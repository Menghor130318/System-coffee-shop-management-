<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['items', 'user', 'receiver'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.order.index', compact('orders'));
    }

    /**
     * Show the details of a specific order.
     */
    public function show($id)
    {
        $order = Order::with(['items', 'user', 'receiver'])->findOrFail($id);
        $staff = User::whereHas('role', function ($q) {
            $q->where('name', 'like', '%admin%');
        })->orWhereHas('role', function ($q) {
            $q->where('name', 'like', '%employee%');
        })->get();

        return view('pages.order.show', compact('order', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone'          => 'required',
            'address'        => 'required',
            'payment_method' => 'required',
        ]);

        // ១. គណនាតម្លៃសរុប ($cartTotal) ចេញពី Session Cart
        $cart = session()->get('cart', []);
        $cartTotal = 0;

        if (!empty($cart)) {
            foreach ($cart as $item) {
                $price = $item['price_min'] ?? ($item['price'] ?? 0);
                $cartTotal += $price * ($item['quantity'] ?? 1);
            }
        } else {
            $cartTotal = (float) $request->input('total', 1.75);
        }

        $paymentMethod = $request->input('payment_method', 'cash');

        // ប្រសិនបើបង់តាម Card ឬ KHQR ឱ្យ Completed និង Paid
        $isPaid = ($paymentMethod === 'card' || $paymentMethod === 'khqr');
        $orderStatus   = $isPaid ? 'completed' : 'pending';
        $paymentStatus = $isPaid ? 'paid' : 'unpaid';

        // ២. បង្កើតទិន្នន័យ Order
        $order = new Order();
        $order->user_id        = auth()->id() ?? null;
        $order->customer_name  = $request->name ?? (auth()->user()->name ?? 'Customer');
        $order->phone          = $request->phone;
        $order->address        = $request->address;
        $order->payment_method = $paymentMethod;
        $order->status         = $orderStatus;
        $order->payment_status = $paymentStatus;
        
        // កំណត់តម្លៃ subtotal និង total
        $order->subtotal = (float) $cartTotal;
        $order->total    = (float) $cartTotal;

        if ($request->filled('note')) {
            $order->note = $request->note;
        }

        if ($isPaid) {
            $order->paid_at      = now();
            $order->completed_at = now();
        }

        $order->save();

        // ៣. បង្កើត Order Items តែ ១ ដងគត់ ស្របតាម Model OrderItem
        if (!empty($cart) && class_exists(OrderItem::class)) {
            foreach ($cart as $productId => $item) {
                $qty       = (int) ($item['quantity'] ?? 1);
                $unitPrice = (float) ($item['price_min'] ?? ($item['price'] ?? 0));
                $itemTotal = $unitPrice * $qty;

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => is_numeric($productId) ? (int)$productId : ($item['id'] ?? 1),
                    'quantity'           => $qty,
                    'unit_price'         => $unitPrice,
                    'total_price'        => $itemTotal,
                    'size_id'            => $item['size_id'] ?? null,
                    'sweetness_level_id' => $item['sweetness_level_id'] ?? null,
                    'ice_level_id'       => $item['ice_level_id'] ?? null,
                    'topping_ids'        => $item['topping_ids'] ?? [],
                ]);
            }

            // សម្អាត Cart ក្រោយ Order ជោគជ័យ
            session()->forget('cart');
        }

        return redirect()->route('order.index')->with('success', 'Order #' . $order->id . ' has been completed successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with('items')->findOrFail($id);
        $staff = User::whereHas('role', function ($q) {
            $q->where('name', 'like', '%admin%');
        })->orWhereHas('role', function ($q) {
            $q->where('name', 'like', '%employee%');
        })->get();

        return view('pages.order.edit', compact('order', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status'           => 'nullable|in:waiting_payment,paid,preparing,completed,cancelled,pending',
            'payment_status'   => 'nullable|in:pending,paid,unpaid',
            'receiver_user_id' => 'nullable|exists:users,id',
        ]);

        $order = Order::findOrFail($id);

        if ($request->has('status')) {
            $order->status = $request->status;
            if ($request->status == 'completed') {
                $order->completed_at   = now();
                $order->payment_status = 'paid';
                $order->paid_at        = now();
            }
        }

        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
            if ($request->payment_status == 'paid' && !$order->paid_at) {
                $order->paid_at = now();
            }
        }

        if ($request->has('receiver_user_id')) {
            $order->receiver_user_id = $request->receiver_user_id;
        }

        $order->save();

        return redirect()->route('order.index')->with('success', 'Order updated successfully');
    }
    public function create()
    {
        // Fetch products or tables needed for the order screen
        $products = Product::all(); 
    
        return view('pages.order.create', compact('products'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('order.index')->with('success', 'Order deleted successfully');
    }
}