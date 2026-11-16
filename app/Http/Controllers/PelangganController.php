<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Tampilkan data pelanggan dengan fitur pencarian dan pagination
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pelanggans = Pelanggan::when($search, function ($query, $search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                             ->orWhere('no_hp', 'like', "%{$search}%")
                             ->orWhere('alamat', 'like', "%{$search}%")
                             ->orWhere('pekerjaan', 'like', "%{$search}%")
                             ->orWhere('id', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pelanggan.index', compact('pelanggans', 'search'));
    }

    /**
     * Form tambah pelanggan baru
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Simpan data pelanggan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|regex:/^[0-9+ -]{8,20}$/',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:100',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid (hanya angka, simbol + atau tanda strip).',
            'alamat.required' => 'Alamat pelanggan wajib diisi.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    /**
     * Form edit data pelanggan
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update data pelanggan
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|regex:/^[0-9+ -]{8,20}$/',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:100',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'alamat.required' => 'Alamat pelanggan wajib diisi.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Hapus data pelanggan
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus!');
    }
}
