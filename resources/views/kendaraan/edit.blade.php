@extends('layouts.app')

@section('title', 'Edit Kendaraan')
@section('page_heading', 'Form Edit Data Kendaraan')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Kendaraan
                    </h5>
                    <small class="text-muted">Nomor Plat: {{ $kendaraan->no_plat }}</small>
                </div>
                <a href="{{ route('kendaraan.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="no_plat" class="form-label fw-semibold">Nomor Plat Kendaraan <span class="text-danger">*</span></label>
                        <input type="text" name="no_plat" id="no_plat" class="form-control text-uppercase @error('no_plat') is-invalid @enderror" value="{{ old('no_plat', $kendaraan->no_plat) }}" required>
                        @error('no_plat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 p-2 bg-light rounded-3 border @error('jenis_kendaraan') border-danger @enderror">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kendaraan" id="jenis_matic" value="Matic" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'Matic' ? 'checked' : '' }} required>
                                <label class="form-check-label fw-medium" for="jenis_matic">
                                    <i class="bi bi-speedometer2 text-primary me-1"></i> Matic
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kendaraan" id="jenis_manual" value="Manual Transmisi" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'Manual Transmisi' ? 'checked' : '' }} required>
                                <label class="form-check-label fw-medium" for="jenis_manual">
                                    <i class="bi bi-gear-fill text-warning me-1"></i> Manual Transmisi
                                </label>
                            </div>
                        </div>
                        @error('jenis_kendaraan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_pemilik" class="form-label fw-semibold">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror" value="{{ old('nama_pemilik', $kendaraan->nama_pemilik) }}" required>
                        @error('nama_pemilik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="no_stnk" class="form-label fw-semibold">Nomor STNK <span class="text-danger">*</span></label>
                            <input type="text" name="no_stnk" id="no_stnk" class="form-control @error('no_stnk') is-invalid @enderror" value="{{ old('no_stnk', $kendaraan->no_stnk) }}" required>
                            @error('no_stnk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembuatan" class="form-label fw-semibold">Tahun Pembuatan <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_pembuatan" id="tahun_pembuatan" class="form-control @error('tahun_pembuatan') is-invalid @enderror" value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan) }}" min="1980" max="{{ date('Y') + 1 }}" required>
                            @error('tahun_pembuatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="warna" class="form-label fw-semibold">Warna Kendaraan <span class="text-danger">*</span></label>
                        <input type="text" name="warna" id="warna" class="form-control @error('warna') is-invalid @enderror" value="{{ old('warna', $kendaraan->warna) }}" required>
                        @error('warna')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('kendaraan.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-warning px-4 d-flex align-items-center gap-2 text-dark fw-semibold">
                            <i class="bi bi-check-lg"></i>
                            <span>Update Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
