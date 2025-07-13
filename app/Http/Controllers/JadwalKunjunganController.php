<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\User; // Untuk dropdown user/staff yang bertugas
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login
use Illuminate\Routing\Controller; // Pastikan ini diimport

class JadwalKunjunganController extends Controller
{

  public function ___construct()
  {
    $this->middleware('auth');
    $this->middleware('role:admin|staff')->only(['create', 'store', 'edit', 'update', 'destroy']);
    $this->middleware('role:admin|manajer|staff')->only(['index', 'show']);
  }


  public function index()
  {
    // Ambil jadwal kunjungan yang dilakukan oleh user login (jika staff), atau semua (jika admin/manajer)
    if (Auth::user()->hasRole('staff')) {
      $jadwalKunjungans = JadwalKunjungan::with(['pelanggan', 'user'])
        ->where('user_id', Auth::id())
        ->latest('tanggal_jadwal')
        ->paginate(10);
    } else {
      $jadwalKunjungans = JadwalKunjungan::with(['pelanggan', 'user'])
        ->latest('tanggal_jadwal')
        ->paginate(10);
    }

    return view('admin.jadwal-kunjungan.index', compact('jadwalKunjungans'));
  }

  public function create()
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
    $users = \App\Models\User::whereHas('roles', function ($query) {
      $query->whereIn('name', ['admin', 'staff']); // Hanya user dengan peran 'admin' atau 'staff'
    })->get();

    return view('admin.jadwal-kunjungan.create', compact('pelanggans', 'users'));
  }
  public function store(Request $request)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'user_id' => 'required|exists:users,id', // Staff yang ditugaskan
      'tanggal_jadwal' => 'required|date',
      'tujuan' => 'required|string',
      'status' => 'required|in:dijadwalkan,selesai,batal', // Validasi enum
    ]);

    JadwalKunjungan::create([
      'pelanggan_id' => $request->pelanggan_id,
      'user_id' => $request->user_id,
      'tanggal_jadwal' => $request->tanggal_jadwal,
      'tujuan' => $request->tujuan,
      'hasil' => $request->hasil, // Hasil bisa kosong saat buat
      'status' => $request->status,
    ]);

    return redirect()->route('admin.jadwal-kunjungan.index')->with('success', 'Jadwal Kunjungan berhasil ditambahkan!');
  }
  public function show(JadwalKunjungan $jadwalKunjungan)
  {
    return view('admin.jadwal-kunjungan.show', compact('jadwalKunjungan'));
  }
  public function edit(JadwalKunjungan $jadwalKunjungan)
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
    $users = \App\Models\User::whereHas('roles', function ($query) {
      $query->whereIn('name', ['admin', 'staff']); // Hanya user dengan peran 'admin' atau 'staff'
    })->get();
    // --- AKHIR UBAH ---
    return view('admin.jadwal-kunjungan.edit', compact('jadwalKunjungan', 'pelanggans', 'users'));
  }
  public function update(Request $request, JadwalKunjungan $jadwalKunjungan)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'user_id' => 'required|exists:users,id',
      'tanggal_jadwal' => 'required|date',
      'tujuan' => 'required|string',
      'hasil' => 'nullable|string', // Hasil bisa null
      'status' => 'required|in:dijadwalkan,selesai,batal',
    ]);

    $jadwalKunjungan->update([
      'pelanggan_id' => $request->pelanggan_id,
      'user_id' => $request->user_id,
      'tanggal_jadwal' => $request->tanggal_jadwal,
      'tujuan' => $request->tujuan,
      'hasil' => $request->hasil,
      'status' => $request->status,
    ]);

    return redirect()->route('admin.jadwal-kunjungan.index')->with('success', 'Jadwal Kunjungan berhasil diperbarui!');
  }

  public function destroy(JadwalKunjungan $jadwalKunjungan)
  {
    $jadwalKunjungan->delete();
    return redirect()->route('admin.jadwal-kunjungan.index')->with('success', 'Jadwal Kunjungan berhasil dihapus!');
  }
}
