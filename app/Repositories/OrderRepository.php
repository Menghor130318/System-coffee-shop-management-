<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Topping;

class OrderRepository implements OrderRepositoryInterface
{
    public function checkout(array $data)
    {
        return DB::transaction(function () use ($data) {

            if (empty($data['items'])) {

                abort(400, 'Cart is empty.');
            }

            $subtotal = collect($data['items'])

                ->sum('total');

            $shipping = 0;

            $discount = 0;

            $total = $subtotal + $shipping - $discount;

            $user = auth()->user();

            $order = Order::create([
                'order_code' => 'ORD' . now()->format('YmdHis') . rand(100, 999),

                'user_id' => $user->id,

                'customer_name' => $user->full_name,

                'customer_phone' => $data['customer_phone'],

                'customer_email' => $user->email,

                'shipping_address' => $data['shipping_address'],

                'note' => $data['note'] ?? null,

                'subtotal' => $subtotal,

                'shipping_fee' => $shipping,

                'discount' => $discount,

                'total' => $total,

                'payment_method' => 'vnpay',

                'payment_status' => 'pending',

                'status' => 'waiting_payment',
            ]);
            foreach ($data['items'] as $item) {

                OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $item['product']['id'],

                    'size_id' => $item['size']['id'] ?? null,

                    'sweetness_level_id' => $item['sweetness']['id'] ?? null,

                    'ice_level_id' => $item['ice']['id'] ?? null,

                    'topping_ids' => collect($item['toppings'])
                        ->pluck('id')
                        ->toArray(),

                    'quantity' => $item['quantity'],

                    'unit_price' => $item['unitPrice'],

                    'total_price' => $item['total']

                ]);
            }

            return $order->load('items');
        });
    }

    public function history()
    {
        return Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function detail($id)
    {
        $order = Order::with([
            'items.product',
            'items.size',
            'items.sweetnessLevel',
            'items.iceLevel'
        ])->findOrFail($id);

        foreach ($order->items as $item) {

            $item->toppings = Topping::whereIn(
                'id',
                $item->topping_ids ?? []
            )->get();
        }

        return $order;
    }
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if (!in_array($order->status, [
            'waiting_payment',
            'pending_confirmation'
        ])) {
            abort(400, 'Đơn hàng không thể hủy.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return $order;
    }
    public function received($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'ready') {
            abort(400, 'Đơn đang được chuẩn bị.');
        }

        $order->update([
            'status' => 'completed'
        ]);

        return $order;
    }
    public function adminList()
    {
        return Order::with('user')
            ->whereIn('status', [
                'pending_confirmation',
                'ready',
                'completed',
                'cancelled'
            ])
            ->latest()
            ->paginate(10);
    }
    public function updateStatus($id, array $data)
    {
        $order = Order::findOrFail($id);

        $currentStatus = $order->status;

        $newStatus = $data['status'];

        $allowedTransitions = [

            'waiting_payment' => [
                'cancelled'
            ],

            'pending_confirmation' => [
                'ready',
                'cancelled'
            ],

            'ready' => [
                'completed'
            ],

            'completed' => [],

            'cancelled' => [],
        ];

        if (
            !isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])
        ) {
            abort(400, 'Không thể chuyển trạng thái này.');
        }

        $order->status = $newStatus;

        $order->save();

        return $order;
    }
    public function show($id)
    {
        $order = Order::with([
            'items.product',
            'items.size',
            'items.sweetnessLevel',
            'items.iceLevel'
        ])->findOrFail($id);

        foreach ($order->items as $item) {

            $item->toppings = Topping::whereIn(
                'id',
                $item->topping_ids ?? []
            )->get();
        }

        return $order;
    }
    public function pendingConfirmationOrders()
    {
        return Order::with([
            'user',
            'items.product'
        ])
            ->where('status', 'pending_confirmation')
            ->latest()
            ->get();
    }
}
