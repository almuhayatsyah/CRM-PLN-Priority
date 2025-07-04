<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    

    <div class="p-4 shadow rounded-4" style="width: 100%; max-width: 400px; background-color: #f4f4f6;">
    {{-- Logo --}}
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo_crm.png') }}" alt="Logo CRM" style="width: 120px;">
    </div>

    {{-- Judul --}}
    <h5 class="text-center fw-bold mb-1">SISTEM</h5>
    <p class="text-center text-uppercase text-muted mb-4" style="font-size: 13px;">
        Customer Relationship Management PAE PLN UID Aceh
    </p>

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- Email --}}
        <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-person"></i>
            </span>
            <input type="email" name="email" class="form-control border-start-0" placeholder="Email address" required>
        </div>

        {{-- Password --}}
        <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" name="password" class="form-control border-start-0" placeholder="Password" required>
        </div>
        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : 'remember' }}>
            <label class="form-check-label" for="remember">Ingat saya</label>
        </div>

        {{-- Lupa Password --}}
        <div class="mb-3 text-end">
            <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">Lupa Password</a>
        </div>

        {{-- Tombol --}}
        <div class="d-grid">
            <button type="submit" class="btn text-white fw-semibold rounded-pill"
                style="background: linear-gradient(to right, #00c851, #007EFB);">
                Login Now
            </button>
        </div>
            <footer class="">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto" style="font-size: 13px;"">
                        <span>Hak Cipta &copy; <?= date('Y') ?> PLN UID ACEH.</span>
                    </div>
                </div>
            </footer>
    </form>
</div>
    <div class="text-center mt-4">
        <p class="text-muted mb-0"></p>
    </div>

</x-guest-layout>