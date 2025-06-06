<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDokter;

class JadwalDokterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jadwal_dokter",
     *     tags={"Jadwal Dokter"},
     *     security={{"bearerAuth":{}}},
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
     *     path="/api/jadwal_dokter",
     *     tags={"Jadwal Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Tambah jadwal dokter baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"dokter_id", "hari", "jam_mulai", "jam_selesai"},
     *             @OA\Property(property="dokter_id", type="integer", example=1),
     *             @OA\Property(property="hari", type="string", example="Senin"),
     *             @OA\Property(property="jam_mulai", type="string", format="time", example="08:00"),
     *             @OA\Property(property="jam_selesai", type="string", format="time", example="12:00")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Jadwal berhasil ditambahkan")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'dokter_id' => 'required|integer|exists:dokters,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal = JadwalDokter::create($data);

        return response()->json($jadwal, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/jadwal_dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     security={{"bearerAuth":{}}},
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
     *     path="/api/jadwal_dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Perbarui jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="dokter_id", type="integer", example=1),
     *             @OA\Property(property="hari", type="string", example="Selasa"),
     *             @OA\Property(property="jam_mulai", type="string", format="time", example="09:00"),
     *             @OA\Property(property="jam_selesai", type="string", format="time", example="13:00")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Jadwal dokter berhasil diperbarui")
     * )
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::findOrFail($id);

        $data = $request->validate([
            'dokter_id' => 'integer|exists:dokters,id',
            'hari' => 'string',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
        ]);

        $jadwal->update($data);

        return response()->json($jadwal);
    }

    /**
     * @OA\Delete(
     *     path="/api/jadwal_dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     security={{"bearerAuth":{}}},
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

    /**
     * @OA\Get(
     *     path="/api/jadwal_dokter_with_dokter",
     *     tags={"Jadwal Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Tampilkan semua jadwal dokter beserta data dokternya",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil menampilkan data jadwal dokter dengan relasi dokter",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data jadwal dokter ditemukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="hari", type="string", example="Senin"),
     *                     @OA\Property(property="jam_mulai", type="string", example="08:00"),
     *                     @OA\Property(property="jam_selesai", type="string", example="12:00"),
     *                     @OA\Property(
     *                         property="dokter",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="nama", type="string", example="dr. Andi"),
     *                         @OA\Property(property="spesialis", type="string", example="Umum"),
     *                         @OA\Property(property="no_telp", type="string", example="08123456789"),
     *                         @OA\Property(property="email", type="string", example="andi@example.com")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAllWithDokter()
    {
        $jadwal_dokters = JadwalDokter::with('dokter:id,nama,spesialis,no_telp,email')->get();

        return response()->json([
            'message' => 'Data jadwal dokter ditemukan',
            'data' => $jadwal_dokters
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/jadwal_dokter_Hari_Ini",
     *     tags={"Jadwal Dokter"},
     *     security={{"bearerAuth":{}}},
     *     summary="Menampilkan daftar dokter yang tersedia berdasarkan hari",
     *     description="Endpoint ini menampilkan daftar dokter yang siap praktik berdasarkan hari. Jika tidak diberikan parameter hari, maka akan menggunakan hari ini.",
     *     @OA\Parameter(
     *         name="hari",
     *         in="query",
     *         required=false,
     *         description="Hari dalam format string (contoh: Senin, Selasa, Rabu, dst). Jika tidak diisi, otomatis ambil hari ini.",
     *         @OA\Schema(type="string", example="Senin")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Daftar dokter tersedia",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="dr. Sinta Dewi"),
     *                 @OA\Property(property="spesialis", type="string", example="Spesialis Anak"),
     *                 @OA\Property(property="hari", type="string", example="Senin")
     *             )
     *         )
     *     )
     * )
     */
    public function getJadwalHariIni(Request $request)
    {
        $hari = $request->query('hari');

        if (!$hari) {
            $hari = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');
        }

        $jadwalHariIni = JadwalDokter::with('dokter')
            ->where('hari', $hari)
            ->get()
            ->map(function ($jadwal) {
                return [
                    'id' => $jadwal->dokter->id,
                    'nama' => $jadwal->dokter->nama,
                    'spesialis' => $jadwal->dokter->spesialis,
                    'hari' => $jadwal->hari
                ];
            });

        if ($jadwalHariIni->isEmpty()) {
            return response()->json([
                'status' => 'tidak tersedia',
                'message' => "Tidak ada dokter yang tersedia pada hari $hari"
            ], 200);
        }

        return response()->json([
            'status' => 'tersedia',
            'message' => "Daftar dokter yang tersedia pada hari $hari",
            'data' => $jadwalHariIni
        ]);
    }

    /**
 * @OA\Get(
 *     path="/api/jadwal_dokter/search",
 *     tags={"Jadwal Dokter"},
 *     summary="Cari jadwal dokter berdasarkan nama dokter (tanpa autentikasi)",
 *     @OA\Parameter(
 *         name="nama",
 *         in="query",
 *         required=true,
 *         description="Nama dokter yang ingin dicari (bisa sebagian)",
 *         @OA\Schema(type="string", example="Andi")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Data jadwal dokter ditemukan"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Data tidak ditemukan"
 *     )
 * )
 */
public function searchByName(Request $request)
{
    $nama = $request->query('nama');

    if (!$nama) {
        return response()->json([
            'status' => 'error',
            'message' => 'Parameter nama wajib diisi'
        ], 400);
    }

    $jadwal = JadwalDokter::whereHas('dokter', function ($query) use ($nama) {
        $query->where('nama', 'like', "%$nama%");
    })->with('dokter')->get();

    if ($jadwal->isEmpty()) {
        return response()->json([
            'status' => 'not found',
            'message' => "Tidak ada jadwal dokter dengan nama mengandung '$nama'"
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'message' => "Jadwal dokter dengan nama '$nama' ditemukan",
        'data' => $jadwal
    ], 200);
}
}
