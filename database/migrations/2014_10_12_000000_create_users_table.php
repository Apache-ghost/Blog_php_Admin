<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->string('username', 100)->unique();
			$table->string('email', 100)->unique();
			$table->string('password');
			$table->string('avatar')->nullable();
			$table->string('gender')->nullable();
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->string('facebook')->nullable();
			$table->string('twitter')->nullable();
			$table->string('google_plus')->nullable();
			$table->string('linkedin')->nullable();
			$table->text('about')->nullable();
			$table->string('role', 50);
			$table->tinyInteger('activation_status')->default(0);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users');
	}
}
