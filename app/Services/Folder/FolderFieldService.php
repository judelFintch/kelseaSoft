<?php

namespace App\Services\Folder;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FolderFieldService
{
    /**
     * Ensure a column exists on the folders table.
     */
    public static function ensureFieldExists(string $field): void
    {
        if (!Schema::hasColumn('folders', $field)) {
            Schema::table('folders', function (Blueprint $table) use ($field) {
                $table->string($field)->nullable();
            });
        }
    }
}
