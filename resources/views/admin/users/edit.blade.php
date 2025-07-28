@extends('layouts.app')

@section('content')
<div class="container-fluid"> {{-- Gunakan container-fluid untuk konsistensi --}}
  <h2 class="mt-4">Edit User</h2>

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
      <i class="fas fa-edit me-1"></i> Form Edit User
    </div>
    <div class="card-body">
      <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"> {{-- PENTING: Tambahkan enctype --}}
        @csrf
        @method('PUT') {{-- Penting untuk update --}}

        <div class="mb-3">
          <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}" required>
          @error('nama_lengkap')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
          @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="mb-3">
          <label for="profile_photo" class="form-label">Foto Profil (Opsional)</label>
          @if ($user->profile_photo_path)
          <div class="mb-2">
            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto Profil" class="img-thumbnail rounded-circle" style="max-width: 150px; max-height: 150px; object-fit: cover;">
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
            <label class="form-check-label" for="remove_photo">Hapus Foto Profil</label>
          </div>
          @endif
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
            <option value="{{ $role->name }}" {{ (old('role', $user->roles->first()->name ?? '') == $role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
            @endforeach
          </select>
          @error('role')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection