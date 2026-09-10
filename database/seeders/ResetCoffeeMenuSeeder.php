<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ResetCoffeeMenuSeeder extends Seeder
{
    /**
     * Delete the OLD seed menu (categories 1-21 and their products)
     * and clear the previously imported products (categories >= 22) so they
     * can be re-imported with corrected rounding+prices and multilingual names.
     *
     * This is a destructive reset. It does NOT delete categories 22-29,
     * only their products (so re-import re-creates with right data).
     */
    public function run(): void
    {
        // 1) Delete old menu products (categories 1-21).
        $oldProducts = Product::whereHas('category', function ($q) {
            $q->where('id', '<=', 21);
        });
        $oldCount = $oldProducts->count();
        $oldProducts->delete();

        // 2) Delete old menu categories (1-21).
        $oldCats = Category::where('id', '<=', 21);
        $oldCatCount = $oldCats->count();
        $oldCats->delete();

        // 3) Delete previously imported products (categories >= 22) so re-import runs clean.
        $newProducts = Product::whereHas('category', function ($q) {
            $q->where('id', '>=', 22);
        });
        $newCount = $newProducts->count();
        $newProducts->delete();

        $this->command->info("Deleted {$oldCount} old products, {$oldCatCount} old categories, {$newCount} previously imported products.");
        $this->command->info('Categories 22+ (new menu) remain for re-import.');
    }
}
