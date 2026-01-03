@extends('layouts.master')

@section('title', app()->getLocale() == 'ar' ? $partner->name_arabic : $partner->name_english)

@section('seo_desc', Str::limit(strip_tags(app()->getLocale() == 'ar' ? $partner->seo_description_arabic : $partner->seo_description_english), 160))

@section('seo_tags', $partner->seo_tags)

@section('content')

{{-- Hero Section --}}
<section class="partner-hero">
    <div class="partner-hero-bg"></div>
    <div class="partner-hero-overlay"></div>
    <div class="container">
        <div class="partner-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">{{ __('lang.our_partners') }}</a></li>
                    <li class="breadcrumb-item active">{{ app()->getLocale() == 'ar' ? $partner->name_arabic : $partner->name_english }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Partner Profile Section --}}
<section class="partner-profile-section">
    <div class="container">
        <div class="partner-profile-card" data-animate="fadeInUp">
            {{-- Logo --}}
            <div class="profile-logo-wrapper">
                @if($partner->logo_english && app()->getLocale() == 'en')
                <img src="{{ asset('storage' . $partner->logo_english) }}" alt="{{ $partner->name_english }}" class="profile-logo">
                @elseif($partner->logo_arabic && app()->getLocale() == 'ar')
                <img src="{{ asset('storage' . $partner->logo_arabic) }}" alt="{{ $partner->name_arabic }}" class="profile-logo">
                @elseif($partner->logo_english)
                <img src="{{ asset('storage' . $partner->logo_english) }}" alt="{{ $partner->name_english }}" class="profile-logo">
                @else
                <div class="profile-logo-placeholder">
                    <i class="fas fa-building"></i>
                </div>
                @endif
            </div>
            
            {{-- Partner Info --}}
            <div class="profile-info">
                <h1 class="profile-name">{{ app()->getLocale() == 'ar' ? $partner->name_arabic : $partner->name_english }}</h1>
                <span class="profile-badge">
                    <i class="fas fa-check-circle"></i>
                    {{ __('lang.trusted_partner') }}
                </span>
            </div>
        </div>
    </div>
</section>

