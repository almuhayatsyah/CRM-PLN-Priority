@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Daftar Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Daftar Pelanggan</a></li>
        <!-- <li class="breadcrumb-item active">Kunjungan & Interaksi</li> -->
    </ol>
    <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i> Tambah Pelanggan</a>
</div>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Statistik Jumlah Pelanggan Berdasarkan Kriteria Prioritas -->
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-bolt fa-2x text-warning"></i>
                </div>
                <div>
                    <div class="fw-bold">Tegangan Menengah</div>
                    <div class="fs-4">{{ $pelanggan->where('kriteria_prioritas', 'tegangan_menengah')->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-bolt fa-2x text-primary"></i>
                </div>
                <div>
                    <div class="fw-bold">Tegangan Tinggi</div>
                    <div class="fs-4">{{ $pelanggan->where('kriteria_prioritas', 'tegangan_tinggi')->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-users fa-2x text-secondary"></i>
                </div>
                <div>
                    <div class="fw-bold">Total Pelanggan</div>
                    <div class="fs-4">{{ $pelanggan->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- searching dan drop down filtering pelanggan -->
<div class="mb-3 d-flex gap-2 align-items-center">
    <div style="width: 200px;">
        <input type="text" id="namaPelangganFilter" class="form-control form-control-sm" placeholder="Cari nama pelanggan...">
    </div>
    <div style="width: 200px;">
        <select id="idPelFilter" class="form-select form-select-sm">
            <option value="">Semua ID Pel</option>
            @foreach($pelanggan as $item)
            <option value="{{ $item->id_pel }}">{{ $item->id_pel }}</option>
            @endforeach
        </select>
    </div>
    <div style="width: 200px;">
        <select id="up3Filter" class="form-select form-select-sm">
            <option value="">Semua UP3</option>
            @foreach(\App\Models\Pelanggan::UP3_OPTIONS as $up3)
            <option value="{{ $up3 }}">{{ $up3 }}</option>
            @endforeach
        </select>
    </div>
    <div style="width: 200px;">
        <select id="sektorFilter" class="form-select form-select-sm">
            <option value="">Semua sektor</option>
            @foreach(\App\Models\Pelanggan::SEKTOR_OPTIONS as $sektor)
            <option value="{{ $sektor }}">{{ $sektor }}</option>
            @endforeach
        </select>
    </div>
    <!-- endd -->

</div>
<!-- Tabel Pelanggan -->
<div class="mb-2">
    <a href="{{ route('admin.monitoring.kunjungan-interaksi') }}" class="btn btn-secondary mb-2 me-2">
        <i class="fas fa-users"></i> Kunjungan & Interaksi
    </a>
    <a href="{{ route('admin.pelanggan.exportPdf') }}" class="btn btn-danger me-2">
        <i class="fas fa-file-pdf me-1"></i> Export PDF
    </a>
    <a href="{{ route('admin.pelanggan.exportExcel') }}" class="btn btn-success"> {{-- <-- PASTIKAN INI --}}
        <i class="fas fa-file-excel me-1"></i> Export Excel
    </a>
</div>
<div class="table-responsive">
    <table id="tabel-pelanggan" class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th><i class="fas fa-id-card me-1"></i>ID Pel</th>
                <th><i class="fas fa-key me-1"></i>Kode PLN</th>
                <th><i class="fas fa-building me-1"></i>Nama Perusahaan</th>
                <th><i class="fas fa-envelope me-1 text-success"></i>Email</th>
                <th><i class="fas fa-user me-1"></i>Nama PIC</th>
                <th><i class="fas fa-phone me-1 text-primary"></i>Kontak</th>
                <th><i class="fas fa-bolt me-1 text-warning"></i>Kapasitas Daya</th>
                <th><i class="fas fa-industry me-1 text-info"></i>Sektor</th>
                <th><i class="fas fa-clipboard-list me-1"></i>Peruntukan</th>
                <th><i class="fas fa-map-marker-alt me-1 text-danger"></i>UP3</th>
                <th><i class="fas fa-map-marker-alt me-1 text-danger"></i>ULP</th>
                <th><i class="fas fa-star me-1 text-warning"></i>Kriteria Prioritas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
</div>
@push('styles')
<style>
    @media (max-width: 1000px) {
        #tabel-pelanggan {
            font-size: 13px;
        }

        #tabel-pelanggan th,
        #tabel-pelanggan td {
            padding: 6px 4px;
        }
    }

    @media (max-width: 768px) {
        #tabel-pelanggan {
            font-size: 11px;
        }

        #tabel-pelanggan th,
        #tabel-pelanggan td {
            padding: 4px 2px;
        }
    }
</style>
@endpush
@forelse($pelanggan as $item)
<tr>
    <td>{{ ($pelanggan->currentPage() - 1) * $pelanggan->perPage() + $loop->iteration }}</td>
    <td>{{ $item->id_pel }}</td>
    <td>{{ $item->kode_PLN }}</td>
    <td>{{ $item->nama_perusahaan }}</td>
    <td>{{ $item->user->email ?? '-' }}</td>
    <td>{{ $item->nama }}</td>
    <td>{{ $item->kontak }}</td>
    <td>{{ $item->kapasitas_daya }} kWh</td>
    <td>{{ $item->sektor }}</td>
    <td>{{ $item->peruntukan }}</td>
    <td>{{ $item->up3 }}</td>
    <td>{{ $item->ulp }}</td>
    <td>{{ $item->kriteria_prioritas }}</td>
    <td>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pelanggan.show', $item->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-info-circle"></i> Detail
            </a>
            <a href="{{ route('admin.pelanggan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.pelanggan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
            {{-- Tombol Lihat Kunjungan (YANG BARU) --}}
            @role('admin|manajer|staff')
            <a href="{{ route('admin.jadwal-kunjungan.index', ['pelanggan_id' => $item->id]) }}" class="btn btn-sm btn-primary" title="Lihat Daftar Kunjungan">
                <i class="fas fa-calendar-alt"></i> Kunjungan
            </a>
            @endrole
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="14" class="text-center">Belum ada data pelanggan.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection