<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Medicine::class, function (Faker $faker) {
    return [
        'amount'=> $faker->numberBetween(0,2000),
        'remark' => $faker->realText(200)
    ];
});
