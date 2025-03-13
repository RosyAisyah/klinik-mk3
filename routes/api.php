<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;

Route::get('/pasiens', [PasienController::class, 'index']);
Route::get('/pasiens/{id}', [PasienController::class, 'show']); 
Route::post('/pasiens', [PasienController::class, 'store']); 
Route::put('/pasiens/{id}', [PasienController::class, 'update']); 
Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']); 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('pasiens', PasienController::class);

// Route::get('/test', function(){
//     return response()->json(['message' => 'test']);
// });
