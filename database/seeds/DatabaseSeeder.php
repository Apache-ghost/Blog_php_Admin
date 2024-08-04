<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//$this->call(UsersTableSeeder::class);
		/*$this->call(CategoriesTableSeeder::class);
		$this->call(TagsTableSeeder::class);
		$this->call(SubscribersTableSeeder::class);
		$this->call(SettingsTableSeeder::class);*/
		//$this->call(CommentsTableSeeder::class);
		$this->call(PagesTableSeeder::class);
		$this->call(GalleriesTableSeeder::class);
	}
}
