@extends('layouts.master')

@section('title', app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english)

@section('seo_desc', app()->getLocale() == 'ar' ? $service->seo_des_ar : $service->seo_des_en)

@section('seo_tags', $service->seo_tags)

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/service-single.css') }}?v={{ time() }}">
@endsection

@section('content')

{{-- Hero Section --}}
<section class="service-hero-section position-relative">
    @if($service->hero_image)
    <div class="service-hero-bg" style="background-image: url('{{ asset('storage' . $service->hero_image) }}');"></div>
    @elseif($service->main_image)
    <div class="service-hero-bg" style="background-image: url('{{ asset('storage' . $service->main_image) }}');"></div>
    @else
    <div class="service-hero-bg service-hero-gradient"></div>
    @endif
    <div class="service-hero-overlay"></div>
    <div class="container position-relative">
        <div class="service-hero-content">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">{{ __('lang.services') }}</a></li>
                    @if($service->parentService)
                    <li class="breadcrumb-item">
                        <a href="{{ route('services.show', $service->parentService->slug) }}">
                            {{ app()->getLocale() == 'ar' ? $service->parentService->title_arabic : $service->parentService->title_english }}
                        </a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                    </li>
                </ol>
            </nav>
            
            @if($service->is_sub_service && $service->parentService)
            <div class="service-parent-badge mb-3">
                <a href="{{ route('services.show', $service->parentService->slug) }}">
                    <i class="fal fa-layer-group"></i>
                    {{ app()->getLocale() == 'ar' ? $service->parentService->title_arabic : $service->parentService->title_english }}
                </a>
            </div>
            @endif
            
            <h1 class="service-hero-title">
                {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
            </h1>
            
            @if($service->bio_english || $service->bio_arabic)
            <p class="service-hero-subtitle">
                {{ app()->getLocale() == 'ar' ? $service->bio_arabic : $service->bio_english }}
            </p>
            @endif
            
            <div class="service-hero-actions mt-4">
                <a href="{{ route('contact') }}" class="btn-service-primary">
                    <i class="fal fa-comments"></i>
                    {{ __('lang.get_consultation') }}
                </a>
                <a href="#service-content" class="btn-service-secondary">
                    <i class="fal fa-arrow-down"></i>
                    {{ __('lang.explore_service') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<div id="service-content">
    @php
        // Build sections based on section order if available, otherwise use default order
        $sectionOrders = $service->sectionOrders;
        
        if ($sectionOrders && $sectionOrders->count() > 0) {
            $orderedSections = $sectionOrders->filter(function($section) {
                return $section->is_visible;
            })->sortBy('order');
        } else {
            // Default order if no section orders defined
            $defaultSections = collect([
                (object)['section_type' => 'description', 'order' => 1, 'is_visible' => true],
                (object)['section_type' => 'features', 'order' => 2, 'is_visible' => true],
                (object)['section_type' => 'values', 'order' => 3, 'is_visible' => true],
                (object)['section_type' => 'process', 'order' => 4, 'is_visible' => true],
                (object)['section_type' => 'sub_services', 'order' => 5, 'is_visible' => true],
                (object)['section_type' => 'faq', 'order' => 6, 'is_visible' => true],
            ]);
            $orderedSections = $defaultSections;
        }
    @endphp
    
    @foreach($orderedSections as $section)
        @php $hasContent = false; @endphp
        
        @switch($section->section_type)
            @case('description')
                @include('pages.services.sections.description')
                @php $hasContent = true; @endphp
                @break
                
            @case('features')
                @if($service->features && $service->features->count() > 0)
                    @include('pages.services.sections.features')
                    @php $hasContent = true; @endphp
                @endif
                {{-- Show Related Services (sub-services) after Features for parent services --}}
                @if($service->is_sub_service == 0 && $service->subServices && $service->subServices->count() > 0)
                    @if($hasContent)
                        <div class="section-divider"><span></span></div>
                    @endif
                    @include('pages.services.sections.related-services')
                    @php $hasContent = true; @endphp
                @endif
                @break
                
            @case('values')
                @if($service->values && $service->values->count() > 0)
                    @include('pages.services.sections.values')
                    @php $hasContent = true; @endphp
                @endif
                @break
                
            @case('process')
                @if($service->processes && $service->processes->count() > 0)
                    @include('pages.services.sections.process')
                    @php $hasContent = true; @endphp
                @endif
                @break
                
            @case('sub_services')
                @if($service->subServices && $service->subServices->count() > 0)
                    @include('pages.services.sections.sub-services')
                    @php $hasContent = true; @endphp
                @endif
                @break
                
            @case('faq')
                @if($service->faqs && $service->faqs->count() > 0)
                    @include('pages.services.sections.faq')
                    @php $hasContent = true; @endphp
                @endif
                @break
                
            @case('custom_block')
                @if($section->block)
                    @include('pages.services.sections.custom-block', ['block' => $section->block])
                    @php $hasContent = true; @endphp
                @endif
                @break
        @endswitch
        
        {{-- Add divider after each section (except the last one) --}}
        @if($hasContent && !$loop->last)
            <div class="section-divider"><span></span></div>
        @endif
    @endforeach
</div>

{{-- CTA Section --}}
<section class="service-cta-section py-12">
    <div class="container">
        <div class="cta-wrapper">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h3 class="cta-title">{{ __('lang.ready_to_start') }}</h3>
                    <p class="cta-text">{{ __('lang.service_cta_text') }}</p>
                </div>
                <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('contact') }}" class="cta-btn-primary">
                        <i class="fal fa-paper-plane"></i>
                        {{ __('lang.contact_us') }}
                    </a>
                    <a href="tel:{{ $footerContactInfo->phone ?? '' }}" class="cta-btn-secondary">
                        <i class="fal fa-phone"></i>
                        {{ __('lang.call_now') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script>
$(document).ready(function() {
    // Related Services Slider
    if ($('.related-services-slider').length && !$('.related-services-slider').hasClass('slick-initialized')) {
        $('.related-services-slider').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            dots: true,
            arrows: true,
            prevArrow: $('.related-slider-prev'),
            nextArrow: $('.related-slider-next'),
            appendDots: $('.related-slider-dots'),
            infinite: true,
            speed: 500,
            rtl: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false
                    }
                }
            ]
        });
    }
});
</script>
@endsection

