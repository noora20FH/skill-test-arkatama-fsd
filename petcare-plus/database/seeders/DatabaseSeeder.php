<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Owner;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
    {
        // Owner 1: Valid
        Owner::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com', // Added email
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 10, Jakarta', // Added address
            'is_verified' => true
        ]);

        // Owner 2: Valid
        Owner::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com', // Added email
            'phone' => '08987654321',
            'address' => 'Jl. Sudirman No. 5, Bandung', // Added address
            'is_verified' => true
        ]);

        // Owner 3: Tidak Valid (Unverified)
        Owner::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com', // Added email
            'phone' => '00000',
            'address' => 'Unknown Address', // Added address
            'is_verified' => false
        ]);
    }
}
