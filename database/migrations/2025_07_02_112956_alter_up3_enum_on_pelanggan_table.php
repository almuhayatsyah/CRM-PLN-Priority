<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement("ALTER TABLE pelanggan MODIFY up3 ENUM( 'UP3 Banda Aceh',
        'UP3 Lhokseumawe',
        'UP3 Meulaboh',
        'UP3 Sigli',
        'UP3 Langsa',
        'UP3 Subullusalam') NULL");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement("ALTER TABLE pelanggan MODIFY up3 VARCHAR(250) NULL");
    }
};
