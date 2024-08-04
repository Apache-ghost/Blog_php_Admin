<!-- Logo -->
<a href="{{ route('admin.dashboardRoute') }}" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><b>B</b>MP</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>Blog Master</b></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- notification -->
      <li class="messages-menu"><a href="{{ route('admin.comments.index') }}" title="Comment"><i class="fa fa-comment-o"></i><span class="label label-warning">{{ $comments->count() }}</span></a></li>

      <li class="messages-menu"><a href="{{ route('admin.comments.index') }}" title="Post"><i class="fa fa-newspaper-o"></i><span class="label label-warning">{{ $posts->count() }}</span></a></li>
      <!-- /.notification -->

      <!-- frontend -->
      <li class="user user-menu">
        <a href="{{ route('homePage') }}" target="_blank">
          <img src="{{ asset('public/admin/image/frontend.png') }}" class="user-image img-responsive" alt="Frontend" width="25px">
          <span class="hidden-xs">Frontend</span>
        </a>
      </li>
      <!-- /.frontend -->

      <!-- user -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          @if(!empty(Auth::user()->avatar))
          <img src="{{ asset('public/avatar/' . Auth::user()->avatar) }}" class="user-image" alt="{{ Auth::user()->name }}">
          @else
          <img src="{{ asset('public/avatar/user.png') }}" class="user-image" alt="{{ Auth::user()->name }}">
          @endif
          <span class="hidden-xs">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            @if(!empty(Auth::user()->avatar))
            <img src="{{ asset('public/avatar/'. Auth::user()->avatar) }}" class="img-circle" alt="{{ Auth::user()->name }}">
            @else
            <img src="{{ asset('public/avatar/user.png') }}" class="img-circle" alt="{{ Auth::user()->name }}">
            @endif
            <p>
              {{ Auth::user()->name }} - {{ Auth::user()->role }}
              <small>Member Since {{ date("d F Y", strtotime(Auth::user()->created_at)) }} </small>
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{ route('admin.profile.index') }}" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>
          </li>
        </ul>
      </li>
      <!-- /.user -->

      <!-- setting -->
      <li class="user user-menu"><a href="{{ route('admin.setting.index') }}"><span class="hidden-xs"><i class="fa fa-gears"></i></span></a></li>
      <!-- /.setting -->

    </ul>
  </div>
</nav>