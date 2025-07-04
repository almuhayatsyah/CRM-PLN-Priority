@extends('layouts.app')
@section('content')
<div class="container">
  <h2>Edit User</h2>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
      <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}" required>
      </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <select class="form-control" id="role" name="role" required>
        <option value="">-- Pilih Role --</option>
        @foreach ($roles as $role)
        <option value="{{ $role->name }}" {{ (old('role', $user->roles->first()->name ?? '') == $role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
        @endforeach
        </select>
    </div>
      <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
