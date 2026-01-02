{{-- Sub Services Section --}}
<section class="service-sub-services-section py-12">
    <div class="container">
        <div class="section-header text-center mb-10">
            <div class="section-badge mb-3">
                <span class="badge-line"></span>
                <span class="badge-text">{{ __('lang.related_services') }}</span>
                <span class="badge-line"></span>
            </div>
            @if(isset($titles['sub_services']) && $titles['sub_services'])
            <h2 class="section-title">
                {{ app()->getLocale() == 'ar' ? $titles['sub_services']->title_arabic : $titles['sub_services']->title_english }}
            </h2>
            @if($titles['sub_services']->subtitle_english || $titles['sub_services']->subtitle_arabic)
            <p class="section-subtitle">
                {{ app()->getLocale() == 'ar' ? $titles['sub_services']->subtitle_arabic : $titles['sub_services']->subtitle_english }}
            </p>
            @endif
            @else
            <h2 class="section-title">{{ __('lang.sub_services_title') }}</h2>
            <p class="section-subtitle">{{ __('lang.sub_services_subtitle') }}</p>
            @endif
        </div>
        
        <div class="sub-services-grid">
            @foreach($service->subServices as $index => $subService)
            <a href="{{ route('services.show', $subService->slug) }}" class="sub-service-card" data-animate="fadeInUp" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="sub-service-image">
                    @if($subService->main_image)
                    <img src="{{ asset('storage' . $subService->main_image) }}" alt="{{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}">
                    @else
                    <div class="sub-service-placeholder">
                        @if($subService->icon)
                        <img src="{{ asset('storage' . $subService->icon) }}" alt="">
                        @else
                        <i class="fal fa-cog"></i>
                        @endif
                    </div>
                    @endif
                    <div class="sub-service-overlay">
                        <span class="sub-service-view-btn">
                            <i class="fal fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
                <div class="sub-service-content">
                    <div class="sub-service-icon">
                        @if($subService->icon)
                        <img src="{{ asset('storage' . $subService->icon) }}" alt="">
                        @else
                        <i class="fal fa-cog"></i>
                        @endif
                    </div>
                    <h4 class="sub-service-title">
                        {{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}
                    </h4>
                    <p class="sub-service-bio">
                        {{ Str::limit(app()->getLocale() == 'ar' ? $subService->bio_arabic : $subService->bio_english, 100) }}
                    </p>
                    <span class="sub-service-link">
                        {{ __('lang.learn_more') }}
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

