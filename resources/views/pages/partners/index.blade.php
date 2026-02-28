@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('partners'); @endphp

@section('title', $seo['title'] ?? __('lang.our_partners'))

@section('seo_desc', $seo['description'] ?? __('lang.partners_seo_desc'))

@section('seo_tags', $seo['tags'] ?? __('lang.our_partners'))

@section('content')

{{-- Hero Section --}}
<section class="partners-hero">
    @if($pageBanner && $pageBanner->cover)
    <div class="partners-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="partners-hero-bg partners-hero-gradient"></div>
    @endif
    <div class="partners-hero-overlay"></div>
    <div class="container">
        <div class="partners-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about') }}">{{ __('lang.about_us') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('lang.our_partners') }}</li>
                </ol>
            </nav>
            <h1 class="partners-hero-title">{{ __('lang.our_partners') }}</h1>
            <p class="partners-hero-subtitle">{{ __('lang.partners_hero_subtitle') }}</p>
        </div>
    </div>
    
    {{-- Decorative Elements --}}
    <div class="hero-decoration hero-decoration-1"></div>
    <div class="hero-decoration hero-decoration-2"></div>
</section>

{{-- Partners Section --}}
@if($partners && $partners->count() > 0)
<section class="partners-section">
    <div class="container">
        {{-- Section Header --}}
        <div class="section-header" data-animate="fadeInUp">
            <span class="section-label">
                <i class="fas fa-handshake"></i>
                {{ __('lang.trusted_partners') }}
            </span>
            <h2 class="section-title">{{ __('lang.partners_we_work_with') }}</h2>
            <div class="section-divider">
                <span></span>
            </div>
        </div>
        
        {{-- Partners Grid --}}
        <div class="partners-grid">
            @foreach($partners as $index => $partner)
            <div class="partner-card" data-animate="fadeInUp" data-delay="{{ ($index % 3) * 100 }}">
                {{-- Card Header with Logo --}}
                <div class="partner-card-header">
                    <div class="partner-logo-wrapper">
                        @if($partner->logo_english && app()->getLocale() == 'en')
                        <img src="{{ asset('storage' . $partner->logo_english) }}" 
                             alt="{{ $partner->name_english }}" 
                             class="partner-logo">
                        @elseif($partner->logo_arabic && app()->getLocale() == 'ar')
                        <img src="{{ asset('storage' . $partner->logo_arabic) }}" 
                             alt="{{ $partner->name_arabic }}" 
                             class="partner-logo">
                        @elseif($partner->logo_english)
                        <img src="{{ asset('storage' . $partner->logo_english) }}" 
                             alt="{{ $partner->name_english }}" 
                             class="partner-logo">
                        @else
                        <div class="partner-logo-placeholder">
                            <i class="fas fa-building"></i>
                        </div>
                        @endif
                    </div>
                    <span class="partner-badge">
                        <i class="fas fa-check-circle"></i>
                        {{ __('lang.verified') }}
                    </span>
                </div>
                
                {{-- Partner Info --}}
                <div class="partner-card-body">
                    <h3 class="partner-name">
                        {{ app()->getLocale() == 'ar' ? $partner->name_arabic : $partner->name_english }}
                    </h3>
                    
                    @if((app()->getLocale() == 'ar' && $partner->about_arabic) || (app()->getLocale() == 'en' && $partner->about_english))
                    <p class="partner-desc">
                        {{ Str::limit(strip_tags(app()->getLocale() == 'ar' ? $partner->about_arabic : $partner->about_english), 100) }}
                    </p>
                    @endif
                    
                    {{-- Contact Info --}}
                    <div class="partner-contact-info">
                        @if($partner->email)
                        <div class="contact-row">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a>
                        </div>
                        @endif
                        
                        @if($partner->mobile)
                        <div class="contact-row">
                            <i class="fas fa-phone"></i>
                            <a href="tel:{{ $partner->mobile }}">{{ $partner->mobile }}</a>
                        </div>
                        @endif
                    </div>
                </div>
                
                {{-- Card Footer --}}
                <div class="partner-card-footer">
                    <a href="{{ route('partners.show', $partner->id) }}" class="btn-view-partner">
                        <span>{{ __('lang.view_details') }}</span>
                        <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                    </a>
                    
                    @if($partner->website_url)
                    <a href="{{ $partner->website_url }}" target="_blank" class="btn-website" title="{{ __('lang.visit_website') }}">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
{{-- Empty State --}}
<section class="partners-empty-section">
    <div class="container">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-handshake"></i>
            </div>
            <h3 class="empty-title">{{ __('lang.no_partners_yet') }}</h3>
            <p class="empty-text">{{ __('lang.partners_coming_soon') }}</p>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="partners-cta-section">
    <div class="container">
        <div class="cta-wrapper" data-animate="fadeInUp">
            <div class="cta-content">
                <div class="cta-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="cta-text">
                    <h3>{{ __('lang.become_partner') }}</h3>
                    <p>{{ __('lang.partner_cta_text') }}</p>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="cta-btn">
                <span>{{ __('lang.contact_us') }}</span>
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            </a>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/partners-page.css') }}?v={{ time() }}">
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
