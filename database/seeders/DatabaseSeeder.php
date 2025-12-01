<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GolonganSeeder::class,
            EselonSeeder::class,
            JabatanSeeder::class,
            AgamaSeeder::class,
            UnitKerjaSeeder::class,
            PegawaiSeeder::class,
        ]);
    }
}
