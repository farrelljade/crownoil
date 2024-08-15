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
        Schema::rename('lead_source', 'lead_sources');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('lead_sources', 'lead_source');
    }
};