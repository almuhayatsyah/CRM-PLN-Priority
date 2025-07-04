@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Pelanggan</h4>
        <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i> Tambah Pelanggan</a>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>ID Pel</th>
                    <th>Kode PLN</th>
                    <th>Nama Perusahaan</th>
                    <th>Nama PIC</th>
                    <th>Kontak</th>
                    <th>Kapasitas Daya</th>
                    <th>Sektor</th>
                    <th>Peruntukan</th>
                    <th>UP3</th>
                    <th>ULP</th>
                    <th>Kriteria Prioritas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $item)
                <tr>
                    <td>{{ ($pelanggan->currentPage() - 1) * $pelanggan->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->id_pel }}</td>
                    <td>{{ $item->kode_PLN }}</td>
                    <td>{{ $item->nama_perusahaan }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kontak }}</td>
                    <td>{{ $item->kapasitas_daya }}</td>
                    <td>{{ $item->sektor }}</td>
                    <td>{{ $item->peruntukan }}</td>
                    <td>{{ $item->up3 }}</td>
                    <td>{{ $item->ulp }}</td>
                    <td>{{ $item->kriteria_prioritas }}</td>
                    <td>
                        <a href="{{ route('admin.pelanggan.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.pelanggan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">Belum ada data pelanggan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $pelanggan->links() }}
        </div>
    </div>
</div>
@endsection