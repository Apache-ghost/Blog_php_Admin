<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('posts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->integer('category_id')->unsigned()->index();
			$table->date('post_date');
			$table->string('post_title');
			$table->string('post_slug');
			$table->text('post_details');
			$table->string('featured_image')->nullable();
			$table->string('youtube_video_url')->nullable();
			$table->tinyInteger('publication_status')->default(0);
			$table->tinyInteger('is_featured')->default(0);
			$table->integer('view_count')->default(0);
			$table->string('meta_title')->nullable();;
			$table->string('meta_keywords')->nullable();
			$table->text('meta_description')->nullable();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('posts');
	}
}
