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
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/konsultasis",
     *     tags={"Konsultasi"},
     *     summary="Create a new consultation",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_konsultasi","id_pasien", "id_dokter", "tanggal_konsul", "status", "metode"},
     *             @OA\Property(property="id_konsultasi", type="integer"),
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
        $validatedData = $request->validate([
            'id_konsultasi' => 'integer|exists:konsultasis,id',
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
        ], 201);
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
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Konsultasi retrieved successfully.',
            'data' => $konsultasis,
        ], 200);
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
     *             required={"id_konsultasi","id_pasien", "id_dokter", "tanggal_konsul", "status", "metode"},
     *             @OA\Property(property="id_konsultasi", type="integer"),
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
        $konsultasis = Konsultasi::find($id);

        if (!$konsultasis) {
            return response()->json([
                'status' => 404,
                'message' => 'Konsultasi not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'id_konsultasi' => 'integer|exists:konsultasis,id',
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
            ], 404);
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
 *     description="Mengambil data konsultasi lengkap dengan data pasien (id, nama, alamat, jenis_kelamin) dan dokter (id, nama, spesialis, no_telp, email)",
 *     @OA\Response(
 *         response=200,
 *         description="Konsultasi with relations retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Konsultasi with relations retrieved successfully."),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="tanggal_konsultasi", type="string", format="date", example="2025-05-26"),
 *                     @OA\Property(
 *                         property="pasien",
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=3),
 *                         @OA\Property(property="nama", type="string", example="Erlinda Nabilla"),
 *                         @OA\Property(property="alamat", type="string", example="Jl. Melati No. 5"),
 *                         @OA\Property(property="jenis_kelamin", type="string", example="Perempuan")
 *                     ),
 *                     @OA\Property(
 *                         property="dokter",
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=2),
 *                         @OA\Property(property="nama", type="string", example="dr. Raka Pratama"),
 *                         @OA\Property(property="spesialis", type="string", example="Saraf"),
 *                         @OA\Property(property="no_telp", type="string", example="081234567890"),
 *                         @OA\Property(property="email", type="string", example="raka@kliniksehat.com")
 *                     )
 *                 )
 *             )
 *         )
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
         'data' => $konsultasis
     ]);
 }
 

}
