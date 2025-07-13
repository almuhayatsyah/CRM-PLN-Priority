@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Daftar Feedback Pelanggan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Feedback</li>
  </ol>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="d-flex justify-content-end mb-3">
    @role('admin|staff') {{-- Hanya admin atau staff yang bisa menambah --}}
    <a href="{{ route('admin.feedback.create') }}" class="btn btn-primary">
      <i class="fas fa-plus me-1"></i> Tambah Feedback
    </a>
    @endrole
  </div>

  {{-- Form Filter --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i>
      Filter Feedback
    </div>
    <div class="card-body">
      <form action="{{ route('admin.feedback.index') }}" method="GET">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="pelanggan_id" class="form-label">Pelanggan</label>
            <select class="form-select" id="pelanggan_id" name="pelanggan_id">
              <option value="">Semua Pelanggan</option>
              @foreach ($allPelanggans as $pelanggan)
              <option value="{{ $pelanggan->id }}" {{ request('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                {{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }})
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="skor" class="form-label">Skor</label>
            <select class="form-select" id="skor" name="skor">
              <option value="">Semua Skor</option>
              @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ request('skor') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                @endfor
            </select>
          </div>
          <div class="col-md-4">
            <label for="status_feedback" class="form-label">Status</label>
            <select class="form-select" id="status_feedback" name="status_feedback">
              <option value="">Semua Status</option>
              <option value="Baru" {{ request('status_feedback') == 'Baru' ? 'selected' : '' }}>Baru</option>
              <option value="Sedang Ditangani" {{ request('status_feedback') == 'Sedang Ditangani' ? 'selected' : '' }}>Sedang Ditangani</option>
              <option value="Selesai" {{ request('status_feedback') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Data Feedback
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Pelanggan</th>
              <th>Skor</th>
              <th>Komentar</th>
              <th>Status</th>
              <th>Tanggal Masuk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($feedbacks as $feedback)
            <tr>
              <td>{{ $loop->iteration + ($feedbacks->currentPage() - 1) * $feedbacks->perPage() }}</td>
              <td>{{ $feedback->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
              <td>{{ $feedback->skor }}</td>
              <td>{{ Str::limit($feedback->komentar, 100) }}</td>
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
              <td>
                @role('admin|staff')
                <a href="{{ route('admin.feedback.edit', $feedback->id) }}" class="btn btn-warning btn-sm">Edit Status</a>
                <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus feedback ini?')">Hapus</button>
                </form>
                @endrole
                @role('admin|manajer|staff')
                <a href="{{ route('admin.feedback.show', $feedback->id) }}" class="btn btn-info btn-sm">Detail</a>
                @endrole
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Tidak ada data feedback.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $feedbacks->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection