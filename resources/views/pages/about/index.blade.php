@extends('layouts.master')

@section('title', app()->getLocale() == 'ar' ? ($aboutInfo->title_arabic ?? __('lang.about_us')) : ($aboutInfo->title_english ?? __('lang.about_us')))

@section('seo_desc', app()->getLocale() == 'ar' ? ($contactInfo->seo_description_arabic ?? '') : ($contactInfo->seo_description_english ?? ''))

@section('seo_tags', app()->getLocale() == 'ar' ? ($aboutInfo->title_arabic ?? __('lang.about_us')) : ($aboutInfo->title_english ?? __('lang.about_us')))

@section('content')

{{-- Hero Section with Cover Image --}}
<section class="about-hero-section position-relative">
    @if($aboutInfo->page_cover_image)
    <div class="about-hero-bg" style="background-image: url('{{ asset('storage' . $aboutInfo->page_cover_image) }}');"></div>
    @else
    <div class="about-hero-bg about-hero-gradient"></div>
    @endif
    <div class="about-hero-overlay"></div>
    <div class="container position-relative">
        <div class="about-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.about_us') }}</li>
                </ol>
            </nav>
            <h1 class="about-hero-title">
                {{ app()->getLocale() == 'ar' ? ($aboutInfo->title_arabic ?? __('lang.about_us')) : ($aboutInfo->title_english ?? __('lang.about_us')) }}
            </h1>
            @if($aboutInfo->subtitle_english || $aboutInfo->subtitle_arabic)
            <p class="about-hero-subtitle">
                {{ app()->getLocale() == 'ar' ? $aboutInfo->subtitle_arabic : $aboutInfo->subtitle_english }}
            </p>
            @endif
        </div>
    </div>
</section>

{{-- About Section - Modern Design --}}
@if($aboutInfo->about_english || $aboutInfo->about_arabic)
<section class="about-section-modern">
    <div class="about-section-bg">
        <div class="about-bg-shape about-bg-shape-1"></div>
        <div class="about-bg-shape about-bg-shape-2"></div>
        <div class="about-bg-shape about-bg-shape-3"></div>
    </div>
    <div class="container">
        <div class="about-modern-wrapper">
            <div class="row align-items-center g-5">
                @if($aboutInfo->about_image)
                <div class="col-lg-6" data-animate="fadeInLeft">
                    <div class="about-image-modern">
                        <div class="about-image-frame">
                            <div class="about-image-inner">
                                <img src="{{ asset('storage' . $aboutInfo->about_image) }}" 
                                     alt="{{ __('lang.about_us') }}">
                            </div>
                            <div class="about-image-border"></div>
                        </div>
                        {{-- Floating Elements --}}
                        <div class="about-float-element about-float-1">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="about-float-element about-float-2">
                            <i class="fas fa-award"></i>
                        </div>
                        {{-- Experience Badge --}}
                        @php
                            $yearsExperience = date('Y') - 2010;
                        @endphp
                        <div class="about-experience-badge">
                            <div class="experience-number">{{ $yearsExperience }}+</div>
                            <div class="experience-text">{{ __('lang.years_experience') ?? 'Years Experience' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-animate="fadeInRight">
                @else
                <div class="col-lg-12" data-animate="fadeInUp">
                @endif
                    <div class="about-content-modern">
                        {{-- Section Badge --}}
                        <div class="about-badge">
                            <span class="badge-icon"><i class="fas fa-info-circle"></i></span>
                            <span class="badge-text">{{ __('lang.who_we_are') }}</span>
                        </div>
                        
                        {{-- Title with Highlight --}}
                        <h2 class="about-title-modern">
                            {{ __('lang.about_us') }}
                            <span class="title-highlight"></span>
                        </h2>
                        
                        {{-- Subtitle/Tagline --}}
                        @if($aboutInfo->subtitle_english || $aboutInfo->subtitle_arabic)
                        <p class="about-tagline">
                            {{ app()->getLocale() == 'ar' ? $aboutInfo->subtitle_arabic : $aboutInfo->subtitle_english }}
                        </p>
                        @endif
                        
                        {{-- About Text with Modern Styling --}}
                        <div class="about-text-modern">
                            <div class="about-text-content">
                                {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->about_arabic : $aboutInfo->about_english)) !!}
                            </div>
                        </div>
                        
                        {{-- Key Points --}}
                        <div class="about-key-points">
                            <div class="key-point">
                                <div class="key-point-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span>{{ __('lang.professional_team') ?? 'Professional Team' }}</span>
                            </div>
                            <div class="key-point">
                                <div class="key-point-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span>{{ __('lang.quality_service') ?? 'Quality Service' }}</span>
                            </div>
                            <div class="key-point">
                                <div class="key-point-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span>{{ __('lang.customer_satisfaction') ?? 'Customer Satisfaction' }}</span>
                            </div>
                        </div>
                        
                        {{-- Action Buttons --}}
                        <div class="about-actions">
                            @if($aboutInfo->company_profile)
                            <a href="{{ asset('storage' . $aboutInfo->company_profile) }}" 
                               class="btn-about-primary" 
                               target="_blank" 
                               download>
                                <span class="btn-icon"><i class="fas fa-file-pdf"></i></span>
                                <span class="btn-text">{{ __('lang.download_company_profile') }}</span>
                                <span class="btn-arrow"><i class="fas fa-download"></i></span>
                            </a>
                            @endif
                            <a href="{{ route('contact') }}" class="btn-about-secondary">
                                <span>{{ __('lang.contact_us') }}</span>
                                <i class="fas fa-arrow-right {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }}"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Features Section - Modern Design --}}
