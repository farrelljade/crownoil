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
        Schema::create('user_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('calls_target')->default(0)->nullable();
            $table->integer('prospect_target')->default(0)->nullable();
            $table->integer('profit_target')->default(0)->nullable();
            $table->integer('rejuve_target')->default(0)->nullable();
            $table->integer('iho_target')->default(0)->nullable();
            $table->integer('lubricant_target')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_targets');
    }
};
