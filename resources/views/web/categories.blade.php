@extends('web.layouts.app')
@section('title', 'Categories')


@section('style')
<style type="text/css">
.btn { border-radius: 0px }
.category-grid-style { margin: 5px 0px; }
</style>
@endsection

@section('content')
<div class="col-md-8">
	<div class="crumb inner-page-crumb">
		<ul>
			<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
			<li><a class="active">Categories</a></li>
		</ul>
	</div>
	<div class="home-news-block block-no-space">
		@foreach($categories as $category)
		<div class="col-sm-3">
			<div class="category-grid-style">
				<a href="{{ route('categoryPage', $category->id) }}" class="btn btn-primary btn-block">{{ $category->category_name }} ({{ $category->post->count() }})</a>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection

@section('sidebar')
@include('web.includes.sidebar')
@endsection

@section('script')
@endsection