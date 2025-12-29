{{-- Why Choose Us Section --}}
@if($whyChooseUsBlock)
<section class="why-choose-us-section">
    <div class="container">
        <div class="why-choose-us-grid">
            {{-- Left Cards (2 cards) --}}
            <div class="why-cards-left">
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
            
            {{-- Right Cards (2 cards) --}}
            <div class="why-cards-right">
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
    </div>
</section>
@endif

