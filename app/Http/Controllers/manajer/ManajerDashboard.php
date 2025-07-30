<?php

namespace App\Http\Controllers\Manajer; // Pastikan namespace ini benar

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;

// Import Models yang relevan
use App\Models\User;
use App\Models\Interaksi;
use App\Models\JadwalKunjungan;
use App\Models\Feedback;
use App\Models\Pelanggan;
use App\Models\PemakaianDaya; // Untuk laporan pemakaian daya

class ManajerDashboard extends Controller
{
  public function __construct()
  {
    // Hanya user yang login dan memiliki peran 'manajer' yang bisa mengakses ini
    $this->middleware(['auth', 'role:manajer']);
  }

  /**
   * Menampilkan halaman Dashboard Manajer.
   */
  public function index()
  {
    // --- Logika Pengambilan Data untuk Dashboard Manajer ---
    // Statistik Umum
    $totalInteraksi = Interaksi::count();
    $totalKunjungan = JadwalKunjungan::count();
    $totalFeedback = Feedback::count();

    // Rata-rata Skor Feedback
    $rataRataSkorFeedback = Feedback::avg('skor');
    $rataRataSkorFeedback = round($rataRataSkorFeedback ?? 0, 1); // Bulatkan 1 desimal

    // Feedback Belum Tindak Lanjut (Status 'Baru' atau 'Sedang Ditangani')
    $feedbackBelumTindakLanjut = Feedback::whereIn('status', ['Baru', 'Sedang Ditangani'])->count();

    // Ringkasan Aktivitas Staff (untuk tabel/list di dashboard)
    $staffAktivitasRingkasan = User::whereHas('roles', function ($query) {
      $query->whereIn('name', ['staff']); // Hanya staff
    })
      ->withCount('interaksis') // Jumlah interaksi yang dicatat staff
      ->withCount(['jadwalKunjungans as completed_visits_count' => function ($query) {
        $query->where('status', 'selesai'); // Jumlah kunjungan selesai oleh staff
      }])
      ->orderBy('nama_lengkap')
      ->get();

    $labelsGrafik = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    $dataGrafik = [65, 59, 80, 81, 56, 55]; // Contoh data Kunjungan atau Interaksi

    // --- Akhir Logika Data Dashboard Manajer ---

    return view('manajer.dashboard', compact(
      'totalInteraksi',
      'totalKunjungan',
      'totalFeedback',
      'rataRataSkorFeedback',
      'feedbackBelumTindakLanjut',
      'staffAktivitasRingkasan',
      'labelsGrafik', // Untuk grafik
      'dataGrafik'    // Untuk grafik
    ));
  }

