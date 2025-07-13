<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::rename('customer_interactions', 'interaksi');
  }

  public function down(): void
  {
    Schema::rename('interaksi', 'customer_interactions');
  }
};
