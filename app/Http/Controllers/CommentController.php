<?php

namespace App\Http\Controllers;

use App\Comment;

class CommentController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('admin.comment.index');
	}

	public function get() {
		$comments = Comment::all();

		return datatables()->of($comments)
			->editColumn('created_at', '{{ date("d F Y", strtotime($created_at)) }}')
			->editColumn('comment', '{!! str_limit($comment, 30) !!}')
			->addColumn('post', function ($comments) {
				return '<a class="post-view-button" role="button" tabindex="0" data-id="' . $comments->post->id . '">' . str_limit($comments->post->post_title, 30) . '</a>';})
			->addColumn('username', function ($comments) {
				return '<a class="user-view-button" role="button" tabindex="0" data-id="' . $comments->user->id . '">' . $comments->user->name . '</a>';})
			->addColumn('publication_status', function ($comments) {
				if ($comments->publication_status == 1) {
					return '<a href="' . route('admin.unpublishedCommentsRoute', $comments->id) . '" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Unpublished"><i class="icon fa fa-arrow-down"></i>Published</a>';
				}
				return '<a href="' . route('admin.publishedCommentsRoute', $comments->id) . '" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to Published"><i class="icon fa fa-arrow-up"></i> Unpublished</a>';})
			->addColumn('action', function ($comments) {
				return '<button class="btn btn-info btn-xs view-button" data-id="' . $comments->id . '" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></button> <button class="btn btn-danger btn-xs delete-button" data-id="' . $comments->id . '"data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';})
			->rawColumns(['post', 'username', 'publication_status', 'action', 'comment'])
			->setRowId('id')
			->make(true);
	}

	public function show($id) {
		$comment = Comment::with(['post:id,post_title', 'user:id,name'])->where('id', $id)
			->first();
		return json_encode($comment);
	}

	public function published($id) {
		$affected_row = Comment::where('id', $id)
			->update(['publication_status' => 1]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Published successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function unpublished($id) {
		$affected_row = Comment::where('id', $id)
			->update(['publication_status' => 0]);

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Unpublished successfully.');
		}
		return redirect()->back()->with('exception', 'Operation failed !');
	}

	public function destroy($id) {
		$comment = Comment::find($id);
		if (count($comment)) {
			$comment->delete();
			return redirect()->back()->with('message', 'Comment delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Comment not found !');
		}
	}
}
