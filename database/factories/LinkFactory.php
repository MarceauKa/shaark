<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    $http_status_codes = [
        null,
        200,
        302,
        404,
        500,
    ];

    $http_status_code = $http_status_codes[rand(0, 4)];
    $http_checked_at = null;
    if (! is_null($http_status_code)) {
        $http_checked_at = $faker->dateTimeThisMonth;
    }

    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'url' => $faker->url,
        'http_status' => $http_status_code,
        'http_checked_at' => $http_checked_at,
    ];
});
