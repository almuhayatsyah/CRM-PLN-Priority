<?php

namespace App\Http\Controllers;

use App\Models\PemakaianDaya;
use App\Models\Pelanggan;
use App\Models\User; // Jika perlu user yang input
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;


class PemakaianDayaController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    // Admin & Staff bisa CRUD, Manajer hanya bisa melihat
    $this->middleware('role:admin|staff')->only(['create', 'store', 'edit', 'update', 'destroy']);
    $this->middleware('role:admin|manajer|staff')->only(['index', 'show']);
  }
  public function index(Request $request)
  {
    $queryPemakaianDaya = PemakaianDaya::with('pelanggan');

    // Filter berdasarkan ID pelanggan
    if ($request->filled('pelanggan_id')) {
      $queryPemakaianDaya->where('pelanggan_id', $request->pelanggan_id);
    }
    // Filter berdasarkan bulan_tahun (jika ada)
    if ($request->filled('bulan_tahun')) {
      $queryPemakaianDaya->where('bulan_tahun', $request->bulan_tahun);
    }
    // Filter berdasarkan flag_anomali
    if ($request->filled('flag_anomali')) {
      $queryPemakaianDaya->where('flag_anomali', $request->flag_anomali);
    }

    $pemakaianDayas = $queryPemakaianDaya->latest('bulan_tahun')->paginate(10);
    $allPelanggans = Pelanggan::orderBy('nama_perusahaan')->get(); // Untuk filter dropdown

    return view('admin.pemakaian-daya.index', compact('pemakaianDayas', 'allPelanggans'));
  }

  public function create()
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
    return view('admin.pemakaian-daya.create', compact('pelanggans'));
  }
  public function store(Request $request)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'bulan_tahun' => 'required|string|max:50',
      'pemakaian_Kwh' => 'required|numeric',
      'beban_anomali' => 'nullable|numeric',
      'flag_anomali' => 'required|boolean', // harus 0 atau 1
    ]);

    // Deteksi anomali sederhana: Jika beban_anomali diisi, maka flag_anomali otomatis 1
    $flag_anomali_value = $request->flag_anomali;
    if ($request->filled('beban_anomali') && $request->beban_anomali > 0) {
      $flag_anomali_value = 1;
    }


    PemakaianDaya::create([
      'pelanggan_id' => $request->pelanggan_id,
      'bulan_tahun' => $request->bulan_tahun,
      'pemakaian_Kwh' => $request->pemakaian_Kwh,
      'beban_anomali' => $request->beban_anomali,
      'flag_anomali' => $flag_anomali_value,
    ]);

    return redirect()->route('admin.pemakaian-daya.index')->with('success', 'Catatan Pemakaian Daya berhasil ditambahkan!');
  }
  public function show(PemakaianDaya $pemakaianDaya)
  {
    return view('admin.pemakaian-daya.show', compact('pemakaianDaya'));
  }
  public function edit(PemakaianDaya $pemakaianDaya)
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
    return view('admin.pemakaian-daya.edit', compact('pemakaianDaya', 'pelanggans'));
  }

  public function update(Request $request, PemakaianDaya $pemakaianDaya)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'bulan_tahun' => 'required|string|max:50',
      'pemakaian_Kwh' => 'required|numeric',
      'beban_anomali' => 'nullable|numeric',
      'flag_anomali' => 'required|boolean',
    ]);

    $flag_anomali_value = $request->flag_anomali;
    if ($request->filled('beban_anomali') && $request->beban_anomali > 0) {
      $flag_anomali_value = 1;
    }

    $pemakaianDaya->update([
      'pelanggan_id' => $request->pelanggan_id,
      'bulan_tahun' => $request->bulan_tahun,
      'pemakaian_Kwh' => $request->pemakaian_Kwh,
      'beban_anomali' => $request->beban_anomali,
      'flag_anomali' => $flag_anomali_value,
    ]);

    return redirect()->route('admin.pemakaian-daya.index')->with('success', 'Catatan Pemakaian Daya berhasil diperbarui!');
  }

  public function destroy(PemakaianDaya $pemakaianDaya)
  {
    $pemakaianDaya->delete();
    return redirect()->route('admin.pemakaian-daya.index')->with('success', 'Catatan Pemakaian Daya berhasil dihapus!');
  }
}
