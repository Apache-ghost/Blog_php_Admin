@extends('web.layouts.app')
@section('title', 'Search')


@section('style')
@endsection

@section('content')
<div class="col-md-8">
	<div class="crumb inner-page-crumb">
		<ul>
			<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
			<li><a class="active">Search Results</a></li>
		</ul>
	</div>
	@if($posts->count() > 0)
	@foreach($posts as $post)
	<div class="faqs-title">
		<a href="{{ route('detailsPage', $post->post_slug) }}" title="{{ $post->post_title }}"><h4>{{ $post->post_title }}</h4></a>
		<div class="single-post-info" style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding: 10px 0px;">
			<div class="pull-left post-author">
				@if(!empty($post->user->avatar))
				<img alt="{{ $post->user->name }}" src="{{ asset('public/avatar/' . $post->user->avatar) }}" width="35px">
				@else
				<img alt="{{ $post->user->name }}" src="{{ get_gravatar($post->user->email) }}" width="35px">
				@endif
				By <a href="{{ route('authorProfilePage', $post->user->username) }}" title="">{{ $post->user->name }}</a>
				<span class="spliator">ــ</span>
				Last Update <a>{{ date("d F Y", strtotime($post->post_date)) }}</a>
			</div>

			<ul class="views-comments pull-right">
				<li class="po-views"><i class="fa fa-eye"></i>{{ $post->view_count }}</li>
				<li><i class="fa fa-comments"></i>{{ $post->comment->count() }}</li>
			</ul>
		</div>
	</div>
	@endforeach
	@else
	<div class="text-center">No Result</div>
	@endif
</div>
@endsection

@section('sidebar')
@include('web.includes.sidebar')
@endsection

@section('script')
@endsection