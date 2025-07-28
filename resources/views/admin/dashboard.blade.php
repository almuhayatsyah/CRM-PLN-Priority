@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <h1 class="mt-4">Dashboard Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    {{-- Statistik Cards --}}
    <div class="row mb-4">
        {{-- Kartu Total Pelanggan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $totalPelanggan ?? 0 }}</div>
                <div class="stat-label">Total Pelanggan</div>
            </div>
        </div>

        {{-- Kartu Total Users --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>

        {{-- Kartu Total Kunjungan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">{{ $totalKunjungan ?? 0 }}</div>
                <div class="stat-label">Total Kunjungan</div>
            </div>
        </div>

        {{-- Kartu Total Anomali --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-number">{{ $totalAnomali ?? 0 }}</div>
                <div class="stat-label">Total Anomali</div>
            </div>
        </div>
    </div>

    {{-- Grafik dan Chart --}}
    <div class="row mb-4">
        {{-- Grafik Pemakaian Daya --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Pemakaian Daya</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Filter Grafik:</div>
                            <a class="dropdown-item" href="#" onclick="updateChart('month')">Bulan Ini</a>
                            <a class="dropdown-item" href="#" onclick="updateChart('quarter')">3 Bulan Terakhir</a>
                            <a class="dropdown-item" href="#" onclick="updateChart('year')">Tahun Ini</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="pemakaianDayaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pie Chart Sektor Pelanggan --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Sektor Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="sektorPelangganChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Industri
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Komersial
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Rumah Tangga
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel dan Data Terbaru --}}
    <div class="row">
        {{-- Pelanggan Aktif Terbaru --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pelanggan Aktif Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>ID Pel</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelangganAktif as $pelanggan)
                                <tr>
                                    <td>{{ $pelanggan->nama_perusahaan }}</td>
                                    <td>{{ $pelanggan->id_pel }}</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data pelanggan aktif.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @forelse($aktivitasTerbaru ?? [] as $aktivitas)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">{{ $aktivitas->title ?? 'Aktivitas Sistem' }}</h6>
                                <p class="timeline-text">{{ $aktivitas->description ?? 'Deskripsi aktivitas' }}</p>
                                <small class="text-muted">{{ $aktivitas->created_at ?? now() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Tidak ada aktivitas terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik (akan diisi dari controller)
    var chartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Pemakaian Daya (kWh)',
            data: [1500, 1800, 2200, 1900, 2400, 2100, 2800, 2600, 2300, 2000, 1700, 1600],
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    var pieData = {
        labels: ['Industri', 'Komersial', 'Rumah Tangga'],
        datasets: [{
            data: [45, 30, 25],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }]
    };

    // Inisialisasi Chart
    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart
        var ctx = document.getElementById('pemakaianDayaChart');
        if (ctx) {
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'index'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5,
                                padding: 10,
                                callback: function(value, index, values) {
                                    return number_format(value) + ' kWh';
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' kWh';
                            }
                        }
                    }
                }
            });
        }

        // Pie Chart
        var ctxPie = document.getElementById('sektorPelangganChart');
        if (ctxPie) {
            var pieChart = new Chart(ctxPie, {
                type: 'doughnut',
                data: pieData,
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });
        }
    });

    // Function untuk update chart
    function updateChart(period) {
        console.log('Updating chart for period:', period);
        // Implementasi update chart berdasarkan periode
    }

    // Function untuk format angka
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if ((sep.length > 0)) {
            var i = s[0].length;
            if (i % 3 !== 0) {
                i += 3 - i % 3;
            }
            s[0] = s[0].padStart(i, '0');
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
</script>

<style>
    .chart-area {
        position: relative;
        height: 20rem;
        width: 100%;
    }

    .chart-pie {
        position: relative;
        height: 15rem;
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .timeline-content {
        background: #f8f9fc;
        padding: 15px;
        border-radius: 5px;
        border-left: 3px solid #4e73df;
    }

    .timeline-title {
        margin: 0 0 5px 0;
        font-weight: 600;
        color: #5a5c69;
    }

    .timeline-text {
        margin: 0 0 5px 0;
        color: #858796;
        font-size: 0.875rem;
    }

    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .text-gray-300 {
        color: #dddfeb !important;
    }

    .text-gray-800 {
        color: #5a5c69 !important;
    }
</style>
@endpush