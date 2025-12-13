<!-- start: Features Section -->
        <section class="h5-service-section h10-service section-gap">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading-wrap style-8">
                  <div class="heading-wrap-content">
                    <div class="sec-heading style-3">
                      <span class="sub-title wow fadeInUp" data-wow-delay=".3s"><img src="{{url('/pic/logosvg.svg')}}"> {{ __('lang.our_features') }}</span>
                      <h2 class="sec-title text-anim">{{ __('lang.why_choose_us') }}</h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-12">
                <div class="service-wrapper h10-service-wrapper wow fadeInUp" data-wow-delay=".4s">
                  <div class="swiper h10-service-slider">
                    <div class="swiper-wrapper">
                      @forelse($features as $index => $feature)
                      <div class="swiper-slide">
                        <div class="service-item style-4 wow fadeInUp" data-wow-delay=".{{ ($index + 1) * 2 }}s">
                          <h6 class="h10-service-sln">{{ sprintf('%02d', $index + 1) }}.</h6>
                          <div class="service-icon">
                            @if($feature->icon)
                            <img src="{{ asset('storage/' . $feature->icon) }}" alt="{{ App::getLocale() == 'en' ? $feature->title_english : $feature->title_arabic }}" style="width: 60px; height: 60px; object-fit: contain;">
                            @else
                            <i class="tji-box"></i>
                            @endif
                          </div>
                          <div class="service-content">
                            <h4 class="title">{{ App::getLocale() == 'en' ? $feature->title_english : $feature->title_arabic }}</h4>
                            <p class="desc">{{ App::getLocale() == 'en' ? $feature->description_english : $feature->description_arabic }}</p>
                          </div>
                        </div>
                      </div>
                      @empty
                      <div class="swiper-slide">
                        <div class="service-item style-4">
                          <h6 class="h10-service-sln">01.</h6>
                          <div class="service-icon">
                            <i class="tji-box"></i>
                          </div>
                          <div class="service-content">
                            <h4 class="title">{{ __('lang.no_features_available') }}</h4>
                            <p class="desc">{{ __('lang.add_features_from_admin') }}</p>
                          </div>
                        </div>
                      </div>
                      @endforelse
                    </div>
                    <div class="swiper-pagination-area"></div>
                  </div>
                </div>


              </div>

            </div>
          </div>
        </section>

        <style>
        /* Make icon white on hover */
        .service-item.style-4:hover .service-icon i {
          color: #ffffff !important;
        }
        /* Make icon image white on hover */
        .service-item.style-4:hover .service-icon img {
          filter: brightness(0) invert(1);
          transition: filter 0.3s ease;
        }
        .service-icon img {
          transition: filter 0.3s ease;
        }
        </style>
        <!-- end: Features Section -->