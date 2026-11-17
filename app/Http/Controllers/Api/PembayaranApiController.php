<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembayaranApiController extends Controller
{
    /**
     * GET /api/pembayaran
     */
    public function index(Request $request)
    {
        if (str_contains($request->header('Accept', ''), 'text/html')) {
            return redirect()->route('pembayaran.index');
        }

        $pembayarans = Pembayaran::with(['dataService.daftarService.pelanggan', 'dataService.daftarService.kendaraan'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar transaksi pembayaran berhasil diambil',
            'data' => $pembayarans,
        ], 200);
    }

    /**
     * POST /api/pembayaran
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data_service_id' => 'required|exists:data_services,id',
            'jumlah_biaya' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash/Tunai,Non Tunai',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pembayaran = Pembayaran::create($validator->validated());
        $pembayaran->load(['dataService.daftarService.pelanggan', 'dataService.daftarService.kendaraan']);

        return response()->json([
            'status' => true,
            'message' => 'Transaksi pembayaran berhasil dicatat',
            'data' => $pembayaran,
        ], 201);
    }

    /**
     * GET /api/pembayaran/{id}
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['dataService.daftarService.pelanggan', 'dataService.daftarService.kendaraan'])->find($id);

        if (!$pembayaran) {
            return response()->json([
                'status' => false,
                'message' => 'Data pembayaran tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data pembayaran ditemukan',
            'data' => $pembayaran,
        ], 200);
    }

    /**
     * PUT/PATCH /api/pembayaran/{id}
     */
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json([
                'status' => false,
                'message' => 'Data pembayaran tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'data_service_id' => 'required|exists:data_services,id',
            'jumlah_biaya' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash/Tunai,Non Tunai',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pembayaran->update($validator->validated());
        $pembayaran->load(['dataService.daftarService.pelanggan', 'dataService.daftarService.kendaraan']);

        return response()->json([
            'status' => true,
            'message' => 'Data pembayaran berhasil diperbarui',
            'data' => $pembayaran,
        ], 200);
    }

    /**
     * DELETE /api/pembayaran/{id}
     */
    public function destroy($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json([
                'status' => false,
                'message' => 'Data pembayaran tidak ditemukan',
            ], 404);
        }

        $pembayaran->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data pembayaran berhasil dihapus',
        ], 200);
    }
}
