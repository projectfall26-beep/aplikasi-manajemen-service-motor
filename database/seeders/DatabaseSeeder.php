<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\DaftarService;
use App\Models\DataService;
use App\Models\Pembayaran;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Data Pelanggan Percobaan
        $p1 = Pelanggan::create([
            'nama_lengkap' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 45, Jakarta Barat',
            'pekerjaan' => 'Karyawan Swasta',
        ]);

        $p2 = Pelanggan::create([
            'nama_lengkap' => 'Siti Aminah',
            'no_hp' => '085712345678',
            'alamat' => 'Jl. Sudirman No. 12, Jakarta Selatan',
            'pekerjaan' => 'Wiraswasta',
        ]);

        $p3 = Pelanggan::create([
            'nama_lengkap' => 'Ahmad Fauzi',
            'no_hp' => '087898765432',
            'alamat' => 'Jl. Melati Raya No. 8, Tangerang',
            'pekerjaan' => 'Guru',
        ]);

        // 2. Data Kendaraan Percobaan
        $k1 = Kendaraan::create([
            'no_plat' => 'B 1234 ABC',
            'jenis_kendaraan' => 'Matic',
            'no_stnk' => 'STNK-992101',
            'tahun_pembuatan' => '2021',
            'nama_pemilik' => 'Budi Santoso',
            'warna' => 'Hitam Metalik',
        ]);

        $k2 = Kendaraan::create([
            'no_plat' => 'B 5678 DEF',
            'jenis_kendaraan' => 'Manual Transmisi',
            'no_stnk' => 'STNK-883210',
            'tahun_pembuatan' => '2019',
            'nama_pemilik' => 'Siti Aminah',
            'warna' => 'Merah',
        ]);

        $k3 = Kendaraan::create([
            'no_plat' => 'B 9012 GHI',
            'jenis_kendaraan' => 'Matic',
            'no_stnk' => 'STNK-774321',
            'tahun_pembuatan' => '2023',
            'nama_pemilik' => 'Ahmad Fauzi',
            'warna' => 'Biru Tua',
        ]);

        // 3. Data Daftar Servis
        $ds1 = DaftarService::create([
            'pelanggan_id' => $p1->id,
            'kendaraan_id' => $k1->id,
            'keluhan' => 'Rem depan kurang pakem dan tarikan gas agak berat.',
            'tanggal_servis' => now()->toDateString(),
        ]);

        $ds2 = DaftarService::create([
            'pelanggan_id' => $p2->id,
            'kendaraan_id' => $k2->id,
            'keluhan' => 'Ganti oli rutin dan rantai motor berbunyi kasar.',
            'tanggal_servis' => now()->toDateString(),
        ]);

        // 4. Data Pengerjaan Service (Data Service)
        $work1 = DataService::create([
            'daftar_service_id' => $ds1->id,
            'estimasi_service' => '2 Jam',
            'nama_mekanik' => 'Agus Priyono',
            'sparepart_pengganti' => 'Kampas Rem Depan, Oli Mesin MPX 2',
        ]);

        $work2 = DataService::create([
            'daftar_service_id' => $ds2->id,
            'estimasi_service' => '1 Jam',
            'nama_mekanik' => 'Doni Saputra',
            'sparepart_pengganti' => 'Oli Mesin Federal, Pelumas Rantai',
        ]);

        // 5. Data Pembayaran Service
        Pembayaran::create([
            'data_service_id' => $work1->id,
            'jumlah_biaya' => 175000,
            'jenis_pembayaran' => 'Cash/Tunai',
            'keterangan' => 'Lunas, servis berjalan lancar.',
        ]);

        Pembayaran::create([
            'data_service_id' => $work2->id,
            'jumlah_biaya' => 120000,
            'jenis_pembayaran' => 'Non Tunai',
            'keterangan' => 'Lunas via QRIS / Transfer Bank.',
        ]);
    }
}
