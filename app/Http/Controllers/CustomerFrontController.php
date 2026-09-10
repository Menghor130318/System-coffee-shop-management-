<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerFrontController extends Controller
{
    /**
     * Display the coffee menu for customers.
     */
    public function menu(Request $request)
    {
        $categories = Category::orderBy('id', 'asc')->get();
        
        $products = Product::with('category')
            ->when($request->input('category'), function ($query, $cat) {
                return $query->where('category_id', $cat);
            })
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('product_name_kh', 'like', '%' . $search . '%')
                      ->orWhere('product_name_en', 'like', '%' . $search . '%');
                });
            })
            ->paginate(9);

        return view('pages.customer.menu', compact('categories', 'products'));
    }

    /**
     * Display the Coffee Shop Dashboard for customers.
     */
    public function customerDashboard()
    {
        // សម្រួលលុប where('status', true) និង orderBy('sort_order') ដែលគ្មានក្នុង DB ចោល
        $allCategories = Category::with('products')->orderBy('id', 'asc')->get();

        // Daytime Menu category slugs
        $daytimeSlugs = [
            'hot-drinks-coffee',
            'iced-drinks-coffee',
            'blended-drinks-coffee',
            'fresh-fruit-juice',
            'tea-thai-tea-soda',
            'noodle-soup',
            'rice-dishes',
            'fried-noodles',
            'porridge',
        ];

        // Additional Menu category slugs
        $additionalSlugs = [
            'grilled-duck-set',
            'phnom-sreh-beef-soup',
            'cambodian-dishes',
            'vegetables',
            'meat-meatballs',
            'drinks-beer',
        ];

        $daytimeCategories = $allCategories->filter(function ($cat) use ($daytimeSlugs) {
            return isset($cat->slug) && in_array($cat->slug, $daytimeSlugs);
        })->values();

        $additionalCategories = $allCategories->filter(function ($cat) use ($additionalSlugs) {
            return isset($cat->slug) && in_array($cat->slug, $additionalSlugs);
        })->values();

        // ទាញយកផលិតផលទាំងអស់
        $allProducts = Product::with('category')->get();

        return view('pages.customer.dashboard', compact(
            'daytimeCategories',
            'additionalCategories',
            'allProducts'
        ));
    }

    /**
     * Add a product to the cart (session-based).
     */
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->product_name_kh ?? $product->product_name_en,
                'price' => $product->price_min ?? $product->price ?? 0,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_count', array_sum(array_column($cart, 'quantity')));

        if ($request->ajax()) {
            return response()->json(['status' => 200, 'cart_count' => session('cart_count')]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    /**
     * Show the cart.
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('pages.customer.cart', compact('cart', 'total'));
    }

    /**
     * Update cart item quantity.
     */
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);
        session()->put('cart_count', array_sum(array_column($cart, 'quantity')));

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        session()->put('cart_count', array_sum(array_column($cart, 'quantity')));

        return redirect()->route('cart.index')->with('success', 'Item removed from cart');
    }

    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('pages.customer.checkout', compact('cart', 'total'));
    }

    /**
     * Process the order and payment.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'required|string',
            'payment_method' => 'required|in:cash,card,khqr',
            'note' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        $shipping = 0;
        $total = $subtotal + $shipping;

        DB::beginTransaction();
        try {
            $order = new \App\Models\Order();
            $order->user_id = auth()->id();
            $order->customer_name = $request->customer_name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->note = $request->note;
            $order->subtotal = $subtotal;
            $order->shipping_fee = $shipping;
            $order->discount = 0;
            $order->total = $total;
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'pending';
            $order->status = 'waiting_payment';
            $order->transaction_no = 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(substr(md5(rand()), 0, 6));
            $order->queue_number = $this->generateQueueNumber();
            $order->save();

            // Save order items
            foreach ($cart as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'size_id' => null,
                    'sweetness_level_id' => null,
                    'ice_level_id' => null,
                    'topping_ids' => null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Record payment
            DB::table('payments')->insert([
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'transaction_no' => $order->transaction_no,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Clear cart
            session()->forget('cart');
            session()->forget('cart_count');

            return redirect()->route('my.orders')->with('success', 'Order placed successfully! Please complete your payment.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    /**
     * Show customer's orders.
     */
    public function myOrders()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->with(['items', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.customer.orders', compact('orders'));
    }

    /**
     * Show customer profile.
     */
    public function profile()
    {
        return view('pages.customer.profile', ['user' => auth()->user()]);
    }

    /**
     * Update customer profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'avatar-' . $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/avatars'), $filename);
            $user->avatar = 'img/avatars/' . $filename;
        }

        // Change password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Show public reservation form.
     */
    public function reservation()
    {
        return view('pages.customer.reservation');
    }

    /**
     * Store a public reservation.
     */
    public function storeReservation(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'table_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $reservation = new \App\Models\Reservation();
        $reservation->reservation_code = 'RSV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        $reservation->customer_name = $request->customer_name;
        $reservation->customer_phone = $request->customer_phone;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->reservation_time = $request->reservation_time;
        $reservation->table_number = $request->table_number;
        $reservation->notes = $request->notes;
        $reservation->status = 'pending';
        $reservation->save();

        return redirect()->route('reservation.public')->with('success', 'Your table reservation has been submitted successfully!');
    }

    /**
     * Generate a queue number.
     */
    private function generateQueueNumber()
    {
        $todayCount = \App\Models\Order::whereDate('created_at', today())->count();
        $next = $todayCount + 1;
        return 'A' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Show invoice.
     */
    public function invoice($id)
    {
        $order = \App\Models\Order::with(['items', 'user', 'receiver'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('pages.customer.invoice', compact('order'));
    }
}