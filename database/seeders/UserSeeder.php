<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Tambahkan ini
use Illuminate\Support\Facades\Hash; // <-- Tambahkan ini

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat User Admin
        User::create([
            'name' => 'Admin Cafe',
            'email' => 'admin@cafe.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
            'role' => 'admin',
        ]);

        // Membuat User Kasir
        User::create([
            'name' => 'Kasir Satu',
            'email' => 'kasir@cafe.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
            'role' => 'kasir',
        ]);
    }
}