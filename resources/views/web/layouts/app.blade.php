<!DOCTYPE html>
<html lang="en">
<!-- head -->
<head>
    @include('web.includes.head')
    @yield('style')
</head>
<!-- /.head -->

<body>
    <!-- theme layout -->
    <div class="theme-layout">
        <!-- header -->
        @include('web.includes.header')
        <!-- /.header -->

        <!-- first section block -->
        <section>
            <div class="space">
                <div class="container">
                    <div class="row">
                        <!-- left section -->
                        @yield('content')
                        <!-- /. left section -->

                        <!-- /. right side widget -->
                        @yield('sidebar')
                        <!--/. right side widget-->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.first section block -->

        <!-- footer -->
        @include('web.includes.footer')
        <!-- /. footer -->

    </div>
    <!-- /. theme-layout -->

    <!-- scripts -->
    @include('web.includes.scripts')
    @yield('script')
    <!-- /. script -->
</body>
</html>