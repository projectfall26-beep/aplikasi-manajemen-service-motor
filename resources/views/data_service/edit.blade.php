@extends('layouts.app')

@section('title', 'Edit Data Servis')
@section('page_heading', 'Form Edit Pengerjaan Servis')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-9 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Edit Pengerjaan Servis Mekanik
                    </h5>
                    <small class="text-muted">Servis: #SRV-{{ str_pad($dataService->daftar_service_id, 4, '0', STR_PAD_LEFT) }}</small>
                </div>
                <a href="{{ route('data-service.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('data-service.update', $dataService->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Dropdown ID Servis Pelanggan -->
                    <div class="mb-3">
                        <label for="daftar_service_id" class="form-label fw-semibold">Pilih ID Servis Pelanggan <span class="text-danger">*</span></label>
                        <select name="daftar_service_id" id="daftar_service_id" class="form-select @error('daftar_service_id') is-invalid @enderror" required>
                            <option value="">-- Pilih ID Servis Pelanggan --</option>
                            @foreach($daftarServices as $ds)
                                <option value="{{ $ds->id }}" 
                                        data-keluhan="{{ $ds->keluhan }}"
                                        {{ old('daftar_service_id', $dataService->daftar_service_id) == $ds->id ? 'selected' : '' }}>
                                    #SRV-{{ str_pad($ds->id, 4, '0', STR_PAD_LEFT) }} | Plat: {{ $ds->kendaraan->no_plat ?? '-' }} ({{ $ds->pelanggan->nama_lengkap ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('daftar_service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keluhan Kendaraan (Otomatis Terisi) -->
                    <div class="mb-3">
                        <label for="keluhan_auto" class="form-label fw-semibold">
                            Keluhan Kendaraan <span class="badge bg-secondary-subtle text-secondary fw-normal">Otomatis Terisi</span>
                        </label>
                        <textarea id="keluhan_auto" rows="2" class="form-control bg-light" readonly>{{ $dataService->daftarService->keluhan ?? '' }}</textarea>
                    </div>

                    <div class="row">
                        <!-- Estimasi Service -->
                        <div class="col-md-6 mb-3">
                            <label for="estimasi_service" class="form-label fw-semibold">Estimasi Service <span class="text-danger">*</span></label>
                            <input type="text" name="estimasi_service" id="estimasi_service" class="form-control @error('estimasi_service') is-invalid @enderror" value="{{ old('estimasi_service', $dataService->estimasi_service) }}" required>
                            @error('estimasi_service')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Mekanik -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_mekanik" class="form-label fw-semibold">Nama Mekanik <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mekanik" id="nama_mekanik" class="form-control @error('nama_mekanik') is-invalid @enderror" value="{{ old('nama_mekanik', $dataService->nama_mekanik) }}" required>
                            @error('nama_mekanik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sparepart Pengganti -->
                    <div class="mb-4">
                        <label for="sparepart_pengganti" class="form-label fw-semibold">Sparepart Pengganti</label>
                        <textarea name="sparepart_pengganti" id="sparepart_pengganti" rows="3" class="form-control @error('sparepart_pengganti') is-invalid @enderror">{{ old('sparepart_pengganti', $dataService->sparepart_pengganti) }}</textarea>
                        @error('sparepart_pengganti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('data-service.index') }}" class="btn btn-light px-4">Batal</a>
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
</script>
@endpush
