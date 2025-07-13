@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Daftar Interaksi Pelanggan Umum</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Interaksi Umum</li>
  </ol>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-comments me-1"></i>
      Data Interaksi Umum
      @role('admin|staff')
      <a href="{{ route('admin.interaksi.create') }}" class="btn btn-primary btn-sm float-end">Tambah Interaksi Umum</a>
      @endrole
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
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
            @forelse ($interaksis as $interaksi)
            <tr>
              <td>{{ $loop->iteration + ($interaksis->currentPage() - 1) * $interaksis->perPage() }}</td>
              <td>{{ $interaksi->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
              <td>{{ $interaksi->jenis_interaksi }}</td>
              <td>{{ Str::limit($interaksi->deskripsi, 70) }}</td>
              <td>{{ \Carbon\Carbon::parse($interaksi->tanggal_interaksi)->format('d-m-Y H:i') }}</td>
              <td>{{ $interaksi->user->nama_lengkap ?? 'N/A' }}</td>
              <td>{{ $interaksi->status_interaksi }}</td>
              <td>
                @role('admin|staff')
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
          {{ $interaksis->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection