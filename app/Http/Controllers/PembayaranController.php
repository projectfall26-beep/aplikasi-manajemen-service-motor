<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\DataService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Tampilkan data transaksi pembayaran servis
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pembayarans = Pembayaran::with(['dataService.daftarService.pelanggan', 'dataService.daftarService.kendaraan'])
            ->when($search, function ($query, $search) {
                return $query->where('jenis_pembayaran', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhere('jumlah_biaya', 'like', "%{$search}%")
                    ->orWhereHas('dataService.daftarService.pelanggan', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dataService.daftarService.kendaraan', function ($q) use ($search) {
                        $q->where('no_plat', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pembayaran.index', compact('pembayarans', 'search'));
    }

    /**
     * Form tambah transaksi pembayaran
     */
    public function create()
    {
        $dataServices = DataService::with(['daftarService.pelanggan', 'daftarService.kendaraan'])->latest()->get();

        return view('pembayaran.create', compact('dataServices'));
    }

    /**
     * Simpan transaksi pembayaran
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_service_id' => 'required|exists:data_services,id',
            'jumlah_biaya' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash/Tunai,Non Tunai',
            'keterangan' => 'nullable|string',
        ], [
            'data_service_id.required' => 'Pilih ID Servis dari Data Service.',
            'data_service_id.exists' => 'Data pengerjaan servis tidak ditemukan.',
            'jumlah_biaya.required' => 'Jumlah biaya servis wajib diisi.',
            'jumlah_biaya.numeric' => 'Jumlah biaya harus berupa angka.',
            'jumlah_biaya.min' => 'Jumlah biaya tidak boleh negatif.',
            'jenis_pembayaran.required' => 'Pilih salah satu jenis pembayaran (Cash/Tunai atau Non Tunai).',
        ]);

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Transaksi pembayaran servis berhasil dicatat!');
    }

    /**
     * Form edit transaksi pembayaran
     */
    public function edit(Pembayaran $pembayaran)
    {
        $dataServices = DataService::with(['daftarService.pelanggan', 'daftarService.kendaraan'])->latest()->get();

        return view('pembayaran.edit', compact('pembayaran', 'dataServices'));
    }

    /**
     * Update transaksi pembayaran
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'data_service_id' => 'required|exists:data_services,id',
            'jumlah_biaya' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash/Tunai,Non Tunai',
            'keterangan' => 'nullable|string',
        ], [
            'data_service_id.required' => 'Pilih ID Servis dari Data Service.',
            'data_service_id.exists' => 'Data pengerjaan servis tidak ditemukan.',
            'jumlah_biaya.required' => 'Jumlah biaya servis wajib diisi.',
            'jumlah_biaya.numeric' => 'Jumlah biaya harus berupa angka.',
            'jumlah_biaya.min' => 'Jumlah biaya tidak boleh negatif.',
            'jenis_pembayaran.required' => 'Pilih jenis pembayaran.',
        ]);

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Transaksi pembayaran berhasil diperbarui!');
    }

    /**
     * Hapus transaksi pembayaran
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Data transaksi pembayaran berhasil dihapus!');
    }
}
