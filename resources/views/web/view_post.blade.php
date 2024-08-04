@php
use Carbon\Carbon;
@endphp

@extends('web.layouts.app')

@section('title', $post->meta_title)
@section('keywords', $post->meta_keywords)
@section('description', $post->meta_description)

@section('style')
<style type="text/css">
iframe {
	margin: 20px 0px;
}
.category {
	color: #9E9E9E;
}
.category:hover {
	color: #757575;
}
</style>
@endsection

@section('content')
<div class="col-md-8">
	<div class="home-news-block block-no-space">
		<div class="crumb inner-page-crumb">
			<ul>
				<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
				<li><a href="{{ route('dashboard.dashboardPage') }}">Dashboard</a></li>
				<li><a href="{{ route('dashboard.viewPostPage', $post->post_slug) }}">{{ $post->post_title }}</a></li>
			</ul>
		</div>

		<div class="about-us">
			<div class="row">
				<div class="col-md-12">
					<p class="text-warning pull-left">Post Status Unpublished</p>
					<a href="{{ route('dashboard.dashboardPage') }}" class="btn btn-primary pull-right btn-flat"><i class="fa fa-dashboard"></i> Dashboard</a>
				</div>
			</div>
			<hr>
			<div class="row">


				<div class="col-md-12">
					<div class="post-grid-style">
						<div class="post-detail">
							<h2><a>{{ $post->post_title }}</a></h2>
							<ul class="post-meta3">
								<li><i class="ti-time"></i>{{ date("d F Y - h:ia", strtotime($post->created_at)) }}</li>
								<li><i class="ti-comment"></i>{{ $post->comment->count() }}</li>
								<li><i class="ti-eye"></i>{{ $post->view_count }}</li>
							</ul>
							<div class="single-avatar">
								<img src="{{ get_featured_image_thumbnail_url($post->featured_image) }}" alt="maro news">
							</div>
							<p>{!! $post->post_details !!}</p>
							@if(!empty($post->youtube_video_url))
							<iframe width="100%" height="420" src="{{ $post->youtube_video_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
							@endif
							<ul class="tag">
								<li><span><i class="fa fa-tags" aria-hidden="true"></i></span></li>
								@foreach($post->tags as $tag)
								<li><a href="{{ route('tagPage', $tag->id) }}" title="{{ $tag->tag_name }}">{{ $tag->tag_name }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('sidebar')
@include('web.includes.user_sidebar')
@endsection

@section('script')
@endsection