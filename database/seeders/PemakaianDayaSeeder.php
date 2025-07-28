<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemakaianDaya;
use App\Models\Pelanggan;

class PemakaianDayaSeeder extends Seeder
{
  public function run()
  {
    // Ambil pelanggan pertama
    $pelanggan = Pelanggan::first();

    if (!$pelanggan) {
      return;
    }

    // Data dummy untuk tahun 2025
    $dataDummy = [
      ['bulan_tahun' => '2025-01', 'pemakaian_Kwh' => 1500.50, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-02', 'pemakaian_Kwh' => 1800.25, 'beban_anomali' => 150.00, 'flag_anomali' => 1],
      ['bulan_tahun' => '2025-03', 'pemakaian_Kwh' => 2200.75, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-04', 'pemakaian_Kwh' => 1900.00, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-05', 'pemakaian_Kwh' => 2400.30, 'beban_anomali' => 200.00, 'flag_anomali' => 1],
      ['bulan_tahun' => '2025-06', 'pemakaian_Kwh' => 2100.80, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-07', 'pemakaian_Kwh' => 2800.45, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-08', 'pemakaian_Kwh' => 2600.20, 'beban_anomali' => 180.00, 'flag_anomali' => 1],
      ['bulan_tahun' => '2025-09', 'pemakaian_Kwh' => 2300.90, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-10', 'pemakaian_Kwh' => 2000.15, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-11', 'pemakaian_Kwh' => 1700.60, 'beban_anomali' => null, 'flag_anomali' => 0],
      ['bulan_tahun' => '2025-12', 'pemakaian_Kwh' => 1600.40, 'beban_anomali' => null, 'flag_anomali' => 0],
    ];

    foreach ($dataDummy as $data) {
      PemakaianDaya::updateOrCreate(
        [
          'pelanggan_id' => $pelanggan->id,
          'bulan_tahun' => $data['bulan_tahun']
        ],
        [
          'pemakaian_Kwh' => $data['pemakaian_Kwh'],
          'beban_anomali' => $data['beban_anomali'],
          'flag_anomali' => $data['flag_anomali']
        ]
      );
    }
  }
}
