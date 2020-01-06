<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Wall;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Wall::class, function (Faker $faker) {
    $title = $faker->word;

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'restrict_tags' => [],
        'restrict_cards' => [],
        'appearance' => Wall::APPEARANCE_DEFAULT,
        'is_default' => false,
    ];
});
