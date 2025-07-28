<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $fillable = [
        'id_pel',
        'kode_PLN',
        'nama_perusahaan',
        'nama',
        'kontak',
        'kapasitas_daya',
        'sektor',
        'peruntukan',
        'up3',
        'ulp',
        'kriteria_prioritas',
        'user_id',
        'profile_photo_path'
    ];

    // ENUM options for sektor
    public const SEKTOR_OPTIONS = [
        'industri',
        'bisnis',
        'rumah_tangga',
        'sosial',
        'pemerintah',
        'lainnya',
    ];

    // ENUM options for kriteria_prioritas
    public const KRITERIA_PRIORITAS_OPTIONS = [
        'tegangan_tinggi',
        'tegangan_menengah',
    ];

    // ENUM options for up3
    public const UP3_OPTIONS = [
        'UP3 Banda Aceh',
        'UP3 Lhokseumawe',
        'UP3 Meulaboh',
        'UP3 Sigli',
        'UP3 Langsa',
        'UP3 Subullusalam'
    ];

    // ENUM options for ulp


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalKunjungan()
    {
        return $this->hasMany(JadwalKunjungan::class);
    }

    public function interaksi()
    {
        return $this->hasMany(Interaksi::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function pemakaianDaya()
    {
        return $this->hasMany(PemakaianDaya::class);
    }
}
