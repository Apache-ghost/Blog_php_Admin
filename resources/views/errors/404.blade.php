@extends('web.layouts.app')
@section('title', 'My Blog')

@section('content')
<div class="col-md-12">
    <div class="error-404">
        <a href="{{ route('homePage') }}">
            <img src="{{ asset('public/web/images/404.png') }}">
        </a>
    </div>
</div>
@endsection