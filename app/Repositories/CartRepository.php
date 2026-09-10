<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\PriceCalculatorService;

class CartRepository implements CartRepositoryInterface
{
    protected PriceCalculatorService $calculator;
    public function __construct(
        PriceCalculatorService $calculator
    ) {
        $this->calculator = $calculator;
    }
    public function add(array $data)
    {
        $cart = Cart::firstOrCreate([
            'session_id' => session()->getId()
        ]);

        $product = Product::with([
            'sizes',
            'toppings'
        ])->findOrFail($data['product_id']);

        $price = $this->calculator->calculate(
            $product,
            $data
        );

        return CartItem::create([

            'cart_id' => $cart->id,

            'product_id' => $product->id,

            'size_id' => $data['size_id'] ?? null,

            'sweetness_level_id' =>
            $data['sweetness_level_id'] ?? null,

            'ice_level_id' =>
            $data['ice_level_id'] ?? null,

            'topping_ids' =>
            $data['topping_ids'] ?? [],

            'quantity' =>
            $data['quantity'],

            'unit_price' => $price['unit_price'],

            'total_price' => $price['total_price'],

        ]);
    }
    public function items($cartId)
    {
        return Cart::with([

            'items.product',

            'items.size',

            'items.sweetnessLevel',

            'items.iceLevel'

        ])->findOrFail($cartId);
    }
    public function clear($cartId)
    {
        CartItem::where('cart_id', $cartId)->delete();

        return true;
    }
    public function update($itemId, array $data)
    {
        $item = CartItem::findOrFail($itemId);

        $product = Product::with([
            'sizes',
            'toppings'
        ])->findOrFail($item->product_id);

        $price = $this->calculator->calculate(
            $product,
            $data
        );

        $item->update([
            'size_id' => $data['size_id'],
            'sweetness_level_id' => $data['sweetness_level_id'],
            'ice_level_id' => $data['ice_level_id'],
            'topping_ids' => $data['topping_ids'],
            'quantity' => $data['quantity'],

            'unit_price' => $price['unit_price'],

            'total_price' => $price['total_price'],
        ]);

        return $item;
    }

    public function remove($itemId)
    {
        $item = CartItem::findOrFail($itemId);

        $item->delete();

        return [
            'message' => 'Item removed successfully.'
        ];
    }
    public function list()
    {
        return Cart::firstOrCreate(
            [
                'session_id' => session()->getId()
            ]
        )->load([
            'items.product',
            'items.size',
            'items.sweetnessLevel',
            'items.iceLevel'
        ]);
    }
}
