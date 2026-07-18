@extends('layouts.master')
@section('title', __('lang.account_dashboard'))
@section('seo_desc', __('lang.account_portal_subtitle'))
@section('robots', 'noindex, nofollow')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/account-portal.css') }}?v={{ filemtime(public_path('assets/css/account-portal.css')) }}">
@endsection

@section('content')
@include('pages.account.partials.hero', [
    'title' => __('lang.account_dashboard'),
    'subtitle' => __('lang.account_portal_subtitle'),
])

<section class="account-section">
    <div class="container">
        <div class="account-grid">
            @include('pages.account.partials.nav')

            <div>
                <div class="account-card">
                    <h2 class="account-card__title">{{ __('lang.account_welcome') }}, {{ $user->name }}</h2>
                    <p class="account-card__subtitle">{{ __('lang.account_portal_subtitle') }}</p>

                    <div class="account-data">
                        <div class="account-data__row">
                            <span class="account-data__label">{{ __('lang.account_email') }}</span>
                            <span class="account-data__value">
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="account-badge account-badge--ok"><i class="fas fa-check"></i> {{ __('lang.account_email_verified') }}</span>
                                @else
                                    <span class="account-badge account-badge--warn"><i class="fas fa-exclamation"></i> {{ __('lang.account_email_unverified') }}</span>
                                @endif
                            </span>
                        </div>
                        @if($user->phone)
                        <div class="account-data__row">
                            <span class="account-data__label">{{ __('lang.account_phone') }}</span>
                            <span class="account-data__value">{{ $user->phone }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="alert alert-info mt-4 mb-4">
                        <i class="fas fa-info-circle mr-2"></i> {{ __('lang.account_projects_coming_soon') }}
                    </div>

                    <a href="{{ route('account.profile') }}" class="btn btn-account">
                        <i class="fas fa-user mr-2"></i> {{ __('lang.account_my_profile') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@include('pages.account.partials.alerts')
@endsection
