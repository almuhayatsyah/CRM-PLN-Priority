<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('status', 50)->default('Baru')->change(); // GUNAKAN .change()
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->enum('status', ['baru', 'sedang ditangani', 'selesai'])->default('baru')->change();
        });
    }
};
