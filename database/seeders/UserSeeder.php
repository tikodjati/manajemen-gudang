<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Akun Admin [cite: 177]
        User::create([
            'nama' => 'Admin Eufrat',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Akun Sales [cite: 177]
        User::create([
            'nama' => 'Sales Loddy',
            'email' => 'sales@mail.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
        ]);

        // Akun Kepala Gudang [cite: 177]
        User::create([
            'nama' => 'Gudang Tiko',
            'email' => 'gudang@mail.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_gudang',
        ]);
    }
}
