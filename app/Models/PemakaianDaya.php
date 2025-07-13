<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianDaya extends Model
{
    use HasFactory;

    protected $table = 'pemakaian_daya'; // Pastikan nama tabel di database

    protected $fillable = [
        'pelanggan_id',
        'bulan_tahun',
        'pemakaian_Kwh',
        'beban_anomali',
        'flag_anomali',
    ];

    // Relasi: Pemakaian Daya dimiliki oleh satu Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Jika ada user yang menginput (opsional, tergantung desain Anda)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
