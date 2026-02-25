{{-- Why Choose Us Section --}}
@if($whyChooseUsBlock)
<section class="why-choose-us-section">
    <div class="container">
        <div class="why-choose-us-grid">
            {{-- Left Cards (2 cards) - Desktop --}}
            <div class="why-cards-left why-cards-desktop">
                @foreach($whyChooseUsCards->take(2) as $card)
                <div class="why-card" data-animate="fadeInLeft">
                    <div class="why-card-icon">
                        @if($card->icon_dark)
                        <img src="{{ url('/storage' . $card->icon_dark) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}">
                        @else
                        <i class="fas fa-star"></i>
                        @endif
                    </div>
                    <h3 class="why-card-title">
                        {{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}
                    </h3>
                    <p class="why-card-text">
                        {{ app()->getLocale() == 'ar' ? $card->bio_arabic : $card->bio_english }}
                    </p>
                </div>
                @endforeach
            </div>
            
            {{-- Center - Title & Logo --}}
            <div class="why-center" data-animate="fadeInUp">
                <div class="why-center-content">
                    @if($whyChooseUsBlock->subtitle_english || $whyChooseUsBlock->subtitle_arabic)
                    <span class="why-subtitle">
                        <i class="fas fa-circle"></i>
                        {{ app()->getLocale() == 'ar' ? $whyChooseUsBlock->subtitle_arabic : $whyChooseUsBlock->subtitle_english }}
                    </span>
                    @endif
                    
                    <h2 class="why-title">
                        {{ app()->getLocale() == 'ar' ? $whyChooseUsBlock->title_arabic : $whyChooseUsBlock->title_english }}
                    </h2>
                    
                    <div class="why-logo">
                        <img src="{{ url('/pic/svgwhite.svg') }}" alt="SVG Logo">
                    </div>
                    
                    @if($whyChooseUsBlock->button_text_english || $whyChooseUsBlock->button_text_arabic)
                    <a href="{{ app()->getLocale() == 'ar' ? ($whyChooseUsBlock->url_arabic ?? '#') : ($whyChooseUsBlock->url_english ?? '#') }}" 
                       class="why-btn">
                        {{ app()->getLocale() == 'ar' ? $whyChooseUsBlock->button_text_arabic : $whyChooseUsBlock->button_text_english }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    @endif
                </div>
            </div>
            
            {{-- Right Cards (2 cards) - Desktop --}}
            <div class="why-cards-right why-cards-desktop">
                @foreach($whyChooseUsCards->skip(2)->take(2) as $card)
                <div class="why-card" data-animate="fadeInRight">
                    <div class="why-card-icon">
                        @if($card->icon_dark)
                        <img src="{{ url('/storage' . $card->icon_dark) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}">
                        @else
                        <i class="fas fa-star"></i>
                        @endif
                    </div>
                    <h3 class="why-card-title">
                        {{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}
                    </h3>
                    <p class="why-card-text">
                        {{ app()->getLocale() == 'ar' ? $card->bio_arabic : $card->bio_english }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
        
        {{-- Mobile Cards Slider --}}
        <div class="why-cards-mobile">
            @foreach($whyChooseUsCards->take(4) as $card)
            <div class="why-mobile-slide">
                <div class="why-card">
                    <div class="why-card-icon">
                        @if($card->icon_dark)
                        <img src="{{ url('/storage' . $card->icon_dark) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}">
                        @else
                        <i class="fas fa-star"></i>
                        @endif
                    </div>
                    <h3 class="why-card-title">
                        {{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}
                    </h3>
                    <p class="why-card-text">
                        {{ app()->getLocale() == 'ar' ? $card->bio_arabic : $card->bio_english }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var $whySlider = $('.why-cards-mobile');
    var whyInitialized = false;

    function initWhySlider() {
        if ($(window).width() <= 767) {
            if (!whyInitialized && $whySlider.length) {
                $whySlider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 3500,
                    infinite: true,
                    speed: 400,
                    adaptiveHeight: true,
                    customPaging: function() {
                        return '<span></span>';
                    }
                });
                whyInitialized = true;
            }
        } else {
            if (whyInitialized) {
                $whySlider.slick('unslick');
                whyInitialized = false;
            }
        }
    }

    initWhySlider();
    $(window).on('resize', initWhySlider);
});
</script>
@endif

