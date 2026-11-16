@extends('layouts.app')

@section('title', 'Data Kendaraan')
@section('page_heading', 'Kelola Data Kendaraan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-bicycle text-primary me-2"></i>Daftar Master Kendaraan
            </h5>
            <small class="text-muted">Total terdaftar: {{ $kendaraans->total() }} kendaraan</small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Form Pencarian -->
            <form action="{{ route('kendaraan.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari plat, pemilik, jenis..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('kendaraan.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Tambah Kendaraan</span>
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 140px;">Nomor Plat</th>
                        <th>Jenis Kendaraan</th>
                        <th>Pemilik Motor</th>
                        <th>Nomor STNK</th>
                        <th>Tahun</th>
                        <th>Warna</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kendaraans as $kendaraan)
                        <tr>
                            <td>
                                <span class="badge bg-dark fs-6 px-3 py-2 border">
                                    {{ $kendaraan->no_plat }}
                                </span>
                            </td>
                            <td>
                                @if($kendaraan->jenis_kendaraan == 'Matic')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        <i class="bi bi-speedometer2 me-1"></i>Matic
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle">
                                        <i class="bi bi-gear-fill me-1"></i>Manual Transmisi
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $kendaraan->nama_pemilik }}</div>
                            </td>
                            <td>
                                <span class="text-muted font-monospace">{{ $kendaraan->no_stnk }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $kendaraan->tahun_pembuatan }}</span>
                            </td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-circle-fill" style="color: #64748b; font-size: 0.65rem;"></i>
                                    {{ $kendaraan->warna }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kendaraan.edit', $kendaraan->id) }}" class="btn btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus Data" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $kendaraan->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade text-start" id="deleteModal{{ $kendaraan->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Apakah Anda yakin ingin menghapus data kendaraan plat <strong>{{ $kendaraan->no_plat }}</strong> (Pemilik: {{ $kendaraan->nama_pemilik }})?
                                                <div class="text-muted small mt-2">Semua data riwayat servis untuk kendaraan ini juga akan terhapus.</div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('kendaraan.destroy', $kendaraan->id) }}" method="POST">
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
                                Tidak ada data kendaraan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($kendaraans->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $kendaraans->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
