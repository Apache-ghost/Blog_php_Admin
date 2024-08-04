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
            <h3>Forget Password</h3>
            <form method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
            </form>
            <p style="margin-top: 25px;">Already have an account? <a href="{{ route('login') }}">Login</a>.</p></p>
        </div>

    </div>
</div>
@endsection

@section('sidebar')
@endsection

@section('script')
@endsection