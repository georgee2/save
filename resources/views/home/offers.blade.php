{{-- Featured Offers Section --}}
@if(isset($featuredOffers) && $featuredOffers->count() > 0)
<section class="pt-lg-12 pb-lg-11 py-11 offers-section">
    <div class="container container-xxl">
        <div class="row align-items-center mb-6">
            <div class="col-md-7">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13">{{ __('lang.special_deals') }}</span>
                <h2 class="text-heading mt-2 mb-0">{{ __('lang.featured_offers_title') }}</h2>
                <span class="heading-divider"></span>
                <p class="mb-0">{{ __('lang.featured_offers_bio') }}</p>
            </div>
            <div class="col-md-5 text-md-right mt-4 mt-md-0">
                <a href="{{ route('offers.index') }}" class="btn fs-14 text-secondary btn-accent py-3 lh-15 px-7 mb-6 mb-lg-0">
                    {{ __('lang.view_all_offers') }}
                    <i class="far fa-long-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        <div class="slick-slider offers-slider custom-arrow-spacing-30"
            data-slick-options='{"slidesToShow": 3,"dots":true,"arrows":false,"autoplay":true,"autoplaySpeed":4000,"infinite":true,"responsive":[{"breakpoint": 1400,"settings": {"slidesToShow":3}},{"breakpoint": 1200,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":true}}]}'>
            
            @foreach($featuredOffers as $offer)
            <div class="box pb-7 pt-2 px-2" data-animate="fadeInUp">
                <div class="offer-card position-relative rounded-lg overflow-hidden shadow-hover-3">
                    {{-- Offer Image with Gradient Overlay --}}
                    <div class="offer-card-image position-relative">
                        <a href="{{ route('offers.show', $offer->slug) }}">
                            <img src="{{ url('/storage' . $offer->main_image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}"
                                 class="w-100">
                        </a>
                        
                        {{-- Gradient Overlay --}}
                        <div class="offer-gradient-overlay"></div>
                        
                        {{-- Price Tag --}}
                        @if($offer->default_price && $offer->currency)
                        <div class="offer-price-tag">
                            <span class="price-label">{{ __('lang.starting_from') }}</span>
                            <span class="price-value">{{ $offer->currency->abbreviation ?? 'AED' }} {{ number_format($offer->default_price->price) }}</span>
                            @if($offer->default_price->emirate)
                            <span class="price-emirate">{{ app()->getLocale() == 'ar' ? $offer->default_price->emirate->title_arabic : $offer->default_price->emirate->title_english }}</span>
                            @endif
                        </div>
                        @endif
                        
                        
                        {{-- Media Count --}}
                        <a href="{{ route('offers.show', $offer->slug) }}" class="offer-media-count position-absolute">
                            @if($offer->total_images > 0)
                            <span class="media-item" data-toggle="tooltip" title="{{ $offer->total_images }} {{ __('lang.images') }}">
                                <i class="far fa-images"></i> {{ $offer->total_images }}
                            </span>
                            @endif
                            @if($offer->video_count > 0)
                            <span class="media-item" data-toggle="tooltip" title="{{ $offer->video_count }} {{ __('lang.videos') }}">
                                <i class="far fa-play-circle"></i> {{ $offer->video_count }}
                            </span>
                            @endif
                        </a>
                    </div>
                    
                    {{-- Offer Code Badge with Copy & Share --}}
                    @if($offer->offer_code)
                    <div class="offer-code-badge">
                        <span class="code-value">{{ $offer->offer_code }}</span>
                        <div class="code-actions">
                            <button type="button" class="code-action-btn copy-code-btn" 
                                    data-code="{{ $offer->offer_code }}" 
                                    data-toggle="tooltip" 
                                    data-placement="left"
                                    title="{{ __('lang.copy_code') }}">
                                <i class="far fa-copy"></i>
                            </button>
                            @php
                                $shareTitle = app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english;
                                $shareCurrency = $offer->currency->abbreviation ?? 'AED';
                                $shareUrl = route('offers.show', $offer->slug);
                                $shareImage = url('/storage' . $offer->main_image);
                                $pricesData = [];
                                if($offer->prices) {
                                    foreach($offer->prices->where('status', 0) as $p) {
                                        if($p->emirate) {
                                            $pricesData[] = [
                                                'emirate_id' => $p->emirate_id,
                                                'price' => number_format($p->price),
                                                'emirate' => app()->getLocale() == 'ar' ? $p->emirate->title_arabic : $p->emirate->title_english,
                                            ];
                                        }
                                    }
                                }
                            @endphp
                            {{-- Share Slide Out --}}
                            <div class="offer-share-group"
                                 data-share-title="{{ $shareTitle }}"
                                 data-share-currency="{{ $shareCurrency }}"
                                 data-share-url="{{ $shareUrl }}"
                                 data-share-image="{{ $shareImage }}"
                                 data-share-prices="{{ json_encode($pricesData) }}">
                                <div class="share-slide-wrapper">
                                    <button type="button" class="code-action-btn share-slide-btn">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    <div class="share-slide-icons">
                                        <a href="#" target="_blank" class="code-action-btn facebook-btn offer-share-fb"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" target="_blank" class="code-action-btn twitter-btn offer-share-tw"><i class="fab fa-twitter"></i></a>
                                        <a href="#" target="_blank" class="code-action-btn linkedin-btn offer-share-li"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="#" target="_blank" class="code-action-btn pinterest-btn offer-share-pi"><i class="fab fa-pinterest-p"></i></a>
                                        <a href="#" class="code-action-btn email-btn offer-share-em"><i class="fas fa-envelope"></i></a>
                                    </div>
                                </div>
                                {{-- WhatsApp Separate --}}
                                <a href="#" target="_blank" class="code-action-btn whatsapp-share-btn offer-share-wa"
                                   data-toggle="tooltip" data-placement="left" title="{{ __('lang.share_whatsapp') }}">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Offer Content --}}
                    <div class="offer-card-body bg-white p-4">
                        {{-- Category --}}
                        <div class="offer-category-info mb-2">
                            @if($offer->category)
                            <a href="{{ route('offers.category', $offer->category->slug) }}" class="offer-cat-link" title="{{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}">
                                {{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}
                            </a>
                            @endif
                            @if($offer->category && $offer->subcategory)
                            <span class="cat-divider">•</span>
                            @endif
                            @if($offer->subcategory)
                            <a href="{{ route('offers.subcategory', $offer->subcategory->slug) }}" class="offer-subcat-link" title="{{ app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english }}">
                                {{ app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english }}
                            </a>
                            @endif
                        </div>
                        
                        {{-- Title --}}
                        <h3 class="offer-title fs-18 font-weight-600 lh-14 mb-3">
                            <a href="{{ route('offers.show', $offer->slug) }}" class="text-heading hover-primary">
                                {{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}
                            </a>
                        </h3>
                        
                        {{-- Specifications --}}
                        @if($offer->specifications->count() > 0)
                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n5 offer-specs">
                            @foreach($offer->specifications->take(4) as $spec)
                            @if($spec->specification)
                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                                data-toggle="tooltip" 
                                title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                                @if($spec->specification->icon)
                                <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                                     class="mr-1" 
                                     style="width: 30px; height: 30px; object-fit: contain;">
                                @else
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-1" 
                                      style="width: 30px; height: 30px; font-size: 14px; font-weight: 600;">
                                    {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                                </span>
                                @endif
                                {{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    
                    {{-- Footer with CTA - Similar to Featured Projects --}}
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                        <p class="fs-17 font-weight-bold text-heading mb-0">
                            @if($offer->sqft)
                            {{ number_format($offer->sqft) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqft') }}</span>
                            @endif
                        </p>
                        <div class="d-flex align-items-center">
                            <button class="btn-favourite mr-2" type="button" data-type="offer" data-id="{{ $offer->id }}"
                                    data-emirate="{{ optional($offer->default_price)->emirate_id ?? '' }}"
                                    data-price="{{ optional($offer->default_price)->price ?? '' }}"
                                    title="{{ __('lang.add_to_favourites') }}">
                                <i class="fal fa-heart"></i>
                            </button>
                            <a href="{{ route('offers.show', $offer->slug) }}"
                               class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                                {{ __('lang.view_offer') }}
                                <i class="far fa-long-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</section>

{{-- Copy Code, Dynamic Share Links & Smart Dots Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic share links - uses selected emirate price
    var urlParams = new URLSearchParams(window.location.search);
    var selectedEmirateId = urlParams.get('emirate_id');

    document.querySelectorAll('.offer-share-group').forEach(function(group) {
        var title = group.getAttribute('data-share-title');
        var currency = group.getAttribute('data-share-currency');
        var url = group.getAttribute('data-share-url');
        var image = group.getAttribute('data-share-image');
        var prices = JSON.parse(group.getAttribute('data-share-prices') || '[]');

        var matched = null;
        if (selectedEmirateId) {
            matched = prices.find(function(p) { return p.emirate_id == selectedEmirateId; });
        }
        if (!matched && prices.length > 0) {
            matched = prices[0];
        }

        var text = title;
        if (matched) {
            text += ' - ' + currency + ' ' + matched.price + ' (' + matched.emirate + ')';
        }

        var enc = encodeURIComponent;
        var fb = group.querySelector('.offer-share-fb');
        var tw = group.querySelector('.offer-share-tw');
        var li = group.querySelector('.offer-share-li');
        var pi = group.querySelector('.offer-share-pi');
        var em = group.querySelector('.offer-share-em');
        var wa = group.querySelector('.offer-share-wa');

        if (fb) fb.href = 'https://www.facebook.com/sharer/sharer.php?u=' + enc(url) + '&quote=' + enc(text);
        if (tw) tw.href = 'https://twitter.com/intent/tweet?url=' + enc(url) + '&text=' + enc(text);
        if (li) li.href = 'https://www.linkedin.com/shareArticle?mini=true&url=' + enc(url) + '&title=' + enc(title) + '&summary=' + enc(text);
        if (pi) pi.href = 'https://pinterest.com/pin/create/button/?url=' + enc(url) + '&media=' + enc(image) + '&description=' + enc(text);
        if (em) em.href = 'mailto:?subject=' + enc(title) + '&body=' + enc(text + '\n\n' + url);
        if (wa) wa.href = 'https://wa.me/?text=' + enc(text + '\n' + url);
    });

    // Copy Code functionality
    document.querySelectorAll('.copy-code-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var code = this.getAttribute('data-code');
            navigator.clipboard.writeText(code).then(function() {
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML = '<i class="far fa-copy"></i>';
                }, 2000);
            });
        });
    });

    // Smart Dots for Offers Slider
    var maxVisible = 5;

    function updateOffersSmartDots() {
        var $dots = $('.offers-slider .slick-dots li');
        var total = $dots.length;
        if (total <= maxVisible) return;

        var activeIndex = $dots.filter('.slick-active').index();

        $dots.removeClass('smart-dot-hidden smart-dot-far');

        $dots.each(function(i) {
            var distance = Math.abs(i - activeIndex);
            if (distance > Math.floor(maxVisible / 2) + 1) {
                $(this).addClass('smart-dot-far');
            } else if (distance > Math.floor(maxVisible / 2)) {
                $(this).addClass('smart-dot-hidden');
            }
        });
    }

    var $offersSlider = $('.offers-slider');
    if ($offersSlider.length) {
        $offersSlider.on('afterChange', updateOffersSmartDots);
        $offersSlider.on('init', updateOffersSmartDots);
        setTimeout(updateOffersSmartDots, 500);
    }
});
</script>
@endif
