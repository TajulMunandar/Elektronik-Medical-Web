<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // password di-hash
            'role' => 'admin',
        ]);

        // Akun Petugas
        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        // Akun Pasien
        User::create([
            'name' => 'Pasien 1',
            'email' => 'pasien1@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pasien',
        ]);
    }
}
