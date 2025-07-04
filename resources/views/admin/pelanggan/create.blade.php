@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Tambah Pelanggan</h4>
    <form action="{{ route('admin.pelanggan.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">ID Pel</label>
                @php
                function isRequired($field, $requiredFields) {
                return in_array($field, $requiredFields);
                }
                @endphp
                <input type="text" name="id_pel" class="form-control" value="{{ old('id_pel') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kode PLN</label>
                <input type="text" name="kode_PLN" class="form-control" value="{{ old('kode_PLN') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama PIC</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kontak</label>
                <input type="text" name="kontak" class="form-control" value="{{ old('kontak') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kapasitas Daya</label>
                <input type="number" step="0.01" name="kapasitas_daya" class="form-control" value="{{ old('kapasitas_daya') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sektor</label>
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
                <label class="form-label">Peruntukan</label>
                <input type="text" name="peruntukan" class="form-control" value="{{ old('peruntukan') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">UP3</label>
                <select name="up3" class="form-control" required>
                    <option value="">-- Pilih UP3 --</option>
                    @foreach(\App\Models\Pelanggan::UP3_OPTIONS as $up3)
                    <option value="{{ $up3 }}" {{ old('up3') == $up3 ? 'selected' : '' }}>{{ $up3 }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">ULP</label>
                <input type="text" name="ulp" class="form-control" value="{{ old('ulp') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kriteria Prioritas</label>
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
                <label for="nama_lengkap" class="form-label">Isi Nama Lengkap <span class="text-danger">*</span></label>
                <input type="nama_lengkap" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection