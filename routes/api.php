<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\Pasien;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\Rekam_medisController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LaporanController;

Route::get('/pasiens/search', [PasienController::class, 'searchByName']);
Route::get('/pasiens', [PasienController::class, 'index']);
Route::get('/pasiens/{id}', [PasienController::class, 'show']); 
Route::post('/pasiens', [PasienController::class, 'store']); 
Route::put('/pasiens/{id}', [PasienController::class, 'update']); 
Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']);
Route::post('/pasiens/login', [PasienController::class, 'login']);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/dokters', [DokterController::class, 'index']);
Route::get('/dokters/{id}', [DokterController::class, 'show']); 
Route::post('/dokters', [DokterController::class, 'store']); 
Route::put('/dokters/{id}', [DokterController::class, 'update']); 
Route::delete('/dokters/{id}', [DokterController::class, 'destroy']); 
Route::get('/dokters/spesialis/{spesialis}', [DokterController::class, 'getBySpesialis']);


Route::get('/rekam_mediss/search', [Rekam_medisController::class, 'search']); // ⬅️ Pindahkan ke atas duluan
Route::get('/rekam_mediss', [Rekam_medisController::class, 'index']);
Route::get('/rekam_mediss/{id}', [Rekam_medisController::class, 'show']);
Route::post('/rekam_mediss', [Rekam_medisController::class, 'store']);
Route::put('/rekam_mediss/{id}', [Rekam_medisController::class, 'update']);
Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy']);



Route::get('/konsultasis', [KonsultasiController::class, 'index']);
Route::get('/konsultasis/detail', [KonsultasiController::class, 'indexWithRelasi']);
Route::get('/konsultasis/{id}', [KonsultasiController::class, 'show']);
Route::post('/konsultasis', [KonsultasiController::class, 'store']);
Route::put('/konsultasis/{id}', [KonsultasiController::class, 'update']);
Route::delete('/konsultasis/{id}', [KonsultasiController::class, 'destroy']);



Route::get('/jadwal_dokter', [JadwalDokterController::class, 'index']);            // Menampilkan semua konsultasi
Route::post('/jadwal_dokter', [JadwalDokterController::class, 'store']);           // Menyimpan konsultasi baru
Route::get('/jadwal_dokter/{id}', [JadwalDokterController::class, 'show']);        // Menampilkan detail konsultasi tertentu
Route::put('/jadwal_dokter/{id}', [JadwalDokterController::class, 'update']);      // Mengupdate data konsultasi
Route::delete('/jadwal_dokter/{id}', [JadwalDokterController::class, 'destroy']);  // Menghapus data konsultasi
Route::get('/jadwal_dokter_with_dokter', [JadwalDokterController::class, 'getAllWithDokter']);
Route::get('/jadwal_dokter_Hari_Ini', [JadwalDokterController::class, 'getJadwalHariIni']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    Route::put('/payments/{id}', [PaymentController::class, 'update']);
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
});


Route::get('/laporans', [LaporanController::class, 'index']);       // GET /api/laporans
Route::post('/laporans', [LaporanController::class, 'store']);      // POST /api/laporans
Route::get('/laporans/{id}', [LaporanController::class, 'show']);    // GET /api/laporans/{id}
Route::put('/laporans/{id}', [LaporanController::class, 'update']);  // PUT /api/laporans/{id}
Route::delete('/laporans/{id}', [LaporanController::class, 'destroy']); // DELETE /api/laporans/{id}

Route::post('/pasiens/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $pasien = Pasien::where('email', $request->email)->first();

    if (!$pasien || !Hash::check($request->password, $pasien->password)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    return response()->json([
        'token' => $pasien->createToken('api-token')->plainTextToken,
        'pasien' => $pasien
    ]);
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'email' => 'required|email|unique:pasiens,email',
        'password' => 'required|min:6',
        'nama' => 'required',
        'alamat' => 'required',
        'jenis_kelamin' => 'required',
        'no_telp' => 'required',
        'tanggal_lahir' => 'required|date',
    ]);

    $pasien = \App\Models\Pasien::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'no_telp' => $request->no_telp,
        'tanggal_lahir' => $request->tanggal_lahir,
        'konsultasi_id' => null // atau isi sesuai kebutuhan
    ]);

    return response()->json([
        'message' => 'Pasien berhasil didaftarkan',
        'pasien' => $pasien
    ], 201);
});