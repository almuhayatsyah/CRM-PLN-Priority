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
        ('interaksi');
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('interaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->string('bulan_tahun', 50);
            $table->decimal('pemakaian_kwh', 12, 2);
            $table->decimal('beban_anomali', 10, 2)->nullable();
            $table->tinyInteger('flag_anomali')->default(0); // Assuming 0 for normal, 1 for anomaly
            $table->timestamps();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
        //
    }
};
