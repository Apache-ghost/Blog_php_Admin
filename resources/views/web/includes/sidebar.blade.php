<div class="col-md-4">
    <aside>
     <!--START NEWSLETTER-->
     <div class="widget newsletter">
        <form data-parsley-validate action="{{ route('searchRoute') }}" method="post">
            {{ csrf_field() }}
            <input type="text" name="search_keywords" class="newsletter-email" placeholder="ex: post title" required>
            <button class="newsletter-subscribe" type="submit"><i class="fa fa-search"></i> Search</button>
        </form>
        @if ($errors->has('search_keywords'))
        <p class="text-center text-danger" style="font-size: 12px; padding: 5px 0px;">{{ $errors->first('search_keywords') }}</p>
        @endif
    </div>
    <!--/END NEWSLETTER-->

  <!--START POPULAR CATEGORIES-->
  <div class="widget">
    <div class="widget-title">
        <h4>
            <i class="fa fa-rocket"></i>
            All Categories
        </h4>
    </div>
    <ul class="widget-popular-cat">
        @foreach($categories as $category)
        <li>
            <a href="{{ route('categoryPage', $category->id) }}" title="{{ $category->category_name }}"><i class="fa fa-angle-right"></i>{{ $category->category_name }}<span class="cat-count-1">{{ $category->post()->count() }}</span></a>
        </li>
        @endforeach
    </ul>
</div>
<!--/END POPULAR CATEGORIES-->

<!--START NEWSLETTER-->
<div class="widget newsletter">
    <div class="widget-title">
        <h4>
            <i class="ti-email"></i>
            NEWSLETTER
        </h4>
    </div>
    <div class="subscribe-image">
        <img src="{{ asset('public/web') }}/images/newsletter.png" alt="Newsletter">
        <p>Subscribe our newsletter to stay updated.</p>
    </div>
    <form data-parsley-validate id="subscribe_add_form" method="post">
        {{ csrf_field() }}
        <input type="text" name="email" class="newsletter-email" placeholder="ex: mail@mail.com" required>
        <button class="newsletter-subscribe" name="subscribe" type="button" id="store-button">Subscribe</button>
    </form>
    <p class="text-center text-danger" id="email-error"></p>
    <p class="text-center text-success" id="email-success"></p>
</div>
<!--/END NEWSLETTER-->

<!--START TAGS-->
<div class="widget">
    <div class="widget-title">
        <h4>
            <i class="ti-tag"></i>
            Tags
        </h4>
    </div>
    <ul class="tags-cloud">
        @foreach($tags as $tag)
        <li><a href="{{ route('tagPage', $tag->id) }}" title="{{ $tag->tag_name }}">{{ $tag->tag_name }} ({{ $tag->posts()->count() }})</a></li>
        @endforeach
    </ul>
</div>
<!--/END TAGS-->

<!--Facebook Page-->
@if(!empty($setting->facebook))
    <div class="widget">
        <div class="fb-page" data-href="{{ $setting->facebook }}" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
            <blockquote cite="{{ $setting->facebook }}" class="fb-xfbml-parse-ignore">
                <a href="{{ $setting->facebook }}">{{ $setting->website_title }}</a>
            </blockquote>
        </div>
        <div id="fb-root"></div>
        <script type="text/javascript">
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=1227264524030761&autoLogAppEvents=1';
              fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
      </script>
  </div>
  @endif
  <!--/Facebook Page-->

</aside>
</div>