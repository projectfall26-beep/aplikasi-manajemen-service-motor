@extends('layouts.app')

@section('title', 'Tambah Data Servis')
@section('page_heading', 'Form Input Data Pengerjaan Servis')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-9 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-wrench text-primary me-2"></i>Input Pengerjaan Servis Mekanik
                    </h5>
                    <small class="text-muted">Pilih ID Servis dari daftar registrasi servis pelanggan</small>
                </div>
                <a href="{{ route('data-service.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('data-service.store') }}" method="POST">
                    @csrf

                    <!-- Dropdown ID Servis Pelanggan -->
                    <div class="mb-3">
                        <label for="daftar_service_id" class="form-label fw-semibold">Pilih ID Servis Pelanggan <span class="text-danger">*</span></label>
                        <select name="daftar_service_id" id="daftar_service_id" class="form-select @error('daftar_service_id') is-invalid @enderror" required>
                            <option value="">-- Pilih ID Servis Pelanggan --</option>
                            @foreach($daftarServices as $ds)
                                <option value="{{ $ds->id }}" 
                                        data-keluhan="{{ $ds->keluhan }}"
                                        data-pelanggan="{{ $ds->pelanggan->nama_lengkap ?? '-' }}"
                                        data-plat="{{ $ds->kendaraan->no_plat ?? '-' }}"
                                        {{ old('daftar_service_id') == $ds->id ? 'selected' : '' }}>
                                    #SRV-{{ str_pad($ds->id, 4, '0', STR_PAD_LEFT) }} | Plat: {{ $ds->kendaraan->no_plat ?? '-' }} ({{ $ds->pelanggan->nama_lengkap ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">ID Servis diambil langsung dari tabel Daftar Service</small>
                        @error('daftar_service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keluhan Kendaraan (Otomatis Terisi) -->
                    <div class="mb-3">
                        <label for="keluhan_auto" class="form-label fw-semibold">
                            Keluhan Kendaraan <span class="badge bg-secondary-subtle text-secondary fw-normal">Otomatis Terisi</span>
                        </label>
                        <textarea id="keluhan_auto" rows="2" class="form-control bg-light" placeholder="Otomatis terisi saat ID Servis Pelanggan dipilih" readonly></textarea>
                    </div>

                    <div class="row">
                        <!-- Estimasi Service -->
                        <div class="col-md-6 mb-3">
                            <label for="estimasi_service" class="form-label fw-semibold">Estimasi Service <span class="text-danger">*</span></label>
                            <input type="text" name="estimasi_service" id="estimasi_service" class="form-control @error('estimasi_service') is-invalid @enderror" value="{{ old('estimasi_service') }}" placeholder="Contoh: 1 Jam, 45 Menit, Selesai Sore" required>
                            @error('estimasi_service')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Mekanik -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_mekanik" class="form-label fw-semibold">Nama Mekanik <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mekanik" id="nama_mekanik" class="form-control @error('nama_mekanik') is-invalid @enderror" value="{{ old('nama_mekanik') }}" placeholder="Contoh: Agus Priyono" required>
                            @error('nama_mekanik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sparepart Pengganti -->
                    <div class="mb-4">
                        <label for="sparepart_pengganti" class="form-label fw-semibold">Sparepart Pengganti</label>
                        <textarea name="sparepart_pengganti" id="sparepart_pengganti" rows="3" class="form-control @error('sparepart_pengganti') is-invalid @enderror" placeholder="Sebutkan suku cadang yang diganti (Contoh: Oli Mesin MPX 2, Busi NGK, Kampas Rem Belakang). Kosongkan atau isi strip (-) jika tidak ada.">{{ old('sparepart_pengganti') }}</textarea>
                        @error('sparepart_pengganti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('data-service.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-2">
                            <i class="bi bi-save"></i>
                            <span>Simpan Data Servis</span>
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
    // Fitur Otomatis Mengisi Keluhan Kendaraan Saat ID Servis Dipilih
    const selectServis = document.getElementById('daftar_service_id');
    const inputKeluhan = document.getElementById('keluhan_auto');

    function updateKeluhan() {
        const selectedOption = selectServis.options[selectServis.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const keluhan = selectedOption.getAttribute('data-keluhan') || '';
            inputKeluhan.value = keluhan;
        } else {
            inputKeluhan.value = '';
        }
    }

    selectServis.addEventListener('change', updateKeluhan);
    updateKeluhan();
</script>
@endpush
