<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LandingPageController;

// Impor Controller khusus Admin dari sub-namespace Admin
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\UserController;

// Impor Controller modul yang dipakai bersama dari namespace utama
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\JadwalKunjunganController;
use App\Http\Controllers\InteraksiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PemakaianDayaController;


use Illuminate\Support\Facades\Route;

// Rute Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Grup Rute yang Membutuhkan Autentikasi
// Middleware 'role' akan diterapkan di __construct masing-masing Controller
Route::middleware(['auth'])->group(function () {
    // RUTE UNTUK MODUL KHUSUS ADMIN
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // Manajemen User Sistem (Hanya Admin)
    Route::resource('admin/users', UserController::class)->names('admin.users');

    // Monitoring Aktivitas
    Route::get('admin/monitoring/staff-activity', [AdminDashboard::class, 'staffActivity'])->name('admin.monitoring.staff-activity');
    Route::get('admin/monitoring/kunjungan-interaksi', [AdminDashboard::class, 'kunjunganInteraksi'])->name('admin.monitoring.kunjungan-interaksi');
    Route::get('admin/monitoring/feedback-masuk', [AdminDashboard::class, 'feedbackMasuk'])->name('admin.monitoring.feedback-masuk');

    // Laporan & Analitik
    Route::get('admin/laporan/kunjungan', [AdminDashboard::class, 'laporanKunjungan'])->name('admin.laporan.kunjungan');
    Route::get('admin/laporan/feedback', [AdminDashboard::class, 'laporanFeedback'])->name('admin.laporan.feedback');
    Route::get('admin/laporan/pemakaian-daya', [AdminDashboard::class, 'laporanPemakaianDaya'])->name('admin.laporan.pemakaian-daya');
    Route::get('admin/laporan/unduh', [AdminDashboard::class, 'unduhLaporan'])->name('admin.laporan.unduh'); // Rute untuk menampilkan form unduh

    // PENTING: Tambahkan Rute POST untuk memproses unduh laporan
    Route::post('admin/laporan/do-unduh', [AdminDashboard::class, 'doUnduhLaporan'])->name('admin.laporan.do-unduh'); // <-- TAMBAHKAN INI

    // Pengaturan Sistem
    Route::get('admin/pengaturan-sistem', [AdminDashboard::class, 'pengaturanSistem'])->name('admin.pengaturan-sistem');


    // RUTE UNTUK MODUL YANG DIPAKAI BERSAMA
    // PENTING: Rute spesifik (seperti export) HARUS di atas resource yang lebih umum untuk Controller yang sama.
    Route::get('admin/pelanggan/export-pdf', [PelangganController::class, 'exportPdf'])->name('admin.pelanggan.exportPdf');
    Route::get('admin/pelanggan/export-excel', [PelangganController::class, 'exportExcel'])->name('admin.pelanggan.exportExcel');
    // Resource route untuk Pelanggan (harus di bawah rute export spesifiknya)
    Route::resource('admin/pelanggan', PelangganController::class)->names('admin.pelanggan');

    // Resource routes untuk modul-modul lain
    Route::resource('admin/jadwal-kunjungan', JadwalKunjunganController::class)->names('admin.jadwal-kunjungan');
    Route::resource('admin/interaksi', InteraksiController::class)->names('admin.interaksi');
    Route::resource('admin/feedback', FeedbackController::class)->names('admin.feedback');
    Route::resource('admin/notifikasi', NotifikasiController::class)->names('admin.notifikasi');
    Route::resource('admin/pemakaian-daya', PemakaianDayaController::class)->names('admin.pemakaian-daya');


    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute Autentikasi Bawaan Laravel Breeze
require __DIR__ . '/auth.php';
