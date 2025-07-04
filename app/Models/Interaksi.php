<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaksi extends Model
{
    protected $table = 'interaksi';

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

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
