@extends('layouts.master')

@section('title', app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english)

@section('seo_desc', app()->getLocale() == 'ar' ? ($branch->seo_description_arabic ?: $branch->location_text_arabic) : ($branch->seo_description_english ?: $branch->location_text_english))

@section('seo_tags', $branch->seo_tags ?: (app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english))

@section('content')

{{-- Hero Section --}}
<section class="branch-single-hero position-relative">
    <div class="branch-hero-gradient"></div>
    <div class="branch-hero-overlay"></div>
    <div class="container position-relative">
        <div class="branch-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about') }}">{{ __('lang.about_us') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">{{ __('lang.our_branches') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english }}</li>
                </ol>
            </nav>
            <div class="branch-badge mb-3">
                <i class="fas fa-building"></i>
                <span>{{ __('lang.branch') }}</span>
            </div>
            <h1 class="branch-hero-title">{{ app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english }}</h1>
            @if(($branch->location_text_english && app()->getLocale() == 'en') || ($branch->location_text_arabic && app()->getLocale() == 'ar'))
            <p class="branch-hero-location">
                <i class="fas fa-map-marker-alt"></i>
                {{ app()->getLocale() == 'ar' ? $branch->location_text_arabic : $branch->location_text_english }}
            </p>
            @endif
        </div>
    </div>
</section>

{{-- Branch Details Section --}}
<section class="branch-details-section py-12">
    <div class="container">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8 mb-5 mb-lg-0">
                {{-- Branch Info Card --}}
                <div class="branch-info-card" data-animate="fadeInUp">
                    <div class="info-card-header">
                        <div class="branch-logo-large">
                            @if($branch->logo_english && app()->getLocale() == 'en')
                            <img src="{{ asset('storage' . $branch->logo_english) }}" 
                                 alt="{{ $branch->name_english }}">
                            @elseif($branch->logo_arabic && app()->getLocale() == 'ar')
                            <img src="{{ asset('storage' . $branch->logo_arabic) }}" 
                                 alt="{{ $branch->name_arabic }}">
                            @elseif($branch->logo_english)
                            <img src="{{ asset('storage' . $branch->logo_english) }}" 
                                 alt="{{ $branch->name_english }}">
                            @else
                            <div class="logo-placeholder">
                                <i class="fas fa-building"></i>
                            </div>
                            @endif
                        </div>
                        <div class="info-card-title">
                            <h2>{{ app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english }}</h2>
                            @if($branch->opening_hours)
                            <p class="opening-hours">
                                <i class="fas fa-clock"></i>
                                {{ $branch->opening_hours }}
                            </p>
                            @endif
                        </div>
                    </div>
                    
                    {{-- About Section --}}
                    @if(($branch->about_english && app()->getLocale() == 'en') || ($branch->about_arabic && app()->getLocale() == 'ar'))
                    <div class="info-section">
                        <h3 class="info-section-title">
                            <i class="fas fa-info-circle"></i>
                            {{ __('lang.about') }}
                        </h3>
                        <div class="info-content">
                            {!! app()->getLocale() == 'ar' ? $branch->about_arabic : $branch->about_english !!}
                        </div>
                    </div>
                    @endif
                    
                    {{-- Mission Section --}}
                    @if(($branch->mission_english && app()->getLocale() == 'en') || ($branch->mission_arabic && app()->getLocale() == 'ar'))
                    <div class="info-section">
                        <h3 class="info-section-title">
                            <i class="fas fa-bullseye"></i>
                            {{ __('lang.mission') }}
                        </h3>
                        <div class="info-content">
                            {!! app()->getLocale() == 'ar' ? $branch->mission_arabic : $branch->mission_english !!}
                        </div>
                    </div>
                    @endif
                    
                    {{-- Vision Section --}}
                    @if(($branch->vision_english && app()->getLocale() == 'en') || ($branch->vision_arabic && app()->getLocale() == 'ar'))
                    <div class="info-section">
                        <h3 class="info-section-title">
                            <i class="fas fa-eye"></i>
                            {{ __('lang.vision') }}
                        </h3>
                        <div class="info-content">
                            {!! app()->getLocale() == 'ar' ? $branch->vision_arabic : $branch->vision_english !!}
                        </div>
                    </div>
                    @endif
                </div>
                
                {{-- Map Section --}}
                @if($branch->map_url)
                <div class="branch-map-card" data-animate="fadeInUp" data-delay="100">
                    <h3 class="map-title">
                        <i class="fas fa-map-marked-alt"></i>
                        {{ __('lang.location_on_map') }}
                    </h3>
                    <div class="map-wrapper">
                        @if(strpos($branch->map_url, '<iframe') !== false)
                            {!! $branch->map_url !!}
                        @else
                            <iframe src="{{ $branch->map_url }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Contact Card --}}
                <div class="branch-contact-card" data-animate="fadeInUp" data-delay="150">
                    <h3 class="contact-card-title">{{ __('lang.contact_information') }}</h3>
                    
                    <div class="contact-list">
                        @if(($branch->location_text_english && app()->getLocale() == 'en') || ($branch->location_text_arabic && app()->getLocale() == 'ar'))
                        <div class="contact-item-large">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.address') }}</span>
                                <span class="contact-value">{{ app()->getLocale() == 'ar' ? $branch->location_text_arabic : $branch->location_text_english }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if($branch->mobile)
                        <div class="contact-item-large">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.phone') }}</span>
                                <a href="tel:{{ $branch->mobile }}" class="contact-value">{{ $branch->mobile }}</a>
                            </div>
                        </div>
                        @endif
                        
                        @if($branch->office_number)
                        <div class="contact-item-large">
                            <div class="contact-icon">
                                <i class="fas fa-phone-square"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.office_phone') }}</span>
                                <a href="tel:{{ $branch->office_number }}" class="contact-value">{{ $branch->office_number }}</a>
                            </div>
                        </div>
                        @endif
                        
                        @if($branch->email)
                        <div class="contact-item-large">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.email') }}</span>
                                <a href="mailto:{{ $branch->email }}" class="contact-value">{{ $branch->email }}</a>
                            </div>
                        </div>
                        @endif
                        
                        @if($branch->opening_hours)
                        <div class="contact-item-large">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.working_hours') }}</span>
                                <span class="contact-value">{{ $branch->opening_hours }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="contact-actions">
                        @if($branch->mobile)
                        <a href="tel:{{ $branch->mobile }}" class="btn-contact btn-call">
                            <i class="fas fa-phone"></i>
                            {{ __('lang.call_now') }}
                        </a>
                        @endif
                    </div>
                </div>
                
                {{-- Social Links --}}
                @if($branch->website_url || $branch->facebook_url || $branch->instagram_url || $branch->linkedin_url || $branch->twitter_url)
                <div class="branch-social-card" data-animate="fadeInUp" data-delay="200">
                    <h3 class="social-card-title">{{ __('lang.follow_us') }}</h3>
                    <div class="social-links">
                        @if($branch->website_url)
                        <a href="{{ $branch->website_url }}" target="_blank" class="social-link website" title="Website">
                            <i class="fas fa-globe"></i>
                        </a>
                        @endif
                        @if($branch->facebook_url)
                        <a href="{{ $branch->facebook_url }}" target="_blank" class="social-link facebook" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($branch->instagram_url)
                        <a href="{{ $branch->instagram_url }}" target="_blank" class="social-link instagram" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if($branch->linkedin_url)
                        <a href="{{ $branch->linkedin_url }}" target="_blank" class="social-link linkedin" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                        @if($branch->twitter_url)
                        <a href="{{ $branch->twitter_url }}" target="_blank" class="social-link twitter" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
                
                {{-- Other Branches --}}
                @if($otherBranches && $otherBranches->count() > 0)
                <div class="other-branches-card" data-animate="fadeInUp" data-delay="250">
                    <h3 class="other-branches-title">{{ __('lang.other_branches') }}</h3>
                    <div class="other-branches-list">
                        @foreach($otherBranches as $otherBranch)
                        <a href="{{ route('branches.show', $otherBranch->id) }}" class="other-branch-item">
                            <div class="other-branch-logo">
                                @if($otherBranch->logo_english)
                                <img src="{{ asset('storage' . $otherBranch->logo_english) }}" alt="{{ $otherBranch->name_english }}">
                                @else
                                <i class="fas fa-building"></i>
                                @endif
                            </div>
                            <div class="other-branch-info">
                                <span class="other-branch-name">{{ app()->getLocale() == 'ar' ? $otherBranch->name_arabic : $otherBranch->name_english }}</span>
                                @if($otherBranch->mobile)
                                <span class="other-branch-phone">{{ $otherBranch->mobile }}</span>
                                @endif
                            </div>
                            <i class="fas fa-chevron-right {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }}"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="branch-cta-section py-10">
    <div class="container">
        <div class="branch-cta-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title">{{ __('lang.visit_us_today') }}</h3>
                    <p class="cta-text">{{ __('lang.branch_cta_text') }}</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="{{ route('branches.index') }}" class="btn btn-cta">
                        <i class="fas fa-building {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        <span>{{ __('lang.view_all_branches') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/branch-single.css') }}?v={{ time() }}">
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

