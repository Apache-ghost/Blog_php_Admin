<script type="text/javascript" src="{{ asset('public/web/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/web/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/web/js/owl.carousel.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('public/web/js/html5lightbox.js') }}"></script> -->
<!-- <script type="text/javascript" src="{{ asset('public/web/js/clock.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('public/web/js/jquery.bootstrap.newsbox.min.js') }}"></script>
<script src="{{ asset('public/web/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/web/js/parsley.min.js') }}"></script>

<script type="text/javascript">
	/** store subscriber **/
	$("#store-button").click(function(){
		var subscribe_add_form = $("#subscribe_add_form");
		var form_data = subscribe_add_form.serialize();
		$( '#email-error' ).html( "" );
		$( '#email-success' ).html( "" );
		$.ajax({
			url:'{{ route('subscribeRoute') }}',
			type:'POST',
			data:form_data,
			success:function(data) {
				console.log(data);
				if(data.errors) {
					if(data.errors.email){
						$( '#email-error' ).html( data.errors.email[0] );
					}
				}
				if(data.success) {
					$( '#email-success' ).text('Successfully subscribe.');
				}
			},
		});
	});
</script>