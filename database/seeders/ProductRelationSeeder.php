<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductRelationSeeder extends Seeder
{
    public function run(): void
    {
        // Get all coffee-type products (categories 1 = កាហ្វេ, 2 = តែ, 3 = តែទឹកដោះគោ)
        $products = Product::whereIn('category_id', [1, 2, 3])->get();

        // Attach toppings to drink products
        $toppingIds = DB::table('toppings')->pluck('id')->all();
        foreach ($products as $product) {
            foreach ($toppingIds as $toppingId) {
                $exists = DB::table('product_toppings')
                    ->where('product_id', $product->id)
                    ->where('topping_id', $toppingId)
                    ->first();
                if (!$exists) {
                    DB::table('product_toppings')->insert([
                        'product_id' => $product->id,
                        'topping_id' => $toppingId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Attach sweetness levels to drink products
        $sweetnessIds = DB::table('sweetness_levels')->pluck('id')->all();
        foreach ($products as $product) {
            foreach ($sweetnessIds as $sweetnessId) {
                $exists = DB::table('product_sweetness_levels')
                    ->where('product_id', $product->id)
                    ->where('sweetness_level_id', $sweetnessId)
                    ->first();
                if (!$exists) {
                    DB::table('product_sweetness_levels')->insert([
                        'product_id' => $product->id,
                        'sweetness_level_id' => $sweetnessId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Attach ice levels to drink products
        $iceIds = DB::table('ice_levels')->pluck('id')->all();
        foreach ($products as $product) {
            foreach ($iceIds as $iceId) {
                $exists = DB::table('product_ice_levels')
                    ->where('product_id', $product->id)
                    ->where('ice_level_id', $iceId)
                    ->first();
                if (!$exists) {
                    DB::table('product_ice_levels')->insert([
                        'product_id' => $product->id,
                        'ice_level_id' => $iceId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
    
    }