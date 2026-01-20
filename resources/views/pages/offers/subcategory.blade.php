@extends('layouts.master')
@section('title' , (app()->getLocale() == 'ar' ? $currentSubcategory->title_arabic : $currentSubcategory->title_english) . ' - ' . __('lang.offers'))
@section('seo_desc', app()->getLocale() == 'ar' ? ($currentSubcategory->bio_arabic ?? $currentSubcategory->title_arabic) : ($currentSubcategory->bio_english ?? $currentSubcategory->title_english))
@section('seo_tags', (app()->getLocale() == 'ar' ? $currentSubcategory->title_arabic : $currentSubcategory->title_english) . ', ' . __('lang.offers'))

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
                @if($currentCategory)
                <li class="breadcrumb-item"><a href="{{ route('offers.category', $currentCategory->slug) }}">{{ app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ app()->getLocale() == 'ar' ? $currentSubcategory->title_arabic : $currentSubcategory->title_english }}</li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ app()->getLocale() == 'ar' ? $currentSubcategory->title_arabic : $currentSubcategory->title_english }}</h1>
        </nav>
    </div>
</section>

{{-- Subcategory Filter Slider (Sibling subcategories from same category) --}}
@if(isset($subcategoriesWithCount) && $subcategoriesWithCount->count() > 0)
<section class="subcategory-filter-section">
    <div class="container">
        <div class="subcategory-filter-slider slick-slider" 
             data-slick-options='{"slidesToShow": 6, "slidesToScroll": 2, "autoplay": false, "dots": false, "arrows": true, "infinite": false, "responsive":[{"breakpoint": 1400,"settings": {"slidesToShow": 5, "arrows": true}},{"breakpoint": 1200,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 992,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 768,"settings": {"slidesToShow": 3, "arrows": true}},{"breakpoint": 576,"settings": {"slidesToShow": 2, "arrows": false}}]}'>
            
            {{-- All Subcategories in Category Option --}}
            <div class="box">
                <a href="{{ route('offers.category', $currentCategory->slug) }}" 
                   class="subcategory-filter-item all-item">
                    <div class="subcategory-filter-icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <p class="subcategory-filter-title">{{ __('lang.all') }}</p>
                    <span class="subcategory-filter-count">{{ app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english }}</span>
                </a>
            </div>
            
            {{-- Subcategory Items --}}
            @foreach($subcategoriesWithCount as $subcat)
            <div class="box">
                <a href="{{ route('offers.subcategory', $subcat->slug) }}" 
                   class="subcategory-filter-item {{ $currentSubcategory->id == $subcat->id ? 'active' : '' }}">
                    <div class="subcategory-filter-icon">
                        @if($subcat->icon)
                        <img src="{{ url('/storage' . $subcat->icon) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english }}">
                        @else
                        <i class="fas fa-folder"></i>
                        @endif
                    </div>
                    <p class="subcategory-filter-title">{{ app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english }}</p>
                    <span class="subcategory-filter-count">{{ $subcat->offers_count }} {{ __('lang.offers') }}</span>
                </a>
            </div>
            @endforeach
            
        </div>
    </div>
</section>
@endif

