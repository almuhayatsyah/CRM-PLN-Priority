<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;



class PelangganController extends Controller
{
  // Tampilkan semua pelanggan
  public function index()
  {
    $pelanggan = Pelanggan::all();
    return view('pelanggan.index', compact('pelanggan'));
  }

  // Tampilkan form tambah pelanggan
  public function create()
  {
  
    return redirect()->route('pelanggan.create');
  }

  // Simpan pelanggan baru
  public function store(Request $request)
  {
    $data = $request->validate([
      'id_pel' => 'required',
      'kode_PLN' => 'required',
      'nama_perusahaan' => 'required',
      'nama' => 'required',
      'kontak' => 'required',
      'kapasitas_daya' => 'required',
      'sektor' => 'required',
      'peruntukan' => 'required',
      'up3' => 'required',
      'ulp' => 'required',
      'kriteria_prioritas' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6', // jika password diinput admin
    ]);

    // 1. Buat user baru
    $user = User::create([
      'nama_lengkap' => $data['nama'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
    // Assign role pelanggan jika pakai spatie/role
    // $user->assignRole('pelanggan');

    // 2. Buat data pelanggan, hubungkan ke user baru
    $data['user_id'] = $user->id;
    Pelanggan::create($data);

    return redirect()->route('pelanggan.index')->with('success', 'Pelanggan & user berhasil ditambahkan!');
  }

  // Tampilkan detail pelanggan
  public function show(Pelanggan $pelanggan)
  {
    return view('pelanggan.show', compact('pelanggan'));
  }

  // Tampilkan form edit pelanggan
  public function edit(Pelanggan $pelanggan)
  {
    return view('pelanggan.edit', compact('pelanggan'));
  }

  // Update data pelanggan
  public function update(Request $request, Pelanggan $pelanggan)
  {
    $data = $request->validate([
      // Tambahkan validasi sesuai kebutuhan
    ]);
    $pelanggan->update($data);
    return redirect()->route('pelanggan.index');
  }

  // Hapus pelanggan
  public function destroy(Pelanggan $pelanggan)
  {
    $pelanggan->delete();
    return redirect()->route('pelanggan.index');
  }

  // Import pelanggan dari file CSV

  public function import(Request $request)
  {

    return redirect()->route('admin.pelanggan.index')->with('success', 'Import data pelanggan berhasil!');
  }
}
