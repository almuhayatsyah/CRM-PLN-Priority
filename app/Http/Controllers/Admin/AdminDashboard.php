<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Interaksi;
use App\Models\JadwalKunjungan;
use App\Models\Feedback;
use App\Models\PemakaianDaya;
use App\Carbon\Carbon;

use Illuminate\Routing\Controller;

class AdminDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function kunjunganInteraksi(Request $request)
    {
        // Ambil semua user (untuk dropdown filter Staff/User Pelaksana)
        $allUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff'); // <--- Hanya filter peran 'staff'
        })->get();
        // Ambil semua pelanggan (untuk dropdown filter Pelanggan)
        $allPelanggans = Pelanggan::orderBy('nama_perusahaan')->get(); // <--- TAMBAHKAN INI

        // --- Logika Filter untuk Interaksi Pelanggan Umum ---
        $queryInteraksi = Interaksi::with(['pelanggan', 'user']);
        // Filter berdasarkan ID pelanggan (dari dropdown)
        if ($request->filled('pelanggan_id')) { // UBAH DARI 'pelanggan_nama' menjadi 'pelanggan_id'
            $queryInteraksi->where('pelanggan_id', $request->pelanggan_id); // UBAH LOGIKA FILTER
        }

        // Filter berdasarkan user pelaksana
        if ($request->filled('user_id')) {
            $queryInteraksi->where('user_id', $request->user_id);
        }

        // Filter berdasarkan status interaksi
        if ($request->filled('interaksi_status')) {
            $queryInteraksi->where('status_interaksi', $request->interaksi_status);
        }

        // Filter berdasarkan rentang tanggal interaksi
        if ($request->filled('tanggal_mulai')) {
            $queryInteraksi->where('tanggal_interaksi', '>=', $request->tanggal_mulai . ' 00:00:00');
        }
        if ($request->filled('tanggal_akhir')) {
            $queryInteraksi->where('tanggal_interaksi', '<=', $request->tanggal_akhir . ' 23:59:59');
        }

        $interaksiPelanggan = $queryInteraksi->latest('tanggal_interaksi')->paginate(10, ['*'], 'interaksiPage');


        // --- Logika Filter untuk Jadwal Kunjungan ---
        $queryKunjungan = JadwalKunjungan::with(['pelanggan', 'user']);

        // Filter berdasarkan ID pelanggan (dari dropdown)
        if ($request->filled('pelanggan_id')) { // UBAH DARI 'pelanggan_nama' menjadi 'pelanggan_id'
            $queryKunjungan->where('pelanggan_id', $request->pelanggan_id); // UBAH LOGIKA FILTER
        }

        // Filter berdasarkan staff pelaksana
        if ($request->filled('user_id')) {
            $queryKunjungan->where('user_id', $request->user_id);
        }

        // Filter berdasarkan status kunjungan
        if ($request->filled('kunjungan_status')) {
            $queryKunjungan->where('status', $request->kunjungan_status);
        }

        // Filter berdasarkan rentang tanggal jadwal
        if ($request->filled('tanggal_mulai')) {
            $queryKunjungan->where('tanggal_jadwal', '>=', $request->tanggal_mulai . ' 00:00:00');
        }
        if ($request->filled('tanggal_akhir')) {
            $queryKunjungan->where('tanggal_jadwal', '<=', $request->tanggal_akhir . ' 23:59:59');
        }

        $jadwalKunjungans = $queryKunjungan->orderBy('tanggal_jadwal', 'desc')->paginate(10, ['*'], 'kunjunganPage');

        // Lewatkan semua variabel ke view, termasuk $allUsers dan $allPelanggans
        return view('admin.monitoring_aktivitas.kunjungan-interaksi', compact('interaksiPelanggan', 'jadwalKunjungans', 'allUsers', 'allPelanggans')); // <--- TAMBAHKAN 'allPelanggans'
    }
    public function index()
    {
        // Ambil total pelanggan
        $totalPelanggan = Pelanggan::count();

        $totalUsers = User::count();
        $totalFeedback = \App\Models\Feedback::count();
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
            'totalFeedback',
            'pelangganAktif', // Pastikan variabel ini ada di sini!
            'pemakaianDaya'
        ));
    }
}
