@extends('layouts.app')

@section('content')
<div class="container-fluid"> {{-- Gunakan container-fluid untuk konsistensi --}}
  <h2 class="mt-4">Tambah User Baru</h2> {{-- Tambahkan margin top --}}

  @if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert"> {{-- Tambahkan kelas Bootstrap untuk alert --}}
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card mb-4"> {{-- Bungkus form dalam card --}}
    <div class="card-header">
      <i class="fas fa-user-plus me-1"></i> Form Tambah User
    </div>
    <div class="card-body">
      <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"> {{-- PENTING: Tambahkan enctype --}}
        @csrf
        <div class="mb-3">
          <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required> {{-- Hapus $user --}}
          @error('nama_lengkap')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
          @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
          <label for="profile_photo" class="form-label">Foto Profil (Opsional)</label>
          <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo">
          @error('profile_photo')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required> {{-- Gunakan form-select --}}
            <option value="">-- Pilih Role --</option>
            @foreach ($roles as $role)
            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
            @endforeach
          </select>
          @error('role')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection