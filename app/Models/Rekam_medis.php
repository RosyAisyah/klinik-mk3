<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekam_medis extends Model
{
    protected $table = 'rekam_mediss';
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal_periksa',
        'diagnosa',
        'tindakan',
        'resep_obat'
    ];
}
