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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Purifier;

class WebController extends Controller {

	public function index() {
		$setting = Setting::first(['meta_title', 'meta_keywords', 'meta_description']);
		$posts = Post::where('publication_status', 1)->orderBy('post_date', 'desc')->paginate(10);
		$popular_posts = Post::where(['publication_status' => 1])->orderBy('view_count', 'desc')->limit(9)->get();
		return view('web.home', compact('posts', 'popular_posts', 'setting'));
	}

	public function most_popular() {
		$popular_posts = Post::where(['publication_status' => 1])->orderBy('view_count', 'desc')->paginate(10);
		$recent_posts = Post::where(['publication_status' => 1])->orderBy('post_date', 'desc')->limit(9)->get();
		return view('web.most_popular', compact('recent_posts', 'popular_posts'));
	}

	public function tags() {
		$tags = Tag::where(['publication_status' => 1])->orderBy('tag_name')->get(['id', 'tag_name']);
		return view('web.tags', compact('tags'));
	}

	public function categories() {
		$categories = Category::where(['publication_status' => 1])->orderBy('category_name')->get(['id', 'category_name']);
		return view('web.categories', compact('categories'));
	}

	public function contact_us() {
		$setting = Setting::first();
		return view('web.contact_us', compact('setting'));
	}

	public function gallery() {
		$setting = Setting::first(['gallery_meta_title', 'gallery_meta_keywords', 'gallery_meta_description']);
		$galleries = Gallery::where(['publication_status' => 1])->orderBy('created_at', 'desc')->paginate(9);
		return view('web.gallery', compact('galleries', 'setting'));
	}

	public function get_gallery_image($id) {
		$gallery = Gallery::where('id', $id)->first();
		return json_encode($gallery);
	}

	public function search(Request $request) {
		$post = request()->validate([
			'search_keywords' => 'required|string|max:250',
		], [
			'search_keywords.required' => 'The keywords field is required.',
		]);

		$search_keywords = $request->input('search_keywords');
		$posts = Post::where('post_title', 'like', '%' . $search_keywords . '%')->where('publication_status', 1)->orderBy('post_date', 'desc')->limit(25)->get();

		return view('web.search', compact('posts'));
	}

