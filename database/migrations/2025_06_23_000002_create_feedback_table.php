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
    Schema::create('feedback', function (Blueprint $table) {
      $table->id(); // PK
      $table->unsignedBigInteger('pelanggan_id'); // FK ke tabel pelanggan
      $table->unsignedBigInteger('interaksi_id'); // FK ke tabel interaksi
      $table->tinyInteger('skor'); // skor (Tinyint)
      $table->text('komentar')->nullable(); // komentar (Text)
      $table->timestamp('created_at')->useCurrent(); // created_at (Timestamp)

      // Foreign key constraints
      $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
      $table->foreign('interaksi_id')->references('id')->on('interaksi')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('feedback');
  }
};
