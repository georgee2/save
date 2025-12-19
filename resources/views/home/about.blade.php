{{-- About Section - Solutions Built for Business --}}
@if($aboutBlock)
<section class="svg-about-section">
    <div class="container">
        <div class="svg-about-cards">
            {{-- Center Content - Title Area --}}
            <div class="svg-center-content svg-about-center">
                @if($aboutBlock->subtitle_english || $aboutBlock->subtitle_arabic)
                <span class="section-badge" data-animate="fadeInUp">
                    <i class="fas fa-cloud"></i>
                    {{ app()->getLocale() == 'ar' ? $aboutBlock->subtitle_arabic : $aboutBlock->subtitle_english }}
                </span>
                @endif
                
                <h2 class="section-title" data-animate="fadeInUp">
                    {{ app()->getLocale() == 'ar' ? $aboutBlock->title_arabic : $aboutBlock->title_english }}
                </h2>
                
                @if($aboutBlock->button_text_english || $aboutBlock->button_text_arabic)
                <a href="{{ app()->getLocale() == 'ar' ? ($aboutBlock->url_arabic ?? '#') : ($aboutBlock->url_english ?? '#') }}" 
                   class="section-btn" data-animate="fadeInUp">
                    {{ app()->getLocale() == 'ar' ? $aboutBlock->button_text_arabic : $aboutBlock->button_text_english }}
                    <span class="btn-icon">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </a>
                @endif
            </div>

            {{-- Dynamic Cards from Database --}}
            @php
                $iconCards = $aboutCards->where('card_type', 'icon_card')->values();
                $bgCard = $aboutCards->where('card_type', 'card_with_background')->first();
                $cardPositions = ['svg-card-1', 'svg-card-2', 'svg-card-3', 'svg-card-4'];
            @endphp

            {{-- Icon Cards (up to 4) --}}
            @foreach($iconCards->take(4) as $index => $card)
            <div class="svg-icon-card {{ $cardPositions[$index] ?? '' }} {{ $index === 0 ? 'svg-card-featured' : '' }}" data-animate="fadeInUp">
                @if($card->icon_dark)
                <div class="card-icon">
                    <img src="{{ asset('storage' . $card->icon_dark) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}">
                </div>
                @endif
                
                <h3 class="card-title">
                    {{ app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english }}
                </h3>
                
                <p class="card-text">
                    {{ app()->getLocale() == 'ar' ? $card->bio_arabic : $card->bio_english }}
                </p>
            </div>
            @endforeach

            {{-- Background Card (last position) --}}
            @if($bgCard)
            <div class="svg-bg-card svg-card-5" 
                 style="background-image: url('{{ asset('storage' . $bgCard->background) }}')"
                 data-animate="fadeInUp">
                @if($bgCard->icon_white)
                <div class="card-icon-overlay">
                    <img src="{{ asset('storage' . $bgCard->icon_white) }}" alt="Icon">
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
@endif

