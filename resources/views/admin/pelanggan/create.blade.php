@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Tambah Pelanggan</h4>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="notes-box mb-3">
        <strong>Catatan:</strong> Silakan isi data pelanggan dengan lengkap dan benar. Email dan password akan digunakan untuk login pelanggan. Semua field bertanda * wajib diisi.
    </div>
    <form action="{{ route('admin.pelanggan.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-id-card me-1"></i>ID Pel</label>
                @php
                function isRequired($field, $requiredFields) {
                return in_array($field, $requiredFields);
                }
                @endphp
                <input type="text" name="id_pel" class="form-control" value="{{ old('id_pel') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-key me-1"></i>Kode PLN</label>
                <input type="text" name="kode_PLN" class="form-control" value="{{ old('kode_PLN') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-building me-1"></i>Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-user me-1"></i>Nama PIC</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-phone me-1"></i>Kontak</label>
                <input type="text" name="kontak" class="form-control" value="{{ old('kontak') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-bolt me-1"></i>Kapasitas Daya</label>
                <input type="number" step="0.01" name="kapasitas_daya" class="form-control" value="{{ old('kapasitas_daya') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-industry me-1"></i>Sektor</label>
                <select name="sektor" class="form-control" required>
                    <option value="">-- Pilih Sektor --</option>
                    @foreach(\App\Models\Pelanggan::SEKTOR_OPTIONS as $sektor)
                    <option value="{{ $sektor }}" {{ old('sektor') == $sektor ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $sektor)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-clipboard-list me-1"></i>Peruntukan</label>
                <input type="text" name="peruntukan" class="form-control" value="{{ old('peruntukan') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>UP3</label>
                <select name="up3" class="form-control" required>
                    <option value="">-- Pilih UP3 --</option>
                    @foreach(\App\Models\Pelanggan::UP3_OPTIONS as $up3)
                    <option value="{{ $up3 }}" {{ old('up3') == $up3 ? 'selected' : '' }}>{{ $up3 }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>ULP</label>
                <input type="text" name="ulp" class="form-control" value="{{ old('ulp') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-star me-1"></i>Kriteria Prioritas</label>
                <select name="kriteria_prioritas" class="form-control" required>
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach(\App\Models\Pelanggan::KRITERIA_PRIORITAS_OPTIONS as $kriteria)
                    <option value="{{ $kriteria }}" {{ old('kriteria_prioritas') == $kriteria ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $kriteria)) }}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="nama_lengkap" class="form-label"><i class="fas fa-user-tag me-1"></i>Isi Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock me-1"></i>Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label"><i class="fas fa-user-shield me-1"></i>Role</label>
                <input type="text" class="form-control" id="role" name="role" value="pelanggan" readonly>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection