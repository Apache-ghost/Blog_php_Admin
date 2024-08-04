@extends('admin.layouts.app')
@section('title', 'Dashboard')


@section('style')
<style type="text/css">
.modal-title {
	font-weight: bold;
}
.bg-grey{
	background-color: #BDBDBD;
}
.users-list>li {
	width: 10%;
}
</style>
@endsection

@section('content')
<!-- Page header -->
<section class="content-header">
	<h1>
		DASHBOARD
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('admin.dashboardRoute') }}"><i class="fa fa-home active"></i> Dashboard</a></li>
	</ol>
</section>
<!-- /.page header -->

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_categories->count() }}</h3>

					<p>CATEGORY</p>
				</div>
				<div class="icon">
					<i class="fa fa-paper-plane"></i>
				</div>
				<a href="{{ route('admin.categories.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_tags->count() }}</h3>

					<p>TAG</p>
				</div>
				<div class="icon">
					<i class="fa fa-tag"></i>
				</div>
				<a href="{{ route('admin.tags.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_posts->count() }}</h3>

					<p>POST</p>
				</div>
				<div class="icon">
					<i class="fa fa-newspaper-o"></i>
				</div>
				<a href="{{ route('admin.posts.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_users->count() }}</h3>

					<p>USER</p>
				</div>
				<div class="icon">
					<i class="fa fa-users"></i>
				</div>
				<a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_comments->count() }}</h3>

					<p>COMMENT</p>
				</div>
				<div class="icon">
					<i class="fa fa-comment"></i>
				</div>
				<a href="{{ route('admin.comments.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_subscribers->count() }}</h3>

					<p>SUBSCRIBER</p>
				</div>
				<div class="icon">
					<i class="fa fa-envelope"></i>
				</div>
				<a href="{{ route('admin.subscribers.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_pages->count() }}</h3>

					<p>PAGE</p>
				</div>
				<div class="icon">
					<i class="fa fa-file"></i>
				</div>
				<a href="{{ route('admin.pages.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-grey">
				<div class="inner">
					<h3>{{ $all_galleries->count() }}</h3>

					<p>GALLERY</p>
				</div>
				<div class="icon">
					<i class="fa fa-image"></i>
				</div>
				<a href="{{ route('admin.galleries.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Recent Posts</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="box-footer box-comments">
						@foreach($posts as $post)
						<div class="box-comment">
							<!-- User image -->
							@if(!empty($post->user->avatar))
							<img class="img-circle img-sm" alt="{{ $post->user->name }}" src="{{ asset('public/avatar/' . $post->user->avatar) }}" width="35px">
							@else
							<img class="img-circle img-sm" alt="{{ $post->user->name }}" src="{{ get_gravatar($post->user->email) }}" width="35px">
							@endif

							<div class="comment-text">
								<span class="username">
									<a class="user-view-button" data-id="{{ $post->user->id }}" role="button" tabindex="0">{{ $post->user->name }}</a>
									<span class="text-muted pull-right"><strong>{{ date("d F Y - h:ia", strtotime($post->created_at)) }}</strong></span>
								</span><!-- /.username -->
								<p><a class="post-view-button" role="button" tabindex="0" data-id="{{ $post->id }}">{{ str_limit($post->post_title, 100) }}</a></p>
							</div>
							<!-- /.comment-text -->
						</div>
						<!-- /.box-comment -->
						@endforeach
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer clearfix">
					<a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-info btn-flat pull-right">View All</a>
				</div>
			</div>
			<!-- /.box -->
		</div>

		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Recent Comments</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="box-footer box-comments">
						@foreach($comments as $comment)
						<div class="box-comment">
							<!-- User image -->
							@if(!empty($comment->user->avatar))
							<img class="img-circle img-sm" alt="{{ $comment->user->name }}" src="{{ asset('public/avatar/' . $comment->user->avatar) }}" width="35px">
							@else
							<img class="img-circle img-sm" alt="{{ $comment->user->name }}" src="{{ get_gravatar($comment->user->email) }}" width="35px">
							@endif

							<div class="comment-text">
								<span class="username">
									<a role="button" tabindex="0" class="user-view-button" data-id="{{ $comment->user->id }}">{{ $comment->user->name }}</a>
									<span class="text-muted pull-right"><strong>{{ date("d F Y - h:ia", strtotime($comment->created_at)) }}</strong></span>
								</span><!-- /.username -->
								{!! str_limit($comment->comment, 100) !!}
							</div>
							<!-- /.comment-text -->
						</div>
						<!-- /.box-comment -->
						@endforeach
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer clearfix">
					<a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-info btn-flat pull-right">View All</a>
				</div>
			</div>
			<!-- /.box -->
		</div>

		<div class="col-md-12">
			<!-- USERS LIST -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Recent Users</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
					<ul class="users-list clearfix">
						@foreach($users as $user)
						<li>
							@if(!empty($user->avatar))
							<img class="img-responsive" alt="{{ $user->name }}" src="{{ asset('public/avatar/' . $user->avatar) }}" width="128px">
							@else
							<img class="img-responsive" alt="{{ $user->name }}" src="{{ get_gravatar($user->email) }}" width="128px">
							@endif
							<a class="users-list-name user-view-button" data-id="{{ $user->id }}" role="button" tabindex="0">{{ $user->name }}</a>
							<span class="users-list-date">{{ date("d F Y", strtotime($user->created_at)) }}</span>
						</li>
						@endforeach
					</ul>
					<!-- /.users-list -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-info btn-flat pull-right">View All</a>
				</div>
				<!-- /.box-footer -->
			</div>
			<!--/.box -->
		</div>

		<!-- view user modal -->
		<div id="user-view-modal" class="modal fade bs-example-modal-lg print-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="btn-group pull-right no-print">
							<div class="btn-group">
								<button class="tip btn btn-default btn-flat btn-sm" id="print-button" data-toggle="tooltip" data-original-title="Print">
									<i class="fa fa-print"></i>
									<span class="hidden-sm hidden-xs"></span>
								</button>
							</div>
							<div class="btn-group">
								<button class="tip btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-original-title="Close" data-dismiss="modal" aria-label="Close">
									<i class="fa fa-remove"></i>
									<span class="hidden-sm hidden-xs"></span>
								</button>
							</div>
						</div>
						<h4 class="modal-title" id="view-name"></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-9">
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<td width="20%">Role</td>
											<td id="view-role"></td>
										</tr>
										<tr>
											<td>Username</td>
											<td id="view-username"></td>
										</tr>
										<tr>
											<td>Email</td>
											<td id="view-email"></td>
										</tr>
										<tr>
											<td>Gender</td>
											<td id="view-gender"></td>
										</tr>
										<tr>
											<td>Phone</td>
											<td id="view-phone"></td>
										</tr>
										<tr>
											<td>Address</td>
											<td id="view-address"></td>
										</tr>
										<tr>
											<td>Facebook</td>
											<td id="view-facebook"></td>
										</tr>
										<tr>
											<td>Twitter</td>
											<td id="view-twitter"></td>
										</tr>
										<tr>
											<td>Google Plus</td>
											<td id="view-google-plus"></td>
										</tr>
										<tr>
											<td>Linkedin</td>
											<td id="view-linkedin"></td>
										</tr>
										<tr>
											<td>Status</td>
											<td id="view-status"></td>
										</tr>
										<tr>
											<td>About</td>
											<td id="view-about"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-3">
								<img id="view-avatar" class="img-responsive img-thumbnail img-rounded">
							</div>
						</div>
					</div>
					<div class="modal-footer no-print">
						<button type="button" class="btn btn-default btn-flat" data-dismiss="modal" aria-label="Close">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.view user modal -->

		<!-- view post modal -->
		<div id="view-post-modal" class="modal fade bs-example-modal-lg print-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="btn-group pull-right no-print">
							<div class="btn-group">
								<button class="tip btn btn-default btn-flat btn-sm" id="print-button" data-toggle="tooltip" data-original-title="Print">
									<i class="fa fa-print"></i>
									<span class="hidden-sm hidden-xs"></span>
								</button>
							</div>
							<div class="btn-group">
								<button class="tip btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-original-title="Close" data-dismiss="modal" aria-label="Close">
									<i class="fa fa-remove"></i>
									<span class="hidden-sm hidden-xs"></span>
								</button>
							</div>
						</div>
						<h4 class="modal-title" id="view-post-title"></h4>
					</div>
					<div class="modal-body">
						<table class="table table-bordered table-striped">
							<tbody>
								<tr>
									<td colspan="2"><img src="" id="view-featured-image" class="img-responsive img-thumbnail img-rounded" width="100%"></td>
								</tr>
								<tr>
									<td width="20%">Post Slug</td>
									<td id="view-post-slug"></td>
								</tr>
								<tr>
									<td>Post Category</td>
									<td id="view-post-category"></td>
								</tr>
								<tr>
									<td>Post Date</td>
									<td id="view-post-date"></td>
								</tr>
								<tr>
									<td>Post Created By</td>
									<td id="view-post-created-by"></td>
								</tr>
								<tr>
									<td>Publication Status</td>
									<td id="view-publication-status"></td>
								</tr>
								<tr>
									<td>Meta Title</td>
									<td id="view-meta-title"></td>
								</tr>
								<tr>
									<td>Meta Keywords</td>
									<td id="view-meta-keywords"></td>
								</tr>
								<tr>
									<td>Meta Description</td>
									<td id="view-meta-description"></td>
								</tr>
								<tr>
									<td>Post Tags</td>
									<td id="view-post-tags"><div class="tags"></div></td>
								</tr>
								<tr>
									<td>Post Details</td>
									<td id="view-post-details"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer no-print">
						<button type="button" class="btn btn-default btn-flat" data-dismiss="modal" aria-label="Close">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.view post modal -->

	</section>
	<!-- /.main content -->
	@endsection

	@section('script')
	<script type="text/javascript">
		/** User View **/
		$(".user-view-button").click(function(){
			var id = $(this).data("id");
			var url = "{{ route('admin.users.show', 'id') }}";
			url = url.replace("id", id);
			$.ajax({
				url: url,
				method: "GET",
				dataType: "json",
				success:function(data){
					var src = '{{ asset('public/avatar') }}/';
					var default_avatar = '{{ asset('public/avatar/user.png') }}';
					$('#user-view-modal').modal('show');

					$('#view-name').text(data['name']);
					$('#view-username').text(data['username']);
					$('#view-email').text(data['email']);
					$("#view-avatar").attr("src", src+data['avatar']);
					if(data['avatar']){
						$("#view-avatar").attr("src", src+data['avatar']);
					}else{
						$("#view-avatar").attr("src", default_avatar);
					}
					if(data['gender'] == 'm'){
						$('#view-gender').text('Male');
					}else{
						$('#view-gender').text('Female');
					}
					$('#view-phone').text(data['phone']);
					$('#view-address').text(data['address']);
					$('#view-facebook').text(data['facebook']);
					$('#view-twitter').text(data['twitter']);
					$('#view-google-plus').text(data['google_plus']);
					$('#view-linkedin').text(data['linkedin']);
					$('#view-about').text(data['about']);
					if(data['role'] == 'admin'){
						$('#view-role').text('Admin');
					}else{
						$('#view-role').text('User');
					}
					if(data['activation_status'] == 1){
						$('#view-status').text('Active');
					}else{
						$('#view-status').text('Block');
					}
				}});
		});

		/** Post View **/
		$(".post-view-button").click(function(){
			var post_id = $(this).data("id");
			var url = "{{ route('admin.posts.show', 'post_id') }}";
			url = url.replace("post_id", post_id);
			$.ajax({
				url: url,
				method: "GET",
				dataType: "json",
				success:function(data){
					var src = '{{ asset('public/featured_image') }}/';
					$('#view-post-modal').modal('show');
					$('#view-post-title').text(data['post_title']);
					$('#view-post-slug').text(data['post_slug']);
					$('#view-post-date').text(data['post_date']);
					$('#view-post-details').text($(data['post_details']).text());
					$("#view-featured-image").attr("src", src+data['featured_image']);
					$('#view-post-category').text(data['category']['category_name']);
					$('#view-post-created-by').text(data['user']['name']);
					if(data['publication_status'] == 1){
						$('#view-publication-status').text('Published');
					}else{
						$('#view-publication-status').text('Unpublished');
					}
					$('#view-meta-title').text(data['meta_title']);
					$('#view-meta-keywords').text(data['meta_keywords']);
					$('#view-meta-description').text($(data['meta_description']).text());

					var tags = "";
					for (var key in data['tags']) {
						if (data['tags'].hasOwnProperty(key)) {
							tags += "<span class='label label-primary'>"+ data['tags'][key]["tag_name"] +"</span>";
						}
					}
					$("#view-post-tags .tags").html(tags);
				}});
		});
	</script>
	@endsection