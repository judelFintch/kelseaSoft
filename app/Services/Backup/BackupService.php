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

        $dir = config('backup.path');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if ($db['driver'] === 'mysql') {
            $fileName .= '.sql';
            $path = $dir . DIRECTORY_SEPARATOR . $fileName;
            $command = sprintf(
                'mysqldump -h %s -u %s -p"%s" %s > %s',
                $db['host'],
                $db['username'],
                $db['password'],
                $db['database'],
                $path
            );
            system($command);
        } elseif ($db['driver'] === 'pgsql') {
            $fileName .= '.sql';
            $path = $dir . DIRECTORY_SEPARATOR . $fileName;
            $command = sprintf(
                'PGPASSWORD="%s" pg_dump -h %s -U %s %s > %s',
                $db['password'],
                $db['host'],
                $db['username'],
                $db['database'],
                $path
            );
            system($command);
        } elseif ($db['driver'] === 'sqlite') {
            $fileName .= '.sqlite';
            $path = $dir . DIRECTORY_SEPARATOR . $fileName;
            if (!file_exists($db['database'])) {
                throw new Exception('SQLite database file not found.');
            }
            if (!copy($db['database'], $path)) {
                throw new Exception('Failed to copy SQLite database.');
            }
        } else {
            throw new Exception('Unsupported database driver for backup.');
        }

        if (config('backup.compress')) {
            $compressed = $path . '.gz';
            $fp = fopen($path, 'rb');
            $gz = gzopen($compressed, 'wb9');
            while (!feof($fp)) {
                gzwrite($gz, fread($fp, 1024 * 512));
            }
            fclose($fp);
            gzclose($gz);
            unlink($path);
            $fileName .= '.gz';
        }

        return $fileName;
    }

    public function restore(string $file): void
    {
        $connection = config('database.default');
        $db = config("database.connections.$connection");
        $dir = config('backup.path');
        $path = $dir . DIRECTORY_SEPARATOR . $file;

        if (!file_exists($path)) {
            throw new Exception('Backup file not found.');
        }

        $isCompressed = Str::endsWith($file, '.gz');
        if ($isCompressed) {
            $tempPath = substr($path, 0, -3);
            $gz = gzopen($path, 'rb');
            $out = fopen($tempPath, 'wb');
            while (!gzeof($gz)) {
                fwrite($out, gzread($gz, 1024 * 512));
            }
            fclose($out);
            gzclose($gz);
        } else {
            $tempPath = $path;
        }

        if ($db['driver'] === 'mysql') {
            $command = sprintf(
                'mysql -h %s -u %s -p"%s" %s < %s',
                $db['host'],
                $db['username'],
                $db['password'],
                $db['database'],
                $tempPath
            );
        } elseif ($db['driver'] === 'pgsql') {
            $command = sprintf(
                'PGPASSWORD="%s" psql -h %s -U %s %s < %s',
                $db['password'],
                $db['host'],
                $db['username'],
                $db['database'],
                $tempPath
            );
        } elseif ($db['driver'] === 'sqlite') {
            if (!copy($tempPath, $db['database'])) {
                throw new Exception('Failed to restore SQLite database.');
            }
            if ($isCompressed) {
                unlink($tempPath);
            }
            return;
        } else {
            throw new Exception('Unsupported database driver for restore.');
        }

        system($command);

        if ($isCompressed) {
            unlink($tempPath);
        }
    }
}
