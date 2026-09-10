<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        Size::insert([
            [
                'name' => 'S',
                'code' => 'S',
                'status' => true,
            ],
            [
                'name' => 'M',
                'code' => 'M',
                'status' => true,
            ],
            [
                'name' => 'L',
                'code' => 'L',
                'status' => true,
            ],
            [
                'name' => 'Ly Dài',
                'code' => 'XL',
                'status' => true,
            ],
        ]);
    }
}