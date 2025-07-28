@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Test Chart</h1>

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-chart-area me-1"></i>
      Test Chart Pemakaian Daya
    </div>
    <div class="card-body">
      <div class="chart-container" style="position: relative; height: 500px; width: 100%;">
        <canvas id="testChart"
          data-labels='["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]'
          data-values='[1500, 1800, 2200, 1900, 2400, 2100, 2800, 2600, 2300, 2000, 1700, 1600]'>
        </canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('testChart');
    if (ctx) {
      console.log('Test Canvas element found');

      // Ambil data dari data attributes
      var chartLabels = JSON.parse(ctx.getAttribute('data-labels') || '[]');
      var chartDataKwh = JSON.parse(ctx.getAttribute('data-values') || '[]');

      console.log('Test Chart Labels:', chartLabels);
      console.log('Test Chart Data:', chartDataKwh);

      var testChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: chartLabels,
          datasets: [{
            label: 'Test Pemakaian Kwh',
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
              position: 'top'
            }
          },
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

      console.log('Test Chart created successfully');
    } else {
      console.error('Test Canvas element not found');
    }
  });
</script>
@endpush