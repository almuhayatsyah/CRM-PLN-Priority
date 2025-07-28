@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Notifikasi Sistem</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Notifikasi</li>
  </ol>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  {{-- Form Filter --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i> Filter Notifikasi
    </div>
    <div class="card-body">
      <form action="{{ route('admin.notifikasi.index') }}" method="GET">
        <div class="row g-3 align-items-end">
          @role('admin') {{-- Hanya admin yang bisa filter user penerima --}}
          <div class="col-md-4">
            <label for="user_id_filter" class="form-label">User Penerima</label>
            <select class="form-select" id="user_id_filter" name="user_id">
              <option value="">Semua User</option>
              @foreach($allUsers as $user)
              <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>
          @endrole
          <div class="{{ Auth::user()->hasRole('admin') ? 'col-md-4' : 'col-md-6' }}">
            <label for="status_dibaca_filter" class="form-label">Status</label>
            <select class="form-select" id="status_dibaca_filter" name="status_dibaca">
              <option value="">Semua Status</option>
              <option value="0" {{ request('status_dibaca') == '0' ? 'selected' : '' }}>Belum Dibaca</option>
              <option value="1" {{ request('status_dibaca') == '1' ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>
          </div>
          <div class="{{ Auth::user()->hasRole('admin') ? 'col-md-4' : 'col-md-6' }} text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Data Notifikasi
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              @role('admin') <th>Penerima</th> @endrole {{-- Hanya admin yang lihat --}}
              <th>Pesan</th>
              <th>Status</th>
              <th>Waktu</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($notifikasis as $notifikasi)
            <tr class="{{ !$notifikasi->dibaca ? 'fw-bold bg-light' : '' }}"> {{-- Notifikasi belum dibaca lebih tebal --}}
              <td>{{ $loop->iteration + ($notifikasis->currentPage() - 1) * $notifikasis->perPage() }}</td>
              @role('admin') <td>{{ $notifikasi->user->name ?? 'N/A' }}</td> @endrole
              <td>{{ Str::limit($notifikasi->pesan, 150) }}</td>
              <td>
                @if ($notifikasi->dibaca)
                <span class="badge bg-success">Sudah Dibaca</span>
                @else
                <span class="badge bg-danger">Belum Dibaca</span>
                @endif
              </td>
              <td>{{ $notifikasi->created_at->format('d-m-Y H:i') }}</td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('admin.notifikasi.show', $notifikasi->id) }}" class="btn btn-info btn-sm">Detail</a>
                  @role('admin')
                  @if (!$notifikasi->dibaca)
                  <form action="{{ route('admin.notifikasi.update', $notifikasi->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="dibaca" value="1">
                    <button type="submit" class="btn btn-success btn-sm" title="Tandai Sudah Dibaca">Baca</button>
                  </form>
                  @else
                  <form action="{{ route('admin.notifikasi.update', $notifikasi->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="dibaca" value="0">
                    <button type="submit" class="btn btn-warning btn-sm" title="Tandai Belum Dibaca">Belum Baca</button>
                  </form>
                  @endif
                  <form action="{{ route('admin.notifikasi.destroy', $notifikasi->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">Hapus</button>
                  </form>
                  @endrole
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="{{ Auth::user()->hasRole('admin') ? '6' : '5' }}" class="text-center">Tidak ada notifikasi sistem.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $notifikasis->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection