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
        $fileName = "backup_{$timestamp}";

        if ($db['driver'] === 'mysql') {
            $fileName .= '.sql';
            $path = storage_path('app/backups/' . $fileName);
            $command = sprintf(
                'mysqldump -h %s -u %s -p"%s" %s > %s',
                $db['host'],
                $db['username'],
                $db['password'],
                $db['database'],
                $path
            );
        } elseif ($db['driver'] === 'pgsql') {
            $fileName .= '.sql';
            $path = storage_path('app/backups/' . $fileName);
            $command = sprintf(
                'PGPASSWORD="%s" pg_dump -h %s -U %s %s > %s',
                $db['password'],
                $db['host'],
                $db['username'],
                $db['database'],
                $path
            );
        } elseif ($db['driver'] === 'sqlite') {
            $fileName .= '.sqlite';
            $path = storage_path('app/backups/' . $fileName);
            if (!file_exists($db['database'])) {
                throw new Exception('SQLite database file not found.');
            }
            if (!copy($db['database'], $path)) {
                throw new Exception('Failed to copy SQLite database.');
            }
            return $fileName;
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
        } elseif ($db['driver'] === 'sqlite') {
            if (!copy($path, $db['database'])) {
                throw new Exception('Failed to restore SQLite database.');
            }
            return;
        } else {
            throw new Exception('Unsupported database driver for restore.');
        }

        system($command);
    }
}
