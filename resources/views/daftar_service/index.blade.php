@extends('layouts.app')

@section('title', 'Daftar Service')
@section('page_heading', 'Daftar Pendaftaran Servis Motor')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-journal-text text-primary me-2"></i>Daftar Registrasi Servis Pelanggan
            </h5>
            <small class="text-muted">Total terdaftar: {{ $daftarServices->total() }} pendaftaran</small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Form Pencarian -->
            <form action="{{ route('daftar-service.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari ID, Plat, Pelanggan..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('daftar-service.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('daftar-service.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-calendar-plus-fill"></i>
                <span>Registrasi Servis Baru</span>
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 130px;">ID Servis</th>
                        <th>Tanggal</th>
                        <th>Plat Kendaraan</th>
                        <th>ID & Nama Pelanggan</th>
                        <th>Keluhan Kendaraan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftarServices as $servis)
                        <tr>
                            <td>
                                <span class="badge bg-dark fs-6 px-2 py-1">
                                    #SRV-{{ str_pad($servis->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ \Carbon\Carbon::parse($servis->tanggal_servis)->translatedFormat('d F Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($servis->tanggal_servis)->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $servis->kendaraan->no_plat ?? '-' }}</div>
                                <small class="text-muted">{{ $servis->kendaraan->jenis_kendaraan ?? '' }} - {{ $servis->kendaraan->warna ?? '' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $servis->pelanggan->nama_lengkap ?? '-' }}</div>
                                <small class="badge bg-light text-secondary border">#PLG-{{ str_pad($servis->pelanggan_id, 3, '0', STR_PAD_LEFT) }}</small>
                                <small class="text-muted ms-1">{{ $servis->pelanggan->no_hp ?? '' }}</small>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $servis->keluhan }}">
                                    {{ $servis->keluhan }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($servis->dataService && $servis->dataService->pembayaran)
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($servis->dataService)
                                    <span class="badge bg-info text-dark">Proses Mekanik</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu Pengerjaan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('daftar-service.edit', $servis->id) }}" class="btn btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus Data" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $servis->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade text-start" id="deleteModal{{ $servis->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Apakah Anda yakin ingin menghapus data servis <strong>#SRV-{{ str_pad($servis->id, 4, '0', STR_PAD_LEFT) }}</strong> (Pelanggan: {{ $servis->pelanggan->nama_lengkap ?? '-' }})?
                                                <div class="text-muted small mt-2">Data pengerjaan servis mekanik dan pembayarannya yang terkait juga akan dihapus.</div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('daftar-service.destroy', $servis->id) }}" method="POST">
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
                                Tidak ada data pendaftaran servis yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($daftarServices->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $daftarServices->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
