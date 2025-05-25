<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'konsultasi_id',
        'jumlah_bayar',
        'metode_bayar',
        'status_pembayaran'
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }

}
