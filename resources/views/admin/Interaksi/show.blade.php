@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Detail Interaksi Umum</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.interaksi.index') }}">Interaksi Umum</a></li>
    <li class="breadcrumb-item active">Detail</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Informasi Interaksi Umum
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-3"><strong>ID Interaksi:</strong></div>
        <div class="col-md-9">{{ $interaksi->id }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Pelanggan:</strong></div>
        <div class="col-md-9">
          {{ $interaksi->pelanggan->nama_perusahaan ?? 'N/A' }} ({{ $interaksi->pelanggan->nama ?? 'N/A' }})<br>
          <span class="text-muted">ID Pel: {{ $interaksi->pelanggan->id_pel ?? 'N/A' }}</span>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Dilakukan Oleh:</strong></div>
        <div class="col-md-9">{{ $interaksi->user->nama_lengkap ?? 'N/A' }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Jenis Interaksi:</strong></div>
        <div class="col-md-9">{{ $interaksi->jenis_interaksi }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Tanggal & Waktu:</strong></div>
        <div class="col-md-9">{{ \Carbon\Carbon::parse($interaksi->tanggal_interaksi)->format('d F Y H:i') }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Status:</strong></div>
        <div class="col-md-9">{{ $interaksi->status_interaksi }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Deskripsi:</strong></div>
        <div class="col-md-9">{{ $interaksi->deskripsi }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Dibuat Pada:</strong></div>
        <div class="col-md-9">{{ $interaksi->created_at->format('d F Y H:i:s') }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Terakhir Diperbarui:</strong></div>
        <div class="col-md-9">{{ $interaksi->updated_at->format('d F Y H:i:s') }}</div>
      </div>

      @role('admin|staff')
      <a href="{{ route('admin.interaksi.edit', $interaksi->id) }}" class="btn btn-warning">Edit</a>
      @endrole
      <a href="{{ route('admin.interaksi.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
  </div>
</div>
@endsection