@if($features && count($features) > 0)
<section class="features-section-modern">
    {{-- Background Elements --}}
    <div class="features-bg-wrapper">
        <div class="features-bg-gradient"></div>
        <div class="features-bg-pattern"></div>
        <div class="features-bg-glow features-glow-1"></div>
        <div class="features-bg-glow features-glow-2"></div>
    </div>
    
    <div class="container position-relative">
        {{-- Section Header --}}
        <div class="features-header" data-animate="fadeInUp">
            <div class="features-badge">
                <span class="badge-dot"></span>
                <span class="badge-text">{{ __('lang.what_we_offer') }}</span>
            </div>
            <h2 class="features-title">
                {{ __('lang.our_features') }}
                <span class="title-decoration">
                    <svg viewBox="0 0 200 20" preserveAspectRatio="none">
                        <path d="M0,10 Q50,0 100,10 T200,10" fill="none" stroke="currentColor" stroke-width="3"/>
                    </svg>
                </span>
            </h2>
            <p class="features-subtitle">{{ __('lang.features_subtitle') ?? 'Discover what makes us stand out from the rest' }}</p>
        </div>
        
        {{-- Features Grid --}}
        <div class="features-grid-modern">
            @foreach($features as $index => $feature)
            <div class="feature-card-modern" data-animate="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                {{-- Card Glow Effect --}}
                <div class="feature-card-glow"></div>
                
                {{-- Card Inner --}}
                <div class="feature-card-inner">
                    {{-- Number Badge --}}
                    <div class="feature-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    
                    {{-- Icon Container --}}
                    <div class="feature-icon-modern">
                        <div class="icon-bg">
                            <div class="icon-bg-inner"></div>
                        </div>
                        <div class="icon-content">
                            @if($feature->icon)
                            <img src="{{ asset('storage' . $feature->icon) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}">
                            @else
                            <i class="fas fa-star"></i>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="feature-content-modern">
                        <h4 class="feature-title-modern">
                            {{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}
                        </h4>
                        <p class="feature-desc-modern">
                            {{ app()->getLocale() == 'ar' ? $feature->description_arabic : $feature->description_english }}
                        </p>
                    </div>
                    
                    {{-- Hover Arrow --}}
                    <div class="feature-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    
                    {{-- Bottom Accent Line --}}
                    <div class="feature-accent-line"></div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Bottom Decoration --}}
        <div class="features-bottom-decoration">
            <div class="decoration-line"></div>
            <div class="decoration-icon">
                <i class="fas fa-gem"></i>
            </div>
            <div class="decoration-line"></div>
        </div>
    </div>
</section>
@endif

