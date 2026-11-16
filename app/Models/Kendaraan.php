<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraans';

    protected $fillable = [
        'no_plat',
        'jenis_kendaraan',
        'no_stnk',
        'tahun_pembuatan',
        'nama_pemilik',
        'warna',
    ];

    /**
     * Relasi ke daftar service (Satu kendaraan memiliki banyak riwayat servis)
     */
    public function daftarServices()
    {
        return $this->hasMany(DaftarService::class, 'kendaraan_id');
    }
}
