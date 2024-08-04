<?php

use Illuminate\Database\Seeder;

class GalleriesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(App\Gallery::class, 15)->create();
	}
}
