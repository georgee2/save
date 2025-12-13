@if(isset($service) && isset($service->subServices) && count($service->subServices) > 0)
<!-- start: Sub Services Section -->
        <section class="tj-project-section-3 section-gap section-gap-x">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading-wrap">
          <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/logosvg.svg')}}"> 
            @if(isset($titles['sub_services']) && $titles['sub_services'])
              @if(App::getLocale() == 'en')
                {{ $titles['sub_services']->subtitle_english ?? __('lang.related_services') }}
              @else
                {{ $titles['sub_services']->subtitle_arabic ?? __('lang.related_services') }}
              @endif
            @else
              {{ __('lang.related_services') }}
            @endif
          </span>
                  <div class="heading-wrap-content">
                    <div class="sec-heading style-3">
              <h2 class="sec-title title-anim">
                @if(isset($titles['sub_services']) && $titles['sub_services'])
                  @if(App::getLocale() == 'en')
                    {{ $titles['sub_services']->title_english }}
                  @else
                    {{ $titles['sub_services']->title_arabic }}
                  @endif
                @else
                  {{ __('lang.sub_services') }}
                @endif
              </h2>
                    </div>
                    <div class="slider-navigation d-none d-md-inline-flex wow fadeInUp" data-wow-delay=".5s">
                      <div class="slider-prev">
                        <span class="anim-icon">
                          <i class="tji-arrow-left"></i>
                          <i class="tji-arrow-left"></i>
                        </span>
                      </div>
                      <div class="slider-next">
                        <span class="anim-icon">
                          <i class="tji-arrow-right"></i>
                          <i class="tji-arrow-right"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="project-wrapper wow fadeInUp" data-wow-delay=".4s">
                  <div class="swiper project-slider-2">
                    <div class="swiper-wrapper">
              @foreach($service->subServices as $subService)
                      <div class="swiper-slide">
                        <div class="project-item">
                  @if($subService->service_home_image)
                          <div class="project-img">
                    <img src="{{ asset('storage/' . $subService->service_home_image) }}" alt="{{ App::getLocale() == 'en' ? $subService->title_english : $subService->title_arabic }}">
                          </div>
                  @endif
                          <div class="project-content">
                    <span class="categories">
                      <a href="{{ route('services.show', ['slug' => $subService->slug]) }}">
                        {{ __('lang.service') }}
                      </a>
                    </span>
                            <div class="project-text">
                      <h4 class="title">
                        <a href="{{ route('services.show', ['slug' => $subService->slug]) }}">
                          @if(App::getLocale() == 'en')
                            {{ $subService->title_english }}
                          @else
                            {{ $subService->title_arabic }}
                          @endif
                        </a>
                              </h4>
                      <a class="project-btn" href="{{ route('services.show', ['slug' => $subService->slug]) }}">
                                <i class="tji-arrow-right-big"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
              @endforeach
                    </div>
                    <div class="swiper-pagination-area"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
<!-- end: Sub Services Section -->
@endif