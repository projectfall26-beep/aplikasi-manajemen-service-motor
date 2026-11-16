<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarService extends Model
{
    use HasFactory;

    protected $table = 'daftar_services';

    protected $fillable = [
        'pelanggan_id',
        'kendaraan_id',
        'keluhan',
        'tanggal_servis',
    ];

    protected $casts = [
        'tanggal_servis' => 'date',
    ];

    /**
     * Relasi ke data pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    /**
     * Relasi ke data kendaraan
     */
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    /**
     * Relasi ke data pengerjaan service
     */
    public function dataService()
    {
        return $this->hasOne(DataService::class, 'daftar_service_id');
    }
}
