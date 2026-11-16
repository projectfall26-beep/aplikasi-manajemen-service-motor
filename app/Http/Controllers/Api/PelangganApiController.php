<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganApiController extends Controller
{
    /**
     * GET /api/pelanggan
     * Mengambil seluruh data pelanggan
     */
    public function index()
    {
        $pelanggans = Pelanggan::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar data pelanggan berhasil diambil',
            'data' => $pelanggans,
        ], 200);
    }

    /**
     * POST /api/pelanggan
     * Menambahkan data pelanggan baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|regex:/^[0-9+ -]{8,20}$/',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pelanggan = Pelanggan::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data pelanggan berhasil ditambahkan',
            'data' => $pelanggan,
        ], 201);
    }

    /**
     * GET /api/pelanggan/{id}
     * Mengambil detail pelanggan berdasarkan ID
     */
    public function show($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'status' => false,
                'message' => 'Data pelanggan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data pelanggan ditemukan',
            'data' => $pelanggan,
        ], 200);
    }

    /**
     * PUT/PATCH /api/pelanggan/{id}
     * Memperbarui data pelanggan
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'status' => false,
                'message' => 'Data pelanggan tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|regex:/^[0-9+ -]{8,20}$/',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pelanggan->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data pelanggan berhasil diperbarui',
            'data' => $pelanggan,
        ], 200);
    }

    /**
     * DELETE /api/pelanggan/{id}
     * Menghapus data pelanggan
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'status' => false,
                'message' => 'Data pelanggan tidak ditemukan',
            ], 404);
        }

        $pelanggan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data pelanggan berhasil dihapus',
        ], 200);
    }
}
