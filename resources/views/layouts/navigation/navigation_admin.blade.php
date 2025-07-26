<link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">

<div class="d-flex" id="wrapper">
    @include('layouts.navigation.partials.topbar')

    <div id="sidebar-wrapper">
        <div class="sidebar-heading p-3 fw-bold text-center">
            <div class="sidebar-logo mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-dark">
                    <img src="{{ asset('images/logo_crm.png') }}" alt="Logo CRM" style="width: 90px;">
                </a>
            </div>
            <span style="font-size:1.1em; letter-spacing:1px;">SISTEM CRM PLN PRIORITY</span>
        </div>
        <div class="list-group list-group-flush">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2 text-dark"></i> Dashboard
            </a>

            {{-- Manajemen Pelanggan (TERMASUK PEMAKAIAN DAYA OPERASIONAL) --}}
            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.pelanggan.*') || request()->routeIs('admin.pemakaian-daya.index') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapsePelanggan" role="button" aria-expanded="{{ request()->routeIs('admin.pelanggan.*') || request()->routeIs('admin.pemakaian-daya.index') ? 'true' : 'false' }}" aria-controls="collapsePelanggan">
                <i class="fas fa-users me-2 text-dark"></i>Pelanggan
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.pelanggan.*') || request()->routeIs('admin.pemakaian-daya.index') ? 'show' : '' }}" id="collapsePelanggan">
                <a href="{{ route('admin.pelanggan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pelanggan.index') ? 'active' : '' }}">
                    <i class="fas fa-list me-2 text-dark"></i> Daftar Pelanggan
                </a>
                @role('admin') {{-- Hanya Admin yang bisa menambah --}}
                <a href="{{ route('admin.pelanggan.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pelanggan.create') ? 'active' : '' }}">
                    <i class="fas fa-user-plus me-2 text-dark"></i> Tambah Pelanggan
                </a>
                @endrole
                {{-- LINK BARU UNTUK MANAJEMEN PEMAKAIAN DAYA OPERASIONAL --}}
                <a href="{{ route('admin.pemakaian-daya.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pemakaian-daya.index') ? 'active' : '' }}">
                    <i class="fas fa-bolt me-2 text-dark"></i> Pemakaian Daya
                </a>
            </div>

            {{-- Monitoring Aktivitas --}}
            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.monitoring.*') || request()->routeIs('admin.feedback.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseAktivitas" role="button" aria-expanded="{{ request()->routeIs('admin.monitoring.*') || request()->routeIs('admin.feedback.*') ? 'true' : 'false' }}" aria-controls="collapseAktivitas">
                <i class="fas fa-tasks me-2 text-dark"></i> Monitoring Aktivitas
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.monitoring.*') || request()->routeIs('admin.feedback.*') ? 'show' : '' }}" id="collapseAktivitas">
                <a href="{{ route('admin.monitoring.staff-activity') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.monitoring.staff-activity') ? 'active' : '' }}">
                    <i class="fas fa-user-clock me-2 text-dark"></i> Aktivitas Staff
                </a>
                <a href="{{ route('admin.monitoring.kunjungan-interaksi') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.monitoring.kunjungan-interaksi') ? 'active' : '' }}">
                    <i class="fas fa-handshake me-2 text-dark"></i> Kunjungan&Interaksi
                </a>
                <a href="{{ route('admin.feedback.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                    <i class="fas fa-inbox me-2 text-dark"></i> Feedback Masuk
                </a>
            </div>

            {{-- Laporan & Analitik (Di sini hanya laporan, bukan CRUD) --}}
            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseLaporan" role="button" aria-expanded="{{ request()->routeIs('admin.laporan.*') ? 'true' : 'false' }}" aria-controls="collapseLaporan">
                <i class="fas fa-chart-bar me-2 text-dark"></i> Laporan & Analitik
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.laporan.*') ? 'show' : '' }}" id="collapseLaporan"> {{-- Hapus pemakaian-daya.* dari sini --}}
                <a href="{{ route('admin.laporan.kunjungan') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.laporan.kunjungan') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list me-2 text-dark"></i> Kunjungan
                </a>
                <a href="{{ route('admin.laporan.feedback') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.laporan.feedback') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots me-2 text-dark"></i> Feedback
                </a>
                {{-- LINK Laporan Pemakaian Daya, bukan CRUD --}}
                <a href="{{ route('admin.laporan.pemakaian-daya') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.laporan.pemakaian-daya') ? 'active' : '' }}">
                    <i class="fas fa-bolt me-2 text-dark"></i> Pemakaian Daya
                </a>
                <a href="{{ route('admin.laporan.unduh') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.laporan.unduh') ? 'active' : '' }}">
                    <i class="fas fa-file-download me-2 text-dark"></i> Unduh Excel & PDF
                </a>
            </div>

            {{-- Notifikasi --}}
            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.notifikasi.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseNotifikasi" role="button" aria-expanded="{{ request()->routeIs('admin.notifikasi.*') ? 'true' : 'false' }}" aria-controls="collapseNotifikasi">
                <i class="fas fa-bell me-2 text-dark"></i> Notifikasi
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.notifikasi.*') ? 'show' : '' }}" id="collapseNotifikasi">
                <a href="{{ route('admin.notifikasi.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.notifikasi.index') ? 'active' : '' }}">
                    <i class="fas fa-bell me-2 text-dark"></i> Notifikasi Sistem
                </a>
            </div>

            {{-- Manajemen Users --}}
            <a class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseUser" role="button" aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}" aria-controls="collapseUser">
                <i class="fas fa-user-cog me-2 text-dark"></i> Manajemen Users
                <i class="fas fa-chevron-down float-end text-dark"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="collapseUser">
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <i class="fas fa-list me-2 text-dark"></i> Daftar Users
                </a>
                <a href="{{ route('admin.users.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                    <i class="fas fa-user-plus me-2 text-dark"></i> Tambah Users
                </a>
            </div>

            {{-- Pengaturan Sistem --}}
            <a href="{{ route('admin.pengaturan-sistem') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pengaturan-sistem') ? 'active' : '' }}">
                <i class="fas fa-cogs me-2 text-dark"></i> Pengaturan Sistem
            </a>

            <div class="list-group-item list-group-item-action p-0">
                <div class="dropdown-divider"></div>
            </div>

            {{-- Profil --}}
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fas fa-user-circle me-2 text-dark"></i> Profil
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="d-grid">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action text-start">
                    <i class="fas fa-sign-out-alt me-2 text-dark"></i> Log Out
                </button>
            </form>
        </div>
    </div>
</div>