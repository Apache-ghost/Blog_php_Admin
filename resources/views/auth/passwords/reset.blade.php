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
            <h3>Reset Password</h3>
            <form method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                        </div>
                    </form>
            <p style="margin-top: 25px;">You have no account? <a href="{{ route('register') }}">Click here</a>.</p>
        </div>

    </div>
</div>
@endsection

@section('sidebar')
@endsection

@section('script')
@endsection
