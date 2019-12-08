<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Leave;
use Faker\Generator as Faker;

$factory->define(Leave::class, function (Faker $faker) {

    return [
        'employer_id' => $faker->randomDigitNotNull,
        'type' => $faker->randomDigitNotNull,
        'start_date' => $faker->date('Y-m-d H:i:s'),
        'end_date' => $faker->date('Y-m-d H:i:s'),
        'reason' => $faker->text,
        'status' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
