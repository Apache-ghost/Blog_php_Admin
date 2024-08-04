<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('settings', function (Blueprint $table) {
			$table->increments('id');
			$table->string('website_title', 250)->nullable();
			$table->string('logo', 50)->nullable();
			$table->string('favicon', 50)->nullable();
			$table->text('about_us')->nullable();
			$table->string('copyright')->nullable();
			$table->string('email', 100)->nullable();
			$table->string('phone', 25)->nullable();
			$table->string('mobile', 25)->nullable();
			$table->string('fax', 20)->nullable();
			$table->string('address_line_one')->nullable();
			$table->string('address_line_two')->nullable();
			$table->string('state', 50)->nullable();
			$table->string('city', 50)->nullable();
			$table->string('zip', 20)->nullable();
			$table->string('country', 50)->nullable();
			$table->text('map_iframe')->nullable();
			$table->string('facebook')->nullable();
			$table->string('twitter')->nullable();
			$table->string('google_plus')->nullable();
			$table->string('linkedin')->nullable();
			$table->string('meta_title')->nullable();;
			$table->string('meta_keywords')->nullable();
			$table->text('meta_description')->nullable();
			$table->string('gallery_meta_title')->nullable();;
			$table->string('gallery_meta_keywords')->nullable();
			$table->text('gallery_meta_description')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('settings');
	}
}
