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
        Schema::table('feedback', function (Blueprint $table) {
            // Menambahkan hanya kolom updated_at setelah created_at
            // Jika kolom created_at sudah ada, kita tambahkan updated_at setelahnya.
            // Jika created_at belum ada, ini akan menempatkannya di akhir tabel.
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            // Menghapus kolom updated_at jika di-rollback
            $table->dropColumn('updated_at');
        });
    }
};
