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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('ppl');
            $table->decimal('ppl_cost', 8, 2)->after('quantity')->nullable();
            $table->decimal('ppl_sell', 8, 2)->after('ppl_cost')->nullable();
            $table->decimal('vat', 8, 2)->after('ppl_sell')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('ppl')->after('quantity')->nullable();
            $table->dropColumn('ppl_cost');
            $table->dropColumn('ppl_sell');
            $table->dropColumn('vat');
        });
    }
};
