@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Tambah Jadwal Kunjungan Baru</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.jadwal-kunjungan.index') }}">Jadwal Kunjungan</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Form Jadwal Kunjungan
    </div>
    <div class="card-body">
      <form action="{{ route('admin.jadwal-kunjungan.store') }}" method="POST">
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
          <label for="user_id" class="form-label">Staff Pelaksana</label>
          <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
            <option value="">Pilih Staff</option>
            @foreach ($users as $user)
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
          <label for="tanggal_jadwal" class="form-label">Tanggal & Waktu Jadwal</label>
          <input type="datetime-local" class="form-control @error('tanggal_jadwal') is-invalid @enderror" id="tanggal_jadwal" name="tanggal_jadwal" value="{{ old('tanggal_jadwal') }}" required>
          @error('tanggal_jadwal')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="tujuan" class="form-label">Tujuan Kunjungan</label>
          <textarea class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" rows="3" required>{{ old('tujuan') }}</textarea>
          @error('tujuan')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="dijadwalkan" {{ old('status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Batal</option>
          </select>
          @error('status')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="hasil" class="form-label">Hasil Kunjungan (Opsional)</label>
          <textarea class="form-control @error('hasil') is-invalid @enderror" id="hasil" name="hasil" rows="3">{{ old('hasil') }}</textarea>
          @error('hasil')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
        <a href="{{ route('admin.jadwal-kunjungan.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection