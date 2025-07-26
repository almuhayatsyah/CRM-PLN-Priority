@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Laporan Pemakaian Daya Pelanggan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Laporan & Analitik</a></li>
    <li class="breadcrumb-item active">Laporan Pemakaian Daya</li>
  </ol>

  {{-- Statistik Ringkasan Pemakaian Daya --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Catatan ({{ $tahunFilter }})</h5>
          <p class="card-text h2">{{ $totalCatatan ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-danger mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Anomali</h5>
          <p class="card-text h2">{{ $totalAnomali ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Persentase Anomali</h5>
          <p class="card-text h2">{{ $persentaseAnomali ?? 0 }}%</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Form Filter Laporan --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i> Filter Laporan Pemakaian Daya
    </div>
    <div class="card-body">
      <form action="{{ route('admin.laporan.pemakaian-daya') }}" method="GET">
        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label for="tahunFilter" class="form-label">Tahun</label>
            <select class="form-select" id="tahunFilter" name="tahun">
              @foreach($tahunOptions as $tahun)
              <option value="{{ $tahun }}" {{ $tahun == $tahunFilter ? 'selected' : '' }}>{{ $tahun }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="pelangganFilter" class="form-label">Pelanggan</label>
            <select class="form-select" id="pelangganFilter" name="pelanggan_id">
              <option value="">Semua Pelanggan</option>
              @foreach($allPelanggans as $pelanggan)
              <option value="{{ $pelanggan->id }}" {{ $pelanggan->id == $pelangganFilter ? 'selected' : '' }}>{{ $pelanggan->nama_perusahaan }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="anomaliFilter" class="form-label">Status Anomali</label>
            <select class="form-select" id="anomaliFilter" name="flag_anomali">
              <option value="">Semua Status</option>
              <option value="1" {{ '1' == $anomaliFilter ? 'selected' : '' }}>Anomali</option>
              <option value="0" {{ '0' == $anomaliFilter ? 'selected' : '' }}>Normal</option>
            </select>
          </div>
          <div class="col-md-2 text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.laporan.pemakaian-daya') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Grafik Pemakaian Daya per Bulan (membutuhkan Chart.js) --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-chart-area me-1"></i>
      Tren Pemakaian Daya per Bulan (Tahun {{ $tahunFilter }})
    </div>
    <div class="card-body">
      <canvas id="pemakaianDayaChart" width="100%" height="40"></canvas>
    </div>
  </div>

  {{-- Tabel Detail Pemakaian Daya --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Detail Data Pemakaian Daya
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Pelanggan</th>
              <th>Bulan & Tahun</th>
              <th>Pemakaian Kwh</th>
              <th>Beban Anomali</th>
              <th>Flag Anomali</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($laporanPemakaianDayas as $data)
            <tr>
              <td>{{ $loop->iteration + ($laporanPemakaianDayas->currentPage() - 1) * $laporanPemakaianDayas->perPage() }}</td>
              <td>{{ $data->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
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
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">Tidak ada data pemakaian daya untuk laporan ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $laporanPemakaianDayas->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
{{-- Membutuhkan Chart.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('pemakaianDayaChart');
    if (ctx) { // Pastikan elemen canvas ada
      var pemakaianDayaChart = new Chart(ctx, {
        type: 'line', // Bisa 'bar' atau 'line'
        data: {
          labels: @json($labelsGrafik),
          datasets: [{
            label: 'Total Pemakaian Kwh',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.1,
            fill: true,
            data: @json($dataGrafikKwh),
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Kwh'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Bulan'
              }
            }
          }
        }
      });
    }
  });
</script>
@endpush