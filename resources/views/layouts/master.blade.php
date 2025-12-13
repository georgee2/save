<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

    <head>
        <meta content="@yield('seo_desc')" name="description">
        <meta content="@yield('seo_tags')" name="keywords">
        <title>@yield('title' , env('APP_NAME'))</title>
        <!--==============================
            All CSS File
        ============================== -->

        <!-- Place favicon.ico in the root directory -->
          <link rel="shortcut icon" type="image/x-icon" href="assets/images/fav.png">

          <!-- CSS here -->
          <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/font-awesome-pro.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/animate.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/bexon-icons.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/nice-select.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/swiper.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/venobox.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/odometer-theme-default.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/meanmenu.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/css/main.css')}}">
          <!-- Scroll and Animation Optimization -->
          <link rel="stylesheet" href="{{asset('/assets/css/scroll-optimization.css')}}">
          <!-- Mobile Hero Optimization -->
          <link rel="stylesheet" href="{{asset('/assets/css/mobile-hero.css')}}">
                

        @yield('css')

    </head>

    <body>

    <div class="body-overlay"></div>

      <!-- Preloader Start -->
      <div class="tj-preloader is-loading">
        <div class="tj-preloader-inner">
          <div class="tj-preloader-ball-wrap">
            <div class="tj-preloader-ball-inner-wrap">
              <div class="tj-preloader-ball-inner">
                <div class="tj-preloader-ball"></div>
              </div>
              <div class="tj-preloader-ball-shadow"></div>
            </div>
            <div id="tj-weave-anim" class="tj-preloader-text">Smart Vision Group ...</div>
          </div>
        </div>
        <div class="tj-preloader-overlay"></div>
      </div>
      <!-- Preloader end -->

      <!-- back to top start -->
      <div id="tj-back-to-top"><span id="tj-back-to-top-percentage"></span></div>
      <!-- back to top end -->

      <!-- start: Search Popup -->
      <div class="search-popup-overlay"></div>

        @include('includes.sidebar')
        @include('includes.mobile')
        @include('includes.header')

    <div id="smooth-wrapper">
        <div id="smooth-content">
          <main id="primary" class="site-main">
            <div class="space-for-header"></div>
                @yield('content')
                @include('includes.footer')

            </main>
        </div>
    </div>



   
      <script src="{{asset('/assets/js/jquery.min.js')}}"></script>
      <script src="{{asset('/assets/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('/assets/js/gsap.min.js')}}"></script>
      <script src="{{asset('/assets/js/ScrollSmoother.js')}}"></script>
      <script src="{{asset('/assets/js/gsap-scroll-to-plugin.min.js')}}"></script>
      <script src="{{asset('/assets/js/gsap-scroll-trigger.min.js')}}"></script>
      <script src="{{asset('/assets/js/gsap-split-text.min.js')}}"></script>
      <script src="{{asset('/assets/js/jquery.nice-select.min.js')}}"></script>
      <script src="{{asset('/assets/js/swiper.min.js')}}"></script>
      <script src="{{asset('/assets/js/odometer.min.js')}}"></script>
      <script src="{{asset('/assets/js/venobox.min.js')}}"></script>
      <script src="{{asset('/assets/js/appear.min.js')}}"></script>
      <script src="{{asset('/assets/js/wow.min.js')}}"></script>
      <script src="{{asset('/assets/js/wow-config.js')}}"></script>
      <script src="{{asset('/assets/js/meanmenu.js')}}"></script>
      <script src="{{asset('/assets/js/imagesloaded-pkgd.js')}}"></script>
      <script src="{{asset('/assets/js/isotope.pkgd.min.js')}}"></script>
      <script src="{{asset('/assets/js/main.js')}}"></script>
    
    @yield('js')

</body>

</html>