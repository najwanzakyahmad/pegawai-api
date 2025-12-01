<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $jabatans = [
            'Kepala Dinas',
            'Sekretaris',
            'Kepala Bagian Umum',
            'Kepala Bagian Keuangan',
            'Staff Administrasi',
            'Staff Keuangan',
            'Staff IT',
        ];

        foreach ($jabatans as $nama) {
            Jabatan::create([
                'nama_jabatan' => $nama,
            ]);
        }
    }
}
