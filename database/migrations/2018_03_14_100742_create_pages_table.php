<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->string('page_name');
			$table->string('page_slug', 190)->unique();
			$table->text('page_content');
			$table->string('page_featured_image')->nullable();
			$table->string('meta_title')->nullable();
			$table->string('meta_keywords')->nullable();
			$table->text('meta_description')->nullable();
			$table->tinyInteger('publication_status')->default(0);
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('pages');
	}
}
