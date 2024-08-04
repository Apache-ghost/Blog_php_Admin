<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Image;

class PageController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('admin.page.index');
	}

	public function get() {
		$pages = Page::all();

		return datatables()->of($pages)
			->editColumn('created_at', '{{ date("d F Y", strtotime($created_at)) }}')
			->editColumn('updated_at', '{{ date("d F Y", strtotime($updated_at)) }}')
			->addColumn('username', function ($pages) {
				return '<a class="user-view-button" role="button" tabindex="0" data-id="' . $pages->user->id . '">' . $pages->user->name . '</a>';})
			->addColumn('publication_status', function ($pages) {
				if ($pages->publication_status == 1) {
					return '<a href="' . route('admin.unpublishedPagesRoute', $pages->id) . '" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Unpublished"><i class="icon fa fa-arrow-down"></i>Published</a>';
				}
				return '<a href="' . route('admin.publishedPagesRoute', $pages->id) . '" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Published"><i class="icon fa fa-arrow-up"></i> Unpublished</a>';})
			->addColumn('action', function ($pages) {
				return '<button class="btn btn-info btn-xs view-button" data-id="' . $pages->id . '" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></button> <button class="btn btn-primary btn-xs edit-button" data-id="' . $pages->id . '" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs delete-button" data-id="' . $pages->id . '"data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';})
			->addColumn('page_featured_image', function ($posts) {
				if (!empty($posts->page_featured_image)) {
					return '<img src="' . get_page_featured_image_url($posts->page_featured_image) . '" width="60" class="img img-thumbnail img-responsive">';
				}
				return '<img src="' . get_page_featured_image_url('no_image.jpg') . '" width="60" class="img img-thumbnail img-responsive">';})
			->rawColumns(['username', 'publication_status', 'action', 'page_featured_image'])
			->setRowId('id')
			->make(true);
	}

	public function store(Request $request) {
		$validator = $validator = Validator::make($request->all(), [
			'page_name' => 'required|max:250',
			'page_slug' => 'required|alpha_dash|min:5|max:150|unique:pages',
			'page_content' => 'required|string',
			'publication_status' => 'required',
			'page_featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'page_name.required' => 'Page name is required.',
			'page_featured_image.dimensions' => 'Max dimensions 350x600',
		]);

		if ($validator->passes()) {
			$page = Page::create([
				'user_id' => Auth::user()->id,
				'page_name' => $request->input('page_name'),
				'page_slug' => $request->input('page_slug'),
				'page_content' => $request->input('page_content'),
				'publication_status' => $request->input('publication_status'),
				'meta_title' => $request->input('meta_title'),
				'meta_keywords' => $request->input('meta_keywords'),
				'meta_description' => $request->input('meta_description'),
			]);

			if ($request->hasFile('page_featured_image')) {
				$image = $request->file('page_featured_image');
				$file_name = $this->page_featured_image($page->id, $image);
				Page::find($page->id)->update(['page_featured_image' => $file_name]);
			}

			if (!empty($page->id)) {
				$request->session()->flash('message', 'Page add successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}

			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function page_featured_image($id, $image) {
		$filename = $id . '.jpg';
		$location = get_page_featured_image_path($filename);
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
		if ($width < $height) {
			$y = 387;
		} else {
			$x = 688;
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
		$page = Page::with(['user:id,name'])->where('id', $id)
			->first();
		return json_encode($page);
	}

	public function update(Request $request, $id) {
		$page = Page::find($id);

		if ($page->page_slug == $request->page_slug) {
			$page_slug = "required|alpha_dash|min:5|max:150";
		} else {
			$page_slug = "required|alpha_dash|min:5|max:150|unique:pages";
		}

		$validator = $validator = Validator::make($request->all(), [
			'page_name' => 'required|max:250',
			'page_slug' => $page_slug,
			'page_content' => 'required|string',
			'publication_status' => 'required',
			'page_featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'page_name.required' => 'Page name is required.',
		]);

		if ($validator->passes()) {
			$page->page_name = $request->get('page_name');
			$page->page_slug = $request->get('page_slug');
			$page->page_content = $request->get('page_content');
			$page->publication_status = $request->get('publication_status');
			$page->meta_title = $request->get('meta_title');
			$page->meta_keywords = $request->get('meta_keywords');
			$page->meta_description = $request->get('meta_description');

			if ($request->hasFile('page_featured_image')) {
				$image = $request->file('page_featured_image');
				$file_name = $this->page_featured_image($page->id, $image);
				$page->page_featured_image = $file_name;
			}

			$affected_row = $page->save();

			if (!empty($affected_row)) {
				$request->session()->flash('message', 'Page update successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}
			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function published($id) {
		$affected_row = Page::where('id', $id)
			->update(['publication_status' => 1]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Published successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function unpublished($id) {
		$affected_row = Page::where('id', $id)
			->update(['publication_status' => 0]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Unpublished successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function destroy($id) {
		$page = Page::find($id);
		if (count($page)) {
			if ($page->page_featured_image) {
				@unlink(get_page_featured_image_path($page->page_featured_image));
			}
			$page->delete();
			return redirect()->back()->with('message', 'Page delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Page not found !');
		}
	}
}
