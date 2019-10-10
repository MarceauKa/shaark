<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Story;
use Faker\Generator as Faker;

$factory->define(Story::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'slug' => $faker->unique->slug,
        'content' => $faker->paragraphs(5, true),
    ];
});
