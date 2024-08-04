<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Gallery;
use App\Page;
use App\Post;
use App\Setting;
use App\Subscriber;
use App\Tag;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$all_categories = Category::all();
		$all_comments = Comment::all();
		$all_galleries = Gallery::all();
		$all_pages = Page::all();
		$all_posts = Post::all();
		$all_subscribers = Subscriber::all();
		$all_tags = Tag::all();
		$all_users = User::all();

		$comments = Comment::orderBy('created_at', 'desc')->limit(5)->get();
		$posts = Post::orderBy('created_at', 'desc')->limit(5)->get();
		$users = User::orderBy('created_at', 'desc')->limit(10)->get();

		return view('admin.dashboard', compact('all_categories', 'all_comments', 'all_galleries', 'all_pages', 'all_posts', 'all_subscribers', 'all_tags', 'all_users', 'comments', 'posts', 'users'));
	}
}
