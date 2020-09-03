<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token' => Str::random(10),
        'birth_date' => $faker->dateTime,
        'phone_number' => $faker->randomNumber(8),
        'school' => $faker->sentence(5, true),
        'history' => $faker->sentence(6, true),
        'position' => $faker->word,
        'department_id' => rand(1, count(App\Department::all())),
        'contract_start_date' => now(),
        'contract_end_date' => $faker->dateTime(mktime(date('Y') + 20)),
        'gender' => $faker->randomElement(['male', 'female']),
        'allowed_leaves' => random_int(10, 30),
        'ncin' => $faker->randomNumber(8)
    ];
});
