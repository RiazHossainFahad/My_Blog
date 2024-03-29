<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'url' => 'logo.png',
        'title' => $faker->text(50),
        'body' => $faker->paragraph
    ];
});