{{-- Partner Content Section --}}
<section class="partner-content-section">
    <div class="container">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8">
                {{-- About Section --}}
                @if((app()->getLocale() == 'ar' && $partner->about_arabic) || (app()->getLocale() == 'en' && $partner->about_english))
                <div class="content-card about-card" data-animate="fadeInUp">
                    <div class="card-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h2 class="card-title">{{ __('lang.about_partner') }}</h2>
                    <div class="card-content">
                        {!! app()->getLocale() == 'ar' ? $partner->about_arabic : $partner->about_english !!}
                    </div>
                </div>
                @endif
                
                {{-- Mission & Vision Section --}}
                @if((app()->getLocale() == 'ar' && ($partner->mission_arabic || $partner->vision_arabic)) || (app()->getLocale() == 'en' && ($partner->mission_english || $partner->vision_english)))
                <div class="mission-vision-wrapper" data-animate="fadeInUp" data-delay="100">
                    {{-- Mission --}}
                    @if((app()->getLocale() == 'ar' && $partner->mission_arabic) || (app()->getLocale() == 'en' && $partner->mission_english))
                    <div class="mv-card mission-card">
                        <div class="mv-header">
                            <div class="mv-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3 class="mv-title">{{ __('lang.our_mission') }}</h3>
                        </div>
                        <div class="mv-content">
                            {!! app()->getLocale() == 'ar' ? $partner->mission_arabic : $partner->mission_english !!}
                        </div>
                    </div>
                    @endif
                    
                    {{-- Vision --}}
                    @if((app()->getLocale() == 'ar' && $partner->vision_arabic) || (app()->getLocale() == 'en' && $partner->vision_english))
                    <div class="mv-card vision-card">
                        <div class="mv-header">
                            <div class="mv-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3 class="mv-title">{{ __('lang.our_vision') }}</h3>
                        </div>
                        <div class="mv-content">
                            {!! app()->getLocale() == 'ar' ? $partner->vision_arabic : $partner->vision_english !!}
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                {{-- Location Section --}}
                @if($partner->map_url || (app()->getLocale() == 'ar' && $partner->location_text_arabic) || (app()->getLocale() == 'en' && $partner->location_text_english))
                <div class="content-card location-card" data-animate="fadeInUp" data-delay="200">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h2 class="card-title">{{ __('lang.location') }}</h2>
                    
                    @if((app()->getLocale() == 'ar' && $partner->location_text_arabic) || (app()->getLocale() == 'en' && $partner->location_text_english))
                    <div class="location-address">
                        <i class="fas fa-map-pin"></i>
                        <span>{{ app()->getLocale() == 'ar' ? $partner->location_text_arabic : $partner->location_text_english }}</span>
                    </div>
                    @endif
                    
                    @if($partner->map_url)
                    <div class="map-container">
                        @if(strpos($partner->map_url, '<iframe') !== false)
                            {!! $partner->map_url !!}
                        @else
                            <iframe src="{{ $partner->map_url }}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
                    </div>
                    @endif
                </div>
                @endif
            </div>
            
            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Contact Card --}}
                <div class="sidebar-card contact-sidebar" data-animate="fadeInUp" data-delay="100">
                    <h3 class="sidebar-title">
                        <i class="fas fa-address-card"></i>
                        {{ __('lang.contact_information') }}
                    </h3>
                    
                    <div class="contact-list">
                        @if($partner->email)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.email') }}</span>
                                <a href="mailto:{{ $partner->email }}" class="contact-value">{{ $partner->email }}</a>
                            </div>
                        </div>
                        @endif
                        
                        @if($partner->mobile)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.mobile') }}</span>
                                <a href="tel:{{ $partner->mobile }}" class="contact-value">{{ $partner->mobile }}</a>
                            </div>
                        </div>
                        @endif
                        
                        @if($partner->office_number)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.office_phone') }}</span>
                                <a href="tel:{{ $partner->office_number }}" class="contact-value">{{ $partner->office_number }}</a>
                            </div>
                        </div>
                        @endif
                        
                        @if($partner->website_url)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.website') }}</span>
                                <a href="{{ $partner->website_url }}" target="_blank" class="contact-value">
                                    {{ str_replace(['https://', 'http://', 'www.'], '', $partner->website_url) }}
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($partner->opening_hours)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.working_hours') }}</span>
                                <span class="contact-value-text">{{ $partner->opening_hours }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if($partner->tax_number)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">{{ __('lang.tax_number') }}</span>
                                <span class="contact-value-text">{{ $partner->tax_number }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Social Links --}}
                    @if($partner->facebook_url || $partner->instagram_url || $partner->linkedin_url || $partner->twitter_url)
                    <div class="social-section">
                        <h4 class="social-title">{{ __('lang.follow_us') }}</h4>
                        <div class="social-links">
                            @if($partner->facebook_url)
                            <a href="{{ $partner->facebook_url }}" target="_blank" class="social-link social-facebook" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if($partner->instagram_url)
                            <a href="{{ $partner->instagram_url }}" target="_blank" class="social-link social-instagram" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($partner->linkedin_url)
                            <a href="{{ $partner->linkedin_url }}" target="_blank" class="social-link social-linkedin" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                            @if($partner->twitter_url)
                            <a href="{{ $partner->twitter_url }}" target="_blank" class="social-link social-twitter" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                
                {{-- Quick Actions --}}
                <div class="sidebar-card actions-sidebar" data-animate="fadeInUp" data-delay="200">
                    <h3 class="sidebar-title">
                        <i class="fas fa-bolt"></i>
                        {{ __('lang.quick_actions') }}
                    </h3>
                    
                    <div class="action-buttons">
                        @if($partner->mobile)
                        <a href="tel:{{ $partner->mobile }}" class="btn-action btn-call">
                            <i class="fas fa-phone"></i>
                            <span>{{ __('lang.call_now') }}</span>
                        </a>
                        @endif
                        
                        @if($partner->website_url)
                        <a href="{{ $partner->website_url }}" target="_blank" class="btn-action btn-website">
                            <i class="fas fa-globe"></i>
                            <span>{{ __('lang.visit_website') }}</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Other Partners Section --}}
@if($otherPartners && $otherPartners->count() > 0)
<section class="other-partners-section">
    <div class="container">
        <div class="section-header" data-animate="fadeInUp">
            <h2 class="section-title">{{ __('lang.other_partners') }}</h2>
            <div class="section-divider"><span></span></div>
        </div>
        
        <div class="other-partners-grid">
            @foreach($otherPartners as $index => $otherPartner)
            <a href="{{ route('partners.show', $otherPartner->id) }}" class="other-partner-card" data-animate="fadeInUp" data-delay="{{ ($index % 4) * 100 }}">
                <div class="other-partner-logo">
                    @if($otherPartner->logo_english && app()->getLocale() == 'en')
                    <img src="{{ asset('storage' . $otherPartner->logo_english) }}" alt="{{ $otherPartner->name_english }}">
                    @elseif($otherPartner->logo_arabic && app()->getLocale() == 'ar')
                    <img src="{{ asset('storage' . $otherPartner->logo_arabic) }}" alt="{{ $otherPartner->name_arabic }}">
                    @elseif($otherPartner->logo_english)
                    <img src="{{ asset('storage' . $otherPartner->logo_english) }}" alt="{{ $otherPartner->name_english }}">
                    @else
                    <i class="fas fa-building"></i>
                    @endif
                </div>
                <span class="other-partner-name">{{ app()->getLocale() == 'ar' ? $otherPartner->name_arabic : $otherPartner->name_english }}</span>
            </a>
            @endforeach
        </div>
        
        <div class="text-center mt-5" data-animate="fadeInUp">
            <a href="{{ route('partners.index') }}" class="btn-view-all">
                <span>{{ __('lang.view_all_partners') }}</span>
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            </a>
        </div>
    </div>
</section>
@endif

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/partner-single.css') }}?v={{ time() }}">
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
