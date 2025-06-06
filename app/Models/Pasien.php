<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Payment; // Pastikan ini ada

class Pasien extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nama',
        'alamat',
        'jenis_kelamin',
        'no_telp',
        'tanggal_lahir',
        'email',
        'password'
    ];

    protected $hidden = ['password'];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_pasien');
    }
}
