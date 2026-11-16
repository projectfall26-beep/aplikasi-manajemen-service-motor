<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KendaraanApiController extends Controller
{
    /**
     * GET /api/kendaraan
     */
    public function index()
    {
        $kendaraans = Kendaraan::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar data kendaraan berhasil diambil',
            'data' => $kendaraans,
        ], 200);
    }

    /**
     * POST /api/kendaraan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_plat' => 'required|string|max:20|unique:kendaraans,no_plat',
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk' => 'required|string|max:50',
            'tahun_pembuatan' => 'required|digits:4|integer',
            'nama_pemilik' => 'required|string|max:255',
            'warna' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kendaraan = Kendaraan::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data kendaraan berhasil ditambahkan',
            'data' => $kendaraan,
        ], 201);
    }

    /**
     * GET /api/kendaraan/{id}
     */
    public function show($id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'status' => false,
                'message' => 'Data kendaraan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data kendaraan ditemukan',
            'data' => $kendaraan,
        ], 200);
    }

    /**
     * PUT/PATCH /api/kendaraan/{id}
     */
    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'status' => false,
                'message' => 'Data kendaraan tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'no_plat' => ['required', 'string', 'max:20', Rule::unique('kendaraans')->ignore($kendaraan->id)],
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk' => 'required|string|max:50',
            'tahun_pembuatan' => 'required|digits:4|integer',
            'nama_pemilik' => 'required|string|max:255',
            'warna' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kendaraan->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data kendaraan berhasil diperbarui',
            'data' => $kendaraan,
        ], 200);
    }

    /**
     * DELETE /api/kendaraan/{id}
     */
    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'status' => false,
                'message' => 'Data kendaraan tidak ditemukan',
            ], 404);
        }

        $kendaraan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data kendaraan berhasil dihapus',
        ], 200);
    }
}
