<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Update Akun Admin
        User::create([
            'nama' => 'Admin Eufrat',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'), //admin123
            'role' => 'admin',
            'recovery_phrase' => 'satu dua tiga empat lima enam tujuh delapan sembilan sepuluh sebelas dua belas', // TARUH DISINI
        ]);

        // Update Akun Sales
        User::create([
            'nama' => 'Sales Loddy',
            'email' => 'sales@mail.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
            'recovery_phrase' => 'satu dua tiga empat lima enam tujuh delapan sembilan sepuluh sebelas dua belas', // TARUH DISINI
        ]);

        // Update Akun Kepala Gudang
        User::create([
            'nama' => 'Gudang Tiko',
            'email' => 'gudang@mail.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_gudang',
            'recovery_phrase' => 'satu dua tiga empat lima enam tujuh delapan sembilan sepuluh sebelas dua belas', // TARUH DISINI
        ]);
    }
}