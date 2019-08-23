<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Link;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'is_private' => 0,
    ];
});

$factory->state(Link::class, 'private', function (Faker $faker) {
    return [
        'is_private' => 1,
    ];
});
