@php
use Carbon\Carbon;
@endphp

@extends('web.layouts.app')

@section('title', $post->meta_title)
@section('keywords', $post->meta_keywords)
@section('description', $post->meta_description)

@section('style')
<!-- Social Share: http://js-socials.com/demos/ -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/web/jssocials/jssocials.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/web/jssocials/jssocials-theme-flat.css') }}">
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
	<div class="crumb inner-page-crumb">
		<ul>
			<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
			<li><a href="{{ route('categoryPage', $post->category->id) }}" title="{{ $post->category->category_name }}">{{ $post->category->category_name }}</a> / </li>
			<li><a class="active">{{ $post->post_title }}</a></li>
		</ul>
	</div>
	<div class="blog-single">
		<div class="post-head">
			<h1>{{ $post->post_title }}</h1>
			<div class="single-post-info">
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
		<div id="shareNative"></div>
		<div id="shareButtonLabel"></div>
		<!-- <ul class="share-links">
			<li><a href="#" title="" class="facebook"><i class="fa fa-facebook"></i> Facebook <b>563</b></a></li>
			<li><a href="#" title="" class="twitter"><i class="fa fa-twitter"></i> Twitter <b>650</b></a></li>
			<li><a href="#" title="" class="google"><i class="fa fa-google"></i> Google+</a></li>
			<li><a href="#" title="" class="pinterest"><i class="fa fa-pinterest-p"></i> Pinterest</a></li>
			<li><a href="#" title="" class="flickr"><i class="fa fa-flickr"></i> Flickr</a></li>
			<li><a href="#" title="" class="linkedin"><i class="fa fa-linkedin"></i> Linkedin</a></li>
			<li><a href="#" title="" class="whatsapp"><i class="fa fa-whatsapp"></i> Whatsapp</a></li>
		</ul> -->
		<div class="single-avatar">
			<img src="{{ get_featured_image_thumbnail_url($post->featured_image) }}" alt="maro news">
		</div>
		<div class="single-post-detail">
			<a title="{{ $post->post_title }}" class="category">{{ $post->post_title }}</a>
			{!! $post->post_details !!}
			@if(!empty($post->youtube_video_url))
			<iframe width="100%" height="420" src="{{ $post->youtube_video_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			@endif
			<ul class="tag">
				<li><span><i class="fa fa-tags" aria-hidden="true"></i></span></li>
				@foreach($post->tags as $tag)
				<li><a href="{{ route('tagPage', $tag->id) }}" title="{{ $tag->tag_name }}">{{ $tag->tag_name }}</a></li>
				@endforeach
			</ul>
			<div class="author">
				<div class="author-avatar">
					@if(!empty($post->user->avatar))
					<img alt="{{ $post->user->name }}" src="{{ asset('public/avatar/' . $post->user->avatar) }}" width="90px">
					@else
					<img alt="{{ $post->user->name }}" src="{{ get_gravatar($post->user->email) }}" width="90px">
					@endif
				</div>
				<div class="author-about">
					<h4><a href="{{ route('authorProfilePage', $post->user->username) }}">{{ $post->user->name }}</a></h4>
					<p>{{ $post->user->about }} &nbsp; </p>
					<ul>
						@if($post->user->facebook)
						<li><a href="{{ $post->user->facebook }}" target="_blank" title="facebook" class="facebook"><i class="fa fa-facebook"></i></a></li>
						@endif
						@if($post->user->twitter)
						<li><a href="{{ $post->user->twitter }}" target="_blank" title="twitter" class="twitter"><i class="fa fa-twitter"></i></a></li>
						@endif
						@if($post->user->google_plus)
						<li><a href="{{ $post->user->google_plus }}" target="_blank" title="google" class="google"><i class="fa fa-google-plus"></i></a></li>
						@endif
						@if($post->user->linkedin)
						<li><a href="{{ $post->user->linkedin }}" target="_blank" title="linkedin" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="single-related">
		<div class="single-title">
			<h4><i class="fa fa-thumbs-o-up"></i> You May Also Like</h4>
		</div>
		<div class="category-recent-post">
			@foreach($related_posts->chunk(3) as $items)
			<div class="progress-unit">
				@foreach($items as $related_post)
				<div class="col-md-4 col-sm-12">
					<div class="pp-trending-grid">
						<img src="{{ get_featured_image_thumbnail_url($related_post->featured_image) }}" alt="maro news">
						<div class="pp-trend-meta">
							<h5><a href="{{ route('detailsPage', $related_post->post_slug) }}" title="">{{ str_limit($related_post->post_title, 50) }}</a></h5>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			@endforeach
		</div>
	</div>

	<div class="space no-top comments-sec">
		<div class="single-title">
			<h4><i class="fa fa-comments"></i> {{ $post->comment->count() }} Comments.</h4>
		</div>
		<ul>
			@foreach($comments as $comment)
			<li>
				<div class="comment">
					@if(!empty($comment->user->avatar))
					<img alt="{{ $comment->user->name }}" src="{{ asset('public/avatar/' . $comment->user->avatar) }}" width="70px">
					@else
					<img alt="{{ $comment->user->name }}" src="{{ get_gravatar($comment->user->email) }}" width="70px">
					@endif
					<div class="comment-detail">
						<h4><a title="" href="#">{{ $comment->user->name }}</a></h4><span>{{ date("d F Y - h:ia", strtotime($comment->created_at)) }}</span>
						<p>{!! $comment->comment !!}</p>
						@if(Auth::check())
						<a title="Replay" class="reply" data-id="{{ $comment->id }}"><i class="fa fa-reply"></i>Reply</a>
						@endif
					</div>
				</div>
				@php($sub_comments = App\Comment::where(['post_id' => $post->id, 'parent_comment_id' => $comment->id, 'publication_status' => 1])->orderBy('id', 'asc')->get())
				@foreach($sub_comments as $sub_comment)
				<ul>
					<li>
						<div class="comment">
							@if(!empty($sub_comment->user->avatar))
							<img alt="{{ $sub_comment->user->name }}" src="{{ asset('public/avatar/' . $sub_comment->user->avatar) }}" width="70px">
							@else
							<img alt="{{ $sub_comment->user->name }}" src="{{ get_gravatar($sub_comment->user->email) }}" width="70px">
							@endif
							<div class="comment-detail">
								<h4><a title="" href="#">{{ $sub_comment->user->name }}</a></h4><span>{{ date("d F Y - h:ia", strtotime($sub_comment->created_at)) }}</span>
								<p>{!! $sub_comment->comment !!}</p>
								@if(Auth::check())
								<a title="Replay" class="reply" data-id="{{ $comment->id }}"><i class="fa fa-reply"></i>Reply</a>
								@endif
							</div>
						</div>
					</li>
				</ul>
				@endforeach

				<div id="reply_form_{{ $comment->id }}"></div>

			</li>
			@endforeach
		</ul>
	</div>
	<div class="contact-form">
		<div class="single-title">
			<h4>leave a comment</h4>
		</div>

		<div class="row">
			<div class="col-sm-12">
				@if (!empty(Session::get('message')))
				<p style="color: #5cb85c">{{ Session::get('message') }}</p>
				@elseif (!empty(Session::get('exception')))
				<p style="color: #d9534f">{{ Session::get('exception') }}</p>
				@endif
			</div>
			@if(Auth::check())
			<form data-parsley-validate action="{{ route('commentRoute', $post->id) }}" method="post">
				{{ csrf_field() }}
				<div class="col-sm-12{{ $errors->has('comment') ? ' has-error' : '' }}">
					<label>Comment <span class="required">*</span></label>
					<textarea name="comment" cols="30" rows="10" required></textarea>
					@if ($errors->has('comment'))
					<span class="help-block">
						<strong>{{ $errors->first('comment') }}</strong>
					</span>
					@endif
				</div>
				<div class="col-sm-12">
					<button type="submit">Post Comment <i class="fa fa-angle-right"></i></button>
				</div>
			</form>
			@else
			<div class="col-sm-12">
				<p>You must login to post a comment. Already Member <a href="{{ route('login') }}">Login</a> | New <a href="{{ route('register') }}">Register</a></p>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('sidebar')
