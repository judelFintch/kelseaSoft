<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Services\Backup\BackupService;

Artisan::command('database:backup', function () {
    $service = new BackupService();
    $file = $service->backup();
    $this->info('Backup saved to storage/app/backups/' . $file);
})->purpose('Create a database backup');

Artisan::command('database:restore {file}', function (string $file) {
    $service = new BackupService();
    try {
        $service->restore($file);
        $this->info('Database restored from ' . $file);
    } catch (\Exception $e) {
        $this->error($e->getMessage());
    }
})->purpose('Restore database from a backup');

