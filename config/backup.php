<?php

return [
    'path' => env('BACKUP_PATH', storage_path('app/backups')),
    'compress' => env('BACKUP_COMPRESS', false),
];
