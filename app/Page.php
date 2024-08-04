<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {
	protected $fillable = [
		'user_id', 'page_name', 'page_slug', 'page_content', 'page_featured_image', 'publication_status', 'meta_title', 'meta_keywords', 'meta_description',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
