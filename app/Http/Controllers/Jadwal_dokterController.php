<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalDokter;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Jadwal Dokter",
 *      description="Dokumentasi Swagger untuk Jadwal Dokter"
 * )
 */
class Jadwal_dokterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jadwal-dokter",
     *     tags={"Jadwal Dokter"},
     *     summary="Tampilkan semua jadwal dokter",
     *     @OA\Response(response="200", description="Berhasil menampilkan semua jadwal dokter")
     * )
     */
    public function index()
    {
        return response()->json(JadwalDokter::all());
    }

    /**
     * @OA\Post(
     *     path="/api/jadwal-dokter",
     *     tags={"Jadwal Dokter"},
     *     summary="Tambah jadwal dokter baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ID_Dokter", "Hari", "Jam_Mulai", "Jam_Selesai"},
     *             @OA\Property(property="ID_Dokter", type="integer"),
     *             @OA\Property(property="Hari", type="string"),
     *             @OA\Property(property="Jam_Mulai", type="string", format="time"),
     *             @OA\Property(property="Jam_Selesai", type="string", format="time")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Jadwal berhasil ditambahkan")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ID_Dokter' => 'required|integer|exists:dokters,ID_Dokter',
            'Hari' => 'required|string',
            'Jam_Mulai' => 'required',
            'Jam_Selesai' => 'required',
        ]);

        $jadwal = JadwalDokter::create($data);

        return response()->json($jadwal, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     summary="Tampilkan jadwal dokter berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Berhasil menampilkan jadwal dokter")
     * )
     */
    public function show($id)
    {
        return response()->json(JadwalDokter::findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     summary="Perbarui jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="ID_Dokter", type="integer"),
     *             @OA\Property(property="Hari", type="string"),
     *             @OA\Property(property="Jam_Mulai", type="string", format="time"),
     *             @OA\Property(property="Jam_Selesai", type="string", format="time")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Jadwal dokter berhasil diperbarui")
     * )
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::findOrFail($id);

        $data = $request->validate([
            'ID_Dokter' => 'integer|exists:dokters,ID_Dokter',
            'Hari' => 'string',
            'Jam_Mulai' => '',
            'Jam_Selesai' => '',
        ]);

        $jadwal->update($data);

        return response()->json($jadwal);
    }

    /**
     * @OA\Delete(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     summary="Hapus jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Jadwal dokter berhasil dihapus")
     * )
     */
    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->delete();

        return response()->json(null, 204);
    }
}

