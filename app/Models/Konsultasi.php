<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
  // App\Models\Konsultasi.php

protected $fillable = [
    'id_pasien',
    'id_dokter',
    'tanggal_konsul',
    'status',
    'metode',
];


   // App\Models\Konsultasi.php

public function pasien()
{
    return $this->belongsTo(Pasien::class, 'id_pasien');
}

public function dokter()
{
    return $this->belongsTo(Dokter::class, 'id_dokter');
}

}

