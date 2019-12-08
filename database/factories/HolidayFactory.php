<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Holiday;
use Faker\Generator as Faker;

$factory->define(Holiday::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'start_date' => $faker->date('Y-m-d H:i:s'),
        'end_date' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
