<?php

namespace App\Http\Controllers; // Pastikan namespacenya App\Http\Controllers

use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Pastikan ini diimport

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman landing page.
     */
    public function index()
    {
        return view('landing'); // Mengembalikan view 'resources/views/landing.blade.php'
    }
}
