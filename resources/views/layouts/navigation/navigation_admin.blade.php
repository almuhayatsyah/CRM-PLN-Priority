<link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
<div class="d-flex" id="wrapper">
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
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapsePelanggan" role="button" aria-expanded="false" aria-controls="collapsePelanggan">
                <i class="fas fa-users me-2"></i>Pelanggan
                <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="collapsePelanggan">
                <a href="{{ route('admin.pelanggan.index') }}"" class=" list-group-item list-group-item-action"><i class="fas fa-list me-2"></i> Daftar Pelanggan</a>
                <a href="{{ route('admin.pelanggan.create') }}" class="list-group-item list-group-item-action"><i class="fas fa-user-plus me-2"></i> Tambah Pelanggan</a>
            </div>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseAktivitas" role="button" aria-expanded="false" aria-controls="collapseAktivitas">
                <i class="fas fa-tasks me-2"></i> Monitoring Aktivitas
                <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="collapseAktivitas">
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-user-clock me-2"></i> Aktivitas Staff</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-handshake me-2"></i> Kunjungan&Interaksi</a>
            </div>
            <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-inbox me-2"></i> Feedback Masuk</a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseLaporan" role="button" aria-expanded="false" aria-controls="collapseLaporan">
                <i class="fas fa-chart-bar me-2"></i> Laporan & Analtik
                <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="collapseLaporan">
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-clipboard-list me-2"></i> Kunjungan</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-comment-dots me-2"></i> Feedback</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-bolt me-2"></i> Pemakaian Daya</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-file-download me-2"></i> Unduh Excel & PDF</a>
            </div>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseNotifikasi" role="button" aria-expanded="false" aria-controls="collapseNotifikasi">
                <i class="fas fa-bell me-2"></i> Notifikasi
                <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="collapseNotifikasi">
                <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-bell me-2"></i> Notifikasi Sistem</a>
            </div>
            <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#collapseUser" role="button" aria-expanded="false" aria-controls="collapseUser">
                <i class="fas fa-user-cog me-2"></i> Manajemen Users
                <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="collapseUser">
                <a href="{{ route('admin.user.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-users-cog me-2"></i> Daftar Users</a>
                <a href="{{ route('admin.user.create') }}" class="list-group-item list-group-item-action"><i class="fas fa-user-plus me-2"></i> Tambah User</a>
            </div>
            <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-cogs me-2"></i> Pengaturan Sistem</a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action"><i class="fas fa-user me-2"></i> Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action"><i class="fas fa-sign-out-alt me-2"></i> Log Out</button>
            </form>
        </div>
    </div>
    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100" style="margin-left:260px;">
        <nav class="navbar navbar-expand-lg navbar-dark"
            style="background: linear-gradient(to right, #009fe3,#009fe3);
            clip-path: polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%);
            height: 70px;">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-semibold" href="dashboard">Dashboard</a>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-person-circle"></i> Admin</a>
                    </li>
                </ul>
            </div>
        </nav>


        <div class="container-fluid mt-4">
            @yield('content')
        </div>
    </div>

</div>