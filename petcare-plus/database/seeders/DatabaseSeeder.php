<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@petcare.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun User Biasa
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 3. Data Owner (Untuk keperluan CRUD Admin)
        Owner::create(['name' => 'Budi Santoso', 'phone' => '08123456789', 'is_verified' => true]);
        Owner::create(['name' => 'Siti Aminah', 'phone' => '08987654321', 'is_verified' => true]);
    
    // Data Master Treatment
    \App\Models\Treatment::insert([
        ['name' => 'Vaksinasi Rabies'],
        ['name' => 'Grooming Lengkap'],
        ['name' => 'Pemeriksaan Umum (Checkup)'],
        ['name' => 'Sterilisasi'],
    ]);
        }
}
