@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
      <div class="card shadow mb-4" style="min-width: 700px;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Detail Pelanggan</h4>
          <span class="badge bg-info text-dark">ID Pelanggan: {{ $pelanggan->id_pel }}</span>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-building me-1"></i>Nama Perusahaan:</strong><br>
              {{ $pelanggan->nama_perusahaan }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-user me-1"></i>Nama PIC:</strong><br>
              {{ $pelanggan->nama }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-envelope me-1"></i>Email:</strong><br>
              <span class="badge bg-success text-white">{{ $pelanggan->user->email ?? '-' }}</span>
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-phone me-1"></i>Kontak:</strong><br>
              {{ $pelanggan->kontak }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-bolt me-1"></i>Kapasitas Daya:</strong><br>
              {{ $pelanggan->kapasitas_daya }} kWh
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-industry me-1"></i>Sektor:</strong><br>
              {{ $pelanggan->sektor }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-clipboard-list me-1"></i>Peruntukan:</strong><br>
              {{ $pelanggan->peruntukan }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-map-marker-alt me-1"></i>UP3:</strong><br>
              {{ $pelanggan->up3 }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-map-marker-alt me-1"></i>ULP:</strong><br>
              {{ $pelanggan->ulp }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-key me-1"></i>Kode PLN:</strong><br>
              {{ $pelanggan->kode_PLN }}
            </div>
            <div class="col-md-6 mb-2">
              <strong><i class="fas fa-star me-1"></i>Kriteria Prioritas:</strong><br>
              <span class="badge bg-warning text-dark">{{ $pelanggan->kriteria_prioritas }}</span>
            </div>
          </div>
          <hr>
          <div class="row mb-2">
            <div class="col-md-6">
              <strong>Dibuat pada:</strong> {{ $pelanggan->created_at->format('d-m-Y H:i') }}
            </div>
            <div class="col-md-6">
              <strong>Update Terakhir:</strong> {{ $pelanggan->updated_at->format('d-m-Y H:i') }}
            </div>
          </div>
          <div class="mt-4 d-flex gap-2">
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection