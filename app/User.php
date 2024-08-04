<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'username', 'password', 'avatar', 'role', 'activation_status', 'gender', 'phone', 'address', 'facebook', 'twitter', 'google_plus', 'linkedin', 'about',

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function post() {
		return $this->hasMany(Post::class);
	}
}
