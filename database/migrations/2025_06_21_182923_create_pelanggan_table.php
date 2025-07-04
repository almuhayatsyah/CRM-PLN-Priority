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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id(); // PK - Kolom 'id' dengan auto-increment dan primary key
            $table->string('id_pel', 100); // Kolom 'id_pel' dengan tipe varchar(100) 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK ke tabel 'users' 
            $table->string('kode_PLN', 100); // Kolom 'kode_PLN' dengan tipe varchar(100) 
            $table->string('nama_perusahaan', 100); // Kolom 'nama_perusahaan' dengan tipe varchar(100) 
            $table->string('nama', 50); // Kolom 'nama' dengan tipe varchar(50) 
            $table->string('kontak', 20); // Kolom 'kontak' dengan tipe varchar(20) 
            $table->decimal('kapasitas_daya', 10, 2); // Kolom 'kapasitas_daya' dengan tipe decimal(10,2) 
            $table->enum('sektor', ['industri', 'bisnis', 'rumah_tangga', 'sosial', 'pemerintah', 'lainnya'])->nullable(); // Kolom 'sektor' dengan tipe enum. Saya tambahkan 'lainnya' dan nullable sebagai opsi, bisa disesuaikan.
            $table->string('peruntukan', 100)->nullable(); // Kolom 'peruntukan' dengan tipe varchar(100) 
            $table->string('up3', 250)->nullable(); // Kolom 'up3' dengan tipe varchar(250) 
            $table->string('ulp', 250)->nullable(); // Kolom 'ulp' dengan tipe varchar(250) 
            $table->enum('kriteria_prioritas', ['prioritas', 'non_prioritas'])->nullable(); // Kolom 'kriteria_prioritas' dengan tipe enum. Saya gunakan 'prioritas' dan 'non_prioritas'.
            $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at' 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
