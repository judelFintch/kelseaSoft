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
        Schema::table('folders', function (Blueprint $table) {
            $table->decimal('freight_amount', 15, 2)->nullable()->after('insurance_amount');
            $table->foreignId('currency_id')->nullable()->after('freight_amount')
                ->constrained('currencies')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropColumn(['freight_amount', 'currency_id']);
        });
    }
};
