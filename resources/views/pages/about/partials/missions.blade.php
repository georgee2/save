 <!-- start: Mission, Vision, Values Section -->
        <section class="h9-service section-gap  section-gap-x tj-sticky-panel-container-2 tj-progress-wrapper">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-4 ">
                <div class="sec-heading style-8  tj-sticky-panel-2">
                  <span class="sub-title wow fadeInUp" data-wow-delay=".3s">{{ __('lang.our_core_values') }}</span>
                  <h2 class="sec-title title-anim">{{ __('lang.mission_vision_values') }}</h2>
                  <div class="h9-service-more wow fadeInUp" data-wow-delay=".3s">
                    <a class="tj-primary-btn" href="{{ route('services.index') }}">
                      <span class="btn-text"><span>{{ __('lang.our_services') }}</span></span>
                      <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-8 ">
                <div class="h9-service-scroll-progress tj-scroll-progress tj-sticky-panel-2">
                  @if($aboutInfo->mission_english || $aboutInfo->mission_arabic)
                  <div class="tj-scroll-progress-item active">
                    <h5 class="tj-scroll-progress-sln">01.</h5>
                    <div class="tj-scroll-progress-ind">
                      <div class="tj-scroll-progress-ind-inner"></div>
                    </div>
                  </div>
                  @endif
                  @if($aboutInfo->vision_english || $aboutInfo->vision_arabic)
                  <div class="tj-scroll-progress-item">
                    <h5 class="tj-scroll-progress-sln">02.</h5>
                    <div class="tj-scroll-progress-ind">
                      <div class="tj-scroll-progress-ind-inner"></div>
                    </div>
                  </div>
                  @endif
                  @if($aboutInfo->values_english || $aboutInfo->values_arabic)
                  <div class="tj-scroll-progress-item">
                    <h5 class="tj-scroll-progress-sln">03.</h5>
                    <div class="tj-scroll-progress-ind">
                      <div class="tj-scroll-progress-ind-inner"></div>
                    </div>
                  </div>
                  @endif
                </div>
                <div class="service-wrapper h9-service-wrapper">
                  @if($aboutInfo->mission_english || $aboutInfo->mission_arabic)
                  <div class="service-item style-5 tj-progress-item">
                    <div class="service-content-area">
                      <div class="service-icon">
                        <i class="fa fa-bullseye"></i>
                      </div>
                      <div class="service-content">
                        <h4 class="title">{{ __('lang.our_mission') }}</h4>
                        <p class="desc">{{ App::getLocale() == 'en' ? $aboutInfo->mission_english : $aboutInfo->mission_arabic }}</p>
                      </div>
                    </div>
                    @if($aboutInfo->mission_image)
                    <div class="service-img">
                      <img src="{{ asset('storage/' . $aboutInfo->mission_image) }}" alt="{{ __('lang.our_mission') }}">
                    </div>
                    @endif
                  </div>
                  @endif

                  @if($aboutInfo->vision_english || $aboutInfo->vision_arabic)
                  <div class="service-item style-5 tj-progress-item">
                    <div class="service-content-area">
                      <div class="service-icon">
                        <i class="fa fa-eye"></i>
                      </div>
                      <div class="service-content">
                        <h4 class="title">{{ __('lang.our_vision') }}</h4>
                        <p class="desc">{{ App::getLocale() == 'en' ? $aboutInfo->vision_english : $aboutInfo->vision_arabic }}</p>
                      </div>
                    </div>
                    @if($aboutInfo->vision_image)
                    <div class="service-img">
                      <img src="{{ asset('storage/' . $aboutInfo->vision_image) }}" alt="{{ __('lang.our_vision') }}">
                    </div>
                    @endif
                  </div>
                  @endif

                  @if($aboutInfo->values_english || $aboutInfo->values_arabic)
                  <div class="service-item style-5 tj-progress-item">
                    <div class="service-content-area">
                      <div class="service-icon">
                        <i class="fa fa-star"></i>
                      </div>
                      <div class="service-content">
                        <h4 class="title">{{ __('lang.our_values') }}</h4>
                        <p class="desc">{{ App::getLocale() == 'en' ? $aboutInfo->values_english : $aboutInfo->values_arabic }}</p>
                      </div>
                    </div>
                    @if($aboutInfo->values_image)
                    <div class="service-img">
                      <img src="{{ asset('storage/' . $aboutInfo->values_image) }}" alt="{{ __('lang.our_values') }}">
                    </div>
                    @endif
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="bg-shape-1">
            <img src="{{ asset('assets/images/shape/pattern-2.svg') }}" alt="">
          </div>
          <div class="bg-shape-2">
            <img src="{{ asset('assets/images/shape/pattern-3.svg') }}" alt="">
          </div>
          <div class="bg-shape-3">
            <img src="{{ asset('assets/images/shape/h7-testimonial-shape-blur.svg') }}" alt="">
          </div>
        </section>

        <style>
        /* Change each slide/card background to main color (orange) */
        .service-item.style-5 {
          background-color: #e64c29 !important;
          border-radius: 15px;
          padding: 30px;
        }

        /* Change icon background to black and icon to white */
        .service-item.style-5 .service-icon {
          background-color: #000000 !important;
          width: 50px !important;
          height: 50px !important;
          display: flex !important;
          align-items: center !important;
          justify-content: center !important;
          border-radius: 50% !important;
        }

        .service-item.style-5 .service-icon i {
          color: #ffffff !important;
          font-size: 20px !important;
        }

        /* Make text white for better contrast on orange card background */
        .service-item.style-5 .service-content .title,
        .service-item.style-5 .service-content .title a,
        .service-item.style-5 .service-content .desc {
          color: #ffffff !important;
        }
        </style>
        <!-- end: Mission, Vision, Values Section -->