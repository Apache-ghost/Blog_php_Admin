<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
	$word = ucfirst($faker->word);
	$tag_slug = $faker->word . '_' . $faker->word;
	$meta_keywords = $faker->word . ', ' . $faker->word . ', ' . $faker->word;

	return [
		'user_id' => 1,
		'tag_name' => $word,
		'tag_slug' => $tag_slug,
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
		'meta_title' => $word,
		'meta_keywords' => $meta_keywords,
		'meta_description' => $faker->text($maxNbChars = 150),
	];
});
