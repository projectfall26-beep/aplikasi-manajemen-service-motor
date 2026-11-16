<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\DaftarService;
use App\Models\DataService;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama Dashboard dengan ringkasan statistik
     */
    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $totalKendaraan = Kendaraan::count();
        $totalDaftarService = DaftarService::count();
        $totalDataService = DataService::count();
        $totalPembayaran = Pembayaran::count();
        $totalPendapatan = Pembayaran::sum('jumlah_biaya');

        // Ringkasan data servis terbaru
        $servisTerbaru = DaftarService::with(['pelanggan', 'kendaraan', 'dataService.pembayaran'])
            ->latest()
            ->take(5)
            ->get();

        // Ringkasan pembayaran terbaru
        $pembayaranTerbaru = Pembayaran::with('dataService.daftarService.pelanggan')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPelanggan',
            'totalKendaraan',
            'totalDaftarService',
            'totalDataService',
            'totalPembayaran',
            'totalPendapatan',
            'servisTerbaru',
            'pembayaranTerbaru'
        ));
    }
}
