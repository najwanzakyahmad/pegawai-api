<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eselon;

class EselonSeeder extends Seeder
{
    public function run(): void
    {
        $eselons = [
            'I'   => 'Eselon I',
            'II'  => 'Eselon II',
            'III' => 'Eselon III',
            'IV'  => 'Eselon IV',
        ];

        foreach ($eselons as $kode => $ket) {
            Eselon::create([
                'kode_eselon' => $kode,
                'keterangan'  => $ket,
            ]);
        }
    }
}
