@extends('layouts.master')
@section('title', __('lang.account_my_profile'))
@section('seo_desc', __('lang.account_portal_subtitle'))
@section('robots', 'noindex, nofollow')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/account-portal.css') }}?v={{ filemtime(public_path('assets/css/account-portal.css')) }}">
@endsection

@section('content')
@include('pages.account.partials.hero', [
    'title' => __('lang.account_my_profile'),
    'subtitle' => __('lang.account_portal_subtitle'),
])

<section class="account-section">
    <div class="container">
        <div class="account-grid">
            @include('pages.account.partials.nav')

            <div>
                <div class="account-card">
                    <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:12px;">
                        <div>
                            <h2 class="account-card__title">{{ __('lang.account_my_profile') }}</h2>
                            <p class="account-card__subtitle mb-0">{{ __('lang.account_portal_subtitle') }}</p>
                        </div>
                        <a href="{{ route('account.settings') }}" class="btn btn-account-outline">
                            <i class="fas fa-pen mr-2"></i> {{ __('lang.account_edit_profile') }}
                        </a>
                    </div>

                    <div class="account-data mt-4">
                        <div class="account-data__row">
                            <span class="account-data__label">{{ __('lang.account_full_name') }}</span>
                            <span class="account-data__value">{{ $user->name }}</span>
                        </div>
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
                        @if($user->pending_email)
                        <div class="account-data__row">
                            <span class="account-data__label">&nbsp;</span>
                            <span class="account-data__value">
                                <span class="account-badge account-badge--warn"><i class="fas fa-clock"></i> {{ $user->pending_email }}</span>
                            </span>
                        </div>
                        @endif
                        <div class="account-data__row">
                            <span class="account-data__label">{{ __('lang.account_phone') }}</span>
                            <span class="account-data__value">{{ $user->phone ?: '—' }}</span>
                        </div>
                        <div class="account-data__row">
                            <span class="account-data__label">{{ __('lang.account_preferred_language') }}</span>
                            <span class="account-data__value">
                                {{ ($user->preferred_locale ?? app()->getLocale()) === 'ar' ? __('lang.account_language_ar') : __('lang.account_language_en') }}
                            </span>
                        </div>
                        <div class="account-data__row">
                            <span class="account-data__label">{{ __('lang.account_member_since') }}</span>
                            <span class="account-data__value">{{ optional($user->created_at)->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@include('pages.account.partials.alerts')
@endsection
