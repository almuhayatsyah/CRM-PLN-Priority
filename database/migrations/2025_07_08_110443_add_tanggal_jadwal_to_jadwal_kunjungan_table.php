<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_kunjungan', function (Blueprint $table) {
            // Tambahkan kolom tanggal_jadwal setelah kolom user_id
            $table->dateTime('tanggal_jadwal')->after('user_id'); // Atau setelah kolom lain yang Anda inginkan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_kunjungan', function (Blueprint $table) {
            // Hapus kolom tanggal_jadwal jika di-rollback
            $table->dropColumn('tanggal_jadwal');
        });
    }
};
