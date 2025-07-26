@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Unduh Laporan Excel & PDF</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Laporan & Analitik</a></li>
    <li class="breadcrumb-item active">Unduh Laporan</li>
  </ol>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  @if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-file-download me-1"></i>
      Pilih Jenis Laporan dan Format Unduh
    </div>
    <div class="card-body">
      <form id="exportForm" action="{{ route('admin.laporan.do-unduh') }}" method="POST">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label for="report_type" class="form-label">Jenis Laporan</label>
            <select class="form-select" id="report_type" name="report_type" required>
              <option value="">-- Pilih Laporan --</option>
              <option value="pelanggan">Daftar Pelanggan</option>
              <option value="kunjungan">Kunjungan</option>
              <option value="interaksi">Interaksi</option>
              <option value="feedback">Feedback</option>
              <option value="pemakaian_daya">Pemakaian Daya</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="export_format" class="form-label">Format Unduh</label>
            <select class="form-select" id="export_format" name="export_format" required>
              <option value="">-- Pilih Format --</option>
              <option value="pdf">PDF</option>
              <option value="excel">Excel</option>
            </select>
          </div>
        </div>

        <div class="row g-3 mt-3" id="filterOptions">
          {{-- Opsi Filter Dinamis akan muncul di sini (misal: Pelanggan, Tahun, dll.) --}}
          {{-- Contoh Filter untuk Laporan Umum --}}
          <div class="col-md-4 report-filter-options" data-report-type="kunjungan interaksi feedback pemakaian_daya">
            <label for="tahun" class="form-label">Tahun</label>
            <select class="form-select" id="tahun" name="tahun">
              @foreach($tahunOptions as $tahun)
              <option value="{{ $tahun }}" {{ $tahun == \Carbon\Carbon::now()->year ? 'selected' : '' }}>{{ $tahun }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 report-filter-options" data-report-type="kunjungan interaksi pemakaian_daya feedback">
            <label for="pelanggan_id" class="form-label">Pelanggan</label>
            <select class="form-select" id="pelanggan_id" name="pelanggan_id">
              <option value="">Semua Pelanggan</option>
              @foreach($allPelanggans as $pelanggan)
              <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }})</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 report-filter-options" data-report-type="kunjungan interaksi">
            <label for="user_id" class="form-label">Staff / User</label>
            <select class="form-select" id="user_id" name="user_id">
              <option value="">Semua Staff/User</option>
              @foreach($allUsers as $user)
              <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4 report-filter-options" data-report-type="kunjungan">
            <label for="status_kunjungan" class="form-label">Status Kunjungan</label>
            <select class="form-select" id="status_kunjungan" name="status_kunjungan"> {{-- Nama name diubah --}}
              <option value="">Semua Status</option>
              <option value="dijadwalkan">Dijadwalkan</option>
              <option value="selesai">Selesai</option>
              <option value="batal">Batal</option>
            </select>
          </div>
          <div class="col-md-4 report-filter-options" data-report-type="interaksi feedback">
            <label for="status_umum" class="form-label">Status Umum</label>
            <select class="form-select" id="status_umum" name="status_umum"> {{-- Nama name diubah --}}
              <option value="">Semua Status</option>
              <option value="Open">Open</option>
              <option value="Resolved">Resolved</option>
              <option value="Follow-up">Follow-up</option>
              <option value="Baru">Baru</option>
              <option value="Sedang Ditangani">Sedang Ditangani</option>
              <option value="Selesai">Selesai</option>
            </select>
          </div>
          <div class="col-md-4 report-filter-options" data-report-type="pemakaian_daya">
            <label for="flag_anomali" class="form-label">Status Anomali</label>
            <select class="form-select" id="flag_anomali" name="flag_anomali">
              <option value="">Semua Status</option>
              <option value="1">Anomali</option>
              <option value="0">Normal</option>
            </select>
          </div>
        </div>

        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-primary"><i class="fas fa-download me-1"></i> Unduh Laporan</button>
        </div>
      </form>

      <hr class="my-4">

      <h5>Riwayat Unduhan (Opsional)</h5>
      <p class="text-muted">Fitur riwayat unduhan bisa ditambahkan di sini.</p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const reportTypeSelect = document.getElementById('report_type');
    const exportFormatSelect = document.getElementById('export_format');
    const allFilterOptions = document.querySelectorAll('.report-filter-options'); // Selector baru

    function toggleFilterOptions() {
      const selectedReportType = reportTypeSelect.value;

      allFilterOptions.forEach(div => {
        const dataTypes = div.dataset.reportType.split(' ');
        if (dataTypes.includes(selectedReportType)) {
          div.style.display = 'block'; // Tampilkan jika cocok
          // Pastikan input di dalamnya tidak disabled agar nilainya terkirim
          div.querySelectorAll('input, select, textarea').forEach(input => {
            input.disabled = false;
          });
        } else {
          div.style.display = 'none'; // Sembunyikan jika tidak cocok
          // Set disabled true agar nilainya tidak terkirim saat form disubmit
          div.querySelectorAll('input, select, textarea').forEach(input => {
            input.disabled = true;
            // Optionally clear value if it was a non-default one
            // input.value = '';
          });
        }
      });
    }

    reportTypeSelect.addEventListener('change', toggleFilterOptions);
    exportFormatSelect.addEventListener('change', toggleFilterOptions);

    // Panggil saat halaman dimuat untuk inisialisasi
    toggleFilterOptions();
  });
</script>
@endpush