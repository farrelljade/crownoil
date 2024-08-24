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
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn([
                'payload',
                'attempts',
                'reserved_at',
                'available_at',
                'created_at',
            ]);

            $table->unsignedBigInteger('prospect_id');
            $table->string('site_name');
            $table->string('opening_hours')->nullable();
            $table->string('po_number')->nullable();
            $table->string('invoice_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
};
