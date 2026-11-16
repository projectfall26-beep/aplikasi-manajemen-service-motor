<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\DaftarServiceController;
use App\Http\Controllers\DataServiceController;
use App\Http\Controllers\PembayaranController;

// Halaman utama diarahkan langsung ke Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Modul CRUD Data Pelanggan
Route::resource('pelanggan', PelangganController::class);

// Modul CRUD Data Kendaraan
Route::resource('kendaraan', KendaraanController::class);

// Modul CRUD Daftar Service (Pendaftaran Servis)
Route::resource('daftar-service', DaftarServiceController::class);

// Modul CRUD Data Service (Pengerjaan Servis oleh Mekanik)
Route::resource('data-service', DataServiceController::class);

// Modul CRUD Pembayaran Service
Route::resource('pembayaran', PembayaranController::class);
