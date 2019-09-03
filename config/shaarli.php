<?php

return [
    'name' => env('APP_NAME'),
    'locale' => env('APP_LANG'),
    'is_private' => false,
    'is_dark' => false,
    'private_archive' => false,
    'link_archive_pdf' => true,
    'link_archive_media' => true,
    'node_bin' => '/usr/bin/node',
    'youtube_dl_bin' => '/usr/bin/youtube-dl',
    'hashids' => [
        'salt' => env('HASHIDS_SALT', 'default-salt'),
        'min' => env('HASHIDS_MIN_LENGTH', 10),
    ],
];
