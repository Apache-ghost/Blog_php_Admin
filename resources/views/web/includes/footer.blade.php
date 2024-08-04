<!--START BOTTOM BAR-->
<div class="bottom-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <p class="copyright">{!! $setting->copyright !!}</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <div class="footer-imp-links">
                    <a href="{{ route('homePage') }}">Home</a>
                    @foreach($pages as $page)
                    <a href="{{ route('pagePage', $page->page_slug) }}">{{ $page->page_name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--END BOTTOM BAR-->