<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Jika kamu tidak mengisi primary key secara manual, jangan masukkan 'id_pembayaran' di fillable
    protected $fillable = [
        'id_konsultasi',
        'id_pasien',
        'jumlah_bayar',
        'metode_bayar',
        'status_pembayaran'
    ];

    // Kalau primary key namanya bukan 'id', perlu kasih tahu Eloquent
    protected $primaryKey = 'id_pembayaran';

    public $incrementing = true; // Kalau id_pembayaran auto increment, default true

    protected $keyType = 'int'; // Tipe primary key

    public function konsultasi()
    {
        // Foreign key id_konsultasi di tabel payments
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
}