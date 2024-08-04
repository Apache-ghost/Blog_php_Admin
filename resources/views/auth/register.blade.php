@extends('web.layouts.app')
@section('title', 'My Blog')


@section('style')
<style type="text/css">
.form-control{
    border-radius: 0px;
    padding: 20px 12px;
}
.btn{
    border-radius: 0px;
}
</style>
@endsection

@section('content')
<div class="col-md-6 col-md-offset-3">
    <div class="home-news-block block-no-space">
        <div class="about-us">
            <h3>Register</h3>
            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Email">
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}" placeholder="Email">
                    @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
                <button type="submit" class="btn btn-info">Submit</button>
            </form>
            <p style="margin-top: 25px;">Already have an account? <a href="{{ route('login') }}">Login</a>.</p>
        </div>

    </div>
</div>
@endsection

@section('sidebar')
@endsection

@section('script')
@endsection