<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongan';
    protected $fillable = [
        'kode_gol',
        'keterangan'
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}

