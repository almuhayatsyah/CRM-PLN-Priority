<div class="d-flex" id="wrapper">
    <!-- Sidebar Staff -->
    <div class="bg-info text-white border-end" id="sidebar-wrapper" style="min-height: 100vh; width: 250px;">
        <div class="sidebar-heading p-3 fw-bold">CRM PLN UID ACEH</div>
        <div class="list-group list-group-flush">
            <a href="{{ route('staff.dashboard') }}" class="list-group-item list-group-item-action bg-info text-white">Dashboard Staff</a>
            <a href="{{ route('staff.tugas') }}" class="list-group-item list-group-item-action bg-info text-white">Tugas</a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action bg-info text-white">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action bg-info text-white">Log Out</button>
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