  /**
   * Menampilkan aktivitas staff untuk monitoring manajer
   */
  public function staffActivity(Request $request)
  {
    // Filter berdasarkan staff jika ada
    $staffId = $request->input('staff_id');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');

    // Ambil semua staff untuk dropdown filter
    $allStaff = User::whereHas('roles', function ($query) {
      $query->where('name', 'staff');
    })->get();

    // Query dasar untuk aktivitas staff
    $queryStaff = User::whereHas('roles', function ($query) {
      $query->where('name', 'staff');
    });

    // Terapkan filter jika ada
    if ($staffId) {
      $queryStaff->where('id', $staffId);
    }

    // Ambil data staff dengan relasi dan hitungan
    $staffActivities = $queryStaff->withCount([
      'interaksis' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
        if ($tanggalMulai) $query->where('tanggal', '>=', $tanggalMulai);
        if ($tanggalAkhir) $query->where('tanggal', '<=', $tanggalAkhir . ' 23:59:59');
      },
      'jadwalKunjungans as kunjungan_total' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
        if ($tanggalMulai) $query->where('tanggal_jadwal', '>=', $tanggalMulai);
        if ($tanggalAkhir) $query->where('tanggal_jadwal', '<=', $tanggalAkhir . ' 23:59:59');
      },
      'jadwalKunjungans as kunjungan_selesai' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
        $query->where('status', 'selesai');
        if ($tanggalMulai) $query->where('tanggal_jadwal', '>=', $tanggalMulai);
        if ($tanggalAkhir) $query->where('tanggal_jadwal', '<=', $tanggalAkhir . ' 23:59:59');
      }
    ])->paginate(10);

    return view('manajer.monitoring.staff-activity', compact('staffActivities', 'allStaff'));
  }

  /**
   * Menampilkan data kunjungan dan interaksi untuk monitoring manajer
   */
  public function kunjunganInteraksi(Request $request)
  {
    // Ambil semua user untuk dropdown filter
    $allUsers = User::whereHas('roles', function ($query) {
      $query->whereIn('name', ['staff', 'manajer']);
    })->get();

    // Ambil semua pelanggan untuk dropdown filter
    $allPelanggans = Pelanggan::all();

    // Filter untuk interaksi
    $queryInteraksi = Interaksi::with(['pelanggan', 'user']);
    if ($request->filled('pelanggan_id')) {
      $queryInteraksi->where('pelanggan_id', $request->pelanggan_id);
    }
    if ($request->filled('user_id')) {
      $queryInteraksi->where('user_id', $request->user_id);
    }
    if ($request->filled('tanggal_mulai')) {
      $queryInteraksi->where('tanggal', '>=', $request->tanggal_mulai);
    }
    if ($request->filled('tanggal_akhir')) {
      $queryInteraksi->where('tanggal', '<=', $request->tanggal_akhir . ' 23:59:59');
    }

    $interaksiPelanggan = $queryInteraksi->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'interaksiPage');

    // Filter untuk jadwal kunjungan
    $queryKunjungan = JadwalKunjungan::with(['pelanggan', 'user']);
    if ($request->filled('pelanggan_id')) {
      $queryKunjungan->where('pelanggan_id', $request->pelanggan_id);
    }
    if ($request->filled('user_id')) {
      $queryKunjungan->where('user_id', $request->user_id);
    }
    if ($request->filled('status')) {
      $queryKunjungan->where('status', $request->status);
    }
    if ($request->filled('tanggal_mulai')) {
      $queryKunjungan->where('tanggal_jadwal', '>=', $request->tanggal_mulai);
    }
    if ($request->filled('tanggal_akhir')) {
      $queryKunjungan->where('tanggal_jadwal', '<=', $request->tanggal_akhir . ' 23:59:59');
    }

    $jadwalKunjungans = $queryKunjungan->orderBy('tanggal_jadwal', 'desc')->paginate(10, ['*'], 'kunjunganPage');

    return view('manajer.monitoring.kunjungan-interaksi', compact('interaksiPelanggan', 'jadwalKunjungans', 'allUsers', 'allPelanggans'));
  }

  /**
   * Menampilkan laporan kunjungan untuk manajer
   */
  public function laporanKunjungan(Request $request)
  {
    $periode = $request->input('periode', 'bulan_ini');
    $tanggalMulai = null;
    $tanggalAkhir = null;

    // Tentukan rentang tanggal berdasarkan periode
    if ($periode == 'bulan_ini') {
      $tanggalMulai = Carbon::now()->startOfMonth()->format('Y-m-d');
      $tanggalAkhir = Carbon::now()->endOfMonth()->format('Y-m-d');
    } elseif ($periode == 'kuartal_ini') {
      $tanggalMulai = Carbon::now()->startOfQuarter()->format('Y-m-d');
      $tanggalAkhir = Carbon::now()->endOfQuarter()->format('Y-m-d');
    } elseif ($periode == 'tahun_ini') {
      $tanggalMulai = Carbon::now()->startOfYear()->format('Y-m-d');
      $tanggalAkhir = Carbon::now()->endOfYear()->format('Y-m-d');
    } elseif ($periode == 'kustom') {
      $tanggalMulai = $request->input('tanggal_mulai');
      $tanggalAkhir = $request->input('tanggal_akhir');
    }

    // Query untuk laporan kunjungan
    $queryKunjungan = JadwalKunjungan::with(['pelanggan', 'user']);
    if ($tanggalMulai) {
      $queryKunjungan->where('tanggal_jadwal', '>=', $tanggalMulai);
    }
    if ($tanggalAkhir) {
      $queryKunjungan->where('tanggal_jadwal', '<=', $tanggalAkhir . ' 23:59:59');
    }

    $kunjunganData = $queryKunjungan->orderBy('tanggal_jadwal', 'desc')->get();

    // Statistik kunjungan
    $totalKunjungan = $kunjunganData->count();
    $kunjunganSelesai = $kunjunganData->where('status', 'selesai')->count();
    $kunjunganBelumSelesai = $totalKunjungan - $kunjunganSelesai;
    $persentaseSelesai = $totalKunjungan > 0 ? round(($kunjunganSelesai / $totalKunjungan) * 100, 1) : 0;

    // Data untuk grafik
    $kunjunganPerStaff = $kunjunganData->groupBy('user_id')
      ->map(function ($items, $userId) {
        $user = User::find($userId);
        return [
          'nama_staff' => $user ? $user->name : 'Unknown',
          'total' => $items->count(),
          'selesai' => $items->where('status', 'selesai')->count()
        ];
      });

    return view('manajer.laporan.kunjungan', compact(
      'kunjunganData',
      'totalKunjungan',
      'kunjunganSelesai',
      'kunjunganBelumSelesai',
      'persentaseSelesai',
      'kunjunganPerStaff',
      'periode',
      'tanggalMulai',
      'tanggalAkhir'
    ));
  }

  /**
   * Menampilkan laporan feedback untuk manajer
   */
  public function laporanFeedback(Request $request)
  {
    $periode = $request->input('periode', 'bulan_ini');
    $tanggalMulai = null;
    $tanggalAkhir = null;

    // Tentukan rentang tanggal berdasarkan periode
    if ($periode == 'bulan_ini') {
      $tanggalMulai = Carbon::now()->startOfMonth()->format('Y-m-d');
      $tanggalAkhir = Carbon::now()->endOfMonth()->format('Y-m-d');
    } elseif ($periode == 'kuartal_ini') {
      $tanggalMulai = Carbon::now()->startOfQuarter()->format('Y-m-d');
      $tanggalAkhir = Carbon::now()->endOfQuarter()->format('Y-m-d');
    } elseif ($periode == 'tahun_ini') {
      $tanggalMulai = Carbon::now()->startOfYear()->format('Y-m-d');
      $tanggalAkhir = Carbon::now()->endOfYear()->format('Y-m-d');
    } elseif ($periode == 'kustom') {
      $tanggalMulai = $request->input('tanggal_mulai');
      $tanggalAkhir = $request->input('tanggal_akhir');
    }

    // Query untuk laporan feedback
    $queryFeedback = Feedback::with('pelanggan');
    if ($tanggalMulai) {
      $queryFeedback->where('created_at', '>=', $tanggalMulai);
    }
    if ($tanggalAkhir) {
      $queryFeedback->where('created_at', '<=', $tanggalAkhir . ' 23:59:59');
    }

    $feedbackData = $queryFeedback->orderBy('created_at', 'desc')->get();

    // Statistik feedback
    $totalFeedback = $feedbackData->count();
    $rataRataSkor = $feedbackData->avg('rating') ?? 0;
    $rataRataSkor = round($rataRataSkor, 1);

    // Data untuk grafik distribusi rating
    $distribusiRating = $feedbackData->groupBy('rating')
      ->map(function ($items, $rating) {
        return [
          'rating' => $rating,
          'jumlah' => $items->count()
        ];
      });

    return view('manajer.laporan.feedback', compact(
      'feedbackData',
      'totalFeedback',
      'rataRataSkor',
      'distribusiRating',
      'periode',
      'tanggalMulai',
      'tanggalAkhir'
    ));
  }

  /**
   * Menampilkan laporan pemakaian daya untuk manajer
   */
  public function laporanPemakaianDaya(Request $request)
  {
    $periode = $request->input('periode', 'bulan_ini');
    $tahun = $request->input('tahun', Carbon::now()->year);
    $bulan = $request->input('bulan', Carbon::now()->month);

    // Query untuk laporan pemakaian daya
    $queryPemakaian = PemakaianDaya::with('pelanggan');

    // Filter berdasarkan periode
    if ($periode == 'bulan') {
      $bulanTahun = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
      $queryPemakaian->where('bulan_tahun', 'like', $bulanTahun . '%');
    } elseif ($periode == 'tahun') {
      $queryPemakaian->where('bulan_tahun', 'like', $tahun . '%');
    }

    $pemakaianData = $queryPemakaian->orderBy('bulan_tahun', 'desc')->get();

    // Statistik pemakaian daya
    $totalPemakaian = $pemakaianData->sum('pemakaian_Kwh');
    $totalAnomali = $pemakaianData->where('flag_anomali', 1)->count();

    // Data untuk grafik trend pemakaian
    $trendPemakaian = [];
    if ($periode == 'bulan') {
      // Trend harian dalam satu bulan
      $trendPemakaian = $pemakaianData->groupBy(function ($item) {
        return Carbon::parse($item->bulan_tahun)->format('d');
      })->map(function ($items) {
        return $items->sum('pemakaian_Kwh');
      });
    } elseif ($periode == 'tahun') {
      // Trend bulanan dalam satu tahun
      $trendPemakaian = $pemakaianData->groupBy(function ($item) {
        return Carbon::parse($item->bulan_tahun)->format('m');
      })->map(function ($items) {
        return $items->sum('pemakaian_Kwh');
      });
    }

    return view('manajer.laporan.pemakaian-daya', compact(
      'pemakaianData',
      'totalPemakaian',
      'totalAnomali',
      'trendPemakaian',
      'periode',
      'tahun',
      'bulan'
    ));
  }

  /**
   * Menampilkan form unduh laporan untuk manajer
   */
  public function unduhLaporan()
  {
    return view('manajer.laporan.unduh');
  }

  /**
   * Memproses permintaan unduh laporan
   */
  public function doUnduhLaporan(Request $request)
  {
    $jenis = $request->input('jenis_laporan');
    $format = $request->input('format');
    $periode = $request->input('periode');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');

    // Logika untuk menghasilkan dan mengunduh laporan sesuai parameter
    // Implementasi sesuai kebutuhan (PDF, Excel, dll)

    return redirect()->back()->with('success', 'Laporan berhasil diunduh');
  }
}
