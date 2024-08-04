<!-- jQuery 3 -->
<script src="{{ asset('public/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('public/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/admin/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/admin/dist/js/demo.js') }}"></script>
<!-- Parsley form validation -->
<script src="{{ asset('public/admin/js/parsley.min.js') }}"></script>
<!-- Summernote editor -->
<script src="{{ asset('public/admin/summernote/summernote.js') }}"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
  })
</script>

<!-- Notification Message -->
@if (!empty(Session::get('message')))
<script>
  $(document).ready(function () {
    $('#message_box').animate({bottom: '60px'}, 1000);
    $("#message_box").fadeOut(4000);
  })
</script>
@endif

<!-- Notification Exception -->
@if (!empty(Session::get('exception')))
<script>
  $(document).ready(function () {
    $('#exception_box').animate({bottom: '60px'}, 1000);
    $("#exception_box").fadeOut(4000);
  })
</script>
@endif

<!-- Activate Menu -->
<script type="text/javascript">
 $('#mainMenu ul li').find('a').each(function () {
  if (document.location.href == $(this).attr('href')) {
    $(this).parents().addClass("active");
    $(this).addClass("active");
  }
});
</script>

<!-- For Modal Print -->
<script type="text/javascript">
  $('#print-button').on('click', function () {
    if ($('.print-modal').is(':visible')) {
      var modalId = $(event.target).closest('.print-modal').attr('id');
      $('body').css('visibility', 'hidden');
      $("#" + modalId).css('visibility', 'visible');
      $('#' + modalId).removeClass('print-modal');
      window.print();
      $('body').css('visibility', 'visible');
      $('#' + modalId).addClass('print-modal');
    } else {
      window.print();
    }
  });
</script>

<!-- For Div Print -->
<script type="text/javascript">
  function printDiv(printable_area) {
   var printContents = document.getElementById(printable_area).innerHTML;
   var originalContents = document.body.innerHTML;
   document.body.innerHTML = printContents;
   window.print();
   document.body.innerHTML = originalContents;
 }
</script>

<!-- For Tooltip -->
<script type="text/javascript">
  $('body').tooltip({selector: '[data-toggle="tooltip"]'});
</script>