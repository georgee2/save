@extends('layouts.master')

@section('title', __('lang.our_branches'))

@section('seo_desc', __('lang.branches_seo_desc'))

@section('seo_tags', __('lang.our_branches'))

@section('content')

{{-- Hero Section --}}
<section class="branches-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="branches-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="branches-hero-bg branches-hero-gradient"></div>
    @endif
    <div class="branches-hero-overlay"></div>
    <div class="container position-relative">
        <div class="branches-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about') }}">{{ __('lang.about_us') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.our_branches') }}</li>
                </ol>
            </nav>
            <h1 class="branches-hero-title">{{ __('lang.our_branches') }}</h1>
            <p class="branches-hero-subtitle">{{ __('lang.branches_hero_subtitle') }}</p>
        </div>
    </div>
</section>

{{-- Company Profile Download Section --}}
@if($aboutInfo && $aboutInfo->company_profile)
<section class="company-profile-section py-10">
    <div class="container">
        <div class="company-profile-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="profile-content">
                        <div class="profile-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="profile-text">
                            <h3 class="profile-title">{{ __('lang.company_profile') }}</h3>
                            <p class="profile-description">{{ __('lang.company_profile_description') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-lg-right">
                    <a href="{{ asset('storage' . $aboutInfo->company_profile) }}" 
                       class="btn btn-download-profile" 
                       target="_blank" 
                       download>
                        <i class="fas fa-download"></i>
                        <span>{{ __('lang.download_company_profile') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Branches List Section --}}
@if($branches && $branches->count() > 0)
<section class="branches-list-section py-12">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="branches-section-badge">
                <i class="fas fa-building"></i>
                <span>{{ __('lang.locations') }}</span>
            </div>
            <h2 class="branches-section-title">{{ __('lang.find_us_near_you') }}</h2>
            <p class="branches-section-subtitle">{{ __('lang.branches_section_subtitle') }}</p>
        </div>
        
        {{-- Branches Grid --}}
        <div class="branches-grid">
            @foreach($branches as $index => $branch)
            <div class="branch-card" data-animate="fadeInUp" data-delay="{{ $index * 100 }}">
                {{-- Branch Header --}}
                <div class="branch-header">
                    <div class="branch-logo-wrapper">
                        @if($branch->logo_english && app()->getLocale() == 'en')
                        <img src="{{ asset('storage' . $branch->logo_english) }}" 
                             alt="{{ $branch->name_english }}" 
                             class="branch-logo">
                        @elseif($branch->logo_arabic && app()->getLocale() == 'ar')
                        <img src="{{ asset('storage' . $branch->logo_arabic) }}" 
                             alt="{{ $branch->name_arabic }}" 
                             class="branch-logo">
                        @elseif($branch->logo_english)
                        <img src="{{ asset('storage' . $branch->logo_english) }}" 
                             alt="{{ $branch->name_english }}" 
                             class="branch-logo">
                        @else
                        <div class="branch-logo-placeholder">
                            <i class="fas fa-building"></i>
                        </div>
                        @endif
                    </div>
                    <div class="branch-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                </div>
                
                {{-- Branch Content --}}
                <div class="branch-content">
                    <h3 class="branch-name">
                        {{ app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english }}
                    </h3>
                    
                    {{-- Location --}}
                    @if(($branch->location_text_english && app()->getLocale() == 'en') || ($branch->location_text_arabic && app()->getLocale() == 'ar'))
                    <div class="branch-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ app()->getLocale() == 'ar' ? $branch->location_text_arabic : $branch->location_text_english }}</span>
                    </div>
                    @endif
                    
                    {{-- Opening Hours --}}
                    @if($branch->opening_hours)
                    <div class="branch-hours">
                        <i class="fas fa-clock"></i>
                        <span>{{ $branch->opening_hours }}</span>
                    </div>
                    @endif
                    
                    {{-- Get Directions Button --}}
                    @if($branch->map_url)
                    <div class="branch-actions">
                        <a href="{{ $branch->map_url }}" target="_blank" class="btn-branch btn-directions">
                            <i class="fas fa-directions"></i>
                            <span>{{ __('lang.get_directions') }}</span>
                        </a>
                    </div>
                    @endif
                </div>
                
                {{-- Map Preview (if available) --}}
                @if($branch->map_url)
                <div class="branch-map-preview">
                    @if(strpos($branch->map_url, '<iframe') !== false)
                        {!! $branch->map_url !!}
                    @else
                        <iframe src="{{ $branch->map_url }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
{{-- Empty State --}}
<section class="branches-empty-section py-12">
    <div class="container">
        <div class="text-center">
            <div class="empty-icon mb-4">
                <i class="fas fa-building"></i>
            </div>
            <h3 class="empty-title">{{ __('lang.no_branches_yet') }}</h3>
            <p class="empty-text">{{ __('lang.branches_coming_soon') }}</p>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="branches-cta-section py-10">
    <div class="container">
        <div class="branches-cta-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title">{{ __('lang.need_assistance') }}</h3>
                    <p class="cta-text">{{ __('lang.branches_cta_text') }}</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="{{ route('contact') }}" class="btn btn-cta">
                        <i class="fas fa-envelope {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        <span>{{ __('lang.contact_us') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/branches-page.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('animated');
                }, delay);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endsection

