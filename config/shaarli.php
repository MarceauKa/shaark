<?php

return [
    // Hashids configuration
    'hashids' => [
        'salt' => env('HASHIDS_SALT', 'default-salt'),
        'min' => env('HASHIDS_MIN_LENGTH', 10),
    ],
    // Activate demo mode
    'demo' => env('APP_DEMO', false),
    // Default settings
    'settings' => [
        'name' => [
            'default' => env('APP_NAME'),
            'rules' => ['required', 'min:2', 'max:100']
        ],
        'locale' => [
            'default' => env('APP_LANG'),
            'rules' => ['required', 'in:fr,en,de,ja']
        ],
        'is_private' => [
            'default' => false,
            'rules' => ['nullable', 'in:on,off']
        ],
        'is_dark' => [
            'default' => false,
            'rules' => ['nullable', 'in:on,off']
        ],
        'home_show_tags' => [
            'default' => true,
            'rules' => ['nullable', 'in:on,off']
        ],
        'home_show_chests' => [
            'default' => true,
            'rules' => ['nullable', 'in:on,off']
        ],
        'compact_cardslist' => [
            'default' => false,
            'rules' => ['nullable', 'in:on,off']
        ],
        'columns_count' => [
            'default' => 3,
            'rules' => ['required', 'numeric', 'min:1', 'max:4']
        ],
        'custom_background' => [
            'default' => null,
            'rules' => ['nullable'],
        ],
        'private_archive' => [
            'default' => false,
            'rules' => ['nullable', 'in:on,off']
        ],
        'secure_login' => [
            'default' => false,
            'rules' => ['nullable', 'in:on,off']
        ],
        'secure_code_expires' => [
            'default' => 30,
            'rules' => ['required', 'numeric', 'min:5', 'max:300']
        ],
        'secure_code_length' => [
            'default' => 8,
            'rules' => ['required', 'numeric', 'min:4', 'max:12']
        ],
        'link_archive_pdf' => [
            'default' => true,
            'rules' => ['nullable', 'in:on,off']
        ],
        'link_archive_media' => [
            'default' => true,
            'rules' => ['nullable', 'in:on,off']
        ],
        'node_bin' => [
            'default' => '/usr/bin/node',
            'rules' => ['required']
        ],
        'youtube_dl_bin' => [
            'default' => '/usr/bin/youtube-dl',
            'rules' => ['required']
        ],
    ],
];