	public function subscribe(Request $request) {
		$validator = $validator = Validator::make($request->all(), [
			'email' => 'required|email|max:100|unique:subscribers',
		], [
			'email.required' => 'Email address is required.',
		]);

		if ($validator->passes()) {
			$subscriber = Subscriber::create([
				'email' => $request->input('email'),
			]);
			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function page($slug) {
		$page = Page::where(['publication_status' => 1, 'page_slug' => $slug])->first();
		return view('web.page', compact('page'));
	}

	public function category($id) {
		$category = Category::where(['publication_status' => 1, 'id' => $id])->first();
		$posts = $category->post()->where(['publication_status' => 1])->orderBy('post_date', 'desc')->paginate(10);
		$popular_posts = $category->post()->where(['publication_status' => 1])->orderBy('view_count', 'desc')->limit(9)->get();
		return view('web.category', compact('posts', 'popular_posts', 'category'));
	}

	public function tag($id) {
		$tag = Tag::where(['publication_status' => 1, 'id' => $id])->first();
		$posts = $tag->posts()->where('publication_status', 1)->orderBy('post_date', 'desc')->paginate(10);
		$popular_posts = $tag->posts()->where('publication_status', 1)->orderBy('view_count', 'desc')->limit(9)->get();
		return view('web.tag', compact('tag', 'popular_posts', 'posts'));
	}

	public function details($slug) {
		$blog_key = 'blog_' . $slug;
		if (!Session::has($blog_key)) {
			Post::where('post_slug', $slug)->increment('view_count');
			Session::put($blog_key, 1);
		}
		$post = Post::where(['post_slug' => $slug, 'publication_status' => 1])->first();
		if (!empty($post)) {
			$comments = Comment::where(['post_id' => $post->id, 'parent_comment_id' => NULL, 'publication_status' => 1])->orderBy('id', 'desc')->get();
			$related_posts = Post::where(['category_id' => $post->category->id, 'publication_status' => 1])->orderBy('post_date', 'desc')->limit(9)->get();
			return view('web.details', compact('post', 'related_posts', 'comments'));
		} else {
			return response()->view('errors.404');
		}
	}

	public function comment(Request $request, $post_id) {
		request()->validate([
			'comment' => 'required|string|max:2500',
		], [
			'comment.required' => 'The Comment field is required.',
		]);

		$comment = Comment::create([
			'user_id' => Auth::user()->id,
			'post_id' => $post_id,
			'comment' => Purifier::clean($request->input('comment')),
		]);

		if (!empty($comment->id)) {
			return redirect()->back()->with('message', 'Comment add successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function replay_comment(Request $request, $comment_id) {
		request()->validate([
			'comment' => 'required|string|max:2500',
		], [
			'comment.required' => 'The Comment field is required.',
		]);

		$comment = Comment::create([
			'user_id' => Auth::user()->id,
			'parent_comment_id' => $comment_id,
			'post_id' => $request->input('post_id'),
			'comment' => Purifier::clean($request->input('comment')),
		]);

		if (!empty($comment->id)) {
			return redirect()->back()->with('message', 'Comment add successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function dashboard() {
		$comments = Comment::where(['user_id' => Auth::user()->id])->orderBy('id', 'desc')->paginate(5);
		$posts = Post::where(['user_id' => Auth::user()->id])->orderBy('post_date', 'desc')->paginate(5);
		return view('web.dashboard', compact('comments', 'posts'));
	}

	public function edit_password() {
		return view('web.change_password');
	}

	public function update_password(Request $request) {
		$validatedData = $request->validate([
			'current_password' => 'required',
			'new_password' => 'required|string|min:8|confirmed',
		]);

		if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
			// The passwords matches
			return redirect()->back()->with("exception", "Your current password does not matches with the password you provided. Please try again.");
		}

		if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
			//Current password and new password are same
			return redirect()->back()->with("exception", "New Password cannot be same as your current password. Please choose a different password.");
		}

		//Change password
		$user = Auth::user();
		$user->password = bcrypt($request->get('new_password'));
		$user->save();

		return redirect()->back()->with("message", "Password update successfully !");
	}

	public function edit_profile() {
		return view('web.edit_profile');
	}

	public function update_profile(Request $request, $id) {
		$user = User::find($id);

		if ($user->email == $request->input('email')) {
			$email = "required|string|email|max:100";
		} else {
			$email = "required|string|email|max:100|unique:users";
		}

		if ($user->username == $request->input('username')) {
			$username = "required|alpha_dash|max:50";
		} else {
			$username = "required|alpha_dash|max:50|unique:users";
		}

		request()->validate([
			'name' => 'required|string|max:100',
			'username' => $username,
			'email' => $email,
			'gender' => 'required',
			'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
			'phone' => 'required|string|max:25',
			'address' => 'required|string|max:250',
			'about' => 'required|string',
			'facebook' => 'nullable|string|max:250',
			'twitter' => 'nullable|string|max:250',
			'google_plus' => 'nullable|string|max:250',
			'linkedin' => 'nullable|string|max:250',
		], [
			'avatar.dimensions' => 'Max dimensions 1920x1080',
		]);

		$user->name = $request->input('name');
		$user->username = $request->input('username');
		$user->email = $request->input('email');
		$user->gender = $request->input('gender');
		$user->phone = $request->input('phone');
		$user->address = $request->input('address');
		$user->about = $request->input('about');
		$user->facebook = $request->input('facebook');
		$user->twitter = $request->input('twitter');
		$user->google_plus = $request->input('google_plus');
		$user->linkedin = $request->input('linkedin');

		if ($request->hasFile('avatar')) {
			$image = $request->file('avatar');
			$filename = $user->id . '.png';
			$location = public_path('avatar/' . $filename);
			// create new image with transparent background color
			$background = Image::canvas(215, 215, '#ffffff');
			// read image file and resize it to 262x54
			$img = Image::make($image);
			//Resize image
			$img->resize(NULL, 215, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			// insert resized image centered into background
			$background->insert($img, 'center');
			// save
			$background->save($location);
			$user->avatar = $filename;
		}

		$affected_row = $user->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Profile update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function author_profile($username) {
		$user = User::where('username', $username)->first();
		$posts = $user->post()->where('publication_status', 1)->orderBy('post_date', 'desc')->paginate(5);
		return view('web.author_profile', compact('user', 'posts'));
	}

	public function add_post() {
		$categories = Category::where('publication_status', 1)->get(['id', 'category_name']);
		$tags = Tag::where('publication_status', 1)->get(['id', 'tag_name']);
		return view('web.add_post', compact('categories', 'tags'));
	}

	public function store_post(Request $request) {
		$url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		$post = request()->validate([
			'category_id' => 'required',
			'post_date' => 'required|date',
			'post_title' => 'required|string|max:255',
			'post_slug' => 'required|alpha_dash|min:5|max:150|unique:posts',
			'post_tags' => 'required',
			'post_details' => 'required|string',
			'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=10000,max_height=10000',
			//'youtube_video_url' => 'nullable|max:255|regex:' . $url,
			'youtube_video_url' => 'nullable|max:255',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'featured_image.dimensions' => 'Max dimensions 350x600',
			'category_id.required' => 'The category field is required.',
		]);

		$url = $request->input('youtube_video_url');
		$youtube_video_url = str_replace('youtu.be', 'youtube.com/embed', $url);

		$post = Post::create([
			'user_id' => Auth::user()->id,
			'post_title' => $request->input('post_title'),
			'post_slug' => $request->input('post_slug'),
			'category_id' => $request->input('category_id'),
			'post_date' => $request->input('post_date'),
			'publication_status' => 0,
			'is_featured' => 0,
			'youtube_video_url' => $youtube_video_url,
			'post_details' => Purifier::clean($request->input('post_details')),
			'meta_title' => $request->input('meta_title'),
			'meta_keywords' => $request->input('meta_keywords'),
			'meta_description' => Purifier::clean($request->input('meta_description')),
		]);

		if (isset($request->post_tags)) {
			$post->tags()->sync($request->post_tags, false);
		} else {
			$post->tags()->sync(array());
		}

		if ($request->hasFile('featured_image')) {
			$image = $request->file('featured_image');
			$file_name = $this->featured_image($post->id, $image);
			$this->featured_image_thumbnail($post->id, $image);
			Post::find($post->id)->update(['featured_image' => $file_name]);
		}

		if (!empty($post->id)) {
			return redirect()->back()->with('message', 'Post add successfully. Admin will review your post and approve. Please wait sometimes.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function edit_post($id) {
		$post = Post::where(['id' => $id, 'user_id' => Auth::user()->id])->firstOrFail();
		$categories = Category::where('publication_status', 1)->get(['id', 'category_name']);
		$tags = Tag::where('publication_status', 1)->get(['id', 'tag_name']);
		return view('web.edit_post', compact('categories', 'tags', 'post'));
	}

	public function update_post(Request $request, $id) {
		$post = Post::find($id);

		if ($post->post_slug == $request->post_slug) {
			$post_slug = "required|alpha_dash|min:5|max:150";
		} else {
			$post_slug = "required|alpha_dash|min:5|max:150|unique:posts";
		}

		$url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		request()->validate([
			'category_id' => 'required',
			'post_title' => 'required|string|max:255',
			'post_slug' => $post_slug,
			'post_details' => 'required|string',
			'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=10000,max_height=60000',
			//'youtube_video_url' => 'nullable|max:255|regex:' . $url,
			'youtube_video_url' => 'nullable|max:255',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'category_id.required' => 'The category field is required.',
		]);

		$post->post_title = $request->input('post_title');
		$post->post_slug = $request->input('post_slug');
		$post->category_id = $request->input('category_id');
		$post->youtube_video_url = $request->input('youtube_video_url');
		$post->post_details = Purifier::clean($request->input('post_details'));
		$post->meta_title = $request->input('meta_title');
		$post->meta_keywords = $request->input('meta_keywords');
		$post->meta_description = Purifier::clean($request->input('meta_description'));

		if ($request->hasFile('featured_image')) {
			$image = $request->file('featured_image');
			$file_name = $this->featured_image($id, $image);
			$this->featured_image_thumbnail($id, $image);
			$post->featured_image = $file_name;
		}

		$affected_row = $post->save();

		if (isset($request->post_tags)) {
			$post->tags()->sync($request->post_tags);
		} else {
			$post->tags()->sync(array());
		}

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Post update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function view_post($slug) {
		$post = Post::where(['post_slug' => $slug, 'publication_status' => 0])->first();
		return view('web.view_post', compact('post'));
	}

	public function featured_image($id, $image) {
		$filename = $id . '.' . $image->getClientOriginalExtension();
		$location = get_featured_image_path($filename);
		// create new image with transparent background color
		$background = Image::canvas(688, 387);
		// read image file and resize it to 200x200
		$img = Image::make($image);
		// Image Height
		$height = $img->height();
		// Image Width
		$width = $img->width();
		$x = NULL;
		$y = NULL;
		if ($width > $height) {
			$y = 688;
		} else {
			$x = 387;
		}
		//Resize Image
		$img->resize($x, $y, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});
		// insert resized image centered into background
		$background->insert($img, 'center');
		// save
		$background->save($location);
		return $filename;
	}

	public function featured_image_thumbnail($id, $image) {
		$filename = $id . '.' . $image->getClientOriginalExtension();
		$location = get_featured_image_thumbnail_path($filename);
		// create new image with transparent background color
		$background = Image::canvas(370, 235);
		// read image file and resize it to 200x200
		$img = Image::make($image);
		// Image Height
		$height = $img->height();
		// Image Width
		$width = $img->width();
		$x = NULL;
		$y = NULL;
		if ($width > $height) {
			$y = 370;
		} else {
			$x = 235;
		}
		//Resize Image
		$img->resize($x, $y, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});
		// insert resized image centered into background
		$background->insert($img, 'center');
		// save
		$background->save($location);
		return $filename;
	}
}
