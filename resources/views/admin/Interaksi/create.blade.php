@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Tambah Interaksi Umum Baru</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.interaksi.index') }}">Interaksi Umum</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Form Interaksi Umum
    </div>
    <div class="card-body">
      <form action="{{ route('admin.interaksi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="pelanggan_id" class="form-label">Pelanggan</label>
          <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required>
            <option value="">Pilih Pelanggan</option>
            @foreach ($pelanggans as $pelanggan)
            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
              {{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }})
            </option>
            @endforeach
          </select>
          @error('pelanggan_id')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="user_id" class="form-label">Staff Pelaksana</label> {{-- Atau 'Dilakukan Oleh' --}}
          <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
            <option value="">Pilih Staff/Admin</option>
            @foreach ($users as $user) {{-- <--- PASTI ADA '$users' DI SINI --}}
            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
              {{ $user->nama_lengkap }}
            </option>
            @endforeach
          </select>
          @error('user_id')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="jenis_interaksi" class="form-label">Jenis Interaksi</label>
          <input type="text" class="form-control @error('jenis_interaksi') is-invalid @enderror" id="jenis_interaksi" name="jenis_interaksi" value="{{ old('jenis_interaksi') }}" placeholder="Contoh: Telepon, Email, Chat" required>
          @error('jenis_interaksi')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi</label>
          <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
          @error('deskripsi')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="tanggal_interaksi" class="form-label">Tanggal & Waktu Interaksi</label>
          <input type="datetime-local" class="form-control @error('tanggal_interaksi') is-invalid @enderror" id="tanggal_interaksi" name="tanggal_interaksi" value="{{ old('tanggal_interaksi') }}" required>
          @error('tanggal_interaksi')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="status_interaksi" class="form-label">Status Interaksi</label>
          <select class="form-select @error('status_interaksi') is-invalid @enderror" id="status_interaksi" name="status_interaksi" required>
            <option value="Open" {{ old('status_interaksi') == 'Open' ? 'selected' : '' }}>Open</option>
            <option value="Resolved" {{ old('status_interaksi') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            <option value="Follow-up" {{ old('status_interaksi') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
          </select>
          @error('status_interaksi')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Interaksi</button>
        <a href="{{ route('admin.interaksi.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection