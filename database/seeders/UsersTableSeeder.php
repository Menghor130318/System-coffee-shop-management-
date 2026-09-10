<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'Admin')->value('id');
        $customerRoleId = DB::table('roles')->where('name', 'Customer')->value('id');

        DB::table('users')->insert([
            [
                'full_name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $adminRoleId,
            ],
            [
                'full_name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $customerRoleId,
            ],
            [
                'full_name' => 'Alice Smith',
                'email' => 'alice@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $customerRoleId,
            ],
        
        ]);
    }
}
