@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Detail Pemakaian Daya</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.pemakaian-daya.index') }}">Pemakaian Daya</a></li>
    <li class="breadcrumb-item active">Detail</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Informasi Pemakaian Daya
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-4"><strong>ID Catatan:</strong></div>
        <div class="col-md-8">{{ $pemakaianDaya->id }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Pelanggan:</strong></div>
        <div class="col-md-8">{{ $pemakaianDaya->pelanggan->nama_perusahaan ?? 'N/A' }} ({{ $pemakaianDaya->pelanggan->nama ?? 'N/A' }})</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Bulan & Tahun:</strong></div>
        <div class="col-md-8">{{ $pemakaianDaya->bulan_tahun }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Pemakaian Kwh:</strong></div>
        <div class="col-md-8">{{ number_format($pemakaianDaya->pemakaian_Kwh, 2) }} kWh</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Beban Anomali:</strong></div>
        <div class="col-md-8">{{ number_format($pemakaianDaya->beban_anomali, 2) ?? '-' }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Flag Anomali:</strong></div>
        <div class="col-md-8">
          @if ($pemakaianDaya->flag_anomali == 1)
          <span class="badge bg-danger">Anomali</span>
          @else
          <span class="badge bg-success">Normal</span>
          @endif
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Dibuat Pada:</strong></div>
        <div class="col-md-8">{{ $pemakaianDaya->created_at->format('d F Y H:i:s') }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Terakhir Diperbarui:</strong></div>
        <div class="col-md-8">{{ $pemakaianDaya->updated_at->format('d F Y H:i:s') }}</div>
      </div>

      @role('admin|staff')
      <a href="{{ route('admin.pemakaian-daya.edit', $pemakaianDaya->id) }}" class="btn btn-warning">Edit</a>
      @endrole
      <a href="{{ route('admin.pemakaian-daya.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
  </div>
</div>
@endsection