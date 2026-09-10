<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MigrateCategoryProducts extends Command
{
    protected $signature = 'categories:migrate-products {--dry-run : Show changes without applying them}';

    protected $description = 'Move products from legacy categories to the new categories without touching orders or order history';

    public function handle(): int
    {
        $categoryDefinitions = [
            ['name' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'sort_order' => 1],
            ['name' => 'ភេសជ្ជៈ និងកាហ្វេ (ទឹកកក)', 'sort_order' => 2],
            ['name' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្រឡុក)', 'sort_order' => 3],
            ['name' => 'ទឹកផ្លែឈើស្រស់', 'sort_order' => 4],
            ['name' => 'តែ និងសូដា', 'sort_order' => 5],
            ['name' => 'គុយទាវ (ទឹកស៊ុប)', 'sort_order' => 6],
            ['name' => 'ប្រភេទបាយ', 'sort_order' => 7],
            ['name' => 'មីឆា, លតឆា និងទាខ្វៃ', 'sort_order' => 8],
            ['name' => 'បបរគ្រប់មុខ', 'sort_order' => 9],
            ['name' => 'ឈុតក្ងានដើមចេកភូមិស្នេហ៍', 'sort_order' => 10],
            ['name' => 'ស៊ុបសាច់អាំង', 'sort_order' => 11],
            ['name' => 'ម្ហូបកម្ម៉ង់', 'sort_order' => 12],
            ['name' => 'សាច់ និងប្រហិត', 'sort_order' => 13],
            ['name' => 'បន្លែ', 'sort_order' => 14],
            ['name' => 'ភេសជ្ជៈ និងស្រាបៀរ', 'sort_order' => 15],
        ];

        $mappings = [
            'Cafe' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)',
            'Trà' => 'តែ និងសូដា',
            'Trà Sữa' => 'ភេសជ្ជៈ និងកាហ្វេ (ទឹកកក)',
            'Sữa' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្រឡុក)',
            'Nước Dừa' => 'ទឹកផ្លែឈើស្រស់',
            'Ăn Vặt' => 'បបរគ្រប់មុខ',
        ];

        foreach ($categoryDefinitions as $definition) {
            Category::firstOrCreateByName($definition['name'], [
                'slug' => Str::slug($definition['name']),
                'status' => true,
                'sort_order' => $definition['sort_order'],
            ])->forceFill([
                'slug' => Str::slug($definition['name']),
                'status' => true,
                'sort_order' => $definition['sort_order'],
            ])->save();
        }

        $dryRun = $this->option('dry-run');
        $updatedProducts = 0;
        $skippedProducts = 0;

        foreach ($mappings as $legacyName => $newName) {
            $legacyCategory = $this->findCategory($legacyName);
            $newCategory = $this->findCategory($newName);

            if (!$legacyCategory || !$newCategory) {
                continue;
            }

            $products = Product::where('category_id', $legacyCategory->id)->get();
            foreach ($products as $product) {
                if ($product->category_id === $newCategory->id) {
                    $skippedProducts++;
                    continue;
                }

                if ($dryRun) {
                    $this->line("Would move {$product->name} ({$product->id}) from {$legacyCategory->name} to {$newCategory->name}");
                    continue;
                }

                $product->category_id = $newCategory->id;
                $product->save();
                $updatedProducts++;
            }
        }

        if ($dryRun) {
            $this->info('Dry run completed. No data was changed.');
            return self::SUCCESS;
        }

        $this->info("Moved {$updatedProducts} products to the new categories without touching orders or sales history.");
        if ($skippedProducts > 0) {
            $this->info("Skipped {$skippedProducts} products that were already assigned to the target category.");
        }

        return self::SUCCESS;
    }

    protected function findCategory(string $name): ?Category
    {
        return Category::where(function ($query) use ($name): void {
            $query->where('name', $name)
                ->orWhere('name_en', $name)
                ->orWhere('name_zh', $name);
        })->first();
    }
}
