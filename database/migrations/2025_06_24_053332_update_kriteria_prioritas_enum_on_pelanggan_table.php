<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum menjadi 'tegangan_tinggi' dan 'tegangan_menengah'
        DB::statement("ALTER TABLE pelanggan MODIFY kriteria_prioritas ENUM('tegangan_tinggi', 'tegangan_menengah') NULL");
    }

    public function down(): void
    {
        // Kembalikan enum ke nilai sebelumnya
        DB::statement("ALTER TABLE pelanggan MODIFY kriteria_prioritas ENUM('prioritas', 'non_prioritas') NULL");
    }
};