<section class="pt-8 pb-11 offers-page">
    <div class="container">
        {{-- Mobile Filter Overlay --}}
        <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>
        
        <div class="row">
            {{-- Main Offers Container --}}
            <div class="offers-main-container filter-hidden mb-8 mb-lg-0" id="offersContainer">
                <div class="row align-items-sm-center mb-6">
                    <div class="col-md-6">
                        <h2 class="fs-15 text-dark mb-0">{{ __('lang.we_found') }} <span class="text-primary">{{ $offers->total() }}</span> {{ __('lang.offers_available') }}</h2>
                    </div>
                    <div class="col-md-6 mt-6 mt-md-0">
                        <div class="d-flex justify-content-md-end align-items-center flex-wrap">
                            {{-- Filter Toggle Button --}}
                            <button type="button" class="filter-toggle-btn mr-3" id="filterToggleBtn">
                                <i class="fas fa-filter"></i>
                                <span class="d-none d-sm-inline">{{ __('lang.filter') }}</span>
                                @php
                                    $activeFilters = 0;
                                    if(request('keyword')) $activeFilters++;
                                    if(request('style_id')) $activeFilters++;
                                    if(request('type_id')) $activeFilters++;
                                    if(request('emirate_id')) $activeFilters++;
                                    if(request('sqft_min') || request('sqft_max')) $activeFilters++;
                                    if(request('sqm_min') || request('sqm_max')) $activeFilters++;
                                    if(request('price_min') || request('price_max')) $activeFilters++;
                                @endphp
                                @if($activeFilters > 0)
                                <span class="filter-count">{{ $activeFilters }}</span>
                                @endif
                            </button>
                            
                            <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                                <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3"
                                       for="sortbySelect"><i class="fas fa-align-left fs-16 pr-2"></i><span class="d-none d-sm-inline">{{ __('lang.sortby') }}:</span></label>
                                <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby-select"
                                        data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3"
                                        id="sortbySelect" name="sortby">
                                    <option value="newest" {{ request('sortby', 'newest') == 'newest' ? 'selected' : '' }}>{{ __('lang.newest') }}</option>
                                    <option value="oldest" {{ request('sortby') == 'oldest' ? 'selected' : '' }}>{{ __('lang.oldest') }}</option>
                                    <option value="price_low" {{ request('sortby') == 'price_low' ? 'selected' : '' }}>{{ __('lang.price_low_to_high') }}</option>
                                    <option value="price_high" {{ request('sortby') == 'price_high' ? 'selected' : '' }}>{{ __('lang.price_high_to_low') }}</option>
                                    <option value="area_low" {{ request('sortby') == 'area_low' ? 'selected' : '' }}>{{ __('lang.area_low_to_high') }}</option>
                                    <option value="area_high" {{ request('sortby') == 'area_high' ? 'selected' : '' }}>{{ __('lang.area_high_to_low') }}</option>
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
                                
                                {{-- Media Count --}}
                                <a href="{{ $offerUrl($offer->slug) }}" class="offer-media-count position-absolute">
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
                                </a>
                            </div>
                            
                            {{-- Offer Code Badge with Copy & Share --}}
                            @if($offer->offer_code)
                            <div class="offer-code-badge">
                                <span class="code-value">{{ $offer->offer_code }}</span>
                                <div class="code-actions">
                                    <button type="button" class="code-action-btn copy-code-btn" 
                                            data-code="{{ $offer->offer_code }}" 
                                            data-toggle="tooltip" 
                                            data-placement="left"
                                            title="{{ __('lang.copy_code') }}">
                                        <i class="far fa-copy"></i>
                                    </button>
                                    {{-- Share Slide Out --}}
                                    <div class="share-slide-wrapper">
                                        <button type="button" class="code-action-btn share-slide-btn">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                        <div class="share-slide-icons">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($offerUrl($offer->slug)) }}" 
                                               target="_blank" class="code-action-btn facebook-btn">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($offerUrl($offer->slug)) }}&text={{ urlencode(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english) }}" 
                                               target="_blank" class="code-action-btn twitter-btn">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($offerUrl($offer->slug)) }}" 
                                               target="_blank" class="code-action-btn linkedin-btn">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                            <a href="https://www.instagram.com/" 
                                               target="_blank" class="code-action-btn instagram-btn">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                            <a href="mailto:?subject={{ rawurlencode(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english) }}&body={{ urlencode($offerUrl($offer->slug)) }}" 
                                               class="code-action-btn email-btn">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- WhatsApp Separate --}}
                                    <a href="https://wa.me/?text={{ urlencode($offerUrl($offer->slug)) }}" 
                                       target="_blank" 
                                       class="code-action-btn whatsapp-share-btn" 
                                       data-toggle="tooltip" 
                                       data-placement="left"
                                       title="{{ __('lang.share_whatsapp') }}">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                            
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
                                    @if($offer->sqft)
                                    {{ number_format($offer->sqft) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqft') }}</span>
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
                                        
                                        {{-- Media Count --}}
                                        <a href="{{ $offerUrl($offer->slug) }}" class="offer-media-count position-absolute">
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
                                        </a>
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
                                                @if($offer->sqft)
                                                {{ number_format($offer->sqft) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqft') }}</span>
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
            
            {{-- Filter Sidebar Wrapper --}}
            <div class="filter-sidebar-wrapper hidden" id="filterSidebarWrapper">
                {{-- Mobile Filter Header --}}
                <div class="mobile-filter-header d-lg-none">
                    <h4>{{ __('lang.filter') }}</h4>
                    <button type="button" class="mobile-filter-close" id="mobileFilterClose">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                
                @include('pages.offers.partials.new-filter-sidebar', [
                    'formAction' => route('offers.subcategory', $currentSubcategory->slug),
                    'categories' => $categories,
                    'subcategories' => $subcategories,
                    'types' => $types,
                    'styles' => $styles,
                    'emirates' => $emirates,
                    'hideCategory' => true,
                    'hideSubcategory' => true
                ])
            </div>
        </div>
    </div>
</section>


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/offers-filter.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/area-slider.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
// Copy Code functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.copy-code-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var code = this.getAttribute('data-code');
            navigator.clipboard.writeText(code).then(function() {
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML = '<i class="far fa-copy"></i>';
                }, 2000);
            });
        });
    });
});

