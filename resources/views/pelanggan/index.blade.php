@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page_heading', 'Kelola Data Pelanggan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-people text-primary me-2"></i>Daftar Master Pelanggan
            </h5>
            <small class="text-muted">Total terdaftar: {{ $pelanggans->total() }} pelanggan</small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Form Pencarian -->
            <form action="{{ route('pelanggan.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, HP, alamat..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i>
                <span>Tambah Pelanggan</span>
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 80px;">ID</th>
                        <th>Nama Lengkap</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Pekerjaan</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-secondary">#PLG-{{ str_pad($pelanggan->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $pelanggan->nama_lengkap }}</div>
                                <small class="text-muted">Terdaftar: {{ $pelanggan->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pelanggan->no_hp) }}" target="_blank" class="text-decoration-none fw-medium text-primary">
                                    <i class="bi bi-whatsapp text-success me-1"></i>{{ $pelanggan->no_hp }}
                                </a>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $pelanggan->alamat }}">
                                    {{ $pelanggan->alamat }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $pelanggan->pekerjaan }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus Data" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pelanggan->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade text-start" id="deleteModal{{ $pelanggan->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Apakah Anda yakin ingin menghapus data pelanggan <strong>{{ $pelanggan->nama_lengkap }}</strong> (#PLG-{{ $pelanggan->id }})?
                                                <div class="text-muted small mt-2">Semua relasi servis terkait pelanggan ini juga akan terhapus.</div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST">
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data pelanggan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($pelanggans->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $pelanggans->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
