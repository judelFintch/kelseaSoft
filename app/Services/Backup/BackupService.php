<?php

namespace App\Services\Backup;

use Exception;
use Illuminate\Support\Str;

class BackupService
{
    public function backup(): string
    {
        $connection = config('database.default');
        $db = config("database.connections.$connection");

        $timestamp = now()->format('Ymd_His');
        $fileName = "backup_{$timestamp}.sql";
        $path = storage_path('app/backups/' . $fileName);

        if ($db['driver'] === 'mysql') {
            $command = sprintf(
                'mysqldump -h %s -u %s -p"%s" %s > %s',
                $db['host'],
                $db['username'],
                $db['password'],
                $db['database'],
                $path
            );
        } elseif ($db['driver'] === 'pgsql') {
            $command = sprintf(
                'PGPASSWORD="%s" pg_dump -h %s -U %s %s > %s',
                $db['password'],
                $db['host'],
                $db['username'],
                $db['database'],
                $path
            );
        } else {
            throw new Exception('Unsupported database driver for backup.');
        }

        system($command);

        return $fileName;
    }

    public function restore(string $file): void
    {
        $connection = config('database.default');
        $db = config("database.connections.$connection");
        $path = storage_path('app/backups/' . $file);

        if (!file_exists($path)) {
            throw new Exception('Backup file not found.');
        }

        if ($db['driver'] === 'mysql') {
            $command = sprintf(
                'mysql -h %s -u %s -p"%s" %s < %s',
                $db['host'],
                $db['username'],
                $db['password'],
                $db['database'],
                $path
            );
        } elseif ($db['driver'] === 'pgsql') {
            $command = sprintf(
                'PGPASSWORD="%s" psql -h %s -U %s %s < %s',
                $db['password'],
                $db['host'],
                $db['username'],
                $db['database'],
                $path
            );
        } else {
            throw new Exception('Unsupported database driver for restore.');
        }

        system($command);
    }
}
