@extends('admin.layouts.app')
@section('title', 'Page')


@section('style')
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css"> -->

	<link rel="stylesheet" href="{{ asset('public/admin/datatable/css/dataTables.bootstrap.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('public/admin/datatable/css/buttons.dataTables.min.css')}}">
	<style type="text/css">
	.modal-title{
		font-weight: bold;
	}
</style>
@endsection

@section('content')
<!-- Page header -->
<section class="content-header">
	<h1>
		PAGE
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('admin.dashboardRoute') }}"><i class="fa fa-home"></i> Dashboard</a></li>
		<li class="active">Page</li>
	</ol>
</section>
<!-- /.page header -->

<!-- Main content -->
<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Manage Pages</h3>

			<div class="box-tools">
				<button type="button" class="btn btn-info btn-sm btn-flat add-button"><i class="fa fa-plus"></i> Add Page</button>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div style="width: 100%; padding-left: -10px;">
				<div class="table-responsive">
					<table id="pages-table" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
						<thead>
							<tr>
								<th>Page Name</th>
								<th>Page Slug</th>
								<th>Created By</th>
								<th>Image</th>
								<th>Created At</th>
								<th>Updated At</th>
								<th width="10%">Publication Status</th>
								<th width="7%">Action</th>
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

<!-- add page modal -->
<div id="add-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						<span class="fa-stack fa-sm">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-plus fa-stack-1x"></i>
						</span>
						Add Page
					</h4>
				</div>
				<form role="form" id="page_add_form" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="form-group">
							<label for="page_name">Page Name</label>
							<input type="text" name="page_name" class="form-control" id="page_name" value="{{ old('page_name') }}" placeholder="ex: page">
							<span class="text-danger" id="page-name-error"></span>
						</div>
						<div class="form-group">
							<label for="page_slug">Page Slug</label>
							<input type="text" name="page_slug" class="form-control" id="page_slug" value="{{ old('page_slug') }}" placeholder="ex: page_slug">
							<span class="text-danger" id="page-slug-error"></span>
						</div>
						<div class="form-group">
							<label for="page_content">Page Content</label>
							<textarea name="page_content" class="form-control add-summernote" id="page_content" placeholder="ex: page content">{{ old('page_content') }}</textarea>
							<span class="text-danger" id="page-content-error"></span>
						</div>
						<div class="form-group">
							<label for="page_featured_image">Page Featured Image</label>
							<input type="file" name="page_featured_image" id="page_featured_image" class="form-control">
							<span class="text-danger" id="page-featured-image-error"></span>
						</div>
						<div class="form-group">
							<label>Publication Status</label>
							<select class="form-control" name="publication_status" id="publication_status">
								<option selected disabled>Select One</option>
								<option value="1">Published</option>
								<option value="0">Unpublished</option>
							</select>
							<span class="text-danger" id="publication-status-error"></span>
						</div>

						<div class="bs-callout bs-callout-success">
							<h4>SEO Information</h4>
						</div>

						<div class="form-group">
							<label for="meta_title">Meata Title</label>
							<input type="text" name="meta_title" class="form-control" id="meta_title" value="{{ old('meta_title') }}" placeholder="ex: page title">
							<span class="text-danger" id="meta-title-error"></span>
						</div>
						<div class="form-group">
							<label for="meta_keywords">Meata Keywords</label>
							<input type="text" name="meta_keywords" class="form-control" id="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="ex: page, title">
							<span class="text-danger" id="meta-keywords-error"></span>
						</div>
						<div class="form-group">
							<label for="meta_description">Meta Description</label>
							<textarea name="meta_description" class="form-control" id="meta_description" rows="3" placeholder="ex: page dscription">{{ old('meta_description') }}</textarea>
							<span class="text-danger" id="meta-description-error"></span>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-info btn-flat" id="store-button">Save changes</button>
					</div>
				</form>

			</div>
		</div>
	</div>
	<!-- /.add page modal -->

	<!-- view page modal -->
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
					<h4 class="modal-title" id="view-page-name"></h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered table-striped">
						<tbody>
							<tr>
								<td colspan="2"><img src="" id="view-page-featured-image" class="img-responsive img-thumbnail img-rounded" width="100%"></td>
							</tr>
							<tr>
								<td width="20%">Page Slug</td>
								<td id="view-page-slug"></td>
							</tr>
							<tr>
								<td>Page Content</td>
								<td id="view-page-content"></td>
							</tr>
							<tr>
								<td>Created By</td>
								<td id="view-created-by"></td>
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
						</tbody>
					</table>
				</div>
				<div class="modal-footer no-print">
					<button type="button" class="btn btn-default btn-flat" data-dismiss="modal" aria-label="Close">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /.view page modal -->

	<!-- delete page modal -->
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
		<!-- /.delete page modal -->


		<!-- edit page modal -->
		<div id="edit-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">
								<span class="fa-stack fa-sm">
									<i class="fa fa-square-o fa-stack-2x"></i>
									<i class="fa fa-edit fa-stack-1x"></i>
								</span>
								Edit Page
							</h4>
						</div>
						<form role="form" id="page_edit_form" method="post" enctype="multipart/form-data">
							{{method_field('PATCH')}}
							{{csrf_field()}}
							<input type="hidden" name="page_id" id="edit-page-id">
							<div class="modal-body">
								<div class="form-group">
									<label for="page_name">Page Name</label>
									<input type="text" name="page_name" class="form-control" id="edit-page-name" placeholder="ex: page">
									<span class="text-danger page-name-error"></span>
								</div>
								<div class="form-group">
									<label for="page_slug">Page Slug</label>
									<input type="text" name="page_slug" class="form-control" id="edit-page-slug" placeholder="ex: page_slug">
									<span class="text-danger page-slug-error"></span>
								</div>
								<div class="form-group">
									<label for="page_content">Page Content</label>
									<textarea name="page_content" class="form-control summernote" id="edit-page-content" placeholder="ex: page content"></textarea>
									<span class="text-danger page-content-error"></span>
								</div>
								<div class="form-group">
									<label for="page_featured_image">Page Featured Image</label>
									<input type="file" name="page_featured_image" id="edit-page-featured-image" class="form-control">
									<span class="text-danger page-featured-image-error"></span>
								</div>
								<div class="form-group">
									<label>Publication Status</label>
									<select class="form-control" name="publication_status" id="edit-publication-status">
										<option selected disabled>Select One</option>
										<option value="1">Published</option>
										<option value="0">Unpublished</option>
									</select>
									<span class="text-danger publication-status-error"></span>
								</div>

								<div class="bs-callout bs-callout-success">
									<h4>SEO Information</h4>
								</div>

								<div class="form-group">
									<label for="meta_title">Meata Title</label>
									<input type="text" name="meta_title" class="form-control" id="edit-meta-title" placeholder="ex: page title">
									<span class="text-danger meta-title-error"></span>
								</div>
								<div class="form-group">
									<label for="meta_keywords">Meata Keywords</label>
									<input type="text" name="meta_keywords" class="form-control" id="edit-meta-keywords" placeholder="ex: page, title">
									<span class="text-danger meta-keywords-error"></span>
								</div>
								<div class="form-group">
									<label for="meta_description">Meta Description</label>
									<textarea name="meta_description" class="form-control" id="edit-meta-description" rows="3" placeholder="ex: page dscription"></textarea>
									<span class="text-danger meta-description-error"></span>
								</div>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-info btn-flat update-button">Update</button>
							</div>
						</form>

					</div>
				</div>
			</div>
			<!-- /.edit page modal -->

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

	<!-- editor -->
	<script type="text/javascript">
		$(function(){
			$('.summernote').summernote({
				height: 200
			})
		});
		$(function(){
			$('.add-summernote').summernote({
				height: 200,
				placeholder: "ex: page content"
			})
		})
	</script>
	<!-- /.editor -->

	<script type="text/javascript">
		/** Load datatable **/
		$(document).ready(function() {
			get_table_data();
		});

		/** Edit **/
		$("#pages-table").on("click", ".edit-button", function(){
			var page_id = $(this).data("id");
			var url = "{{ route('admin.pages.show', 'page_id') }}";
			url = url.replace("page_id", page_id);
			$.ajax({
				url: url,
				method: "GET",
				dataType: "json",
				success:function(data){
					$('#edit-modal').modal('show');
					$('#edit-page-id').val(data['id']);
					$('#edit-page-name').val(data['page_name']);
					$('#edit-page-slug').val(data['page_slug']);
					$(".summernote").summernote("code", data['page_content']);
					$('#edit-publication-status').val(data['publication_status']);
					$('#edit-meta-title').val(data['meta_title']);
					$('#edit-meta-keywords').val(data['meta_keywords']);
					$('#edit-meta-description').val(data['meta_description']);
				}});
		});

		/** Update **/
		$(".update-button").click(function(){
			var page_id = $('#edit-page-id').val();
			var url = "{{ route('admin.pages.update', 'page_id') }}";
			url = url.replace("page_id", page_id);
			// var page_edit_form = $("#page_edit_form");
			// var form_data = page_edit_form.serialize();
			var postData = new FormData($("#page_edit_form")[0]);
			$( '.page-name-error' ).html( "" );
			$( '.page-slug-error' ).html( "" );
			$( '.page-content-error' ).html( "" );
			$( '.page-featured-image-error' ).html( "" );
			$( '.publication-status-error' ).html( "" );
			$( '.meta-title-error' ).html( "" );
			$( '.meta-keywords-error' ).html( "" );
			$( '.meta-description-error' ).html( "" );
			$.ajax({
				type:'POST',
				url: url,
				processData: false,
				contentType: false,
				data : postData,
				success:function(data) {
					console.log(data);
					if(data.errors) {
						if(data.errors.page_name){
							$( '.page-name-error' ).html( data.errors.page_name[0] );
						}
						if(data.errors.page_slug){
							$( '.page-slug-error' ).html( data.errors.page_slug[0] );
						}
						if(data.errors.page_content){
							$( '.page-content-error' ).html( data.errors.page_content[0] );
						}
						if(data.errors.page_featured_image){
							$( '.page-featured-image-error' ).html( data.errors.page_featured_image[0] );
						}
						if(data.errors.publication_status){
							$( '.publication-status-error' ).html( data.errors.publication_status[0] );
						}
						if(data.errors.meta_title){
							$( '.meta-title-error' ).html( data.errors.meta_title[0] );
						}
						if(data.errors.meta_keywords){
							$( '.meta-keywords-error' ).html( data.errors.meta_keywords[0] );
						}
						if(data.errors.meta_description){
							$( '.meta-description-error' ).html( data.errors.meta_description[0] );
						}
					}
					if(data.success) {
						window.location.href = '{{ route('admin.pages.index') }}';
					}
				},
			});
		});

		/** Delete **/
		$("#pages-table").on("click", ".delete-button", function(){
			var page_id = $(this).data("id");
			var url = "{{ route('admin.pages.destroy', 'page_id') }}";
			url = url.replace("page_id", page_id);
			$('#delete-modal').modal('show');
			$('#delete_form').attr('action', url);
		});

		/** View **/
		$("#pages-table").on("click", ".view-button", function(){
			var page_id = $(this).data("id");
			var url = "{{ route('admin.pages.show', 'page_id') }}";
			url = url.replace("page_id", page_id);
			$.ajax({
				url: url,
				method: "GET",
				dataType: "json",
				success:function(data){
					var src = '{{ get_page_featured_image_url() }}/';
					var no_image = '{{ get_page_featured_image_url('no_image.jpg') }}';
					$('#view-modal').modal('show');
					$('#view-page-name').text(data['page_name']);
					$('#view-page-slug').text(data['page_slug']);
					$('#view-page-content').text($(data['page_content']).text());
					$('#view-created-by').text(data['user']['name']);
					if(data['page_featured_image']){
						$("#view-page-featured-image").attr("src", src+data['page_featured_image']);
					}else{
						$("#view-page-featured-image").attr("src", no_image);
					}
					if(data['publication_status'] == 1){
						$('#view-publication-status').text('Published');
					}else{
						$('#view-publication-status').text('Unpublished');
					}
					$('#view-meta-title').text(data['meta_title']);
					$('#view-meta-keywords').text(data['meta_keywords']);
					$('#view-meta-description').text(data['meta_description']);
				}});
		});

		/** Add **/
		$(".add-button").click(function(){
			$('#add-modal').modal('show');
		});

		/** Store **/
		$("#store-button").click(function(){
			var postData = new FormData($("#page_add_form")[0]);
			$( '#page-name-error' ).html( "" );
			$( '#page-slug-error' ).html( "" );
			$( '#page-content-error' ).html( "" );
			$( '#page-featured-image-error' ).html( "" );
			$( '#publication-status-error' ).html( "" );
			$( '#meta-title-error' ).html( "" );
			$( '#meta-keywords-error' ).html( "" );
			$( '#meta-description-error' ).html( "" );
			$.ajax({
				type:'POST',
				url:'{{ route('admin.pages.store') }}',
				processData: false,
				contentType: false,
				data : postData,
				success:function(data) {
					console.log(data);
					if(data.errors) {
						if(data.errors.page_name){
							$( '#page-name-error' ).html( data.errors.page_name[0] );
						}
						if(data.errors.page_slug){
							$( '#page-slug-error' ).html( data.errors.page_slug[0] );
						}
						if(data.errors.page_content){
							$( '#page-content-error' ).html( data.errors.page_content[0] );
						}
						if(data.errors.page_featured_image){
							$( '#page-featured-image-error' ).html( data.errors.page_featured_image[0] );
						}
						if(data.errors.publication_status){
							$( '#publication-status-error' ).html( data.errors.publication_status[0] );
						}
						if(data.errors.meta_title){
							$( '#meta-title-error' ).html( data.errors.meta_title[0] );
						}
						if(data.errors.meta_keywords){
							$( '#meta-keywords-error' ).html( data.errors.meta_keywords[0] );
						}
						if(data.errors.meta_description){
							$( '#meta-description-error' ).html( data.errors.meta_description[0] );
						}
					}
					if(data.success) {
						window.location.href = '{{ route('admin.pages.index') }}';
					}
				},
			});
		});

		/** Get datatable **/
		function get_table_data(){
			$('#pages-table').DataTable({
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
				ajax: "{{ route('admin.getPagesRoute') }}",
				columns: [
				{data: 'page_name'},
				{data: 'page_slug'},
				{data: 'username', name: 'username', orderable: true, searchable: true},
				{data: 'page_featured_image', name: 'page_featured_image', orderable: false, searchable: false},
				{data: 'created_at'},
				{data: 'updated_at'},
				{data: 'publication_status', name: 'publication_status', orderable: false, searchable: false},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				],
				order: [[4, 'desc']],
			});
		}

		/** User View **/
		$("#pages-table").on("click", ".user-view-button", function(){
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