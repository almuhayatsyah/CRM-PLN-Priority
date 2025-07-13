@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Kunjungan & Interaksi Pelanggan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Monitoring Aktivitas</a></li>
    <li class="breadcrumb-item active">Kunjungan & Interaksi</li>
  </ol>

  {{-- Pesan Sukses (jika ada, dari redirect Controller lain) --}}
  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  {{-- Form Filter --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i>
      Filter Data Kunjungan & Interaksi
    </div>
    <div class="card-body">
      <form action="{{ route('admin.monitoring.kunjungan-interaksi') }}" method="GET">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="pelanggan_id" class="form-label">Pelanggan</label>
            <select class="form-select" id="pelanggan_id" name="pelanggan_id">
              <option value="">Semua Pelanggan</option>
              @foreach ($allPelanggans as $pelanggan) {{-- Loop melalui data pelanggan --}}
              <option value="{{ $pelanggan->id }}" {{ request('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                {{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }}) ({{ $pelanggan->id_pel }})
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="user_id" class="form-label">Staff Pelaksana</label>
            <select class="form-select" id="user_id" name="user_id">
              <option value="">Semua Staff</option>
              @foreach ($allUsers as $user)
              <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="interaksi_status" class="form-label">Status Interaksi Umum</label>
            <select class="form-select" id="interaksi_status" name="interaksi_status">
              <option value="">Semua Status</option>
              <option value="Open" {{ request('interaksi_status') == 'Open' ? 'selected' : '' }}>Open</option>
              <option value="Resolved" {{ request('interaksi_status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
              <option value="Follow-up" {{ request('interaksi_status') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="kunjungan_status" class="form-label">Status Jadwal Kunjungan</label>
            <select class="form-select" id="kunjungan_status" name="kunjungan_status">
              <option value="">Semua Status</option>
              <option value="dijadwalkan" {{ request('kunjungan_status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
              <option value="selesai" {{ request('kunjungan_status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
              <option value="batal" {{ request('kunjungan_status') == 'batal' ? 'selected' : '' }}>Batal</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
          </div>
          <div class="col-md-4">
            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.monitoring.kunjungan-interaksi') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>


  {{-- Tombol Tambah --}}
  <div class="d-flex justify-content-end mb-3">
    {{-- Tombol untuk menambah Interaksi Umum --}}
    <a href="{{ route('admin.interaksi.create') }}" class="btn btn-primary me-2">
      <i class="fas fa-plus me-1"></i> Tambah Interaksi Umum
    </a>
    {{-- Tombol untuk menambah Jadwal Kunjungan --}}
    <a href="{{ route('admin.jadwal-kunjungan.create') }}" class="btn btn-success">
      <i class="fas fa-calendar-plus me-1"></i> Buat Jadwal Kunjungan
    </a>
  </div>

  {{-- Bagian Daftar Interaksi Pelanggan Umum --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-comments me-1"></i>
      Daftar Interaksi Pelanggan Umum
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Id Pelanggan</pel>
              <th>Pelanggan</th>
              <th>Jenis</th>
              <th>Deskripsi</th>
              <th>Tanggal</th>
              <th>Oleh</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($interaksiPelanggan as $interaksi)
            <tr>
              <td>{{ $loop->iteration + ($interaksiPelanggan->currentPage() - 1) * $interaksiPelanggan->perPage() }}</td>
              <td>{{ $interaksi->pelanggan->id_pel ?? 'N/A' }}</td>
              <td>{{ $interaksi->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
              <td>{{ $interaksi->jenis_interaksi }}</td>
              <td>{{ Str::limit($interaksi->deskripsi, 70) }}</td>
              <td>{{ \Carbon\Carbon::parse($interaksi->tanggal_interaksi)->format('d-m-Y H:i') }}</td>
              <td>{{ $interaksi->user->nama_lengkap ?? 'N/A' }}</td>
              <td>{{ $interaksi->status_interaksi }}</td>
              <td>
                @role('admin')
                <a href="{{ route('admin.interaksi.edit', $interaksi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.interaksi.destroy', $interaksi->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus interaksi ini?')">Hapus</button>
                </form>
                @endrole
                @role('admin|manajer|staff')
                <a href="{{ route('admin.interaksi.show', $interaksi->id) }}" class="btn btn-info btn-sm">Detail</a>
                @endrole
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">Tidak ada data interaksi pelanggan umum.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $interaksiPelanggan->links() }}
        </div>
      </div>
    </div>
  </div>

  {{-- Bagian Daftar Jadwal Kunjungan --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-calendar-alt me-1"></i>
      Daftar Jadwal Kunjungan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Id Pel</th>
              <th>Pelanggan</th>
              <th>Staff</th>
              <th>Tanggal Jadwal</th>
              <th>Tujuan</th>
              <th>Hasil</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($jadwalKunjungans as $kunjungan)
            <tr>
              <td>{{ $loop->iteration + ($jadwalKunjungans->currentPage() - 1) * $jadwalKunjungans->perPage() }}</td>
              <td>{{ $kunjungan->pelanggan->id_pel ?? 'N/A' }}</td>
              <td>{{ $kunjungan->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
              <td>{{ $kunjungan->user->nama_lengkap ?? 'N/A' }}</td>
              <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_jadwal)->format('d-m-Y H:i') }}</td>
              <td>{{ Str::limit($kunjungan->tujuan, 70) }}</td>
              <td>{{ Str::limit($kunjungan->hasil, 70) ?? '-' }}</td>
              <td>{{ $kunjungan->status }}</td>
              <td>
                @role('admin')
                <a href="{{ route('admin.jadwal-kunjungan.edit', $kunjungan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.jadwal-kunjungan.destroy', $kunjungan->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal kunjungan ini?')">Hapus</button>
                </form>
                @endrole
                @role('admin|manajer|staff')
                <a href="{{ route('admin.jadwal-kunjungan.show', $kunjungan->id) }}" class="btn btn-info btn-sm">Detail</a>
                @endrole
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">Tidak ada data jadwal kunjungan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $jadwalKunjungans->links() }}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection