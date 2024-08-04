<?php

namespace App\Http\Controllers;

use App\Subscriber;

class SubscriberController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('admin.subscriber.index');
	}

	public function get() {
		$subscribers = Subscriber::all();

		return datatables()->of($subscribers)
			->editColumn('created_at', '{{ date("d F Y", strtotime($created_at)) }}')
			->addColumn('action', function ($subscribers) {
				return '<button class="btn btn-danger btn-xs delete-button" data-id="' . $subscribers->id . '"data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';})
			->rawColumns(['action'])
			->setRowId('id')
			->make(true);
	}

	public function destroy($id) {
		$subscriber = Subscriber::find($id);
		if (count($subscriber)) {
			$subscriber->delete();
			return redirect()->back()->with('message', 'Subscriber delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Subscriber not found !');
		}
	}
}
