<!DOCTYPE html>
<html>
<head>
  <!-- Head -->
  @include('admin.includes.head')
  <!-- /.head -->

  <!-- Style -->
  @yield('style')
  <!-- /.style -->

</head>
<body class="hold-transition skin-purple-light sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <!-- Header -->
    <header class="main-header">
      @include('admin.includes.header')
    </header>
    <!-- /.header -->

    <!-- Sidebar -->
    <aside class="main-sidebar">
      @include('admin.includes.sidebar')
    </aside>
    <!-- /.sidebar -->


    <!-- Content Wrapper -->
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    @include('admin.includes.footer')

  </div>
  <!-- ./wrapper -->

  <!-- Flash Notification -->
  @include('admin.includes.flash_notification')
  <!-- /.flash notification -->

  <!-- Scripts -->
  @include('admin.includes.scripts')
  <!-- /.scripts -->

  <!-- Scripts -->
  @yield('script')
  <!-- /.scripts -->
</body>
</html>
