<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKunjungan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kunjungan'; // Pastikan nama tabel di database

    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'tanggal_jadwal',
        'tujuan',
        'hasil',
        'status', // Pastikan kolom ini di tabel
    ];

    // Relasi: Jadwal Kunjungan dimiliki oleh satu Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi: Jadwal Kunjungan dilakukan oleh satu User (Staff/Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
