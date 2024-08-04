<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('admin.tag.index');
	}

	public function get() {
		$tags = Tag::all();

		return datatables()->of($tags)
			->editColumn('created_at', '{{ date("d F Y", strtotime($created_at)) }}')
			->editColumn('updated_at', '{{ date("d F Y", strtotime($updated_at)) }}')
			->addColumn('username', function ($tags) {
				return '<a class="user-view-button" role="button" tabindex="0" data-id="' . $tags->user->id . '">' . $tags->user->name . '</a>';})
			->addColumn('publication_status', function ($tags) {
				if ($tags->publication_status == 1) {
					return '<a href="' . route('admin.unpublishedTagsRoute', $tags->id) . '" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Unpublished"><i class="icon fa fa-arrow-down"></i>Published</a>';
				}
				return '<a href="' . route('admin.publishedTagsRoute', $tags->id) . '" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Published"><i class="icon fa fa-arrow-up"></i> Unpublished</a>';})
			->addColumn('action', function ($tags) {
				return '<button class="btn btn-info btn-xs view-button" data-id="' . $tags->id . '" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></button> <button class="btn btn-primary btn-xs edit-button" data-id="' . $tags->id . '" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs delete-button" data-id="' . $tags->id . '"data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';})
			->rawColumns(['username', 'publication_status', 'action'])
			->setRowId('id')
			->make(true);
	}

	public function store(Request $request) {
		$validator = $validator = Validator::make($request->all(), [
			'tag_name' => 'required|max:250',
			'tag_slug' => 'required|alpha_dash|min:5|max:150|unique:tags',
			'publication_status' => 'required',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'tag_name.required' => 'Tag name is required.',
		]);

		if ($validator->passes()) {
			$tag = Tag::create([
				'user_id' => Auth::user()->id,
				'tag_name' => $request->input('tag_name'),
				'tag_slug' => $request->input('tag_slug'),
				'publication_status' => $request->input('publication_status'),
				'meta_title' => $request->input('meta_title'),
				'meta_keywords' => $request->input('meta_keywords'),
				'meta_description' => $request->input('meta_description'),
			]);
			$tag_id = $tag->id;

			if (!empty($tag_id)) {
				$request->session()->flash('message', 'Tag add successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}

			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function show($id) {
		$tag = Tag::where('id', $id)
			->first();
		return json_encode($tag);
	}

	public function update(Request $request, $id) {
		$tag = Tag::find($id);

		if ($tag->tag_slug == $request->tag_slug) {
			$tag_slug = "required|alpha_dash|min:5|max:150";
		} else {
			$tag_slug = "required|alpha_dash|min:5|max:150|unique:tags";
		}

		$validator = $validator = Validator::make($request->all(), [
			'tag_name' => 'required|max:250',
			'tag_slug' => $tag_slug,
			'publication_status' => 'required',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'tag_name.required' => 'Tag name is required.',
		]);

		if ($validator->passes()) {
			$tag->tag_name = $request->get('tag_name');
			$tag->tag_slug = $request->get('tag_slug');
			$tag->publication_status = $request->get('publication_status');
			$tag->meta_title = $request->get('meta_title');
			$tag->meta_keywords = $request->get('meta_keywords');
			$tag->meta_description = $request->get('meta_description');
			$affected_row = $tag->save();

			if (!empty($affected_row)) {
				$request->session()->flash('message', 'Tag update successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}
			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function published($id) {
		$affected_row = Tag::where('id', $id)
			->update(['publication_status' => 1]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Published successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function unpublished($id) {
		$affected_row = Tag::where('id', $id)
			->update(['publication_status' => 0]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Unpublished successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function destroy($id) {
		$tag = Tag::find($id);
		if (count($tag)) {
			//$tag->posts()->detach();
			$tag->delete();
			return redirect()->back()->with('message', 'Tag delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Tag not found !');
		}
	}
}