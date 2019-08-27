<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Chest;
use App\Link;
use App\Post;
use App\Story;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'is_private' => 0,
    ];
});

$factory->state(Post::class, 'link', function (Faker $faker) {
    return ['postable_type' => Link::class,];
});

$factory->state(Post::class, 'story', function (Faker $faker) {
    return ['postable_type' => Story::class,];
});

$factory->state(Post::class, 'chest', function (Faker $faker) {
    return ['postable_type' => Chest::class,];
});

$factory->state(Post::class, 'private', function (Faker $faker) {
    return [
        'is_private' => 1,
    ];
});

$factory->afterCreating(Post::class, function (Post $post, Faker $faker) {
    if ($post->postable_type == Link::class) {
        $post->postable_id = factory(Link::class)->create()->id;
    } else if ($post->postable_type == Story::class) {
        $post->postable_id = factory(Story::class)->create()->id;
    } else if ($post->postable_type == Chest::class) {
        $post->postable_id = factory(Chest::class)->create()->id;
    }
    $post->save();
});