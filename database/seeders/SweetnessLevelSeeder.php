<?php

namespace Database\Seeders;

use App\Models\SweetnessLevel;
use Illuminate\Database\Seeder;

class SweetnessLevelSeeder extends Seeder
{
    public function run(): void
    {
        SweetnessLevel::insert([
            ['name'=>'0%',   'percent'=>0,   'status'=>true],
            ['name'=>'30%',  'percent'=>30,  'status'=>true],
            ['name'=>'50%',  'percent'=>50,  'status'=>true],
            ['name'=>'70%',  'percent'=>70,  'status'=>true],
            ['name'=>'100%', 'percent'=>100, 'status'=>true],
            ['name'=>'120%', 'percent'=>120, 'status'=>true],
        ]);
    }
}