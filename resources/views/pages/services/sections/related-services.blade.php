{{-- Related Services Section (for parent services) --}}
<section class="service-related-section py-12">
    <div class="container">
        <div class="section-header text-center mb-10">
            <div class="section-badge mb-3">
                <span class="badge-line"></span>
                <span class="badge-text">{{ __('lang.explore_more') }}</span>
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
            <h2 class="section-title">{{ __('lang.our_specialized_services') }}</h2>
            <p class="section-subtitle">{{ __('lang.related_services_subtitle') }}</p>
            @endif
        </div>
        
        <div class="related-services-slider-wrapper">
            {{-- Navigation Arrows --}}
            <button type="button" class="related-slider-arrow related-slider-prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="related-slider-arrow related-slider-next">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            {{-- Slider --}}
            <div class="related-services-slider">
                @foreach($service->subServices as $index => $subService)
                <div class="related-slide-item">
                    <a href="{{ route('services.show', $subService->slug) }}" class="related-service-card">
                        <div class="related-service-image">
                            @if($subService->main_image)
                            <img src="{{ asset('storage' . $subService->main_image) }}" alt="{{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}">
                            @else
                            <div class="related-service-placeholder">
                                @if($subService->icon)
                                <img src="{{ asset('storage' . $subService->icon) }}" alt="" class="placeholder-icon">
                                @else
                                <i class="fal fa-cog"></i>
                                @endif
                            </div>
                            @endif
                            <div class="related-service-overlay">
                                <span class="related-service-view-btn">
                                    <i class="fal fa-arrow-right"></i>
                                </span>
                            </div>
                            <div class="related-service-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div class="related-service-content">
                            <div class="related-service-icon">
                                @if($subService->icon)
                                <img src="{{ asset('storage' . $subService->icon) }}" alt="">
                                @else
                                <i class="fal fa-cog"></i>
                                @endif
                            </div>
                            <h4 class="related-service-title">
                                {{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}
                            </h4>
                            <p class="related-service-bio">
                                {{ Str::limit(app()->getLocale() == 'ar' ? $subService->bio_arabic : $subService->bio_english, 100) }}
                            </p>
                            <span class="related-service-link">
                                {{ __('lang.learn_more') }}
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
            {{-- Dots --}}
            <div class="related-slider-dots"></div>
        </div>
    </div>
</section>

