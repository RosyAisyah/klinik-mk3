<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekam_medis;

class Rekam_medisController extends Controller
{
    public function index()
    {
        $rekam_mediss = Rekam_medis::all();

        return response()->json([
            'status' => 200,
            'message' => 'Rekam Medis retrieved successfully.',
            'data' => $rekam_mediss,
        ], 200);
    }

    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'id'                => 'required|integer',
                'pasien_id'         => 'required|integer',
                'dokter_id'         => 'required|integer',
                'tanggal_periksa'   => 'required|date',
                'diagnosa'          => 'required|string',
                'tindakan'          => 'required|string',
                'resep_obat'        => 'required|string'
            ]);
    
            $rekam_mediss = Rekam_medis::create($validatedData);
    
            return response()->json([
                'status' => 201,
                'message' => 'Rekam Medis created successfully.',
                'data' => $rekam_mediss,
            ], 201);
        }

        catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(Rekam_medis $rekam_mediss) // ✅ Model Binding
    {
        return response()->json([
            'status' => 200,
            'message' => 'Rekam Medis retrieved successfully.',
            'data' => $rekam_mediss,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $rekam_mediss = Rekam_medis::find($id);

        if (!$rekam_mediss) {
            return response()->json([
                'message' => 'Rekam Medis not found'
            ], 404);
        }    

        $validatedData = $request->validate([
                'id'                => 'required|integer',
                'pasien_id'         => 'required|integer',
                'dokter_id'         => 'required|integer',
                'tanggal_periksa'   => 'required|date',
                'diagnosa'          => 'required|string',
                'tindakan'          => 'required|string',
                'resep_obat'        => 'required|string'
        ]);

        $rekam_mediss->update($validatedData);
        $rekam_mediss->save();

        return response()->json([
            'message' => 'Rekam Medis updated successfully',
            'rekam_medis' => $rekam_mediss
        ]);
    }

    public function destroy(Rekam_medis $rekam_mediss) // ✅ Model Binding
    {
        $rekam_mediss->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Rekam Medis deleted successfully.',
            'data' => null,
        ], 200);
    }
}
