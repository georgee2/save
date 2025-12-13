<style>
  /* Icon Hover Effect - Show dark by default, white on hover */
  .choose-box .choose-icon img.icon-white {
    display: none;
  }
  
  .choose-box .choose-icon img.icon-dark {
    display: block;
  }
  
  .choose-box:hover .choose-icon img.icon-dark {
    display: none;
  }
  
  .choose-box:hover .choose-icon img.icon-white {
    display: block;
  }
  
  /* Background card - show only white icon, always visible */
  .countup-item .count-icon img.icon-dark {
    display: none;
  }
  
  .countup-item .count-icon img.icon-white {
    display: block;
  }
  
  /* Make sure icons are properly sized */
  .choose-box .choose-icon img,
  .countup-item .count-icon img {
    width: 60px;
    height: 60px;
    object-fit: contain;
  }
</style>

<!-- start: Choose Section -->
<section id="choose" class="tj-choose-section section-gap">
  <div class="container">
    <div class="row row-gap-4">
      @if($aboutBlock && $aboutCards && $aboutCards->count() > 0)
        @php
          // Separate icon cards from background card
          $iconCards = [];
          $backgroundCard = null;
          
          foreach($aboutCards as $card) {
            if($card->card_type == 'icon_card') {
              $iconCards[] = $card;
            } elseif($card->card_type == 'card_with_background') {
              $backgroundCard = $card;
            }
          }
          
          $delay = 0.2;
        @endphp
        
        <!-- LEFT COLUMN: Card 1 -->
        @if(isset($iconCards[0]))
          <div class="col-lg-4 col-md-6">
            <div class="choose-box wow fadeInUp" data-wow-delay="{{ $delay }}s">
              <div class="choose-content">
                <div class="choose-icon">
                  @if($iconCards[0]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[0]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[0]->title_english : $iconCards[0]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[0]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[0]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[0]->title_english : $iconCards[0]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <h4 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[0]->title_english }}
                  @else
                    {{ $iconCards[0]->title_arabic }}
                  @endif
                </h4>
                <p class="desc">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[0]->bio_english }}
                  @else
                    {{ $iconCards[0]->bio_arabic }}
                  @endif
                </p>
              </div>
            </div>
          </div>
          @php $delay += 0.1; @endphp
        @endif
        
        <!-- MIDDLE COLUMN TOP: Home Block Content (Title, Subtitle, Button) -->
        <div class="col-lg-4 col-md-6">
          <div class="h4-content-wrap text-center">
            <div class="sec-heading style-4 text-center">
              <span class="sub-title wow fadeInUp" data-wow-delay="{{ $delay }}s">
                <i class="tji-box"></i>
                @if(App::getLocale() == 'en')
                  {{ $aboutBlock->subtitle_english }}
                @else
                  {{ $aboutBlock->subtitle_arabic }}
                @endif
              </span>
              <h2 class="sec-title title-anim">
                @if(App::getLocale() == 'en')
                  {!! $aboutBlock->title_english !!}
                @else
                  {!! $aboutBlock->title_arabic !!}
                @endif
              </h2>
            </div>
            @if(($aboutBlock->button_text_english || $aboutBlock->button_text_arabic) && ($aboutBlock->url_english || $aboutBlock->url_arabic))
              <a class="tj-primary-btn wow fadeInUp" data-wow-delay="{{ $delay + 0.2 }}s" href="{{ App::getLocale() == 'en' ? $aboutBlock->url_english : $aboutBlock->url_arabic }}">
                <span class="btn-text">
                  <span>
                    @if(App::getLocale() == 'en')
                      {{ $aboutBlock->button_text_english }}
                    @else
                      {{ $aboutBlock->button_text_arabic }}
                    @endif
                  </span>
                </span>
                <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
              </a>
            @endif
          </div>
        </div>
        @php $delay += 0.1; @endphp
        
        <!-- RIGHT COLUMN: Card 4 -->
        @if(isset($iconCards[3]))
          <div class="col-lg-4 col-md-6">
            <div class="choose-box wow fadeInUp" data-wow-delay="{{ $delay }}s">
              <div class="choose-content">
                <div class="choose-icon">
                  @if($iconCards[3]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[3]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[3]->title_english : $iconCards[3]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[3]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[3]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[3]->title_english : $iconCards[3]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <h4 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[3]->title_english }}
                  @else
                    {{ $iconCards[3]->title_arabic }}
                  @endif
                </h4>
                <p class="desc">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[3]->bio_english }}
                  @else
                    {{ $iconCards[3]->bio_arabic }}
                  @endif
                </p>
              </div>
            </div>
          </div>
          @php $delay += 0.1; @endphp
        @endif
        
        <!-- LEFT COLUMN: Card 2 -->
        @if(isset($iconCards[1]))
          <div class="col-lg-4 col-md-6">
            <div class="choose-box wow fadeInUp" data-wow-delay="{{ $delay }}s">
              <div class="choose-content">
                <div class="choose-icon">
                  @if($iconCards[1]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[1]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[1]->title_english : $iconCards[1]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[1]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[1]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[1]->title_english : $iconCards[1]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <h4 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[1]->title_english }}
                  @else
                    {{ $iconCards[1]->title_arabic }}
                  @endif
                </h4>
                <p class="desc">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[1]->bio_english }}
                  @else
                    {{ $iconCards[1]->bio_arabic }}
                  @endif
                </p>
              </div>
            </div>
          </div>
          @php $delay += 0.1; @endphp
        @endif
        
        <!-- MIDDLE COLUMN BOTTOM: Card 3 -->
        @if(isset($iconCards[2]))
          <div class="col-lg-4 col-md-6">
            <div class="choose-box wow fadeInUp" data-wow-delay="{{ $delay }}s">
              <div class="choose-content">
                <div class="choose-icon">
                  @if($iconCards[2]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[2]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[2]->title_english : $iconCards[2]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[2]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[2]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[2]->title_english : $iconCards[2]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <h4 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[2]->title_english }}
                  @else
                    {{ $iconCards[2]->title_arabic }}
                  @endif
                </h4>
                <p class="desc">
                  @if(App::getLocale() == 'en')
                    {{ $iconCards[2]->bio_english }}
                  @else
                    {{ $iconCards[2]->bio_arabic }}
                  @endif
                </p>
              </div>
            </div>
          </div>
          @php $delay += 0.1; @endphp
        @endif
        
        <!-- RIGHT COLUMN: Card 5 with Background (Only background + white icon) -->
        @if($backgroundCard)
          <div class="col-lg-4 col-md-6">
            <div class="countup-item style-2 wow fadeInUp" data-wow-delay="{{ $delay }}s"
              data-bg-image="{{ asset('storage' . $backgroundCard->background) }}">
              <span class="count-icon">
                @if($backgroundCard->icon_white)
                  <img src="{{ asset('storage' . $backgroundCard->icon_white) }}" alt="Icon" class="icon-white">
                @endif
              </span>
            </div>
          </div>
        @endif
      @else
        <!-- Fallback content if no data -->
        <div class="col-12 text-center">
          <p>No content available for this section.</p>
        </div>
      @endif
    </div>
  </div>
</section>
<!-- end: Choose Section -->
