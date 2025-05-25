<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\Rekam_medisController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LaporanController;

Route::get('/pasiens', [PasienController::class, 'index']);
Route::get('/pasiens/{id}', [PasienController::class, 'show']); 
Route::post('/pasiens', [PasienController::class, 'store']); 
Route::put('/pasiens/{id}', [PasienController::class, 'update']); 
Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']); 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/dokters', [DokterController::class, 'index']);
Route::get('/dokters/{id}', [DokterController::class, 'show']); 
Route::post('/dokters', [DokterController::class, 'store']); 
Route::put('/dokters/{id}', [DokterController::class, 'update']); 
Route::delete('/dokters/{id}', [DokterController::class, 'destroy']); 
Route::get('/dokters/spesialis/{spesialis}', [DokterController::class, 'getBySpesialis']);


Route::get('/rekam_mediss', [Rekam_medisController::class, 'index']);
Route::get('/rekam_mediss/{id}', [Rekam_medisController::class, 'show']); 
Route::post('/rekam_mediss', [Rekam_medisController::class, 'store']); 
Route::put('/rekam_mediss/{id}', [Rekam_medisController::class, 'update']); 
Route::delete('/rekam_mediss/{id}', [Rekam_medisController::class, 'destroy']); 


Route::get('/konsultasis', [KonsultasiController::class, 'index']);            // Menampilkan semua konsultasi
Route::post('/konsultasis', [KonsultasiController::class, 'store']);           // Menyimpan konsultasi baru
Route::get('/konsultasis/{id}', [KonsultasiController::class, 'show']);        // Menampilkan detail konsultasi tertentu
Route::put('/konsultasis/{id}', [KonsultasiController::class, 'update']);      // Mengupdate data konsultasi
Route::delete('/konsultasis/{id}', [KonsultasiController::class, 'destroy']);  // Menghapus data konsultasi
Route::get('/konsultasis/detail', [KonsultasiController::class, 'indexWithRelasi']);


Route::get('/jadwal_dokter', [JadwalDokterController::class, 'index']);            // Menampilkan semua konsultasi
Route::post('/jadwal_dokter', [JadwalDokterController::class, 'store']);           // Menyimpan konsultasi baru
Route::get('/jadwal_dokter/{id}', [JadwalDokterController::class, 'show']);        // Menampilkan detail konsultasi tertentu
Route::put('/jadwal_dokter/{id}', [JadwalDokterController::class, 'update']);      // Mengupdate data konsultasi
Route::delete('/jadwal_dokter/{id}', [JadwalDokterController::class, 'destroy']);  // Menghapus data konsultasi
Route::get('/jadwal_dokter_with_dokter', [JadwalDokterController::class, 'getAllWithDokter']);
 

Route::get('/payments', [PaymentController::class, 'index']);            // Menampilkan semua payment
Route::post('/payments', [PaymentController::class, 'store']);           // Menyimpan payment baru
Route::get('/payments/{id}', [PaymentController::class, 'show']);        // Menampilkan detail payment tertentu
Route::put('/payments/{id}', [PaymentController::class, 'update']);      // Mengupdate data payment
Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);  // Menghapus data payment




Route::get('/laporans', [LaporanController::class, 'index']);       // GET /api/laporans
Route::post('/laporans', [LaporanController::class, 'store']);      // POST /api/laporans
Route::get('/laporans/{id}', [LaporanController::class, 'show']);    // GET /api/laporans/{id}
Route::put('/laporans/{id}', [LaporanController::class, 'update']);  // PUT /api/laporans/{id}
Route::delete('/laporans/{id}', [LaporanController::class, 'destroy']); // DELETE /api/laporans/{id}

//check push1
//check push2
//check push3
//check push4