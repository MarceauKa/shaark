<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    $is_watched = $faker->boolean();
    $http_status_code = $faker->randomElement([
        null, 200, 302, 404, 500,
    ]);

    return [
        'title'           => $faker->sentence,
        'content'         => $faker->paragraph,
        'url'             => $faker->url,
        'is_watched'      => $is_watched,
        'http_status'     => $http_status_code,
        'http_checked_at' => $http_status_code ? $faker->dateTimeThisMonth : null,
    ];
});
