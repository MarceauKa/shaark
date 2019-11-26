<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Album;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(1, true),
    ];
});
