@extends('web.layouts.app')
@section('title', 'Tags')


@section('style')
<style type="text/css">
.btn { border-radius: 0px }
.tag-grid-style { margin: 5px 0px; }
</style>
@endsection

@section('content')
<div class="col-md-8">
	<div class="crumb inner-page-crumb">
		<ul>
			<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
			<li><a class="active">Tags</a></li>
		</ul>
	</div>
	<div class="home-news-block block-no-space">
		@foreach($tags as $tag)
		<div class="col-sm-3 tag-area">
			<div class="tag-grid-style">
				<a href="{{ route('tagPage', $tag->id) }}" class="btn btn-primary btn-block">{{ $tag->tag_name }} ({{ $tag->posts()->count() }})</a>
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