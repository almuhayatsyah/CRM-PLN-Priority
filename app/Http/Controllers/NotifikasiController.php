<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
  public function index()
  {
    $notifikasi = Notifikasi::all();
    return view('notifikasi.index', compact('notifikasi'));
  }
  public function create()
  {
    return view('notifikasi.create');
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      // validasi
    ]);
    Notifikasi::create($data);
    return redirect()->route('notifikasi.index');
  }
  public function show(Notifikasi $notifikasi)
  {
    return view('notifikasi.show', compact('notifikasi'));
  }
  public function edit(Notifikasi $notifikasi)
  {
    return view('notifikasi.edit', compact('notifikasi'));
  }
  public function update(Request $request, Notifikasi $notifikasi)
  {
    $data = $request->validate([
      // validasi
    ]);
    $notifikasi->update($data);
    return redirect()->route('notifikasi.index');
  }
  public function destroy(Notifikasi $notifikasi)
  {
    $notifikasi->delete();
    return redirect()->route('notifikasi.index');
  }
}
