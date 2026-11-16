<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataService extends Model
{
    use HasFactory;

    protected $table = 'data_services';

    protected $fillable = [
        'daftar_service_id',
        'estimasi_service',
        'nama_mekanik',
        'sparepart_pengganti',
    ];

    /**
     * Relasi ke pendaftaran servis
     */
    public function daftarService()
    {
        return $this->belongsTo(DaftarService::class, 'daftar_service_id');
    }

    /**
     * Relasi ke pembayaran
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'data_service_id');
    }
}
