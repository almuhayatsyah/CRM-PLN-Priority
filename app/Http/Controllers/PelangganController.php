<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PelangganExport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'export', 'show', 'destroy']);
        $this->middleware('role:admin|manajer|staff')->only(['index', 'show']);
    }

    // Tampilkan semua pelanggan
    public function index()
    {
        $pelanggan = Pelanggan::paginate(10); // atau jumlah per halaman yang kamu inginkan

        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    // Tampilkan form tambah pelanggan
    public function create()
    {
        return view('admin.pelanggan.create');
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
            'profile_photo' => 'nullable|image|max:2048',

            // Khusus untuk user
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Buat user baru
        $user = User::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        // Assign role pelanggan secara otomatis
        $user->assignRole('pelanggan');

        $pelangganData = $data;
        unset($pelangganData['nama_lengkap'], $pelangganData['email'], $pelangganData['password']);
        $pelangganData['user_id'] = $user->id;


        Pelanggan::create($pelangganData);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan & user berhasil ditambahkan!');
    }

    // Tampilkan detail pelanggan
    public function show(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.detail', compact('pelanggan'));
    }

    // Tampilkan form edit pelanggan
    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    // Update data pelanggan
    public function update(Request $request, Pelanggan $pelanggan)
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
        ]);
        $pelanggan->update($data);
        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil diupdate!');
    }

    // Hapus pelanggan
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('admin.pelanggan.index');
    }

    // Import pelanggan dari file CSV

    public function import(Request $request)
    {

        return redirect()->route('admin.pelanggan.index')->with('success', 'Import data pelanggan berhasil!');
    }

    public function exportPdf(): Response
    {
        // Ambil data pelanggan yang akan diekspor
        $data = Pelanggan::with('user')->get(); // <--- Pastikan nama variabelnya $data

        // Load view dan download PDF, melewatkan data sebagai 'data'
        $pdf = Pdf::loadView('admin.pelanggan.export_pdf', compact('data')); // <--- Pastikan compact('data')
        return $pdf->download('daftar_pelanggan.pdf');
    }

    // Export Excel
    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse // Tipe return yang benar
    {
        $pelanggans = \App\Models\Pelanggan::with('user')->get(); // Ambil data pelanggan yang akan diekspor

        // Menggunakan Export Class untuk mengunduh file Excel
        return Excel::download(new PelangganExport($pelanggans), 'data_pelanggan.xlsx');
    }
}
