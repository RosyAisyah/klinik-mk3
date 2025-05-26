<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';
    use HasFactory;

    protected $fillable = [
        'periode',
        'id_pembayaran',
        'jumlah_pasien',
        'total_pendapatan',
    ];

}
