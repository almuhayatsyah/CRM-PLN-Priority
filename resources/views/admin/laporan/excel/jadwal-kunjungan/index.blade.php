@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Daftar Jadwal Kunjungan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Jadwal Kunjungan</li>
  </ol>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Data Jadwal Kunjungan
      @role('admin|staff') {{-- Hanya admin dan staff yang bisa menambah --}}
      <a href="{{ route('admin.jadwal-kunjungan.create') }}" class="btn btn-primary btn-sm float-end">Tambah Jadwal Kunjungan</a>
      @endrole
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
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
              <td>{{ $kunjungan->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
              <td>{{ $kunjungan->user->nama_lengkap ?? 'N/A' }}</td>
              <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_jadwal)->format('d-m-Y H:i') }}</td>
              <td>{{ Str::limit($kunjungan->tujuan, 50) }}</td>
              <td>{{ Str::limit($kunjungan->hasil, 50) ?? '-' }}</td>
              <td>{{ $kunjungan->status }}</td>
              <td>
                @role('admin|staff|manajer') {{-- Admin, Staff, Manajer bisa melihat detail --}}
                <a href="{{ route('admin.jadwal-kunjungan.show', $kunjungan->id) }}" class="btn btn-info btn-sm">Detail</a>
                @endrole
                @role('admin|staff') {{-- Admin & Staff bisa edit/hapus --}}
                <a href="{{ route('admin.jadwal-kunjungan.edit', $kunjungan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.jadwal-kunjungan.destroy', $kunjungan->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal kunjungan ini?')">Hapus</button>
                </form>
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