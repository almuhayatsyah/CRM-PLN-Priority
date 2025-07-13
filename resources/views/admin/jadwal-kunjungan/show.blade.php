@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Detail Jadwal Kunjungan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.jadwal-kunjungan.index') }}">Jadwal Kunjungan</a></li>
    <li class="breadcrumb-item active">Detail</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Informasi Jadwal Kunjungan
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-3"><strong>ID Kunjungan:</strong></div>
        <div class="col-md-9">{{ $jadwalKunjungan->id }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Pelanggan:</strong></div>
        <div class="col-md-9">
          {{ $jadwalKunjungan->pelanggan->nama_perusahaan ?? 'N/A' }} ({{ $jadwalKunjungan->pelanggan->nama ?? 'N/A' }})<br>
          <span class="text-muted">ID Pel: {{ $jadwalKunjungan->pelanggan->id_pel ?? 'N/A' }}</span>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Staff Pelaksana:</strong></div>
        <div class="col-md-9">{{ $jadwalKunjungan->user->nama_lengkap ?? 'N/A' }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Tanggal & Waktu Jadwal:</strong></div>
        <div class="col-md-9">{{ \Carbon\Carbon::parse($jadwalKunjungan->tanggal_jadwal)->format('d F Y H:i') }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Tujuan Kunjungan:</strong></div>
        <div class="col-md-9">{{ $jadwalKunjungan->tujuan }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Status:</strong></div>
        <div class="col-md-9">{{ $jadwalKunjungan->status }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Hasil Kunjungan:</strong></div>
        <div class="col-md-9">{{ $jadwalKunjungan->hasil ?? 'Belum ada hasil' }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Dibuat Pada:</strong></div>
        <div class="col-md-9">{{ $jadwalKunjungan->created_at->format('d F Y H:i:s') }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"><strong>Terakhir Diperbarui:</strong></div>
        <div class="col-md-9">{{ $jadwalKunjungan->updated_at->format('d F Y H:i:s') }}</div>
      </div>

      <a href="{{ route('admin.jadwal-kunjungan.edit', $jadwalKunjungan->id) }}" class="btn btn-warning">Edit</a>
      <a href="{{ route('admin.jadwal-kunjungan.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
  </div>
</div>
@endsection