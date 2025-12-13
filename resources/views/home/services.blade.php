

<!-- start: Services Section -->
<section class="tj-project-section-3 section-gap section-gap-x">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading-wrap">
          <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/logosvg.svg')}}"> {{ __('lang.our_services') }}
          </span>
          <div class="heading-wrap-content">
            <div class="sec-heading style-3">
              <h2 class="sec-title title-anim">
                {{ __('lang.breaking_boundaries_building_dreams') }}
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
              @if(isset($services) && count($services) > 0)
                @foreach($services as $service)
                  <div class="swiper-slide">
                    <div class="project-item">
                      <div class="project-img">
                        <img src="{{ asset('storage' . ($service->service_home_image ?? $service->main_image)) }}" 
                             alt="{{ App::getLocale() == 'en' ? $service->title_english : $service->title_arabic }}">
                      </div>
                      <div class="project-content">
                        <span class="categories">
                          <a href="{{ route('services.show', ['slug' => $service->slug]) }}">
                            {{ __('lang.service') }}
                          </a>
                        </span>
                        <div class="project-text">
                          <h4 class="title">
                            <a href="{{ route('services.show', ['slug' => $service->slug]) }}">
                              @if(App::getLocale() == 'en')
                                {{ $service->title_english }}
                              @else
                                {{ $service->title_arabic }}
                              @endif
                            </a>
                          </h4>
                          <a class="project-btn" href="{{ route('services.show', ['slug' => $service->slug]) }}">
                            <i class="tji-arrow-right-big"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <!-- Fallback if no services -->
                <div class="swiper-slide">
                  <div class="project-item">
                    <div class="project-img">
                      <img src="assets/images/project/project-6.webp" alt="">
                    </div>
                    <div class="project-content">
                      <span class="categories"><a href="#">Service</a></span>
                      <div class="project-text">
                        <h4 class="title"><a href="#">No services available</a></h4>
                        <a class="project-btn" href="#">
                          <i class="tji-arrow-right-big"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            </div>
            <div class="swiper-pagination-area"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-shape-1">
    <img src="{{url('/pic/shape/pattern-2.svg')}}" alt="">
  </div>
  <div class="bg-shape-2">
    <img src="{{url('/pic/shape/pattern-3.svg')}}" alt="">
  </div>
</section>
<!-- end: Services Section -->
