@extends('layouts.app')

@section('content')
<style>
  /* Custom CSS untuk pagination sederhana */
  .pagination {
    margin-bottom: 0;
  }

  .pagination-sm .page-link {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
  }

  .pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
  }

  .pagination .page-item .page-link {
    color: #0d6efd;
    background-color: #fff;
    border: 1px solid #dee2e6;
  }

  .pagination .page-item .page-link:hover {
    color: #0a58ca;
    background-color: #e9ecef;
    border-color: #dee2e6;
  }

  .pagination .page-item.active .page-link:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
  }
</style>

<div class="container-fluid">
  <h1 class="mt-4">Daftar Pemakaian Daya Pelanggan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pemakaian Daya</li>
  </ol>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="d-flex justify-content-end mb-3">
    @role('admin|staff')
    <a href="{{ route('admin.pemakaian-daya.create') }}" class="btn btn-primary">
      <i class="fas fa-plus me-1"></i> Tambah Pemakaian Daya
    </a>
    @endrole
  </div>

  {{-- Form Filter --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i>
      Filter Pemakaian Daya
    </div>
    <div class="card-body">
      <form action="{{ route('admin.pemakaian-daya.index') }}" method="GET">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="pelanggan_id" class="form-label">Pelanggan</label>
            <select class="form-select" id="pelanggan_id" name="pelanggan_id">
              <option value="">Semua Pelanggan</option>
              @foreach ($allPelanggans as $pelanggan)
              <option value="{{ $pelanggan->id }}" {{ request('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                {{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }}) ({{ $pelanggan->id_pel }})
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="bulan_tahun" class="form-label">Bulan & Tahun</label>
            <input type="month" class="form-control" id="bulan_tahun" name="bulan_tahun" value="{{ request('bulan_tahun') }}">
          </div>
          <div class="col-md-4">
            <label for="flag_anomali" class="form-label">Status Anomali</label>
            <select class="form-select" id="flag_anomali" name="flag_anomali">
              <option value="">Semua</option>
              <option value="1" {{ request('flag_anomali') == '1' ? 'selected' : '' }}>Anomali</option>
              <option value="0" {{ request('flag_anomali') == '0' ? 'selected' : '' }}>Normal</option>
            </select>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.pemakaian-daya.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Data Pemakaian Daya
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Pelanggan</th>
              <th>Id Pel</th>
              <th> sektor </th>
              <th>Bulan & Tahun</th>
              <th>Pemakaian Kwh</th>
              <th>Beban Anomali</th>
              <th>Flag Anomali</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pemakaianDayas as $data)
            <tr>
              <td>{{ $loop->iteration + ($pemakaianDayas->currentPage() - 1) * $pemakaianDayas->perPage() }}</td>
              <td>{{ $data->pelanggan->nama_perusahaan ?? '' }}</td>
              <td>{{ $data->pelanggan->id_pel?? '' }}</td>
              <td>{{ $data->pelanggan->sektor?? '' }}</td>
              <td>{{ $data->bulan_tahun }}</td>
              <td>{{ number_format($data->pemakaian_Kwh, 2) }}</td>
              <td>{{ number_format($data->beban_anomali, 2) ?? '-' }}</td>
              <td>
                @if ($data->flag_anomali == 1)
                <span class="badge bg-danger">Anomali</span>
                @else
                <span class="badge bg-success">Normal</span>
                @endif
              </td>
              <td>
                @role('admin|staff')
                <a href="{{ route('admin.pemakaian-daya.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.pemakaian-daya.destroy', $data->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                </form>
                @endrole
                @role('admin|manajer|staff')
                <a href="{{ route('admin.pemakaian-daya.show', $data->id) }}" class="btn btn-info btn-sm">Detail</a>
                @endrole
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Tidak ada data pemakaian daya.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          @if($pemakaianDayas->hasPages())
          <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
              {{-- Hanya tampilkan nomor halaman, tanpa Previous/Next --}}
              @for ($i = 1; $i <= $pemakaianDayas->lastPage(); $i++)
                <li class="page-item {{ $i == $pemakaianDayas->currentPage() ? 'active' : '' }}">
                  <a class="page-link" href="{{ $pemakaianDayas->url($i) }}&{{ http_build_query(request()->except('page')) }}">
                    {{ $i }}
                  </a>
                </li>
                @endfor
            </ul>
          </nav>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection