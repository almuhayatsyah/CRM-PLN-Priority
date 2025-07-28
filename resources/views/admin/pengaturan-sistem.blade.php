@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Pengaturan Sistem</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengaturan Sistem</li>
  </ol>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
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

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-cogs me-1"></i>
      Konfigurasi Umum Sistem
    </div>
    <div class="card-body">
      <form action="{{ route('admin.pengaturan-sistem.update') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="nama_sistem" class="form-label">Nama Sistem</label>
          <input type="text" class="form-control @error('nama_sistem') is-invalid @enderror" id="nama_sistem" name="nama_sistem" value="{{ old('nama_sistem', $namaSistem) }}" required>
          @error('nama_sistem')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="email_kontak" class="form-label">Email Kontak Admin</label>
          <input type="email" class="form-control @error('email_kontak') is-invalid @enderror" id="email_kontak" name="email_kontak" value="{{ old('email_kontak', $contactEmail) }}" required>
          @error('email_kontak')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input @error('notif_anomali_email') is-invalid @enderror" id="notif_anomali_email" name="notif_anomali_email" value="1" {{ old('notif_anomali_email', $notifAnomaliEmail) ? 'checked' : '' }}>
          <label class="form-check-label" for="notif_anomali_email">Aktifkan Notifikasi Email Anomali Daya</label>
          @error('notif_anomali_email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>

  {{-- Opsi Backup / Restore Data (Untuk nanti jika ada waktu) --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-database me-1"></i>
      Manajemen Data & Backup
    </div>
    <div class="card-body">
      <p>Fitur backup dan restore database dapat ditambahkan di sini.</p>
      <button class="btn btn-info me-2">Backup Database</button>
      <button class="btn btn-danger">Bersihkan Data Lama</button>
    </div>
  </div>
</div>
@endsection