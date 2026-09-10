<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            SizeSeeder::class,
            SweetnessLevelSeeder::class,
            IceLevelSeeder::class,
            ToppingSeeder::class,
            ProductSeeder::class,
            ProductSizeSeeder::class,
            ProductRelationSeeder::class,
            CoffeeShopDataSeeder::class,
        ]);
    }
}
