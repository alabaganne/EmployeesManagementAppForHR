<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

use Illuminate\Support\Facades\Hash;

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
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        'password' => Hash::make('password'),
        // 'remember_token' => Str::random(10),
        'phone_number' => $faker->randomNumber(8),
        'date_of_birth' => $faker->dateTime,
        'address' => $faker->sentence(4),
        'civil_status' => $faker->randomElement(['single', 'married']),
        'gender' => $faker->randomElement(['male', 'female']),
        'id_card_number' => $faker->randomNumber(8),
        'nationality' => $faker->randomElement(['American', 'Canadian', 'British', 'French', 'German', 'Spanish', 'Italian', 'Australian']),
        'university' => $faker->randomElement(['MIT', 'Stanford', 'Harvard', 'Berkeley', 'Oxford', 'Cambridge', 'NYU', 'UCLA']),
        'history' => $faker->randomElement(['Software Engineer with startup experience', 'Designer from agency background', 'Marketing specialist with B2B focus', 'Data analyst from finance sector', 'Project manager with agile expertise']),
        'experience_level' => $faker->numberBetween(1, 15),
        'source' => $faker->randomElement(['recruitment', 'referral', 'internal', 'headhunting', 'career_fair']),
        'position' => $faker->randomElement(['Software Engineer', 'UX Designer', 'Marketing Manager', 'Data Analyst', 'Project Manager', 'DevOps Engineer', 'Product Manager']),
        'grade' => $faker->randomElement(['Junior', 'Mid-level', 'Senior', 'Lead', 'Principal']),
        'hiring_date' => now(),
        'contract_end_date' => $faker->dateTime(mktime(date('Y') + 20)),
        'allowed_leave_days' => random_int(10, 30),
        // 'department_id' => rand(1, count(App\Models\Department::all())),
        'department_id' => rand(1, 5),
        'image_path' => 'storage/images/default-avatar.svg',
    ];
});