@include('web.includes.sidebar')
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$(".reply").click(function(){
			var comment_id = $(this).data("id");
			var id = '#reply_form_'+comment_id;

			var url = "{{ route('replayCommentRoute', 'comment_id') }}";
			url = url.replace("comment_id", comment_id);

			$(id).empty();
			$(id).append('<div class="contact-form" style="margin-bottom: 35px;"><div class="row"><form data-parsley-validate action="'+url+'" method="post">{{ csrf_field() }}<input type="hidden" name="post_id" value="{{ $post->id }}"><div class="col-sm-12"><label>Comment <span class="required">*</span></label><textarea name="comment" cols="30" rows="3" required></textarea></div><div class="col-sm-12"><button type="submit">Replay <i class="fa fa-angle-right"></i></button></div></form></div></div>');
		});
	});
</script>
<!-- Social Share: http://js-socials.com/demos/ -->
<script type="text/javascript" src="{{ asset('public/web/jssocials/jssocials.js') }}"></script>
<script type="text/javascript">
	$(function(){
		var url = 'clustercoding.com';
		$("#shareButtonLabel").jsSocials({
			url: url,
			text: "Google Search Page",
			showCount: false,
			showLabel: true,
			shareIn: "popup",
			shares: [
			"email",
			"twitter",
			"facebook",
			"googleplus",
			"linkedin",
			{ share: "pinterest", label: "Pin this" },
			"whatsapp"
			]
		});
	});
