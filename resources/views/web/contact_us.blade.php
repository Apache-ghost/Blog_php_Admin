@extends('web.layouts.app')
@section('title', 'Contact Us')

@section('style')
<style type="text/css">
#google_map{
	margin-bottom: 40px;
}
</style>
@endsection

@section('content')
<div class="col-md-12">
	<div class="crumb inner-page-crumb">
		<ul>
			<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
			<li><a class="active">Contact Us</a></li>
		</ul>
	</div>
</div>
<div class="col-md-12" id="google_map">
	{!! $setting->map_iframe !!}
</div>

<div class="col-md-6 wow fadeInUp">
	<div class="well">
		<h3>Get in Touch</h3>
		<div class="contact-form contact-us-form">
			<form class="row">
				<div class="col-sm-6">
					<input type="text" placeholder="Name *" required>
				</div>
				<div class="col-sm-6">
					<input type="text" placeholder="Phone">
				</div>
				<div class="col-sm-12">
					<input type="email" placeholder="Email *" required>
				</div>
				<div class="col-sm-12">
					<textarea cols="30" rows="10" placeholder="Your Message"></textarea>
				</div>
				<div class="col-sm-12">
					<button type="submit">Send Message  <i class="fa fa-paper-plane"></i></button>
				</div>
			</form>
		</div>

	</div>
</div>
<div class="col-md-6 wow fadeInUp">
	<div class="well">
		<h3>Address</h3>
		<div class="contact-info">
			<address>
				{{ $setting->address_line_one }}<br>
				{{ $setting->address_line_two }}<br>
				{{ $setting->state }}<br>
				{{ $setting->city }} {{ $setting->zip }}<br>
				{{ $setting->country }}<br>
				Fax: {{ $setting->fax }} <br>
			</address>
			<table class="table">
				<tbody>
					<tr>
						<td>
							<div class="border-icon sm"><span class="ti-headphone"></span></div>
						</td>
						<td><a href="callto:{{ $setting->phone }}">{{ $setting->phone }}</a></td>
					</tr>
					<tr>
						<td>
							<div class="border-icon sm"><span class="ti-mobile"></span></div>
						</td>
						<td><a href="callto:{{ $setting->mobile }}">{{ $setting->mobile }}</a></td>
					</tr>
					<tr>
						<td>
							<div class="border-icon sm"><span class="ti-email"></span></div>
						</td>
						<td>
							<a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection