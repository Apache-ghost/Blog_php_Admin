<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	protected $fillable = [
		'user_id', 'tag_name', 'tag_slug', 'publication_status', 'meta_title', 'meta_keywords', 'meta_description',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function posts() {
		return $this->belongsToMany(Post::class);
	}
}
