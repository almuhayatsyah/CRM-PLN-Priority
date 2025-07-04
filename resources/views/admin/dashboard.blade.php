@extends('layouts.app')
@section('content')

<div class="row">
    {{-- Kartu Total Pelanggan --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pelanggan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPelanggan ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Total Users --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pelanggan Aktif Terakhir</h6>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @forelse($pelangganAktif as $pelanggan) {{-- @forelse adalah fitur Blade, mirip @foreach tapi ada @empty --}}
            <li class="list-group-item">{{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }})</li>
            @empty
            <li class="list-group-item">Tidak ada data pelanggan aktif.</li>
            @endforelse
        </ul>
    </div>
</div>

{{-- Placeholder untuk Grafik Pemakaian Daya (Anda akan menyertakan Chart.js di sini) --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pemakaian Daya Per Bulan</h6>
    </div>
    <div class="card-body">
        <canvas id="myAreaChart"></canvas>
        {{-- Script Chart.js akan ditempatkan di sini --}}
    </div>
</div>

@endsection