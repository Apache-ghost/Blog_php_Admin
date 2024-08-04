<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => '/'], function () {
	Route::get('/', ['as' => 'homePage', 'uses' => 'WebController@index']);
	Route::get('/most-popular', ['as' => 'mostPopularPage', 'uses' => 'WebController@most_popular']);
	Route::get('/tags', ['as' => 'tagsPage', 'uses' => 'WebController@tags']);
	Route::get('/categories', ['as' => 'categoriesPage', 'uses' => 'WebController@categories']);
	Route::get('/gallery', ['as' => 'galleryPage', 'uses' => 'WebController@gallery']);
	Route::get('/get-gallery-image/{id}', ['as' => 'getGalleryRoute', 'uses' => 'WebController@get_gallery_image']);
	Route::get('/contact-us', ['as' => 'contactUsPage', 'uses' => 'WebController@contact_us']);

	Route::get('/page/{slug}', ['as' => 'pagePage', 'uses' => 'WebController@page'])->where('slug', '[\w\d\-\_]+');

	Route::get('/category/{id}', ['as' => 'categoryPage', 'uses' => 'WebController@category']);
	Route::get('/tag/{id}', ['as' => 'tagPage', 'uses' => 'WebController@tag']);
	Route::get('/details/{slug}', ['as' => 'detailsPage', 'uses' => 'WebController@details'])->where('slug', '[\w\d\-\_]+');

	Route::post('/comment/{id}', ['as' => 'commentRoute', 'uses' => 'WebController@comment']);
	Route::post('/replay-comment/{id}', ['as' => 'replayCommentRoute', 'uses' => 'WebController@replay_comment']);

	Route::post('/search', ['as' => 'searchRoute', 'uses' => 'WebController@search']);
	Route::post('/subscribe', ['as' => 'subscribeRoute', 'uses' => 'WebController@subscribe']);

	Route::group(['prefix' => 'dashboard', 'middleware' => ['user'], 'as' => 'dashboard.'], function () {
		Route::get('/', ['as' => 'dashboardPage', 'uses' => 'WebController@dashboard']);
		Route::get('/change-password', ['as' => 'editPasswordPage', 'uses' => 'WebController@edit_password']);
		Route::post('/update-password', ['as' => 'updatePasswordPage', 'uses' => 'WebController@update_password']);
		Route::get('/edit-profile', ['as' => 'editProfilePage', 'uses' => 'WebController@edit_profile']);
		Route::post('/update-profile/{id}', ['as' => 'updatePprofilePage', 'uses' => 'WebController@update_profile']);

		Route::get('/add-post', ['as' => 'addPostPage', 'middleware' => ['author'], 'uses' => 'WebController@add_post']);
		Route::post('/store-post', ['as' => 'storePostRoute', 'middleware' => ['author'], 'uses' => 'WebController@store_post']);
		Route::get('/edit-post/{id}', ['as' => 'editPostPage', 'middleware' => ['author'], 'uses' => 'WebController@edit_post']);
		Route::get('/view-post/{slug}', ['as' => 'viewPostPage', 'middleware' => ['author'], 'uses' => 'WebController@view_post']);
		Route::post('/update-post/{id}', ['as' => 'updatePostRoute', 'middleware' => ['author'], 'uses' => 'WebController@update_post']);
	});

	Route::get('/author-profile/{username}', ['as' => 'authorProfilePage', 'uses' => 'WebController@author_profile']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function () {
	Route::get('/dashboard', ['as' => 'dashboardRoute', 'uses' => 'DashboardController@index']);

	/*** For Category ***/
	Route::resource('categories', 'CategoryController');
	Route::get('/get-categories', ['as' => 'getCategoriesRoute', 'uses' => 'CategoryController@get']);
	Route::get('/categories/published/{id}', ['as' => 'publishedCategoriesRoute', 'uses' => 'CategoryController@published']);
	Route::get('/categories/unpublished/{id}', ['as' => 'unpublishedCategoriesRoute', 'uses' => 'CategoryController@unpublished']);

	/*** For Tag ***/
	Route::resource('tags', 'TagController');
	Route::get('/get-tags', ['as' => 'getTagsRoute', 'uses' => 'TagController@get']);
	Route::get('/tags/published/{id}', ['as' => 'publishedTagsRoute', 'uses' => 'TagController@published']);
	Route::get('/tags/unpublished/{id}', ['as' => 'unpublishedTagsRoute', 'uses' => 'TagController@unpublished']);

	/*** For Post ***/
	Route::resource('posts', 'PostController');
	Route::get('/get-posts', ['as' => 'getPostsRoute', 'uses' => 'PostController@get']);
	Route::get('/posts/published/{id}', ['as' => 'publishedPostsRoute', 'uses' => 'PostController@published']);
	Route::get('/posts/unpublished/{id}', ['as' => 'unpublishedPostsRoute', 'uses' => 'PostController@unpublished']);

	/*** For Subscriber ***/
	Route::resource('subscribers', 'SubscriberController');
	Route::get('/get-subscribers', ['as' => 'getSubscribersRoute', 'uses' => 'SubscriberController@get']);

	/*** For Setting ***/
	Route::resource('setting', 'SettingController');
	Route::post('/setting/logo/{id}', ['as' => 'settingLogoRoute', 'uses' => 'SettingController@logo']);
	Route::post('/setting/favicon/{id}', ['as' => 'settingFaviconRoute', 'uses' => 'SettingController@favicon']);
	Route::post('/setting/general/{id}', ['as' => 'settingGeneralRoute', 'uses' => 'SettingController@general']);
	Route::post('/setting/contact/{id}', ['as' => 'settingContactRoute', 'uses' => 'SettingController@contact']);
	Route::post('/setting/address/{id}', ['as' => 'settingAddressRoute', 'uses' => 'SettingController@address']);
	Route::post('/setting/social/{id}', ['as' => 'settingSocialRoute', 'uses' => 'SettingController@social']);
	Route::post('/setting/meta/{id}', ['as' => 'settingMetaRoute', 'uses' => 'SettingController@meta']);
	Route::post('/setting/gallery-meta/{id}', ['as' => 'settingGalleryMetaRoute', 'uses' => 'SettingController@gallery_meta']);

	/*** For Profile ***/
	Route::resource('profile', 'ProfileController');
	Route::post('/profile/avatar/{id}', ['as' => 'profileAvatarRoute', 'uses' => 'ProfileController@avatar']);
	Route::post('/profile/update-password', ['as' => 'profileUpdatePasswordRoute', 'uses' => 'ProfileController@update_password']);

	/*** For User ***/
	Route::resource('users', 'UserController');

	/*** For Comment ***/
	Route::resource('comments', 'CommentController');
	Route::get('/get-comments', ['as' => 'getCommentsRoute', 'uses' => 'CommentController@get']);
	Route::get('/comments/published/{id}', ['as' => 'publishedCommentsRoute', 'uses' => 'CommentController@published']);
	Route::get('/comments/unpublished/{id}', ['as' => 'unpublishedCommentsRoute', 'uses' => 'CommentController@unpublished']);

	/*** For Page ***/
	Route::resource('pages', 'PageController');
	Route::get('/get-pages', ['as' => 'getPagesRoute', 'uses' => 'PageController@get']);
	Route::get('/pages/published/{id}', ['as' => 'publishedPagesRoute', 'uses' => 'PageController@published']);
	Route::get('/pages/unpublished/{id}', ['as' => 'unpublishedPagesRoute', 'uses' => 'PageController@unpublished']);

	/*** For Gallery ***/
	Route::resource('galleries', 'GalleryController');
	Route::get('/get-galleries', ['as' => 'getGalleriesRoute', 'uses' => 'GalleryController@get']);
	Route::get('/galleries/published/{id}', ['as' => 'publishedGalleriesRoute', 'uses' => 'GalleryController@published']);
	Route::get('/galleries/unpublished/{id}', ['as' => 'unpublishedGalleriesRoute', 'uses' => 'GalleryController@unpublished']);

});

Auth::routes();