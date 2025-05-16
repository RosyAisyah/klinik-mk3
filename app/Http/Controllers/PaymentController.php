<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Payment",
 *     description="API untuk manajemen data pembayaran konsultasi"
 * )
 */
class PaymentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/payment",
     *     tags={"Payment"},
     *     summary="Ambil semua data pembayaran",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar payment berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $payments = Payment::all();

        return response()->json([
            'status'  => 200,
            'message' => 'Payment retrieved successfully.',
            'data'    => $payments,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/payment",
     *     tags={"Payment"},
     *     summary="Buat pembayaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"konsultasi_id","jumlah_bayar","metode_bayar","status_pembayaran"},
     *             @OA\Property(property="konsultasi_id",   type="integer", example=3),
     *             @OA\Property(property="jumlah_bayar",    type="number",  format="float", example=150000),
     *             @OA\Property(property="metode_bayar",    type="string",  enum={"cash","transfer","ewallet"}, example="transfer"),
     *             @OA\Property(property="status_pembayaran", type="string", enum={"pending","berhasil","gagal"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment berhasil dibuat"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'konsultasi_id'    => 'required|integer|exists:konsultasis,id',
            'jumlah_bayar'     => 'required|numeric|min:0',
            'metode_bayar'     => 'required|string|in:cash,transfer,ewallet',
            'status_pembayaran'=> 'required|string|in:pending,berhasil,gagal',
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
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
     *     summary="Ambil pembayaran berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment tidak ditemukan"
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
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
     *     summary="Perbarui pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"konsultasi_id","jumlah_bayar","metode_bayar","status_pembayaran"},
     *             @OA\Property(property="konsultasi_id",   type="integer", example=3),
     *             @OA\Property(property="jumlah_bayar",    type="number",  format="float", example=175000),
     *             @OA\Property(property="metode_bayar",    type="string",  enum={"cash","transfer","ewallet"}, example="ewallet"),
     *             @OA\Property(property="status_pembayaran", type="string", enum={"pending","berhasil","gagal"}, example="berhasil")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment tidak ditemukan"
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
            'konsultasi_id'    => 'required|integer|exists:konsultasis,id',
            'jumlah_bayar'     => 'required|numeric|min:0',
            'metode_bayar'     => 'required|string|in:cash,transfer,ewallet',
            'status_pembayaran'=> 'required|string|in:pending,berhasil,gagal',
        ]);

        $payment->update($validated);

        return response()->json([
            'status'  => 200,
            'message' => 'Payment updated successfully.',
            'data'    => $payment,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
     *     summary="Hapus pembayaran berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment tidak ditemukan"
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
        ]);
    }
}
