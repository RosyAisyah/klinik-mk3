<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;

/**
 * @OA\Tag(
 *     name="Konsultasi",
 *     description="API untuk mengelola data konsultasi"
 * )
 */
class KonsultasiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/konsultasi",
     *     tags={"Konsultasi"},
     *     summary="Get all consultations",
     *     @OA\Response(
     *         response=200,
     *         description="Konsultasi retrieved successfully"
     *     )
     * )
     */
    public function index()
    {
        $konsultasis = Konsultasi::all();

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi retrieved successfully.',
            'data' => $konsultasis,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/konsultasi",
     *     tags={"Konsultasi"},
     *     summary="Create a new consultation",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_pasien", "id_dokter", "tanggal_konsul", "status", "metode"},
     *             @OA\Property(property="id_pasien", type="integer"),
     *             @OA\Property(property="id_dokter", type="integer"),
     *             @OA\Property(property="tanggal_konsul", type="string", format="date-time"),
     *             @OA\Property(property="status", type="string", enum={"pending", "selesai", "batal"}),
     *             @OA\Property(property="metode", type="string", enum={"online", "offline"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Konsultasi created successfully"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pasien' => 'required|integer|exists:pasiens,id',
            'id_dokter' => 'required|integer|exists:dokters,id',
            'tanggal_konsul' => 'required|date',
            'status' => 'required|in:pending,selesai,batal',
            'metode' => 'required|in:online,offline',
        ]);

        $konsultasi = Konsultasi::create($validatedData);

        return response()->json([
            'status' => 201,
            'message' => 'Konsultasi created successfully.',
            'data' => $konsultasi,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/konsultasi/{id}",
     *     tags={"Konsultasi"},
     *     summary="Get a consultation by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Konsultasi retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Konsultasi not found"
     *     )
     * )
     */
    public function show($id)
    {
        $konsultasi = Konsultasi::find($id);

        if (!$konsultasi) {
            return response()->json([
                'status' => 404,
                'message' => 'Konsultasi not found.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi retrieved successfully.',
            'data' => $konsultasi,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/konsultasi/{id}",
     *     tags={"Konsultasi"},
     *     summary="Update a consultation by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_pasien", "id_dokter", "tanggal_konsul", "status", "metode"},
     *             @OA\Property(property="id_pasien", type="integer"),
     *             @OA\Property(property="id_dokter", type="integer"),
     *             @OA\Property(property="tanggal_konsul", type="string", format="date-time"),
     *             @OA\Property(property="status", type="string", enum={"pending", "selesai", "batal"}),
     *             @OA\Property(property="metode", type="string", enum={"online", "offline"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Konsultasi updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Konsultasi not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $konsultasi = Konsultasi::find($id);

        if (!$konsultasi) {
            return response()->json([
                'status' => 404,
                'message' => 'Konsultasi not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'id_pasien' => 'required|integer|exists:pasiens,id',
            'id_dokter' => 'required|integer|exists:dokters,id',
            'tanggal_konsul' => 'required|date',
            'status' => 'required|in:pending,selesai,batal',
            'metode' => 'required|in:online,offline',
        ]);

        $konsultasi->update($validatedData);

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi updated successfully.',
            'data' => $konsultasi,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/konsultasi/{id}",
     *     tags={"Konsultasi"},
     *     summary="Delete consultation by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Konsultasi deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Konsultasi not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $konsultasi = Konsultasi::find($id);

        if (!$konsultasi) {
            return response()->json([
                'status' => 404,
                'message' => 'Konsultasi not found.',
            ], 404);
        }

        $konsultasi->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi deleted successfully.',
        ]);
    }
}
