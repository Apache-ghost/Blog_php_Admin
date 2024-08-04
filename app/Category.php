<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id', 'category_name', 'category_slug', 'publication_status', 'meta_title', 'meta_keywords', 'meta_description',
    ];

    public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function post()
	{
		return $this->hasMany(Post::class);
	}
}
