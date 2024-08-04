<?php

use Faker\Generator as Faker;

$factory->define(App\Subscriber::class, function (Faker $faker) {
	return [
		'email' => $faker->unique()->safeEmail,
	];
});
