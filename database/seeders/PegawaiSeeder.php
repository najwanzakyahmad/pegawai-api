<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\Jabatan;
use App\Models\Agama;
use App\Models\UnitKerja;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $golonganIds = Golongan::pluck('id')->all();
        $eselonIds   = Eselon::pluck('id')->all();
        $jabatanIds  = Jabatan::pluck('id')->all();
        $agamaIds    = Agama::pluck('id')->all();
        $unitIds     = UnitKerja::pluck('id')->all();

        for ($i = 1; $i <= 100; $i++) {

            Pegawai::create([
                'nip'          => '1980' . str_pad($i, 6, '0', STR_PAD_LEFT), // unik
                'nama'         => $faker->name(),
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir'=> $faker->date('Y-m-d', '2000-12-31'),
                'jenis_kelamin'=> $faker->randomElement(['L','P']),
                'alamat'       => $faker->address(),
                'golongan_id'  => $faker->randomElement($golonganIds),
                'eselon_id'    => $faker->randomElement($eselonIds),
                'jabatan_id'   => $faker->randomElement($jabatanIds),
                'tempat_tugas' => $faker->city(),
                'agama_id'     => $faker->randomElement($agamaIds),
                'unit_kerja_id'=> $faker->randomElement($unitIds),
                'no_hp'        => $faker->phoneNumber(),
                'npwp'         => $faker->numerify('##.###.###.#-###.###'),
                
            ]);
        }
    }
}
