<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('folder_transactions', function (Blueprint $table) {
            $table->foreignId('cash_register_id')->nullable()->after('folder_id')
                ->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->after('cash_register_id')
                ->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('folder_transactions', function (Blueprint $table) {
            $table->dropForeign(['cash_register_id']);
            $table->dropColumn('cash_register_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
