<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Map product categories to the current Khmer category names used by the app
        $categories = [
            'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)' => null,
            'តែ និងសូដា' => null,
            'ភេសជ្ជៈ និងកាហ្វេ (ទឹកកក)' => null,
            'ទឹកផ្លែឈើស្រស់' => null,
            'បបរគ្រប់មុខ' => null,
        ];

        foreach ($categories as $name => $val) {
            $cat = \App\Models\Category::where('name', $name)->first();
            $categories[$name] = $cat ? $cat->id : null;
        }

        $products = [
            ['name' => 'កាហ្វេខ្មៅ', 'slug' => 'black-coffee', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'price' => 12000, 'sale_price' => null, 'desc' => 'កាហ្វេខ្មៅកម្ពុជា ធ្វើពីសណ្តែកកាហ្វេរតនៈគិរី'],
            ['name' => 'កាហ្វេទឹកដោះគោ', 'slug' => 'coffee-milk', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'price' => 15000, 'sale_price' => 13000, 'desc' => 'កាហ្វេទឹកដោះគោឈ្ងុយឆ្ងាញ់'],
            ['name' => 'កាហ្វេម៉ុកកា', 'slug' => 'mocha', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'price' => 18000, 'sale_price' => null, 'desc' => 'កាហ្វេម៉ុកកាជាមួយសូកូឡា'],
            ['name' => 'កាហ្វេឡាតេ', 'slug' => 'latte', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'price' => 17000, 'sale_price' => null, 'desc' => 'ឡាតេក្រែមទន់'],
            ['name' => 'កាហ្វេអេស្ព្រេសសូ', 'slug' => 'espresso', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'price' => 14000, 'sale_price' => null, 'desc' => 'អេស្ព្រេសសូប្រមូលផ្តុំ'],
            ['name' => 'កាហ្វេកាពូឈីណូ', 'slug' => 'cappuccino', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'price' => 19000, 'sale_price' => 17000, 'desc' => 'កាពូឈីណូជាមួយពពុះទឹកដោះគោ'],

            ['name' => 'តែបៃតង', 'slug' => 'green-tea', 'category' => 'តែ និងសូដា', 'price' => 10000, 'sale_price' => null, 'desc' => 'តែបៃតងត្រជាក់'],
            ['name' => 'តែក្តៅ', 'slug' => 'hot-tea', 'category' => 'តែ និងសូដា', 'price' => 8000, 'sale_price' => null, 'desc' => 'តែប្រពៃណីកម្ពុជា'],
            ['name' => 'តែផ្ការ', 'slug' => 'flower-tea', 'category' => 'តែ និងសូដា', 'price' => 12000, 'sale_price' => null, 'desc' => 'តែផ្កាក្រអូប'],

            ['name' => 'តែទឹកដោះគោគុជ', 'slug' => 'milk-tea-boba', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ទឹកកក)', 'price' => 20000, 'sale_price' => 18000, 'desc' => 'តែទឹកដោះគោជាមួយគុជខ្យង'],
            ['name' => 'តែទឹកដោះគោតៃ', 'slug' => 'thai-milk-tea', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ទឹកកក)', 'price' => 19000, 'sale_price' => null, 'desc' => 'តែទឹកដោះគោបែបតៃវ៉ាន់'],
            ['name' => 'តែទឹកដោះគោមជីខ្មៅ', 'slug' => 'black-milk-tea', 'category' => 'ភេសជ្ជៈ និងកាហ្វេ (ទឹកកក)', 'price' => 21000, 'sale_price' => null, 'desc' => 'តែមជីខ្មៅជាមួយទឹកដោះគោ'],

            ['name' => 'ទឹកក្រូចច្របាច់', 'slug' => 'orange-juice', 'category' => 'ទឹកផ្លែឈើស្រស់', 'price' => 15000, 'sale_price' => 13000, 'desc' => 'ទឹកក្រូចស្រស់ច្របាច់'],
            ['name' => 'ទឹកក្រូចឆ្មា', 'slug' => 'lime-juice', 'category' => 'ទឹកផ្លែឈើស្រស់', 'price' => 14000, 'sale_price' => null, 'desc' => 'ទឹកក្រូចឆ្មាត្រជាក់'],
            ['name' => 'ស្រាក្រឡុកផ្លែឈើ', 'slug' => 'fruit-shake', 'category' => 'ទឹកផ្លែឈើស្រស់', 'price' => 18000, 'sale_price' => null, 'desc' => 'ស្រាក្រឡុកផ្លែឈើចម្រុះ'],

            ['name' => 'ប្រហិតសាច់', 'slug' => 'meatball', 'category' => 'បបរគ្រប់មុខ', 'price' => 16000, 'sale_price' => null, 'desc' => 'ប្រហិតសាច់អាំង'],
            ['name' => 'នំខេកសូកូឡា', 'slug' => 'chocolate-cake', 'category' => 'បបរគ្រប់មុខ', 'price' => 12000, 'sale_price' => null, 'desc' => 'នំខេកសូកូឡាទន់'],
            ['name' => 'សាំងវិច', 'slug' => 'sandwich', 'category' => 'បបរគ្រប់មុខ', 'price' => 14000, 'sale_price' => null, 'desc' => 'សាំងវិចជាមួយសាច់និងបន្លែ'],
        ];

// Existing product images available in public/img/products
        $imagePool = [
            'product-1.jpg',
            'product-2.jpg',
            'product-3.jpg',
            'product-4.jpg',
            'product-5.jpg',
        ];

        $index = 0;
        foreach ($products as $p) {
            $categoryId = $categories[$p['category']];
            if (!$categoryId) {
                continue;
            }
            $exists = Product::where('slug', $p['slug'])->first();
            if (!$exists) {
                Product::insert([
                    'category_id' => $categoryId,
                    'name' => $p['name'],
                    'slug' => $p['slug'],
                    'description' => $p['desc'],
                    'price' => $p['price'],
                    'sale_price' => $p['sale_price'],
                    // Cycle through available images so every product shows an image
                    'image' => $imagePool[$index % count($imagePool)],
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $index++;
            }
        }
    }
}
