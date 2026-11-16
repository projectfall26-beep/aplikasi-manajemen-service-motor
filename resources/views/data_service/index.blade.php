@extends('layouts.app')

@section('title', 'Data Servis Mekanik')
@section('page_heading', 'Kelola Data Servis Mekanik')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-wrench-adjustable text-primary me-2"></i>Daftar Pengerjaan Servis & Mekanik
            </h5>
            <small class="text-muted">Total data servis: {{ $dataServices->total() }} pengerjaan</small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Form Pencarian -->
            <form action="{{ route('data-service.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari mekanik, sparepart, ID..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('data-service.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('data-service.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Input Data Servis</span>
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 130px;">ID Servis</th>
                        <th>Pelanggan & Kendaraan</th>
                        <th>Keluhan Kendaraan</th>
                        <th>Mekanik Penanggung Jawab</th>
                        <th>Estimasi Waktu</th>
                        <th>Sparepart Pengganti</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataServices as $ds)
                        <tr>
                            <td>
                                <span class="badge bg-dark fs-6 px-2 py-1">
                                    #SRV-{{ str_pad($ds->daftar_service_id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $ds->daftarService->pelanggan->nama_lengkap ?? '-' }}</div>
                                <span class="badge bg-light text-dark border">
                                    {{ $ds->daftarService->kendaraan->no_plat ?? '-' }} ({{ $ds->daftarService->kendaraan->jenis_kendaraan ?? '-' }})
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block text-muted" style="max-width: 200px;" title="{{ $ds->daftarService->keluhan ?? '-' }}">
                                    {{ $ds->daftarService->keluhan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-person-badge"></i>
                                    {{ $ds->nama_mekanik }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info border border-info-subtle">
                                    <i class="bi bi-clock me-1"></i>{{ $ds->estimasi_service }}
                                </span>
                            </td>
                            <td>
                                @if($ds->sparepart_pengganti)
                                    <span class="small text-dark">{{ $ds->sparepart_pengganti }}</span>
                                @else
                                    <span class="text-muted fst-italic small">Tidak ada penggantian sparepart</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('data-service.edit', $ds->id) }}" class="btn btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus Data" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $ds->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade text-start" id="deleteModal{{ $ds->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Apakah Anda yakin ingin menghapus data servis ini (Mekanik: <strong>{{ $ds->nama_mekanik }}</strong>)?
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('data-service.destroy', $ds->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data pengerjaan servis mekanik.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($dataServices->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $dataServices->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
