<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemakaianDaya extends Model
{
    protected $table = 'pemakaian_daya';
    protected $fillable = [
        'pelanggan_id',
        'bulan_tahun',
        'pemakaian_kwh',
        'beban_anomali',
        'flag_anomali',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
