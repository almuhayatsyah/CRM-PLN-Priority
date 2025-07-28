<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi; // Pastikan ini diimport
use App\Models\User; // Untuk filter dropdown jika ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class NotifikasiController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('role:admin')->only(['update', 'destroy']);
    $this->middleware('role:admin|manajer|staff')->only(['index', 'show']);
  }

  /**
   * Menampilkan daftar semua notifikasi.
   */
  public function index(Request $request)
  {
    $queryNotifikasi = Notifikasi::query()->with('user');

    // Filter notifikasi berdasarkan user yang sedang login jika bukan admin
    if (Auth::user()->hasRole('staff') || Auth::user()->hasRole('manajer') || Auth::user()->hasRole('pelanggan')) {
      $queryNotifikasi->where('user_id', Auth::id());
    }

    // Filter berdasarkan status dibaca
    if ($request->filled('status_dibaca')) {
      $queryNotifikasi->where('dibaca', $request->status_dibaca);
    }
    // Filter berdasarkan user penerima (hanya untuk Admin)
    if (Auth::user()->hasRole('admin') && $request->filled('user_id')) {
      $queryNotifikasi->where('user_id', $request->user_id);
    }

    $notifikasis = $queryNotifikasi->latest()->paginate(10);

    // Ambil semua user untuk filter admin
    $allUsers = Auth::user()->hasRole('admin') ? User::all() : collect();

    return view('admin.notifikasi.index', compact('notifikasis', 'allUsers'));
  }

  /**
   * Tidak ada method create() dan store() karena notifikasi biasanya digenerate sistem.
   */

  /**
   * Menampilkan detail notifikasi.
   */
  public function show(Notifikasi $notifikasi)
  {
    // Pastikan hanya user yang bersangkutan atau admin yang bisa melihat
    if (Auth::user()->id !== $notifikasi->user_id && !Auth::user()->hasRole('admin')) {
      abort(403, 'Anda tidak memiliki akses untuk melihat notifikasi ini.');
    }

    // Tandai sebagai sudah dibaca saat dilihat
    if (!$notifikasi->dibaca) {
      $notifikasi->update(['dibaca' => true]);
    }
    return view('admin.notifikasi.show', compact('notifikasi'));
  }

  /**
   * Update status notifikasi (misal: menandai dibaca/belum dibaca).
   */
  public function update(Request $request, Notifikasi $notifikasi)
  {
    // Hanya Admin yang bisa mengupdate status
    $this->authorize('update', $notifikasi); // Menggunakan Gates/Policies jika ada, atau cek role di sini

    $request->validate([
      'dibaca' => 'required|boolean',
    ]);

    $notifikasi->update(['dibaca' => $request->dibaca]);
    return redirect()->route('admin.notifikasi.index')->with('success', 'Status notifikasi berhasil diperbarui!');
  }

  /**
   * Menghapus notifikasi.
   */
  public function destroy(Notifikasi $notifikasi)
  {
    // Hanya Admin yang bisa menghapus
    $this->authorize('delete', $notifikasi); // Menggunakan Gates/Policies jika ada, atau cek role di sini

    $notifikasi->delete();
    return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi berhasil dihapus!');
  }
}
