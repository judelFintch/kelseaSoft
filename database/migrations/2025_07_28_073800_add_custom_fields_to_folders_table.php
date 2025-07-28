<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->string('scelle_number')->nullable()->after('company_id');
            $table->string('manifest_number')->nullable()->after('scelle_number');
            $table->string('incoterm')->nullable()->after('manifest_number');
            $table->string('customs_regime')->nullable()->after('incoterm');
            $table->string('additional_code')->nullable()->after('customs_regime');
            $table->date('quotation_date')->nullable()->after('additional_code');
            $table->date('opening_date')->nullable()->after('quotation_date');
            $table->string('entry_point')->nullable()->after('opening_date');
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
