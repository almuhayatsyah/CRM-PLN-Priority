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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan jalur foto profil
            // String untuk path file, nullable karena foto bisa opsional
            $table->string('profile_photo_path', 2048)->nullable()->after('password'); // Setelah kolom password
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom profile_photo_path jika di-rollback
            $table->dropColumn('profile_photo_path');
        });
    }
};
