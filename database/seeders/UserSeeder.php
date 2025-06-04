<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user admin yang aktif
        DB::table('users')->insert([
            'nama_lengkap' => 'Ilham Fahrezi',
            'username' => 'rezi',
            'email' => 'ilham@gmail.com',
            'password' => Hash::make('ilhamCop'),
            'role' => 'admin',
            'status' => 'Active',
            'verification_token' => null,
            'verification_expiry' => null,
            'reset_pass_token' => null,
            'reset_pass_token_expiry' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'nama_lengkap' => 'Rayner Aditya',
            'username' => 'rayner',
            'email' => 'rayner@gmail.com',
            'password' => Hash::make('raynerCop'),
            'role' => 'admin',
            'status' => 'Active',
            'verification_token' => null,
            'verification_expiry' => null,
            'reset_pass_token' => null,
            'reset_pass_token_expiry' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'nama_lengkap' => 'Anjuan Kaisar',
            'username' => 'anjuan',
            'email' => 'anjuan@gmail.com',
            'password' => Hash::make('anjuanCop'),
            'role' => 'admin',
            'status' => 'Active',
            'verification_token' => null,
            'verification_expiry' => null,
            'reset_pass_token' => null,
            'reset_pass_token_expiry' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Membuat user biasa yang aktif
        DB::table('users')->insert([
            'nama_lengkap' => 'Pengguna Biasa',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'Active',
            'verification_token' => null,
            'verification_expiry' => null,
            'reset_pass_token' => null,
            'reset_pass_token_expiry' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Membuat user dengan status Inactive (butuh verifikasi)
        DB::table('users')->insert([
            'nama_lengkap' => 'User Tidak Aktif',
            'username' => 'inactive_user',
            'email' => 'inactive@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => 'Inactive',
            'verification_token' => Str::random(60),
            'verification_expiry' => now()->addDays(7),
            'reset_pass_token' => null,
            'reset_pass_token_expiry' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
