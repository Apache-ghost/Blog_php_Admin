<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Purifier;

class PostController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('admin.post.index');
	}

	public function get() {
		$posts = Post::all();

		return datatables()->of($posts)
			->editColumn('created_at', '{{ date("d F Y", strtotime($created_at)) }}')
			->editColumn('updated_at', '{{ date("d F Y", strtotime($updated_at)) }}')
			->editColumn('post_title', '{{ str_limit($post_title, 30) }}')
			->addColumn('username', function ($posts) {
				return '<a class="user-view-button" role="button" tabindex="0" data-id="' . $posts->user->id . '">' . $posts->user->name . '</a>';})
			->addColumn('publication_status', function ($posts) {
				if ($posts->publication_status == 1) {
					return '<a href="' . route('admin.unpublishedPostsRoute', $posts->id) . '" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Unpublished"><i class="icon fa fa-arrow-down"></i>Published</a>';
				}
				return '<a href="' . route('admin.publishedPostsRoute', $posts->id) . '" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Published"><i class="icon fa fa-arrow-up"></i> Unpublished</a>';})
			->addColumn('action', function ($posts) {
				return '<button class="btn btn-info btn-xs view-button" data-id="' . $posts->id . '" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></button> <a href="' . route('admin.posts.edit', $posts->id) . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a> <button class="btn btn-danger btn-xs delete-button" data-id="' . $posts->id . '"data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';})
			->addColumn('featured_image', function ($posts) {
				return '<img src="' . get_featured_image_thumbnail_url($posts->featured_image) . '" width="60" class="img img-thumbnail img-responsive">';})
			->rawColumns(['username', 'publication_status', 'action', 'featured_image'])
			->setRowId('id')
			->make(true);
	}

	public function create() {
		$categories = Category::where('publication_status', 1)->get(['id', 'category_name']);
		$tags = Tag::where('publication_status', 1)->get(['id', 'tag_name']);
		return view('admin.post.create', compact('categories', 'tags'));
	}

	public function store(Request $request) {
		$url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		$post = request()->validate([
			'category_id' => 'required',
			'post_date' => 'required|date',
			'post_title' => 'required|string|max:255',
			'post_slug' => 'required|alpha_dash|min:5|max:150|unique:posts',
			'post_details' => 'required|string',
			'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=10000,max_height=10000',
			'youtube_video_url' => 'nullable|max:255|regex:' . $url,
			'youtube_video_url' => 'nullable|max:255',
			'publication_status' => 'required',
			'is_featured' => 'required',
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
			'publication_status' => $request->input('publication_status'),
			'is_featured' => $request->input('is_featured'),
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
			return redirect()->back()->with('message', 'Post add successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
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

	public function show($id) {
		$post = Post::with(['category:id,category_name', 'user:id,name', 'tags:tag_id,tag_name'])->where('id', $id)
			->first();
		return json_encode($post);
	}

	public function edit($id) {
		$post = Post::where('id', $id)->first();
		$categories = Category::where('publication_status', 1)->get(['id', 'category_name']);
		$tags = Tag::where('publication_status', 1)->get(['id', 'tag_name']);
		return view('admin.post.edit', compact('post', 'categories', 'tags'));
	}

	public function update(Request $request, $id) {
		$post = Post::find($id);

		if ($post->post_slug == $request->post_slug) {
			$post_slug = "required|alpha_dash|min:5|max:150";
		} else {
			$post_slug = "required|alpha_dash|min:5|max:150|unique:posts";
		}

		$url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		request()->validate([
			'category_id' => 'required',
			'post_date' => 'required|date',
			'post_title' => 'required|string|max:255',
			'post_slug' => $post_slug,
			'post_details' => 'required|string',
			'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=10000,max_height=60000',
			//'youtube_video_url' => 'nullable|max:255|regex:' . $url,
			'youtube_video_url' => 'nullable|max:255',
			'publication_status' => 'required',
			'is_featured' => 'required',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'category_id.required' => 'The category field is required.',
		]);

		$post->post_title = $request->input('post_title');
		$post->post_slug = $request->input('post_slug');
		$post->category_id = $request->input('category_id');
		$post->post_date = $request->input('post_date');
		$post->publication_status = $request->input('publication_status');
		$post->is_featured = $request->input('is_featured');
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

	public function published($id) {
		$affected_row = Post::where('id', $id)
			->update(['publication_status' => 1]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Published successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function unpublished($id) {
		$affected_row = Post::where('id', $id)
			->update(['publication_status' => 0]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Unpublished successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function destroy($id) {
		$post = Post::find($id);
		if (count($post)) {
			//$post->tags()->detach();
			if ($post->featured_image) {
				@unlink(get_featured_image_path($post->featured_image));
				@unlink(get_featured_image_thumbnail_path($post->featured_image));
			}
			$post->delete();
			return redirect()->back()->with('message', 'Post delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Post not found !');
		}
	}
}