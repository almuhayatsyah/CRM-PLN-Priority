<div class="d-flex" id="wrapper">
    <!-- Sidebar Pelanggan -->
    <div class="bg-warning text-dark border-end" id="sidebar-wrapper" style="min-height: 100vh; width: 250px;">
        <div class="sidebar-heading p-3 fw-bold">CRM PLN UID ACEH</div>
        <div class="list-group list-group-flush">
            <a href="{{ route('pelanggan.dashboard') }}" class="list-group-item list-group-item-action bg-warning text-dark">Dashboard Pelanggan</a>
            <a href="{{ route('pelanggan.interaksi') }}" class="list-group-item list-group-item-action bg-warning text-dark">Interaksi</a>
            <a href="{{ route('pelanggan.feedback') }}" class="list-group-item list-group-item-action bg-warning text-dark">Feedback</a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action bg-warning text-dark">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action bg-warning text-dark">Log Out</button>
            </form>
        </div>
    </div>
    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100">
        <nav class="navbar navbar-light bg-white border-bottom shadow-sm px-4">
            <span class="navbar-brand mb-0 h5">Dashboard</span>
        </nav>
        <div class="container-fluid mt-4">
            @yield('content')
        </div>
    </div>
</div>
