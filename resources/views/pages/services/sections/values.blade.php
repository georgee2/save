{{-- Values Section --}}
<section class="service-values-section py-12">
    <div class="container">
        <div class="section-header text-center mb-10">
            <div class="section-badge section-badge-light mb-3">
                <span class="badge-line"></span>
                <span class="badge-text">{{ __('lang.our_values') }}</span>
                <span class="badge-line"></span>
            </div>
            @if(isset($titles['values']) && $titles['values'])
            <h2 class="section-title text-white">
                {{ app()->getLocale() == 'ar' ? $titles['values']->title_arabic : $titles['values']->title_english }}
            </h2>
            @if($titles['values']->subtitle_english || $titles['values']->subtitle_arabic)
            <p class="section-subtitle text-white-70">
                {{ app()->getLocale() == 'ar' ? $titles['values']->subtitle_arabic : $titles['values']->subtitle_english }}
            </p>
            @endif
            @else
            <h2 class="section-title text-white">{{ __('lang.why_choose_us') }}</h2>
            <p class="section-subtitle text-white-70">{{ __('lang.values_subtitle') }}</p>
            @endif
        </div>
        
        <div class="values-slider-wrapper">
            {{-- Slider Navigation Arrows --}}
            <button class="slider-arrow slider-arrow-prev slider-arrow-light" id="valuesPrev">
                <i class="fal fa-chevron-left"></i>
            </button>
            <button class="slider-arrow slider-arrow-next slider-arrow-light" id="valuesNext">
                <i class="fal fa-chevron-right"></i>
            </button>
            
            <div class="values-slider" id="valuesSlider">
                @foreach($service->values as $index => $value)
                <div class="value-slide-item">
                    <div class="value-card">
                        <div class="value-card-inner">
                            @if($value->image)
                            <div class="value-image-wrapper">
                                <img src="{{ asset('storage' . $value->image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $value->title_arabic : $value->title_english }}"
                                     class="value-image">
                            </div>
                            @else
                            <div class="value-image-wrapper value-image-placeholder">
                                @if($value->icon)
                                <img src="{{ asset('storage' . $value->icon) }}" alt="" class="placeholder-icon">
                                @else
                                <i class="fal fa-gem"></i>
                                @endif
                            </div>
                            @endif
                            <div class="value-content-wrapper">
                                <div class="value-number-badge">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                <div class="value-icon-wrapper">
                                    @if($value->icon)
                                    <img src="{{ asset('storage' . $value->icon) }}" alt="" class="value-icon">
                                    @else
                                    <i class="fal fa-star"></i>
                                    @endif
                                </div>
                                <div class="value-content">
                                    <h4 class="value-title">
                                        {{ app()->getLocale() == 'ar' ? $value->title_arabic : $value->title_english }}
                                    </h4>
                                    <p class="value-description">
                                        {{ app()->getLocale() == 'ar' ? $value->description_arabic : $value->description_english }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Slider Dots --}}
            <div class="values-slider-dots">
                <div class="slider-dots slider-dots-light" id="valuesDots"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $('#valuesSlider').length) {
        var isRTL = document.documentElement.dir === 'rtl' || $('html').attr('lang') === 'ar';
        
        $('#valuesSlider').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            speed: 600,
            dots: true,
            arrows: true,
            rtl: isRTL,
            infinite: true,
            pauseOnHover: true,
            prevArrow: '#valuesPrev',
            nextArrow: '#valuesNext',
            appendDots: '#valuesDots',
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
