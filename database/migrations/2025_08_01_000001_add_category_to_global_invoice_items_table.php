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
        Schema::table('global_invoice_items', function (Blueprint $table) {
            if (!Schema::hasColumn('global_invoice_items', 'category')) {
                $table->enum('category', ['import_tax', 'agency_fee', 'extra_fee'])
                    ->default('import_tax')
                    ->after('global_invoice_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_invoice_items', function (Blueprint $table) {
            if (Schema::hasColumn('global_invoice_items', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
