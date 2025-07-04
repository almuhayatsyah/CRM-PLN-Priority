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
    Schema::create('jadwal_kunjungan', function (Blueprint $table) {
      $table->id(); // PK
      $table->unsignedBigInteger('pelanggan_id'); // FK ke tabel pelanggan
      $table->unsignedBigInteger('user_id'); // FK ke tabel users
      $table->text('tujuan'); // Tujuan
      $table->text('hasil')->nullable(); // Hasil
      $table->enum('status', ['dijadwalkan', 'selesai', 'batal'])->default('dijadwalkan'); // Status kunjungan
      $table->timestamp('created_at')->useCurrent(); // created_at
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at

      // Foreign key constraints
      $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('jadwal_kunjungan');
  }
};
