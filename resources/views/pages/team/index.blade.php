@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('team'); @endphp

@section('title', $seo['title'] ?? __('lang.our_team'))

@section('seo_desc', $seo['description'] ?? __('lang.team_seo_desc'))

@section('seo_tags', $seo['tags'] ?? __('lang.our_team'))

@section('content')

{{-- Hero Section --}}
<section class="team-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="team-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="team-hero-bg team-hero-gradient"></div>
    @endif
    <div class="team-hero-overlay"></div>
    <div class="container position-relative">
        <div class="team-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about') }}">{{ __('lang.about_us') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.our_team') }}</li>
                </ol>
            </nav>
            <h1 class="team-hero-title">{{ __('lang.our_team') }}</h1>
            <p class="team-hero-subtitle">{{ __('lang.team_hero_subtitle') }}</p>
        </div>
    </div>
</section>

{{-- Board of Directors Section --}}
@if($boardMembers && $boardMembers->count() > 0)
<section class="board-section">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="board-section-header">
                <div class="board-icon-wrapper">
                    <i class="fas fa-crown"></i>
                </div>
                <span class="board-label-text">{{ __('lang.leadership') }}</span>
            </div>
            <h2 class="section-title board-title-special">{{ __('lang.board_of_directors') }}</h2>
            <p class="section-subtitle">{{ __('lang.board_subtitle') }}</p>
        </div>
        
        {{-- Board Members Grid --}}
        <div class="board-grid">
            @foreach($boardMembers as $member)
            <div class="board-card" data-animate="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                <div class="board-card-inner">
                    {{-- Image Section --}}
                    <div class="board-image-wrapper">
                        @if($member->main_image)
                        <img src="{{ asset('storage' . $member->main_image) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}" 
                             class="board-image">
                        @else
                        <div class="board-image-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        @endif
                        
                        {{-- Star Badge --}}
                        <div class="board-star-badge">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    
                    {{-- Content Section --}}
                    <div class="board-content">
                        <h3 class="board-name">
                            {{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}
                        </h3>
                        
                        @if($member->rank)
                        <span class="board-rank-label">
                            {{ app()->getLocale() == 'ar' ? $member->rank->name_arabic : $member->rank->name_english }}
                        </span>
                        @endif
                        
                        @if($member->jobTitle)
                        <p class="board-title">
                            {{ app()->getLocale() == 'ar' ? $member->jobTitle->name_arabic : $member->jobTitle->name_english }}
                        </p>
                        @endif
                    </div>
                    
                    {{-- Decorative Element --}}
                    <div class="board-accent"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Team Members Section --}}
@if($teamMembers && $teamMembers->count() > 0)
<section class="team-section {{ $boardMembers && $boardMembers->count() > 0 ? 'bg-light' : '' }}">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="section-label justify-content-center">
                <span class="label-line"></span>
                <span class="label-text">{{ __('lang.meet_the_team') }}</span>
                <span class="label-line"></span>
            </div>
            <h2 class="section-title">{{ __('lang.our_professionals') }}</h2>
            <p class="section-subtitle">{{ __('lang.team_subtitle') }}</p>
        </div>
        
        {{-- Team Members Grid --}}
        <div class="team-grid">
            @foreach($teamMembers as $member)
            <div class="team-card" data-animate="fadeInUp" data-delay="{{ $loop->index * 50 }}">
                {{-- Image --}}
                <div class="team-image-wrapper">
                    @if($member->main_image)
                    <img src="{{ asset('storage' . $member->main_image) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}" 
                         class="team-image">
                    @else
                    <div class="team-image-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    @endif
                </div>
                
                {{-- Content --}}
                <div class="team-content">
                    <h4 class="team-name">
                        {{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}
                    </h4>
                    
                    @if($member->jobTitle)
                    <p class="team-job-title">
                        {{ app()->getLocale() == 'ar' ? $member->jobTitle->name_arabic : $member->jobTitle->name_english }}
                    </p>
                    @endif
                    
                    @if($member->rank)
                    <span class="team-rank">
                        {{ app()->getLocale() == 'ar' ? $member->rank->name_arabic : $member->rank->name_english }}
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Empty State --}}
@if((!$boardMembers || $boardMembers->count() == 0) && (!$teamMembers || $teamMembers->count() == 0))
<section class="team-empty-section py-12">
    <div class="container">
        <div class="text-center">
            <div class="empty-icon mb-4">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="empty-title">{{ __('lang.no_team_members') }}</h3>
            <p class="empty-text">{{ __('lang.team_coming_soon') }}</p>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="team-cta-section py-10">
    <div class="container">
        <div class="team-cta-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title">{{ __('lang.join_our_team') }}</h3>
                    <p class="cta-text">{{ __('lang.team_cta_description') }}</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="{{ route('contact') }}" class="btn btn-cta">
                        <span>{{ __('lang.contact_us') }}</span>
                        <i class="fas fa-arrow-right {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }}"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/team-page.css') }}?v={{ time() }}">
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

