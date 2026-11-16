@extends('layouts.app')

@section('title', 'Pembayaran Servis')
@section('page_heading', 'Kelola Transaksi Pembayaran Kasir')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-cash-stack text-success me-2"></i>Daftar Transaksi Pembayaran
            </h5>
            <small class="text-muted">Total transaksi: {{ $pembayarans->total() }} pembayaran tercatat</small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Form Pencarian -->
            <form action="{{ route('pembayaran.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari metode, biaya, ID..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('pembayaran.create') }}" class="btn btn-success d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Transaksi Pembayaran Baru</span>
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 130px;">ID Servis</th>
                        <th>Pelanggan & Plat Motor</th>
                        <th>Jumlah Biaya</th>
                        <th>Jenis Pembayaran</th>
                        <th>Keterangan</th>
                        <th>Waktu Transaksi</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $bayar)
                        <tr>
                            <td>
                                <span class="badge bg-dark fs-6 px-2 py-1">
                                    #SRV-{{ str_pad($bayar->dataService->daftar_service_id ?? 0, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">
                                    {{ $bayar->dataService->daftarService->pelanggan->nama_lengkap ?? '-' }}
                                </div>
                                <span class="badge bg-light text-dark border">
                                    {{ $bayar->dataService->daftarService->kendaraan->no_plat ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-success fs-6">
                                    Rp {{ number_format($bayar->jumlah_biaya, 0, ',', '.') }}
                                </div>
                            </td>
                            <td>
                                @if($bayar->jenis_pembayaran == 'Cash/Tunai')
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                        <i class="bi bi-cash me-1"></i> Cash / Tunai
                                    </span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        <i class="bi bi-qr-code me-1"></i> Non Tunai (Transfer / QRIS)
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="small text-muted">{{ $bayar->keterangan ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="small text-dark">{{ $bayar->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pembayaran.edit', $bayar->id) }}" class="btn btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus Data" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $bayar->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade text-start" id="deleteModal{{ $bayar->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Apakah Anda yakin ingin menghapus data pembayaran sebesar <strong>Rp {{ number_format($bayar->jumlah_biaya, 0, ',', '.') }}</strong>?
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('pembayaran.destroy', $bayar->id) }}" method="POST">
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
                                Belum ada transaksi pembayaran yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($pembayarans->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $pembayarans->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
