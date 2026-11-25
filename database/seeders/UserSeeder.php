<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Patient Test User
        User::create([
            'first_name' => 'Maria',
            'last_name' => 'Okafor',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'phone' => '555-0101',
        ]);

        // 2. Doctor Test User
        User::create([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'phone' => '555-0102',
            'staff_id' => 'DOC-001',
            'license_no' => 'MD-12345',
        ]);

        // 3. Nurse Test User
        User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => 'nurse@example.com',
            'password' => Hash::make('password123'),
            'role' => 'nurse',
            'phone' => '555-0103',
            'staff_id' => 'NUR-001',
            'license_no' => 'RN-67890',
        ]);

        // 4. Admin Test User
        User::create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '555-0104',
            'staff_id' => 'ADM-001',
        ]);
    }
}