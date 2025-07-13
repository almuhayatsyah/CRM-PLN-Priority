@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Detail Feedback Pelanggan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.feedback.index') }}">Feedback</a></li>
    <li class="breadcrumb-item active">Detail</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Informasi Feedback
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-4"><strong>ID Feedback:</strong></div>
        <div class="col-md-8">{{ $feedback->id }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Pelanggan:</strong></div>
        <div class="col-md-8">{{ $feedback->pelanggan->nama_perusahaan ?? 'N/A' }} ({{ $feedback->pelanggan->nama ?? 'N/A' }})</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Skor:</strong></div>
        <div class="col-md-8">{{ $feedback->skor }} Bintang</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Komentar:</strong></div>
        <div class="col-md-8">{{ $feedback->komentar }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Status:</strong></div>
        <div class="col-md-8">
          @if ($feedback->status == 'Baru')
          <span class="badge bg-primary">{{ $feedback->status }}</span>
          @elseif ($feedback->status == 'Sedang Ditangani')
          <span class="badge bg-warning text-dark">{{ $feedback->status }}</span>
          @else
          <span class="badge bg-success">{{ $feedback->status }}</span>
          @endif
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Tanggal Masuk:</strong></div>
        <div class="col-md-8">{{ $feedback->created_at->format('d F Y H:i:s') }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4"><strong>Terakhir Diperbarui:</strong></div>
        <div class="col-md-8">{{ $feedback->updated_at->format('d F Y H:i:s') }}</div>
      </div>

      @role('admin|staff')
      <a href="{{ route('admin.feedback.edit', $feedback->id) }}" class="btn btn-warning">Edit Status</a>
      @endrole
      <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
  </div>
</div>
@endsection