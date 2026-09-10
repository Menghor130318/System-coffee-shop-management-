<?php

namespace Database\Seeders;

use App\Models\ProductSize;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    public function run(): void
    {
        // Get all products
        $products = Product::all();

        // Sizes: S=1, M=2, L=3, XL=4
        $sizePrices = [
            1 => 0,      // S base price
            2 => 2000,   // M +2000
            3 => 4000,   // L +4000
            4 => 6000,   // XL +6000
        ];

        foreach ($products as $product) {
            foreach ($sizePrices as $sizeId => $addPrice) {
                $exists = ProductSize::where('product_id', $product->id)
                    ->where('size_id', $sizeId)
                    ->first();
                if (!$exists) {
                    ProductSize::insert([
                        'product_id' => $product->id,
                        'size_id' => $sizeId,
                        'price' => $product->price + $addPrice,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
