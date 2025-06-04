<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use App\Models\Pasien;
use App\Models\Dokter;

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
     *     path="/api/konsultasis",
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
        ]);
    }

     /**
 * @OA\Post(
 *     path="/api/konsultasis",
 *     tags={"Konsultasi"},
 *     summary="Create a new consultation",
 *     @OA\Header(
 *         header="Accept",
 *         required=true,
 *         @OA\Schema(type="string", default="application/json")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id_pasien", "id_dokter", "tanggal_konsul", "status", "metode"},
 *             @OA\Property(property="id_pasien", type="integer"),
 *             @OA\Property(property="id_dokter", type="integer"),
 *             @OA\Property(property="tanggal_konsul", type="string", format="date"),
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
     try {
         $validatedData = $request->validate([
             'id_pasien' => 'required|integer|exists:pasiens,id',
             'id_dokter' => 'required|integer|exists:dokters,id',
             'tanggal_konsul' => 'required|date',
             'status' => 'required|in:pending,selesai,batal',
             'metode' => 'required|in:online,offline',
         ]);
 
         $konsultasis = Konsultasi::create($validatedData);
 
         return response()->json([
             'status' => 201,
             'message' => 'Konsultasi created successfully.',
             'data' => $konsultasis,
         ]);
     } catch (\Exception $e) {
         return response()->json([
             'status' => 500,
             'message' => 'Server error: ' . $e->getMessage(),
         ], 500);
     }
 }
 
    /**
     * @OA\Get(
     *     path="/api/konsultasis/{id}",
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
        $konsultasis = Konsultasi::find($id);

        if (!$konsultasis) {
            return response()->json([
                'status' => 404,
                'message' => 'Konsultasi not found.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi retrieved successfully.',
            'data' => $konsultasis,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/konsultasis/{id}",
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
     *             @OA\Property(property="tanggal_konsul", type="string", format="date"),
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
        $konsultasis = Konsultasi::find($id);

        if (!$konsultasis) {
            return response()->json([
                'status' => 404,
                'message' => 'Konsultasi not found.',
            ]);
        }

        $validatedData = $request->validate([
            'id_pasien' => 'required|integer|exists:pasiens,id',
            'id_dokter' => 'required|integer|exists:dokters,id',
            'tanggal_konsul' => 'required|date',
            'status' => 'required|in:pending,selesai,batal',
            'metode' => 'required|in:online,offline',
        ]);

        $konsultasis->update($validatedData);

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi updated successfully.',
            'data' => $konsultasis,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/konsultasis/{id}",
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
        $konsultasis = Konsultasi::find($id);

        if (!$konsultasis) {
            return response()->json([
                'status' => 404,
                'message' => 'Konsultasi not found.',
            ]);
        }

        $konsultasis->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi deleted successfully.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/konsultasis/detail",
     *     tags={"Konsultasi"},
     *     summary="Menampilkan semua data konsultasi beserta relasi pasien dan dokter",
     *     description="Mengambil data konsultasi lengkap dengan data pasien dan dokter",
     *     @OA\Response(
     *         response=200,
     *         description="Konsultasi with relations retrieved successfully"
     *     )
     * )
     */
    public function indexWithRelasi()
    {
        $konsultasis = Konsultasi::with([
            'pasien:id,nama,alamat,jenis_kelamin',
            'dokter:id,nama,spesialis,no_telp,email'
        ])->get();

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi with relations retrieved successfully.',
            'data' => $konsultasis,
        ]);
    }
    
}
