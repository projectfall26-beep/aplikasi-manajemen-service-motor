<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

    protected $fillable = [
        'nama_lengkap',
        'no_hp',
        'alamat',
        'pekerjaan',
    ];

    /**
     * Relasi ke daftar service (Satu pelanggan memiliki banyak riwayat pendaftaran servis)
     */
    public function daftarServices()
    {
        return $this->hasMany(DaftarService::class, 'pelanggan_id');
    }
}
