<?php

return [
    // Hashids configuration
    'hashids' => [
        'salt' => env('HASHIDS_SALT', 'default-salt'),
        'min' => env('HASHIDS_MIN_LENGTH', 10),
    ],
    // Activate demo mode
    'demo' => env('APP_DEMO', false),
];
