@extends('web.layouts.app')
@section('title', 'Dashboard')


@section('style')
@endsection

@section('content')
<div class="col-md-8">
	<div class="home-news-block block-no-space">
		<div class="crumb inner-page-crumb">
			<ul>
				<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
				<li><a href="{{ route('dashboard.dashboardPage') }}">Dashboard</a></li>
			</ul>
		</div>

		@if(isAuthor())
		<div class="about-us">
			<div class="row">
				<div class="col-md-12">
					<h3 class="pull-left">Recent Posts</h3>
					<a href="{{ route('dashboard.addPostPage') }}" class="btn btn-primary pull-right btn-flat"><i class="fa fa-plus"></i> Add Post</a>
				</div>
			</div>
			<hr>
			<div class="row">
				@foreach($posts as $post)
				<div class="col-md-12">
					<div class="post-grid-style">
						<div class="post-detail">
							@if($post->publication_status == 1)
							<h2><a href="{{ route('detailsPage', $post->post_slug) }}" title="maro news">{{ $post->post_title }}</a></h2>
							@else 
							<h2><a href="{{ route('dashboard.viewPostPage', $post->post_slug) }}" title="maro news">{{ $post->post_title }}</a></h2>
							@endif
							<ul class="post-meta3">
								<li><i class="ti-time"></i>{{ date("d F Y - h:ia", strtotime($post->created_at)) }}</li>
								<li><i class="ti-comment"></i>{{ $post->comment->count() }}</li>
								<li><i class="ti-eye"></i>{{ $post->view_count }}</li>
							</ul>
							<p>{!! str_limit($post->post_details, 150) !!}</p>
							@if($post->publication_status == 1)
							<a class="btn btn-success btn-xs btn-flat">Published</a>
							@else
							<a class="btn btn-warning btn-xs btn-flat" data-toggle="tooltip" data-original-title="Need admin approval">Unpublished</a>
							@endif
							<a href="{{ route('dashboard.editPostPage', $post->id) }}" class="btn btn-info btn-xs btn-flat">Edit</a>
							@if($post->publication_status == 1)
							<a href="{{ route('detailsPage', $post->post_slug) }}" class="readmore"><i class="ti-more-alt"></i></a>
							@else
							<a href="{{ route('dashboard.viewPostPage', $post->post_slug) }}" class="readmore"><i class="ti-more-alt"></i></a>
							@endif
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div class="row postgrid-horiz grid-style-2">
			{{ $posts->links() }}
		</div>
		@else
		<div class="about-us">
			<h3>Recent Comments</h3>

			<div class="row">
				@foreach($comments as $comment)
				<div class="col-md-12">
					<div class="post-grid-style">
						<div class="post-detail">
							<h2><a href="{{ route('detailsPage', $comment->post->post_slug) }}" title="maro news">{{ $comment->post->post_title }}</a></h2>
							<ul class="post-meta3">
								<li><i class="ti-time"></i>{{ date("d F Y - h:ia", strtotime($comment->created_at)) }}</li>
							</ul>
							<p>{!! $comment->comment !!}</p>
							@if($comment->publication_status == 1)
							<button class="btn btn-success btn-xs btn-flat">Published</button>
							@else
							<button class="btn btn-warning btn-xs btn-flat">Unpublished</button>
							@endif
							<a href="{{ route('detailsPage', $comment->post->post_slug) }}" class="readmore"><i class="ti-more-alt"></i></a>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div class="row postgrid-horiz grid-style-2">
			{{ $comments->links() }}
		</div>
		@endif
	</div>
</div>
@endsection

@section('sidebar')
@include('web.includes.user_sidebar')
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection