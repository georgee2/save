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

{{-- About Section --}}
@if($aboutInfo->about_english || $aboutInfo->about_arabic)
<section class="about-section py-12">
    <div class="container">
        <div class="row align-items-center">
            @if($aboutInfo->about_image)
            <div class="col-lg-6 mb-6 mb-lg-0" data-animate="fadeInLeft">
                <div class="about-image-wrapper">
                    <img src="{{ asset('storage' . $aboutInfo->about_image) }}" 
                         alt="{{ __('lang.about_us') }}" 
                         class="about-image">
                    <div class="about-image-accent"></div>
                </div>
            </div>
            <div class="col-lg-6" data-animate="fadeInRight">
            @else
            <div class="col-lg-12" data-animate="fadeInUp">
            @endif
                <div class="about-content">
                    <div class="section-label">
                        <span class="label-line"></span>
                        <span class="label-text">{{ __('lang.who_we_are') }}</span>
                    </div>
                    <h2 class="section-title">{{ __('lang.about_us') }}</h2>
                    <div class="about-text">
                        {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->about_arabic : $aboutInfo->about_english)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Features Section --}}
@if($features && count($features) > 0)
<section class="about-features-section py-12">
    <div class="container">
        <div class="text-center mb-8" data-animate="fadeInUp">
            <div class="section-label justify-content-center">
                <span class="label-line"></span>
                <span class="label-text">{{ __('lang.what_we_offer') }}</span>
                <span class="label-line"></span>
            </div>
            <h2 class="section-title">{{ __('lang.our_features') }}</h2>
        </div>
        
        <div class="features-grid">
            @foreach($features as $feature)
            <div class="feature-card" data-animate="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                <div class="feature-icon-wrapper">
                    @if($feature->icon)
                    <img src="{{ asset('storage' . $feature->icon) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}" 
                         class="feature-icon">
                    @else
                    <i class="fas fa-star"></i>
                    @endif
                </div>
                <h4 class="feature-title">
                    {{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}
                </h4>
                <p class="feature-description">
                    {{ app()->getLocale() == 'ar' ? $feature->description_arabic : $feature->description_english }}
                </p>
                <div class="feature-accent"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Mission, Vision, Values Tabs Section --}}
