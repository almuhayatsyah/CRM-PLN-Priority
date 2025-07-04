<?php

namespace App\Http\Controllers;

use App\Models\PemakaianDaya;
use Illuminate\Http\Request;

class PemakaianDayaController extends Controller
{
  public function index()
  {
    $pemakaian = PemakaianDaya::all();
    return view('pemakaian_daya.index', compact('pemakaian'));
  }
  public function create()
  {
    return view('pemakaian_daya.create');
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      // validasi
    ]);
    PemakaianDaya::create($data);
    return redirect()->route('pemakaian_daya.index');
  }
  public function show(PemakaianDaya $pemakaian_daya)
  {
    return view('pemakaian_daya.show', compact('pemakaian_daya'));
  }
  public function edit(PemakaianDaya $pemakaian_daya)
  {
    return view('pemakaian_daya.edit', compact('pemakaian_daya'));
  }
  public function update(Request $request, PemakaianDaya $pemakaian_daya)
  {
    $data = $request->validate([
      // validasi
    ]);
    $pemakaian_daya->update($data);
    return redirect()->route('pemakaian_daya.index');
  }
  public function destroy(PemakaianDaya $pemakaian_daya)
  {
    $pemakaian_daya->delete();
    return redirect()->route('pemakaian_daya.index');
  }
}
