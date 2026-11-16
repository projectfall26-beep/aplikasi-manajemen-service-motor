<?php

namespace App\Http\Controllers;

use App\Models\DataService;
use App\Models\DaftarService;
use Illuminate\Http\Request;

class DataServiceController extends Controller
{
    /**
     * Tampilkan data pengerjaan service bengkel
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $dataServices = DataService::with(['daftarService.pelanggan', 'daftarService.kendaraan', 'pembayaran'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_mekanik', 'like', "%{$search}%")
                    ->orWhere('estimasi_service', 'like', "%{$search}%")
                    ->orWhere('sparepart_pengganti', 'like', "%{$search}%")
                    ->orWhere('daftar_service_id', 'like', "%{$search}%")
                    ->orWhereHas('daftarService.kendaraan', function ($q) use ($search) {
                        $q->where('no_plat', 'like', "%{$search}%");
                    })
                    ->orWhereHas('daftarService.pelanggan', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('data_service.index', compact('dataServices', 'search'));
    }

    /**
     * Form tambah pengerjaan service baru
     */
    public function create()
    {
        // Ambil daftar service yang aktif beserta relasi pelanggan dan kendaraan
        $daftarServices = DaftarService::with(['pelanggan', 'kendaraan'])->latest()->get();

        return view('data_service.create', compact('daftarServices'));
    }

    /**
     * Simpan pengerjaan service baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'daftar_service_id' => 'required|exists:daftar_services,id',
            'estimasi_service' => 'required|string|max:100',
            'nama_mekanik' => 'required|string|max:100',
            'sparepart_pengganti' => 'nullable|string',
        ], [
            'daftar_service_id.required' => 'Pilih ID Servis Pelanggan.',
            'daftar_service_id.exists' => 'Data pendaftaran servis tidak ditemukan.',
            'estimasi_service.required' => 'Estimasi service wajib diisi.',
            'nama_mekanik.required' => 'Nama mekanik wajib diisi.',
        ]);

        DataService::create($validated);

        return redirect()->route('data-service.index')->with('success', 'Data pengerjaan servis mekanik berhasil disimpan!');
    }

    /**
     * Form edit pengerjaan service
     */
    public function edit(DataService $dataService)
    {
        $daftarServices = DaftarService::with(['pelanggan', 'kendaraan'])->latest()->get();

        return view('data_service.edit', compact('dataService', 'daftarServices'));
    }

    /**
     * Update data pengerjaan service
     */
    public function update(Request $request, DataService $dataService)
    {
        $validated = $request->validate([
            'daftar_service_id' => 'required|exists:daftar_services,id',
            'estimasi_service' => 'required|string|max:100',
            'nama_mekanik' => 'required|string|max:100',
            'sparepart_pengganti' => 'nullable|string',
        ], [
            'daftar_service_id.required' => 'Pilih ID Servis Pelanggan.',
            'daftar_service_id.exists' => 'Data pendaftaran servis tidak ditemukan.',
            'estimasi_service.required' => 'Estimasi service wajib diisi.',
            'nama_mekanik.required' => 'Nama mekanik wajib diisi.',
        ]);

        $dataService->update($validated);

        return redirect()->route('data-service.index')->with('success', 'Data servis mekanik berhasil diperbarui!');
    }

    /**
     * Hapus data pengerjaan service
     */
    public function destroy(DataService $dataService)
    {
        $dataService->delete();

        return redirect()->route('data-service.index')->with('success', 'Data servis berhasil dihapus!');
    }
}
