@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Detail Notifikasi</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.notifikasi.index') }}">Notifikasi</a></li>
    <li class="breadcrumb-item active">Detail</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Informasi Notifikasi
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-3"><strong>ID Notifikasi:</strong></div>
        <div class="col-md-9">{{ $notifikasi->id }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Penerima:</strong></div>
        <div class="col-md-9">{{ $notifikasi->user->name ?? 'N/A' }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Waktu Notifikasi:</strong></div>
        <div class="col-md-9">{{ $notifikasi->created_at->format('d F Y H:i:s') }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Status:</strong></div>
        <div class="col-md-9">
          @if ($notifikasi->dibaca)
          <span class="badge bg-success">Sudah Dibaca</span>
          @else
          <span class="badge bg-danger">Belum Dibaca</span>
          @endif
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Pesan:</strong></div>
        <div class="col-md-9">{{ $notifikasi->pesan }}</div>
      </div>

      <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-secondary">Kembali</a>
      @role('admin')
      <form action="{{ route('admin.notifikasi.update', $notifikasi->id) }}" method="POST" class="d-inline ms-2">
        @csrf
        @method('PUT')
        <input type="hidden" name="dibaca" value="{{ $notifikasi->dibaca ? '0' : '1' }}"> {{-- Toggle status --}}
        <button type="submit" class="btn {{ $notifikasi->dibaca ? 'btn-warning' : 'btn-success' }}">{{ $notifikasi->dibaca ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}</button>
      </form>
      <form action="{{ route('admin.notifikasi.destroy', $notifikasi->id) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
      </form>
      @endrole
    </div>
  </div>
</div>
@endsection