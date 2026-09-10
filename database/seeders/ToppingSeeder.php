<?php

namespace Database\Seeders;

use App\Models\Topping;
use Illuminate\Database\Seeder;

class ToppingSeeder extends Seeder
{
    public function run(): void
    {
        Topping::insert([
            ['name'=>'Trân châu BigSize','price'=>8000,'status'=>true],
            ['name'=>'Trân châu đen','price'=>8000,'status'=>true],
            ['name'=>'Nha đam','price'=>8000,'status'=>true],
            ['name'=>'Sương sáo','price'=>8000,'status'=>true],
            ['name'=>'Thạch Agar','price'=>8000,'status'=>true],
            ['name'=>'Thạch Aiyu','price'=>8000,'status'=>true],
            ['name'=>'Thạch dừa Đài Loan','price'=>8000,'status'=>true],
            ['name'=>'Khoai dẻo Oolong','price'=>10000,'status'=>true],
            ['name'=>'Pudding Thái Xanh','price'=>10000,'status'=>true],
            ['name'=>'Khúc Bạch','price'=>10000,'status'=>true],
            ['name'=>'Bánh Flan','price'=>10000,'status'=>true],
            ['name'=>'Kem dẻo','price'=>15000,'status'=>true],
            ['name'=>'Kem Muối','price'=>10000,'status'=>true],
            ['name'=>'Kem Matcha','price'=>10000,'status'=>true],
            ['name'=>'Kem Phô Mai','price'=>15000,'status'=>true],
            ['name'=>'Trái Vải','price'=>10000,'status'=>true],
            ['name'=>'Đào Miếng','price'=>10000,'status'=>true],
            ['name'=>'Flan Trứng Caramel Bự','price'=>23000,'status'=>true],
        ]);
    }
}