<?php

use Faker\Generator as Faker;

$factory->define(App\Setting::class, function (Faker $faker) {
	return [
		'website_title' => 'Cluster Coding Blog',
		'logo' => 'logo.png',
		'favicon' => 'favicon.png',
		'about_us' => 'ClusterCoding is among the pioneers in the Bangladesh to offer quality web services to medium and large sized businesses to compete in today’s digital world. We possess the experience and expertise to help web entrepreneurs reach their customers across the digital space.',
		'copyright' => 'Copyright 2018 <a href="http://clustercoding.com" target="_blank">Clustercoding</a>, All rights reserved.',
		'email' => 'clustercoding@gmail.com',
		'phone' => '+8801717888464',
		'mobile' => '+8801761913331',
		'fax' => '808080',
		'address_line_one' => 'House# 83, Road# 16, Sector# 11',
		'address_line_two' => 'Uttara',
		'state' => 'Uttara',
		'city' => 'Dhaka',
		'zip' => '1230',
		'country' => 'Bangladesh',
		'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2642905.2881059386!2d89.27605108245604!3d23.817470325158617!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30adaaed80e18ba7%3A0xf2d28e0c4e1fc6b!2sBangladesh!5e0!3m2!1sen!2sbd!4v1520764767552" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>',
		'facebook' => 'https://facebook.com/clustercoding',
		'twitter' => 'https://twitter.com/cluster_coding',
		'google_plus' => 'https://plus.google.com/+ClusterCoding',
		'linkedin' => 'https://www.linkedin.com/company/clustercoding/',
		'meta_title' => 'Cluster Coding Blog',
		'meta_keywords' => 'ClusterCoding Blog, Cluster, Coding, Blog',
		'meta_description' => 'ClusterCoding is among the pioneers in the Bangladesh to offer quality web services to medium and large sized businesses to compete in today’s digital world. We possess the experience and expertise to help web entrepreneurs reach their customers across the digital space.',
		'gallery_meta_title' => 'Cluster Coding Blog',
		'gallery_meta_keywords' => 'ClusterCoding Blog, Cluster, Coding, Blog',
		'gallery_meta_description' => 'ClusterCoding is among the pioneers in the Bangladesh to offer quality web services to medium and large sized businesses to compete in today’s digital world. We possess the experience and expertise to help web entrepreneurs reach their customers across the digital space.',
	];
});
