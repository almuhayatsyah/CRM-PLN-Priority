<?php

namespace App\Exports; // <--- PASTI ADA BARIS INI

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Pelanggan;

class PelangganExport implements FromView // <--- PASTI ADA BARIS INI
{
  private $pelanggans;

  public function __construct($pelanggans)
  {
    $this->pelanggans = $pelanggans;
  }

  public function view(): View
  {
    return view('admin.pelanggan.export_excel', [
      'pelanggans' => $this->pelanggans
    ]);
  }
}
