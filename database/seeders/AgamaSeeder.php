<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agama;

class AgamaSeeder extends Seeder
{
    public function run(): void
    {
        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];

        foreach ($agamas as $nama) {
            Agama::create([
                'nama_agama' => $nama,
            ]);
        }
    }
}
