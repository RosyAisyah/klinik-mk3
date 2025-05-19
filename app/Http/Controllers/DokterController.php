<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;

class DokterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dokter",
     *     tags={"Dokter"},
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
     *     path="/api/dokter",
     *     tags={"Dokter"},
     *     summary="Create a new doctor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "nama", "spesialis", "no_telp", "email", "password"},
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="spesialis", type="string"),
     *             @OA\Property(property="no_telp", type="integer"),
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
                'id'     => 'required|integer',
                'nama'   => 'required|string|max:255',
                'spesialis' => 'required|string|max:255',
                'no_telp' => 'required|integer',
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
     *     path="/api/dokter/{id}",
     *     tags={"Dokter"},
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
    public function show(Dokter $dokters)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Dokter retrieved successfully.',
            'data' => $dokters,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/dokter/{id}",
     *     tags={"Dokter"},
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
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="spesialis", type="string"),
     *             @OA\Property(property="no_telp", type="integer"),
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
            'id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'no_telp' => 'required|integer',
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
     *     path="/api/dokter/{id}",
     *     tags={"Dokter"},
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
    public function destroy(Dokter $dokters)
    {
        $dokters->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Dokter deleted successfully.',
            'data' => null,
        ], 200);
    }
}
