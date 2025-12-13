@if($service->features && $service->features->count() > 0)
<!-- start: Service Features Section -->
<section class="h5-service-section overflow-hidden section-gap">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading-wrap style-3">
          <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/logosvg.svg')}}"> 
            @if(isset($titles['features']) && $titles['features'])
              @if(App::getLocale() == 'en')
                {{ $titles['features']->subtitle_english ?? __('lang.our_features') }}
              @else
                {{ $titles['features']->subtitle_arabic ?? __('lang.our_features') }}
              @endif
            @else
              {{ __('lang.our_features') }}
            @endif
          </span>
          <div class="heading-wrap-content">
            <div class="sec-heading style-3">
              <h2 class="sec-title text-anim">
                @if(isset($titles['features']) && $titles['features'])
                  @if(App::getLocale() == 'en')
                    {{ $titles['features']->title_english }}
                  @else
                    {{ $titles['features']->title_arabic }}
                  @endif
                @else
                  {{ __('lang.service_features') }}
                @endif
              </h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="service-wrapper wow fadeInUp" data-wow-delay=".4s">
          <div class="swiper service-features-slider">
            <div class="swiper-wrapper">
              @foreach($service->features as $feature)
              <div class="swiper-slide">
                <div class="service-item style-6 feature-hover-item">
                  <div class="service-icon" style="background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%); width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    @if($feature->icon)
                      <img src="{{ asset('storage/' . $feature->icon) }}" alt="{{ App::getLocale() == 'en' ? $feature->title_english : $feature->title_arabic }}" style="width: 50px; height: 50px; object-fit: contain;">
                    @else
                      <i class="tji-service-1" style="font-size: 40px; color: #ff5722;"></i>
                    @endif
                  </div>
                  <h4 class="title">
                    @if(App::getLocale() == 'en')
                      {{ $feature->title_english }}
                    @else
                      {{ $feature->title_arabic }}
                    @endif
                  </h4>
                  <div class="service-content">
                    <p class="desc">
                      @if(App::getLocale() == 'en')
                        {{ $feature->description_english }}
                      @else
                        {{ $feature->description_arabic }}
                      @endif
                    </p>
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
<!-- end: Service Features Section -->



@endif