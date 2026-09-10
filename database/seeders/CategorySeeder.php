<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $legacyCategoryNames = ['Cafe', 'Trà', 'Trà Sữa', 'Sữa', 'Nước Dừa', 'Ăn Vặt'];

        Category::whereIn('name', $legacyCategoryNames)->delete();

        $categories = [
            ['name' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្ដៅ)', 'slug' => 'phes-cho-nga-kafe-kdau', 'sort_order' => 1],
            ['name' => 'ភេសជ្ជៈ និងកាហ្វេ (ទឹកកក)', 'slug' => 'phes-cho-nga-kafe-teuk-kak', 'sort_order' => 2],
            ['name' => 'ភេសជ្ជៈ និងកាហ្វេ (ក្រឡុក)', 'slug' => 'phes-cho-nga-kafe-krolok', 'sort_order' => 3],
            ['name' => 'ទឹកផ្លែឈើស្រស់', 'slug' => 'teuk-plae-cheu-sros', 'sort_order' => 4],
            ['name' => 'តែ និងសូដា', 'slug' => 'tae-ng-soda', 'sort_order' => 5],
            ['name' => 'គុយទាវ (ទឹកស៊ុប)', 'slug' => 'kuy-teav-teuk-sop', 'sort_order' => 6],
            ['name' => 'ប្រភេទបាយ', 'slug' => 'prohet-bay', 'sort_order' => 7],
            ['name' => 'មីឆា, លតឆា និងទាខ្វៃ', 'slug' => 'mi-cha-lt-cha-ng-teakhvay', 'sort_order' => 8],
            ['name' => 'បបរគ្រប់មុខ', 'slug' => 'bab-rok-krormuk', 'sort_order' => 9],
            ['name' => 'ឈុតក្ងានដើមចេកភូមិស្នេហ៍', 'slug' => 'chut-kngan-dom-chek-phoum-sne', 'sort_order' => 10],
            ['name' => 'ស៊ុបសាច់អាំង', 'slug' => 'soup-sach-ang', 'sort_order' => 11],
            ['name' => 'ម្ហូបកម្ម៉ង់', 'slug' => 'mhob-kam-mong', 'sort_order' => 12],
            ['name' => 'សាច់ និងប្រហិត', 'slug' => 'sach-ng-prohit', 'sort_order' => 13],
            ['name' => 'បន្លែ', 'slug' => 'pnlay', 'sort_order' => 14],
            ['name' => 'ភេសជ្ជៈ និងស្រាបៀរ', 'slug' => 'phes-cho-ng-srabier', 'sort_order' => 15],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreateByName($categoryData['name'], [
                'slug' => $categoryData['slug'],
                'status' => true,
                'sort_order' => $categoryData['sort_order'],
            ]);

            $category->forceFill([
                'slug' => $categoryData['slug'],
                'status' => true,
                'sort_order' => $categoryData['sort_order'],
            ])->save();
        }
    }
}