<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CoffeeShopDataSeeder extends Seeder
{
    /**
     * Seed comprehensive sample data for a Cambodian coffee shop.
     */
    public function run(): void
    {
        $this->seedCategories();
        $this->seedCustomers();
        $this->seedSuppliers();
        $this->seedInventories();
        $this->seedEmployees();
        $this->seedDiscounts();
        $this->seedReservations();
    }

    private function seedCategories(): void
    {
        $categories = [
            'កាហ្វេ' => 'cafe',
            'តែ' => 'tea',
            'តែទឹកដោះគោ' => 'milk-tea',
            'ទឹកដោះគោ' => 'milk',
            'ទឹកក្រូច' => 'juice',
            'អាហារសម្រន់' => 'snacks',
        ];

        // Insert Khmer coffee shop categories
        foreach ($categories as $name => $slug) {
            $exists = DB::table('categories')->where('slug', $slug)->first();
            if (!$exists) {
                DB::table('categories')->insert([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => 'Category for ' . $name,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedCustomers(): void
    {
        $customers = [
            ['name' => 'សុខ វុឌ្ឍ', 'email' => 'sokvuth@gmail.com', 'phone_number' => '012345678'],
            ['name' => 'ចាន់ ស្រីនី', 'email' => 'chansreyni@gmail.com', 'phone_number' => '098765432'],
            ['name' => 'រិទ្ធី សុភា', 'email' => 'rithysopha@gmail.com', 'phone_number' => '011223344'],
            ['name' => 'នី សុខួន', 'email' => 'nisokhoun@gmail.com', 'phone_number' => '016556677'],
            ['name' => 'ឡេង ណារី', 'email' => 'lengnary@gmail.com', 'phone_number' => '017889900'],
            ['name' => 'គឹម ស្រីពេជ្រ', 'email' => 'kimsreypech@gmail.com', 'phone_number' => '092334455'],
            ['name' => 'វ៉ន វិច្ឆិកា', 'email' => 'vonvichika@gmail.com', 'phone_number' => '015667788'],
            ['name' => 'ហុក សុខុន', 'email' => 'hoksokhun@gmail.com', 'phone_number' => '010112233'],
            ['name' => 'ម៉ៅ ស្រីនន្នា', 'email' => 'maosreinun@gmail.com', 'phone_number' => '099445566'],
            ['name' => 'ប៊ុន រិទ្ធី', 'email' => 'bunritthy@gmail.com', 'phone_number' => '088778899'],
        ];

        foreach ($customers as $customer) {
            $exists = DB::table('customers')->where('name', $customer['name'])->first();
            if (!$exists) {
                DB::table('customers')->insert(array_merge($customer, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    private function seedSuppliers(): void
    {
        $suppliers = [
            ['name' => 'ក្រុមហ៊ុន កាហ្វេរកម្ពុជា', 'address' => 'ផ្សារកណ្តាល, ភ្នំពេញ', 'phone' => '012444555'],
            ['name' => 'រោងចក្រទឹកដោះគោ កម្ពុជា', 'address' => 'ខេត្តកំពង់ស្ពឺ', 'phone' => '086666777'],
            ['name' => 'ក្រុមហ៊ុន ស្ករស អង្គរ', 'address' => 'ខេត្តកំពង់ធំ', 'phone' => '017888999'],
            ['name' => 'អ្នកផ្គត់ផ្គង់ តែបៃតង', 'address' => 'ខេត្តមណ្ឌលគិរី', 'phone' => '012333444'],
            ['name' => 'ក្រុមហ៊ុន ដឹកជញ្ជូន សុភមង្គល', 'address' => 'ផ្លូវព្រះមុនីវង្ស, ភ្នំពេញ', 'phone' => '098222333'],
        ];

        foreach ($suppliers as $supplier) {
            $exists = DB::table('suppliers')->where('name', $supplier['name'])->first();
            if (!$exists) {
                DB::table('suppliers')->insert(array_merge($supplier, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    private function seedInventories(): void
    {
        $items = [
            ['name' => 'កាហ្វេស្ងួត', 'stock' => 500, 'unit' => 'គីឡូក្រាម'],
            ['name' => 'ស្ករស', 'stock' => 1000, 'unit' => 'គីឡូក្រាម'],
            ['name' => 'ទឹកដោះគោម្សៅ', 'stock' => 300, 'unit' => 'កំប៉ុង'],
            ['name' => 'តែបៃតង', 'stock' => 200, 'unit' => 'គីឡូក្រាម'],
            ['name' => 'ពែងក្រដាស', 'stock' => 5000, 'unit' => 'ពែង'],
            ['name' => 'ភ្លេងផ្លាស្ទិក', 'stock' => 4000, 'unit' => 'ដើម'],
            ['name' => 'មីក្រែម', 'stock' => 150, 'unit' => 'ដប'],
            ['name' => 'ទឹកបរិសុទ្ធ', 'stock' => 100, 'unit' => 'ដបធំ'],
        ];

        foreach ($items as $item) {
            $exists = DB::table('inventories')->where('name', $item['name'])->first();
            if (!$exists) {
                DB::table('inventories')->insert(array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    private function seedEmployees(): void
    {
        $employees = [
            ['name' => 'ចាន់ ដាណា', 'phone' => '012111222', 'position' => 'អ្នកគ្រប់គ្រង', 'date_of_birth' => '1990-05-15', 'date_of_joining' => '2021-03-01', 'salary' => 800.00, 'address' => 'ភ្នំពេញ'],
            ['name' => 'សុខ រិទ្ធី', 'phone' => '098333444', 'position' => 'អ្នកធ្វើកាហ្វេ', 'date_of_birth' => '1995-08-20', 'date_of_joining' => '2022-06-15', 'salary' => 350.00, 'address' => 'ខេត្តកណ្តាល'],
            ['name' => 'ណារី សុខ', 'phone' => '011444555', 'position' => 'អ្នកបម្រើ', 'date_of_birth' => '1998-02-10', 'date_of_joining' => '2023-01-10', 'salary' => 250.00, 'address' => 'ភ្នំពេញ'],
            ['name' => 'លី ស្រីពេជ្រ', 'phone' => '012555666', 'position' => 'គណនេយ្យករ', 'date_of_birth' => '1993-11-25', 'date_of_joining' => '2021-09-01', 'salary' => 600.00, 'address' => 'ខេត្តតាកែវ'],
            ['name' => 'ហេង វិច្ឆិកា', 'phone' => '098666777', 'position' => 'អ្នកបម្រើ', 'date_of_birth' => '2000-07-05', 'date_of_joining' => '2023-05-20', 'salary' => 250.00, 'address' => 'ភ្នំពេញ'],
        ];

        foreach ($employees as $emp) {
            $exists = DB::table('employees')->where('name', $emp['name'])->first();
            if (!$exists) {
                DB::table('employees')->insert(array_merge([
                    'user_id' => null,
                ], $emp, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    private function seedDiscounts(): void
    {
        $discounts = [
            ['name' => 'បញ្ចុះតម្លៃពេលព្រឹក', 'description' => 'បញ្ចុះ 10% សម្រាប់ភេសជ្ជៈពេលព្រឹក', 'type' => 'percentage', 'value' => 10, 'status' => 'active', 'expired_date' => '2026-12-31'],
            ['name' => 'បញ្ចុះតម្លៃសិស្សនិស្សិត', 'description' => 'បញ្ចុះ 15% សម្រាប់សិស្សនិស្សិត', 'type' => 'percentage', 'value' => 15, 'status' => 'active', 'expired_date' => '2026-12-31'],
            ['name' => 'បញ្ចុះតម្លៃចុងសប្តាហ៍', 'description' => 'បញ្ចុះ 20% នៅថ្ងៃសៅរ៍-អាទិត្យ', 'type' => 'percentage', 'value' => 20, 'status' => 'active', 'expired_date' => '2026-12-31'],
            ['name' => 'កាតសមាជិក VIP', 'description' => 'បញ្ចុះ 5000៛ សម្រាប់សមាជិក VIP', 'type' => 'fixed', 'value' => 5000, 'status' => 'active', 'expired_date' => '2026-12-31'],
        ];

        foreach ($discounts as $discount) {
            $exists = DB::table('discounts')->where('name', $discount['name'])->first();
            if (!$exists) {
                DB::table('discounts')->insert(array_merge($discount, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    private function seedReservations(): void
    {
        $reservations = [
            ['customer_name' => 'សុខ វុឌ្ឍ', 'customer_phone' => '012345678', 'reservation_date' => '2026-07-25', 'reservation_time' => '10:00:00', 'status' => 'confirmed', 'notes' => 'កក់តុក្បែរបង្អួច', 'table_number' => '5'],
            ['customer_name' => 'ចាន់ ស្រីនី', 'customer_phone' => '098765432', 'reservation_date' => '2026-07-25', 'reservation_time' => '14:30:00', 'status' => 'pending', 'notes' => 'កក់តុសម្រាប់ 4 នាក់', 'table_number' => '8'],
            ['customer_name' => 'រិទ្ធី សុភា', 'customer_phone' => '011223344', 'reservation_date' => '2026-07-26', 'reservation_time' => '09:00:00', 'status' => 'pending', 'notes' => 'អបអរសាទរខួបកំណើត', 'table_number' => '3'],
        ];

        foreach ($reservations as $res) {
            $exists = DB::table('reservations')->where('reservation_date', $res['reservation_date'])->where('customer_name', $res['customer_name'])->first();
            if (!$exists) {
                DB::table('reservations')->insert(array_merge([
                    'reservation_code' => 'RSV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                ], $res, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
