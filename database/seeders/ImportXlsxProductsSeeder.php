<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportXlsxProductsSeeder extends Seeder
{
    /**
     * Exchange rate fallback: 1 USD = 4050 Riel.
     * Prices are rounded to a "clean" Riel value typical for a Cambodian coffee shop.
     */
    private const USD_TO_RIEL = 4050;

    /**
     * Product Group (column M) -> English translation for the category.
     * Key is the exact Khmer group text found in the xlsx.
     */
    private const CATEGORY_TRANSLATIONS = [
        '1.ភេសជ្ជះនិងកាហ្វេ (ក្ដៅ)' => ['en' => 'Hot Drinks & Coffee', 'zh' => '热饮与咖啡'],
        '2.ភេសជ្ជះនិងកាហ្វេ(ទឹកកក)' => ['en' => 'Iced Drinks & Coffee', 'zh' => '冰饮与咖啡'],
        '3.ភេសជ្ជះនិងកាហ្វេ(ក្រឡុក)' => ['en' => 'Blended Drinks & Coffee', 'zh' => '冰沙饮品与咖啡'],
        '4.ទឹកផ្លែឈើស្រស់' => ['en' => 'Fresh Fruit Juice', 'zh' => '鲜榨果汁'],
        '5.តែធីសេក និង សូដា' => ['en' => 'Tea, Thai Tea & Soda', 'zh' => '茶、泰式奶茶与苏打'],
        '6.អាហារសមុទ្រ' => ['en' => 'Seafood', 'zh' => '海鲜'],
        '7.ប្រភេទបាយ' => ['en' => 'Rice Dishes', 'zh' => '米饭类'],
        '8.មីឆា លតឆា និង ទាខ្វៃ' => ['en' => 'Noodles & Duck', 'zh' => '粿条与鸭料理'],
        '9.បបរគ្រឿង' => ['en' => 'Porridge', 'zh' => '粥类'],
    ];

    /**
     * English name -> Chinese name dictionary.
     * Used to fill name_zh for products whose English name is known.
     */
    private const ZH_TRANSLATIONS = [
        // Hot Drinks & Coffee
        'Hot Americano' => '热美式咖啡',
        'Hot Cappuccino' => '热卡布奇诺',
        'Hot Latte' => '热拿铁',
        'Hot Espresso' => '热浓缩咖啡',
        'Hot Black Coffee' => '热黑咖啡',
        'Hot Mocha' => '热摩卡',
        'Hot White Coffee' => '热白咖啡',
        'Hot Chocolate' => '热巧克力',
        'Hot Vanilla Latte' => '热香草拿铁',
        'Hot Caramel Latte' => '热焦糖拿铁',
        'Hot Macchiato' => '热玛奇朵',
        'Hot Tea' => '热茶',
        'Hot Green Tea' => '热绿茶',
        'Hot Milk Tea' => '热奶茶',
        'Hot Ginger Tea' => '热姜茶',
        'Hot Lemon Tea' => '热柠檬茶',
        // Iced Drinks & Coffee
        'Iced Americano' => '冰美式咖啡',
        'Iced Cappuccino' => '冰卡布奇诺',
        'Iced Latte' => '冰拿铁',
        'Iced Coffee Milk' => '冰咖啡奶',
        'Iced Mocha' => '冰摩卡',
        'Iced Espresso' => '冰浓缩咖啡',
        'Iced Black Coffee' => '冰黑咖啡',
        'Iced White Coffee' => '冰白咖啡',
        'Iced Chocolate' => '冰巧克力',
        'Iced Vanilla Latte' => '冰香草拿铁',
        'Iced Caramel Latte' => '冰焦糖拿铁',
        'Iced Matcha Latte' => '冰抹茶拿铁',
        'Iced Green Tea' => '冰绿茶',
        'Iced Milk Tea' => '冰奶茶',
        // Blended Drinks & Coffee
        'Coffee Frappe' => '咖啡冰沙',
        'Iced Blended Chocolate' => '冰沙巧克力',
        'Blended Mocha' => '摩卡冰沙',
        'Blended Caramel' => '焦糖冰沙',
        'Matcha Frappe' => '抹茶冰沙',
        'Strawberry Frappe' => '草莓冰沙',
        'Mango Frappe' => '芒果冰沙',
        'Blueberry Frappe' => '蓝莓冰沙',
        // Fresh Fruit Juice
        'Fresh Orange Juice' => '鲜榨橙汁',
        'Lime Juice' => '青柠汁',
        'Lemon Juice' => '柠檬汁',
        'Watermelon Juice' => '西瓜汁',
        'Pineapple Juice' => '菠萝汁',
        'Mango Juice' => '芒果汁',
        'Fruit Shake' => '水果冰沙',
        'Mixed Fruit Juice' => '混合果汁',
        // Tea, Thai Tea & Soda
        'Thai Milk Tea' => '泰式奶茶',
        'Green Tea' => '绿茶',
        'Soda Lime' => '青柠苏打',
        'Soda Lemon' => '柠檬苏打',
        'Soda Passion' => '百香果苏打',
        'Soda Watermelon' => '西瓜苏打',
        'Ice Lemon Tea' => '冰柠檬茶',
        'Honey Lemon Tea' => '蜂蜜柠檬茶',
        'Osmanthus Tea' => '桂花茶',
        'Chrysanthemum Tea' => '菊花茶',
        // Rice Dishes
        'Fried Rice' => '炒饭',
        'Chicken Rice' => '鸡肉饭',
        'Pork Rice' => '猪肉饭',
        'Beef Rice' => '牛肉饭',
        'Seafood Fried Rice' => '海鲜炒饭',
        'Vegetable Fried Rice' => '蔬菜炒饭',
        'Tomato Fried Rice' => '番茄炒饭',
        'Basil Fried Rice' => '罗勒炒饭',
        'Egg Fried Rice' => '蛋炒饭',
        'Steamed Rice' => '白米饭',
        'Crab Fried Rice' => '蟹肉炒饭',
        'Pineapple Fried Rice' => '菠萝炒饭',
        'Curry Fried Rice' => '咖喱炒饭',
        'Minced Pork Rice' => '肉末饭',
        'Bacon Fried Rice' => '培根炒饭',
        // Noodles & Duck
        'Kuyteav Soup' => '粿条汤',
        'Beef Noodle Soup' => '牛肉粿条',
        'Mee Cha' => '炒粿条',
        'Duck Noodle Soup' => '鸭肉粿条',
        'Seafood Noodle Soup' => '海鲜粿条',
        'Grilled Duck' => '烤鸭',
        'Duck Rice' => '鸭肉饭',
        'Roasted Duck' => '烧鸭',
        'Wonton Noodle' => '云吞面',
        // Porridge
        'Pork Porridge' => '猪肉粥',
        'Chicken Porridge' => '鸡肉粥',
        'Beef Porridge' => '牛肉粥',
        'Seafood Porridge' => '海鲜粥',
        'Century Egg Porridge' => '皮蛋粥',
        'Fish Porridge' => '鱼片粥',
        // Others (fallback)
        'Soft Drink' => '软饮',
        'Fresh Milk' => '鲜奶',
        'Bottled Water' => '瓶装水',
        'Coffee' => '咖啡',
        'Tea' => '茶',
        'Juice' => '果汁',
    ];

    /** Column letters for the fields we need. */
    private const COL_CODE    = 'B';
    private const COL_NAME_KH = 'D';
    private const COL_NAME_EN = 'E';
    private const COL_PRICE   = 'H';
    private const COL_GROUP   = 'M';
    private const COL_DESC    = 'Q';

    public function run(): void
    {
        $dir = base_path('xlsx');
        $files = glob($dir . '/*.xlsx');

        if (empty($files)) {
            $this->command->warn('No xlsx files found in ' . $dir);
            return;
        }

        $this->command->info('Found ' . count($files) . ' xlsx file(s).');

        // Cache categories by their Khmer group name.
        $categoryCache = [];
        $imported = 0;
        $skipped = 0;
        $createdCategories = [];

        foreach ($files as $file) {
            $this->command->line('Processing: ' . basename($file));

            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            // Data rows start at row 7 (rows 1-6 are title/header/totals).
            for ($row = 7; $row <= $highestRow; $row++) {
                $group    = trim((string) $sheet->getCell(self::COL_GROUP . $row)->getValue());
                $nameKh   = trim((string) $sheet->getCell(self::COL_NAME_KH . $row)->getValue());
                $nameEn   = trim((string) $sheet->getCell(self::COL_NAME_EN . $row)->getValue());
                $rawPrice = $sheet->getCell(self::COL_PRICE . $row)->getValue();
                $desc     = trim((string) $sheet->getCell(self::COL_DESC . $row)->getValue());

                // Skip empty rows.
                if (empty($group) && empty($nameKh) && empty($nameEn)) {
                    continue;
                }

                // Derive a product name (prefer Khmer, fall back to English).
                $name = $nameKh !== '' ? $nameKh : $nameEn;
                if ($name === '') {
                    continue;
                }

                // Preferred slug source (English name gives readable slugs).
                $slugSource = $nameEn !== '' ? $nameEn : $nameKh;

                // Parse price (skip formula/empty rows).
                if (is_string($rawPrice) && stripos($rawPrice, 'SUM') !== false) {
                    continue;
                }
                $priceUsd = is_numeric($rawPrice) ? (float) $rawPrice : 0;
                if ($priceUsd <= 0) {
                    continue;
                }
                // Rounded Riel price (clean Cambodian coffee-shop number).
                $priceRiel = $this->roundRielPrice($priceUsd * self::USD_TO_RIEL);

                // Resolve / create the category (with multilingual names).
                $category = $this->resolveCategory($group, $categoryCache, $createdCategories);

                // Deduplicate by (category_id + name).
                $exists = Product::where('category_id', $category->id)
                    ->where('name', $name)
                    ->exists();
                if ($exists) {
                    $skipped++;
                    continue;
                }

                // Chinese name: use dictionary from English name first, fallback to Khmer lookup.
                $nameZh = $this->toChinese($nameEn !== '' ? $nameEn : $name);

                Product::create([
                    'category_id'    => $category->id,
                    'name'           => $name,
                    'name_en'        => $nameEn !== '' ? $nameEn : null,
                    'name_zh'        => $nameZh,
                    'slug'           => $this->uniqueSlug($slugSource),
                    'description'    => $desc !== '' ? $desc : ($nameEn !== '' ? $nameEn : null),
                    'price'          => $priceRiel,
                    'sale_price'     => null,
                    'image'          => null,
                    'status'         => true,
                    'use_all_toppings' => true,
                ]);

                $imported++;
            }
        }

        $this->command->info("Done. Created {$imported} product(s), skipped {$skipped} duplicate(s).");
        $this->command->info('Categories ensured: ' . implode(', ', array_keys($createdCategories)));
    }

    /**
     * Find or create a category for the given Khmer Product Group with multilingual names.
     */
    private function resolveCategory(string $group, array &$cache, array &$created): Category
    {
        $group = trim($group);
        if (isset($cache[$group])) {
            return $cache[$group];
        }

        // Look up existing category by name (Khmer).
        $category = Category::where('name', $group)->first();

        if (!$category) {
            $i18n = self::CATEGORY_TRANSLATIONS[$group] ?? null;
            $english = $i18n['en'] ?? null;
            $chinese = $i18n['zh'] ?? null;

            // Keep Khmer group text as the primary category `name` and store
            // translations in `name_en` and `name_zh`.
            $category = Category::create([
                'name'        => $group,
                'name_en'     => $english,
                'name_zh'     => $chinese,
                'slug'        => $this->uniqueCategorySlug($group, $english),
                'description' => $english ?? 'Category imported from xlsx product list',
                'image'       => null,
                'status'      => true,
            ]);

            $created[$group] = ($english ?? $group);
        }

        $cache[$group] = $category;
        return $category;
    }

    /**
     * Round a raw Riel price to a "clean" shop number:
     * drop trailing zeros below 500 and round to the nearest 500.
     */
    private function roundRielPrice(float $riel): int
    {
        $riel = (int) round($riel);

        if ($riel <= 0) {
            return 0;
        }

        // Round to nearest 500 Riel (common in Cambodian shops).
        $rounded = (int) (round($riel / 500) * 500);

        // Avoid 0.
        return $rounded > 0 ? $rounded : 500;
    }

    /**
     * Get the Chinese name from the English (or Khmer) name.
     */
    private function toChinese(string $name): ?string
    {
        $name = trim($name);

        // Direct dictionary match.
        if (isset(self::ZH_TRANSLATIONS[$name])) {
            return self::ZH_TRANSLATIONS[$name];
        }

        // Try to find a partial match on the biggest word.
        foreach (self::ZH_TRANSLATIONS as $en => $zh) {
            if (stripos($name, $en) !== false) {
                return $zh;
            }
        }

        // Fallback: if the name looks English, transliterate the first word.
        $first = strtolower(strtok($name, ' '));
        $firstTranslations = [
            'hot' => '热', 'iced' => '冰', 'cold' => '冰',
            'fresh' => '鲜', 'coffee' => '咖啡', 'tea' => '茶',
            'milk' => '奶', 'soda' => '苏打', 'juice' => '果汁',
            'juices' => '果汁', 'water' => '水', 'rice' => '饭',
            'fried' => '炒', 'noodle' => '面', 'chicken' => '鸡',
            'beef' => '牛', 'pork' => '猪', 'duck' => '鸭',
            'shrimp' => '虾', 'fish' => '鱼', 'egg' => '蛋',
            'mango' => '芒果', 'orange' => '橙', 'lemon' => '柠檬',
            'lime' => '青柠', 'watermelon' => '西瓜', 'pineapple' => '菠萝',
            'strawberry' => '草莓', 'grape' => '葡萄', 'banana' => '香蕉',
            'espresso' => '浓缩咖啡', 'cappuccino' => '卡布奇诺', 'latte' => '拿铁',
            'mocha' => '摩卡', 'americano' => '美式', 'macchiato' => '玛奇朵',
            'frappe' => '冰沙', 'chocolate' => '巧克力', 'matcha' => '抹茶',
            'vanilla' => '香草', 'caramel' => '焦糖', 'ginger' => '姜',
            'honey' => '蜂蜜', 'thai' => '泰式', 'pearl' => '珍珠',
            'boba' => '波霸', 'soft' => '软', 'drink' => '饮',
        ];

        if (isset($firstTranslations[$first])) {
            return $firstTranslations[$first] . $name;
        }

        return null;
    }

    /**
     * Build a unique slug for a category.
     */
    private function uniqueCategorySlug(string $khmer, ?string $english): string
    {
        $base = $english ? Str::slug($english) : 'category-' . Str::slug($khmer);
        if (empty($base)) {
            $base = 'category-' . Str::random(5);
        }
        $base = $base ?: 'category';

        $slug = $base;
        $i = 2;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }

    /**
     * Build a unique slug for a product.
     */
    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        if (empty($base)) {
            $base = 'product-' . Str::random(6);
        }

        $slug = $base;
        $i = 2;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }
}

