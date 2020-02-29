<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\PermissionGroup::class, function (Faker $faker) {
    return [
        'group_name' => $faker->name,
    ];
});
