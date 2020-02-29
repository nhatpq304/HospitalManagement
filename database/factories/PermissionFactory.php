<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Permission::class, function (Faker $faker) {
    return [
        'permission_name' => $faker->name,
        'permission_type' => 'ALL',
    ];
});
