<?php

namespace App\Http\Controllers;

use App\Models\Interaksi;
use Illuminate\Http\Request;

class InteraksiController extends Controller
{
  public function index()
  {
    $interaksi = Interaksi::all();
    return view('interaksi.index', compact('interaksi'));
  }
  public function create()
  {
    return view('interaksi.create');
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      // validasi
    ]);
    Interaksi::create($data);
    return redirect()->route('interaksi.index');
  }
  public function show(Interaksi $interaksi)
  {
    return view('interaksi.show', compact('interaksi'));
  }
  public function edit(Interaksi $interaksi)
  {
    return view('interaksi.edit', compact('interaksi'));
  }
  public function update(Request $request, Interaksi $interaksi)
  {
    $data = $request->validate([
      // validasi
    ]);
    $interaksi->update($data);
    return redirect()->route('interaksi.index');
  }
  public function destroy(Interaksi $interaksi)
  {
    $interaksi->delete();
    return redirect()->route('interaksi.index');
  }
}
