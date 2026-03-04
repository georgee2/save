<!DOCTYPE html>
<html lang="<?php echo e(App::getLocale()); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="translate-url" content="<?php echo e(route('admin.translate')); ?>">
    <title><?php echo $__env->yieldContent('title' , env('APP_NAME')); ?></title>
    <link href="<?php echo e(asset('/css/icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/jquery.nestable.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/morris.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('/css/dropify.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/buttons.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/responsive.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/image-uploader.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/vanilla-calendar-min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/jquery.bootstrap-touchspin.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/lightbox.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/vanillaCalendar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/animation.css')); ?>">
    <!-- Favicon -->
    <link rel="stylesheet" href="<?php echo e(asset('css/breadcrumb.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/select2-custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/new-style.css')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('pic/fav.svg')); ?>">
    <link rel="shortcut icon" type="image/svg+xml" href="<?php echo e(asset('pic/fav.svg')); ?>">
    <style>
        .inner-announcements {
            overflow-y: scroll;
            max-height: 350px;
        }

        .dtr-data a {
            margin-bottom: 10px;
        }

    </style>
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body class="fixed-left">
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <div  id="wrapper">
        <?php if(Request::segment('2') == 'admin'): ?>
        <?php echo $__env->make('admin::includes.side', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(Request::segment('2') == 'basicdata'): ?>
        <?php echo $__env->make('basicdata::includes.side', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(Request::segment('2') == 'crm'): ?>
        <?php echo $__env->make('crm::includes.side', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <div  class="content-page">
            <div class="content">
                <?php echo $__env->make('admin::includes.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
                <?php echo $__env->make('admin::includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('/js/index.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/modernizr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.slimscroll.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/waves.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.nicescroll.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.scrollTo.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/morris.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/raphael-min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/buttons.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/buttons.colVis.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/responsive.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/datatables.init.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/lightbox.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/vanillaCalendar.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.bootstrap-touchspin.min.js')); ?>"></script>
    <!-- Chart JS -->
    <script src="<?php echo e(asset('/js/plugins/chart.js/chart.min.js')); ?>"></script>

    <!--Wysiwig js-->
    <script src="<?php echo e(asset('/js/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.form-editor.init.js')); ?>"></script> 
    
    <script src="<?php echo e(asset('/js/newJS.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/app.js')); ?>"></script>
    
    <?php if(session('success')): ?>
    <script>
        const message = '<?php echo e(session('success')); ?>';
        swal(
                {
                    title: 'success',
                    text: message,
                    icon: 'success',
                    confirmButtonClass: 'btn btn-success',
                }
            )
    </script>
    <?php elseif(session('error')): ?>
    <script>
        const message = '<?php echo e(session('error')); ?>';
        swal(
                {
                    text: message,
                    icon: 'error',
                    confirmButtonClass: 'btn btn-success',
                }
            )
    </script>
    <?php endif; ?>

    <script>
        window.addEventListener('load', function () {
      vanillaCalendar.init({
        disablePastDays: true
      });
    })
    </script>

    <script>
    
        // Select2
        $(".select2").select2();
    </script>

    <?php echo $__env->yieldContent('js'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/layouts/master.blade.php ENDPATH**/ ?>