@extends('web.layouts.app')
@section('title', $user->name)


@section('style')
@endsection

@section('content')
<div class="col-md-8">
	<div class="home-news-block block-no-space">
		<div class="crumb inner-page-crumb">
			<ul>
				<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
				<li><a href="{{ route('authorProfilePage', $user->username) }}">{{ $user->name}}</a></li>
			</ul>
		</div>

		<div class="about-us">
			<h3>Author Recent Posts</h3>

			<div class="row">
				@foreach($posts as $post)
				<div class="col-md-12">
					<div class="post-grid-style">
						<div class="post-detail">
							<h2><a href="{{ route('detailsPage', $post->post_slug) }}" title="maro news">{{ $post->post_title }}</a></h2>
							<ul class="post-meta3">
								<li><i class="ti-time"></i>{{ date("d F Y - h:ia", strtotime($post->created_at)) }}</li>
							</ul>
							<p>{!! str_limit($post->post_details, 150) !!}</p>
							<a href="{{ route('detailsPage', $post->post_slug) }}" class="readmore"><i class="ti-more-alt"></i></a>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div class="row postgrid-horiz grid-style-2">
			{{ $posts->links() }}
		</div>
	</div>
</div>
@endsection

@section('sidebar')
<div class="col-md-4">
	<aside>
		<div class="widget">
			<div class="media-body text-center">
				@if(!empty($user->avatar))
				<img src="{{ asset('public/avatar/' . $user->avatar) }}" class="media-object img-circle" style="width:80px; margin: 0 auto; padding-bottom: 10px;">
				@else
				<img src="{{ get_gravatar($user->email) }}" class="media-object img-circle" style="width:80px; margin: 0 auto; padding-bottom: 10px;">
				@endif
				<h4 class="media-heading"><strong>{{ $user->name }}</strong></h4>
				@if(isAdmin())
				<p class="text-success"><strong>Admin</strong></p>
				<a href="{{ route('admin.dashboardRoute') }}">Admin Dashboard</a>
				@elseif(isAuthor())
				<p class="text-success"><strong>Author</strong></p>
				@else
				<p class="text-success"><strong>User</strong></p>
				@endif
			</div>
			<hr>
			<div class="text-center">
				@if(!empty($user->facebook))
				<a href="{{ $user->facebook }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-facebook"></i></a>
				@endif
				@if(!empty($user->twitter))
				<a href="{{ $user->twitter }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-twitter"></i></a>
				@endif
				@if(!empty($user->google_plus))
				<a href="{{ $user->google_plus }}" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-google-plus"></i></a>
				@endif
				@if(!empty($user->linkedin))
				<a href="{{ $user->linkedin }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-linkedin"></i></a>
				@endif
			</div>
			<hr>
			<ul class="contact-widget">
				<li>
					<span>Username</span>
					<ins><i class="ti-user"></i> {{ $user->username }}</ins>
				</li>
				<li>
					<span>Email Address</span>
					<ins><i class="ti-email"></i> {{ $user->email }}</ins>
				</li>
				@if(!empty($user->phone))
				<li>
					<span>Phone Number</span>
					<ins><i class="ti-mobile"></i> {{ $user->phone }}</ins>
				</li>
				@endif
				@if(!empty($user->address))
				<li>
					<span>Address</span>
					<ins><i class="ti-location-pin"></i> {{ $user->address }}</ins>
				</li>
				@endif
				@if(!empty($user->gender))
				<li>
					<span>Gender</span>
					@if($user->gender == 'm')
					<ins><i class="fa fa-male"></i> Male</ins>
					@else
					<ins><i class="fa fa-female"></i> Female</ins>
					@endif
				</li>
				@endif
				@if(!empty($user->about))
				<li>
					<span>About</span>
					<ins><i class="ti-user"></i> {{ $user->about }}</ins>
				</li>
				@endif
			</ul>
		</div>
	</aside>
</div>
@endsection

@section('script')
@endsection