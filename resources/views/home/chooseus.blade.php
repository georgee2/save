<style>
  /* Icon Hover Effect for Why Choose Us - Show dark by default, white on hover */
  .testimonial-item .choose-icon img.icon-white {
    display: none;
  }
  
  .testimonial-item .choose-icon img.icon-dark {
    display: block;
  }
  
  .testimonial-item:hover .choose-icon img.icon-dark {
    display: none;
  }
  
  .testimonial-item:hover .choose-icon img.icon-white {
    display: block;
  }
  
  /* Make sure icons are properly sized */
  .testimonial-item .choose-icon img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    margin-bottom: 15px;
  }
  
  /* Change background to orange on hover */
  .testimonial-item {
    transition: background-color 0.3s ease, transform 0.3s ease;
  }
  
  .testimonial-item:hover {
    background-color: #e64c29 !important;
    transform: translateY(-5px);
  }
  
  /* Change text color to white on hover for better contrast */
  .testimonial-item:hover h5,
  .testimonial-item:hover p {
    color: #ffffff !important;
  }
</style>

<!-- start: Why Choose Us Section -->
<section class="h9-testimonial">
  <div class="container">
    @if($whyChooseUsBlock && $whyChooseUsCards && $whyChooseUsCards->count() > 0)
      @php
        // Separate cards - we need 4 icon cards (2 left, 2 right)
        $iconCards = [];
        
        foreach($whyChooseUsCards as $card) {
          if($card->card_type == 'icon_card') {
            $iconCards[] = $card;
          }
        }
        
        $delay = 0.2;
      @endphp
      
      <div class="row">
        <!-- LEFT COLUMN: 2 Cards -->
        <div class="col-lg-4 order-2 order-lg-1">
          <div class="h9-testimonial-wrap">
            @if(isset($iconCards[0]))
              <div class="testimonial-item wow fadeInUpBig" data-wow-delay="{{ $delay }}s">
                <div class="choose-icon text-center">
                  @if($iconCards[0]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[0]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[0]->title_english : $iconCards[0]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[0]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[0]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[0]->title_english : $iconCards[0]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <div class="desc">
                  <h5 class="mb-2">
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[0]->title_english }}
                    @else
                      {{ $iconCards[0]->title_arabic }}
                    @endif
                  </h5>
                  <p>
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[0]->bio_english }}
                    @else
                      {{ $iconCards[0]->bio_arabic }}
                    @endif
                  </p>
                </div>
              </div>
              @php $delay += 0.2; @endphp
            @endif
            
            @if(isset($iconCards[1]))
              <div class="testimonial-item style-2 wow fadeInUpBig" data-wow-delay="{{ $delay }}s">
                <div class="choose-icon text-center">
                  @if($iconCards[1]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[1]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[1]->title_english : $iconCards[1]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[1]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[1]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[1]->title_english : $iconCards[1]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <div class="desc">
                  <h5 class="mb-2">
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[1]->title_english }}
                    @else
                      {{ $iconCards[1]->title_arabic }}
                    @endif
                  </h5>
                  <p>
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[1]->bio_english }}
                    @else
                      {{ $iconCards[1]->bio_arabic }}
                    @endif
                  </p>
                </div>
              </div>
              @php $delay += 0.2; @endphp
            @endif
          </div>
        </div>
        
        <!-- MIDDLE COLUMN: Title, Subtitle, Logo -->
        <div class="col-lg-4 order-1 order-lg-2">
          <div class="h9-testimonial-heading">
            <div class="sec-heading style-8">
              <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                @if(App::getLocale() == 'en')
                  {{ $whyChooseUsBlock->subtitle_english }}
                @else
                  {{ $whyChooseUsBlock->subtitle_arabic }}
                @endif
              </span>
              <h2 class="sec-title title-anim">
                @if(App::getLocale() == 'en')
                  {!! $whyChooseUsBlock->title_english !!}
                @else
                  {!! $whyChooseUsBlock->title_arabic !!}
                @endif
              </h2>
            </div>
            <div class="testimonial-img wow fadeInUpBig" data-wow-delay=".3s">
              <img src="{{url('/pic/svgwhite.svg')}}" alt="">
            </div>
          </div>
        </div>
        
        <!-- RIGHT COLUMN: 2 Cards -->
        <div class="col-lg-4 order-3 order-lg-3">
          <div class="h9-testimonial-wrap style-2">
            @if(isset($iconCards[2]))
              <div class="testimonial-item style-2 wow fadeInUpBig" data-wow-delay="{{ $delay }}s">
                <div class="choose-icon text-center">
                  @if($iconCards[2]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[2]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[2]->title_english : $iconCards[2]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[2]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[2]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[2]->title_english : $iconCards[2]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <div class="desc">
                  <h5 class="mb-2">
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[2]->title_english }}
                    @else
                      {{ $iconCards[2]->title_arabic }}
                    @endif
                  </h5>
                  <p>
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[2]->bio_english }}
                    @else
                      {{ $iconCards[2]->bio_arabic }}
                    @endif
                  </p>
                </div>
              </div>
              @php $delay += 0.2; @endphp
            @endif
            
            @if(isset($iconCards[3]))
              <div class="testimonial-item wow fadeInUpBig" data-wow-delay="{{ $delay }}s">
                <div class="choose-icon text-center">
                  @if($iconCards[3]->icon_dark)
                    <img src="{{ asset('storage' . $iconCards[3]->icon_dark) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[3]->title_english : $iconCards[3]->title_arabic }}" class="icon-dark">
                  @endif
                  @if($iconCards[3]->icon_white)
                    <img src="{{ asset('storage' . $iconCards[3]->icon_white) }}" alt="{{ App::getLocale() == 'en' ? $iconCards[3]->title_english : $iconCards[3]->title_arabic }}" class="icon-white">
                  @endif
                </div>
                <div class="desc">
                  <h5 class="mb-2">
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[3]->title_english }}
                    @else
                      {{ $iconCards[3]->title_arabic }}
                    @endif
                  </h5>
                  <p>
                    @if(App::getLocale() == 'en')
                      {{ $iconCards[3]->bio_english }}
                    @else
                      {{ $iconCards[3]->bio_arabic }}
                    @endif
                  </p>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    @else
      <!-- Fallback if no data -->
      <div class="row">
        <div class="col-12 text-center">
          <p>No content available for this section.</p>
        </div>
      </div>
    @endif
  </div>
</section>
<!-- end: Why Choose Us Section -->
