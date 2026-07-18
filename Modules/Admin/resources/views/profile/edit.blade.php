@extends('admin::layouts.master')
@section('title', __('lang.staff_profile_title'))
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="{{ route('Admin') }}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-user"></i> {{ __('lang.staff_profile_title') }}</a>
        </nav>

        <div class="col-lg-8 mx-auto">
            <hr>

            {{-- Account details --}}
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">{{ __('lang.staff_profile_account') }}</h4>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">{{ __('lang.staff_profile_name') }}</label>
                            <input class="form-control" type="text" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">{{ __('lang.staff_profile_email') }}</label>
                            <input class="form-control" type="text" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    @if($user->password_set_at)
                    <p class="text-muted mb-0" style="font-size: 13px;">
                        <i class="fa fa-clock-o"></i>
                        {{ __('lang.staff_profile_password_updated') }}:
                        {{ \Carbon\Carbon::parse($user->password_set_at)->format('M d, Y - h:i A') }}
                    </p>
                    @endif
                </div>
            </div>

            {{-- Password reset --}}
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">{{ __('lang.staff_profile_security') }}</h4>
                    <hr>
                    <p class="text-muted">{{ __('lang.staff_reset_help') }}</p>
                    <form action="{{ route('admin.profile.password.email') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dark waves-effect waves-light">
                            <i class="fa fa-envelope-o mr-1"></i> {{ __('lang.staff_reset_button') }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
