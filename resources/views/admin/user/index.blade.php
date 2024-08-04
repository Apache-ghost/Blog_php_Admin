@extends('admin.layouts.app')
@section('title', 'Users')


@section('style')
<style>
.modal-title {
	font-weight: bold;
}
.social {
	padding: 5px;
	font-size: 12px;
	width: 24px;
	text-align: center;
	text-decoration: none;
	margin: 0px 2px;
}

.social:hover {
	opacity: 0.7;
}

.facebook {
	background: #3B5998;
	color: white;
}

.twitter {
	background: #55ACEE;
	color: white;
}

.google {
	background: #dd4b39;
	color: white;
}

.linkedin {
	background: #007bb5;
	color: white;
}
.edit {
	background: #007bb5;
	color: white;
}
.view {
	background: #55ACEE;
	color: white;
}
.delete {
	background: #dd4b39;
	color: white;
}
.bg-custom-purple{
	background-color: #D1C4E9;
}
</style>
@endsection

@section('content')
<!-- Page header -->
<section class="content-header">
	<h1>
		USERS
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('admin.dashboardRoute') }}"><i class="fa fa-home"></i> Dashboard</a></li>
		<li class="active">Users</li>
	</ol>
</section>
<!-- /.page header -->

<!-- Main content -->
<section class="content">

	<div class="row">
		@foreach($users as $user)
		<div class="col-md-4">
			<!-- Widget: user widget style 1 -->
			<div class="box box-widget widget-user">
				<!-- Add the bg color to the header using any of the bg-* classes -->
				<!-- <div class="widget-user-header bg-aqua-active"> -->
					<div class="widget-user-header bg-custom-purple">
						<h3 class="widget-user-username">{{ $user->name }}</h3>
						<h5 class="widget-user-desc">{{ $user->email }}</h5>
						<h5 class="widget-user-desc">
							@if($user->role == 'admin')
							<span>Admin</span>
							@elseif($user->role == 'author')
							<span>Author</span>
							@else 
							<span>User</span>
							@endif
						</h5>
					</div>
					<div class="widget-user-image">
						@if(!empty($user->avatar))
						<img class="img-circle" src="{{ asset('public/avatar/' . $user->avatar) }}" alt="{{ $user->name }}">
						@else
						<img class="img-circle" src="{{ asset('public/avatar/user.png') }}" alt="{{ $user->name }}">
						@endif
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-sm-12">
								<div class="description-block">
									@if($user->activation_status == 1)
									<h5 class="text-success"><i class="fa fa-unlock"></i> Active</h5>
									@else
									<h5 class="text-danger"><i class="fa fa-lock"></i> Block</h5>
									@endif
									<div class="pull-left">
										@if(!empty($user->facebook))
										<a href="{{ $user->facebook }}" target="_blank" class="fa fa-facebook social facebook"></a>
										@endif
										@if(!empty($user->twitter))
										<a href="{{ $user->twitter }}" target="_blank" class="fa fa-twitter social twitter"></a>
										@endif
										@if(!empty($user->google_plus))
										<a href="{{ $user->google_plus }}" target="_blank" class="fa fa-google-plus social google"></a>
										@endif
										@if(!empty($user->linkedin))
										<a href="{{ $user->linkedin }}" target="_blank" class="fa fa-linkedin social linkedin"></a>
										@endif
									</div>
									<div class="pull-right">
										<button class="btn btn-default btn-xs btn-flat view-button" data-id="{{ $user->id }}" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></button>
										<button class="btn btn-default btn-xs btn-flat edit-button" data-id="{{ $user->id }}" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></button>
										<button class="btn btn-default btn-xs btn-flat delete-button" data-id="{{ $user->id }}" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>
									</div>
								</div>
								<!-- /.description-block -->
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
				</div>
				<!-- /.widget-user -->
			</div>
			<!-- /.col -->
			@endforeach
			<div class="col-md-12 text-center">
				{{ $users->links() }}
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

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

		<!-- edit category modal -->
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
								Upadte User
							</h4>
						</div>
						<form role="form" id="user_edit_form" method="post">
							{{method_field('PATCH')}}
							{{csrf_field()}}
							<input type="hidden" name="id" id="edit-user-id">
							<div class="modal-body">
								<div class="form-group">
									<label>Role</label>
									<select class="form-control" name="role" id="edit-role">
										<option selected disabled>Select One</option>
										<option value="admin">Admin</option>
										<option value="author">Author</option>
										<option value="user">User</option>
									</select>
									<span class="text-danger role-error"></span>
								</div>

								<div class="form-group">
									<label>Activation Status</label>
									<select class="form-control" name="activation_status" id="edit-activation-status">
										<option selected disabled>Select One</option>
										<option value="1">Active</option>
										<option value="0">Block</option>
									</select>
									<span class="text-danger activation-status-error"></span>
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
			<!-- /.edit category modal -->
			@endsection

			@section('script')
			<script type="text/javascript">

				/** Edit **/
				$(".edit-button").click(function(){
					var id = $(this).data("id");
					var url = "{{ route('admin.users.show', 'id') }}";
					url = url.replace("id", id);
					$.ajax({
						url: url,
						method: "GET",
						dataType: "json",
						success:function(data){
							$('#edit-modal').modal('show');
							$('#edit-user-id').val(data['id']);
							$('#edit-role').val(data['role']);
							$('#edit-activation-status').val(data['activation_status']);
						}});
				});

				/** Update **/
				$(".update-button").click(function(){
					var id = $('#edit-user-id').val();
					var url = "{{ route('admin.users.update', 'id') }}";
					url = url.replace("id", id);
					var user_edit_form = $("#user_edit_form");
					var form_data = user_edit_form.serialize();
					$( '.role-error' ).html( "" );
					$( '.activation-status-error' ).html( "" );
					$.ajax({
						url: url,
						type:'POST',
						data:form_data,
						success:function(data) {
							console.log(data);
							if(data.errors) {
								if(data.errors.role){
									$( '.role-error' ).html( data.errors.role[0] );
								}
								if(data.errors.activation_status){
									$( '.activation-status-error' ).html( data.errors.activation_status[0] );
								}
							}
							if(data.success) {
								window.location.href = '{{ route('admin.users.index') }}';
							}
						},
					});
				});

				/** View **/
				$(".view-button").click(function(){
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
							$('#view-modal').modal('show');

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

				/** Delete **/
				$(".delete-button").click(function(){
					var id = $(this).data("id");
					var url = "{{ route('admin.users.destroy', 'id') }}";
					url = url.replace("id", id);
					$('#delete-modal').modal('show');
					$('#delete_form').attr('action', url);
				});
			</script>
			@endsection