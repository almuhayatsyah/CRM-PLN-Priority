<?php

use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JadwalKunjunganController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PemakaianDayaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InteraksiController;



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
    Route::get('admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::resource('admin/user', UserController::class)->names('admin.user');
    Route::get('admin/user/create', [UserController::class, 'create'])->name('admin.user.create');


    // ---------- Manajemen Pelanggan ----------
    Route::get('admin/pelanggan/export-pdf', [App\Http\Controllers\PelangganController::class, 'exportPdf'])->name('admin.pelanggan.exportPdf');
    Route::resource('admin/pelanggan', App\Http\Controllers\PelangganController::class)->names('admin.pelanggan');
    Route::get('admin/pelanggan/create', [App\Http\Controllers\PelangganController::class, 'create'])->name('admin.pelanggan.create');


    // ---------- Manajemen Aktivitas ----------
    Route::resource('admin/interaksi', InteraksiController::class)->names('admin.interaksi');
    Route::get('admin/monitoring_aktivitas/kunjungan-interaksi', [AdminDashboard::class, 'kunjunganInteraksi'])->name('admin.monitoring.kunjungan-interaksi');

    Route::resource('admin/jadwal-kunjungan', JadwalKunjunganController::class)->names('admin.jadwal-kunjungan');
    // ---------- Manajemen Feedback ----------
    Route::resource('admin/laporan/feedback', FeedbackController::class)->names('admin.feedback');

    // ---------- Manajemen Notifikasi ----------
    Route::resource('admin/notifikasi', NotifikasiController::class)->names('admin.notifikasi');

    // ---------- Manajemen Pemakaian Daya ----------
    Route::resource('admin/pemakaian-daya', PemakaianDayaController::class)->names('admin.pemakaian-daya');



    // ----------Feedback-----------------



    // ---------- Manajemen User (CRUD user oleh admin) ----------

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
