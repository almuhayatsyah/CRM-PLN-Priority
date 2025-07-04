<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        session()->regenerate();

        // Redirect sesuai role user
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->hasRole('manajer')) {
            // Ganti dengan route dashboard manajer jika ada
            return redirect()->intended('/manajer/dashboard');
        } elseif ($user->hasRole('staff')) {
            // Ganti dengan route dashboard staff jika ada
            return redirect()->intended('/staff/dashboard');
        } elseif ($user->hasRole('pelanggan')) {
            // Ganti dengan route dashboard pelanggan jika ada
            return redirect()->intended('/pelanggan/dashboard');
        }
        // Default redirect jika tidak ada role
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
