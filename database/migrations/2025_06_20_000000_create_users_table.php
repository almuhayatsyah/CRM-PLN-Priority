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
    Schema::create('users', function (Blueprint $table) {
      $table->id(); // PK
      $table->string('email', 100)->unique(); // Email
      $table->string('password', 100); // Password
      $table->string('nama_lengkap', 100)->nullable(); // Nama lengkap
      $table->datetime('last_login')->nullable(); // Last login
      $table->rememberToken(); // Token untuk fitur remember me
      $table->timestamps(); // created_at & updated_at
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
