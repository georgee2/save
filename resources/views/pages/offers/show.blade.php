@extends('layouts.master')

@php
    $locale = app()->getLocale();

    // Smart SEO title for offers
    if ($offer->{"seo_title_{$locale}"}) {
        $offerTitle = $offer->{"seo_title_{$locale}"};
    } else {
        $offerTitle = $locale == 'ar' ? $offer->title_arabic : $offer->title_english;
    }

    $offerDesc = $offer->{"seo_description_{$locale}"} ?: ($locale == 'ar' ? $offer->title_arabic : $offer->title_english);
    $offerImage = url('/storage' . $offer->main_image);
    $offerAlt = $offer->{"alt_text_{$locale}"} ?? ($locale == 'ar' ? $offer->title_arabic : $offer->title_english);
    $offerPrice = ($offer->default_price && $offer->currency) 
        ? ($offer->currency->abbreviation ?? 'AED') . ' ' . number_format($offer->default_price->price)
        : '';
    $offerEmirate = ($offer->default_price && $offer->default_price->emirate)
        ? ($locale == 'ar' ? $offer->default_price->emirate->title_arabic : $offer->default_price->emirate->title_english)
        : '';
    $ogDescription = $offerDesc;
    if($offerPrice) {
        $ogDescription = $offerPrice . ($offerEmirate ? ' - ' . $offerEmirate : '') . ' | ' . $offerDesc;
    }
@endphp

@section('title', $offerTitle . ' - ' . __('lang.offers'))
@section('seo_desc', $offerDesc)
@section('seo_tags', $offer->seo_tags ?: $offerTitle)

{{-- Open Graph Meta Tags --}}
@section('og_title', $offerTitle . ($offerPrice ? ' - ' . $offerPrice : ''))
@section('og_description', $ogDescription)
@section('og_image', $offerImage)
@section('og_type', 'product')

@section('meta_tags')
@if($offerPrice)
<meta property="product:price:amount" content="{{ $offer->default_price->price ?? '' }}">
<meta property="product:price:currency" content="{{ $offer->currency->abbreviation ?? 'AED' }}">
@endif
@if($offer->offer_code)
<meta property="product:retailer_item_id" content="{{ $offer->offer_code }}">
@endif
@if($offer->default_price)
{{-- Product structured data is emitted ONLY when the offer has an active price,
     so it always includes the required "offers" node. Google rejects a Product
     that has none of offers / review / aggregateRating. Quote-based offers
     (no price) get no Product markup, which is valid. --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ e($offerTitle) }}",
    "description": "{{ e(Str::limit(strip_tags($offerDesc), 300)) }}",
    "image": "{{ $offerImage }}",
    "brand": {
        "@type": "Organization",
        "name": "Smart Vision Engineering Consultants"
    },
    "offers": {
        "@type": "Offer",
        "price": "{{ $offer->default_price->price }}",
        "priceCurrency": "{{ $offer->currency->abbreviation ?? 'AED' }}",
        "availability": "https://schema.org/InStock"
    }
}
</script>
@endif
@endsection

@section('content')


