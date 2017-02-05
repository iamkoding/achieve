<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\City::class, function () {
    $faker = Faker\Factory::create('en_GB');
    return [
        'name' => $faker->city
    ];
});

$factory->define(App\Mosque::class, function () {
    $faker = Faker\Factory::create('en_GB');
    return [
        'name' => $faker->company,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'telephone' => $faker->phoneNumber
    ];
});

$factory->define(App\Distance::class, function () {
    return [
        'ipaddress' => '127.0.01',
    ];
});
