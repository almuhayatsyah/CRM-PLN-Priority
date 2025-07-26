<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

// Import Models yang relevan
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Interaksi; // Model Interaksi yang benar
use App\Models\JadwalKunjungan;
use App\Models\Feedback;
use App\Models\PemakaianDaya;

// Import Export Classes
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PelangganExport; // Ini sudah ada dan berfungsi

// Import Export Classes BARU yang akan kita buat:
use App\Exports\KunjunganExport;
use App\Exports\InteraksiExport;
use App\Exports\FeedbackExport;
use App\Exports\PemakaianDayaExport;

class AdminDashboard extends Controller
{
    // ...

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|menejer']);
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
    public function laporanKunjungan(Request $request)
    {
        // Ambil filter dari request
        $tahunFilter = $request->input('tahun', Carbon::now()->year); // Default tahun sekarang
        $staffFilter = $request->input('user_id'); // Filter berdasarkan staff
        $statusFilter = $request->input('status'); // Filter berdasarkan status kunjungan

        // Data untuk filter dropdown
        $allUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['admin', 'staff', 'manajer']);
        })->get(); // Ambil admin, staff, manajer untuk filter staff
        $tahunOptions = range(Carbon::now()->year, Carbon::now()->year - 5); // Opsi 5 tahun terakhir

        // --- Query Utama Laporan ---
        $queryLaporan = JadwalKunjungan::with(['pelanggan', 'user'])
            ->whereYear('tanggal_jadwal', $tahunFilter);

        if ($staffFilter) {
            $queryLaporan->where('user_id', $staffFilter);
        }
        if ($statusFilter) {
            $queryLaporan->where('status', $statusFilter);
        }

        $laporanKunjungans = $queryLaporan->orderBy('tanggal_jadwal', 'desc')->paginate(10);


        // --- Data Statistik Kunjungan (untuk card dan grafik) ---
        $totalKunjungan = JadwalKunjungan::whereYear('tanggal_jadwal', $tahunFilter)->count();
        $kunjunganDijadwalkan = JadwalKunjungan::whereYear('tanggal_jadwal', $tahunFilter)->where('status', 'dijadwalkan')->count();
        $kunjunganSelesai = JadwalKunjungan::whereYear('tanggal_jadwal', $tahunFilter)->where('status', 'selesai')->count();
        $kunjunganBatal = JadwalKunjungan::whereYear('tanggal_jadwal', $tahunFilter)->where('status', 'batal')->count();


        // Data untuk Grafik Kunjungan per Bulan
        $kunjunganPerBulan = JadwalKunjungan::select(
            DB::raw('MONTH(tanggal_jadwal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tanggal_jadwal', $tahunFilter)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $labelsGrafik = [];
        $dataGrafik = [];
        for ($i = 1; $i <= 12; $i++) {
            $labelsGrafik[] = Carbon::create()->month($i)->format('M'); // Nama bulan singkat
            $dataGrafik[] = $kunjunganPerBulan->has($i) ? $kunjunganPerBulan[$i]->total : 0;
        }

        // Lewatkan data ke view
        return view('admin.laporan.kunjungan', compact(
            'laporanKunjungans',
            'totalKunjungan',
            'kunjunganDijadwalkan',
            'kunjunganSelesai',
            'kunjunganBatal',
            'allUsers',
            'tahunOptions',
            'tahunFilter',
            'staffFilter',
            'statusFilter',
            'labelsGrafik',
            'dataGrafik'
        ));
    }
    public function laporanPemakaianDaya(Request $request)
    {
        $tahunFilter = $request->input('tahun', Carbon::now()->year);
        $pelangganFilter = $request->input('pelanggan_id');
        $anomaliFilter = $request->input('flag_anomali');

        // Query utama data tabel laporan
        $queryLaporan = PemakaianDaya::query()->with(['pelanggan']); // Relasi pelanggan

        // Filter data laporan
        if ($tahunFilter) {
            $queryLaporan->whereRaw("SUBSTRING(bulan_tahun, 1, 4) = ?", [$tahunFilter]);
        }
        if ($pelangganFilter) {
            $queryLaporan->where('pelanggan_id', $pelangganFilter);
        }
        if ($anomaliFilter !== null) {
            $queryLaporan->where('flag_anomali', $anomaliFilter);
        }

        $laporanPemakaianDayas = $queryLaporan->latest('bulan_tahun')->paginate(10);

        // --- Statistik untuk Card dan Grafik ---
        $totalCatatan = PemakaianDaya::whereRaw("SUBSTRING(bulan_tahun, 1, 4) = ?", [$tahunFilter])->count();
        $totalAnomali = PemakaianDaya::whereRaw("SUBSTRING(bulan_tahun, 1, 4) = ?", [$tahunFilter])->where('flag_anomali', 1)->count();
        $persentaseAnomali = ($totalCatatan > 0) ? round(($totalAnomali / $totalCatatan) * 100) : 0;

        // Data untuk Grafik Pemakaian Daya per Bulan (Contoh)
        $pemakaianPerBulan = PemakaianDaya::select(
            DB::raw('SUBSTRING(bulan_tahun, 6, 2) as bulan'), // Ambil bulan dari format YYYY-MM
            DB::raw('SUM(pemakaian_Kwh) as total_kwh')
        )
            ->whereRaw("SUBSTRING(bulan_tahun, 1, 4) = ?", [$tahunFilter])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $labelsGrafik = [];
        $dataGrafikKwh = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanStr = str_pad($i, 2, '0', STR_PAD_LEFT); // Format bulan menjadi 01, 02, dst.
            $labelsGrafik[] = Carbon::create()->month($i)->format('M'); // Nama bulan singkat
            $dataGrafikKwh[] = $pemakaianPerBulan->has($bulanStr) ? $pemakaianPerBulan[$bulanStr]->total_kwh : 0;
        }
        // --- Akhir Statistik dan Grafik ---


        // Data untuk filter dropdown di view
        $allPelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
        $tahunOptions = range(Carbon::now()->year, Carbon::now()->year - 5);


        return view('admin.laporan.pemakaian-daya', compact(
            'laporanPemakaianDayas',
            'totalCatatan',
            'totalAnomali',
            'persentaseAnomali',
            'tahunFilter',
            'pelangganFilter',
            'anomaliFilter',
            'allPelanggans',
            'tahunOptions',
            'labelsGrafik',
            'dataGrafikKwh' // Variabel untuk grafik
        ));
    }

    public function unduhLaporan() // <--- Pastikan method ini ada
    {
        // Ambil data yang dibutuhkan untuk dropdown filter di view
        $allPelanggans = \App\Models\Pelanggan::all();
        $allUsers = \App\Models\User::all();
        $tahunOptions = range(Carbon::now()->year, Carbon::now()->year - 5);

        return view('admin.laporan.unduh', compact('allPelanggans', 'allUsers', 'tahunOptions'));
    }

    /**
     * Memproses permintaan unduh laporan (Excel atau PDF).
     */
    public function doUnduhLaporan(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string|in:pelanggan,kunjungan,interaksi,feedback,pemakaian_daya',
            'export_format' => 'required|string|in:pdf,excel',
            'tahun' => 'nullable|integer',
            'pelanggan_id' => 'nullable|exists:pelanggan,id',
            'user_id' => 'nullable|exists:users,id',
            'status_kunjungan' => 'nullable|string|in:dijadwalkan,selesai,batal',
            'status_umum' => 'nullable|string|in:Open,Resolved,Follow-up,Baru,Sedang Ditangani,Selesai', // Gabungan status interaksi & feedback
            'flag_anomali' => 'nullable|boolean',
        ]);

        $reportType = $request->input('report_type');
        $exportFormat = $request->input('export_format');

        // Ambil filter yang relevan untuk query data
        $filters = $request->only([
            'tahun',
            'pelanggan_id',
            'user_id',
            'status_kunjungan',
            'status_umum',
            'flag_anomali'
        ]);

        // Deklarasi variabel $data di luar blok if agar selalu terdefinisi
        $data = collect(); // Menggunakan koleksi kosong sebagai default

        // --- Logika Ekspor Berdasarkan Jenis Laporan dan Format ---
        if ($reportType === 'pelanggan') {
            $query = Pelanggan::query()->with('user');
            if ($filters['pelanggan_id']) {
                $query->where('id', $filters['pelanggan_id']);
            }
            // Anda bisa menambahkan filter lain untuk pelanggan jika diperlukan (e.g., nama_cari, up3, sektor)
            $data = $query->get();

            if ($exportFormat === 'pdf') {
                $pdf = Pdf::loadView('admin.pelanggan.export_pdf', compact('data')); // Sekarang view akan menerima $data
                return $pdf->download('laporan_pelanggan_' . Carbon::now()->format('Ymd_His') . '.pdf');
            } elseif ($exportFormat === 'excel') {
                return Excel::download(new PelangganExport($data), 'laporan_pelanggan_' . Carbon::now()->format('Ymd_His') . '.xlsx');
            }
        } elseif ($reportType === 'kunjungan') {
            $query = JadwalKunjungan::query()->with(['pelanggan', 'user']);
            if ($filters['tahun']) {
                $query->whereYear('tanggal_jadwal', $filters['tahun']);
            }
            if ($filters['pelanggan_id']) {
                $query->where('pelanggan_id', $filters['pelanggan_id']);
            }
            if ($filters['user_id']) {
                $query->where('user_id', $filters['user_id']);
            }
            if ($filters['status_kunjungan']) {
                $query->where('status', $filters['status_kunjungan']);
            }
            $data = $query->get();

            if ($exportFormat === 'pdf') {
                $pdf = Pdf::loadView('admin.laporan.kunjungan_pdf', compact('data'));
                return $pdf->download('laporan_kunjungan_' . Carbon::now()->format('Ymd_His') . '.pdf');
            } elseif ($exportFormat === 'excel') {
                return Excel::download(new KunjunganExport($data), 'laporan_kunjungan_' . Carbon::now()->format('Ymd_His') . '.xlsx');
            }
        } elseif ($reportType === 'interaksi') {
            $query = Interaksi::query()->with(['pelanggan', 'user']);
            if ($filters['tahun']) {
                $query->whereYear('tanggal_interaksi', $filters['tahun']);
            }
            if ($filters['pelanggan_id']) {
                $query->where('pelanggan_id', $filters['pelanggan_id']);
            }
            if ($filters['user_id']) {
                $query->where('user_id', $filters['user_id']);
            }
            if ($filters['status_umum']) {
                $query->where('status_interaksi', $filters['status_umum']);
            }
            $data = $query->get();

            if ($exportFormat === 'pdf') {
                $pdf = Pdf::loadView('admin.laporan.interaksi_pdf', compact('data'));
                return $pdf->download('laporan_interaksi_' . Carbon::now()->format('Ymd_His') . '.pdf');
            } elseif ($exportFormat === 'excel') {
                return Excel::download(new InteraksiExport($data), 'laporan_interaksi_' . Carbon::now()->format('Ymd_His') . '.xlsx');
            }
        } elseif ($reportType === 'feedback') {
            $query = Feedback::query()->with(['pelanggan']);
            if ($filters['tahun']) {
                $query->whereYear('created_at', $filters['tahun']);
            }
            if ($filters['pelanggan_id']) {
                $query->where('pelanggan_id', $filters['pelanggan_id']);
            }
            if ($filters['status_umum']) {
                $query->where('status', $filters['status_umum']);
            }
            $data = $query->get();

            if ($exportFormat === 'pdf') {
                $pdf = Pdf::loadView('admin.laporan.feedback_pdf', compact('data'));
                return $pdf->download('laporan_feedback_' . Carbon::now()->format('Ymd_His') . '.pdf');
            } elseif ($exportFormat === 'excel') {
                return Excel::download(new FeedbackExport($data), 'laporan_feedback_' . Carbon::now()->format('Ymd_His') . '.xlsx');
            }
        } elseif ($reportType === 'pemakaian_daya') {
            $query = PemakaianDaya::query()->with(['pelanggan']);
            // Untuk filter tahun, karena bulan_tahun adalah varchar, perlu parsing
            if ($filters['tahun']) {
                $query->whereRaw("SUBSTRING(bulan_tahun, 1, 4) = ?", [$filters['tahun']]);
            }
            if ($filters['pelanggan_id']) {
                $query->where('pelanggan_id', $filters['pelanggan_id']);
            }
            if ($filters['flag_anomali'] !== null) {
                $query->where('flag_anomali', $filters['flag_anomali']);
            }
            $data = $query->get();

            if ($exportFormat === 'pdf') {
                $pdf = Pdf::loadView('admin.laporan.pemakaian_daya_pdf', compact('data'));
                return $pdf->download('laporan_pemakaian_daya_' . Carbon::now()->format('Ymd_His') . '.pdf');
            } elseif ($exportFormat === 'excel') {
                return Excel::download(new PemakaianDayaExport($data), 'laporan_pemakaian_daya_' . Carbon::now()->format('Ymd_His') . '.xlsx');
            }
        }
        // --- Akhir Logika Ekspor ---

        return redirect()->back()->with('error', 'Jenis laporan atau format tidak valid.');
    }
    public function laporanFeedback(Request $request) // <--- PASTIKAN METHOD INI ADA DAN NAMANYA BENAR
    {
        // Ambil filter dari request
        $tahunFilter = $request->input('tahun', Carbon::now()->year); // Default tahun sekarang
        $skorFilter = $request->input('skor');
        $statusFilter = $request->input('status'); // Mengacu pada status_umum di form unduh

        // Query utama laporan feedback
        $queryFeedback = Feedback::query()->with('pelanggan');

        if ($tahunFilter) {
            $queryFeedback->whereYear('created_at', $tahunFilter);
        }
        if ($skorFilter) {
            $queryFeedback->where('skor', $skorFilter);
        }
        if ($statusFilter) {
            $queryFeedback->where('status', $statusFilter);
        }

        $laporanFeedbacks = $queryFeedback->latest('created_at')->paginate(10); // Order by tanggal dibuat

        // Data statistik untuk card
        $totalFeedback = Feedback::whereYear('created_at', $tahunFilter)->count();
        $feedbackBaru = Feedback::whereYear('created_at', $tahunFilter)->where('status', 'Baru')->count();
        $feedbackSelesai = Feedback::whereYear('created_at', $tahunFilter)->where('status', 'Selesai')->count();
        $rataRataSkor = Feedback::whereYear('created_at', $tahunFilter)->avg('skor');


        // Data untuk filter dropdown
        $tahunOptions = range(Carbon::now()->year, Carbon::now()->year - 5);
        // Tidak perlu allUsers atau allPelanggans di sini karena sudah ada di showUnduhLaporanForm
        // dan untuk laporan feedback tidak ada filter staff atau pelanggan langsung

        return view('admin.laporan.feedback', compact(
            'laporanFeedbacks',
            'totalFeedback',
            'feedbackBaru',
            'feedbackSelesai',
            'rataRataSkor',
            'tahunFilter',
            'skorFilter',
            'statusFilter',
            'tahunOptions' // Pastikan ini dilewatkan ke view untuk dropdown tahun
        ));
    }
}
