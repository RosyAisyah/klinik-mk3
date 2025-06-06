<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Payment",
 *     type="object",
 *     title="Payment",
 *     required={"id_pembayaran", "id_pasien", "id_konsultasi", "jumlah_bayar", "metode_bayar", "status_pembayaran"},
 *     @OA\Property(property="id_pembayaran", type="integer", example=1),
 *     @OA\Property(property="id_pasien", type="integer", example=1),
 *     @OA\Property(property="id_konsultasi", type="integer", example=1),
 *     @OA\Property(property="jumlah_bayar", type="number", format="float", example=150000.00),
 *     @OA\Property(property="metode_bayar", type="string", enum={"cash", "transfer", "ewallet"}, example="transfer"),
 *     @OA\Property(property="status_pembayaran", type="string", enum={"pending", "berhasil", "gagal"}, example="pending")
 * )
 */

class PaymentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/payments",
     *     tags={"Payment"},
     *     summary="Get all payments",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Payments retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Payments retrieved successfully."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Payment")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $payments = Payment::all();

        return response()->json([
            'status'  => 200,
            'message' => 'Payments retrieved successfully.',
            'data'    => $payments,
        ], 200);
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
     *             required={"id_pasien", "id_konsultasi", "jumlah_bayar", "metode_bayar", "status_pembayaran"},
     *             @OA\Property(property="id_pasien", type="integer", example=1),
     *             @OA\Property(property="id_konsultasi", type="integer", example=1),
     *             @OA\Property(property="jumlah_bayar", type="number", format="float", example=150000.00),
     *             @OA\Property(property="metode_bayar", type="string", enum={"cash", "transfer", "ewallet"}, example="transfer"),
     *             @OA\Property(property="status_pembayaran", type="string", enum={"pending", "berhasil", "gagal"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Payment created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Payment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pasien'         => 'required|integer|exists:pasiens,id',
            'id_konsultasi'     => 'required|integer|exists:konsultasis,id_konsultasi',
            'jumlah_bayar'      => 'required|numeric|min:0',
            'metode_bayar'      => 'required|string|in:cash,transfer,ewallet',
            'status_pembayaran' => 'required|string|in:pending,berhasil,gagal',
        ]);

        $payment = Payment::create($validated);

        return response()->json([
            'status'  => 201,
            'message' => 'Payment created successfully.',
            'data'    => $payment,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/payments/{id}",
     *     tags={"Payment"},
     *     summary="Get a specific payment by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Payment retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Payment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found"
     *     )
     * )
     */
    public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status'  => 404,
                'message' => 'Payment not found.',
            ], 404);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Payment retrieved successfully.',
            'data'    => $payment,
        ], 200);
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
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_pasien", "id_konsultasi", "jumlah_bayar", "metode_bayar", "status_pembayaran"},
     *             @OA\Property(property="id_pasien", type="integer", example=1),
     *             @OA\Property(property="id_konsultasi", type="integer", example=1),
     *             @OA\Property(property="jumlah_bayar", type="number", format="float", example=150000.00),
     *             @OA\Property(property="metode_bayar", type="string", enum={"cash", "transfer", "ewallet"}, example="transfer"),
     *             @OA\Property(property="status_pembayaran", type="string", enum={"pending", "berhasil", "gagal"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Payment updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Payment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status'  => 404,
                'message' => 'Payment not found.',
            ], 404);
        }

        $validated = $request->validate([
            'id_pasien'         => 'required|integer|exists:pasiens,id',
            'id_konsultasi'     => 'required|integer|exists:konsultasis,id_konsultasi',
            'jumlah_bayar'      => 'required|numeric|min:0',
            'metode_bayar'      => 'required|string|in:cash,transfer,ewallet',
            'status_pembayaran' => 'required|string|in:pending,berhasil,gagal',
        ]);

        $payment->update($validated);

        return response()->json([
            'status'  => 200,
            'message' => 'Payment updated successfully.',
            'data'    => $payment,
        ], 200);
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
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Payment deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status'  => 404,
                'message' => 'Payment not found.',
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Payment deleted successfully.',
        ], 200);
    }
}