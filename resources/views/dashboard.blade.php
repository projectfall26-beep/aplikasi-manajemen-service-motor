@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard Ringkasan Bengkel')

@section('content')
<div class="row g-3 mb-4">
    <!-- Card Total Pelanggan -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card stat-card h-100 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Pelanggan</span>
                    <h2 class="fw-bold text-dark my-1">{{ number_format($totalPelanggan) }}</h2>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                        <i class="bi bi-person-check-fill me-1"></i> Terdaftar
                    </span>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('pelanggan.index') }}" class="small text-decoration-none text-primary fw-medium d-flex align-items-center justify-content-between">
                    <span>Kelola Pelanggan</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card Total Kendaraan -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card stat-card h-100 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Kendaraan</span>
                    <h2 class="fw-bold text-dark my-1">{{ number_format($totalKendaraan) }}</h2>
                    <span class="badge bg-info-subtle text-info border border-info-subtle">
                        <i class="bi bi-bicycle me-1"></i> Motor Aktif
                    </span>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-motorcycle"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('kendaraan.index') }}" class="small text-decoration-none text-info fw-medium d-flex align-items-center justify-content-between">
                    <span>Lihat Kendaraan</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card Total Daftar Service -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card stat-card h-100 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Daftar Servis</span>
                    <h2 class="fw-bold text-dark my-1">{{ number_format($totalDaftarService) }}</h2>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                        <i class="bi bi-clock-history me-1"></i> Registrasi Servis
                    </span>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-journal-check"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('daftar-service.index') }}" class="small text-decoration-none text-warning fw-medium d-flex align-items-center justify-content-between">
                    <span>Daftar Antrean Servis</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card Total Data Service Mekanik -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card stat-card h-100 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Data Servis Mekanik</span>
                    <h2 class="fw-bold text-dark my-1">{{ number_format($totalDataService) }}</h2>
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                        <i class="bi bi-gear-wide-connected me-1"></i> Ditangani
                    </span>
                </div>
                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                    <i class="bi bi-wrench-adjustable-circle"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('data-service.index') }}" class="small text-decoration-none text-secondary fw-medium d-flex align-items-center justify-content-between">
                    <span>Data Pengerjaan Servis</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card Total Pembayaran (Transaksi & Nominal) -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card stat-card h-100 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Pembayaran</span>
                    <h2 class="fw-bold text-dark my-1">{{ number_format($totalPembayaran) }}</h2>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <i class="bi bi-check2-all me-1"></i> Transaksi Selesai
                    </span>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('pembayaran.index') }}" class="small text-decoration-none text-success fw-medium d-flex align-items-center justify-content-between">
                    <span>Riwayat Kasir</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Card Total Pendapatan Kasir -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card stat-card h-100 p-3 bg-white text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%) !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-white-50 small fw-semibold text-uppercase">Total Pendapatan Bengkel</span>
                    <h3 class="fw-bold text-white my-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    <span class="badge bg-light text-dark fw-bold">
                        <i class="bi bi-wallet2 me-1"></i> Akumulasi Biaya
                    </span>
                </div>
                <div class="stat-icon bg-white bg-opacity-25 text-white">
                    <i class="bi bi-cash-coin"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top border-white-10">
                <span class="small text-white-50">Tercatat secara otomatis dari modul pembayaran</span>
            </div>
        </div>
    </div>
</div>

<!-- Section Ringkasan Servis Terbaru & Pembayaran -->
<div class="row g-4">
    <!-- Tabel Pendaftaran Servis Terbaru -->
    <div class="col-12 col-xl-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-bold text-dark">
                    <i class="bi bi-clock-history text-primary me-2"></i>5 Pendaftaran Servis Terbaru
                </span>
                <a href="{{ route('daftar-service.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Servis Baru
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Servis</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>No Plat</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servisTerbaru as $srv)
                                <tr>
                                    <td><span class="badge bg-dark">#SRV-{{ str_pad($srv->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($srv->tanggal_servis)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $srv->pelanggan->nama_lengkap ?? '-' }}</div>
                                        <small class="text-muted">{{ $srv->pelanggan->no_hp ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $srv->kendaraan->no_plat ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-truncate d-inline-block" style="max-width: 180px;" title="{{ $srv->keluhan }}">
                                            {{ $srv->keluhan }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($srv->dataService && $srv->dataService->pembayaran)
                                            <span class="badge bg-success">Lunas</span>
                                        @elseif($srv->dataService)
                                            <span class="badge bg-info text-dark">Dikerjakan</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Antre</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data servis terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top text-end">
                <a href="{{ route('daftar-service.index') }}" class="text-decoration-none small fw-semibold">
                    Lihat Semua Pendaftaran Servis &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Tabel Pembayaran Terbaru -->
    <div class="col-12 col-xl-5">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-bold text-dark">
                    <i class="bi bi-wallet2 text-success me-2"></i>Transaksi Kasir Terbaru
                </span>
                <a href="{{ route('pembayaran.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Bayar
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Servis / Pelanggan</th>
                                <th>Metode</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayaranTerbaru as $pay)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            #SRV-{{ str_pad($pay->dataService->daftar_service_id ?? 0, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $pay->dataService->daftarService->pelanggan->nama_lengkap ?? '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $pay->jenis_pembayaran == 'Cash/Tunai' ? 'bg-secondary' : 'bg-primary' }}">
                                            {{ $pay->jenis_pembayaran }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($pay->jumlah_biaya, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada transaksi pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top text-end">
                <a href="{{ route('pembayaran.index') }}" class="text-decoration-none small fw-semibold text-success">
                    Lihat Semua Pembayaran &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
