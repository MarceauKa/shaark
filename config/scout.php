<?php

return [
    // Supported: "algolia", "null"
    'driver' => env('SCOUT_DRIVER', 'algolia'),
    'prefix' => env('SCOUT_PREFIX', ''),
    'queue' => env('SCOUT_QUEUE', false),
    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],
    'soft_delete' => false,
    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],
    'tntsearch' => [
        'storage'  => storage_path(),
        'fuzziness' => env('TNTSEARCH_FUZZINESS', true),
        'fuzzy' => [
            'prefix_length' => 2,
            'max_expansions' => 100,
            'distance' => 4
        ],
        'asYouType' => true,
        'searchBoolean' => env('TNTSEARCH_BOOLEAN', false),
    ],
];
