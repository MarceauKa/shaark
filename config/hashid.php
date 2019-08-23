<?php

return [
    'default' => env('HASHID_CONNECTION', 'hashids'),
    'connections' => [
        'hashids' => [
            'driver' => 'hashids',
            'salt' => env('HASHIDS_SALT', ''),
            'min_length' => env('HASHIDS_MIN_LENGTH', 0),
            'alphabet' => env('HASHIDS_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),
        ],
    ],
];
