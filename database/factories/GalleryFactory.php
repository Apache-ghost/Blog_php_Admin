<?php

use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {

	return [
		'user_id' => 1,
		'caption' => $faker->sentence,
		'image' => '1.jpg',
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
	];
});
