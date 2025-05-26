<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekam_medis;

/**
 * @OA\Tag(
 *     name="Rekam Medis",
 *     description="API untuk mengelola data rekam medis"
 * )
 */
class Rekam_medisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rekam_mediss",
     *     tags={"Rekam Medis"},
     *     summary="Menampilkan semua data rekam medis",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar rekam medis berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $rekam_mediss = Rekam_medis::all();

        return response()->json([
            'status' => 200,
            'message' => 'Rekam Medis retrieved successfully.',
            'data' => $rekam_mediss,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/rekam_mediss",
     *     tags={"Rekam Medis"},
     *     summary="Membuat rekam medis baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id","pasien_id","dokter_id","tanggal_periksa","diagnosa","tindakan","resep_obat"},
     *             @OA\Property(property="id", type="integer", example=1),
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/rekam_mediss/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Menampilkan detail rekam medis berdasarkan ID",
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
    public function show(Rekam_medis $rekam_mediss)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Rekam Medis retrieved successfully.',
            'data' => $rekam_mediss,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/rekam_mediss/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Memperbarui data rekam medis",
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

    /**
     * @OA\Delete(
     *     path="/api/rekam_mediss/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Menghapus rekam medis berdasarkan ID",
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
    public function destroy(Rekam_medis $rekam_mediss)
    {
        $rekam_mediss->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Rekam Medis deleted successfully.',
            'data' => null,
        ], 200);
    }
        /**
     * @OA\Get(
     *     path="/api/rekam_mediss/search",
     *     tags={"Rekam Medis"},
     *     summary="Mencari rekam medis berdasarkan diagnosa",
     *     @OA\Parameter(
     *         name="diagnosa",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hasil pencarian rekam medis"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tidak ada data ditemukan"
     *     )
     * )
     */
    public function search(Request $request)
    {
        $diagnosa = $request->query('diagnosa');

        $results = Rekam_medis::where('diagnosa', 'like', '%' . $diagnosa . '%')->get();

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
