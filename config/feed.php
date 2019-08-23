<?php

return [
    'feeds' => [
        'main' => [
            'items' => 'App\\Link::getFeedItems',
            'url' => '/feed',
            'title' => env('APP_NAME'),
            'view' => 'feed::feed',
        ],
    ],
];
