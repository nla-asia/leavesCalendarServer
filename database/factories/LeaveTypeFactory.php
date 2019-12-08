<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LeaveType;
use Faker\Generator as Faker;

$factory->define(LeaveType::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'days_per_year' => $faker->randomDigitNotNull,
        'description' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
