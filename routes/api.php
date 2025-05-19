<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\Rekam_medisController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\Jadwal_dokterController;
use App\Http\Controllers\PaymentController;

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

Route::get('/rekam_mediss', [Rekam_medisController::class, 'index']);
Route::get('/rekam_mediss/{id}', [Rekam_medisController::class, 'show']); 
Route::post('/rekam_mediss', [Rekam_medisController::class, 'store']); 
Route::put('/rekam_mediss/{id}', [Rekam_medisController::class, 'update']); 
Route::delete('/rekam_mediss/{id}', [Rekam_medisController::class, 'destroy']); 

// Route::apiResource('pasiens', PasienController::class);

// Route::get('/test', function(){
//     return response()->json(['message' => 'test']);
// });

Route::apiResource('pasien', PasienController::class);




// Route untuk resource Konsultasi
Route::get('/konsultasi', [KonsultasiController::class, 'index']);            // Menampilkan semua konsultasi
Route::post('/konsultasi', [KonsultasiController::class, 'store']);           // Menyimpan konsultasi baru
Route::get('/konsultasi/{id}', [KonsultasiController::class, 'show']);        // Menampilkan detail konsultasi tertentu
Route::put('/konsultasi/{id}', [KonsultasiController::class, 'update']);      // Mengupdate data konsultasi
Route::delete('/konsultasi/{id}', [KonsultasiController::class, 'destroy']);  // Menghapus data konsultasi

// Route untuk resource Konsultasi
Route::get('/jadwal_dokter', [Jadwal_dokterController::class, 'index']);            // Menampilkan semua konsultasi
Route::post('/jadwal_dokter', [Jadwal_dokterController::class, 'store']);           // Menyimpan konsultasi baru
Route::get('/jadwal_dokter/{id}', [Jadwal_dokter::class, 'show']);        // Menampilkan detail konsultasi tertentu
Route::put('/jadwal_dokter/{id}', [Jadwal_dokterController::class, 'update']);      // Mengupdate data konsultasi
Route::delete('/jadwal_dokter/{id}', [Jadwal_dokterController::class, 'destroy']);  // Menghapus data konsultasi




// Route untuk resource Payment
Route::get('/payments', [PaymentController::class, 'index']);            // Menampilkan semua payment
Route::post('/payments', [PaymentController::class, 'store']);           // Menyimpan payment baru
Route::get('/payments/{id}', [PaymentController::class, 'show']);        // Menampilkan detail payment tertentu
Route::put('/payments/{id}', [PaymentController::class, 'update']);      // Mengupdate data payment
Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);  // Menghapus data payment


use App\Http\Controllers\LaporanController;

Route::prefix('laporans')->group(function () {
    Route::get('/laporans', [LaporanController::class, 'index']);       // GET /api/laporans
    Route::post('/laporans', [LaporanController::class, 'store']);      // POST /api/laporans
    Route::get('/laporans/{id}', [LaporanController::class, 'show']);    // GET /api/laporans/{id}
    Route::put('/laporans/{id}', [LaporanController::class, 'update']);  // PUT /api/laporans/{id}
    Route::delete('/laporans/{id}', [LaporanController::class, 'destroy']); // DELETE /api/laporans/{id}
});

//check push
