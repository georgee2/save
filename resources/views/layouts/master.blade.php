<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @if(!empty($footerContactInfo->google_search_console))
        <meta name="google-site-verification" content="{{ $footerContactInfo->google_search_console }}">
        @endif
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="favourites-count-url" content="/{{ app()->getLocale() }}/favourites/count">
        <meta name="favourites-toggle-url" content="/{{ app()->getLocale() }}/favourites/toggle">
        <meta name="analytics-heartbeat-url" content="{{ url('/analytics/heartbeat') }}">
        <meta content="@yield('seo_desc')" name="description">
        <meta content="@yield('seo_tags')" name="keywords">
        <title>@yield('title' , env('APP_NAME'))</title>
        
        {{-- Open Graph Meta Tags for Social Sharing --}}
        @hasSection('og_title')
        <meta property="og:title" content="@yield('og_title')">
        @else
        <meta property="og:title" content="@yield('title', env('APP_NAME'))">
        @endif
        
        @hasSection('og_description')
        <meta property="og:description" content="@yield('og_description')">
        @else
        <meta property="og:description" content="@yield('seo_desc')">
        @endif
        
        @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
        @else
        <meta property="og:image" content="{{ asset('assets/images/og-default.jpg') }}">
        @endif
        
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:site_name" content="{{ env('APP_NAME') }}">
        <meta property="og:locale" content="{{ app()->getLocale() == 'ar' ? 'ar_AE' : 'en_US' }}">
        
        {{-- Twitter Card Meta Tags --}}
        <meta name="twitter:card" content="summary_large_image">
        @hasSection('og_title')
        <meta name="twitter:title" content="@yield('og_title')">
        @else
        <meta name="twitter:title" content="@yield('title', env('APP_NAME'))">
        @endif
        
        @hasSection('og_description')
        <meta name="twitter:description" content="@yield('og_description')">
        @else
        <meta name="twitter:description" content="@yield('seo_desc')">
        @endif
        
        @hasSection('og_image')
        <meta name="twitter:image" content="@yield('og_image')">
        @else
        <meta name="twitter:image" content="{{ asset('assets/images/og-default.jpg') }}">
        @endif
        
        @yield('meta_tags')

        {{-- Hreflang alternate tags for multilingual SEO --}}
        <link rel="alternate" hreflang="en-ae" href="{{ LaravelLocalization::getLocalizedURL('en') }}" />
        <link rel="alternate" hreflang="ar-ae" href="{{ LaravelLocalization::getLocalizedURL('ar') }}" />
        <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('en') }}" />

        {{-- Self-referencing canonical --}}
        <link rel="canonical" href="{{ url()->current() }}" />

        {{-- Organization / LocalBusiness JSON-LD --}}
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": ["Organization", "LocalBusiness"],
            "name": "Smart Vision Engineering Consultants (SVEC)",
            "url": "https://svec.ae",
            "logo": "{{ asset('pic/logos/logoen.png') }}",
            "telephone": "{{ $footerContactInfo->mobile ?? '' }}",
            "email": "{{ $footerContactInfo->email ?? '' }}",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Al Batha Tower, 20th Floor, Office 2002, Corniche Al Buhaira, Al Majaz 1",
                "addressLocality": "Sharjah",
                "addressCountry": "AE"
            },
            "sameAs": [
                @if($footerContactInfo->facebook)"{{ $footerContactInfo->facebook }}",@endif
                @if($footerContactInfo->instagram)"{{ $footerContactInfo->instagram }}",@endif
                @if($footerContactInfo->linkedin)"{{ $footerContactInfo->linkedin }}",@endif
                @if($footerContactInfo->twitter)"{{ $footerContactInfo->twitter }}"@endif
            ]
        }
        </script>

        <!--==============================
            All CSS File
        ============================== -->

        <!-- Favicon -->
          <link rel="icon" type="image/svg+xml" href="{{ asset('pic/fav.svg') }}">
          <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('pic/fav.svg') }}">

          <!-- Mobile Hero Optimization -->
          <link rel="stylesheet" href="{{asset('/assets/css/mobile-hero.css')}}">

          <!-- Google fonts -->
          <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Tajawal:wght@300;400;500;700;800&display=swap"
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
          <link rel="stylesheet" href="{{asset('/assets/css/arabic-global.css')}}?v={{ time() }}">
          @endif
          
          <!-- Favourites CSS -->
          <link rel="stylesheet" href="{{asset('/assets/css/favourites.css')}}?v=1.1">
          {{-- SweetAlert2 CSS - Global --}}
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        @yield('css')

        {{-- Google Analytics (GA4) --}}
        @if(!empty($footerContactInfo->google_analytics))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $footerContactInfo->google_analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $footerContactInfo->google_analytics }}');
        </script>
        @endif

        {{-- Facebook Pixel --}}
        @if(!empty($footerContactInfo->facebook_pixel))
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $footerContactInfo->facebook_pixel }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $footerContactInfo->facebook_pixel }}&ev=PageView&noscript=1"/></noscript>
        @endif

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
    
    <!-- Favourites JS -->
    <script src="{{ asset('/js/favourites.js') }}?v=1.1" defer></script>

    <!-- Analytics Beacon -->
    <script src="{{ asset('/js/analytics.js') }}?v=1.0" defer></script>
    
    @yield('js')

</body>

</html>