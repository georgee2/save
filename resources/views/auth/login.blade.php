<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smart Vision Group</title>
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/new-style.css') }}">
    <link rel="shortcut icon" href="{{url('/pic/ficon1.png')}}" />
    @if (App::getLocale() == 'ar')
    <style>
        input,
        select,
        textarea,
        form {
            direction: rtl;
        }

        label {
            float: right;
        }
        span{
            text-align: right;
            display: block;
        }
    </style>
    @endif
</head>

<body>
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div style="background: url('{{url('/pic/login.png')}}');background-repeat: no-repeat;background-size: cover;" class="accountbg"></div>
    <div style=" float: left;clear: both;width: 100%;margin-left: 50px;min-height: 500px !important;max-height: 500px;" class="wrapper-page">



            <div style="width: 80%;"  class="card">
                <div class="card-body">

                    <h3 class="text-center m-0">
                        <a href="#" class="logo logo-admin">
                            <img  src="{{ asset('/pic/logo.png') }}" alt="logo" class="h-20 mx-auto" style="max-height: 200px;width: 60%;">
                        </a>
                    </h3>

                    <div class="p-3">
                        <h4 class=" font-18 m-b-5 text-center" style="color: #e64c29;">Welcome Back !</h4>


                            <form class="form-horizontal m-t-30" action="{{ route('checkuser') }}" method="POST">
                            @csrf
                            @include('admin::layouts.errors')
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="text" class="form-control" id="email" placeholder="Enter Your Mail" name="email">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if(session('error'))
                                <span class="text-danger">{{ session('error') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="userpassword">Password</label>
                                <input type="password" class="form-control" id="userpassword" placeholder="Enter password"
                                    name="password">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group m-t-20">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-primary w-md waves-effect waves-light main-color"
                                        type="submit">LogIn</button>
                                </div>
                            </div>

                        </form>
                            
                        <p class="font-800 font-14 text-dark text-center">© 2025 Content Management System. Developed by <a style="color: #e64c29;"  href="#"> <strong>SVG.</strong></a></p>
                    </div>

                </div>
        </div>
            
            

        

         <div class="m-t-20 ">
        <p hidden="hidden">Don't have an account ? <a href="pages-register.html"
                class="font-400 font-10"> Signup Now </a> </p>
        
    </div>
    </div>

    <!-- jQuery  -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('/js/waves.js') }}"></script>
    <script src="{{ asset('/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('/js/jquery.scrollTo.min.js') }}"></script>

    {{-- {{-- <!-- App js --> --}}
    <script src="{{ asset('/js/app.js') }}"> </script> 
</body>

</html>