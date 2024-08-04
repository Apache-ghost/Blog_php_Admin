@extends('web.layouts.app')

@section('title', $setting->gallery_meta_title)
@section('keywords', $setting->gallery_meta_keywords)
@section('description', $setting->gallery_meta_description)

@section('style')
<style type="text/css">
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    padding-top: 25px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
    margin: auto;
    display: block;
    width: 100%;
    max-width: 700px;
    background-color:transparent;
    border:0px solid #999;
    border:0px solid rgba(0,0,0,0);
    outline:0;
    -webkit-box-shadow:0 0px 0px rgba(0,0,0,0);
    box-shadow:0 0px 0px rgba(0,0,0,0)
}
.modal-header {
	border: 0px;
	}
.caption {
    margin: auto;
    display: block;
    width: 100%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
}
.close {
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

</style>
@endsection

@section('content')
<div class="col-md-12">
	<div class="crumb inner-page-crumb">
		<ul>
			<li><i class="ti-home"></i><a href="{{ route('homePage') }}">Home</a> / </li>
			<li><a href="{{ route('galleryPage') }}">Gallery</a></li>
		</ul>
	</div>
	<div class="home-news-block block-no-space">
		<div class="row postgrid-horiz grid-style-2">
			@foreach($galleries as $gallery)
			<div class="col-sm-4">
				<div class="featured-post">
					<div class="featured-avatar">
						<a class="post-music view-image" data-id="{{ $gallery->id }}" title="{{ $gallery->caption }}"><i class="ti-image"></i></a>
						<img src="{{ get_gallery_image_url($gallery->image) }}" alt="{{ $gallery->caption }}">
					</div>
					<div class="featured-meta small">
						<h2><a title="{{ $gallery->caption }}">{{ $gallery->caption }}</a></h2>
						<ul class="post-info">
							<li><a href="{{ route('authorProfilePage', $gallery->user->username) }}" title="{{ $gallery->caption }}"><i class="ti-user"></i>{{ $gallery->user->name }}</a></li>
						</ul>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="pagination" style="margin-top: 25px;">{{ $galleries->links() }}</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<img id="view-image" width="100%">
				<br>
				<span class="caption" id="view-caption"></span>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$(".view-image").click(function(){
			var id = $(this).data("id");
			var url = "{{ route('getGalleryRoute', 'id') }}";
			url = url.replace("id", id);
			$.ajax({
				url: url,
				method: "GET",
				dataType: "json",
				success:function(data){
					var src = '{{ get_gallery_image_url() }}/';
					$('#view-modal').modal('show');
					$('#view-caption').text(data['caption']);
					$("#view-image").attr("src", src+data['image']);
				}
			});
		});
		$(".close").click(function(){
			$('#view-modal').modal('toggle');
		});
	});
</script>
@endsection