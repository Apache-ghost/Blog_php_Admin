@php($user = Auth::user())
<div class="col-md-4">
	<aside>
		<div class="widget">
			<div class="media-body text-center">
				@if(!empty($user->avatar))
				<img src="{{ asset('public/avatar/' . $user->avatar) }}" class="media-object img-circle" style="width:80px; margin: 0 auto; padding-bottom: 10px;">
				@else 
				<img src="{{ get_gravatar($user->email) }}" class="media-object img-circle" style="width:80px; margin: 0 auto; padding-bottom: 10px;">
				@endif
				<h4 class="media-heading"><strong>{{ $user->name }}</strong></h4>
				@if(isAdmin())
				<p class="text-success"><strong>Admin</strong></p>
				<a href="{{ route('admin.dashboardRoute') }}">Admin Dashboard</a>
				@elseif(isAuthor())
				<p class="text-success"><strong>Author</strong></p>
				@else
				<p class="text-success"><strong>User</strong></p>
				@endif
			</div>
			<hr>
			<div>
				<div class="btn-group btn-group-justified">
					<div class="btn-group">
						<a href="{{ route('dashboard.editProfilePage') }}" class="tip btn btn-default btn-sm"><i class="fa fa-user"></i><span class="hidden-sm hidden-xs"> Edit Profile</span></a>
					</div><div class="btn-group">
						<a href="{{ route('dashboard.editPasswordPage') }}" class="tip btn btn-default btn-sm"><i class="fa fa-key"></i><span class="hidden-sm hidden-xs"> Change Password</span></a>
					</div>
				</div>
			</div>
			<hr>
			<div class="text-center"> 
				@if(!empty($user->facebook))
				<a href="{{ $user->facebook }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-facebook"></i></a>
				@endif
				@if(!empty($user->twitter))
				<a href="{{ $user->twitter }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-twitter"></i></a>
				@endif
				@if(!empty($user->google_plus))
				<a href="{{ $user->google_plus }}" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-google-plus"></i></a>
				@endif
				@if(!empty($user->linkedin))
				<a href="{{ $user->linkedin }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-linkedin"></i></a>
				@endif
			</div>
			<hr>
			<ul class="contact-widget">
				<li>
					<span>Username</span>
					<ins><i class="ti-user"></i> {{ $user->username }}</ins>
				</li>
				<li>
					<span>Email Address</span>
					<ins><i class="ti-email"></i> {{ $user->email }}</ins>
				</li>
				@if(!empty($user->phone))
				<li>
					<span>Phone Number</span>
					<ins><i class="ti-mobile"></i> {{ $user->phone }}</ins>
				</li>
				@endif
				@if(!empty($user->address))
				<li>
					<span>Address</span>
					<ins><i class="ti-location-pin"></i> {{ $user->address }}</ins>
				</li>
				@endif
				@if(!empty($user->gender))
				<li>
					<span>Gender</span>
					@if($user->gender == 'm')
					<ins><i class="fa fa-male"></i> Male</ins>
					@else
					<ins><i class="fa fa-female"></i> Female</ins>
					@endif
				</li>
				@endif
				@if(!empty($user->about))
				<li>
					<span>About</span>
					<ins><i class="ti-user"></i> {{ $user->about }}</ins>
				</li>
				@endif
			</ul>
		</div>
	</aside>
</div>