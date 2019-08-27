<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Chest;
use Faker\Generator as Faker;

$factory->define(Chest::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => [
            [
                'type' => 'url',
                'name' => 'URL Login',
                'value' => $faker->url,
            ],
            [
                'type' => 'text',
                'name' => 'Email',
                'value' => $faker->email,
            ],
            [
                'type' => 'password',
                'name' => 'Mot de passe',
                'value' => $faker->password,
            ],
        ],
    ];
});
