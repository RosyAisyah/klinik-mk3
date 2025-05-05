<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

/**
 * @OA\Info(
 *     title="API Pasien",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk mengelola data pasien."
 * )
 */
class PasienController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pasiens",
     *     summar y="Get list of all pasien",
     *     tags={"Pasien"},
     *     @OA\Response(
     *         response=200,
     *         description="List of pasien",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="nama", type="string"),
     *                 @OA\Property(property="alamat", type="string"),
     *                 @OA\Property(property="jenis_kelamin", type="string"),
     *                 @OA\Property(property="no_telp", type="integer"),
     *                 @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="password", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $pasiens = Pasien::all();

        return response()->json([
            'status' => 200,
            'message' => 'Pasien retrieved successfully.',
            'data' => $pasiens,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pasiens",
     *     summary="Create a new pasien",
     *     tags={"Pasien"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "nama", "alamat", "jenis_kelamin", "no_telp", "tanggal_lahir", "email", "password"},
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="jenis_kelamin", type="string", enum={"Laki-laki", "Perempuan"}),
     *             @OA\Property(property="no_telp", type="integer"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pasien created successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|integer',
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'jenis_kelamin' => 'in:Laki-laki,Perempuan',
                'no_telp' => 'required|integer',
                'tanggal_lahir' => 'required|date',
                'email' => 'required|string|max:255',
                'password' => 'required|string'
            ]);

            $pasiens = Pasien::create($validatedData);

            return response()->json([
                'status' => 201,
                'message' => 'Pasien created successfully.',
                'data' => $pasiens,
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
     *     path="/api/pasiens/{id}",
     *     summary="Get single pasien by ID",
     *     tags={"Pasien"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the pasien",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pasien data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="jenis_kelamin", type="string"),
     *             @OA\Property(property="no_telp", type="integer"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pasien not found"
     *     )
     * )
     */
    public function show(Pasien $pasiens)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Pasien retrieved successfully.',
            'data' => $pasiens,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/pasiens/{id}",
     *     summary="Update pasien data",
     *     tags={"Pasien"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the pasien",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "nama", "alamat", "jenis_kelamin", "no_telp", "tanggal_lahir", "email", "password"},
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="jenis_kelamin", type="string", enum={"Laki-laki", "Perempuan"}),
     *             @OA\Property(property="no_telp", type="integer"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pasien updated successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pasien not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $pasiens = Pasien::find($id);

        if (!$pasiens) {
            return response()->json([
                'message' => 'Pasien not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'in:Laki-laki,Perempuan',
            'no_telp' => 'required|integer',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|string|max:255',
            'password' => 'required|string'
        ]);

        $pasiens->update($validatedData);
        $pasiens->save();

        return response()->json([
            'message' => 'Pasien updated successfully',
            'pasien' => $pasiens
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/pasiens/{id}",
     *     summary="Delete a pasien",
     *     tags={"Pasien"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the pasien",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pasien deleted successfully."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pasien not found"
     *     )
     * )
     */
    public function destroy(Pasien $pasiens)
    {
        $pasiens->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Pasien deleted successfully.',
            'data' => null,
        ], 200);
    }
}
