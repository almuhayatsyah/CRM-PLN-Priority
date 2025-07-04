@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4>Edit Data Pelanggan</h4>
    <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">ID Pel</label>
                <input type="text" name="id_pel" class="form-control" value="{{ old('id_pel', $pelanggan->id_pel) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kode PLN</label>
                <input type="text" name="kode_PLN" class="form-control" value="{{ old('kode_PLN', $pelanggan->kode_PLN) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', $pelanggan->nama_perusahaan) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama PIC</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $pelanggan->nama) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kontak</label>
                <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $pelanggan->kontak) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kapasitas Daya</label>
                <input type="number" step="0.01" name="kapasitas_daya" class="form-control" value="{{ old('kapasitas_daya', $pelanggan->kapasitas_daya) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sektor</label>
                <select name="sektor" class="form-control" required>
                    <option value="">-- Pilih Sektor --</option>
                    @foreach(\App\Models\Pelanggan::SEKTOR_OPTIONS as $sektor)
                    <option value="{{ $sektor }}" {{ old('sektor', $pelanggan->sektor) == $sektor ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $sektor)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Peruntukan</label>
                <input type="text" name="peruntukan" class="form-control" value="{{ old('peruntukan', $pelanggan->peruntukan) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">UP3</label>
                <select name="up3" class="form-control" required>
                    <option value="">-- Pilih UP3 --</option>
                    @foreach(\App\Models\Pelanggan::UP3_OPTIONS as $up3)
                    <option value="{{ $up3 }}" {{ old('up3', $pelanggan->up3) == $up3 ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ', $up3)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">ULP</label>
                <input type="text" name="ulp" class="form-control" value="{{ old('ulp', $pelanggan->ulp) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kriteria Prioritas</label>
                <select name="kriteria_prioritas" class="form-control" required>
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach(\App\Models\Pelanggan::KRITERIA_PRIORITAS_OPTIONS as $kriteria)
                    <option value="{{ $kriteria }}" {{ old('kriteria_prioritas', $pelanggan->kriteria_prioritas) == $kriteria ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $kriteria)) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection