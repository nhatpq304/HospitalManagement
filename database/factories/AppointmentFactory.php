<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Appointment::class, function (Faker $faker) {
    $date = \Carbon\Carbon::create(2020, 5, 19+rand(0,10), 8+rand(0,8), 5*rand(0,12), 0);
    return [
        'remark'=> $faker->realText(50),
        'start_time'=> $date->format('Y-m-d H:i:s'),
        'end_time'=>$date->addMinutes(rand(1, 4)*60)->format('Y-m-d H:i:s')
    ];
});
