<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {
	protected $fillable = [
		'user_id', 'caption', 'image', 'publication_status',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
