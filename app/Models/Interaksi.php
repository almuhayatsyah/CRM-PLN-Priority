<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaksi extends Model
{
  use HasFactory;

  protected $table = 'interaksi';

  protected $fillable = [
    'pelanggan_id',
    'user_id',
    'jenis_interaksi',
    'deskripsi',
    'tanggal_interaksi',
    'status_interaksi'
  ];

  public function pelanggan()
  {
    return $this->belongsTo(Pelanggan::class);
  }
  // Relasi ke Feedback
  public function feedbacks()
  {
    return $this->hasMany(Feedback::class, 'interaksi_id');
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
