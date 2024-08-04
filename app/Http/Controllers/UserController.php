<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

	public function index() {
		$users = User::where('id', '!=', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(9);
		return view('admin.user.index', compact('users'));
	}

	public function update(Request $request, $id) {
		$user = User::find($id);

		$validator = $validator = Validator::make($request->all(), [
			'role' => 'required',
			'activation_status' => 'required',
		], [
			'activation_status.required' => 'Activation status is required.',
		]);

		if ($validator->passes()) {
			$user->activation_status = $request->get('activation_status');
			$user->role = $request->get('role');
			$affected_row = $user->save();

			if (!empty($affected_row)) {
				$request->session()->flash('message', 'User update successfully.');
			} else {
				$request->session()->flash('exception', 'Operation failed !');
			}
			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
	}

	public function show($id) {
		$user = User::where('id', $id)
			->first();
		return json_encode($user);
	}

	public function destroy($id) {
		$user = User::find($id);
		if (count($user)) {
			if ($user->featured_image) {
				@unlink(public_path('avatar/' . $user->avatar));
			}
			$user->delete();
			return redirect()->back()->with('message', 'User delete successfully.');
		} else {
			return redirect()->back()->with('exception', 'Post not found !');
		}
	}
}
