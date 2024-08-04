<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
	$word = ucfirst($faker->word);
	$post_slug = $faker->word . '_' . $faker->word;
	$meta_keywords = $faker->word . ', ' . $faker->word . ', ' . $faker->word;

	return [
		'user_id' => 1,
		'category_id' => $faker->numberBetween($min = 1, $max = 5),
		'post_date' => $faker->date($format = 'Y-m-d', $max = 'now', $min = '2018-01-01'),
		'post_title' => $faker->sentence,
		'post_slug' => $post_slug,
		'post_details' => $faker->text($minNbChars = 150, $maxNbChars = 1050),
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
		'is_featured' => $faker->numberBetween($min = 0, $max = 1),
		'meta_title' => $word,
		'meta_keywords' => $meta_keywords,
		'meta_description' => $faker->text($maxNbChars = 150),
	];
});
