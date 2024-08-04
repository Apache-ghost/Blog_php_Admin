<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	protected $fillable = [
		'user_id', 'category_id', 'post_date', 'post_title', 'post_slug', 'post_details', 'featured_image', 'youtube_video_url', 'publication_status', 'is_featured', 'view_count', 'meta_title', 'meta_keywords', 'meta_description',
	];

	public function category() {
		return $this->belongsTo(Category::class);
	}

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function tags() {
		return $this->belongsToMany(Tag::class);
	}

	public function comment() {
		return $this->hasMany(Comment::class);
	}
}
