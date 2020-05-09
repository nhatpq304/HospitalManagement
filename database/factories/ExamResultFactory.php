<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ExamResult::class, function (Faker $faker) {
    return [
        'created_date'=> \Carbon\Carbon::now(),
        'body_temp'=> $faker->numberBetween(37,41),
        'body_weight'=> $faker->numberBetween(45, 70),
        'body_height'=> $faker->numberBetween(150,190),
        'blood_pressure'=> $faker->numberBetween(60,180),
        'department'=> "CARDIOLOGY",
        'result'=> $faker->realText(200),
    ];
});
