<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'data_service_id',
        'jumlah_biaya',
        'jenis_pembayaran',
        'keterangan',
    ];

    protected $casts = [
        'jumlah_biaya' => 'decimal:2',
    ];

    /**
     * Relasi ke data pengerjaan service
     */
    public function dataService()
    {
        return $this->belongsTo(DataService::class, 'data_service_id');
    }
}
