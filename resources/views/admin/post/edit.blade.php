@extends('admin.layouts.app')
@section('title', 'Post')


@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('public/admin/css/bootstrap-datepicker.min.css') }}">
<style type="text/css">
.modal-body {
    position: relative;
    padding: 25px;
}
.modal-content {
    position: relative;
    background-color: #fff;
    border: 1px solid #999;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 6px;
    -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
    box-shadow: 0 3px 9px rgba(0,0,0,.5);
    background-clip: padding-box;
    outline: 0;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
	background-color: #3c8dbc ;
	border: 1px solid #367fa9;
	border-radius: 4px;
	cursor: default;
	float: left;
	margin-right: 5px;
	margin-top: 5px;
	padding: 0 5px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
	color: black;
	cursor: pointer;
	display: inline-block;
	font-weight: bold;
	margin-right: 4px;
}
</style>
@endsection

@section('content')
<!-- Page header -->

<section class="content-header">
	<h1>
		POST
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('admin.dashboardRoute') }}"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="{{ route('admin.posts.index') }}">Post</a></li>
		<li class="active">Edit Post</li>
	</ol>
</section>
<!-- /.page header -->

<!-- Main content -->
<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Edit Post</h3>

			<div class="box-tools">
				<a href="{{ route('admin.posts.index') }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-list"></i> Manage Posts</a>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<form name="post_edit_form" class="form-horizontal" action="{{ route('admin.posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
				{{method_field('PATCH')}}
				{{csrf_field()}}
				<div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
					<label for="post_title" class="col-md-2 control-label">Post Title</label>
					<div class="col-md-9">
						<input type="text" name="post_title" class="form-control" id="post_title" value="{{ $post->post_title }}" placeholder="ex: post title">
						@if ($errors->has('post_title'))
						<span class="help-block">
							<strong>{{ $errors->first('post_title') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('post_slug') ? ' has-error' : '' }}">
					<label for="post_slug" class="col-md-2 control-label">Post Slug</label>
					<div class="col-md-9">
						<input type="text" name="post_slug" class="form-control" id="post_slug" value="{{ $post->post_slug }}" placeholder="ex: post-slug">
						@if ($errors->has('post_slug'))
						<span class="help-block">
							<strong>{{ $errors->first('post_slug') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
					<label for="category_id" class="col-md-2 control-label">Category Name</label>
					<div class="col-md-5">
						<select name="category_id" class="form-control" id="category_id">
							<option value="" selected disabled>Select One</option>
							@foreach($categories as $category)
							<option value="{{ $category->id }}">{{ $category->category_name}}</option>
							@endforeach
						</select>
						@if ($errors->has('category_id'))
						<span class="help-block">
							<strong>{{ $errors->first('category_id') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('post_date') ? ' has-error' : '' }}">
					<label for="post_date" class="col-md-2 control-label">Post Date</label>
					<div class="col-md-5">
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" name="post_date" class="form-control pull-right" id="post_date" value="{{ $post->post_date }}">
						</div>
						@if ($errors->has('post_date'))
						<span class="help-block">
							<strong>{{ $errors->first('post_date') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('publication_status') ? ' has-error' : '' }}">
					<label for="publication_status" class="col-md-2 control-label">Publication Status</label>
					<div class="col-md-5">
						<select name="publication_status" class="form-control" id="publication_status">
							<option value="" selected disabled>Select One</option>
							<option value="1">Published</option>
							<option value="0">Unpublished</option>
						</select>
						@if ($errors->has('publication_status'))
						<span class="help-block">
							<strong>{{ $errors->first('publication_status') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('is_featured') ? ' has-error' : '' }}">
					<label for="is_featured" class="col-md-2 control-label">Is Featured ?</label>
					<div class="col-md-9">
						<label class="radio-inline">
							@php($is_featured = $post->is_featured)
							<input type="radio" name="is_featured" id="is_featured_1" value="1" {{ $is_featured == 1 ? 'checked' : '' }}>Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="is_featured" id="is_featured_2" value="0" {{ $is_featured == 0 ? 'checked' : '' }}>No
						</label>
						@if ($errors->has('is_featured'))
						<span class="help-block">
							<strong>{{ $errors->first('is_featured') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('featured_image') ? ' has-error' : '' }}">
					<label for="featured_image" class="col-md-2 control-label">Featured Image</label>
					<div class="col-md-5">
						<input type="file" name="featured_image" id="featured_image" class="form-control">
						<p class="help-block">Example block-level help text here.</p>
						@if ($errors->has('featured_image'))
						<span class="help-block">
							<strong>{{ $errors->first('featured_image') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('post_tags') ? ' has-error' : '' }}">
					<label for="post_tags" class="col-md-2 control-label">Post Tag</label>
					<div class="col-md-9">
						<select class="form-control select2-post-tag" name="post_tags[]" multiple="multiple" id="post_tags">
							<option disabled>Select Tags</option>
							@foreach($tags as $tag)
							<option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
							@endforeach
						</select>
						@if ($errors->has('post_tags'))
						<span class="help-block">
							<strong>{{ $errors->first('post_tags') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('youtube_video_url') ? ' has-error' : '' }}">
					<label for="youtube_video_url" class="col-md-2 control-label">Youtube Video URL</label>
					<div class="col-md-9">
						<input type="text" name="youtube_video_url" class="form-control" id="youtube_video_url" value="{{ $post->youtube_video_url }}" placeholder="ex: https://www.youtube.com/watch?v=CSGiwf7KlrQ">
						@if ($errors->has('youtube_video_url'))
						<span class="help-block">
							<strong>{{ $errors->first('youtube_video_url') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('post_details') ? ' has-error' : '' }}">
					<label for="post_details" class="col-md-2 control-label">Post Details</label>
					<div class="col-md-9">
						<textarea name="post_details" class="form-control summernote" id="post_details">{{ $post->post_details }}</textarea>
						@if ($errors->has('post_details'))
						<span class="help-block">
							<strong>{{ $errors->first('post_details') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label"></label>
					<div class="col-md-9">
						<div class="bs-callout bs-callout-success">
							<h4>SEO Information</h4>
						</div>
					</div>
				</div>
				<div class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
					<label for="meta_title" class="col-md-2 control-label">Meta Title</label>
					<div class="col-md-9">
						<input type="text" name="meta_title" class="form-control" id="meta_title" value="{{ $post->meta_title }}" placeholder="ex: post title">
						@if ($errors->has('meta_title'))
						<span class="help-block">
							<strong>{{ $errors->first('meta_title') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('meta_keywords') ? ' has-error' : '' }}">
					<label for="meta_keywords" class="col-md-2 control-label">Meta Keywords</label>
					<div class="col-md-9">
						<input type="text" name="meta_keywords" class="form-control" id="meta_keywords" value="{{ $post->meta_keywords }}" placeholder="ex: post, title">
						@if ($errors->has('meta_keywords'))
						<span class="help-block">
							<strong>{{ $errors->first('meta_keywords') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
					<label for="meta_description" class="col-md-2 control-label">Meta Description</label>
					<div class="col-md-9">
						<textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="ex: post dscription">{{ $post->meta_description }}</textarea>
						@if ($errors->has('meta_description'))
						<span class="help-block">
							<strong>{{ $errors->first('meta_description') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<button type="submit" class="btn btn-info btn-flat">Edit Post</button>
					</div>
				</div>
			</form>
		</div>
		<!-- /.box-body -->
		<div class="box-footer clearfix">
		</div>
	</div>
</section>
<!-- /.main content -->
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.select2-post-tag').select2();
		$('.select2-post-tag').select2().val({!! json_encode($post->tags()->pluck('tag_id')) !!}).trigger('change');
	});
</script>
<script type="text/javascript" src="{{ asset('public/admin/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$(function () {
		var date = new Date();
		//date.setDate(date.getDate()-1);
        $('#post_date').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            startDate: date,
        });
	});
</script>
<script type="text/javascript">
	$(function(){
	$('.summernote').summernote({
		height: 200
	})
})
</script>
<script type="text/javascript">
	document.forms['post_edit_form'].elements['category_id'].value = "{{ $post->category->id }}";
	document.forms['post_edit_form'].elements['publication_status'].value = "{{ $post->publication_status }}";
</script>
@endsection