@extends('layouts.master')
@section('title', __('lang.account_favourites'))
@section('seo_desc', __('lang.account_portal_subtitle'))
@section('robots', 'noindex, nofollow')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/account-portal.css') }}?v={{ filemtime(public_path('assets/css/account-portal.css')) }}">
<link rel="stylesheet" href="{{ asset('/assets/css/favourites-page.css') }}?v=1.9">
@endsection

@section('content')
@include('pages.account.partials.hero', [
    'title' => __('lang.account_favourites'),
    'subtitle' => $totalCount . ' ' . __('lang.favourite_items'),
])

<section class="account-section">
    <div class="container">
        <div class="account-grid">
            @include('pages.account.partials.nav')

            <div>
                @include('pages.favourites.partials.list')
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@include('pages.account.partials.alerts')
@include('pages.favourites.partials.scripts')
@endsection
