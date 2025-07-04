<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKunjungan extends Model
{
    protected $table = 'jadwal_kunjungan';
    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'tujuan',
        'hasil',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
