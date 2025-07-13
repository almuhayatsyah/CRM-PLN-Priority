<?php

namespace App\Http\Controllers;

use App\Models\Interaksi; // Model Interaksi yang baru
use App\Models\Pelanggan; // Untuk dropdown pelanggan
use App\Models\User; // Untuk relasi user
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class InteraksiController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth'); // User harus login
    // Admin & Staff bisa CRUD, Manajer hanya bisa melihat
    $this->middleware('role:admin|staff')->only(['create', 'store', 'edit', 'update', 'destroy']);
    $this->middleware('role:admin|manajer|staff')->only(['index', 'show']);
  }

  /**
   * Menampilkan daftar semua interaksi.
   */
  public function index()
  {
    // Jika user adalah staff, tampilkan hanya interaksi mereka. Admin/Manajer tampilkan semua.
    if (Auth::user()->hasRole('staff')) {
      $interaksis = Interaksi::with(['pelanggan', 'user'])
        ->where('user_id', Auth::id())
        ->latest('tanggal_interaksi')
        ->paginate(10);
    } else {
      $interaksis = Interaksi::with(['pelanggan', 'user'])
        ->latest('tanggal_interaksi')
        ->paginate(10);
    }

    return view('admin.interaksi.index', compact('interaksis'));
  }
  public function create()
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
    $users = \App\Models\User::whereHas('roles', function ($query) {
      $query->whereIn('name', ['admin', 'staff']); // Hanya user dengan peran 'admin' atau 'staff'
    })->get();

    return view('admin.interaksi.create', compact('pelanggans', 'users'));
  }
  /**
   * Menyimpan interaksi baru ke database.
   */
  public function store(Request $request)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'user_id' => 'required|exists:users,id', // User yang melakukan interaksi
      'jenis_interaksi' => 'required|string|max:50',
      'deskripsi' => 'required|string',
      'tanggal_interaksi' => 'required|date',
      'status_interaksi' => 'required|in:Open,Resolved,Follow-up', // Pastikan sesuai enum di DB jika ada
    ]);

    Interaksi::create([
      'pelanggan_id' => $request->pelanggan_id,
      'user_id' => $request->user_id, // ID user yang dipilih di form
      'jenis_interaksi' => $request->jenis_interaksi,
      'deskripsi' => $request->deskripsi,
      'tanggal_interaksi' => $request->tanggal_interaksi,
      'status_interaksi' => $request->status_interaksi,
    ]);

    return redirect()->route('admin.interaksi.index')->with('success', 'Interaksi berhasil ditambahkan!');
  }

  /**
   * Menampilkan detail interaksi.
   */
  public function show(Interaksi $interaksi)
  {
    return view('admin.interaksi.show', compact('interaksi'));
  }

  /**
   * Menampilkan form untuk mengedit interaksi.
   */

  public function edit(Interaksi $interaksi)
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
    $users = \App\Models\User::whereHas('roles', function ($query) {
      $query->whereIn('name', ['admin', 'staff']); // Hanya user dengan peran 'admin' atau 'staff'
    })->get();
    return view('admin.interaksi.edit', compact('interaksi', 'pelanggans', 'users'));
  }
  
  /**
   * Memperbarui interaksi di database.
   */
  public function update(Request $request, Interaksi $interaksi)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'user_id' => 'required|exists:users,id',
      'jenis_interaksi' => 'required|string|max:50',
      'deskripsi' => 'required|string',
      'tanggal_interaksi' => 'required|date',
      'status_interaksi' => 'required|in:Open,Resolved,Follow-up',
    ]);

    $interaksi->update([
      'pelanggan_id' => $request->pelanggan_id,
      'user_id' => $request->user_id,
      'jenis_interaksi' => $request->jenis_interaksi,
      'deskripsi' => $request->deskripsi,
      'tanggal_interaksi' => $request->tanggal_interaksi,
      'status_interaksi' => $request->status_interaksi,
    ]);

    return redirect()->route('admin.interaksi.index')->with('success', 'Interaksi berhasil diperbarui!');
  }

  public function destroy(Interaksi $interaksi)
  {
    $interaksi->delete();
    return redirect()->route('admin.interaksi.index')->with('success', 'Interaksi berhasil dihapus!');
  }
}
