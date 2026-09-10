<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Review;

use App\Interfaces\ReviewRepositoryInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function store(array $data)
    {
        $order = Order::where('status', 'completed')
            ->whereHas('items', function ($query) use ($data) {
                $query->where('product_id', $data['product_id']);
            })
            ->latest()
            ->first();

        if (!$order) {
            abort(403, 'Bạn chưa mua hoặc đơn hàng chưa hoàn thành.');
        }

        $exists = Review::where('order_id', $order->id)
            ->where('product_id', $data['product_id'])
            ->exists();

        if ($exists) {
            abort(400, 'Bạn đã đánh giá sản phẩm này.');
        }

        return Review::create([
            'user_id' => auth()->id(),
            'product_id' => $data['product_id'],
            'order_id' => $order->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);
    }

    public function list($productId)
    {
        return Review::with('user')
            ->where('product_id', $productId)
            ->latest()
            ->get();
    }
}
