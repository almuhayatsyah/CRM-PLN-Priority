<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pelanggan;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use App\Http\Controllers\Controller;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // Tampilkan daftar pelanggan
    public function index()
    {
        $pelanggan = Pelanggan::paginate(10);
        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    // Form tambah pelanggan
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    // Simpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'id_pel' => 'required|string|max:100',
            'kode_PLN' => 'required|string|max:100',
            'nama_perusahaan' => 'required|string|max:100',
            'nama' => 'required|string|max:50',
            'kontak' => 'nullable|string|max:20',
            'kapasitas_daya' => 'nullable|numeric',
            'sektor' => 'nullable|string|max:50',
            'peruntukan' => 'nullable|string|max:100',
            'up3' => 'nullable|string|max:250',
            'ulp' => 'nullable|string|max:250',
            'kriteria_prioritas' => 'nullable|string|max:50',
        ]);
        Pelanggan::create($request->all());
        return Redirect::route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // Form edit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    // Update pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $request->validate([
            'id_pel' => 'required|string|max:100',
            'kode_PLN' => 'required|string|max:100',
            'nama_perusahaan' => 'required|string|max:100',
            'nama' => 'required|string|max:50',
            'kontak' => 'nullable|string|max:20',
            'kapasitas_daya' => 'nullable|numeric',
            'sektor' => 'nullable|string|max:50',
            'peruntukan' => 'nullable|string|max:100',
            'up3' => 'nullable|string|max:250',
            'ulp' => 'nullable|string|max:250',
            'kriteria_prioritas' => 'nullable|string|max:50',
        ]);
        $pelanggan->update($request->all());
        return Redirect::route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil diupdate.');
    }

    // Hapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return Redirect::route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
