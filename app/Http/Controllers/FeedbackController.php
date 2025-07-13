<?php

namespace App\Http\Controllers; // Pastikan namespace-nya App\Http\Controllers

use App\Models\Feedback;
use App\Models\Pelanggan; // Untuk dropdown pelanggan
use App\Models\User;     // Untuk user yang mungkin menindaklanjuti
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class FeedbackController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('role:admin|staff')->only(['create', 'store', 'edit', 'update', 'destroy']);
    $this->middleware('role:admin|manajer|staff')->only(['index', 'show']);
  }

  public function index(Request $request)
  {
    $queryFeedback = Feedback::with('pelanggan');

    // Filter berdasarkan ID pelanggan
    if ($request->filled('pelanggan_id')) {
      $queryFeedback->where('pelanggan_id', $request->pelanggan_id);
    }
    // Filter berdasarkan skor (misal: min skor)
    if ($request->filled('skor')) {
      $queryFeedback->where('skor', $request->skor);
    }
    // Filter berdasarkan status
    if ($request->filled('status_feedback')) { // Sesuaikan nama parameter request
      $queryFeedback->where('status', $request->status_feedback);
    }

    $feedbacks = $queryFeedback->latest()->paginate(10);
    $allPelanggans = Pelanggan::orderBy('nama_perusahaan')->get(); // Untuk filter dropdown

    return view('admin.feedback.index', compact('feedbacks', 'allPelanggans'));
  }
  public function create()
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get();
    return view('admin.feedback.create', compact('pelanggans'));
  }
  public function store(Request $request)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'skor' => 'required|integer|min:1|max:5', // Validasi skor 1-5
      'komentar' => 'required|string',
      'status' => 'required|in:Baru,Sedang Ditangani,Selesai', // Validasi status
    ]);

    Feedback::create([
      'pelanggan_id' => $request->pelanggan_id,
      'skor' => $request->skor,
      'komentar' => $request->komentar,
      'status' => $request->status,
      // 'user_id' => Auth::id(), // Jika ada kolom user_id yang mencatat siapa yang input
    ]);

    return redirect()->route('admin.feedback.index')->with('success', 'Feedback berhasil ditambahkan!');
  }
  public function show(Feedback $feedback)
  {
    return view('admin.feedback.show', compact('feedback'));
  }
  public function edit(Feedback $feedback)
  {
    $pelanggans = Pelanggan::orderBy('nama_perusahaan')->get(); // Mungkin tidak perlu, tapi jika formnya sama
    return view('admin.feedback.edit', compact('feedback', 'pelanggans'));
  }
  public function update(Request $request, Feedback $feedback)
  {
    $request->validate([
      'pelanggan_id' => 'required|exists:pelanggan,id',
      'skor' => 'required|integer|min:1|max:5',
      'komentar' => 'required|string',
      'status' => 'required|in:Baru,Sedang Ditangani,Selesai',
    ]);

    $feedback->update([
      'pelanggan_id' => $request->pelanggan_id,
      'skor' => $request->skor,
      'komentar' => $request->komentar,
      'status' => $request->status,
    ]);

    return redirect()->route('admin.feedback.index')->with('success', 'Feedback berhasil diperbarui!');
  }
  public function destroy(Feedback $feedback)
  {
    $feedback->delete();
    return redirect()->route('admin.feedback.index')->with('success', 'Feedback berhasil dihapus!');
  }
}
