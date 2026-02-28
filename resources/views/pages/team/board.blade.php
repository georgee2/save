@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('board'); @endphp

@section('title', $seo['title'] ?? __('lang.board_of_directors'))

@section('seo_desc', $seo['description'] ?? __('lang.board_seo_desc'))

@section('seo_tags', $seo['tags'] ?? __('lang.board_of_directors'))

@section('content')

{{-- Hero Section --}}
<section class="board-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="board-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="board-hero-bg board-hero-gradient"></div>
    @endif
    <div class="board-hero-overlay"></div>
    <div class="container position-relative">
        <div class="board-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about') }}">{{ __('lang.about_us') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.board_of_directors') }}</li>
                </ol>
            </nav>
            <h1 class="board-hero-title">{{ __('lang.board_of_directors') }}</h1>
            <p class="board-hero-subtitle">{{ __('lang.board_hero_subtitle') }}</p>
        </div>
    </div>
</section>

{{-- Board Members Section --}}
@if($boardMembers && $boardMembers->count() > 0)
<section class="board-list-section py-12">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="board-section-badge">
                <i class="fas fa-star"></i>
                <span>{{ __('lang.leadership') }}</span>
            </div>
            <h2 class="board-section-title">{{ __('lang.meet_our_leaders') }}</h2>
            <p class="board-section-subtitle">{{ __('lang.board_section_subtitle') }}</p>
        </div>
        
        {{-- Board Members List --}}
        <div class="board-members-list">
            @foreach($boardMembers as $index => $member)
            <div class="board-member-row {{ $index % 2 == 1 ? 'row-reverse' : '' }}" data-animate="fadeInUp" data-delay="{{ $index * 100 }}">
                <div class="board-member-card">
                    {{-- Image Side --}}
                    <div class="board-member-visual">
                        <div class="board-image-container">
                            {{-- Decorative Frame --}}
                            <div class="board-frame-accent"></div>
                            <div class="board-frame-border"></div>
                            
                            {{-- Member Image --}}
                            <div class="board-image-wrapper">
                                @if($member->page_image)
                                <img src="{{ asset('storage' . $member->page_image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}" 
                                     class="board-member-image">
                                @elseif($member->main_image)
                                <img src="{{ asset('storage' . $member->main_image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}" 
                                     class="board-member-image">
                                @else
                                <div class="board-image-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                                @endif
                            </div>
                            
                            {{-- Board Badge --}}
                            <div class="board-member-badge">
                                <i class="fas fa-star"></i>
                                <span>{{ __('lang.board_member') }}</span>
                            </div>
                            
                            {{-- Member Number --}}
                            <div class="board-member-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                    
                    {{-- Content Side --}}
                    <div class="board-member-content">
                        <div class="board-content-inner">
                            {{-- Rank Badge --}}
                            @if($member->rank)
                            <div class="board-rank-tag">
                                {{ app()->getLocale() == 'ar' ? $member->rank->name_arabic : $member->rank->name_english }}
                            </div>
                            @endif
                            
                            {{-- Name --}}
                            <h3 class="board-member-name">
                                {{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}
                            </h3>
                            
                            {{-- Job Title --}}
                            @if($member->jobTitle)
                            <p class="board-member-title">
                                {{ app()->getLocale() == 'ar' ? $member->jobTitle->name_arabic : $member->jobTitle->name_english }}
                            </p>
                            @endif
                            
                            {{-- Divider --}}
                            <div class="board-divider"></div>
                            
                            {{-- Work Experience --}}
                            @if(($member->work_experience_english && app()->getLocale() == 'en') || ($member->work_experience_arabic && app()->getLocale() == 'ar'))
                            <div class="board-member-bio">
                                <p>{{ Str::limit(app()->getLocale() == 'ar' ? $member->work_experience_arabic : $member->work_experience_english, 250) }}</p>
                            </div>
                            @endif
                            
                            {{-- Contact & Action --}}
                            <div class="board-member-actions">
                                <div class="board-contact-links">
                                    @if($member->email)
                                    <a href="mailto:{{ $member->email }}" class="board-contact-btn">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    @endif
                                    @if($member->mobile)
                                    <a href="tel:{{ $member->mobile }}" class="board-contact-btn">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                    @endif
                                </div>
                                <a href="{{ route('team.member', $member->id) }}" class="board-view-btn">
                                    {{ __('lang.view_profile') }}
                                    <i class="fas fa-arrow-right {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }}"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
{{-- Empty State --}}
<section class="board-empty-section py-12">
    <div class="container">
        <div class="text-center">
            <div class="empty-icon mb-4">
                <i class="fas fa-user-tie"></i>
            </div>
            <h3 class="empty-title">{{ __('lang.no_board_members') }}</h3>
            <p class="empty-text">{{ __('lang.board_coming_soon') }}</p>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="board-cta-section py-10">
    <div class="container">
        <div class="board-cta-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title">{{ __('lang.meet_full_team') }}</h3>
                    <p class="cta-text">{{ __('lang.meet_full_team_text') }}</p>
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
<link rel="stylesheet" href="{{ asset('/assets/css/board-page.css') }}?v={{ time() }}">
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

