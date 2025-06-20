<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_invoices', function (Blueprint $table) {
            $table->string('product')->nullable()->after('company_id');
        });
    }

    public function down(): void
    {
        Schema::table('global_invoices', function (Blueprint $table) {
            $table->dropColumn('product');
        });
    }
};
