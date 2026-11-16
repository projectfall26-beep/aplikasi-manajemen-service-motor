@extends('layouts.app')

@section('title', 'Edit Pendaftaran Servis')
@section('page_heading', 'Form Edit Pendaftaran Servis')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-9 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Edit Pendaftaran Servis
                    </h5>
                    <small class="text-muted">ID Servis: #SRV-{{ str_pad($daftarService->id, 4, '0', STR_PAD_LEFT) }}</small>
                </div>
                <a href="{{ route('daftar-service.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('daftar-service.update', $daftarService->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Dropdown ID Pelanggan -->
                        <div class="col-md-6 mb-3">
                            <label for="pelanggan_id" class="form-label fw-semibold">Pilih ID Pelanggan <span class="text-danger">*</span></label>
                            <select name="pelanggan_id" id="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih ID Pelanggan --</option>
                                @foreach($pelanggans as $p)
                                    <option value="{{ $p->id }}" data-nama="{{ $p->nama_lengkap }}" data-hp="{{ $p->no_hp }}" {{ old('pelanggan_id', $daftarService->pelanggan_id) == $p->id ? 'selected' : '' }}>
                                        #PLG-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }} - {{ $p->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelanggan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Pelanggan (Terisi Otomatis) -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_pelanggan_auto" class="form-label fw-semibold">
                                Nama Pelanggan <span class="badge bg-secondary-subtle text-secondary fw-normal">Otomatis Terisi</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-fill text-primary"></i></span>
                                <input type="text" id="nama_pelanggan_auto" class="form-control bg-light" value="{{ $daftarService->pelanggan->nama_lengkap ?? '' }}" readonly>
                            </div>
                            <small class="text-muted" id="hp_pelanggan_info"></small>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Dropdown Nomor Plat Kendaraan -->
                        <div class="col-md-6 mb-3">
                            <label for="kendaraan_id" class="form-label fw-semibold">Nomor Plat Kendaraan <span class="text-danger">*</span></label>
                            <select name="kendaraan_id" id="kendaraan_id" class="form-select @error('kendaraan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Nomor Plat --</option>
                                @foreach($kendaraans as $k)
                                    <option value="{{ $k->id }}" {{ old('kendaraan_id', $daftarService->kendaraan_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->no_plat }} ({{ $k->jenis_kendaraan }} - {{ $k->warna }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kendaraan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Servis -->
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_servis" class="form-label fw-semibold">Tanggal Servis <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_servis" id="tanggal_servis" class="form-control @error('tanggal_servis') is-invalid @enderror" value="{{ old('tanggal_servis', $daftarService->tanggal_servis->format('Y-m-d')) }}" required>
                            @error('tanggal_servis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Keluhan Kendaraan -->
                    <div class="mb-4">
                        <label for="keluhan" class="form-label fw-semibold">Keluhan Kendaraan <span class="text-danger">*</span></label>
                        <textarea name="keluhan" id="keluhan" rows="3" class="form-control @error('keluhan') is-invalid @enderror" required>{{ old('keluhan', $daftarService->keluhan) }}</textarea>
                        @error('keluhan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('daftar-service.index') }}" class="btn btn-light px-4">Batal</a>
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

@push('scripts')
<script>
    const selectPelanggan = document.getElementById('pelanggan_id');
    const inputNama = document.getElementById('nama_pelanggan_auto');
    const infoHp = document.getElementById('hp_pelanggan_info');

    function updateNamaPelanggan() {
        const selectedOption = selectPelanggan.options[selectPelanggan.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const nama = selectedOption.getAttribute('data-nama') || '';
            const hp = selectedOption.getAttribute('data-hp') || '';
            inputNama.value = nama;
            infoHp.textContent = hp ? 'Kontak: ' + hp : '';
        } else {
            inputNama.value = '';
            infoHp.textContent = '';
        }
    }

    selectPelanggan.addEventListener('change', updateNamaPelanggan);
    updateNamaPelanggan();
</script>
@endpush
