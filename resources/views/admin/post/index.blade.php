@extends('admin.layouts.app')
@section('title', 'Post')


@section('style')
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css"> -->

	<link rel="stylesheet" href="{{ asset('public/admin/datatable/css/dataTables.bootstrap.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('public/admin/datatable/css/buttons.dataTables.min.css')}}">
	<style type="text/css">
	.tags .label {
		margin-right: 2px;
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
		<li class="active">Post</li>
	</ol>
</section>
<!-- /.page header -->

<!-- Main content -->
<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Manage Posts</h3>

			<div class="box-tools">
				<a href="{{ route('admin.posts.create') }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> Add Post</a>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div style="width: 100%; padding-left: -10px;">
				<div class="table-responsive">
					<table id="posts-table" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
						<thead>
							<tr>
								<th>Post Title</th>
								<th>Post Slug</th>
								<th>Created By</th>
								<th>Featured Image</th>
								<th>Created At</th>
								<th>Updated At</th>
								<th>Publication Status</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer clearfix">
		</div>
	</div>
</section>
<!-- /.main content -->

<!-- view post modal -->
<div id="view-modal" class="modal fade bs-example-modal-lg print-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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

<!-- delete post modal -->
<div id="delete-modal" class="modal modal-danger fade" id="modal-danger">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						<span class="fa-stack fa-sm">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-trash fa-stack-1x"></i>
						</span>
						Are you sure want to delete this ?
					</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
					<form method="post" role="form" id="delete_form">
						{{csrf_field()}}
						{{method_field('DELETE')}}
						<button type="submit" class="btn btn-outline">Delete</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.delete post modal -->

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
	@endsection

	@section('script')
	<!-- <script type="text/javascript" src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script> -->

	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/datatables.bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/dataTables.buttons.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/buttons.flash.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/pdfmake.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/vfs_fonts.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/buttons.html5.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/buttons.print.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/admin/datatable/js/buttons.colVis.min.js') }}"></script>

	<script type="text/javascript">
		/** Load datatable **/
		$(document).ready(function() {
			get_table_data();
		});

		/** Delete **/
		$("#posts-table").on("click", ".delete-button", function(){
			var post_id = $(this).data("id");
			var url = "{{ route('admin.posts.destroy', 'post_id') }}";
			url = url.replace("post_id", post_id);
			$('#delete-modal').modal('show');
			$('#delete_form').attr('action', url);
		});

		/** View **/
		$("#posts-table").on("click", ".view-button", function(){
			var post_id = $(this).data("id");
			var url = "{{ route('admin.posts.show', 'post_id') }}";
			url = url.replace("post_id", post_id);
			$.ajax({
				url: url,
				method: "GET",
				dataType: "json",
				success:function(data){
					var src = '{{ asset('public/featured_image') }}/';
					$('#view-modal').modal('show');
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

		/** Get datatable **/
		function get_table_data(){
			$('#posts-table').DataTable({
				dom: 'Blfrtip',
				buttons: [
				{ extend: 'copy', exportOptions: { columns: ':visible'}},
				{ extend: 'print', exportOptions: { columns: ':visible'}},
				{ extend: 'pdf', orientation: 'landscape', pageSize: 'A4', exportOptions: { columns: ':visible'}},
				{ extend: 'csv', exportOptions: { columns: ':visible'}},
				{ extend: 'colvis', text:'Column'},
				],
				columnDefs: [ {
					targets: -1,
					visible: true
				} ],
				lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.getPostsRoute') }}",
				columns: [
				{data: 'post_title'},
				{data: 'post_slug'},
				{data: 'username', name: 'username', orderable: true, searchable: true},
				{data: 'featured_image', name: 'featured_image', orderable: true, searchable: true},
				{data: 'created_at'},
				{data: 'updated_at'},
				{data: 'publication_status', name: 'publication_status', orderable: false, searchable: false},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				],
				order: [[4, 'desc']],
			});
		}

		/** User View **/
		$("#posts-table").on("click", ".user-view-button", function(){
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
	</script>
	@endsection