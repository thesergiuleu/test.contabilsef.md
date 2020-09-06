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
//        'image' => 'uploads/' . $faker->image('storage/app/public/uploads',640,480, null, false),
        'slug' => $faker->slug,
        'meta_description' => $faker->sentence,
        'meta_keywords' => $faker->sentence,
    ];
});
