<?php

function get_featured_image_url($var = null) {
	if ($var != null) {
		return asset('public/featured_image/' . $var . '');
	} else {
		return asset('public/featured_image/');
	}
}

function get_featured_image_path($var = null) {
	if ($var != null) {
		return public_path('featured_image/' . $var . '');
	} else {
		return public_path('featured_image/');
	}
}

function get_featured_image_thumbnail_url($var = null) {
	if ($var != null) {
		return asset('public/featured_image/thumbnail/' . $var . '');
	} else {
		return asset('public/featured_image/thumbnail/');
	}
}

function get_featured_image_thumbnail_path($var = null) {
	if ($var != null) {
		return public_path('featured_image/thumbnail/' . $var . '');
	} else {
		return public_path('featured_image/thumbnail/');
	}
}

function get_page_featured_image_url($var = null) {
	if ($var != null) {
		return asset('public/page_featured_image/' . $var . '');
	} else {
		return asset('public/page_featured_image/');
	}
}

function get_page_featured_image_path($var = null) {
	if ($var != null) {
		return public_path('page_featured_image/' . $var . '');
	} else {
		return public_path('page_featured_image/');
	}
}


function get_gallery_image_url($var = null) {
	if ($var != null) {
		return asset('public/gallery_image/' . $var . '');
	} else {
		return asset('public/gallery_image/');
	}
}

function get_gallery_image_path($var = null) {
	if ($var != null) {
		return public_path('gallery_image/' . $var . '');
	} else {
		return public_path('gallery_image/');
	}
}

function isAdmin() {
	$user = Auth::user();
	if ($user->role == 'admin') {
		return true;
	} else {
		return false;
	}
}

function isAuthor() {
	$user = Auth::user();
	if ($user->role == 'author') {
		return true;
	} else {
		return false;
	}
}

function isUser() {
	$user = Auth::user();
	if ($user->role == 'user') {
		return true;
	} else {
		return false;
	}
}

function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
	$url = 'https://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&d=$d&r=$r";
	if ($img) {
		$url = '<img src="' . $url . '"';
		foreach ($atts as $key => $val) {
			$url .= ' ' . $key . '="' . $val . '"';
		}

		$url .= ' />';
	}
	return $url;
}