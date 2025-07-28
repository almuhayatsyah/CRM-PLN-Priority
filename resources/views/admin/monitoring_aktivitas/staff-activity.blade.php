@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Monitoring Aktivitas Staff</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Monitoring Aktivitas</a></li>
    <li class="breadcrumb-item active">Aktivitas Staff</li>
  </ol>

  {{-- Form Filter (opsional) --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i> Filter Staff
    </div>
    <div class="card-body">
      <form action="{{ route('admin.monitoring.staff-activity') }}" method="GET">
        <div class="row g-3 align-items-end">
          <div class="col-md-6">
            <label for="namaFilter" class="form-label">Cari Nama Staff</label>
            <input type="text" class="form-control" id="namaFilter" name="nama" value="{{ request('nama') }}">
          </div>
          <div class="col-md-6 text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.monitoring.staff-activity') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  {{-- Tabel Aktivitas Staff --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Data Aktivitas Staff
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Staff/User</th>
              <th>Role</th>
              <th>Login Terakhir</th>
              <th>Total Interaksi</th>
              <th>Total Kunjungan</th>
              <th>Kunjungan Selesai</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($allStaff as $user)
            <tr>
              <td>{{ $loop->iteration + ($allStaff->currentPage() - 1) * $allStaff->perPage() }}</td>
              <td>{{ $user->nama_lengkap }}</td>
              <td>
                @foreach($user->getRoleNames() as $role)
                <span class="badge bg-secondary">{{ $role }}</span>
                @endforeach
              </td>
              <td>{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d-m-Y H:i') : '-' }}</td>
              <td>{{ $user->interaksis_count }}</td>
              <td>{{ $user->jadwal_kunjungans_count }}</td>
              <td>{{ $user->completed_visits_count }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Tidak ada data aktivitas staff.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $allStaff->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection