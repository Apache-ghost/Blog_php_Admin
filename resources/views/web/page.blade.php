@extends('web.layouts.app')

@section('title', $page->meta_title)
@section('keywords', $page->meta_keywords)
@section('description', $page->meta_description)

@section('style')
@endsection

@section('content')
<div class="col-md-8">
	<div class="crumb inner-page-crumb">
		<ul>
			<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
			<li><a class="active">{{ $page->page_name }}</a></li>
		</ul>
	</div>
	<div class="about-us">
		<h3>{{ $page->page_name }}</h3>
		@if(!empty($page->page_featured_image))
			<img src="{{ get_page_featured_image_url($page->page_featured_image) }}" alt="{{ $page->page_name }}">
			@endif
		<div class="about-meta">
		<p>{!! $page->page_content !!}</p>
		</div>
	</div>
</div>
@endsection

@section('sidebar')
@include('web.includes.sidebar')
@endsection

@section('script')
@endsection