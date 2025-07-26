@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Laporan Kunjungan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Laporan & Analitik</a></li>
    <li class="breadcrumb-item active">Laporan Kunjungan</li>
  </ol>

  {{-- Statistik Ringkasan Kunjungan (dari AdminDashboard@laporanKunjungan) --}}
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Kunjungan ({{ $tahunFilter }})</h5>
          <p class="card-text h2">{{ $totalKunjungan ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-info mb-3">
        <div class="card-body">
          <h5 class="card-title">Dijadwalkan</h5>
          <p class="card-text h2">{{ $kunjunganDijadwalkan ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Selesai</h5>
          <p class="card-text h2">{{ $kunjunganSelesai ?? 0 }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-danger mb-3">
        <div class="card-body">
          <h5 class="card-title">Batal</h5>
          <p class="card-text h2">{{ $kunjunganBatal ?? 0 }}</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Form Filter Laporan --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-filter me-1"></i> Filter Laporan Kunjungan
    </div>
    <div class="card-body">
      <form action="{{ route('admin.laporan.kunjungan') }}" method="GET">
        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label for="tahunFilter" class="form-label">Tahun</label>
            <select class="form-select" id="tahunFilter" name="tahun">
              @foreach($tahunOptions as $tahun)
              <option value="{{ $tahun }}" {{ $tahun == $tahunFilter ? 'selected' : '' }}>{{ $tahun }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="staffFilter" class="form-label">Staff Pelaksana</label>
            <select class="form-select" id="staffFilter" name="user_id">
              <option value="">Semua Staff</option>
              @foreach($allUsers as $user)
              <option value="{{ $user->id }}" {{ $user->id == $staffFilter ? 'selected' : '' }}>{{ $user->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="statusFilter" class="form-label">Status Kunjungan</label>
            <select class="form-select" id="statusFilter" name="status">
              <option value="">Semua Status</option>
              <option value="dijadwalkan" {{ 'dijadwalkan' == $statusFilter ? 'selected' : '' }}>Dijadwalkan</option>
              <option value="selesai" {{ 'selesai' == $statusFilter ? 'selected' : '' }}>Selesai</option>
              <option value="batal" {{ 'batal' == $statusFilter ? 'selected' : '' }}>Batal</option>
            </select>
          </div>
          <div class="col-md-3 text-end">
            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ route('admin.laporan.kunjungan') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Grafik Kunjungan per Bulan (membutuhkan Chart.js) --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-chart-area me-1"></i>
      Tren Kunjungan per Bulan (Tahun {{ $tahunFilter }})
    </div>
    <div class="card-body">
      <canvas id="kunjunganChart" width="100%" height="40"></canvas>
    </div>
  </div>

  {{-- Tabel Detail Kunjungan --}}
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Detail Data Kunjungan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Pelanggan</th>
              <th>Staff</th>
              <th>Tanggal Jadwal</th>
              <th>Tujuan</th>
              <th>Hasil</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($laporanKunjungans as $kunjungan)
            <tr>
              <td>{{ $loop->iteration + ($laporanKunjungans->currentPage() - 1) * $laporanKunjungans->perPage() }}</td>
              <td>{{ $kunjungan->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
              <td>{{ $kunjungan->user->name ?? 'N/A' }}</td>
              <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_jadwal)->format('d-m-Y H:i') }}</td>
              <td>{{ Str::limit($kunjungan->tujuan, 70) }}</td>
              <td>{{ Str::limit($kunjungan->hasil, 70) ?? '-' }}</td>
              <td>{{ $kunjungan->status }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Tidak ada data kunjungan untuk laporan ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $laporanKunjungans->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
{{-- Membutuhkan Chart.js Library --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('kunjunganChart');
    if (ctx) { // Pastikan elemen canvas ada
      var kunjunganChart = new Chart(ctx, {
        type: 'bar', // Bisa 'bar' atau 'line'
        data: {
          labels: @json($labelsGrafik),
          datasets: [{
            label: 'Total Kunjungan',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            data: @json($dataGrafik),
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                precision: 0 // Pastikan sumbu Y adalah bilangan bulat
              }
            }
          }
        }
      });
    }
  });
</script>
@endpush