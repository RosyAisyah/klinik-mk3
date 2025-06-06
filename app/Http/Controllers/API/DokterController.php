<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;

class DokterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dokters",
     *     tags={"Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Get all doctors",
     *     @OA\Response(
     *         response=200,
     *         description="Dokter retrieved successfully"
     *     )
     * )
     */
    public function index()
    {
        $dokters = Dokter::all();
        return response()->json([
            'status' => 200,
            'message' => 'Dokter retrieved successfully.',
            'data' => $dokters,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/dokters",
     *     tags={"Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Create a new doctor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "nama", "spesialis", "no_telp", "email", "password"},
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="spesialis", type="string"),
     *             @OA\Property(property="no_telp", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Dokter created successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama'   => 'required|string|max:255',
                'spesialis' => 'required|string|max:255',
                'no_telp' => 'required|string',
                'email' => 'required|string|max:255',
                'password' => 'required|string'
            ]);

            $dokters = Dokter::create($validatedData);

            return response()->json([
                'status' => 201,
                'message' => 'Dokter created successfully.',
                'data' => $dokters,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/dokters/{id}",
     *     tags={"Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Get doctor by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dokter retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dokter not found"
     *     )
     * )
     */
    public function show($id)
    {
        $dokter = Dokter::find($id);

        if (!$dokter) {
            return response()->json([
                'status' => 404,
                'message' => 'Dokter not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Dokter retrieved successfully.',
            'data' => $dokter,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/dokters/{id}",
     *     tags={"Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Update a doctor by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "nama", "spesialis", "no_telp", "email", "password"},
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="spesialis", type="string"),
     *             @OA\Property(property="no_telp", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dokter updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dokter not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $dokters = Dokter::find($id);

        if (!$dokters) {
            return response()->json([
                'message' => 'Dokter not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'no_telp' => 'required|string',
            'email' => 'required|string|max:255',
            'password' => 'required|string'
        ]);

        $dokters->update($validatedData);
        $dokters->save();

        return response()->json([
            'message' => 'Dokter updated successfully',
            'dokter' => $dokters
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/dokters/{id}",
     *     tags={"Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Delete doctor by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dokter deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dokter not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $dokter = Dokter::find($id);

        if (!$dokter) {
            return response()->json([
                'status' => 404,
                'message' => 'Dokter not found.',
            ], 404);
        }

        $dokter->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Dokter deleted successfully.',
            'data' => null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/dokters/spesialis/{spesialis}",
     *     tags={"Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Ambil daftar dokter berdasarkan spesialis",
     *     @OA\Parameter(
     *         name="spesialis",
     *         in="path",
     *         description="Spesialis dokter, misalnya: anak, gigi, umum",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sukses mengambil data dokter",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data dokter ditemukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="dr. Siti"),
     *                     @OA\Property(property="spesialis", type="string", example="gigi"),
     *                     @OA\Property(property="no_telp", type="string", example="081234567890"),
     *                     @OA\Property(property="email", type="string", example="dr.siti@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Dokter tidak ditemukan")
     * )
     */
    public function getBySpesialis($spesialis)
    {
        $dokters = Dokter::where('spesialis', $spesialis)->get();

        if ($dokters->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada dokter dengan spesialis ' . $spesialis,
            ], 404);
        }

        return response()->json([
            'message' => 'Data dokter ditemukan',
            'data' => $dokters->makeHidden(['password']),
        ], 200);
    }
}