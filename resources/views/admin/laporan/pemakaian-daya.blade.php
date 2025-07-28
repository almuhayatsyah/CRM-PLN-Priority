@php
$chartLabelsJson = json_encode($labelsGrafik);
$chartDataKwhJson = json_encode($dataGrafikKwh);
@endphp

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
      <div class="chart-container" style="position: relative; height: 500px; width: 100%;">
        <canvas id="pemakaianDayaChart"
          data-labels="{{ json_encode($labelsGrafik) }}"
          data-values="{{ json_encode($dataGrafikKwh) }}">
        </canvas>
      </div>
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
        <div class="d-flex justify-content-center mt-3">
          @if($laporanPemakaianDayas->hasPages())
          <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
              {{-- Hanya tampilkan nomor halaman, tanpa Previous/Next --}}
              @for ($i = 1; $i <= $laporanPemakaianDayas->lastPage(); $i++)
                <li class="page-item {{ $i == $laporanPemakaianDayas->currentPage() ? 'active' : '' }}">
                  <a class="page-link" href="{{ $laporanPemakaianDayas->url($i) }}&{{ http_build_query(request()->except('page')) }}">
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

@push('scripts')
{{-- Membutuhkan Chart.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('pemakaianDayaChart');
    if (ctx) { // Pastikan elemen canvas ada
      console.log('Canvas element found');

      // Ambil data dari data attributes
      var chartLabels = JSON.parse(ctx.getAttribute('data-labels') || '[]');
      var chartDataKwh = JSON.parse(ctx.getAttribute('data-values') || '[]');

      console.log('Chart Labels:', chartLabels);
      console.log('Chart Data:', chartDataKwh);

      var pemakaianDayaChart = new Chart(ctx, {
        type: 'line', // Bisa 'bar' atau 'line'
        data: {
          labels: chartLabels,
          datasets: [{
            label: 'Total Pemakaian Kwh',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 3,
            tension: 0.1,
            fill: true,
            data: chartDataKwh,
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                font: {
                  size: 14
                }
              }
            },
            tooltip: {
              backgroundColor: 'rgba(0, 0, 0, 0.8)',
              titleColor: '#fff',
              bodyColor: '#fff',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1,
              cornerRadius: 6,
              displayColors: true
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Kwh',
                font: {
                  size: 14,
                  weight: 'bold'
                }
              },
              ticks: {
                font: {
                  size: 12
                }
              },
              grid: {
                color: 'rgba(0, 0, 0, 0.1)',
                drawBorder: false
              }
            },
            x: {
              title: {
                display: true,
                text: 'Bulan',
                font: {
                  size: 14,
                  weight: 'bold'
                }
              },
              ticks: {
                font: {
                  size: 12
                }
              },
              grid: {
                color: 'rgba(0, 0, 0, 0.1)',
                drawBorder: false
              }
            }
          },
          interaction: {
            intersect: false,
            mode: 'index'
          },
          elements: {
            line: {
              borderWidth: 3
            }
          }
        }
      });

      console.log('Chart created successfully');
    } else {
      console.error('Canvas element not found');
    }
  });
</script>
@endpush