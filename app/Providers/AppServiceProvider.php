<?php

namespace App\Providers;

use App\Category;
use App\Comment;
use App\Page;
use App\Post;
use App\Setting;
use App\Tag;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		//View::share('setting', 'query');

		View::composer(['web.includes.sidebar'], function ($view) {
			$categories = Category::where('publication_status', 1)->orderBy('category_name')->get(['id', 'category_name']);
			$tags = Tag::where('publication_status', 1)->orderBy('tag_name')->get(['id', 'tag_name']);
			$setting = Setting::first();
			$view->with(compact('categories', 'tags', 'setting'));
		});

		View::composer(['web.includes.header', 'web.includes.footer'], function ($view) {
			$setting = Setting::first();
			$pages = Page::where('publication_status', 1)->get(['page_name', 'page_slug']);
			$view->with(compact('setting', 'pages'));
		});

		View::composer(['admin.includes.header'], function ($view) {
			$comments = Comment::where('publication_status', 0)->get(['id']);
			$posts = Post::where('publication_status', 0)->get(['id']);
			$view->with(compact('comments', 'posts'));
		});

		View::composer(['web.includes.head'], function ($view) {
			$setting = Setting::first(['website_title']);
			$view->with(compact('setting'));
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
