<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            DB::table('targets')->insert([
                ['name' => 'calls'],
                ['name' => 'prospects'],
                ['name' => 'profit'],
                ['name' => 'rejuves'],
                ['name' => 'iho'],
                ['name' => 'lubricants'],
                ['name' => 'carbon_offsets']
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            DB::table('targets')->whereIn('name', ['calls', 'prospects', 'profit', 'rejuves', 'iho', 'lubricants', 'carbon_offsets'])->delete();
        });
    }
};
