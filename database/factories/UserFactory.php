<?php

use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName($gender = null|'male'|'female'),
        'second_name' => $faker->firstName($gender = null|'male'|'female'),
        'surname' => $faker->firstName($gender = null|'male'|'female'),
        'second_surname' => $faker->lastName ,
        'phone_number' => $faker->bankRoutingNumber,
        'address' => $faker->address,
        'identification' => $faker->randomNumber($nbDigits = NULL, $strict = false) ,
        'ocupation' => $faker->realText($maxNbChars = 100, $indexSize = 2),
        'email' => $faker->unique()->safeEmail,
        // 'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'type_identification_id' => random_int(1, 6),
        'municipio_id' => random_int(1, 2),
        'departamento_id' => random_int(1, 2),
    ];
});
