<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // <-- PASTIKAN BARIS INI ADA DAN BENAR!
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Interaksi; // Pastikan model ini diimport
use App\Models\Feedback; // Pastikan model ini diimport

class AdminController extends Controller // <-- Ini yang benar
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Ambil total pelanggan
        $totalPelanggan = Pelanggan::count();

        // Ambil total users (bisa difilter berdasarkan role jika perlu)
        $totalUsers = User::count();

        $totalInteraksi = \App\Models\Interaksi::count();
        $totalFeedback = \App\Models\Feedback::count();

        // *** Bagian yang hilang atau perlu dipastikan: Mendapatkan data pelanggan aktif ***
        // Anda bisa definisikan kriteria "aktif" sesuai kebutuhan.
        // Contoh sederhana: ambil 5 pelanggan terbaru.
        $pelangganAktif = Pelanggan::orderBy('created_at', 'desc')->limit(5)->get();

        // Contoh data dummy untuk grafik (akan diganti dengan data sesungguhnya nanti)
        $pemakaianDaya = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [65, 59, 80, 81, 56, 55],
        ];

        // *** Pastikan semua variabel yang digunakan di view dilewatkan di sini ***
        return view('admin.dashboard', compact(
            'totalPelanggan',
            'totalUsers',
            'totalInteraksi',
            'totalFeedback',
            'pelangganAktif', // Pastikan variabel ini ada di sini!
            'pemakaianDaya'
        ));
    }
}
