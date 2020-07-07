<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        // 'title' => ,
        'body' => $faker->paragraph(50),
        'published_at' => Carbon::today(),
        'user_id' => function() {
        	return factory(App\User::class)->create()->id;
        },
        'public_flag' => 1,
        'view_count' => 0,
    ];
});
