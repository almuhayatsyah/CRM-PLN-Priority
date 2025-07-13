<link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
<div class="d-flex" id="wrapper">
    @include('layouts.navigation.partials.topbar')

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading p-3 fw-bold text-center">
            <div class="sidebar-logo mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-dark">
                    <img src="{{ asset('images/logo_crm.png') }}" alt="Logo CRM" style="width: 90px;">
            </div>
            <span style="font-size:1.1em; letter-spacing:1px;">SISTEM CRM PLN PRIORITY</span>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-tachometer-alt me-2 text-dark"></i> Dashboard
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapsePelanggan" role="button" aria-expanded="false" aria-controls="collapsePelanggan">
                <i class="fas fa-users me-2 text-dark"></i>Pelanggan
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse" id="collapsePelanggan">
                <a href="{{ route('admin.pelanggan.index') }}"" class=" list-group-item list-group-item-action"><i class="fas fa-list me-2 text-dark"></i> Daftar Pelanggan</a>
                <a href="{{ route('admin.pelanggan.create') }}" class="list-group-item list-group-item-action"><i class="fas fa-user-plus me-2 text-dark"></i> Tambah Pelanggan</a>
            </div>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseAktivitas" role="button" aria-expanded="false" aria-controls="collapseAktivitas">
                <i class="fas fa-tasks me-2 text-dark"></i> Monitoring Aktivitas
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse" id="collapseAktivitas">
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-user-clock me-2 text-dark"></i> Aktivitas Staff</a>
                <a href="{{ route('admin.monitoring.kunjungan-interaksi') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.monitoring.kunjungan-interaksi') ? 'active' : '' }}">
                    <i class="fas fa-bell me-2 text-dark"></i> Kunjungan&Interaksi
                </a>
            </div>
            <a href="{{ route('admin.feedback.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-inbox me-2 text-dark"></i> Feedback Masuk</a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseLaporan" role="button" aria-expanded="false" aria-controls="collapseLaporan">
                <i class="fas fa-chart-bar me-2 text-dark"></i> Laporan & Analtik
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse" id="collapseLaporan">
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-clipboard-list me-2 text-dark"></i> Kunjungan</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-comment-dots me-2 text-dark"></i> Feedback</a>
                <a href="{{ route('admin.pemakaian-daya.index') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.pemakaian-daya.*') ? 'active' : '' }}">
                    <i class="fas fa-bolt me-2"></i> Pemakaian Daya
                </a>
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-file-download me-2 text-dark"></i> Unduh Excel & PDF</a>
            </div>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseNotifikasi" role="button" aria-expanded="false" aria-controls="collapseNotifikasi">
                <i class="fas fa-bell me-2 text-dark"></i> Notifikasi
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse" id="collapseNotifikasi">
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-bell me-2 text-dark"></i> Notifikasi Sistem</a>
            </div>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseUser" role="button" aria-expanded="false" aria-controls="collapseUser">
                <i class="fas fa-user-cog me-2 text-dark"></i> Manajemen Users
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse" id="collapseUser">
                <a href="{{ route('admin.user.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-users-cog me-2 text-dark"></i> Daftar Users</a>
                <a href="{{ route('admin.user.create') }}" class="list-group-item list-group-item-action"><i class="fas fa-user-plus me-2 text-dark"></i> Tambah User</a>
            </div>
            <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-cogs me-2 text-dark"></i> Pengaturan Sistem</a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action"><i class="fas fa-user me-2 text-dark"></i> Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action"><i class="fas fa-sign-out-alt me-2 text-dark"></i> Log Out</button>
            </form>
        </div>
    </div>
</div>