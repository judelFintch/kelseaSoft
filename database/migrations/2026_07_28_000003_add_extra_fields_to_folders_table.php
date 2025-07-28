<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->string('scelle_number')->nullable();
            $table->string('manifest_number')->nullable();
            $table->string('incoterm')->nullable();
            $table->string('customs_regime')->nullable();
            $table->string('additional_code')->nullable();
            $table->date('quotation_date')->nullable();
            $table->date('opening_date')->nullable();
            $table->string('entry_point')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->dropColumn([
                'scelle_number',
                'manifest_number',
                'incoterm',
                'customs_regime',
                'additional_code',
                'quotation_date',
                'opening_date',
                'entry_point',
            ]);
        });
    }
};
