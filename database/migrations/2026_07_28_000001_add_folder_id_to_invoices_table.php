<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'folder_id')) {
                $table->foreignId('folder_id')->nullable()->after('id')->constrained('folders')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'folder_id')) {
                $table->dropForeign(['folder_id']);
                $table->dropColumn('folder_id');
            }
        });
    }
};
