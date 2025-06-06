<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PasienController;
use App\Http\Controllers\API\DokterController;
use App\Http\Controllers\API\RekamMedisController;
use App\Http\Controllers\API\KonsultasiController;
use App\Http\Controllers\API\JadwalDokterController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

// Endpoint publik
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

// Endpoint yang bebas akses (tidak butuh login)
Route::get('/pasiens/search', [PasienController::class, 'searchByName']);
Route::get('/pasiens', [PasienController::class, 'index']);
Route::get('/pasiens/{id}', [PasienController::class, 'show']);
Route::get('/dokters', [DokterController::class, 'index']);
Route::get('/jadwal_dokter', [JadwalDokterController::class, 'index']);
Route::get('/RekamMedis', [RekamMedisController::class, 'index']);
Route::get('/konsultasis', [KonsultasiController::class, 'index']);
Route::get('/konsultasis/detail', [KonsultasiController::class, 'indexWithRelasi']);
Route::get('/konsultasis/{id}', [KonsultasiController::class, 'show']);
Route::get('/jadwal_dokter/search', [JadwalDokterController::class, 'searchByName']);
Route::get('/users', [UserController::class, 'getAllUsers']);


// Group middleware untuk user role 'user' (harus login dan punya role user)
Route::middleware(['auth:sanctum', 'role:user,admin'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    Route::get('/jadwal_dokter/{id}', [JadwalDokterController::class, 'show']);
    Route::get('/jadwal_dokter_with_dokter', [JadwalDokterController::class, 'getAllWithDokter']);
    Route::get('/jadwal_dokter_Hari_Ini', [JadwalDokterController::class, 'getJadwalHariIni']);
    Route::get('/RekamMedis/search', [RekamMedisController::class, 'search']);
    Route::get('/RekamMedis/{id}', [RekamMedisController::class, 'show']);
    Route::post('/konsultasis', [KonsultasiController::class, 'store']);
    Route::put('/konsultasis/{id}', [KonsultasiController::class, 'update']);
    Route::delete('/konsultasis/{id}', [KonsultasiController::class, 'destroy']);
    Route::get('/dokters/{id}', [DokterController::class, 'show']);
    Route::get('/dokters/spesialis/{spesialis}', [DokterController::class, 'getBySpesialis']);


});

// Group middleware untuk user role 'admin' (harus login dan punya role admin)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::put('/payments/{id}', [PaymentController::class, 'update']);
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
    Route::post('/RekamMedis', [RekamMedisController::class, 'store']);
    Route::put('/RekamMedis/{id}', [RekamMedisController::class, 'update']);
    Route::delete('/RekamMedis/{id}', [RekamMedisController::class, 'destroy']);
    Route::post('/jadwal_dokter', [JadwalDokterController::class, 'store']);
    Route::put('/jadwal_dokter/{id}', [JadwalDokterController::class, 'update']);
    Route::delete('/jadwal_dokter/{id}', [JadwalDokterController::class, 'destroy']);
    Route::post('/dokters', [DokterController::class, 'store']);
    Route::put('/dokters/{id}', [DokterController::class, 'update']);
    Route::delete('/dokters/{id}', [DokterController::class, 'destroy']);
    Route::post('/pasiens', [PasienController::class, 'store']);
    Route::put('/pasiens/{id}', [PasienController::class, 'update']);
    Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']);
});

// Endpoint yang memerlukan autentikasi (token Bearer via sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', LogoutController::class);

    // Info user yang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});