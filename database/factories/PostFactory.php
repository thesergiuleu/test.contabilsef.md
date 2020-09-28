<?php

/** @var Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'seo_title' => $faker->sentence,
        'body' => $faker->text,
        'privacy' => $faker->boolean,
        'image' => 'uploads/dd0d9c5bb36c9edee601de8c692cfcf3.jpg',
        'slug' => $faker->slug,
        'meta_description' => $faker->sentence,
        'meta_keywords' => $faker->sentence,
    ];
});
