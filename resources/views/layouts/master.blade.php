<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <head>
        <meta content="@yield('seo_desc')" name="description">
        <meta content="@yield('seo_tags')" name="keywords">
        <title>@yield('title' , env('APP_NAME'))</title>
        <!--==============================
            All CSS File
        ============================== -->

        <!-- Place favicon.ico in the root directory -->
          <link rel="shortcut icon" type="image/x-icon" href="assets/images/fav.png">

          <!-- Mobile Hero Optimization -->
          <link rel="stylesheet" href="{{asset('/assets/css/mobile-hero.css')}}">

          <!-- Google fonts -->
          <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet">
          <!-- Vendors CSS -->
          <link rel="stylesheet" href="{{asset('/assets/vendors/fontawesome-pro-5/css/all.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/bootstrap-select/css/bootstrap-select.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/slick/slick.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/magnific-popup/magnific-popup.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/jquery-ui/jquery-ui.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/chartjs/Chart.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/dropzone/css/dropzone.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/animate.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/timepicker/bootstrap-timepicker.min.css')}}">
          <link rel="stylesheet" href="{{asset('/assets/vendors/mapbox-gl/mapbox-gl.min.css')}}">
          <!-- Themes core CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/themes.css')}}">
          <!-- Custom Sections CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/custom-sections.css')}}">
          <!-- Category/Projects Page CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/category-page.css')}}">
          <!-- Offers Section CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/offers-section.css')}}?v={{ time() }}">
          <!-- Services Section CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/services-section.css')}}">
          <!-- Interior Gallery CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/interior-gallery.css')}}?v={{ time() }}">
          <!-- Global Search CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/global-search.css')}}?v={{ time() }}">
          <!-- Section Divider CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/section-divider.css')}}">
          <!-- Why Choose Us CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/why-choose-us.css')}}?v={{ time() }}">
          <!-- Home Projects CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/home-projects.css')}}?v={{ time() }}">
          <!-- Home Contact & FAQ CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/home-contact-faq.css')}}?v={{ time() }}">
          <!-- Home News CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/home-news.css')}}?v={{ time() }}">
          <!-- Footer CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/footer.css')}}">
          <!-- Area Slider CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/area-slider.css')}}">
          <!-- Preloader CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/preloader.css')}}">
          <!-- Topbar CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/topbar.css')}}?v={{ time() }}">
          <!-- Header CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/header.css')}}?v={{ time() }}">
          <!-- Mobile Header CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/mobile-header.css')}}?v={{ time() }}">
          <!-- Mobile Bottom Nav CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/mobile-bottom-nav.css')}}?v={{ time() }}">
          
          <!-- RTL CSS for Arabic -->
          @if(app()->getLocale() == 'ar')
          <link rel="stylesheet" href="{{asset('/assets/css/rtl.css')}}?v={{ time() }}">
          @endif
          
          {{-- SweetAlert2 CSS - Global --}}
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        @yield('css')

    </head>

    <body>
      @include('includes.preloader')
      @include('includes.topbar')
      @include('includes.header')

      <main id="content">
        @include('includes.search')

        @yield('content')

      </main>
      @include('includes.footer')
      @include('includes.mobile-bottom-nav')
      @include('includes.language-switcher')



        <!-- Vendors scripts -->
        <script src="{{asset('/assets/vendors/jquery.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/bootstrap/bootstrap.bundle.js')}}"></script>
        <script src="{{asset('/assets/vendors/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/slick/slick.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/waypoints/jquery.waypoints.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/counter/countUp.js')}}"></script>
        <script src="{{asset('/assets/vendors/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/chartjs/Chart.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/dropzone/js/dropzone.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/timepicker/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/hc-sticky/hc-sticky.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/jparallax/TweenMax.min.js')}}"></script>
        <script src="{{asset('/assets/vendors/mapbox-gl/mapbox-gl.js')}}"></script>
        <!-- Theme scripts -->
        <script src="{{asset('/assets/js/theme.js')}}"></script>
        
        <!-- Preloader Script -->
        <script>
            $(window).on('load', function() {
                // Hide preloader after page fully loads
                setTimeout(function() {
                    $('#preloader').addClass('loaded');
                    // Remove from DOM after transition
                    setTimeout(function() {
                        $('#preloader').remove();
                    }, 500);
                }, 300);
            });
        </script>
        
        <!-- Back to Top Script -->
        <script>
            (function() {
                var backToTop = document.getElementById('backToTop');
                if (backToTop) {
                    // Show/hide button on scroll
                    window.addEventListener('scroll', function() {
                        if (window.pageYOffset > 300) {
                            backToTop.classList.add('show');
                        } else {
                            backToTop.classList.remove('show');
                        }
                    });
                    
                    // Smooth scroll to top on click
                    backToTop.addEventListener('click', function(e) {
                        e.preventDefault();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                }
            })();
        </script>
        
        <!-- Sticky Header Script -->
        <script>
            (function() {
                var header = document.querySelector('.main-header');
                var body = document.body;
                var scrollThreshold = 50;
                
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > scrollThreshold) {
                        header.classList.add('is-sticky');
                        body.classList.add('scrolled');
                    } else {
                        header.classList.remove('is-sticky');
                        body.classList.remove('scrolled');
                    }
                });
            })();
        </script>
   
    {{-- SweetAlert2 - Global --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('js')

</body>

</html>