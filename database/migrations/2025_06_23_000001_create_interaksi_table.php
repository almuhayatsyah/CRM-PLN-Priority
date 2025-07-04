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
    Schema::create('interaksi', function (Blueprint $table) {
      $table->id(); // PK
      $table->unsignedBigInteger('pelanggan_id'); // FK ke tabel pelanggan
      $table->string('bulan_tahun', 50); // Bulan_tahun
      $table->decimal('pemakaian_kwh', 12, 2); // Pemakaian_Kwh
      $table->decimal('beban_anomali', 10, 2)->nullable(); // Beban_anomali
      $table->tinyInteger('flag_anomali')->default(0); // Flag_anomali
      $table->timestamp('created_at')->useCurrent(); // created_at
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at

      // Foreign key constraint
      $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('interaksi');
  }
};
