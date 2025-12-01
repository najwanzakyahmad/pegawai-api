<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 admin
        User::create([
            'username'     => 'admin',
            'password'     => Hash::make('password'), // ganti di produksi
            'nama_lengkap' => 'Administrator Sistem',
            'role'         => 'admin',
        ]);

        // 4 user
        for ($i = 1; $i <= 4; $i++) {
            User::create([
                'username'     => 'user' . $i,
                'password'     => Hash::make('password'), // ganti di produksi
                'nama_lengkap' => 'User Pegawai ' . $i,
                'role'         => 'user',
            ]);
        }
    }
}
