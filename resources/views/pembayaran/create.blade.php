@extends('layouts.app')

@section('title', 'Transaksi Pembayaran')
@section('page_heading', 'Form Input Pembayaran Servis')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-9 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-cash-coin text-success me-2"></i>Transaksi Kasir Pembayaran
                    </h5>
                    <small class="text-muted">Pilih data pengerjaan servis mekanik untuk diselesaikan pembayarannya</small>
                </div>
                <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf

                    <!-- Dropdown ID Servis Pelanggan (dari Data Service) -->
                    <div class="mb-3">
                        <label for="data_service_id" class="form-label fw-semibold">Pilih ID Servis Pelanggan (Data Service) <span class="text-danger">*</span></label>
                        <select name="data_service_id" id="data_service_id" class="form-select @error('data_service_id') is-invalid @enderror" required>
                            <option value="">-- Pilih ID Servis dari Data Service --</option>
                            @foreach($dataServices as $ds)
                                <option value="{{ $ds->id }}" {{ old('data_service_id') == $ds->id ? 'selected' : '' }}>
                                    #SRV-{{ str_pad($ds->daftar_service_id, 4, '0', STR_PAD_LEFT) }} | Plat: {{ $ds->daftarService->kendaraan->no_plat ?? '-' }} (Pelanggan: {{ $ds->daftarService->pelanggan->nama_lengkap ?? '-' }}) - Mekanik: {{ $ds->nama_mekanik }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">ID servis diambil dari tabel Data Service mekanik</small>
                        @error('data_service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jumlah Biaya Servis (Validasi Angka) -->
                    <div class="mb-3">
                        <label for="jumlah_biaya" class="form-label fw-semibold">Jumlah Biaya Servis (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">Rp</span>
                            <input type="number" step="0.01" min="0" name="jumlah_biaya" id="jumlah_biaya" class="form-control @error('jumlah_biaya') is-invalid @enderror" value="{{ old('jumlah_biaya') }}" placeholder="Contoh: 150000" required>
                        </div>
                        <small class="text-muted">Harus berupa angka (contoh: 150000)</small>
                        @error('jumlah_biaya')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Pembayaran (Radio Button: Cash/Tunai atau Non Tunai) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Jenis Pembayaran <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 p-3 bg-light rounded-3 border @error('jenis_pembayaran') border-danger @enderror">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_pembayaran" id="bayar_cash" value="Cash/Tunai" {{ old('jenis_pembayaran', 'Cash/Tunai') == 'Cash/Tunai' ? 'checked' : '' }} required>
                                <label class="form-check-label fw-medium" for="bayar_cash">
                                    <i class="bi bi-cash text-success me-1"></i> Cash / Tunai
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_pembayaran" id="bayar_non_tunai" value="Non Tunai" {{ old('jenis_pembayaran') == 'Non Tunai' ? 'checked' : '' }} required>
                                <label class="form-check-label fw-medium" for="bayar_non_tunai">
                                    <i class="bi bi-qr-code text-primary me-1"></i> Non Tunai (Transfer / QRIS / Debit)
                                </label>
                            </div>
                        </div>
                        @error('jenis_pembayaran')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan / Catatan Transaksi</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Contoh: Pembayaran lunas via BCA / QRIS / Bayar tunai pas di kasir.">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-4 d-flex align-items-center gap-2">
                            <i class="bi bi-check2-circle"></i>
                            <span>Simpan Pembayaran</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
