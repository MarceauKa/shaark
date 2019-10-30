<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'cloud' => env('FILESYSTEM_CLOUD', 's3'),
    // Supported Drivers: "local", "ftp", "sftp", "s3"
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'archives' => [
            'driver' => 'local',
            'root' => storage_path('app/archives'),
            'visibility' => 'private',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'backup' => [
            'driver' => env('BACKUP_DRIVER', 'local'),
            'root' => env('BACKUP_DRIVER', 'local') === 'local' ? storage_path('app/backup') : '',
            'host' => env('BACKUP_HOST', null),
            'port' => env('BACKUP_PORT', 21),
            'username' => env('BACKUP_USERNAME', null),
            'password' => env('BACKUP_PASSWORD', null),
            'timeout' => env('BACKUP_TIMEOUT', 60),
            'ssl' => env('BACKUP_SSL', true),
            'visibility' => 'private'
        ],
    ],
];
