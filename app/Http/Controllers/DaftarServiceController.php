<?php

namespace App\Http\Controllers;

use App\Models\DaftarService;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class DaftarServiceController extends Controller
{
    /**
     * Tampilkan riwayat pendaftaran servis
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $daftarServices = DaftarService::with(['pelanggan', 'kendaraan', 'dataService'])
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                    ->orWhere('keluhan', 'like', "%{$search}%")
                    ->orWhere('tanggal_servis', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kendaraan', function ($q) use ($search) {
                        $q->where('no_plat', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('daftar_service.index', compact('daftarServices', 'search'));
    }

    /**
     * Form pendaftaran servis baru
     */
    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama_lengkap')->get();
        $kendaraans = Kendaraan::orderBy('no_plat')->get();

        return view('daftar_service.create', compact('pelanggans', 'kendaraans'));
    }

    /**
     * Simpan pendaftaran servis baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'keluhan' => 'required|string',
            'tanggal_servis' => 'required|date',
        ], [
            'pelanggan_id.required' => 'Pilih ID / Nama Pelanggan.',
            'pelanggan_id.exists' => 'Data pelanggan tidak ditemukan.',
            'kendaraan_id.required' => 'Pilih Nomor Plat Kendaraan.',
            'kendaraan_id.exists' => 'Data kendaraan tidak ditemukan.',
            'keluhan.required' => 'Keluhan kendaraan wajib diisi.',
            'tanggal_servis.required' => 'Tanggal servis wajib diisi.',
        ]);

        DaftarService::create($validated);

        return redirect()->route('daftar-service.index')->with('success', 'Pendaftaran servis baru berhasil disimpan!');
    }

    /**
     * Form edit pendaftaran servis
     */
    public function edit(DaftarService $daftarService)
    {
        $pelanggans = Pelanggan::orderBy('nama_lengkap')->get();
        $kendaraans = Kendaraan::orderBy('no_plat')->get();

        return view('daftar_service.edit', compact('daftarService', 'pelanggans', 'kendaraans'));
    }

    /**
     * Update pendaftaran servis
     */
    public function update(Request $request, DaftarService $daftarService)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'keluhan' => 'required|string',
            'tanggal_servis' => 'required|date',
        ], [
            'pelanggan_id.required' => 'Pilih ID / Nama Pelanggan.',
            'pelanggan_id.exists' => 'Data pelanggan tidak ditemukan.',
            'kendaraan_id.required' => 'Pilih Nomor Plat Kendaraan.',
            'kendaraan_id.exists' => 'Data kendaraan tidak ditemukan.',
            'keluhan.required' => 'Keluhan kendaraan wajib diisi.',
            'tanggal_servis.required' => 'Tanggal servis wajib diisi.',
        ]);

        $daftarService->update($validated);

        return redirect()->route('daftar-service.index')->with('success', 'Data pendaftaran servis berhasil diperbarui!');
    }

    /**
     * Hapus pendaftaran servis
     */
    public function destroy(DaftarService $daftarService)
    {
        $daftarService->delete();

        return redirect()->route('daftar-service.index')->with('success', 'Pendaftaran servis berhasil dihapus!');
    }
}
