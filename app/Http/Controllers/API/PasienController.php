<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pasiens",
     *     summary="Get list of all pasien",
     *     tags={"Pasien"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all pasien",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="nama", type="string"),
     *                     @OA\Property(property="alamat", type="string"),
     *                     @OA\Property(property="jenis_kelamin", type="string"),
     *                     @OA\Property(property="no_telp", type="string"),
     *                     @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *                     @OA\Property(property="email", type="string")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $pasiens = Pasien::all()->map(function ($pasien) {
            return $pasien->makeHidden(['password']);
        });

        return response()->json([
            'status' => 200,
            'message' => 'Pasien retrieved successfully.',
            'data' => $pasiens,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/pasiens",
     *     summary="Create a new pasien",
     *     tags={"Pasien"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "alamat", "jenis_kelamin", "no_telp", "tanggal_lahir", "email", "password"},
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="jenis_kelamin", type="string"),
     *             @OA\Property(property="no_telp", type="string"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Pasien created successfully")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|string|email|max:255|unique:pasiens,email',
            'password' => 'required|string|min:6',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $pasien = Pasien::create($validatedData)->makeHidden(['password']);

        return response()->json([
            'status' => 201,
            'message' => 'Pasien created successfully.',
            'data' => $pasien,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pasiens/{id}",
     *     summary="Get detail of pasien",
     *     tags={"Pasien"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Pasien found"),
     *     @OA\Response(response=404, description="Pasien not found")
     * )
     */
    public function show($id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json([
                'status' => 404,
                'message' => 'Pasien not found.',
            ], 404);
        }

        $pasien->makeHidden(['password']);

        return response()->json([
            'status' => 200,
            'message' => 'Pasien retrieved successfully.',
            'data' => $pasien,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/pasiens/{id}",
     *     summary="Update existing pasien",
     *     tags={"Pasien"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "alamat", "jenis_kelamin", "no_telp", "tanggal_lahir", "email"},
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="jenis_kelamin", type="string"),
     *             @OA\Property(property="no_telp", type="string"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pasien updated successfully"),
     *     @OA\Response(response=404, description="Pasien not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json([
                'status' => 404,
                'message' => 'Pasien not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|string|email|max:255|unique:pasiens,email,' . $id,
            'password' => 'sometimes|string|min:6',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $pasien->update($validatedData);
        $pasien->makeHidden(['password']);

        return response()->json([
            'status' => 200,
            'message' => 'Pasien updated successfully.',
            'data' => $pasien,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/pasiens/{id}",
     *     summary="Delete pasien",
     *     tags={"Pasien"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Pasien deleted successfully"),
     *     @OA\Response(response=404, description="Pasien not found")
     * )
     */
    public function destroy($id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json([
                'status' => 404,
                'message' => 'Pasien not found.',
            ], 404);
        }

        $pasien->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Pasien deleted successfully.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/pasiens/search",
     *     summary="Search pasien by name",
     *     tags={"Pasien"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         required=true,
     *         description="Nama pasien yang ingin dicari",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pasien ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="nama", type="string"),
     *                     @OA\Property(property="alamat", type="string"),
     *                     @OA\Property(property="jenis_kelamin", type="string"),
     *                     @OA\Property(property="no_telp", type="string"),
     *                     @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *                     @OA\Property(property="email", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Pasien tidak ditemukan")
     * )
     */
    public function searchByName(Request $request)
    {
        $nama = $request->query('nama');

        $pasiens = Pasien::where('nama', 'like', '%' . $nama . '%')->get();

        if ($pasiens->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Pasien dengan nama "' . $nama . '" tidak ditemukan.',
            ], 404);
        }

        $pasiens->makeHidden(['password']);

        return response()->json([
            'status' => 200,
            'message' => 'Pasien ditemukan.',
            'data' => $pasiens,
        ]);
    }
}