{{-- Mission, Vision, Values Section - Clean Modern Design --}}
@if(($aboutInfo->mission_english || $aboutInfo->mission_arabic) || ($aboutInfo->vision_english || $aboutInfo->vision_arabic) || ($aboutInfo->values_english || $aboutInfo->values_arabic))
<section class="mvv-section-v2">
    <div class="container">
        {{-- Section Header --}}
        <div class="mvv-section-header text-center" data-animate="fadeInUp">
            <span class="mvv-label">{{ __('lang.our_foundation') }}</span>
            <h2 class="mvv-heading">{{ __('lang.mission_vision_values') }}</h2>
            <div class="mvv-heading-line"></div>
        </div>
        
        {{-- MVV Items --}}
        <div class="mvv-items-wrapper">
            {{-- Mission --}}
            @if($aboutInfo->mission_english || $aboutInfo->mission_arabic)
            <div class="mvv-item" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    @if($aboutInfo->mission_image)
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="{{ asset('storage' . $aboutInfo->mission_image) }}" alt="{{ __('lang.mission') }}">
                            <div class="mvv-image-badge">
                                <i class="fas fa-bullseye"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mvv-item-content {{ !$aboutInfo->mission_image ? 'mvv-full-width' : '' }}">
                        <div class="mvv-item-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="mvv-item-title">{{ __('lang.our_mission') }}</h3>
                        <div class="mvv-item-text">
                            {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->mission_arabic : $aboutInfo->mission_english)) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            {{-- Vision --}}
            @if($aboutInfo->vision_english || $aboutInfo->vision_arabic)
            <div class="mvv-item mvv-item-reverse" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    @if($aboutInfo->vision_image)
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="{{ asset('storage' . $aboutInfo->vision_image) }}" alt="{{ __('lang.vision') }}">
                            <div class="mvv-image-badge mvv-badge-vision">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mvv-item-content {{ !$aboutInfo->vision_image ? 'mvv-full-width' : '' }}">
                        <div class="mvv-item-icon mvv-icon-vision">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="mvv-item-title">{{ __('lang.our_vision') }}</h3>
                        <div class="mvv-item-text">
                            {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->vision_arabic : $aboutInfo->vision_english)) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            {{-- Values --}}
            @if($aboutInfo->values_english || $aboutInfo->values_arabic)
            <div class="mvv-item" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    @if($aboutInfo->values_image)
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="{{ asset('storage' . $aboutInfo->values_image) }}" alt="{{ __('lang.values') }}">
                            <div class="mvv-image-badge mvv-badge-values">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mvv-item-content {{ !$aboutInfo->values_image ? 'mvv-full-width' : '' }}">
                        <div class="mvv-item-icon mvv-icon-values">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="mvv-item-title">{{ __('lang.our_values') }}</h3>
                        <div class="mvv-item-text">
                            {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->values_arabic : $aboutInfo->values_english)) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Certificates Section --}}
@if(isset($certificates) && $certificates->count() > 0)
<section class="certificates-section">
    <div class="container">
        {{-- Section Header --}}
        <div class="certificates-header text-center" data-animate="fadeInUp">
            <span class="certificates-label">{{ __('lang.our_achievements') }}</span>
            <h2 class="certificates-title">{{ __('lang.certificates') }}</h2>
            <div class="certificates-title-line"></div>
            <p class="certificates-subtitle">{{ __('lang.certificates_subtitle') }}</p>
        </div>
        
        {{-- Certificates Slider --}}
        <div class="certificates-slider-wrapper" data-animate="fadeInUp">
            <div class="certificates-slider">
                @foreach($certificates as $certificate)
                <div class="certificate-slide">
                    <div class="certificate-card">
                        @if($certificate->image)
                        <a href="{{ url('/storage' . $certificate->image) }}" 
                           data-gtf-mfp="true" 
                           data-gallery-id="certificates-gallery"
                           title="{{ app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english }}">
                            <div class="certificate-image">
                                <img src="{{ url('/storage' . $certificate->image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english }}">
                                <div class="certificate-overlay">
                                    <div class="certificate-zoom">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @else
                        <div class="certificate-image certificate-no-image">
                            <div class="certificate-placeholder">
                                <i class="fas fa-certificate"></i>
                            </div>
                        </div>
                        @endif
                        <div class="certificate-info">
                            <h4 class="certificate-name">
                                {{ app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english }}
                            </h4>
                            @if($certificate->bio_english || $certificate->bio_arabic)
                            <p class="certificate-bio">
                                {{ app()->getLocale() == 'ar' ? $certificate->bio_arabic : $certificate->bio_english }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Slider Navigation --}}
            <div class="certificates-nav">
                <button class="cert-nav-btn cert-prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="cert-nav-btn cert-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            {{-- Slider Dots --}}
            <div class="certificates-dots"></div>
        </div>
    </div>
</section>
@endif

