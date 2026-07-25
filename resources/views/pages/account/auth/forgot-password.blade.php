@extends('layouts.master')
@section('title', __('lang.account_forgot_title'))
@section('seo_desc', __('lang.account_forgot_subtitle'))
@section('robots', 'noindex, nofollow')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/account-portal.css') }}?v={{ filemtime(public_path('assets/css/account-portal.css')) }}">
@endsection

@section('content')
@include('pages.account.partials.hero', [
    'title' => __('lang.account_forgot_title'),
    'subtitle' => __('lang.account_forgot_subtitle'),
    'guest' => true,
])

<section class="account-section">
    <div class="container">
        <div class="account-auth-wrap">
            <div class="account-card">
                <h2 class="account-card__title">{{ __('lang.account_forgot_title') }}</h2>
                <p class="account-card__subtitle">{{ __('lang.account_forgot_subtitle') }}</p>

                <form method="POST" action="{{ route('password.email') }}" class="account-form">
                    @csrf
                    @include('includes.form-guard')
                    <div class="form-group">
                        <label for="email">{{ __('lang.account_email') }}</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn btn-account w-100">
                        <i class="fas fa-paper-plane mr-2"></i> {{ __('lang.account_send_reset_link') }}
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    <a href="{{ route('login') }}" style="color:var(--acc-primary);font-weight:600;">
                        <i class="fas fa-arrow-left mr-1"></i> {{ __('lang.account_back_to_login') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@include('pages.account.partials.alerts')
@endsection
