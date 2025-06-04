<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;


/**
 * @OA\Info(
 *     title="API Klinik",
 *     version="1.0.0"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

/**
 * @OA\Tag(
 *     name="Payment",
 *     description="API untuk mengelola pembayaran konsultasi"
 * )
 */
class PaymentController extends Controller
{
    public function __construct()
{
    \Illuminate\Support\Facades\Route::middleware('auth:sanctum');
}


    /**
     * @OA\Get(
     *     path="/api/payments",
     *     tags={"Payment"},
     *     summary="Get all payments for the authenticated patient",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Payment retrieved successfully"
     *     )
     * )
     */
    public function index()
    {
        $pasien = auth()->user();
        $payments = Payment::where('id_pasien', $pasien->id)->get();

        return response()->json([
            'status'  => 200,
            'message' => 'Payment retrieved successfully.',
            'data'    => $payments,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/payments",
     *     tags={"Payment"},
     *     summary="Create a new payment",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_konsultasi", "jumlah_bayar", "metode_bayar", "status_pembayaran"},
     *             @OA\Property(property="id_konsultasi", type="integer"),
     *             @OA\Property(property="jumlah_bayar", type="number", format="float"),
     *             @OA\Property(property="metode_bayar", type="string", enum={"cash", "transfer", "ewallet"}),
     *             @OA\Property(property="status_pembayaran", type="string", enum={"pending", "berhasil", "gagal"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_konsultasi'    => 'required|integer|exists:konsultasis,id_konsultasi',
            'jumlah_bayar'     => 'required|numeric|min:0',
            'metode_bayar'     => 'required|string|in:cash,transfer,ewallet',
            'status_pembayaran'=> 'required|string|in:pending,berhasil,gagal',
        ]);

        $pasien = auth()->user();

        $payments = Payment::create([
            'id_pasien'         => $pasien->id,
            'id_konsultasi'     => $validated['id_konsultasi'],
            'jumlah_bayar'      => $validated['jumlah_bayar'],
            'metode_bayar'      => $validated['metode_bayar'],
            'status_pembayaran' => $validated['status_pembayaran'],
        ]);

        return response()->json([
            'status'  => 201,
            'message' => 'Payment created successfully.',
            'data'    => $payments,
        ], 201);

        return response()->json(['message' => 'masuk ke store'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/payments/{id}",
     *     tags={"Payment"},
     *     summary="Get a specific payment by ID for the authenticated patient",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found"
     *     )
     * )
     */
    public function show($id)
    {
        $pasien = auth()->user();
        $payments = Payment::where('id', $id)->where('id_pasien', $pasien->id)->first();

        if (!$payments) {
            return response()->json([
                'status'  => 404,
                'message' => 'Payment not found.',
            ], 404);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Payment retrieved successfully.',
            'data'    => $payments,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/payments/{id}",
     *     tags={"Payment"},
     *     summary="Update an existing payment by ID",
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
     *             required={"id_konsultasi", "jumlah_bayar", "metode_bayar", "status_pembayaran"},
     *             @OA\Property(property="id_konsultasi", type="integer"),
     *             @OA\Property(property="jumlah_bayar", type="number", format="float"),
     *             @OA\Property(property="metode_bayar", type="string", enum={"cash", "transfer", "ewallet"}),
     *             @OA\Property(property="status_pembayaran", type="string", enum={"pending", "berhasil", "gagal"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $pasien = auth()->user();
        $payments = Payment::where('id', $id)->where('id_pasien', $pasien->id)->first();

        if (!$payments) {
            return response()->json([
                'status'  => 404,
                'message' => 'Payment not found.',
            ], 404);
        }

        $validated = $request->validate([
            'id_konsultasi'    => 'required|integer|exists:konsultasis,id_konsultasi',
            'jumlah_bayar'     => 'required|numeric|min:0',
            'metode_bayar'     => 'required|string|in:cash,transfer,ewallet',
            'status_pembayaran'=> 'required|string|in:pending,berhasil,gagal',
        ]);

        $payments->update($validated);

        return response()->json([
            'status'  => 200,
            'message' => 'Payment updated successfully.',
            'data'    => $payments,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/payments/{id}",
     *     tags={"Payment"},
     *     summary="Delete a payment by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $pasien = auth()->user();
        $payments = Payment::where('id', $id)->where('id_pasien', $pasien->id)->first();

        if (!$payments) {
            return response()->json([
                'status'  => 404,
                'message' => 'Payment not found.',
            ], 404);
        }

        $payments->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Payment deleted successfully.',
        ]);
    }
}
