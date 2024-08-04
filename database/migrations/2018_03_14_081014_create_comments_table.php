<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('comments', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->integer('post_id')->unsigned()->index();
			$table->integer('parent_comment_id')->unsigned()->nullable();
			$table->text('comment');
			$table->tinyInteger('publication_status')->default(1);
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('comments');
	}
}
