<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitKerja;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        // level 1
        $sekretariat = UnitKerja::create([
            'nama_unit' => 'Sekretariat',
            'kode_unit' => 'UK-001',
            'parent_id' => null,
        ]);

        $keuangan = UnitKerja::create([
            'nama_unit' => 'Bagian Keuangan',
            'kode_unit' => 'UK-002',
            'parent_id' => null,
        ]);

        $it = UnitKerja::create([
            'nama_unit' => 'Bagian Teknologi Informasi',
            'kode_unit' => 'UK-003',
            'parent_id' => null,
        ]);

        // level 2 (child)
        UnitKerja::create([
            'nama_unit' => 'Subbag Umum',
            'kode_unit' => 'UK-004',
            'parent_id' => $sekretariat->id,
        ]);

        UnitKerja::create([
            'nama_unit' => 'Subbag Perencanaan',
            'kode_unit' => 'UK-005',
            'parent_id' => $sekretariat->id,
        ]);

        UnitKerja::create([
            'nama_unit' => 'Subbag Akuntansi',
            'kode_unit' => 'UK-006',
            'parent_id' => $keuangan->id,
        ]);

        UnitKerja::create([
            'nama_unit' => 'Subbag Aplikasi',
            'kode_unit' => 'UK-007',
            'parent_id' => $it->id,
        ]);
    }
}
