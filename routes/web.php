<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\JadwalKunjunganController;
use App\Http\Controllers\InteraksiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PemakaianDayaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// ========================
// ROOT & AUTH REDIRECT
// ========================
// Redirect root ke dashboard jika sudah login, ke login jika belum
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        // Tambahkan redirect sesuai role lain jika ada
        // else if ($user->hasRole('manajer')) { ... }
        // else if ($user->hasRole('staff')) { ... }
        // else if ($user->hasRole('pelanggan')) { ... }
        // Default: redirect ke profile
        return redirect()->route('profile.edit');
    }
    return view('auth.login');
});

// ========================
// ADMIN ROUTES (hanya untuk admin)
// ========================
Route::middleware(['auth'])->group(function () {
    // ---------- Dashboard Admin ----------
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');

    // ---------- Manajemen Pelanggan ----------
    Route::resource('admin/pelanggan', App\Http\Controllers\Admin\PelangganController::class)->names('admin.pelanggan');




    // ---------- Manajemen Jadwal Kunjungan ----------
    Route::resource('admin/jadwal-kunjungan', JadwalKunjunganController::class)->names('admin.jadwal-kunjungan');

    // ---------- Manajemen Interaksi ----------
    Route::resource('admin/interaksi', InteraksiController::class)->names('admin.interaksi');

    // ---------- Manajemen Feedback ----------
    Route::resource('admin/feedback', FeedbackController::class)->names('admin.feedback');

    // ---------- Manajemen Notifikasi ----------
    Route::resource('admin/notifikasi', NotifikasiController::class)->names('admin.notifikasi');

    // ---------- Manajemen Pemakaian Daya ----------
    Route::resource('admin/pemakaian-daya', PemakaianDayaController::class)->names('admin.pemakaian-daya');

    // ---------- Manajemen User (CRUD user oleh admin) ----------
    Route::resource('admin/user', App\Http\Controllers\Admin\UserController::class)->names('admin.user');
    // Route khusus form tambah user (opsional, sudah termasuk di resource, tapi bisa eksplisit)
    Route::get('admin/user/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.create');
});

// ========================
// PROFILE ROUTES (untuk semua user yang login)
// ========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================
// AUTH ROUTES (Laravel Breeze/Fortify/Jetstream)
// ========================
require __DIR__ . '/auth.php';
