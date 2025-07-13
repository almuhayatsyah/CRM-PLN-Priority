<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback'; // Pastikan nama tabel di database

    protected $fillable = [
        'pelanggan_id',
        'interaksi_id', // Jika feedback terhubung ke interaksi tertentu (opsional)
        'skor',         // Misalnya 1-5
        'komentar',
        'status',       // Misal: 'Baru', 'Sedang Ditangani', 'Selesai' (ini akan kita tambahkan)
        
    ];

    // Relasi: Feedback dimiliki oleh satu Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi: Feedback terhubung ke Interaksi (jika ada, opsional)
    public function interaksi()
    {
        return $this->belongsTo(Interaksi::class);
    }

    // Relasi: User (admin/staff) yang mungkin menindaklanjuti feedback (opsional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
