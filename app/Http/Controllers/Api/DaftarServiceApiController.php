<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DaftarServiceApiController extends Controller
{
    /**
     * GET /api/daftar-service
     */
    public function index(Request $request)
    {
        if (str_contains($request->header('Accept', ''), 'text/html')) {
            return redirect()->route('daftar-service.index');
        }

        $daftarServices = DaftarService::with(['pelanggan', 'kendaraan', 'dataService.pembayaran'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar data registrasi servis berhasil diambil',
            'data' => $daftarServices,
        ], 200);
    }

    /**
     * POST /api/daftar-service
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'keluhan' => 'required|string',
            'tanggal_servis' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $daftarService = DaftarService::create($validator->validated());
        $daftarService->load(['pelanggan', 'kendaraan']);

        return response()->json([
            'status' => true,
            'message' => 'Data registrasi servis berhasil ditambahkan',
            'data' => $daftarService,
        ], 201);
    }

    /**
     * GET /api/daftar-service/{id}
     */
    public function show($id)
    {
        $daftarService = DaftarService::with(['pelanggan', 'kendaraan', 'dataService'])->find($id);

        if (!$daftarService) {
            return response()->json([
                'status' => false,
                'message' => 'Data registrasi servis tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data registrasi servis ditemukan',
            'data' => $daftarService,
        ], 200);
    }

    /**
     * PUT/PATCH /api/daftar-service/{id}
     */
    public function update(Request $request, $id)
    {
        $daftarService = DaftarService::find($id);

        if (!$daftarService) {
            return response()->json([
                'status' => false,
                'message' => 'Data registrasi servis tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'keluhan' => 'required|string',
            'tanggal_servis' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $daftarService->update($validator->validated());
        $daftarService->load(['pelanggan', 'kendaraan']);

        return response()->json([
            'status' => true,
            'message' => 'Data registrasi servis berhasil diperbarui',
            'data' => $daftarService,
        ], 200);
    }

    /**
     * DELETE /api/daftar-service/{id}
     */
    public function destroy($id)
    {
        $daftarService = DaftarService::find($id);

        if (!$daftarService) {
            return response()->json([
                'status' => false,
                'message' => 'Data registrasi servis tidak ditemukan',
            ], 404);
        }

        $daftarService->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data registrasi servis berhasil dihapus',
        ], 200);
    }
}
