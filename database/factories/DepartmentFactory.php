<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->word())
    ];
});
