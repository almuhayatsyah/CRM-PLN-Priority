<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;

class JadwalKunjunganController extends Controller
{
  public function index()
  {
    $jadwal = JadwalKunjungan::all();
    return view('jadwal_kunjungan.index', compact('jadwal'));
  }
  public function create()
  {
    return view('jadwal_kunjungan.create');
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      // validasi
    ]);
    JadwalKunjungan::create($data);
    return redirect()->route('jadwal_kunjungan.index');
  }
  public function show(JadwalKunjungan $jadwal_kunjungan)
  {
    return view('jadwal_kunjungan.show', compact('jadwal_kunjungan'));
  }
  public function edit(JadwalKunjungan $jadwal_kunjungan)
  {
    return view('jadwal_kunjungan.edit', compact('jadwal_kunjungan'));
  }
  public function update(Request $request, JadwalKunjungan $jadwal_kunjungan)
  {
    $data = $request->validate([
      // validasi
    ]);
    $jadwal_kunjungan->update($data);
    return redirect()->route('jadwal_kunjungan.index');
  }
  public function destroy(JadwalKunjungan $jadwal_kunjungan)
  {
    $jadwal_kunjungan->delete();
    return redirect()->route('jadwal_kunjungan.index');
  }
}
