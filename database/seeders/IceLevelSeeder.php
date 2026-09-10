<?php

namespace Database\Seeders;

use App\Models\IceLevel;
use Illuminate\Database\Seeder;

class IceLevelSeeder extends Seeder
{
    public function run(): void
    {
        IceLevel::insert([
            [
                'name' => 'Không đá',
                'percent' => 0,
                'status' => true,
            ],
            [
                'name' => '50% đá',
                'percent' => 50,
                'status' => true,
            ],
            [
                'name' => '100% đá',
                'percent' => 100,
                'status' => true,
            ],
            [
                'name' => 'Đá riêng',
                'percent' => -1,
                'status' => true,
            ],
        ]);
    }
}