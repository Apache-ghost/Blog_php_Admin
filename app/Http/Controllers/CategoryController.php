<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('admin.category.index');
	}

	public function get() {
		$categories = Category::all();

		return datatables()->of($categories)
			->editColumn('created_at', '{{ date("d F Y", strtotime($created_at)) }}')
			->editColumn('updated_at', '{{ date("d F Y", strtotime($updated_at)) }}')
			->addColumn('username', function ($categories) {
				return '<a class="user-view-button" role="button" tabindex="0" data-id="' . $categories->user->id . '">' . $categories->user->name . '</a>';})
			->addColumn('publication_status', function ($categories) {
				if ($categories->publication_status == 1) {
					return '<a href="' . route('admin.unpublishedCategoriesRoute', $categories->id) . '" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Unpublished"><i class="icon fa fa-arrow-down"></i>Published</a>';
				}
				return '<a href="' . route('admin.publishedCategoriesRoute', $categories->id) . '" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Published"><i class="icon fa fa-arrow-up"></i> Unpublished</a>';})
			->addColumn('action', function ($categories) {
				return '<button class="btn btn-info btn-xs view-button" data-id="' . $categories->id . '" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></button> <button class="btn btn-primary btn-xs edit-button" data-id="' . $categories->id . '" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs delete-button" data-id="' . $categories->id . '"data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';})
			->rawColumns(['username', 'publication_status', 'action'])
			->setRowId('id')
			->make(true);
	}

	public function store(Request $request) {
		$validator = $validator = Validator::make($request->all(), [
			'category_name' => 'required|max:250',
			'category_slug' => 'required|alpha_dash|min:5|max:150|unique:categories',
			'publication_status' => 'required',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'category_name.required' => 'Category name is required.',
		]);

		if ($validator->passes()) {
			$category = Category::create([
				'user_id' => Auth::user()->id,
				'category_name' => $request->input('category_name'),
				'category_slug' => $request->input('category_slug'),
				'publication_status' => $request->input('publication_status'),
				'meta_title' => $request->input('meta_title'),
				'meta_keywords' => $request->input('meta_keywords'),
				'meta_description' => $request->input('meta_description'),
			]);
			$category_id = $category->id;

			if (!empty($category_id)) {
				$request->session()->flash('message', 'Category add successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}

			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function show($id) {
		$category = Category::where('id', $id)
			->first();
		return json_encode($category);
	}

	public function update(Request $request, $id) {
		$category = Category::find($id);

		if ($category->category_slug == $request->category_slug) {
			$category_slug = "required|alpha_dash|min:5|max:150";
		} else {
			$category_slug = "required|alpha_dash|min:5|max:150|unique:categories";
		}

		$validator = $validator = Validator::make($request->all(), [
			'category_name' => 'required|max:250',
			'category_slug' => $category_slug,
			'publication_status' => 'required',
			'meta_title' => 'required|max:250',
			'meta_keywords' => 'required|max:250',
			'meta_description' => 'required|max:400',
		], [
			'category_name.required' => 'Category name is required.',
		]);

		if ($validator->passes()) {
			$category->category_name = $request->get('category_name');
			$category->category_slug = $request->get('category_slug');
			$category->publication_status = $request->get('publication_status');
			$category->meta_title = $request->get('meta_title');
			$category->meta_keywords = $request->get('meta_keywords');
			$category->meta_description = $request->get('meta_description');
			$affected_row = $category->save();

			if (!empty($affected_row)) {
				$request->session()->flash('message', 'Category update successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}
			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function published($id) {
		$affected_row = Category::where('id', $id)
			->update(['publication_status' => 1]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Published successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function unpublished($id) {
		$affected_row = Category::where('id', $id)
			->update(['publication_status' => 0]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Unpublished successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function destroy($id) {
		$category = Category::find($id);
		if (count($category)) {
			$category->delete();
			return redirect()->back()->with('message', 'Category delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Category not found !');
		}
	}
}
