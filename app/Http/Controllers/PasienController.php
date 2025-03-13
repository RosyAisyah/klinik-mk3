<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::all();

        return response()->json([
            'status' => 200,
            'message' => 'Pasien retrieved successfully.',
            'data' => $pasiens,
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'konsultasi_id'     => 'required|integer',
            'nama'              => 'required|string|max:255',
            'alamat'            => 'required|string|max:255',
            'jenis_kelamin'     => 'in:Laki-laki,Perempuan',
            'no_telp'           => 'required|integer',
            'tanggal_lahir'     => 'required|date',
            'email'             => 'required|string|max:255',
            'password'          => 'required|string'
        ]);

        $pasiens = Pasien::create($validatedData);

        return response()->json([
            'status' => 201,
            'message' => 'Pasien created successfully.',
            'data' => $pasiens,
        ], 201);
    }

    public function show(Pasien $pasiens) // ✅ Model Binding
    {
        return response()->json([
            'status' => 200,
            'message' => 'Pasien retrieved successfully.',
            'data' => $pasiens,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $pasiens = Pasien::find($id);

        if (!$pasiens) {
            return response()->json([
                'message' => 'Pasien not found'
            ], 404);
        }    

        $validatedData = $request->validate([
            'konsultasi_id'     => 'required|integer',
            'nama'              => 'required|string|max:255',
            'alamat'            => 'required|string|max:255',
            'tanggal_lahir'     => 'required|date',
            'riwayat_medis'     => 'nullable|text',
            'email'             => 'required|string|max:255'
        ]);

        $pasiens->update($validatedData);
        $pasiens->save();

        return response()->json([
            'message' => 'Pasien updated successfully',
            'pasien'    => $pasiens
        ]);
    }

    public function destroy(Pasien $pasiens) // ✅ Model Binding
    {
        $pasiens->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Pasien deleted successfully.',
            'data' => null,
        ], 200);
    }
}