{{-- Team Slider Section --}}
@if(isset($allTeamMembers) && $allTeamMembers->count() > 0)
<section class="about-team-section py-12">
    <div class="container">
        <div class="text-center mb-8" data-animate="fadeInUp">
            <div class="section-label justify-content-center">
                <span class="label-line"></span>
                <span class="label-text">{{ __('lang.meet_the_team') }}</span>
                <span class="label-line"></span>
            </div>
            <h2 class="section-title">{{ __('lang.our_team') }}</h2>
            <p class="section-subtitle">{{ __('lang.team_slider_bio') }}</p>
        </div>
        
        {{-- Team Slider --}}
        <div class="about-team-slider slick-slider"
             data-slick-options='{"slidesToShow": 5, "slidesToScroll": 1, "autoplay": true, "autoplaySpeed": 2000, "speed": 500, "dots": true, "arrows": true, "infinite": true, "pauseOnHover": false, "responsive": [{"breakpoint": 1200, "settings": {"slidesToShow": 4}}, {"breakpoint": 992, "settings": {"slidesToShow": 3}}, {"breakpoint": 768, "settings": {"slidesToShow": 2}}, {"breakpoint": 480, "settings": {"slidesToShow": 1}}]}'>
            @foreach($allTeamMembers as $member)
            <div class="about-team-slide px-2 pb-4">
                <div class="about-team-card d-block">
                    <div class="about-team-card-inner">
                        {{-- Member Icon --}}
                        <div class="about-team-icon mx-auto mb-3">
                            @if($member->icon)
                            <img src="{{ asset('storage' . $member->icon) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}">
                            @elseif($member->main_image)
                            <img src="{{ asset('storage' . $member->main_image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}">
                            @else
                            <div class="about-team-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                            
                            {{-- Board Badge --}}
                            @if($member->is_board_director)
                            <div class="about-team-badge">
                                <i class="fas fa-star"></i>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Member Info --}}
                        <h5 class="about-team-name">
                            {{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}
                        </h5>
                        
                        @if($member->jobTitle)
                        <p class="about-team-job">
                            {{ app()->getLocale() == 'ar' ? $member->jobTitle->name_arabic : $member->jobTitle->name_english }}
                        </p>
                        @endif
                        
                        @if($member->rank)
                        <p class="about-team-rank">
                            {{ app()->getLocale() == 'ar' ? $member->rank->name_arabic : $member->rank->name_english }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- View All Button --}}
        <div class="text-center mt-8">
            <a href="{{ route('team.index') }}" class="btn-view-team">
                {{ __('lang.view_all_team') }}
                <i class="fas fa-arrow-right {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }} ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Custom Blocks Section - Enhanced Design --}}
@if($customBlocks && count($customBlocks) > 0)
<section class="custom-blocks-section">
    <div class="container">
        {{-- Section Header --}}
        <div class="blocks-section-header text-center" data-animate="fadeInUp">
            <span class="blocks-section-label">{{ __('lang.discover_more') }}</span>
            <h2 class="blocks-section-title">{{ __('lang.more_about_us') }}</h2>
            <div class="blocks-section-line"></div>
        </div>
        
        {{-- Blocks Container --}}
        <div class="blocks-container">
            @foreach($customBlocks as $block)
            <div class="custom-block {{ $loop->even ? 'custom-block-reverse' : '' }}" data-animate="fadeInUp">
                <div class="custom-block-wrapper">
                    {{-- Image Column --}}
                    @if($block->image)
                    <div class="custom-block-image">
                        <div class="block-img-frame">
                            <img src="{{ asset('storage' . $block->image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}">
                            <div class="block-img-overlay"></div>
                        </div>
                        <div class="block-img-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    @endif
                    
                    {{-- Content Column --}}
                    <div class="custom-block-content {{ !$block->image ? 'custom-block-full' : '' }}">
                        <div class="block-content-box">
                            <span class="block-step-label">{{ __('lang.step') }} {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="block-content-title">
                                {{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}
                            </h3>
                            <div class="block-content-desc">
                                {!! nl2br(e(app()->getLocale() == 'ar' ? $block->description_arabic : $block->description_english)) !!}
                            </div>
                            <div class="block-content-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Government Partners Slider --}}
@include('home.government-partners')

{{-- CTA Section --}}
<section class="about-cta-section py-10">
    <div class="container">
        <div class="about-cta-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title">{{ __('lang.ready_to_start') }}</h3>
                    <p class="cta-text">{{ __('lang.cta_description') }}</p>
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
<link rel="stylesheet" href="{{ asset('/assets/css/about-page.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Smooth tab transitions
    $('#mvvTabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    // Certificates Slider
    if ($('.certificates-slider').length) {
        $('.certificates-slider').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 600,
            dots: true,
            arrows: true,
            infinite: true,
            pauseOnHover: true,
            prevArrow: '.cert-prev',
            nextArrow: '.cert-next',
            appendDots: '.certificates-dots',
            rtl: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        centerMode: true,
                        centerPadding: '30px'
                    }
                }
            ]
        });
    }
});
</script>
@endsection

