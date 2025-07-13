<div id="page-content-wrapper" class="w-100" style="margin-left:260px;">
  <nav class="navbar navbar-expand-lg navbar-dark"
    style="background: linear-gradient(to right,rgb(171, 207, 40),#009fe3);
            clip-path: polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%);
            height: 70px;
            position: relative;">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-semibold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('images/pln_logo.png') }}" alt="" style="height:65px;" class="me-2">
        PLN UID ACEH
      </a>
      <div class="card bg-info text-white p-1" style="font-size: 0.8rem; border-radius: 0.25rem;">
        Priority Account Executive
      </div>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <span class="d-block text-white text-center" style="font-size: 0.8rem;">
            {{ Auth::user()->role ?? '' }}
          </span>
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle me-2"></i> {{ Auth::user()->nama_lengkap ?? 'Profile' }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profil</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Log Out</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    @yield('content')
  </div>

</div>