@if(($aboutInfo->mission_english || $aboutInfo->mission_arabic) || ($aboutInfo->vision_english || $aboutInfo->vision_arabic) || ($aboutInfo->values_english || $aboutInfo->values_arabic))
<section class="mvv-section py-12 bg-light">
    <div class="container">
        <div class="text-center mb-8" data-animate="fadeInUp">
            <div class="section-label justify-content-center">
                <span class="label-line"></span>
                <span class="label-text">{{ __('lang.our_foundation') }}</span>
                <span class="label-line"></span>
            </div>
            <h2 class="section-title">{{ __('lang.mission_vision_values') }}</h2>
        </div>
        
        {{-- Tabs Navigation --}}
        <div class="mvv-tabs-wrapper" data-animate="fadeInUp">
            <ul class="nav nav-pills mvv-nav justify-content-center mb-6" id="mvvTabs" role="tablist">
                @if($aboutInfo->mission_english || $aboutInfo->mission_arabic)
                <li class="nav-item">
                    <a class="nav-link active" id="mission-tab" data-toggle="pill" href="#mission" role="tab">
                        <i class="fas fa-bullseye"></i>
                        <span>{{ __('lang.mission') }}</span>
                    </a>
                </li>
                @endif
                @if($aboutInfo->vision_english || $aboutInfo->vision_arabic)
                <li class="nav-item">
                    <a class="nav-link {{ !($aboutInfo->mission_english || $aboutInfo->mission_arabic) ? 'active' : '' }}" id="vision-tab" data-toggle="pill" href="#vision" role="tab">
                        <i class="fas fa-eye"></i>
                        <span>{{ __('lang.vision') }}</span>
                    </a>
                </li>
                @endif
                @if($aboutInfo->values_english || $aboutInfo->values_arabic)
                <li class="nav-item">
                    <a class="nav-link {{ !($aboutInfo->mission_english || $aboutInfo->mission_arabic) && !($aboutInfo->vision_english || $aboutInfo->vision_arabic) ? 'active' : '' }}" id="values-tab" data-toggle="pill" href="#values" role="tab">
                        <i class="fas fa-heart"></i>
                        <span>{{ __('lang.values') }}</span>
                    </a>
                </li>
                @endif
            </ul>
            
            {{-- Tabs Content --}}
            <div class="tab-content mvv-tab-content" id="mvvTabContent">
                {{-- Mission Tab --}}
                @if($aboutInfo->mission_english || $aboutInfo->mission_arabic)
                <div class="tab-pane fade show active" id="mission" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-lg-6 {{ app()->getLocale() == 'ar' ? 'order-lg-2' : '' }}">
                            <div class="mvv-content">
                                <div class="mvv-icon-wrapper">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <h3 class="mvv-title">{{ __('lang.our_mission') }}</h3>
                                <div class="mvv-text">
                                    {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->mission_arabic : $aboutInfo->mission_english)) !!}
                                </div>
                            </div>
                        </div>
                        @if($aboutInfo->mission_image)
                        <div class="col-lg-6 {{ app()->getLocale() == 'ar' ? 'order-lg-1' : '' }}">
                            <div class="mvv-image-wrapper">
                                <img src="{{ asset('storage' . $aboutInfo->mission_image) }}" alt="{{ __('lang.mission') }}" class="mvv-image">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                {{-- Vision Tab --}}
                @if($aboutInfo->vision_english || $aboutInfo->vision_arabic)
                <div class="tab-pane fade {{ !($aboutInfo->mission_english || $aboutInfo->mission_arabic) ? 'show active' : '' }}" id="vision" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-lg-6 {{ app()->getLocale() == 'ar' ? 'order-lg-2' : '' }}">
                            <div class="mvv-content">
                                <div class="mvv-icon-wrapper vision-icon">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <h3 class="mvv-title">{{ __('lang.our_vision') }}</h3>
                                <div class="mvv-text">
                                    {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->vision_arabic : $aboutInfo->vision_english)) !!}
                                </div>
                            </div>
                        </div>
                        @if($aboutInfo->vision_image)
                        <div class="col-lg-6 {{ app()->getLocale() == 'ar' ? 'order-lg-1' : '' }}">
                            <div class="mvv-image-wrapper">
                                <img src="{{ asset('storage' . $aboutInfo->vision_image) }}" alt="{{ __('lang.vision') }}" class="mvv-image">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                {{-- Values Tab --}}
                @if($aboutInfo->values_english || $aboutInfo->values_arabic)
                <div class="tab-pane fade {{ !($aboutInfo->mission_english || $aboutInfo->mission_arabic) && !($aboutInfo->vision_english || $aboutInfo->vision_arabic) ? 'show active' : '' }}" id="values" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-lg-6 {{ app()->getLocale() == 'ar' ? 'order-lg-2' : '' }}">
                            <div class="mvv-content">
                                <div class="mvv-icon-wrapper values-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <h3 class="mvv-title">{{ __('lang.our_values') }}</h3>
                                <div class="mvv-text">
                                    {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->values_arabic : $aboutInfo->values_english)) !!}
                                </div>
                            </div>
                        </div>
                        @if($aboutInfo->values_image)
                        <div class="col-lg-6 {{ app()->getLocale() == 'ar' ? 'order-lg-1' : '' }}">
                            <div class="mvv-image-wrapper">
                                <img src="{{ asset('storage' . $aboutInfo->values_image) }}" alt="{{ __('lang.values') }}" class="mvv-image">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
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
                <a href="{{ route('team.member', $member->id) }}" class="about-team-card d-block">
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
                </a>
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

{{-- Custom Blocks Section --}}
@if($customBlocks && count($customBlocks) > 0)
<section class="about-blocks-section py-12">
    <div class="container">
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="section-label justify-content-center">
                <span class="label-line"></span>
                <span class="label-text">{{ __('lang.discover_more') }}</span>
                <span class="label-line"></span>
            </div>
            <h2 class="section-title">{{ __('lang.more_about_us') }}</h2>
        </div>
        
        @foreach($customBlocks as $block)
        <div class="about-block {{ $loop->even ? 'block-reverse' : '' }}" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-6 {{ $loop->even ? 'order-lg-2' : '' }} mb-6 mb-lg-0">
                    <div class="block-image-wrapper">
                        @if($block->image)
                        <img src="{{ asset('storage' . $block->image) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}" 
                             class="block-image">
                        @endif
                        <div class="block-image-overlay"></div>
                        <div class="block-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                <div class="col-lg-6 {{ $loop->even ? 'order-lg-1' : '' }}">
                    <div class="block-content {{ $loop->even ? 'block-content-right' : '' }}">
                        <h3 class="block-title">
                            {{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}
                        </h3>
                        <div class="block-text">
                            {!! nl2br(e(app()->getLocale() == 'ar' ? $block->description_arabic : $block->description_english)) !!}
                        </div>
                        <div class="block-accent-line"></div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
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
});
</script>
@endsection