</script>
<script type="text/javascript">
	$(function(){
		$("#shareNative").jsSocials({
			showLabel: false,
			showCount: false,

			shares: [{
				renderer: function() {
					var $result = $("<div>");

					var script = document.createElement("script");
					script.text = "(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = \"//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.3\"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));";
					$result.append(script);

					$("<div>").addClass("fb-share-button")
					.attr("data-layout", "button_count")
					.appendTo($result);

					return $result;
				}
			}, {
				renderer: function() {
					var $result = $("<div>");

					var script = document.createElement("script");
					script.src = "https://apis.google.com/js/platform.js";
					$result.append(script);

					$("<div>").addClass("g-plus")
					.attr({
						"data-action": "share",
						"data-annotation": "bubble"
					})
					.appendTo($result);

					return $result;
				}
			}, {
				renderer: function() {
					var $result = $("<div>");

					var script = document.createElement("script");
					script.src = "//platform.linkedin.com/in.js";
					$result.append(script);

					$("<script>").attr({ type: "IN/Share", "data-counter": "right" })
					.appendTo($result);

					return $result;
				}
			}, {
				renderer: function() {
					var $result = $("<div>");

					var script = document.createElement("script");
					script.text = "window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,\"script\",\"twitter-wjs\"));";
					$result.append(script);

					$("<a>").addClass("twitter-share-button")
					.text("Tweet")
					.attr("href", "https://twitter.com/share")
					.appendTo($result);

					return $result;
				}
			}, {
				renderer: function() {
					var $result = $("<div>");

					var script = document.createElement("script");
					script.src = "//assets.pinterest.com/js/pinit.js";
					$result.append(script);

					$("<a>").append($("<img>").attr("//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png"))
					.attr({
						href: "//www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fjs-socials.com%2Fdemos%2F&media=%26quot%3Bhttp%3A%2F%2Fgdurl.com%2Fa653%26quot%3B&description=Next%20stop%3A%20Pinterest",
						"data-pin-do": "buttonPin",
						"data-pin-config": "beside",
						"data-pin-color":"red"
					})
					.appendTo($result);

					return $result;
				}
			}]
		});
	});
</script>
@endsection