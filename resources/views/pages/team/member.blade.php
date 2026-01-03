@extends('layouts.master')

@section('title', app()->getLocale() == 'ar' ? $team->name_arabic : $team->name_english)

@section('seo_desc', app()->getLocale() == 'ar' ? ($team->work_experience_arabic ?? __('lang.team_member_seo_desc')) : ($team->work_experience_english ?? __('lang.team_member_seo_desc')))

@section('seo_tags', (app()->getLocale() == 'ar' ? $team->name_arabic : $team->name_english) . ', ' . __('lang.our_team'))

@section('content')

{{-- Hero Section --}}
<section class="member-hero-section position-relative">
    <div class="member-hero-bg member-hero-gradient"></div>
    <div class="member-hero-overlay"></div>
    <div class="container position-relative">
        <div class="member-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about') }}">{{ __('lang.about_us') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('team.index') }}">{{ __('lang.our_team') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ app()->getLocale() == 'ar' ? $team->name_arabic : $team->name_english }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Member Profile Section --}}
<section class="member-profile-section py-12">
    <div class="container">
        <div class="member-profile-card">
            <div class="row align-items-center">
                {{-- Image Column --}}
                <div class="col-lg-5 mb-6 mb-lg-0">
                    <div class="member-image-wrapper" data-animate="fadeInLeft">
                        @if($team->page_image)
                        <img src="{{ asset('storage' . $team->page_image) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $team->name_arabic : $team->name_english }}" 
                             class="member-profile-image">
                        @elseif($team->main_image)
                        <img src="{{ asset('storage' . $team->main_image) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $team->name_arabic : $team->name_english }}" 
                             class="member-profile-image">
                        @else
                        <div class="member-image-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        @endif
                        
                        {{-- Decorative Elements --}}
                        <div class="member-image-frame"></div>
                        <div class="member-image-accent"></div>
                        
                        {{-- Board Badge --}}
                        @if($team->is_board_director)
                        <div class="member-board-badge">
                            <i class="fas fa-star"></i>
                            <span>{{ __('lang.board_member') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                {{-- Info Column --}}
                <div class="col-lg-7">
                    <div class="member-info" data-animate="fadeInRight">
                        {{-- Rank Badge --}}
                        @if($team->rank)
                        <div class="member-rank-badge">
                            {{ app()->getLocale() == 'ar' ? $team->rank->name_arabic : $team->rank->name_english }}
                        </div>
                        @endif
                        
                        {{-- Name --}}
                        <h1 class="member-name">
                            {{ app()->getLocale() == 'ar' ? $team->name_arabic : $team->name_english }}
                        </h1>
                        
                        {{-- Job Title --}}
                        @if($team->jobTitle)
                        <p class="member-job-title">
                            {{ app()->getLocale() == 'ar' ? $team->jobTitle->name_arabic : $team->jobTitle->name_english }}
                        </p>
                        @endif
                        
                        {{-- Divider --}}
                        <div class="member-divider"></div>
                        
                        {{-- Contact Information --}}
                        <div class="member-contact-info">
                            <h4 class="contact-section-title">{{ __('lang.contact_information') }}</h4>
                            <div class="contact-items">
                                @if($team->email)
                                <a href="mailto:{{ $team->email }}" class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-details">
                                        <span class="contact-label">{{ __('lang.email') }}</span>
                                        <span class="contact-value">{{ $team->email }}</span>
                                    </div>
                                </a>
                                @endif
                                
                                @if($team->mobile)
                                <a href="tel:{{ $team->mobile }}" class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="contact-details">
                                        <span class="contact-label">{{ __('lang.phone') }}</span>
                                        <span class="contact-value" dir="ltr">{{ $team->mobile }}</span>
                                    </div>
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Quick Actions --}}
                        <div class="member-actions">
                            @if($team->email)
                            <a href="mailto:{{ $team->email }}" class="btn-member-action btn-primary-action">
                                <i class="fas fa-envelope"></i>
                                <span>{{ __('lang.send_email') }}</span>
                            </a>
                            @endif
                            @if($team->mobile)
                            <a href="tel:{{ $team->mobile }}" class="btn-member-action btn-secondary-action">
                                <i class="fas fa-phone"></i>
                                <span>{{ __('lang.call_now') }}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Work Experience Section --}}
@if(($team->work_experience_english && app()->getLocale() == 'en') || ($team->work_experience_arabic && app()->getLocale() == 'ar'))
<section class="member-experience-section py-12 bg-light">
    <div class="container">
        <div class="experience-content" data-animate="fadeInUp">
            <div class="text-center mb-8">
                <div class="section-label justify-content-center">
                    <span class="label-line"></span>
                    <span class="label-text">{{ __('lang.professional_background') }}</span>
                    <span class="label-line"></span>
                </div>
                <h2 class="section-title">{{ __('lang.work_experience') }}</h2>
            </div>
            
            <div class="experience-card">
                <div class="experience-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="experience-text">
                    {!! nl2br(e(app()->getLocale() == 'ar' ? $team->work_experience_arabic : $team->work_experience_english)) !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Back to Team CTA --}}
<section class="member-cta-section py-10">
    <div class="container">
        <div class="member-cta-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title">{{ __('lang.meet_more_team') }}</h3>
                    <p class="cta-text">{{ __('lang.explore_team_text') }}</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="{{ route('team.index') }}" class="btn btn-cta">
                        <i class="fas fa-users {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        <span>{{ __('lang.view_all_team') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/team-member.css') }}?v={{ time() }}">
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
                entry.target.classList.add('animated');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endsection

