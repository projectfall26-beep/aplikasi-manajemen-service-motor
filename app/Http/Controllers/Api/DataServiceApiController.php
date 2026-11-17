<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataServiceApiController extends Controller
{
    /**
     * GET /api/data-service
     */
    public function index(Request $request)
    {
        if (str_contains($request->header('Accept', ''), 'text/html')) {
            return redirect()->route('data-service.index');
        }

        $dataServices = DataService::with(['daftarService.pelanggan', 'daftarService.kendaraan', 'pembayaran'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar data pengerjaan servis mekanik berhasil diambil',
            'data' => $dataServices,
        ], 200);
    }

    /**
     * POST /api/data-service
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'daftar_service_id' => 'required|exists:daftar_services,id',
            'estimasi_service' => 'required|string|max:100',
            'nama_mekanik' => 'required|string|max:100',
            'sparepart_pengganti' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $dataService = DataService::create($validator->validated());
        $dataService->load(['daftarService.pelanggan', 'daftarService.kendaraan']);

        return response()->json([
            'status' => true,
            'message' => 'Data pengerjaan servis mekanik berhasil ditambahkan',
            'data' => $dataService,
        ], 201);
    }

    /**
     * GET /api/data-service/{id}
     */
    public function show($id)
    {
        $dataService = DataService::with(['daftarService.pelanggan', 'daftarService.kendaraan', 'pembayaran'])->find($id);

        if (!$dataService) {
            return response()->json([
                'status' => false,
                'message' => 'Data pengerjaan servis mekanik tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data pengerjaan servis mekanik ditemukan',
            'data' => $dataService,
        ], 200);
    }

    /**
     * PUT/PATCH /api/data-service/{id}
     */
    public function update(Request $request, $id)
    {
        $dataService = DataService::find($id);

        if (!$dataService) {
            return response()->json([
                'status' => false,
                'message' => 'Data pengerjaan servis mekanik tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'daftar_service_id' => 'required|exists:daftar_services,id',
            'estimasi_service' => 'required|string|max:100',
            'nama_mekanik' => 'required|string|max:100',
            'sparepart_pengganti' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $dataService->update($validator->validated());
        $dataService->load(['daftarService.pelanggan', 'daftarService.kendaraan']);

        return response()->json([
            'status' => true,
            'message' => 'Data pengerjaan servis mekanik berhasil diperbarui',
            'data' => $dataService,
        ], 200);
    }

    /**
     * DELETE /api/data-service/{id}
     */
    public function destroy($id)
    {
        $dataService = DataService::find($id);

        if (!$dataService) {
            return response()->json([
                'status' => false,
                'message' => 'Data pengerjaan servis mekanik tidak ditemukan',
            ], 404);
        }

        $dataService->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data pengerjaan servis mekanik berhasil dihapus',
        ], 200);
    }
}
