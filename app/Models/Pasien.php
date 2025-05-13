<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'konsultasi_id',
        'nama',
        'alamat',
        'jenis_kelamin',
        'no_telp',
        'tanggal_lahir',
        'email',
        'password'
    ];
}
