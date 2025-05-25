<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Laporan",
 *     description="API untuk mengelola laporan bulanan"
 * )
 */
class LaporanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/laporans",
     *     tags={"Laporan"},
     *     summary="Menampilkan semua laporan",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data laporan",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="periode", type="string", example="2025-04-03"),
     *                 @OA\Property(property="jumlah_pasien", type="integer", example=120),
     *                 @OA\Property(property="total_pendapatan", type="number", format="float", example=5000000),
     *                 @OA\Property(property="created_at", type="string", format="date", example="2025-05-03"),
     *                 @OA\Property(property="updated_at", type="string", format="date", example="2025-05-04")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Laporan::all());
    }

    /**
     * @OA\Post(
     *     path="/api/laporans",
     *     tags={"Laporan"},
     *     summary="Membuat laporan baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"periode","jumlah_pasien","total_pendapatan"},
     *             @OA\Property(property="periode", type="string", example="2025-04-03"),
     *             @OA\Property(property="jumlah_pasien", type="integer", example=120),
     *             @OA\Property(property="total_pendapatan", type="number", format="float", example=5000000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Laporan berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=5),
     *             @OA\Property(property="periode", type="string", example="2025-04-03"),
     *             @OA\Property(property="jumlah_pasien", type="integer", example=120),
     *             @OA\Property(property="total_pendapatan", type="number", format="float", example=5000000),
     *             @OA\Property(property="created_at", type="string", format="date", example="2025-05-03"),
     *             @OA\Property(property="updated_at", type="string", format="date", example="2025-05-03")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $laporan = Laporan::create($request->all());
        return response()->json($laporan, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/laporans/{id}",
     *     tags={"Laporan"},
     *     summary="Menampilkan detail laporan berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID laporan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil detail laporan",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="periode", type="string", example="2025-04-03"),
     *             @OA\Property(property="jumlah_pasien", type="integer", example=120),
     *             @OA\Property(property="total_pendapatan", type="number", format="float", example=5000000),
     *             @OA\Property(property="created_at", type="string", format="date", example="2025-05-03"),
     *             @OA\Property(property="updated_at", type="string", format="date", example="2025-05-04")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $laporan = Laporan::find($id);
        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }
        return response()->json($laporan);
    }

    /**
     * @OA\Put(
     *     path="/api/laporans/{id}",
     *     tags={"Laporan"},
     *     summary="Mengupdate laporan berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID laporan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="periode", type="string", example="2025-05-03"),
     *             @OA\Property(property="jumlah_pasien", type="integer", example=135),
     *             @OA\Property(property="total_pendapatan", type="number", format="float", example=7500000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Laporan berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="periode", type="string", example="2025-05-03"),
     *             @OA\Property(property="jumlah_pasien", type="integer", example=135),
     *             @OA\Property(property="total_pendapatan", type="number", format="float", example=7500000),
     *             @OA\Property(property="created_at", type="string", format="date", example="2025-05-03"),
     *             @OA\Property(property="updated_at", type="string", format="date", example="2025-05-04")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $laporan = Laporan::find($id);
        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        $laporan->update($request->all());
        return response()->json($laporan);
    }

    /**
     * @OA\Delete(
     *     path="/api/laporans/{id}",
     *     tags={"Laporan"},
     *     summary="Menghapus laporan berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID laporan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Laporan berhasil dihapus"),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $laporan = Laporan::find($id);
        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        $laporan->delete();
        return response()->json(null, 204);
    }
}
