<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Golongan;

class GolonganSeeder extends Seeder
{
    public function run(): void
    {
        $golongans = [
            'I/a', 'I/b', 'I/c', 'I/d',
            'II/a', 'II/b', 'II/c', 'II/d',
            'III/a', 'III/b', 'III/c', 'III/d',
            'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e',
            'V/a', 'V/b',
        ];

        foreach ($golongans as $kode) {
            Golongan::create([
                'kode_gol'  => $kode,
                'keterangan'=> 'Golongan ' . $kode,
            ]);
        }
    }
}
