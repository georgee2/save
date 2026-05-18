<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="translate-url" content="{{ route('admin.translate') }}">
    <title>@yield('title' , env('APP_NAME'))</title>
    <link href="{{asset('/css/icons.css')}}" rel="stylesheet">
    <link href="{{asset('/css/jquery.nestable.css')}}" rel="stylesheet">
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('/css/morris.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/image-uploader.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/vanilla-calendar-min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/jquery.bootstrap-touchspin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vanillaCalendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <!-- Favicon -->
    <link rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-style.css') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('pic/fav.svg') }}">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('pic/fav.svg') }}">
    <style>
        .inner-announcements {
            overflow-y: scroll;
            max-height: 350px;
        }

        .dtr-data a {
            margin-bottom: 10px;
        }

        /* Tagify mirrors form-control onto its <tags> wrapper, inheriting Bootstrap's fixed 38px height.
           Override so the wrapper grows with wrapped chips instead of overflowing the next field. */
        tags.tagify.form-control {
            height: auto;
            min-height: calc(1.5em + .75rem + 2px);
        }

    </style>
    @yield('css')
</head>

<body class="fixed-left">
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <div  id="wrapper">
        @if(Request::segment('2') == 'admin')
        @include('admin::includes.side')
        @elseif(Request::segment('2') == 'basicdata')
        @include('basicdata::includes.side')
        @elseif(Request::segment('2') == 'crm')
        @include('crm::includes.side')
        @endif

        <div  class="content-page">
            <div class="content">
                @include('admin::includes.topbar')
                @yield('content')
                @include('admin::includes.footer')
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/index.js') }}"></script>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('/js/waves.js') }}"></script>
    <script src="{{ asset('/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('/js/morris.min.js')}}"></script>
    <script src="{{ asset('/js/raphael-min.js') }}"></script>
    <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/js/datatables.init.js') }}"></script>
    <script src="{{ asset('/js/select2.min.js') }}"></script>
    <script src="{{ asset('/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('/js/vanillaCalendar.js') }}"></script>
    <script src="{{ asset('/js/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('/js/plugins/chart.js/chart.min.js') }}"></script>

    <!--Wysiwig js-->
    <script src="{{ asset('/js/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.form-editor.init.js') }}"></script> 
    
    <script src="{{ asset('/js/newJS.js') }}"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    
    @if(session('success'))
    <script>
        const message = '{{ session('success') }}';
        swal(
                {
                    title: 'success',
                    text: message,
                    icon: 'success',
                    confirmButtonClass: 'btn btn-success',
                }
            )
    </script>
    @elseif(session('error'))
    <script>
        const message = '{{ session('error') }}';
        swal(
                {
                    text: message,
                    icon: 'error',
                    confirmButtonClass: 'btn btn-success',
                }
            )
    </script>
    @endif

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

    @yield('js')
    @stack('scripts')
</body>

</html>