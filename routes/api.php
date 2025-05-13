<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\Rekam_medisController;

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
