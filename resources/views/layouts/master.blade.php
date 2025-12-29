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
          <link rel="stylesheet" href="{{asset('/assets/css/offers-section.css')}}">
          <!-- Services Section CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/services-section.css')}}">
          <!-- Section Divider CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/section-divider.css')}}">
          <!-- Why Choose Us CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/why-choose-us.css')}}">
                

        @yield('css')

    </head>

    <body>
      @include('includes.header')

      <main id="content">
        @include('includes.search')

        @yield('content')

      </main>
      @include('includes.footer')



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
   
    
    @yield('js')

</body>

</html>