@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('services_index'); @endphp

@section('title', $seo['title'] ?? __('lang.our_services'))

@section('seo_desc', $seo['description'] ?? __('lang.services_seo_desc'))

@section('seo_tags', $seo['tags'] ?? __('lang.services'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/services-page.css') }}?v={{ time() }}">
@endsection

@section('content')

{{-- Hero Section --}}
<section class="services-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="services-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="services-hero-bg services-hero-gradient"></div>
    @endif
    <div class="services-hero-overlay"></div>
    <div class="container position-relative">
        <div class="services-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.services') }}</li>
                </ol>
            </nav>
            <h1 class="services-hero-title">{{ __('lang.our_services') }}</h1>
            <p class="services-hero-subtitle">{{ __('lang.services_subtitle') }}</p>
        </div>
    </div>
</section>

{{-- Services Intro Section --}}
<section class="services-intro-section py-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-badge mb-3">
                    <span class="badge-line"></span>
                    <span class="badge-text">{{ __('lang.what_we_offer') }}</span>
                    <span class="badge-line"></span>
                </div>
                <h2 class="section-title mb-4">{{ __('lang.comprehensive_solutions') }}</h2>
                <p class="section-description">{{ __('lang.services_intro_text') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Main Services Section --}}
<section class="services-main-section py-10">
    <div class="container">
        @if($mainServices->count() > 0)
            @foreach($mainServices as $index => $service)
            <div class="service-block {{ $index % 2 == 0 ? '' : 'service-block-reversed' }}" data-animate="fadeInUp">
                {{-- Service Card --}}
                <div class="service-card">
                    <div class="row g-0 align-items-stretch">
                        {{-- Image Side --}}
                        <div class="col-lg-6 {{ $index % 2 == 0 ? 'order-lg-1' : 'order-lg-2' }}">
                            <div class="service-image-wrapper">
                                <a href="{{ route('services.show', $service->slug) }}">
                                    @if($service->main_image)
                                    <img src="{{ asset('storage' . $service->main_image) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}"
                                         class="service-main-image">
                                    @else
                                    <div class="service-image-placeholder">
                                        <i class="fal fa-cogs"></i>
                                    </div>
                                    @endif
                                </a>
                                <div class="service-number">
                                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                        {{-- Content Side --}}
                        <div class="col-lg-6 {{ $index % 2 == 0 ? 'order-lg-2' : 'order-lg-1' }}">
                            <div class="service-content">
                                <div class="service-icon-wrapper">
                                    @if($service->icon)
                                    <img src="{{ asset('storage' . $service->icon) }}" alt="" class="service-icon">
                                    @else
                                    <i class="fal fa-cog service-icon-fallback"></i>
                                    @endif
                                </div>
                                <h3 class="service-title">
                                    <a href="{{ route('services.show', $service->slug) }}">
                                        {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                    </a>
                                </h3>
                                <p class="service-description">
                                    {{ app()->getLocale() == 'ar' ? $service->bio_arabic : $service->bio_english }}
                                </p>
                                
                                {{-- Sub Services --}}
                                @if($service->subServices && $service->subServices->count() > 0)
                                <div class="sub-services-wrapper">
                                    <h5 class="sub-services-title">
                                        <i class="fal fa-layer-group"></i>
                                        {{ __('lang.included_services') }}
                                    </h5>
                                    <div class="sub-services-grid">
                                        @foreach($service->subServices as $subService)
                                        <a href="{{ route('services.show', $subService->slug) }}" class="sub-service-item">
                                            <span class="sub-service-icon">
                                                @if($subService->icon)
                                                <img src="{{ asset('storage' . $subService->icon) }}" alt="">
                                                @else
                                                <i class="fal fa-check-circle"></i>
                                                @endif
                                            </span>
                                            <span class="sub-service-name">
                                                {{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}
                                            </span>
                                            <span class="sub-service-arrow">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                <a href="{{ route('services.show', $service->slug) }}" class="service-link-btn">
                                    <span>{{ __('lang.learn_more') }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="no-services-found text-center py-10">
            <div class="no-services-icon">
                <i class="fal fa-cogs"></i>
            </div>
            <h3>{{ __('lang.no_services_found') }}</h3>
            <p class="text-muted">{{ __('lang.no_services_desc') }}</p>
            <a href="{{ route('index') }}" class="btn btn-primary mt-4">
                <i class="fal fa-home mr-2"></i>
                {{ __('lang.back_to_home') }}
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Quick Navigation Section --}}
@if($mainServices->count() > 3)
<section class="services-quick-nav py-10">
    <div class="container">
        <div class="quick-nav-wrapper">
            <h4 class="quick-nav-title">{{ __('lang.quick_navigation') }}</h4>
            <div class="quick-nav-grid">
                @foreach($mainServices as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="quick-nav-item">
                    <span class="quick-nav-icon">
                        @if($service->icon)
                        <img src="{{ asset('storage' . $service->icon) }}" alt="">
                        @else
                        <i class="fal fa-cog"></i>
                        @endif
                    </span>
                    <span class="quick-nav-text">
                        {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="services-cta-section py-12">
    <div class="container">
        <div class="cta-wrapper">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="cta-title">{{ __('lang.need_help_choosing') }}</h3>
                    <p class="cta-text">{{ __('lang.contact_for_consultation') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('contact') }}" class="cta-btn">
                        <i class="fal fa-comments mr-2"></i>
                        {{ __('lang.get_in_touch') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

