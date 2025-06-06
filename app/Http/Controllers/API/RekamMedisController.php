<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;

/**
 * @OA\Tag(
 *     name="Rekam Medis",
 *     description="API untuk mengelola data rekam medis"
 * )
 */
class RekamMedisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/RekamMedis",
     *     tags={"Rekam Medis"},
     *     summary="Menampilkan semua data rekam medis",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar rekam medis berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $RekamMedis = RekamMedis::all();

        return response()->json([
            'status' => 200,
            'message' => 'Rekam Medis retrieved successfully.',
            'data' => $RekamMedis,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/RekamMedis",
     *     tags={"Rekam Medis"},
     *     summary="Membuat rekam medis baru",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id","pasien_id","dokter_id","tanggal_periksa","diagnosa","tindakan","resep_obat"},
     *             @OA\Property(property="pasien_id", type="integer", example=2),
     *             @OA\Property(property="dokter_id", type="integer", example=3),
     *             @OA\Property(property="tanggal_periksa", type="string", format="date", example="2025-05-05"),
     *             @OA\Property(property="diagnosa", type="string", example="Demam Berdarah"),
     *             @OA\Property(property="tindakan", type="string", example="Pemberian infus dan istirahat total"),
     *             @OA\Property(property="resep_obat", type="string", example="Paracetamol, multivitamin")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rekam medis berhasil dibuat"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Kesalahan server"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'pasien_id'         => 'required|integer',
                'dokter_id'         => 'required|integer',
                'tanggal_periksa'   => 'required|date',
                'diagnosa'          => 'required|string',
                'tindakan'          => 'required|string',
                'resep_obat'        => 'required|string'
            ]);

            $RekamMedis = RekamMedis::create($validatedData);

            return response()->json([
                'status' => 201,
                'message' => 'Rekam Medis created successfully.',
                'data' => $RekamMedis,
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
     *     path="/api/RekamMedis/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Menampilkan detail rekam medis berdasarkan ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rekam medis berhasil ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rekam medis tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $RekamMedis = RekamMedis::find($id);

        if (!$RekamMedis) {
            return response()->json([
                'status' => 404,
                'message' => 'Rekam medis not found.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Rekam medis retrieved successfully.',
            'data' => $RekamMedis,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/RekamMedis/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Memperbarui data rekam medis",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id","pasien_id","dokter_id","tanggal_periksa","diagnosa","tindakan","resep_obat"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="pasien_id", type="integer", example=2),
     *             @OA\Property(property="dokter_id", type="integer", example=3),
     *             @OA\Property(property="tanggal_periksa", type="string", format="date", example="2025-05-05"),
     *             @OA\Property(property="diagnosa", type="string", example="Flu Berat"),
     *             @OA\Property(property="tindakan", type="string", example="Rawat jalan dan observasi"),
     *             @OA\Property(property="resep_obat", type="string", example="Obat batuk, vitamin C")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rekam medis berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rekam medis tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $RekamMedis = RekamMedis::find($id);

        if (!$RekamMedis) {
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

        $RekamMedis->update($validatedData);
        $RekamMedis->save();

        return response()->json([
            'message' => 'Rekam Medis updated successfully',
            'RekamMedis' => $RekamMedis
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/RekamMedis/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Menghapus rekam medis berdasarkan ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rekam medis berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rekam medis tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $RekamMedis = RekamMedis::find($id);

        if (!$RekamMedis) {
            return response()->json([
                'status' => 404,
                'message' => 'Rekam medis not found.',
            ], 404);
        }

        $RekamMedis->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Rekam medis deleted successfully.',
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/RekamMedis/search",
     *     tags={"Rekam Medis"},
     *     summary="Mencari rekam medis berdasarkan diagnosa",
     *     description="Endpoint ini digunakan untuk mencari rekam medis berdasarkan diagnosa. Pencarian menggunakan query string, dan mendukung pencarian sebagian kata (LIKE).",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="diagnosa",
     *         in="query",
     *         required=true,
     *         description="Diagnosa yang ingin dicari",
     *         @OA\Schema(type="string", example="demam")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data rekam medis ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Data rekam medis ditemukan."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="pasien_id", type="integer", example=2),
     *                     @OA\Property(property="dokter_id", type="integer", example=3),
     *                     @OA\Property(property="tanggal_periksa", type="string", format="date", example="2025-05-05"),
     *                     @OA\Property(property="diagnosa", type="string", example="Demam Berdarah"),
     *                     @OA\Property(property="tindakan", type="string", example="Pemberian infus"),
     *                     @OA\Property(property="resep_obat", type="string", example="Paracetamol")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tidak ada data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Tidak ada data rekam medis dengan diagnosa tersebut.")
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $diagnosa = $request->query('diagnosa');

        if (!$diagnosa) {
            return response()->json([
                'status' => 400,
                'message' => 'Parameter diagnosa wajib diisi.'
            ], 400);
        }

        $results = RekamMedis::where('diagnosa', 'like', '%' . $diagnosa . '%')->get();

        if ($results->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Tidak ada data rekam medis dengan diagnosa tersebut.'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Data rekam medis ditemukan.',
            'data' => $results
        ], 200);
    }
}