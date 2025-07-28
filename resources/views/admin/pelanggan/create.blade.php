@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Tambah Pelanggan</h4>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="notes-box alert alert-info mb-3">
        <strong>Catatan:</strong> Silakan isi data pelanggan dengan lengkap dan benar. Email dan password akan digunakan untuk login pelanggan. Semua field bertanda <span class="text-danger">*</span> wajib diisi.
    </div>

    <form action="{{ route('admin.pelanggan.store') }}" method="POST" enctype="multipart/form-data"> {{-- PENTING: Tambahkan enctype --}}
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-id-card me-1"></i>ID Pel <span class="text-danger">*</span></label>
                <input type="text" name="id_pel" class="form-control @error('id_pel') is-invalid @enderror" value="{{ old('id_pel') }}" required>
                @error('id_pel')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-key me-1"></i>Kode PLN <span class="text-danger">*</span></label>
                <input type="text" name="kode_PLN" class="form-control @error('kode_PLN') is-invalid @enderror" value="{{ old('kode_PLN') }}" required>
                @error('kode_PLN')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-building me-1"></i>Nama Perusahaan <span class="text-danger">*</span></label>
                <input type="text" name="nama_perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" value="{{ old('nama_perusahaan') }}" required>
                @error('nama_perusahaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-user me-1"></i>Nama PIC <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-phone me-1"></i>Kontak</label>
                <input type="text" name="kontak" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak') }}">
                @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-bolt me-1"></i>Kapasitas Daya</label>
                <input type="number" step="0.01" name="kapasitas_daya" class="form-control @error('kapasitas_daya') is-invalid @enderror" value="{{ old('kapasitas_daya') }}">
                @error('kapasitas_daya')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-industry me-1"></i>Sektor <span class="text-danger">*</span></label>
                <select name="sektor" class="form-select @error('sektor') is-invalid @enderror" required>
                    <option value="">-- Pilih Sektor --</option>
                    @foreach(\App\Models\Pelanggan::SEKTOR_OPTIONS as $sektor)
                    <option value="{{ $sektor }}" {{ old('sektor') == $sektor ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $sektor)) }}
                    </option>
                    @endforeach
                </select>
                @error('sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-clipboard-list me-1"></i>Peruntukan</label>
                <input type="text" name="peruntukan" class="form-control @error('peruntukan') is-invalid @enderror" value="{{ old('peruntukan') }}">
                @error('peruntukan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>UP3 <span class="text-danger">*</span></label>
                <select name="up3" class="form-select @error('up3') is-invalid @enderror" required>
                    <option value="">-- Pilih UP3 --</option>
                    @foreach(\App\Models\Pelanggan::UP3_OPTIONS as $up3)
                    <option value="{{ $up3 }}" {{ old('up3') == $up3 ? 'selected' : '' }}>{{ $up3 }}</option>
                    @endforeach
                </select>
                @error('up3')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>ULP</label>
                <input type="text" name="ulp" class="form-control @error('ulp') is-invalid @enderror" value="{{ old('ulp') }}">
                @error('ulp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-star me-1"></i>Kriteria Prioritas <span class="text-danger">*</span></label>
                <select name="kriteria_prioritas" class="form-select @error('kriteria_prioritas') is-invalid @enderror" required>
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach(\App\Models\Pelanggan::KRITERIA_PRIORITAS_OPTIONS as $kriteria)
                    <option value="{{ $kriteria }}" {{ old('kriteria_prioritas') == $kriteria ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $kriteria)) }}
                    </option>
                    @endforeach
                </select>
                @error('kriteria_prioritas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- FOTO PROFIL PELANGGAN --}}
            <div class="col-md-12">
                <label for="profile_photo_pelanggan" class="form-label"><i class="fas fa-image me-1"></i>Foto Profil Pelanggan (Opsional)</label>
                <input type="file" class="form-control @error('profile_photo_pelanggan') is-invalid @enderror" id="profile_photo_pelanggan" name="profile_photo_pelanggan">
                @error('profile_photo_pelanggan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <h5 class="mt-4 mb-3">Informasi Login Pelanggan</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label for="user_email" class="form-label"><i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('user_email') is-invalid @enderror" id="user_email" name="user_email" value="{{ old('user_email') }}" required>
                @error('user_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="user_password" class="form-label"><i class="fas fa-lock me-1"></i>Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('user_password') is-invalid @enderror" id="user_password" name="user_password" required>
                @error('user_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="user_password_confirmation" class="form-label"><i class="fas fa-lock me-1"></i>Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('user_password_confirmation') is-invalid @enderror" id="user_password_confirmation" name="user_password_confirmation" required>
                @error('user_password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary me-2">Simpan</button>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection