<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KendaraanController extends Controller
{
    /**
     * Tampilkan data kendaraan dengan pencarian dan pagination
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kendaraans = Kendaraan::when($search, function ($query, $search) {
                return $query->where('no_plat', 'like', "%{$search}%")
                             ->orWhere('nama_pemilik', 'like', "%{$search}%")
                             ->orWhere('jenis_kendaraan', 'like', "%{$search}%")
                             ->orWhere('no_stnk', 'like', "%{$search}%")
                             ->orWhere('warna', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kendaraan.index', compact('kendaraans', 'search'));
    }

    /**
     * Form tambah kendaraan
     */
    public function create()
    {
        return view('kendaraan.create');
    }

    /**
     * Simpan data kendaraan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_plat' => 'required|string|max:20|unique:kendaraans,no_plat',
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk' => 'required|string|max:50',
            'tahun_pembuatan' => 'required|digits:4|integer|min:1980|max:'.(date('Y') + 1),
            'nama_pemilik' => 'required|string|max:255',
            'warna' => 'required|string|max:50',
        ], [
            'no_plat.required' => 'Nomor plat kendaraan wajib diisi.',
            'no_plat.unique' => 'Nomor plat sudah terdaftar dalam sistem.',
            'jenis_kendaraan.required' => 'Pilih salah satu jenis kendaraan (Matic / Manual Transmisi).',
            'no_stnk.required' => 'Nomor STNK wajib diisi.',
            'tahun_pembuatan.required' => 'Tahun pembuatan wajib diisi (4 digit).',
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'warna.required' => 'Warna kendaraan wajib diisi.',
        ]);

        Kendaraan::create($validated);

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    /**
     * Form edit data kendaraan
     */
    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    /**
     * Update data kendaraan
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'no_plat' => ['required', 'string', 'max:20', Rule::unique('kendaraans')->ignore($kendaraan->id)],
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk' => 'required|string|max:50',
            'tahun_pembuatan' => 'required|digits:4|integer|min:1980|max:'.(date('Y') + 1),
            'nama_pemilik' => 'required|string|max:255',
            'warna' => 'required|string|max:50',
        ], [
            'no_plat.required' => 'Nomor plat kendaraan wajib diisi.',
            'no_plat.unique' => 'Nomor plat sudah digunakan oleh kendaraan lain.',
            'jenis_kendaraan.required' => 'Pilih salah satu jenis kendaraan.',
            'no_stnk.required' => 'Nomor STNK wajib diisi.',
            'tahun_pembuatan.required' => 'Tahun pembuatan wajib diisi (4 digit).',
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'warna.required' => 'Warna kendaraan wajib diisi.',
        ]);

        $kendaraan->update($validated);

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    /**
     * Hapus data kendaraan
     */
    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil dihapus!');
    }
}
