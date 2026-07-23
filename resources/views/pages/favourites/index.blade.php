@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('favourites'); @endphp
@section('title', $seo['title'] ?? __('lang.my_favourites'))
@section('seo_desc', $seo['description'] ?? __('lang.my_favourites'))
@section('seo_tags', $seo['tags'] ?? __('lang.my_favourites'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/favourites-page.css') }}?v=1.9">
@endsection

@section('content')
<section class="favourites-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.favourites') }}</li>
            </ol>
        </nav>
        <h1><i class="fal fa-heart"></i> {{ __('lang.my_favourites') }}</h1>
        <p>{{ $totalCount }} {{ __('lang.favourite_items') }}</p>
        @if($totalCount > 0)
        <div class="fav-ref-id" id="favRefId" data-id="{{ $favouriteId }}">
            <span class="fav-ref-label">{{ __('lang.reference_id') }}:</span>
            <span class="fav-ref-code">{{ $favouriteId }}</span>
            <button class="fav-ref-copy" onclick="copyRefId()" title="{{ __('lang.copy_link') }}"><i class="fal fa-copy"></i></button>
        </div>
        <p class="fav-expiry-hint"><i class="fal fa-clock"></i> {{ __('lang.fav_expiry_hint') }}</p>
        @endif
    </div>
</section>

@include('pages.favourites.partials.list')
@endsection

@section('js')
@include('pages.favourites.partials.scripts')
@endsection
