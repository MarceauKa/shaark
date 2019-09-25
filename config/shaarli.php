<?php

return [
    // App name
    'name' => env('APP_NAME'),
    // App locale
    'locale' => env('APP_LANG'),
    // Entire app is behind login
    'is_private' => false,
    // Dark mode
    'is_dark' => false,
    // Makes link archive private
    'private_archive' => false,
    // Requires email verification after login
    'secure_login' => false,
    // Login code expiration in minutes
    'secure_code_expires' => 30,
    // Length of the login code
    'secure_code_length' => 8,
    // Allow PDF archiving (puppeteer)
    'link_archive_pdf' => true,
    // Allow medie archiving (youtube-dl)
    'link_archive_media' => true,
    // Node.js binary path
    'node_bin' => '/usr/bin/node',
    // Youtube-dl binary path
    'youtube_dl_bin' => '/usr/bin/youtube-dl',
    // Hashids configuration
    'hashids' => [
        'salt' => env('HASHIDS_SALT', 'default-salt'),
        'min' => env('HASHIDS_MIN_LENGTH', 10),
    ],
];
