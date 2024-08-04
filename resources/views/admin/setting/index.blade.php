@extends('admin.layouts.app')
@section('title', 'Setting')


@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/parsley.css') }}">
<style type="text/css">
.tab-pane{
	margin-top: 30px
}
</style>
@endsection

@section('content')
<!-- Page header -->
<section class="content-header">
	<h1>
		SETTING
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('admin.dashboardRoute') }}"><i class="fa fa-home"></i> Dashboard</a></li>
		<li class="active">Setting</li>
	</ol>
</section>
<!-- /.page header -->

<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#logo" data-toggle="tab">Logo</a></li>
					<li><a href="#favicon" data-toggle="tab">Favicon</a></li>
					<li><a href="#general" data-toggle="tab">General</a></li>
					<li><a href="#contact" data-toggle="tab">Contact</a></li>
					<li><a href="#address" data-toggle="tab">Address</a></li>
					<li><a href="#social_link" data-toggle="tab">Social Link</a></li>
					<li><a href="#home_page_meta" data-toggle="tab">Home Page Meta</a></li>
					<li><a href="#gallery_page_meta" data-toggle="tab">Gallery Page Meta</a></li>
				</ul>
				<div class="tab-content">
					<div class="active tab-pane" id="logo">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingLogoRoute', $setting->id) }}" method="post" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<img src="{{ asset('public/web/logo/' . $setting->logo) }}" width="262" class="img-responsive">
								</div>
							</div>
							<div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
								<label for="logo" class="col-sm-2 control-label">New Logo</label>
								<div class="col-sm-3">
									<input type="file" name="logo" class="form-control" id="logo" required>
									@if ($errors->has('logo'))
									<span class="help-block">
										<strong>{{ $errors->first('logo') }}</strong>
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
					<div class="tab-pane" id="favicon">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingFaviconRoute', $setting->id) }}" method="post" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<img src="{{ asset('public/web/favicon/' . $setting->favicon) }}" width="32" class="img-responsive">
								</div>
							</div>
							<div class="form-group{{ $errors->has('favicon') ? ' has-error' : '' }}">
								<label for="favicon" class="col-sm-2 control-label">New Logo</label>
								<div class="col-sm-3">
									<input type="file" name="favicon" class="form-control" id="favicon" required>
									@if ($errors->has('favicon'))
									<span class="help-block">
										<strong>{{ $errors->first('favicon') }}</strong>
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

					<div class="tab-pane" id="general">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingGeneralRoute', $setting->id) }}" method="post">
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('map_iframe') ? ' has-error' : '' }}">
								<label for="map_iframe" class="col-sm-2 control-label">Map iFrame</label>
								<div class="col-sm-10">
									<textarea name="map_iframe" class="form-control" id="map_iframe" rows="6" placeholder="ex. google map iframe" maxlength="500">{{ $setting->map_iframe }}</textarea>
									@if ($errors->has('map_iframe'))
									<span class="help-block">
										<strong>{{ $errors->first('map_iframe') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('about_us') ? ' has-error' : '' }}">
								<label for="about_us" class="col-sm-2 control-label">Footer About Us</label>
								<div class="col-sm-10">
									<textarea name="about_us" class="form-control" id="about_us" placeholder="ex. about us"  rows="6" required maxlength="500">{{ $setting->about_us }}</textarea>
									@if ($errors->has('about_us'))
									<span class="help-block">
										<strong>{{ $errors->first('about_us') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('copyright') ? ' has-error' : '' }}">
								<label for="copyright" class="col-sm-2 control-label">Copyright</label>
								<div class="col-sm-10">
									<input type="text" name="copyright" class="form-control" id="copyright" value="{{ $setting->copyright }}" placeholder="ex. Copyright 2018 Clustercoding, All rights reserved." required maxlength="250">
									@if ($errors->has('copyright'))
									<span class="help-block">
										<strong>{{ $errors->first('copyright') }}</strong>
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
					<div class="tab-pane" id="contact">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingContactRoute', $setting->id) }}" method="post">
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								<label for="email" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="text" name="email" class="form-control" id="email" value="{{ $setting->email }}" placeholder="ex. clustercoding@gmail.com" required maxlength="100">
									@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
								<label for="phone" class="col-sm-2 control-label">Phone</label>
								<div class="col-sm-10">
									<input type="text" name="phone" class="form-control" id="phone" value="{{ $setting->phone }}" placeholder="ex. XXXXXXXXXXX" maxlength="25">
									@if ($errors->has('phone'))
									<span class="help-block">
										<strong>{{ $errors->first('phone') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
								<label for="mobile" class="col-sm-2 control-label">Mobile</label>
								<div class="col-sm-10">
									<input type="text" name="mobile" class="form-control" id="mobile" value="{{ $setting->mobile }}" placeholder="ex. XXXXXXXXXXX" maxlength="25">
									@if ($errors->has('mobile'))
									<span class="help-block">
										<strong>{{ $errors->first('mobile') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
								<label for="fax" class="col-sm-2 control-label">Fax</label>
								<div class="col-sm-10">
									<input type="text" name="fax" class="form-control" id="fax" value="{{ $setting->fax }}" placeholder="ex. XXXXXX" maxlength="20">
									@if ($errors->has('fax'))
									<span class="help-block">
										<strong>{{ $errors->first('fax') }}</strong>
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
					<div class="tab-pane" id="address">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingAddressRoute', $setting->id) }}" method="post">
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('address_line_one') ? ' has-error' : '' }}">
								<label for="address_line_one" class="col-sm-2 control-label">Address Line 1</label>
								<div class="col-sm-10">
									<input type="text" name="address_line_one" class="form-control" id="email" value="{{ $setting->address_line_one }}" placeholder="ex. address" maxlength="250">
									@if ($errors->has('address_line_one'))
									<span class="help-block">
										<strong>{{ $errors->first('address_line_one') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('address_line_two') ? ' has-error' : '' }}">
								<label for="address_line_two" class="col-sm-2 control-label">Address Line 2</label>
								<div class="col-sm-10">
									<input type="text" name="address_line_two" class="form-control" id="address_line_two" value="{{ $setting->address_line_two }}" placeholder="ex. address" maxlength="250">
									@if ($errors->has('address_line_two'))
									<span class="help-block">
										<strong>{{ $errors->first('address_line_two') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
								<label for="state" class="col-sm-2 control-label">state</label>
								<div class="col-sm-10">
									<input type="text" name="state" class="form-control" id="state" value="{{ $setting->state }}" placeholder="ex. state" maxlength="50">
									@if ($errors->has('state'))
									<span class="help-block">
										<strong>{{ $errors->first('state') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
								<label for="city" class="col-sm-2 control-label">City</label>
								<div class="col-sm-10">
									<input type="text" name="city" class="form-control" id="city" value="{{ $setting->city }}" placeholder="ex. city" maxlength="50">
									@if ($errors->has('city'))
									<span class="help-block">
										<strong>{{ $errors->first('city') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
								<label for="zip" class="col-sm-2 control-label">Zip</label>
								<div class="col-sm-10">
									<input type="text" name="zip" class="form-control" id="zip" value="{{ $setting->zip }}" placeholder="ex. zip" maxlength="25">
									@if ($errors->has('zip'))
									<span class="help-block">
										<strong>{{ $errors->first('zip') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
								<label for="country" class="col-sm-2 control-label">Country</label>
								<div class="col-sm-10">
									<input type="text" name="country" class="form-control" id="country" value="{{ $setting->country }}" placeholder="ex. country" maxlength="50">
									@if ($errors->has('country'))
									<span class="help-block">
										<strong>{{ $errors->first('country') }}</strong>
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
					<div class="tab-pane" id="social_link">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingSocialRoute', $setting->id) }}" method="post">
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }}">
								<label for="facebook" class="col-sm-2 control-label">Facebook</label>
								<div class="col-sm-10">
									<input type="text" name="facebook" class="form-control" id="facebook" value="{{ $setting->facebook }}" placeholder="ex. https://facebook.com/clustercoding" maxlength="250">
									@if ($errors->has('facebook'))
									<span class="help-block">
										<strong>{{ $errors->first('facebook') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('twitter') ? ' has-error' : '' }}">
								<label for="twitter" class="col-sm-2 control-label">Twitter</label>
								<div class="col-sm-10">
									<input type="text" name="twitter" class="form-control" id="twitter" value="{{ $setting->twitter }}" placeholder="ex. https://twitter.com/cluster_coding" maxlength="250">
									@if ($errors->has('twitter'))
									<span class="help-block">
										<strong>{{ $errors->first('twitter') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('google_plus') ? ' has-error' : '' }}">
								<label for="google_plus" class="col-sm-2 control-label">Google Plus</label>
								<div class="col-sm-10">
									<input type="text" name="google_plus" class="form-control" id="google_plus" value="{{ $setting->google_plus }}" placeholder="ex. https://plus.google.com/+ClusterCoding" maxlength="250">
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
									<input type="text" name="linkedin" class="form-control" id="linkedin" value="{{ $setting->linkedin }}" placeholder="ex. https://www.linkedin.com/company/clustercoding/" maxlength="250">
									@if ($errors->has('linkedin'))
									<span class="help-block">
										<strong>{{ $errors->first('linkedin') }}</strong>
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
					<div class="tab-pane" id="home_page_meta">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingMetaRoute', $setting->id) }}" method="post">
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
								<label for="meta_title" class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" name="meta_title" class="form-control" id="meta_title" value="{{ $setting->meta_title }}" placeholder="ex. meta title" required maxlength="250">
									@if ($errors->has('meta_title'))
									<span class="help-block">
										<strong>{{ $errors->first('meta_title') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('meta_keywords') ? ' has-error' : '' }}">
								<label for="meta_keywords" class="col-sm-2 control-label">Meta Keywords</label>
								<div class="col-sm-10">
									<input type="text" name="meta_keywords" class="form-control" id="meta_keywords" value="{{ $setting->meta_keywords }}" placeholder="ex. meta, keywords" required maxlength="250">
									@if ($errors->has('meta_keywords'))
									<span class="help-block">
										<strong>{{ $errors->first('meta_keywords') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
								<label for="meta_description" class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<textarea name="meta_description" class="form-control" id="meta_description" placeholder="ex. meta description" required maxlength="350">{{ $setting->meta_description }}</textarea>
									@if ($errors->has('meta_description'))
									<span class="help-block">
										<strong>{{ $errors->first('meta_description') }}</strong>
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
					<div class="tab-pane" id="gallery_page_meta">
						<form data-parsley-validate class="form-horizontal" action="{{ route('admin.settingGalleryMetaRoute', $setting->id) }}" method="post">
							{{csrf_field()}}
							<div class="form-group{{ $errors->has('gallery_meta_title') ? ' has-error' : '' }}">
								<label for="gallery_meta_title" class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" name="gallery_meta_title" class="form-control" id="gallery_meta_title" value="{{ $setting->gallery_meta_title }}" placeholder="ex. meta title" required maxlength="250">
									@if ($errors->has('gallery_meta_title'))
									<span class="help-block">
										<strong>{{ $errors->first('gallery_meta_title') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('gallery_meta_keywords') ? ' has-error' : '' }}">
								<label for="gallery_meta_keywords" class="col-sm-2 control-label">Meta Keywords</label>
								<div class="col-sm-10">
									<input type="text" name="gallery_meta_keywords" class="form-control" id="gallery_meta_keywords" value="{{ $setting->gallery_meta_keywords }}" placeholder="ex. meta, keywords" required maxlength="250">
									@if ($errors->has('gallery_meta_keywords'))
									<span class="help-block">
										<strong>{{ $errors->first('gallery_meta_keywords') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('gallery_meta_description') ? ' has-error' : '' }}">
								<label for="gallery_meta_description" class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<textarea name="gallery_meta_description" class="form-control" id="gallery_meta_description" placeholder="ex. meta description" required maxlength="350">{{ $setting->gallery_meta_description }}</textarea>
									@if ($errors->has('gallery_meta_description'))
									<span class="help-block">
										<strong>{{ $errors->first('gallery_meta_description') }}</strong>
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
<!-- /.main content -->
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('public/admin/js/parsley.min.js') }}"></script>
@endsection