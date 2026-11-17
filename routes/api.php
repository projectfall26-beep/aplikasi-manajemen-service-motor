<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\KendaraanApiController;
use App\Http\Controllers\Api\DaftarServiceApiController;
use App\Http\Controllers\Api\DataServiceApiController;
use App\Http\Controllers\Api\PembayaranApiController;

/*
|--------------------------------------------------------------------------
| REST API Routes - Manajemen Service Motor
|--------------------------------------------------------------------------
| Seluruh endpoint didesain dengan format JSON responsif untuk pengujian Postman.
*/

Route::name('api.')->group(function () {
    // 1. API Modul Pelanggan
    Route::apiResource('pelanggan', PelangganApiController::class);

    // 2. API Modul Kendaraan
    Route::apiResource('kendaraan', KendaraanApiController::class);

    // 3. API Modul Daftar Service
    Route::apiResource('daftar-service', DaftarServiceApiController::class);

    // 4. API Modul Data Service
    Route::apiResource('data-service', DataServiceApiController::class);

    // 5. API Modul Pembayaran Service
    Route::apiResource('pembayaran', PembayaranApiController::class);
});
