<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(5, true),
    ];
});
