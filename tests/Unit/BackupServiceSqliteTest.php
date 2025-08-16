<?php

namespace Tests\Unit;

use App\Services\Backup\BackupService;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class BackupServiceSqliteTest extends TestCase
{
    public function test_backup_and_restore_with_sqlite(): void
    {
        $original = storage_path('app/backups/test_db.sqlite');
        if (!is_dir(dirname($original))) {
            mkdir(dirname($original), 0777, true);
        }
        file_put_contents($original, 'initial');

        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite.database', $original);
        Config::set('backup.compress', true);

        $service = new BackupService();
        $backupFile = $service->backup();
        $backupPath = config('backup.path') . DIRECTORY_SEPARATOR . $backupFile;

        $this->assertTrue(str_ends_with($backupFile, '.sqlite.gz'));
        $this->assertFileExists($backupPath);

        file_put_contents($original, 'changed');
        $service->restore($backupFile);

        $this->assertStringEqualsFile($original, 'initial');

        unlink($backupPath);
        unlink($original);
    }
}
