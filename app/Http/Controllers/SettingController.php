<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Image;

class SettingController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$setting = Setting::first();
		return view('admin.setting.index', compact('setting'));
	}

	public function logo(Request $request, $id) {
		request()->validate([
			'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
		], [
			'logo.dimensions' => 'Max dimensions 350x600',
		]);

		$setting = Setting::find($id);
		if ($request->hasFile('logo')) {
			$image = $request->file('logo');
			$filename = 'logo.png';
			$location = public_path('web/logo/' . $filename);
			// create new image with transparent background color
			$background = Image::canvas(262, 54, '#ffffff');
			// read image file and resize it to 262x54
			$img = Image::make($image);
			//Resize image
			$img->resize(NULL, 54, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			// insert resized image centered into background
			$background->insert($img, 'center');
			// save
			$background->save($location);
			$setting->logo = $filename;
		}

		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Logo update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function favicon(Request $request, $id) {
		request()->validate([
			'favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=5000,max_height=3000',
		], [
			'favicon.dimensions' => 'Max dimensions 350x600',
		]);

		$setting = Setting::find($id);
		if ($request->hasFile('favicon')) {
			$image = $request->file('favicon');
			$filename = 'favicon.png';
			$location = public_path('web/favicon/' . $filename);
			// create new image with transparent background color
			$background = Image::canvas(32, 32, '#ffffff');
			// read image file and resize it to 262x54
			$img = Image::make($image);
			//Resize image
			$img->resize(NULL, 32, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			// insert resized image centered into background
			$background->insert($img, 'center');
			// save
			$background->save($location);
			$setting->favicon = $filename;
		}

		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Favicon update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function general(Request $request, $id) {
		request()->validate([
			'about_us' => 'required|string|max:500',
			'copyright' => 'required|string|max:250',
			'map_iframe' => 'nullable|string|max:500',
		], [
			'about_us.required' => 'The about us field is required.',
		]);

		$setting = Setting::find($id);
		$setting->about_us = $request->input('about_us');
		$setting->copyright = $request->input('copyright');
		$setting->map_iframe = $request->input('map_iframe');
		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Setting update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function contact(Request $request, $id) {
		request()->validate([
			'email' => 'required|string|max:100',
			'phone' => 'nullable|string|max:25',
			'mobile' => 'nullable|string|max:25',
			'fax' => 'nullable|string|max:20',
		], [
			'email.required' => 'The email field is required.',
		]);

		$setting = Setting::find($id);
		$setting->email = $request->input('email');
		$setting->phone = $request->input('phone');
		$setting->mobile = $request->input('mobile');
		$setting->fax = $request->input('fax');
		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Setting update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function address(Request $request, $id) {
		request()->validate([
			'address_line_one' => 'nullable|string|max:250',
			'address_line_two' => 'nullable|string|max:250',
			'state' => 'nullable|string|max:50',
			'city' => 'nullable|string|max:50',
			'zip' => 'nullable|string|max:20',
			'country' => 'nullable|string|max:50',
		]);

		$setting = Setting::find($id);
		$setting->address_line_one = $request->input('address_line_one');
		$setting->address_line_two = $request->input('address_line_two');
		$setting->state = $request->input('state');
		$setting->city = $request->input('city');
		$setting->zip = $request->input('zip');
		$setting->country = $request->input('country');
		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Setting update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function social(Request $request, $id) {
		request()->validate([
			'facebook' => 'nullable|string|max:250',
			'twitter' => 'nullable|string|max:250',
			'google_plus' => 'nullable|string|max:50',
			'linkedin' => 'nullable|string|max:50',
		]);

		$setting = Setting::find($id);
		$setting->facebook = $request->input('facebook');
		$setting->twitter = $request->input('twitter');
		$setting->google_plus = $request->input('google_plus');
		$setting->linkedin = $request->input('linkedin');
		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Setting update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function meta(Request $request, $id) {
		request()->validate([
			'meta_title' => 'required|string|max:255',
			'meta_keywords' => 'required|string|max:255',
			'meta_description' => 'required|string|max:350',
		]);

		$setting = Setting::find($id);
		$setting->meta_title = $request->input('meta_title');
		$setting->meta_keywords = $request->input('meta_keywords');
		$setting->meta_description = $request->input('meta_description');
		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Setting update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}

	public function gallery_meta(Request $request, $id) {
		request()->validate([
			'gallery_meta_title' => 'required|string|max:255',
			'gallery_meta_keywords' => 'required|string|max:255',
			'gallery_meta_description' => 'required|string|max:350',
		]);

		$setting = Setting::find($id);
		$setting->gallery_meta_title = $request->input('gallery_meta_title');
		$setting->gallery_meta_keywords = $request->input('gallery_meta_keywords');
		$setting->gallery_meta_description = $request->input('gallery_meta_description');
		$affected_row = $setting->save();

		if (!empty($affected_row)) {
			return redirect()->back()->with('message', 'Setting update successfully.');
		} else {
			return redirect()->back()->with('exception', 'Operation failed !');
		}
	}
}
