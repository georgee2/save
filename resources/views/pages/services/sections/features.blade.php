{{-- Features Section --}}
<section class="service-features-section py-12">
    <div class="container">
        <div class="section-header text-center mb-10">
            <div class="section-badge mb-3">
                <span class="badge-line"></span>
                <span class="badge-text">{{ __('lang.key_features') }}</span>
                <span class="badge-line"></span>
            </div>
            @if(isset($titles['features']) && $titles['features'])
            <h2 class="section-title">
                {{ app()->getLocale() == 'ar' ? $titles['features']->title_arabic : $titles['features']->title_english }}
            </h2>
            @if($titles['features']->subtitle_english || $titles['features']->subtitle_arabic)
            <p class="section-subtitle">
                {{ app()->getLocale() == 'ar' ? $titles['features']->subtitle_arabic : $titles['features']->subtitle_english }}
            </p>
            @endif
            @else
            <h2 class="section-title">{{ __('lang.service_features') }}</h2>
            <p class="section-subtitle">{{ __('lang.features_subtitle') }}</p>
            @endif
        </div>
        
        <div class="features-slider-wrapper">
            {{-- Slider Navigation Arrows --}}
            <button class="slider-arrow slider-arrow-prev" id="featuresPrev">
                <i class="fal fa-chevron-left"></i>
            </button>
            <button class="slider-arrow slider-arrow-next" id="featuresNext">
                <i class="fal fa-chevron-right"></i>
            </button>
            
            <div class="features-slider" id="featuresSlider">
                @foreach($service->features as $index => $feature)
                <div class="feature-slide-item">
                    <div class="feature-card">
                        <div class="feature-card-inner">
                            <div class="feature-image-wrapper">
                                @if($feature->image)
                                <img src="{{ asset('storage' . $feature->image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}"
                                     class="feature-image">
                                @else
                                <div class="feature-image-placeholder">
                                    @if($feature->icon)
                                    <img src="{{ asset('storage' . $feature->icon) }}" alt="" class="placeholder-icon">
                                    @else
                                    <i class="fal fa-image"></i>
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="feature-content-wrapper">
                                <div class="feature-icon-wrapper">
                                    @if($feature->icon)
                                    <img src="{{ asset('storage' . $feature->icon) }}" alt="" class="feature-icon">
                                    @else
                                    <i class="fal fa-check-circle"></i>
                                    @endif
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">
                                        {{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}
                                    </h4>
                                    <p class="feature-description">
                                        {{ app()->getLocale() == 'ar' ? $feature->description_arabic : $feature->description_english }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Slider Dots --}}
            <div class="features-slider-dots">
                <div class="slider-dots" id="featuresDots"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $('#featuresSlider').length) {
        var isRTL = document.documentElement.dir === 'rtl' || $('html').attr('lang') === 'ar';
        
        $('#featuresSlider').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 600,
            dots: true,
            arrows: true,
            rtl: isRTL,
            infinite: true,
            pauseOnHover: true,
            prevArrow: '#featuresPrev',
            nextArrow: '#featuresNext',
            appendDots: '#featuresDots',
            cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)',
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
});
</script>