<section class="pb-8 page-title shadow">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offers.index') }}">{{ __('lang.offers') }}</a></li>
                @if($offer->category)
                <li class="breadcrumb-item"><a href="{{ route('offers.category', $offer->category->slug) }}">{{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}</a></li>
                @endif
                @if($offer->subcategory)
                <li class="breadcrumb-item"><a href="{{ route('offers.subcategory', $offer->subcategory->slug) }}">{{ app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}</li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}</h1>
        </nav>
    </div>
</section>


<section class="pt-8 pb-11 offers-page">
    <div class="container">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8 mb-8 mb-lg-0">
                {{-- Image Gallery with Thumbnails on Left --}}
                <div class="offer-gallery-container mb-6">
                    <div class="row no-gutters">
                        {{-- Thumbnails Column (Left Side) --}}
                        <div class="col-2 col-md-2 pr-2">
                            <div class="offer-thumbnails-wrapper">
                                <div class="offer-thumbnails-slider" id="offerThumbnails">
                                    {{-- Main Image Thumbnail --}}
                                    <div class="thumbnail-item active" data-index="0">
                                        <img src="{{ url('/storage' . $offer->main_image) }}"
                                             alt="{{ $offerAlt }}"
                                             class="thumbnail-img">
                                    </div>
                                    {{-- Gallery Images Thumbnails --}}
                                    @if($offer->images && $offer->images->count() > 0)
                                        @foreach($offer->images as $index => $image)
                                        <div class="thumbnail-item" data-index="{{ $index + 1 }}">
                                            <img src="{{ url('/storage' . $image->image) }}" 
                                                 alt=""
                                                 class="thumbnail-img">
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                {{-- Thumbnail Navigation Arrows --}}
                                @if($offer->images && $offer->images->count() > 4)
                                <div class="thumbnail-nav">
                                    <button type="button" class="thumb-nav-btn thumb-prev" id="thumbPrev">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button type="button" class="thumb-nav-btn thumb-next" id="thumbNext">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Main Image Slider (Right Side) --}}
                        <div class="col-10 col-md-10">
                            <div class="offer-main-slider-wrapper position-relative">
                                <div class="offer-main-slider" id="offerMainSlider">
                                    {{-- Main Image --}}
                                    <div class="main-slide">
                                        <a href="{{ url('/storage' . $offer->main_image) }}" 
                                           class="offer-gallery-item"
                                           data-gtf-mfp="true" 
                                           data-gallery-id="offer-gallery">
                                            <img src="{{ url('/storage' . $offer->main_image) }}"
                                                 alt="{{ $offerAlt }}"
                                                 class="main-slide-img">
                                        </a>
                                    </div>
                                    {{-- Gallery Images --}}
                                    @if($offer->images && $offer->images->count() > 0)
                                        @foreach($offer->images as $image)
                                        <div class="main-slide">
                                            <a href="{{ url('/storage' . $image->image) }}" 
                                               class="offer-gallery-item"
                                               data-gtf-mfp="true" 
                                               data-gallery-id="offer-gallery">
                                                <img src="{{ url('/storage' . $image->image) }}" 
                                                     alt=""
                                                     class="main-slide-img">
                                            </a>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                
                                {{-- Price Tag on Image - Top Right --}}
                                @if($offer->selected_price)
                                <div class="offer-price-tag offer-price-tag-show position-absolute" id="galleryPriceTag" style="top: 20px; right: 20px; left: auto; bottom: auto; z-index: 5;">
                                    <div class="price-label">{{ __('lang.starting_from') }}</div>
                                    <div class="price-value">
                                        {{ $offer->currency->abbreviation ?? 'AED' }} <span id="galleryPriceAmount">{{ number_format($offer->selected_price->price) }}</span>
                                    </div>
                                    <div class="price-emirate" id="galleryEmirateName">
                                        {{ $offer->selected_price->emirate ? (app()->getLocale() == 'ar' ? $offer->selected_price->emirate->title_arabic : $offer->selected_price->emirate->title_english) : '' }}
                                    </div>
                                </div>
                                @endif
                                
                                {{-- Media Count --}}
                                <div class="position-absolute d-flex" style="bottom: 20px; right: 20px; z-index: 5; gap: 10px;">
                                    @if($offer->total_images > 0)
                                    <span class="media-item text-white" style="background: rgba(0,0,0,0.6); padding: 8px 12px; border-radius: 6px; font-size: 14px;">
                                        <i class="far fa-images mr-1"></i> {{ $offer->total_images }} {{ __('lang.images') }}
                                    </span>
                                    @endif
                                    @if($offer->video_count > 0)
                                    <span class="media-item text-white" style="background: rgba(0,0,0,0.6); padding: 8px 12px; border-radius: 6px; font-size: 14px;">
                                        <i class="far fa-play-circle mr-1"></i> {{ $offer->video_count }} {{ __('lang.videos') }}
                                    </span>
                                    @endif
                                </div>
                                
                                {{-- Slider Navigation Arrows --}}
                                <button type="button" class="slider-nav-btn slider-prev" id="sliderPrev">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="slider-nav-btn slider-next" id="sliderNext">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Description --}}
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-align-left"></i>
                                {{ __('lang.description') }}
                            </h3>
                        </div>
                        <div class="offer-description">
                            {!! app()->getLocale() == 'ar' ? ($offer->description_arabic ?? __('lang.no_description')) : ($offer->description_english ?? __('lang.no_description')) !!}
                        </div>
                    </div>
                </div>
                
                {{-- Specifications --}}
                @if($offer->specifications && $offer->specifications->count() > 0)
                <div class="card border-0 shadow-sm mb-6 specifications-card">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-clipboard-list"></i>
                                {{ __('lang.specifications') }}
                            </h3>
                        </div>
                        <div class="specifications-grid">
                            @foreach($offer->specifications as $spec)
                            @if($spec->specification)
                            <div class="spec-item">
                                <div class="spec-icon-wrapper">
                                    @if($spec->specification->icon)
                                    <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                                    @else
                                    <span class="spec-placeholder">
                                        {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                                    </span>
                                    @endif
                                </div>
                                <div class="spec-content">
                                    <span class="spec-label">{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}</span>
                                    <span class="spec-value">{{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}</span>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- 3D Visual --}}
                @if($offer->plan_3d_image)
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-cube"></i>
                                {{ __('lang.3d_image') }}
                            </h3>
                        </div>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10 col-12 mb-4">
                                <div class="position-relative rounded-lg overflow-hidden visual-image-wrapper">
                                    <a href="{{ url('/storage' . $offer->plan_3d_image) }}" 
                                       data-gtf-mfp="true" 
                                       data-gallery-id="visual-plan-gallery"
                                       class="d-block">
                                        <img src="{{ url('/storage' . $offer->plan_3d_image) }}" 
                                             alt="{{ __('lang.3d_image') }}" 
                                             class="w-100 rounded-lg"
                                             style="object-fit: contain; max-height: 600px;">
                                        <div class="position-absolute d-flex align-items-center justify-content-center" 
                                             style="bottom: 15px; left: 15px; background: rgba(0,0,0,0.7); padding: 8px 16px; border-radius: 6px;">
                                            <i class="fal fa-cube text-white mr-2"></i>
                                            <span class="text-white font-weight-500 fs-14">{{ __('lang.3d_image') }}</span>
                                        </div>
                                        <div class="position-absolute d-flex align-items-center justify-content-center hover-overlay-visual" 
                                             style="top: 0; left: 0; right: 0; bottom: 0; background: rgba(25,134,139,0.3); opacity: 0; transition: opacity 0.3s;">
                                            <i class="fal fa-search-plus text-white fs-40"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Facts & Features --}}
                <div class="card border-0 shadow-sm mb-6 facts-features-card">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-info-circle"></i>
                                {{ __('lang.facts_and_features') }}
                            </h3>
                        </div>
                        <div class="facts-grid">
                            @if($offer->category)
                            <div class="fact-item">
                                <div class="fact-icon-wrapper category-icon">
                                    @if($offer->category->icon)
                                    <img src="{{ url('/storage' . $offer->category->icon) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}">
                                    @else
                                    <span class="fact-placeholder">
                                        <i class="fas fa-folder"></i>
                                    </span>
                                    @endif
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label">{{ __('lang.category') }}</span>
                                    <span class="fact-value">{{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($offer->subcategory)
                            <div class="fact-item">
                                <div class="fact-icon-wrapper subcategory-icon">
                                    @if($offer->subcategory->icon)
                                    <img src="{{ url('/storage' . $offer->subcategory->icon) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english }}">
                                    @else
                                    <span class="fact-placeholder">
                                        <i class="fas fa-folder-open"></i>
                                    </span>
                                    @endif
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label">{{ __('lang.subcategory') }}</span>
                                    <span class="fact-value">{{ app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($offer->type)
                            <div class="fact-item">
                                <div class="fact-icon-wrapper type-icon">
                                    @if($offer->type->icon)
                                    <img src="{{ url('/storage' . $offer->type->icon) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $offer->type->name_arabic : $offer->type->name_english }}">
                                    @else
                                    <span class="fact-placeholder">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    @endif
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label">{{ __('lang.type') }}</span>
                                    <span class="fact-value">{{ app()->getLocale() == 'ar' ? $offer->type->name_arabic : $offer->type->name_english }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($offer->style)
                            <div class="fact-item">
                                <div class="fact-icon-wrapper style-icon">
                                    @if($offer->style->icon)
                                    <img src="{{ url('/storage' . $offer->style->icon) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $offer->style->title_arabic : $offer->style->title_english }}">
                                    @else
                                    <span class="fact-placeholder">
                                        <i class="fas fa-paint-brush"></i>
                                    </span>
                                    @endif
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label">{{ __('lang.style') }}</span>
                                    <span class="fact-value">{{ app()->getLocale() == 'ar' ? $offer->style->title_arabic : $offer->style->title_english }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($offer->sqft)
                            <div class="fact-item">
                                <div class="fact-icon-wrapper sqft-icon">
                                    <span class="fact-placeholder">
                                        <i class="fas fa-ruler-combined"></i>
                                    </span>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label">{{ __('lang.sqft') }}</span>
                                    <span class="fact-value">{{ number_format($offer->sqft) }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($offer->sqm)
                            <div class="fact-item">
                                <div class="fact-icon-wrapper sqm-icon">
                                    <span class="fact-placeholder">
                                        <i class="fas fa-vector-square"></i>
                                    </span>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label">{{ __('lang.sqm') }}</span>
                                    <span class="fact-value">{{ number_format($offer->sqm) }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- Floor Plans --}}
                @include('pages.offers.partials.floors')
                
                {{-- Feasibility Studies --}}
                @include('pages.offers.partials.feasibility')
                
                {{-- Offer Video --}}
                @if($offer->video_url)
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-video"></i>
                                {{ __('lang.offer_video') }}
                            </h3>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9 rounded overflow-hidden">
                            @php
                                $videoUrl = $offer->video_url;
                                // Convert YouTube watch URLs to embed format
                                if (strpos($videoUrl, 'youtube.com/watch') !== false) {
                                    preg_match('/[?&]v=([^&]+)/', $videoUrl, $matches);
                                    if (isset($matches[1])) {
                                        $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                    }
                                } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                    $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 1);
                                    $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                                }
                            @endphp
                            <iframe class="embed-responsive-item" src="{{ $videoUrl }}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Virtual Tour --}}
                @if($offer->tour_url)
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-vr-cardboard"></i>
                                {{ __('lang.virtual_tour') }}
                            </h3>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9 rounded overflow-hidden">
                            <iframe class="embed-responsive-item" src="{{ $offer->tour_url }}" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            {{-- Sidebar --}}
            <div class="col-lg-4 primary-sidebar sidebar-sticky" id="sidebar">
                <div class="primary-sidebar-inner">
                {{-- Price Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        {{-- Price Header --}}
                        <div class="offer-price-header mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge badge-offer" style="background: linear-gradient(135deg, #e1273d 0%, #c41f33 100%); padding: 6px 12px; font-size: 11px; border-radius: 20px;">
                                    {{ __('lang.special_offer') }}
                                </span>
                                @if($offer->offer_code)
                                <span class="badge" style="background: #19868b; color: white; padding: 6px 12px; font-size: 11px; border-radius: 20px;">
                                    <i class="fas fa-barcode mr-1"></i> {{ $offer->offer_code }}
                                </span>
                                @endif
                            </div>
                            <h4 class="fs-18 text-heading font-weight-600 mb-0">{{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}</h4>
                        </div>
                        
                        {{-- Emirates Selection - Click to change price on image --}}
                        @if($offer->all_prices && $offer->all_prices->count() > 0)
                        <div class="emirates-selector mb-4">
                            <h5 class="fs-14 text-heading font-weight-600 mb-3">
                                <i class="fas fa-map-marker-alt text-primary mr-2"></i>{{ __('lang.select_emirate') }}
                            </h5>
                            <div class="emirates-grid">
                                @foreach($offer->all_prices as $priceItem)
                                @if($priceItem->emirate)
                                <div class="emirate-item {{ $offer->selected_price && $offer->selected_price->emirate_id == $priceItem->emirate_id ? 'active-emirate' : '' }}" 
                                     data-emirate-id="{{ $priceItem->emirate_id }}"
                                     data-price="{{ number_format($priceItem->price) }}"
                                     data-raw-price="{{ $priceItem->price }}"
                                     data-emirate-name="{{ app()->getLocale() == 'ar' ? $priceItem->emirate->title_arabic : $priceItem->emirate->title_english }}">
                                    <div class="emirate-icon-wrapper">
                                        @if($priceItem->emirate->icon)
                                        <img src="{{ url('/storage' . $priceItem->emirate->icon) }}" alt="{{ app()->getLocale() == 'ar' ? $priceItem->emirate->title_arabic : $priceItem->emirate->title_english }}">
                                        @else
                                        <i class="fas fa-map-marker-alt"></i>
                                        @endif
                                    </div>
                                    <span class="emirate-name">{{ app()->getLocale() == 'ar' ? $priceItem->emirate->title_arabic : $priceItem->emirate->title_english }}</span>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        {{-- Quick Info --}}
                        <div class="quick-info mb-4">
                            @if($offer->sqft)
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-gray-light">{{ __('lang.sqft') }}</span>
                                <span class="font-weight-600">{{ number_format($offer->sqft) }}</span>
                            </div>
                            @endif
                            @if($offer->sqm)
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-gray-light">{{ __('lang.sqm') }}</span>
                                <span class="font-weight-600">{{ number_format($offer->sqm) }}</span>
                            </div>
                            @endif
                        </div>
                        
                        {{-- CTA Buttons --}}
                        <div class="cta-buttons">
                            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg btn-block mb-2">
                                <i class="fas fa-phone-alt mr-2"></i> {{ __('lang.contact_us') }}
                            </a>
                            @if($offer->plan_2d_image)
                            <a href="{{ url('/storage' . $offer->plan_2d_image) }}" target="_blank" class="btn btn-outline-primary btn-lg btn-block mb-3">
                                <i class="fas fa-file-pdf mr-2"></i> {{ __('lang.offer_file') }}
                            </a>
                            @endif
                        </div>
                        
                        {{-- Favourite Button --}}
                        <div class="pt-3 border-top mb-3">
                            <button class="btn-favourite" style="width:auto;border-radius:50px;padding:8px 20px;gap:8px;font-size:14px;"
                                    data-type="offer" data-id="{{ $offer->id }}"
                                    data-emirate="{{ $offer->selected_price->emirate_id ?? ($offer->all_prices->first()->emirate_id ?? '') }}"
                                    data-price="{{ $offer->selected_price->price ?? ($offer->all_prices->first()->price ?? '') }}"
                                    title="{{ __('lang.add_to_favourites') }}">
                                <i class="fal fa-heart"></i> {{ __('lang.add_to_favourites') }}
                            </button>
                        </div>

                        {{-- Share Buttons --}}
                        @php
                            $shareTitle = app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english;
                            $shareCurrency = $offer->currency->abbreviation ?? 'AED';
                            $shareUrl = request()->url();
                            $shareImage = url('/storage' . $offer->main_image);
                        @endphp
                        <div class="share-section pt-3 border-top">
                            <h6 class="fs-13 text-muted text-uppercase mb-3">{{ __('lang.share') }}</h6>
                            <div class="d-flex justify-content-between flex-wrap">
                                <a id="shareFacebook" href="#" target="_blank" class="btn btn-sm btn-outline-primary flex-fill mr-1 mb-2" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a id="shareTwitter" href="#" target="_blank" class="btn btn-sm btn-outline-info flex-fill mr-1 mb-2" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a id="shareWhatsapp" href="#" target="_blank" class="btn btn-sm btn-outline-success flex-fill mr-1 mb-2" title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a id="shareLinkedin" href="#" target="_blank" class="btn btn-sm btn-outline-primary flex-fill mr-1 mb-2" title="LinkedIn" style="border-color: #0077b5; color: #0077b5;">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a id="sharePinterest" href="#" target="_blank" class="btn btn-sm btn-outline-danger flex-fill mr-1 mb-2" title="Pinterest" style="border-color: #e60023; color: #e60023;">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a id="shareEmail" href="#" class="btn btn-sm btn-outline-secondary flex-fill mb-2" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                        <script>
                        (function() {
                            var shareTitle = @json($shareTitle);
                            var shareCurrency = @json($shareCurrency);
                            var shareUrl = @json($shareUrl);
                            var shareImage = @json($shareImage);
                            var currentPrice = '';
                            var currentEmirate = '';

                            @if($offer->selected_price)
                                currentPrice = '{{ number_format($offer->selected_price->price) }}';
                                currentEmirate = '{{ $offer->selected_price->emirate ? (app()->getLocale() == "ar" ? $offer->selected_price->emirate->title_arabic : $offer->selected_price->emirate->title_english) : "" }}';
                            @endif

                            function buildShareText() {
                                var text = shareTitle;
                                if (currentPrice) text += ' - ' + shareCurrency + ' ' + currentPrice;
                                if (currentEmirate) text += ' (' + currentEmirate + ')';
                                return text;
                            }

                            function updateShareLinks() {
                                var text = buildShareText();
                                var enc = encodeURIComponent;
                                document.getElementById('shareFacebook').href = 'https://www.facebook.com/sharer/sharer.php?u=' + enc(shareUrl) + '&quote=' + enc(text);
                                document.getElementById('shareTwitter').href = 'https://twitter.com/intent/tweet?url=' + enc(shareUrl) + '&text=' + enc(text);
                                document.getElementById('shareWhatsapp').href = 'https://wa.me/?text=' + enc(text + '\n' + shareUrl);
                                document.getElementById('shareLinkedin').href = 'https://www.linkedin.com/shareArticle?mini=true&url=' + enc(shareUrl) + '&title=' + enc(shareTitle) + '&summary=' + enc(text);
                                document.getElementById('sharePinterest').href = 'https://pinterest.com/pin/create/button/?url=' + enc(shareUrl) + '&media=' + enc(shareImage) + '&description=' + enc(text);
                                document.getElementById('shareEmail').href = 'mailto:?subject=' + enc(shareTitle) + '&body=' + enc(text + '\n\n' + shareUrl);
                            }

                            updateShareLinks();

                            window.updateSharePrice = function(price, emirateName) {
                                currentPrice = price;
                                currentEmirate = emirateName;
                                updateShareLinks();
                            };
                        })();
                        </script>
                    </div>
                </div>
                
                {{-- Schedule A Tour / Request Info Card --}}
                @php
                    $showOfferScheduleTour = config('features.offers.schedule_tour');
                    $showOfferRequestInfo = config('features.offers.request_info');
                    $showOfferForms = $showOfferScheduleTour || $showOfferRequestInfo;
                @endphp
                @if($showOfferForms)
                <div class="card border-0 shadow-sm widget-request-tour">
                    @if($showOfferScheduleTour && $showOfferRequestInfo)
                    {{-- Both tabs enabled --}}
                    <ul class="nav nav-tabs d-flex" role="tablist">
                        <li class="nav-item flex-fill">
                            <a class="nav-link active text-center px-3 py-3" data-toggle="tab" href="#schedule-tour" role="tab" aria-selected="true">
                                <i class="fas fa-calendar-alt mr-2"></i>{{ __('lang.schedule_a_tour') }}
                            </a>
                        </li>
                        <li class="nav-item flex-fill">
                            <a class="nav-link text-center px-3 py-3" data-toggle="tab" href="#request-info" role="tab" aria-selected="false">
                                <i class="fas fa-info-circle mr-2"></i>{{ __('lang.request_info') }}
                            </a>
                        </li>
                    </ul>
                    @elseif($showOfferScheduleTour)
                    {{-- Only Schedule a Tour --}}
                    <div class="card-header bg-primary text-white text-center py-3">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ __('lang.schedule_a_tour') }}
                    </div>
                    @else
                    {{-- Only Request Info --}}
                    <div class="card-header bg-primary text-white text-center py-3">
                        <i class="fas fa-info-circle mr-2"></i>{{ __('lang.request_info') }}
                    </div>
                    @endif
                    <div class="card-body px-4 shadow-xxs-2 pb-4 pt-0">
                        {{-- Two independent forms, one per tab. They used to share a single
                             <form>, so with both tabs enabled every field posted together and
                             the two field sets collided. --}}
                        <div class="tab-content pt-1 pb-0 px-0 shadow-none">
                            @if($showOfferScheduleTour)
                            {{-- Schedule A Tour Tab --}}
                            <div class="tab-pane fade {{ $showOfferScheduleTour ? 'show active' : '' }}" id="schedule-tour" role="tabpanel">
                                <form action="{{ route('contact.store') }}" method="POST" class="offer-inquiry-form" id="offerTourForm">
                                    @csrf
                                    @include('includes.form-guard')
                                    <input type="hidden" name="source" value="offer_tour">
                                    <input type="hidden" name="related_type" value="offer">
                                    <input type="hidden" name="related_id" value="{{ $offer->id }}">
                                    <input type="hidden" name="subject" value="{{ __('lang.schedule_a_tour') }} - {{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}">
                                    <input type="hidden" name="message" value="{{ __('lang.interested_in_offer', ['offer' => app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english]) }}">
                                    <input type="hidden" name="g-recaptcha-response" class="offer-recaptcha-token">
                                    {{-- Date Picker Slider with Custom Navigation --}}
                                    <div class="calendar-slider-wrapper mt-4 mb-3">
                                        <button type="button" class="calendar-nav calendar-prev" id="calendarPrev">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <div class="slick-slider calendar-slider" id="calendarSlider"
                                             data-slick-options='{"slidesToShow": 5, "autoplay":false, "dots":false, "arrows":false, "infinite":false, "responsive":[{"breakpoint": 400,"settings": {"slidesToShow":3}},{"breakpoint": 576,"settings": {"slidesToShow":4}}]}'>
                                            @php
                                                $today = \Carbon\Carbon::now();
                                            @endphp
                                            @for($i = 0; $i < 14; $i++)
                                            @php
                                                $date = $today->copy()->addDays($i);
                                            @endphp
                                            <div class="box px-1 py-2">
                                                <div class="calendar-day text-center px-2 py-3 rounded {{ $i === 0 ? 'active' : '' }}" 
                                                     data-date="{{ $date->format('Y-m-d') }}"
                                                     style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                                                    <span class="d-block fs-12 text-muted text-uppercase">{{ $date->format('D') }}</span>
                                                    <span class="d-block fs-20 font-weight-600 text-heading">{{ $date->format('d') }}</span>
                                                    <span class="d-block fs-11 text-muted">{{ $date->format('M') }}</span>
                                                </div>
                                            </div>
                                            @endfor
                                        </div>
                                        <button type="button" class="calendar-nav calendar-next" id="calendarNext">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" id="selectedDate" name="preferred_date" value="{{ $today->format('Y-m-d') }}">

                                    <div class="form-group mb-3">
                                        <label class="fs-13 text-muted mb-1">{{ __('lang.preferred_time') }}</label>
                                        <select class="form-control form-control-lg border-0 bg-gray-01" name="preferred_time">
                                            <option value="">{{ __('lang.select_time') }}</option>
                                            <option value="09:00">09:00 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="13:00">01:00 PM</option>
                                            <option value="14:00">02:00 PM</option>
                                            <option value="15:00">03:00 PM</option>
                                            <option value="16:00">04:00 PM</option>
                                            <option value="17:00">05:00 PM</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg border-0 bg-gray-01" name="name" placeholder="{{ __('lang.full_name') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control form-control-lg border-0 bg-gray-01" name="email" placeholder="{{ __('lang.email_address') }}">
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="tel" class="form-control form-control-lg border-0 bg-gray-01" name="phone" placeholder="{{ __('lang.phone_number') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block rounded">
                                        <i class="fas fa-calendar-check mr-2"></i>{{ __('lang.schedule_a_tour') }}
                                    </button>
                                </form>
                            </div>
                            @endif
                                
                            @if($showOfferRequestInfo)
                            {{-- Request Info Tab --}}
                            <div class="tab-pane fade {{ !$showOfferScheduleTour ? 'show active' : '' }} pt-4" id="request-info" role="tabpanel">
                                <form action="{{ route('contact.store') }}" method="POST" class="offer-inquiry-form" id="offerInfoForm">
                                    @csrf
                                    @include('includes.form-guard')
                                    <input type="hidden" name="source" value="offer_info">
                                    <input type="hidden" name="related_type" value="offer">
                                    <input type="hidden" name="related_id" value="{{ $offer->id }}">
                                    <input type="hidden" name="subject" value="{{ __('lang.request_info') }} - {{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}">
                                    <input type="hidden" name="g-recaptcha-response" class="offer-recaptcha-token">
                                    {{-- These were info_name / info_email / info_phone, which the contact
                                         endpoint does not accept; it requires name / email / phone. --}}
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg border-0 bg-gray-01" name="name" placeholder="{{ __('lang.full_name') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control form-control-lg border-0 bg-gray-01" name="email" placeholder="{{ __('lang.email_address') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="tel" class="form-control form-control-lg border-0 bg-gray-01" name="phone" placeholder="{{ __('lang.phone_number') }}">
                                    </div>
                                    <div class="form-group mb-4">
                                        <textarea class="form-control border-0 bg-gray-01" name="message" rows="4" placeholder="{{ __('lang.interested_message') }}">{{ __('lang.interested_in_offer', ['offer' => app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english]) }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block rounded">
                                        <i class="fas fa-paper-plane mr-2"></i>{{ __('lang.request_info') }}
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                {{-- Show Contact Card when forms are disabled --}}
                @include('pages.offers.partials.contact-card')
                @endif
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/offer-show.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
// Price Update Function - Updates price tag on gallery image
function updateGalleryPrice(price, emirateName) {
    var galleryPriceAmount = document.getElementById('galleryPriceAmount');
    var galleryEmirateName = document.getElementById('galleryEmirateName');
    
    if (galleryPriceAmount) {
        galleryPriceAmount.textContent = price;
    }
    if (galleryEmirateName) {
        galleryEmirateName.textContent = emirateName;
    }
}

// Gallery Slideshow
document.addEventListener('DOMContentLoaded', function() {
    // Emirates Items Click - Update price tag on image
    var emirateItems = document.querySelectorAll('.emirate-item');
    
    emirateItems.forEach(function(item) {
        item.addEventListener('click', function() {
            var price = this.getAttribute('data-price');
            var emirateName = this.getAttribute('data-emirate-name');
            var emirateId = this.getAttribute('data-emirate-id');
            
            // Update gallery price tag
            updateGalleryPrice(price, emirateName);
            
            // Update share links with selected emirate price
            if (typeof updateSharePrice === 'function') {
                updateSharePrice(price, emirateName);
            }
            
            // Update active state in emirates grid
            emirateItems.forEach(function(el) {
                el.classList.remove('active-emirate');
            });
            this.classList.add('active-emirate');

            // Update favourite button with selected emirate and price
            var favBtn = document.querySelector('.btn-favourite[data-type="offer"]');
            if (favBtn) {
                favBtn.setAttribute('data-emirate', emirateId);
                favBtn.setAttribute('data-price', this.getAttribute('data-raw-price') || '');
            }
            
            // Update Feasibility Studies section based on selected emirate
            updateFeasibilityStudies(emirateId, emirateName);
        });
    });
    
    // Function to update Feasibility Studies section
    function updateFeasibilityStudies(emirateId, emirateName) {
        var fsSection = document.getElementById('feasibilityStudiesSection');
        var fsStudies = document.querySelectorAll('.feasibility-study-item');
        var fsBadge = document.getElementById('fsEmirateNameDisplay');
        var noStudiesMsg = document.getElementById('noFeasibilityStudiesMsg');
        
        if (!fsSection) return;
        
        var hasVisibleStudies = false;
        
        // Show/hide studies based on emirate
        fsStudies.forEach(function(study) {
            var studyEmirateId = study.getAttribute('data-emirate-id');
            if (studyEmirateId == emirateId) {
                study.style.display = '';
                hasVisibleStudies = true;
            } else {
                study.style.display = 'none';
                // Collapse hidden studies
                var collapseEl = study.querySelector('.collapse');
                if (collapseEl) {
                    $(collapseEl).collapse('hide');
                }
            }
        });
        
        // Update emirate badge
        if (fsBadge) {
            fsBadge.textContent = emirateName;
        }
        
        // Show/hide the entire section based on whether there are matching studies
        if (hasVisibleStudies) {
            fsSection.style.display = '';
            if (noStudiesMsg) noStudiesMsg.style.display = 'none';
        } else {
            // Hide entire section if no studies for this emirate
            fsSection.style.display = 'none';
        }
    }
    
    // Gallery Slideshow
    var thumbnails = document.querySelectorAll('.thumbnail-item');
    var mainSlides = document.querySelectorAll('.main-slide');
    var currentSlide = 0;
    var totalSlides = mainSlides.length;
    
    // Show first slide
    if (mainSlides.length > 0) {
        mainSlides[0].classList.add('active');
    }
    
    // Function to go to specific slide
    function goToSlide(index) {
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;
        
        // Update main slides
        mainSlides.forEach(function(slide, i) {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });
        
        // Update thumbnails
        thumbnails.forEach(function(thumb, i) {
            thumb.classList.remove('active');
            if (i === index) {
                thumb.classList.add('active');
                // Scroll thumbnail into view
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
        
        currentSlide = index;
    }
    
    // Thumbnail click handlers
    thumbnails.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            var index = parseInt(this.getAttribute('data-index'));
            goToSlide(index);
        });
    });
    
    // Main slider navigation
    var sliderPrev = document.getElementById('sliderPrev');
    var sliderNext = document.getElementById('sliderNext');
    
    if (sliderPrev) {
        sliderPrev.addEventListener('click', function() {
            goToSlide(currentSlide - 1);
        });
    }
    
    if (sliderNext) {
        sliderNext.addEventListener('click', function() {
            goToSlide(currentSlide + 1);
        });
    }
    
    // Thumbnail navigation
    var thumbPrev = document.getElementById('thumbPrev');
    var thumbNext = document.getElementById('thumbNext');
    var thumbnailsSlider = document.getElementById('offerThumbnails');
    
    if (thumbPrev && thumbnailsSlider) {
        thumbPrev.addEventListener('click', function() {
            thumbnailsSlider.scrollBy({ top: -100, behavior: 'smooth' });
        });
    }
    
    if (thumbNext && thumbnailsSlider) {
        thumbNext.addEventListener('click', function() {
            thumbnailsSlider.scrollBy({ top: 100, behavior: 'smooth' });
        });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            goToSlide(currentSlide - 1);
        } else if (e.key === 'ArrowRight') {
            goToSlide(currentSlide + 1);
        }
    });
    
    // Initialize Magnific Popup for offer gallery
    if (typeof $.fn.magnificPopup !== 'undefined') {
        var $galleryItems = $('.offer-gallery-item');
        if ($galleryItems.length > 0) {
            var galleryImages = [];
            $galleryItems.each(function() {
                galleryImages.push({
                    src: $(this).attr('href')
                });
            });
            
            $galleryItems.magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                items: galleryImages,
                closeOnBgClick: true,
                closeBtnInside: false,
                mainClass: 'mfp-zoom-in',
                midClick: true,
                removalDelay: 300,
                callbacks: {
                    beforeOpen: function() {
                        var index = $galleryItems.index(this.st.el);
                        if (index !== -1) {
                            this.goTo(index);
                        }
                    }
                }
            });
        }
    }
    
    // Calendar Day Selection for Tour Form
    var calendarDays = document.querySelectorAll('.calendar-day');
    var selectedDateInput = document.getElementById('selectedDate');
    
    calendarDays.forEach(function(day) {
        day.addEventListener('click', function() {
            // Remove active class from all days
            calendarDays.forEach(function(d) {
                d.classList.remove('active');
            });
            
            // Add active class to clicked day
            this.classList.add('active');
            
            // Update hidden input with selected date
            if (selectedDateInput) {
                selectedDateInput.value = this.getAttribute('data-date');
            }
        });
    });
    
    // Initialize Calendar Slider with Custom Navigation
    if (typeof $.fn.slick !== 'undefined') {
        var $calendarSlider = $('#calendarSlider');
        
        if ($calendarSlider.length && !$calendarSlider.hasClass('slick-initialized')) {
            $calendarSlider.slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: false,
                dots: false,
                arrows: false,
                infinite: false,
                responsive: [
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 4
                        }
                    }
                ]
            });
            
            // Custom navigation buttons
            $('#calendarPrev').on('click', function() {
                $calendarSlider.slick('slickPrev');
            });
            
            $('#calendarNext').on('click', function() {
                $calendarSlider.slick('slickNext');
            });
        }
    }
});
</script>

@if($showOfferScheduleTour || $showOfferRequestInfo)
    @include('includes.inquiry-form-scripts', [
        'inquiryFormSelector' => '.offer-inquiry-form',
        'inquiryRecaptchaAction' => 'offer_enquiry',
    ])
@endif
@endsection

