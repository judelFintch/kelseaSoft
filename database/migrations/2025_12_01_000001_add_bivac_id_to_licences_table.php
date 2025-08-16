<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('licences', function (Blueprint $table) {
            $table->foreignId('bivac_id')->nullable()->after('supplier_id')->constrained('bivacs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('licences', function (Blueprint $table) {
            $table->dropForeign(['bivac_id']);
            $table->dropColumn('bivac_id');
        });
    }
};
