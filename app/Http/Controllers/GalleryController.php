<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Image;

class GalleryController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('admin.gallery.index');
	}

	public function get() {
		$galleries = Gallery::all();

		return datatables()->of($galleries)
			->editColumn('created_at', '{{ date("d F Y", strtotime($created_at)) }}')
			->editColumn('updated_at', '{{ date("d F Y", strtotime($updated_at)) }}')
			->addColumn('username', function ($galleries) {
				return '<a class="user-view-button" role="button" tabindex="0" data-id="' . $galleries->user->id . '">' . $galleries->user->name . '</a>';})
			->addColumn('publication_status', function ($galleries) {
				if ($galleries->publication_status == 1) {
					return '<a href="' . route('admin.unpublishedGalleriesRoute', $galleries->id) . '" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Unpublished"><i class="icon fa fa-arrow-down"></i>Published</a>';
				}
				return '<a href="' . route('admin.publishedGalleriesRoute', $galleries->id) . '" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Published"><i class="icon fa fa-arrow-up"></i> Unpublished</a>';})
			->addColumn('action', function ($galleries) {
				return '<button class="btn btn-info btn-xs view-button" data-id="' . $galleries->id . '" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></button> <button class="btn btn-primary btn-xs edit-button" data-id="' . $galleries->id . '" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs delete-button" data-id="' . $galleries->id . '"data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';})
			->addColumn('image', function ($galleries) {
				if (!empty($galleries->image)) {
					return '<img src="' . get_gallery_image_url($galleries->image) . '" width="60" class="img img-thumbnail img-responsive">';
				}
				return '<img src="' . get_gallery_image_url('no_image.jpg') . '" width="60" class="img img-thumbnail img-responsive">';})
			->rawColumns(['username', 'publication_status', 'action', 'image'])
			->setRowId('id')
			->make(true);
	}

	public function store(Request $request) {
		$validator = $validator = Validator::make($request->all(), [
			'caption' => 'required|max:250',
			'publication_status' => 'required',
			'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
		], [
			'caption.required' => 'Caption is required.',
			'image.dimensions' => 'Max dimensions 350x600',
		]);

		if ($validator->passes()) {
			$gallery = Gallery::create([
				'user_id' => Auth::user()->id,
				'caption' => $request->input('caption'),
				'publication_status' => $request->input('publication_status'),
			]);

			if ($request->hasFile('image')) {
				$image = $request->file('image');
				$file_name = $this->image($gallery->id, $image);
				Gallery::find($gallery->id)->update(['image' => $file_name]);
			}

			if (!empty($gallery->id)) {
				$request->session()->flash('message', 'Gallery add successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}

			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function image($id, $image) {
		$filename = $id . '.jpg';
		$location = get_gallery_image_path($filename);
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
		$gallery = Gallery::with(['user:id,name'])->where('id', $id)
			->first();
		return json_encode($gallery);
	}

	public function update(Request $request, $id) {
		$gallery = Gallery::find($id);

		$validator = $validator = Validator::make($request->all(), [
			'caption' => 'required|max:250',
			'publication_status' => 'required',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
		], [
			'caption.required' => 'Caption is required.',
		]);

		if ($validator->passes()) {
			$gallery->caption = $request->get('caption');
			$gallery->publication_status = $request->get('publication_status');

			if ($request->hasFile('image')) {
				$image = $request->file('image');
				$file_name = $this->image($gallery->id, $image);
				$gallery->image = $file_name;
			}

			$affected_row = $gallery->save();

			if (!empty($affected_row)) {
				$request->session()->flash('message', 'Gallery update successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}
			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function published($id) {
		$affected_row = Gallery::where('id', $id)
			->update(['publication_status' => 1]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Published successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function unpublished($id) {
		$affected_row = Gallery::where('id', $id)
			->update(['publication_status' => 0]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Unpublished successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function destroy($id) {
		$gallery = Gallery::find($id);
		if (count($gallery)) {
			if ($gallery->image) {
				@unlink(get_gallery_image_path($gallery->image));
			}
			$gallery->delete();
			return redirect()->back()->with('message', 'Gallery delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Gallery not found !');
		}
	}
}
