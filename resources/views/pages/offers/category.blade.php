@extends('layouts.master')
@section('title' , (app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english) . ' - ' . __('lang.offers'))
@section('seo_desc', app()->getLocale() == 'ar' ? ($currentCategory->bio_arabic ?? $currentCategory->title_arabic) : ($currentCategory->bio_english ?? $currentCategory->title_english))
@section('seo_tags', (app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english) . ', ' . __('lang.offers'))

@php
    // Helper function to build offer URL with emirate_id if filtered
    $offerUrl = function($slug) {
        $params = ['slug' => $slug];
        if (request()->filled('emirate_id')) {
            $params['emirate_id'] = request('emirate_id');
        }
        return route('offers.show', $params);
    };
@endphp

@section('content')


<section class="pb-8 page-title shadow">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offers.index') }}">{{ __('lang.offers') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english }}</li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english }}</h1>
        </nav>
    </div>
</section>


<section class="pt-8 pb-11 offers-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-8 mb-lg-0">
                <div class="row align-items-sm-center mb-6">
                    <div class="col-md-6">
                        <h2 class="fs-15 text-dark mb-0">{{ __('lang.we_found') }} <span class="text-primary">{{ $offers->total() }}</span> {{ __('lang.offers_available') }}</h2>
                    </div>
                    <div class="col-md-6 mt-6 mt-md-0">
                        <div class="d-flex justify-content-md-end align-items-center">
                            <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                                <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3"
                                       for="inputGroupSelect01"><i class="fas fa-align-left fs-16 pr-2"></i>{{ __('lang.sortby') }}:</label>
                                <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby"
                                        data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3"
                                        id="inputGroupSelect01" name="sortby">
                                    <option selected>{{ __('lang.newest') }}</option>
                                    <option value="1">{{ __('lang.oldest') }}</option>
                                </select>
                            </div>
                            <div class="d-none d-md-block">
                                <a class="fs-sm-18 text-dark view-toggle" href="#" id="listViewBtn" data-view="list">
                                    <i class="fas fa-list"></i>
                                </a>
                                <a class="fs-sm-18 text-dark ml-5 view-toggle active" href="#" id="gridViewBtn" data-view="grid">
                                    <i class="fa fa-th-large"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Grid View --}}
                <div class="row" id="gridView">
                    @forelse($offers as $offer)
                    <div class="col-md-6 mb-6">
                        <div class="offer-card position-relative rounded-lg" data-animate="fadeInUp">
                            {{-- Offer Image with Gradient Overlay --}}
                            <div class="offer-card-image position-relative">
                                <a href="{{ $offerUrl($offer->slug) }}">
                                    <img src="{{ url('/storage' . $offer->main_image) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}"
                                         class="w-100">
                                </a>
                                
                                {{-- Gradient Overlay --}}
                                <div class="offer-gradient-overlay"></div>
                                
                                {{-- Price Tag --}}
                                @if($offer->default_price && $offer->currency)
                                <div class="offer-price-tag">
                                    <span class="price-label">{{ __('lang.starting_from') }}</span>
                                    <span class="price-value">{{ $offer->currency->abbreviation ?? 'AED' }} {{ number_format($offer->default_price->price) }}</span>
                                    @if($offer->default_price->emirate)
                                    <span class="price-emirate">{{ app()->getLocale() == 'ar' ? $offer->default_price->emirate->title_arabic : $offer->default_price->emirate->title_english }}</span>
                                    @endif
                                </div>
                                @endif
                                
                                {{-- Top Badges --}}
                                <div class="offer-badges position-absolute">
                                    <span class="badge badge-offer">{{ __('lang.special_offer') }}</span>
                                    @if($offer->sqft)
                                    <span class="badge badge-area">{{ number_format($offer->sqft) }} {{ __('lang.sqft') }}</span>
                                    @endif
                                </div>
                                
                                {{-- Media Count --}}
                                <div class="offer-media-count position-absolute">
                                    @if($offer->total_images > 0)
                                    <span class="media-item" data-toggle="tooltip" title="{{ $offer->total_images }} {{ __('lang.images') }}">
                                        <i class="far fa-images"></i> {{ $offer->total_images }}
                                    </span>
                                    @endif
                                    @if($offer->video_count > 0)
                                    <span class="media-item" data-toggle="tooltip" title="{{ $offer->video_count }} {{ __('lang.videos') }}">
                                        <i class="far fa-play-circle"></i> {{ $offer->video_count }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Offer Content --}}
                            <div class="offer-card-body bg-white p-4">
                                {{-- Category --}}
                                <div class="offer-category mb-2">
                                    @if($offer->category)
                                    <a href="{{ route('offers.category', $offer->category->slug) }}" class="text-primary font-weight-500 fs-13 hover-secondary">
                                        {{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}
                                    </a>
                                    @endif
                                    @if($offer->subcategory)
                                    <span class="mx-1 text-muted">/</span>
                                    <a href="{{ route('offers.subcategory', $offer->subcategory->slug) }}" class="text-gray-light fs-13 hover-primary">
                                        {{ app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english }}
                                    </a>
                                    @endif
                                </div>
                                
                                {{-- Title --}}
                                <h3 class="offer-title fs-18 font-weight-600 lh-14 mb-3">
                                    <a href="{{ $offerUrl($offer->slug) }}" class="text-heading hover-primary">
                                        {{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}
                                    </a>
                                </h3>
                                
                                {{-- Specifications --}}
                                @if($offer->specifications->count() > 0)
                                <ul class="list-inline d-flex mb-0 flex-wrap mr-n5 offer-specs">
                                    @foreach($offer->specifications->take(3) as $spec)
                                    @if($spec->specification)
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                                        data-toggle="tooltip" 
                                        title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                                        @if($spec->specification->icon)
                                        <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                             alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                                             class="mr-2 spec-icon" 
                                             style="width: 24px; height: 24px; object-fit: contain;">
                                        @else
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-2 spec-icon-placeholder" 
                                              style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                                            {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                                        </span>
                                        @endif
                                        <span class="spec-value">{{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}</span>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            
                            {{-- Footer with CTA --}}
                            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                <p class="fs-17 font-weight-bold text-heading mb-0">
                                    @if($offer->sqm)
                                    {{ number_format($offer->sqm) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqm') }}</span>
                                    @endif
                                </p>
                                <a href="{{ $offerUrl($offer->slug) }}" class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                                    {{ __('lang.view_offer') }}
                                    <i class="far fa-long-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            {{ __('lang.no_offers_found') }}
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- List View --}}
                <div class="row" id="listView" style="display: none;">
                    @forelse($offers as $offer)
                    <div class="col-12 mb-6">
                        <div class="offer-card position-relative rounded-lg" data-animate="fadeInUp">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <div class="offer-card-image-list position-relative h-100">
                                        <a href="{{ $offerUrl($offer->slug) }}">
                                            <img src="{{ url('/storage' . $offer->main_image) }}" 
                                                 class="h-100 w-100 object-fit-cover"
                                                 alt="{{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}">
                                        </a>
                                        
                                        {{-- Gradient Overlay --}}
                                        <div class="offer-gradient-overlay"></div>
                                        
                                        {{-- Price Tag --}}
                                        @if($offer->default_price && $offer->currency)
                                        <div class="offer-price-tag">
                                            <span class="price-label">{{ __('lang.starting_from') }}</span>
                                            <span class="price-value">{{ $offer->currency->abbreviation ?? 'AED' }} {{ number_format($offer->default_price->price) }}</span>
                                        </div>
                                        @endif
                                        
                                        {{-- Top Badges --}}
                                        <div class="offer-badges position-absolute">
                                            <span class="badge badge-offer">{{ __('lang.special_offer') }}</span>
                                        </div>
                                        
                                        {{-- Media Count --}}
                                        <div class="offer-media-count position-absolute">
                                            @if($offer->total_images > 0)
                                            <span class="media-item">
                                                <i class="far fa-images"></i> {{ $offer->total_images }}
                                            </span>
                                            @endif
                                            @if($offer->video_count > 0)
                                            <span class="media-item">
                                                <i class="far fa-play-circle"></i> {{ $offer->video_count }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="offer-card-body bg-white p-4 d-flex flex-column h-100">
                                        {{-- Category --}}
                                        <div class="offer-category mb-2">
                                            @if($offer->category)
                                            <a href="{{ route('offers.category', $offer->category->slug) }}" class="text-primary font-weight-500 fs-13 hover-secondary">
                                                {{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}
                                            </a>
                                            @endif
                                            @if($offer->subcategory)
                                            <span class="mx-1 text-muted">/</span>
                                            <a href="{{ route('offers.subcategory', $offer->subcategory->slug) }}" class="text-gray-light fs-13 hover-primary">
                                                {{ app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english }}
                                            </a>
                                            @endif
                                        </div>
                                        
                                        {{-- Title --}}
                                        <h3 class="offer-title fs-18 font-weight-600 lh-14 mb-3">
                                            <a href="{{ $offerUrl($offer->slug) }}" class="text-heading hover-primary">
                                                {{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}
                                            </a>
                                        </h3>
                                        
                                        {{-- Specifications --}}
                                        @if($offer->specifications->count() > 0)
                                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n5 offer-specs">
                                            @foreach($offer->specifications->take(4) as $spec)
                                            @if($spec->specification)
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                                                data-toggle="tooltip" 
                                                title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                                                @if($spec->specification->icon)
                                                <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                                     alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                                                     class="mr-2 spec-icon" 
                                                     style="width: 24px; height: 24px; object-fit: contain;">
                                                @else
                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-2 spec-icon-placeholder" 
                                                      style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                                                    {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                                                </span>
                                                @endif
                                                <span class="spec-value">{{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}</span>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                        @endif
                                        
                                        <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                                            <p class="fs-17 font-weight-bold text-heading mb-0">
                                                @if($offer->sqm)
                                                {{ number_format($offer->sqm) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqm') }}</span>
                                                @endif
                                            </p>
                                            <a href="{{ $offerUrl($offer->slug) }}" class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                                                {{ __('lang.view_offer') }}
                                                <i class="far fa-long-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            {{ __('lang.no_offers_found') }}
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($offers->hasPages())
                <nav class="pt-4">
                    <ul class="pagination rounded-active justify-content-center mb-0">
                        {{-- Previous Page Link --}}
                        @if($offers->onFirstPage())
                        <li class="page-item disabled"><span class="page-link"><i class="far fa-angle-double-left"></i></span></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ $offers->previousPageUrl() }}"><i class="far fa-angle-double-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach($offers->getUrlRange(1, $offers->lastPage()) as $page => $url)
                            @if($page == $offers->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if($offers->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $offers->nextPageUrl() }}"><i class="far fa-angle-double-right"></i></a></li>
                        @else
                        <li class="page-item disabled"><span class="page-link"><i class="far fa-angle-double-right"></i></span></li>
                        @endif
                    </ul>
                </nav>
                @endif
            </div>
            @include('pages.offers.partials.filter-sidebar', [
                'formAction' => route('offers.category', $currentCategory->slug),
                'hideCategory' => true
            ])
        </div>
    </div>
</section>


@endsection

@section('css')
{{-- offers-section.css is already included in master layout --}}
@endsection

@section('js')
<script>
$(document).ready(function() {
    // View toggle functionality
    $('.view-toggle').on('click', function(e) {
        e.preventDefault();
        var view = $(this).data('view');
        
        // Update active state
        $('.view-toggle').removeClass('active opacity-2');
        $(this).addClass('active');
        $('.view-toggle').not(this).addClass('opacity-2');
        
        if (view === 'list') {
            $('#gridView').hide();
            $('#listView').show();
        } else {
            $('#listView').hide();
            $('#gridView').show();
        }
    });
    
    // Set initial state
    $('#listViewBtn').addClass('opacity-2');
});
</script>
@endsection

