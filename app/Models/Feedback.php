<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'pelanggan_id',
        'interaksi_id',
        'skor',
        'komentar',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function interaksi()
    {
        return $this->belongsTo(Interaksi::class);
    }
}
