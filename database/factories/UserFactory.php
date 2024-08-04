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
		'name' => $faker->name,
		'username' => $faker->word . '_' . $faker->word,
		'email' => $faker->unique()->safeEmail,
		'password' => '$2y$10$oWeLVANkG.dkOCsbqynHyue3KL1MUXw6JEnQf2vpaaL.0gCBlYDei', // demo
		'role' => 'user',
		'remember_token' => str_random(10),
	];
});
