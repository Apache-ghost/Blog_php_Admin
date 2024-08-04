@extends('web.layouts.app')
@section('title', 'Update Password')


@section('style')
<style type="text/css">
.contact-form {
	float: left;
	width: 100%;
	border: 0px;
	padding: 0px;
	margin-top: 0px;
}
</style>
@endsection

@section('content')
<div class="col-md-8">
	<div class="home-news-block block-no-space">
		<div class="crumb inner-page-crumb">
			<ul>
				<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
				<li><a href="{{ route('dashboard.dashboardPage') }}">Dashboard</a> / </li>
				<li><a href="{{ route('dashboard.editPasswordPage') }}">Change Password</a></li>
			</ul>
		</div>

		<div class="about-us">
			<div class="contact-form">
				<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left">Change Password</h3>
					<a href="{{ route('dashboard.dashboardPage') }}" class="btn btn-primary pull-right btn-flat"><i class="fa fa-dashboard"></i> Dashboard</a>
				</div>
			</div>
			<hr>
				<div class="row">
					<div class="col-sm-12">
						@if (!empty(Session::get('message')))
						<p style="color: #5cb85c">{{ Session::get('message') }}</p>
						@elseif (!empty(Session::get('exception')))
						<p style="color: #d9534f">{{ Session::get('exception') }}</p>
						@else
						<p>Required fields are marked <span class="required">*</span></p>
						@endif
					</div>
					<form data-parsley-validate action="{{ route('dashboard.updatePasswordPage') }}" method="post">
						{{csrf_field()}}
						<div class="col-md-12{{ $errors->has('current_password') ? ' has-error' : '' }}">
							<label>Current Password <span class="required">*</span></label>
							<input id="current_password" type="password" name="current_password" required>
							@if ($errors->has('current_password'))
							<span class="help-block">
								<strong>{{ $errors->first('current_password') }}</strong>
							</span>
							@endif
						</div>
						<div class="col-md-12{{ $errors->has('new_password') ? ' has-error' : '' }}">
							<label>New Password <span class="required">*</span></label>
							<input id="new_password" type="password" name="new_password" required minlength="8">
							@if ($errors->has('new_password'))
							<span class="help-block">
								<strong>{{ $errors->first('new_password') }}</strong>
							</span>
							@endif
						</div>
						<div class="col-md-12{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
							<label>Confirm New Password <span class="required">*</span></label>
							<input id="new_password_confirm" type="password" name="new_password_confirmation" required minlength="8">
						</div>
						<div class="col-sm-12">
							<button type="submit">Update <i class="fa fa-angle-right"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('sidebar')
@include('web.includes.user_sidebar')
@endsection

@section('script')
@endsection