$(document).ready(function() {
    // Filter Toggle Functionality
    var filterToggleBtn = $('#filterToggleBtn');
    var filterSidebar = $('#filterSidebarWrapper');
    var offersContainer = $('#offersContainer');
    var mobileFilterOverlay = $('#mobileFilterOverlay');
    var mobileFilterClose = $('#mobileFilterClose');
    var body = $('body');
    
    // Check if we're on mobile
    function isMobile() {
        return window.innerWidth <= 991;
    }
    
    // Toggle filter visibility
    filterToggleBtn.on('click', function() {
        if (isMobile()) {
            filterSidebar.toggleClass('visible hidden');
            mobileFilterOverlay.toggleClass('active');
            body.toggleClass('filter-open');
        } else {
            filterSidebar.toggleClass('visible hidden');
            offersContainer.toggleClass('filter-visible filter-hidden');
        }
        $(this).toggleClass('active');
    });
    
    // Close mobile filter
    mobileFilterClose.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    // Close on overlay click
    mobileFilterOverlay.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if (!isMobile()) {
            mobileFilterOverlay.removeClass('active');
            body.removeClass('filter-open');
        }
    });
    
    // View toggle functionality
    $('.view-toggle').on('click', function(e) {
        e.preventDefault();
        var view = $(this).data('view');
        
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
    
    $('#listViewBtn').addClass('opacity-2');
    
    // Initialize SQFT Range Slider
    var sqftMinDefault = 50;
    var sqftMaxDefault = 15000;
    var sqftMinVal = {{ request('sqft_min', 50) ?: 50 }};
    var sqftMaxVal = {{ request('sqft_max', 15000) ?: 15000 }};
    
    $("#sqft-slider").slider({
        range: true,
        min: sqftMinDefault,
        max: sqftMaxDefault,
        values: [sqftMinVal, sqftMaxVal],
        slide: function(event, ui) {
            $("#sqft-range-display").text(ui.values[0] + " {{ __('lang.sqft') }} {{ __('lang.to') }} " + ui.values[1] + " {{ __('lang.sqft') }}");
            $("#sqft_min").val(ui.values[0]);
            $("#sqft_max").val(ui.values[1]);
        },
        stop: function(event, ui) {
            if (ui.values[0] !== sqftMinDefault || ui.values[1] !== sqftMaxDefault) {
                $('#offerFilterForm').submit();
            }
        }
    });
    $("#sqft-range-display").text(sqftMinVal + " {{ __('lang.sqft') }} {{ __('lang.to') }} " + sqftMaxVal + " {{ __('lang.sqft') }}");
    
    // Initialize SQM Range Slider
    var sqmMinDefault = 5;
    var sqmMaxDefault = 1400;
    var sqmMinVal = {{ request('sqm_min', 5) ?: 5 }};
    var sqmMaxVal = {{ request('sqm_max', 1400) ?: 1400 }};
    
    $("#sqm-slider").slider({
        range: true,
        min: sqmMinDefault,
        max: sqmMaxDefault,
        values: [sqmMinVal, sqmMaxVal],
        slide: function(event, ui) {
            $("#sqm-range-display").text(ui.values[0] + " {{ __('lang.sqm') }} {{ __('lang.to') }} " + ui.values[1] + " {{ __('lang.sqm') }}");
            $("#sqm_min").val(ui.values[0]);
            $("#sqm_max").val(ui.values[1]);
        },
        stop: function(event, ui) {
            if (ui.values[0] !== sqmMinDefault || ui.values[1] !== sqmMaxDefault) {
                $('#offerFilterForm').submit();
            }
        }
    });
    $("#sqm-range-display").text(sqmMinVal + " {{ __('lang.sqm') }} {{ __('lang.to') }} " + sqmMaxVal + " {{ __('lang.sqm') }}");
    
    // Sort by change - auto submit
    $('.sortby-select').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    $('#sortbySelect').on('change', function() {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    // Auto-submit for filter dropdowns
    $('.filter-select').on('changed.bs.select', function() {
        $('#offerFilterForm').submit();
    });
    
    // Close filter on escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && filterSidebar.hasClass('visible') && isMobile()) {
            filterSidebar.removeClass('visible').addClass('hidden');
            mobileFilterOverlay.removeClass('active');
            body.removeClass('filter-open');
            filterToggleBtn.removeClass('active');
        }
    });
});
</script>
@endsection

