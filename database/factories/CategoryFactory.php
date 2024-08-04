<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {

	$word = ucfirst($faker->word);
	$category_slug = $faker->word . '_' . $faker->word;
	$meta_keywords = $faker->word . ', ' . $faker->word . ', ' . $faker->word;

	return [
		'user_id' => 1,
		'category_name' => $word,
		'category_slug' => $category_slug,
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
		'meta_title' => $word,
		'meta_keywords' => $meta_keywords,
		'meta_description' => $faker->text($maxNbChars = 150),
	];
});
