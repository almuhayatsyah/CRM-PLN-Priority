<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
  public function index()
  {
    $feedback = Feedback::all();
    return view('feedback.index', compact('feedback'));
  }
  public function create()
  {
    return view('feedback.create');
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      // validasi
    ]);
    Feedback::create($data);
    return redirect()->route('feedback.index');
  }
  public function show(Feedback $feedback)
  {
    return view('feedback.show', compact('feedback'));
  }
  public function edit(Feedback $feedback)
  {
    return view('feedback.edit', compact('feedback'));
  }
  public function update(Request $request, Feedback $feedback)
  {
    $data = $request->validate([
      // validasi
    ]);
    $feedback->update($data);
    return redirect()->route('feedback.index');
  }
  public function destroy(Feedback $feedback)
  {
    $feedback->delete();
    return redirect()->route('feedback.index');
  }
}
