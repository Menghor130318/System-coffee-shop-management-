<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateRequestedAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'System Administrator']
        );

        $customerRole = Role::firstOrCreate(
            ['name' => 'Customer'],
            ['description' => 'Customer']
        );

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer1@example.com'],
            [
                'full_name' => 'Customer One',
                'password' => Hash::make('password123'),
                'role_id' => $customerRole->id,
            ]
        );
    }
}
