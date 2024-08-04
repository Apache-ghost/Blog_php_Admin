@extends('admin.layouts.app')
@section('title', 'Setting')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/parsley.css') }}">
<style>
.social {
	padding: 5px;
	font-size: 12px;
	width: 24px;
	text-align: center;
	text-decoration: none;
	margin: 5px 2px;
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
.tab-pane{
	margin-top: 30px
}
</style>
@endsection

@section('content')
<!-- Page header -->
<section class="content-header">
	<h1>
		PROFILE
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('admin.dashboardRoute') }}"><i class="fa fa-home"></i> Dashboard</a></li>
		<li class="active">Profile</li>
	</ol>
</section>
<!-- /.page header -->

<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-md-3">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					@if(!empty($user->avatar))
					<img class="profile-user-img img-responsive img-circle" src="{{ asset('public/avatar/' . $user->avatar) }}" alt="{{ Auth::user()->name }}">
					@else
					<img class="profile-user-img img-responsive img-circle" src="{{ asset('public/avatar/user.png') }}" alt="{{ Auth::user()->name }}">
					@endif
					<h3 class="profile-username text-center">{{ $user->name }}</h3>

					<p class="text-muted text-center">{{ isAdmin() ? 'Admin' : 'User' }}</p>
					<hr>
					<div class="text-center">
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
					<hr>
					<strong><i class="fa fa-user margin-r-5"></i> Username</strong>
					<p class="text-muted">{{ $user->name }}</p>
					<hr>
					<strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
					<p class="text-muted">{{ $user->email }}</p>
					<hr>
					@if(!empty($user->gender))
					@if($user->gender == 'm')
					<strong><i class="fa fa-male margin-r-5"></i> Gender</strong>
					<p class="text-muted">Male</p>
					@elseif($user->gender == 'f')
					<strong><i class="fa fa-female margin-r-5"></i> Gender</strong>
					<p class="text-muted">Female</p>
					@endif
					<hr>
					@endif
					
					@if(!empty($user->phone))
					<strong><i class="fa fa-phone margin-r-5"></i> Phone</strong>
					<p class="text-muted">{{ $user->phone }}</p>
					<hr>
					@endif

					@if(!empty($user->address))
					<strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
					<p class="text-muted">{{ $user->address }}</p>
					<hr>
					@endif

					@if(!empty($user->about))
					<strong><i class="fa fa-user margin-r-5"></i> About Me</strong>
					<p class="text-muted">{{ $user->about }}</p>
					<hr>
					@endif
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
		<div class="col-md-9">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#info" data-toggle="tab">Update Information</a></li>
					<li><a href="#picture" data-toggle="tab">Update Picture</a></li>
					<li><a href="#password" data-toggle="tab">Update Password</a></li>
				</ul>
				<div class="tab-content">
					<div class="active tab-pane" id="info">
						<form name="profile_edit_form" data-parsley-validate class="form-horizontal" action="{{ route('admin.profile.update', $user->id) }}" method="post">
							{{method_field('PATCH')}}
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								<label for="name" class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" placeholder="ex. John Smith" required maxlength="100">
									@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
								<label for="username" class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10">
									<input type="text" name="username" class="form-control" id="username" value="{{ $user->username }}" placeholder="ex. john_smith" required maxlength="50">
									@if ($errors->has('username'))
									<span class="help-block">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								<label for="email" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="text" name="email" class="form-control" id="copyright" value="{{ $user->email }}" placeholder="ex. johnsmith@mail.com" required maxlength="100">
									@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
								<label for="gender" class="col-sm-2 control-label">Gender</label>
								<div class="col-sm-10">
									<select name="gender" class="form-control" id="gender" required>
										<option value="" disabled selected>Select One</option>
										<option value="m">Male</option>
										<option value="f">Female</option>
									</select>
									@if ($errors->has('gender'))
									<span class="help-block">
										<strong>{{ $errors->first('gender') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
								<label for="phone" class="col-sm-2 control-label">Phone</label>
								<div class="col-sm-10">
									<input type="text" name="phone" class="form-control" id="phone" value="{{ $user->phone }}" placeholder="ex. XXXXXXXXXXX" required maxlength="250">
									@if ($errors->has('phone'))
									<span class="help-block">
										<strong>{{ $errors->first('phone') }}</strong>
									</span>
									@endif
								</div>
							</div>


							<div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }}">
								<label for="facebook" class="col-sm-2 control-label">Facebook URL</label>
								<div class="col-sm-10">
									<input type="text" name="facebook" class="form-control" id="facebook" value="{{ $user->facebook }}" placeholder="ex. https://www.facebook.com/username" required maxlength="250">
									@if ($errors->has('facebook'))
									<span class="help-block">
										<strong>{{ $errors->first('facebook') }}</strong>
									</span>
									@endif
								</div>
							</div>


							<div class="form-group{{ $errors->has('twitter') ? ' has-error' : '' }}">
								<label for="twitter" class="col-sm-2 control-label">Twitter URL</label>
								<div class="col-sm-10">
									<input type="text" name="twitter" class="form-control" id="twitter" value="{{ $user->twitter }}" placeholder="ex. https://twitter.com/username" required maxlength="250">
									@if ($errors->has('twitter'))
									<span class="help-block">
										<strong>{{ $errors->first('twitter') }}</strong>
									</span>
									@endif
								</div>
							</div>


							<div class="form-group{{ $errors->has('google_plus') ? ' has-error' : '' }}">
								<label for="google_plus" class="col-sm-2 control-label">Google Plus URL</label>
								<div class="col-sm-10">
									<input type="text" name="google_plus" class="form-control" id="google_plus" value="{{ $user->google_plus }}" placeholder="ex. https://plus.google.com/username" required maxlength="250">
									@if ($errors->has('google_plus'))
									<span class="help-block">
										<strong>{{ $errors->first('google_plus') }}</strong>
									</span>
									@endif
								</div>
							</div>


							<div class="form-group{{ $errors->has('linkedin') ? ' has-error' : '' }}">
								<label for="linkedin" class="col-sm-2 control-label">Linkedin</label>
								<div class="col-sm-10">
									<input type="text" name="linkedin" class="form-control" id="linkedin" value="{{ $user->linkedin }}" placeholder="ex. https://www.linkedin.com/username" required maxlength="250">
									@if ($errors->has('linkedin'))
									<span class="help-block">
										<strong>{{ $errors->first('linkedin') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
								<label for="address" class="col-sm-2 control-label">Address</label>
								<div class="col-sm-10">
									<input type="text" name="address" class="form-control" id="address" value="{{ $user->address }}" placeholder="ex. House 00, Road 00, New york, United states" required maxlength="250">
									@if ($errors->has('address'))
									<span class="help-block">
										<strong>{{ $errors->first('address') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
								<label for="about" class="col-sm-2 control-label">About Me</label>
								<div class="col-sm-10">
									<textarea name="about" class="form-control" id="about" rows="6" placeholder="ex. about me" required maxlength="500">{{ $user->about }}</textarea>
									@if ($errors->has('about'))
									<span class="help-block">
										<strong>{{ $errors->first('about') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-info btn-flat">Update</button>
								</div>
							</div>
						</form>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="picture">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.profileAvatarRoute', $user->id) }}" method="post" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
								<label for="avatar" class="col-sm-2 control-label">Avater</label>
								<div class="col-sm-4">
									<input type="file" name="avatar" class="form-control" id="avatar" required>
									@if ($errors->has('avatar'))
									<span class="help-block">
										<strong>{{ $errors->first('avatar') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-info btn-flat">Update</button>
								</div>
							</div>
						</form>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="password">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.profileUpdatePasswordRoute') }}" method="post">
							{{csrf_field()}}

							<div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                            <label for="new_password" class="col-md-3 control-label">Current Password <span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <input id="current_password" type="password" class="form-control" name="current_password" required >
                                @if ($errors->has('current_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label for="new_password" class="col-md-3 control-label">New Password <span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <input id="new_password" type="password" class="form-control" name="new_password" required minlength="8">
                                @if ($errors->has('new_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirm" class="col-md-3 control-label">Confirm New Password <span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <input id="new_password_confirm" type="password" class="form-control" name="new_password_confirmation" required minlength="8">
                            </div>
                        </div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<button type="submit" class="btn btn-info btn-flat">Update</button>
								</div>
							</div>
						</form>
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

</section>
<!-- /.content -->
<!-- /.content -->
<!-- /.main content -->
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('public/admin/js/parsley.min.js') }}"></script>
<script type="text/javascript">
	@if(!empty($user->gender))
	document.forms['profile_edit_form'].elements['gender'].value = "{{ $user->gender }}";
	@endif
</script>
@endsection