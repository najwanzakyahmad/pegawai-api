<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eselon extends Model
{
    use HasFactory;

    protected $table = 'eselon';

    protected $fillable = [
        'kode_eselon',
        'keterangan'
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}

