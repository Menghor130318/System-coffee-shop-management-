<?php

namespace App\Services;

use App\Models\Product;

class PriceCalculatorService
{
    public function calculate(Product $product, array $data): array
    {
        $basePrice = $product->sale_price ?? $product->price;

        // Size
        $sizePrice = 0;

        if (!empty($data['size_id'])) {

            $size = $product->sizes()
                ->where('sizes.id', $data['size_id'])
                ->first();

            if ($size) {
                $sizePrice = $size->pivot->price;
            }
        }

        // Topping
        $toppingPrice = 0;

        if (!empty($data['topping_ids'])) {

            $toppingPrice = $product->toppings()
                ->whereIn('toppings.id', $data['topping_ids'])
                ->sum('toppings.price');
        }

        $quantity = $data['quantity'] ?? 1;

        $unitPrice = $basePrice + $sizePrice + $toppingPrice;

        return [

            'base_price' => $basePrice,

            'size_price' => $sizePrice,

            'topping_price' => $toppingPrice,

            'unit_price' => $unitPrice,

            'total_price' => $unitPrice * $quantity
        ];
    }
}
