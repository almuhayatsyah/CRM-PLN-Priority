@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Laporan Feedback Pelanggan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Laporan & Analitik</a></li>
    <li class="breadcrumb-item active">Laporan Feedback</li>
  </ol>

  {{-- Statistik Ringkasan Feedback --}}
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Feedback ({{ $tahunFilter }})</h5>
          <p class="card-text h2">{{ $totalFeedback ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-info mb-3">
        <div class="card-body">
          <h5 class="card-title">Feedback Baru</h5>
          <p class="card-text h2">{{ $feedbackBaru ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Feedback Selesai</h5>
          <p class="card-text h2">{{ $feedbackSelesai ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning mb-3">
        <div class="card-body">
          <h5 class="card-title">Rata-Rata Skor</h5>
          <p class="card-text h2">{{ number_format($rataRataSkor ?? 0, 1) }}</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Form Filter Laporan Feedback --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i> Filter Laporan Feedback
    </div>
    <div class="card-body">
      <form action="{{ route('admin.laporan.feedback') }}" method="GET">
        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label for="tahunFilter" class="form-label">Tahun</label>
            <select class="form-select" id="tahunFilter" name="tahun">
              @foreach($tahunOptions as $tahun)
              <option value="{{ $tahun }}" {{ $tahun == $tahunFilter ? 'selected' : '' }}>{{ $tahun }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="skorFilter" class="form-label">Skor</label>
            <select class="form-select" id="skorFilter" name="skor">
              <option value="">Semua Skor</option>
              @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ $i == $skorFilter ? 'selected' : '' }}>{{ $i }} Bintang</option>
                @endfor
            </select>
          </div>
          <div class="col-md-3">
            <label for="statusFilter" class="form-label">Status</label>
            <select class="form-select" id="statusFilter" name="status">
              <option value="">Semua Status</option>
              <option value="Baru" {{ 'Baru' == $statusFilter ? 'selected' : '' }}>Baru</option>
              <option value="Sedang Ditangani" {{ 'Sedang Ditangani' == $statusFilter ? 'selected' : '' }}>Sedang Ditangani</option>
              <option value="Selesai" {{ 'Selesai' == $statusFilter ? 'selected' : '' }}>Selesai</option>
            </select>
          </div>
          <div class="col-md-3 text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.laporan.feedback') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Tabel Detail Feedback --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Detail Data Feedback
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Pelanggan</th>
              <th>Skor</th>
              <th>Komentar</th>
              <th>Status</th>
              <th>Tanggal dan waktu Masuk</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($laporanFeedbacks as $feedback)
            <tr>
              <td>{{ $loop->iteration + ($laporanFeedbacks->currentPage() - 1) * $laporanFeedbacks->perPage() }}</td>
              <td>{{ $feedback->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
              <td>{{ $feedback->skor }}</td>
              <td>{{ Str::limit($feedback->komentar, 150) }}</td>
              <td>
                @if ($feedback->status == 'Baru')
                <span class="badge bg-primary">{{ $feedback->status }}</span>
                @elseif ($feedback->status == 'Sedang Ditangani')
                <span class="badge bg-warning text-dark">{{ $feedback->status }}</span>
                @else
                <span class="badge bg-success">{{ $feedback->status }}</span>
                @endif
              </td>
              <td>{{ $feedback->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">Tidak ada data feedback untuk laporan ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $laporanFeedbacks->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection