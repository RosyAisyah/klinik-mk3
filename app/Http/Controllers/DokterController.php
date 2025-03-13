<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::all();

        return response()->json([
            'status' => 200,
            'message' => 'Dokter retrieved successfully.',
            'data' => $dokters,
        ], 200);
    }

    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'id'     => 'required|integer',
                'nama'              => 'required|string|max:255',
                'spesialis'            => 'required|string|max:255',
                'no_telp'           => 'required|integer',
                'email'             => 'required|string|max:255',
                'password'          => 'required|string'
            ]);
    
            $dokters = Dokter::create($validatedData);
    
            return response()->json([
                'status' => 201,
                'message' => 'Dokter created successfully.',
                'data' => $dokters,
            ], 201);
        }

        catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
    }

    }

    public function show(Dokter $dokters) // ✅ Model Binding
    {
        return response()->json([
            'status' => 200,
            'message' => 'Dokter retrieved successfully.',
            'data' => $dokters,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $dokters = Dokter::find($id);

        if (!$dokters) {
            return response()->json([
                'message' => 'Dokter not found'
            ], 404);
        }    

        $validatedData = $request->validate([
                'id'                => 'required|integer',
                'nama'              => 'required|string|max:255',
                'spesialis'         => 'required|string|max:255',
                'no_telp'           => 'required|integer',
                'email'             => 'required|string|max:255',
                'password'          => 'required|string'
        ]);

        $dokters->update($validatedData);
        $dokters->save();

        return response()->json([
            'message' => 'Dokter updated successfully',
            'dokter'    => $dokters
        ]);
    }

    public function destroy(Dokter $dokters) // ✅ Model Binding
    {
        $dokters->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Dokter deleted successfully.',
            'data' => null,
        ], 200);
    }
}