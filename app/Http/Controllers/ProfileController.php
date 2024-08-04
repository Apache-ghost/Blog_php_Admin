<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class ProfileController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$user = User::where('id', Auth::user()->id)->first();
		return view('admin.profile.index', compact('user'));
	}

	public function update(Request $request, $id) {
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
			'phone' => 'required|string|max:25',
			'address' => 'required|string|max:250',
			'about' => 'required|string',
			'facebook' => 'nullable|string|max:250',
			'twitter' => 'nullable|string|max:250',
			'google_plus' => 'nullable|string|max:250',
			'linkedin' => 'nullable|string|max:250',
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
		$affected_row = $user->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Profile update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function avatar(Request $request, $id) {
		request()->validate([
			'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
		], [
			'avatar.dimensions' => 'Max dimensions 350x600',
		]);

		$user = User::find($id);
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
			return redirect()->back()->with('message', 'Avater update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
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
}
