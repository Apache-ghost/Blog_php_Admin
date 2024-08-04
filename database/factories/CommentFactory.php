<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
	return [
		'user_id' => $faker->numberBetween($min = 1, $max = 20),
		'post_id' => $faker->numberBetween($min = 1, $max = 20),
		'comment' => $faker->sentence,
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
	];
});
