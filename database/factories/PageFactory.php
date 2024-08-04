<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {

	$word = ucfirst($faker->word);
	$page_slug = $faker->word . '_' . $faker->word;
	$meta_keywords = $faker->word . ', ' . $faker->word . ', ' . $faker->word;

	return [
		'user_id' => 1,
		'page_name' => $word,
		'page_slug' => $page_slug,
		'page_content' => $faker->text(),
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
		'meta_title' => $word,
		'meta_keywords' => $meta_keywords,
		'meta_description' => $faker->text($maxNbChars = 150),
	];
});
