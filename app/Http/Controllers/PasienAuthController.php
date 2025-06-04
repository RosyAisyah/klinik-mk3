<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;

class PasienAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $pasien = Pasien::where('email', $credentials['email'])->first();

        if (!$pasien || !Hash::check($credentials['password'], $pasien->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Buat token sanctum
        $token = $pasien->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'token' => $token,
            'pasien' => $pasien,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout success',
        ]);
    }
}
