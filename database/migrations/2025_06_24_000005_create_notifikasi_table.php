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
    Schema::create('notifikasi', function (Blueprint $table) {
      $table->id(); // PK
      $table->unsignedBigInteger('user_id'); // FK ke tabel users
      $table->text('pesan'); // Pesan
      $table->tinyInteger('dibaca')->default(0); // Dibaca (0=belum, 1=sudah)
      $table->timestamp('created_at')->useCurrent(); // created_at
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at

      // Foreign key constraint
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('notifikasi');
  }
};
