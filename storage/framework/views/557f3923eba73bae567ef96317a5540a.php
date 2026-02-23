<!DOCTYPE html>
<html lang="<?php echo e(App::getLocale()); ?>" dir="<?php echo e(App::getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="<?php echo $__env->yieldContent('seo_desc'); ?>" name="description">
        <meta content="<?php echo $__env->yieldContent('seo_tags'); ?>" name="keywords">
        <title><?php echo $__env->yieldContent('title' , env('APP_NAME')); ?></title>
        
        
        <?php if (! empty(trim($__env->yieldContent('og_title')))): ?>
        <meta property="og:title" content="<?php echo $__env->yieldContent('og_title'); ?>">
        <?php else: ?>
        <meta property="og:title" content="<?php echo $__env->yieldContent('title', env('APP_NAME')); ?>">
        <?php endif; ?>
        
        <?php if (! empty(trim($__env->yieldContent('og_description')))): ?>
        <meta property="og:description" content="<?php echo $__env->yieldContent('og_description'); ?>">
        <?php else: ?>
        <meta property="og:description" content="<?php echo $__env->yieldContent('seo_desc'); ?>">
        <?php endif; ?>
        
        <?php if (! empty(trim($__env->yieldContent('og_image')))): ?>
        <meta property="og:image" content="<?php echo $__env->yieldContent('og_image'); ?>">
        <?php else: ?>
        <meta property="og:image" content="<?php echo e(asset('assets/images/og-default.jpg')); ?>">
        <?php endif; ?>
        
        <meta property="og:url" content="<?php echo e(url()->current()); ?>">
        <meta property="og:type" content="<?php echo $__env->yieldContent('og_type', 'website'); ?>">
        <meta property="og:site_name" content="<?php echo e(env('APP_NAME')); ?>">
        <meta property="og:locale" content="<?php echo e(app()->getLocale() == 'ar' ? 'ar_AE' : 'en_US'); ?>">
        
        
        <meta name="twitter:card" content="summary_large_image">
        <?php if (! empty(trim($__env->yieldContent('og_title')))): ?>
        <meta name="twitter:title" content="<?php echo $__env->yieldContent('og_title'); ?>">
        <?php else: ?>
        <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', env('APP_NAME')); ?>">
        <?php endif; ?>
        
        <?php if (! empty(trim($__env->yieldContent('og_description')))): ?>
        <meta name="twitter:description" content="<?php echo $__env->yieldContent('og_description'); ?>">
        <?php else: ?>
        <meta name="twitter:description" content="<?php echo $__env->yieldContent('seo_desc'); ?>">
        <?php endif; ?>
        
        <?php if (! empty(trim($__env->yieldContent('og_image')))): ?>
        <meta name="twitter:image" content="<?php echo $__env->yieldContent('og_image'); ?>">
        <?php else: ?>
        <meta name="twitter:image" content="<?php echo e(asset('assets/images/og-default.jpg')); ?>">
        <?php endif; ?>
        
        <?php echo $__env->yieldContent('meta_tags'); ?>
        <!--==============================
            All CSS File
        ============================== -->

        <!-- Favicon -->
          <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('pic/fav.svg')); ?>">
          <link rel="shortcut icon" type="image/svg+xml" href="<?php echo e(asset('pic/fav.svg')); ?>">

          <!-- Mobile Hero Optimization -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/mobile-hero.css')); ?>">

          <!-- Google fonts -->
          <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet">
          <!-- Vendors CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/fontawesome-pro-5/css/all.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/bootstrap-select/css/bootstrap-select.min.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/slick/slick.min.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/magnific-popup/magnific-popup.min.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/jquery-ui/jquery-ui.min.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/chartjs/Chart.min.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/dropzone/css/dropzone.min.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/animate.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/timepicker/bootstrap-timepicker.min.css')); ?>">
          <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/mapbox-gl/mapbox-gl.min.css')); ?>">
          <!-- Themes core CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/themes.css')); ?>">
          <!-- Custom Sections CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/custom-sections.css')); ?>">
          <!-- Category/Projects Page CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/category-page.css')); ?>">
          <!-- Offers Section CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/offers-section.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Services Section CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/services-section.css')); ?>">
          <!-- Interior Gallery CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/interior-gallery.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Global Search CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/global-search.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Section Divider CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/section-divider.css')); ?>">
          <!-- Why Choose Us CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/why-choose-us.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Home Projects CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/home-projects.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Home Contact & FAQ CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/home-contact-faq.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Home News CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/home-news.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Footer CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/footer.css')); ?>">
          <!-- Area Slider CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/area-slider.css')); ?>">
          <!-- Preloader CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/preloader.css')); ?>">
          <!-- Topbar CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/topbar.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Header CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/header.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Mobile Header CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/mobile-header.css')); ?>?v=<?php echo e(time()); ?>">
          <!-- Mobile Bottom Nav CSS -->
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/mobile-bottom-nav.css')); ?>?v=<?php echo e(time()); ?>">
          
          <!-- RTL CSS for Arabic -->
          <?php if(app()->getLocale() == 'ar'): ?>
          <link rel="stylesheet" href="<?php echo e(asset('/assets/css/rtl.css')); ?>?v=<?php echo e(time()); ?>">
          <?php endif; ?>
          
          
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <?php echo $__env->yieldContent('css'); ?>

    </head>

    <body>
      <?php echo $__env->make('includes.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('includes.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <main id="content">
        <?php echo $__env->make('includes.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->yieldContent('content'); ?>

      </main>
      <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('includes.mobile-bottom-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('includes.language-switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



        <!-- Vendors scripts -->
        <script src="<?php echo e(asset('/assets/vendors/jquery.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/bootstrap/bootstrap.bundle.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/bootstrap-select/js/bootstrap-select.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/slick/slick.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/waypoints/jquery.waypoints.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/counter/countUp.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/magnific-popup/jquery.magnific-popup.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/chartjs/Chart.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/dropzone/js/dropzone.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/timepicker/bootstrap-timepicker.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/hc-sticky/hc-sticky.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/jparallax/TweenMax.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/assets/vendors/mapbox-gl/mapbox-gl.js')); ?>"></script>
        <!-- Theme scripts -->
        <script src="<?php echo e(asset('/assets/js/theme.js')); ?>"></script>
        
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
   
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php echo $__env->yieldContent('js'); ?>

</body>

</html><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/layouts/master.blade.php ENDPATH**/ ?>