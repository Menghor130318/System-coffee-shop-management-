<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class KhmerMenuSeeder extends Seeder
{
    /**
     * Seed the full Cambodian coffee shop menu in English.
     *
     * Categories are grouped into two main sections:
     *  - Daytime Menu (ម្ហូបកម្ម៉ងអាហារពេលថ្ងៃ)
     *  - Additional Menu (មុខម្ហូបបន្ថែម)
     */
    public function run(): void
    {
        $this->seedCategories();
        $this->seedProducts();
    }

    private function seedCategories(): void
    {
        // Supported image pool (files exist in public/img/products)
        $imagePool = ['product-1.jpg', 'product-2.jpg', 'product-3.jpg', 'product-4.jpg', 'product-5.jpg'];

        $categories = [
            // ===== Daytime Menu (ម្ហូបកម្ម៉ងអាហារពេលថ្ងៃ) =====
['name' => 'Hot Drinks & Coffee', 'slug' => 'hot-drinks-coffee', 'icon' => 'coffee'],
            ['name' => 'Iced Drinks & Coffee', 'slug' => 'iced-drinks-coffee', 'icon' => 'mug-hot'],
            ['name' => 'Blended Drinks & Coffee', 'slug' => 'blended-drinks-coffee', 'icon' => 'glass-martini'],
            ['name' => 'Fresh Fruit Juice', 'slug' => 'fresh-fruit-juice', 'icon' => 'lemon'],
            ['name' => 'Tea, Thai Tea & Soda', 'slug' => 'tea-thai-tea-soda', 'icon' => 'mug-saucer'],
            ['name' => 'Noodle Soup', 'slug' => 'noodle-soup', 'icon' => 'bowl-food'],
            ['name' => 'Rice Dishes', 'slug' => 'rice-dishes', 'icon' => 'bowl-rice'],
            ['name' => 'Fried Noodles', 'slug' => 'fried-noodles', 'icon' => 'utensils'],
            ['name' => 'Porridge', 'slug' => 'porridge', 'icon' => 'soup'],

            // ===== Additional Menu (មុខម្ហូបបន្ថែម) =====
            ['name' => 'Grilled Duck Set', 'slug' => 'grilled-duck-set', 'icon' => 'drumstick-bite'],
            ['name' => 'Phnom Sreh Boneless Beef Soup', 'slug' => 'phnom-sreh-beef-soup', 'icon' => 'bowl-food'],
            ['name' => 'Cambodian Dishes', 'slug' => 'cambodian-dishes', 'icon' => 'utensils'],
            ['name' => 'Vegetables', 'slug' => 'vegetables', 'icon' => 'carrot'],
            ['name' => 'Meat & Meatballs', 'slug' => 'meat-meatballs', 'icon' => 'drumstick-bite'],
            ['name' => 'Drinks & Beer', 'slug' => 'drinks-beer', 'icon' => 'beer'],
        ];

        foreach ($categories as $cat) {
            $existing = Category::where('slug', $cat['slug'])->first();
            if ($existing) {
                continue;
            }
            Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'description' => $cat['name'],
                'image' => $imagePool[array_rand($imagePool)],
                'status' => true,
            ]);
        }
    }

    private function seedProducts(): void
    {
        $imagePool = ['product-1.jpg', 'product-2.jpg', 'product-3.jpg', 'product-4.jpg', 'product-5.jpg'];

        $products = [
            // Hot Drinks & Coffee
            ['name' => 'Black Coffee', 'slug' => 'hot-black-coffee', 'cat' => 'hot-drinks-coffee', 'price' => 12000, 'sale' => null, 'desc' => 'Cambodian black coffee from Ratanakiri beans'],
            ['name' => 'Hot Cappuccino', 'slug' => 'hot-cappuccino', 'cat' => 'hot-drinks-coffee', 'price' => 19000, 'sale' => 17000, 'desc' => 'Hot cappuccino with silky milk foam'],
            ['name' => 'Hot Latte', 'slug' => 'hot-latte', 'cat' => 'hot-drinks-coffee', 'price' => 17000, 'sale' => null, 'desc' => 'Smooth hot latte with creamy milk'],
            ['name' => 'Hot Espresso', 'slug' => 'hot-espresso', 'cat' => 'hot-drinks-coffee', 'price' => 14000, 'sale' => null, 'desc' => 'Rich and bold hot espresso'],

            // Iced Drinks & Coffee
            ['name' => 'Iced Coffee Milk', 'slug' => 'iced-coffee-milk', 'cat' => 'iced-drinks-coffee', 'price' => 15000, 'sale' => 13000, 'desc' => 'Iced coffee with sweet condensed milk'],
            ['name' => 'Iced Mocha', 'slug' => 'iced-mocha', 'cat' => 'iced-drinks-coffee', 'price' => 18000, 'sale' => null, 'desc' => 'Iced mocha with chocolate and espresso'],
            ['name' => 'Iced Latte', 'slug' => 'iced-latte', 'cat' => 'iced-drinks-coffee', 'price' => 17000, 'sale' => null, 'desc' => 'Refreshing iced latte'],

            // Blended Drinks & Coffee
            ['name' => 'Coffee Frappe', 'slug' => 'coffee-frappe', 'cat' => 'blended-drinks-coffee', 'price' => 20000, 'sale' => 18000, 'desc' => 'Blended coffee frappe topped with cream'],
            ['name' => 'Iced Blended Chocolate', 'slug' => 'blended-chocolate', 'cat' => 'blended-drinks-coffee', 'price' => 19000, 'sale' => null, 'desc' => 'Creamy blended chocolate drink'],

            // Fresh Fruit Juice
            ['name' => 'Fresh Orange Juice', 'slug' => 'fresh-orange-juice', 'cat' => 'fresh-fruit-juice', 'price' => 15000, 'sale' => 13000, 'desc' => 'Freshly squeezed orange juice'],
            ['name' => 'Lime Juice', 'slug' => 'lime-juice', 'cat' => 'fresh-fruit-juice', 'price' => 14000, 'sale' => null, 'desc' => 'Cool lime juice with mint'],
            ['name' => 'Fruit Shake', 'slug' => 'fruit-shake', 'cat' => 'fresh-fruit-juice', 'price' => 18000, 'sale' => null, 'desc' => 'Mixed fresh fruit shake'],

            // Tea, Thai Tea & Soda
            ['name' => 'Thai Milk Tea', 'slug' => 'thai-milk-tea', 'cat' => 'tea-thai-tea-soda', 'price' => 19000, 'sale' => null, 'desc' => 'Classic Thai milk tea with boba'],
            ['name' => 'Green Tea', 'slug' => 'green-tea', 'cat' => 'tea-thai-tea-soda', 'price' => 10000, 'sale' => null, 'desc' => 'Refreshing green tea'],
            ['name' => 'Soda Lime', 'slug' => 'soda-lime', 'cat' => 'tea-thai-tea-soda', 'price' => 12000, 'sale' => null, 'desc' => 'Sparkling soda with fresh lime'],

            // Noodle Soup
            ['name' => 'Kuyteav Soup', 'slug' => 'kuyteav-soup', 'cat' => 'noodle-soup', 'price' => 15000, 'sale' => null, 'desc' => 'Traditional Cambodian noodle soup with pork broth'],
            ['name' => 'Beef Noodle Soup', 'slug' => 'beef-noodle-soup', 'cat' => 'noodle-soup', 'price' => 17000, 'sale' => null, 'desc' => 'Beef noodle soup with fresh herbs'],

            // Rice Dishes
            ['name' => 'Fried Rice', 'slug' => 'fried-rice', 'cat' => 'rice-dishes', 'price' => 16000, 'sale' => null, 'desc' => 'Cambodian-style fried rice'],
            ['name' => 'Chicken Rice', 'slug' => 'chicken-rice', 'cat' => 'rice-dishes', 'price' => 18000, 'sale' => null, 'desc' => 'Steamed rice with roasted chicken'],

            // Fried Noodles
            ['name' => 'Mee Cha', 'slug' => 'mee-cha', 'cat' => 'fried-noodles', 'price' => 16000, 'sale' => null, 'desc' => 'Stir-fried mee cha with vegetables'],
            ['name' => 'Pad Thai', 'slug' => 'pad-thai', 'cat' => 'fried-noodles', 'price' => 17000, 'sale' => 15000, 'desc' => 'Stir-fried rice noodles with shrimp'],

            // Porridge
            ['name' => 'Pork Porridge', 'slug' => 'pork-porridge', 'cat' => 'porridge', 'price' => 14000, 'sale' => null, 'desc' => 'Warm pork porridge with ginger'],
            ['name' => 'Chicken Porridge', 'slug' => 'chicken-porridge', 'cat' => 'porridge', 'price' => 15000, 'sale' => null, 'desc' => 'Hearty chicken porridge'],

            // Grilled Duck Set
            ['name' => 'Grilled Duck Set', 'slug' => 'grilled-duck-set', 'cat' => 'grilled-duck-set', 'price' => 65000, 'sale' => 58000, 'desc' => 'Whole grilled duck set with vegetables and rice'],

            // Phnom Sreh Boneless Beef Soup
            ['name' => 'Phnom Sreh Beef Soup', 'slug' => 'phnom-sreh-beef-soup', 'cat' => 'phnom-sreh-beef-soup', 'price' => 45000, 'sale' => null, 'desc' => 'Boneless beef soup from Phnom Sreh'],

            // Cambodian Dishes
            ['name' => 'Amok Curry', 'slug' => 'amok-curry', 'cat' => 'cambodian-dishes', 'price' => 35000, 'sale' => null, 'desc' => 'Traditional Khmer amok curry in banana leaf'],
            ['name' => 'Lok Lak', 'slug' => 'lok-lak', 'cat' => 'cambodian-dishes', 'price' => 30000, 'sale' => 27000, 'desc' => 'Stir-fried beef lok lak with pepper sauce'],

            // Vegetables
            ['name' => 'Stir-fried Morning Glory', 'slug' => 'morning-glory', 'cat' => 'vegetables', 'price' => 12000, 'sale' => null, 'desc' => 'Stir-fried water spinach with garlic'],
            ['name' => 'Mixed Vegetables', 'slug' => 'mixed-vegetables', 'cat' => 'vegetables', 'price' => 14000, 'sale' => null, 'desc' => 'Assorted fresh vegetables stir-fry'],

            // Meat & Meatballs
            ['name' => 'Grilled Pork Skewers', 'slug' => 'grilled-pork-skewers', 'cat' => 'meat-meatballs', 'price' => 18000, 'sale' => null, 'desc' => 'Charcoal-grilled pork skewers'],
            ['name' => 'Beef Meatballs', 'slug' => 'beef-meatballs', 'cat' => 'meat-meatballs', 'price' => 16000, 'sale' => null, 'desc' => 'Juicy beef meatballs in sauce'],

            // Drinks & Beer
            ['name' => 'Angkor Beer', 'slug' => 'angkor-beer', 'cat' => 'drinks-beer', 'price' => 15000, 'sale' => null, 'desc' => 'Cambodian Angkor draft beer'],
            ['name' => 'Cambodia Beer', 'slug' => 'cambodia-beer', 'cat' => 'drinks-beer', 'price' => 15000, 'sale' => null, 'desc' => 'Refreshing Cambodia beer'],
            ['name' => 'Soft Drink', 'slug' => 'soft-drink', 'cat' => 'drinks-beer', 'price' => 8000, 'sale' => null, 'desc' => 'Chilled soft drink'],

            // Additional drinks - duplicate-free
        ];

        foreach ($products as $p) {
            $category = Category::where('slug', $p['cat'])->first();
            if (!$category) {
                continue;
            }
            $exists = Product::where('slug', $p['slug'])->first();
            if ($exists) {
                continue;
            }
            Product::create([
                'category_id' => $category->id,
                'name' => $p['name'],
                'slug' => $p['slug'],
                'description' => $p['desc'],
                'price' => $p['price'],
                'sale_price' => $p['sale'],
                'image' => $imagePool[array_rand($imagePool)],
                'status' => true,
            ]);
        }
    }
}
