<!-- start: Banner Slider / Mobile Hero -->
@if($sliders && $sliders->count() > 0)
  @php
    $firstSlider = $sliders->first();
  @endphp
  
  <!-- Desktop Slider (Hidden on Mobile) -->
  <section class="tj-slider-section desktop-slider">
    <div class="swiper hero-slider">
      <div class="swiper-wrapper">
        @foreach($sliders as $slider)
          <div class="swiper-slide tj-slider-item">
            <div class="slider-bg-image" data-bg-image="{{ asset('storage' . $slider->image) }}"></div>
            <div class="container">
              <div class="slider-wrapper">
                <div class="slider-content">
                  <h1 class="slider-title">
                    @if(App::getLocale() == 'en')
                      {!! $slider->title_english !!}
                    @else
                      {!! $slider->title_arabic !!}
                    @endif
                  </h1>
                  <div class="slider-desc">
                    @if(App::getLocale() == 'en')
                      {{ $slider->bio_english }}
                    @else
                      {{ $slider->bio_arabic }}
                    @endif
                  </div>
                  @if(($slider->button_text_english || $slider->button_text_arabic) && ($slider->url_english || $slider->url_arabic))
                    <div class="slider-btn">
                      <a class="tj-primary-btn" href="{{ App::getLocale() == 'en' ? $slider->url_english : $slider->url_arabic }}">
                        <span class="btn-text">
                          <span>
                            @if(App::getLocale() == 'en')
                              {{ $slider->button_text_english }}
                            @else
                              {{ $slider->button_text_arabic }}
                            @endif
                          </span>
                        </span>
                        <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                      </a>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="hero-navigation d-inline-flex wow fadeIn" data-wow-delay="1.5s">
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

    <div class="circle-text-wrap wow fadeInUp" data-wow-delay="1s">
      <span class="circle-text" data-bg-image="assets/images/hero/circle-text.webp"></span>
      <a class="circle-icon" href="service.html"><i class="tji-arrow-down-big"></i></a>
    </div>
  </section>

  <!-- Mobile Hero (Hidden on Desktop) -->
  <section class="tj-mobile-hero mobile-hero-only">
    <div class="mobile-hero-image" style="background-image: url('{{ asset('storage' . $firstSlider->image) }}');">
      <div class="mobile-hero-overlay"></div>
      <div class="container">
        <div class="mobile-hero-content">
          <h1 class="mobile-hero-title">
            @if(App::getLocale() == 'en')
              {!! $firstSlider->title_english !!}
            @else
              {!! $firstSlider->title_arabic !!}
            @endif
          </h1>
          <div class="mobile-hero-desc">
            @if(App::getLocale() == 'en')
              {{ $firstSlider->bio_english }}
            @else
              {{ $firstSlider->bio_arabic }}
            @endif
          </div>
          @if(($firstSlider->button_text_english || $firstSlider->button_text_arabic) && ($firstSlider->url_english || $firstSlider->url_arabic))
            <div class="mobile-hero-btn">
              <a class="tj-primary-btn" href="{{ App::getLocale() == 'en' ? $firstSlider->url_english : $firstSlider->url_arabic }}">
                <span class="btn-text">
                  <span>
                    @if(App::getLocale() == 'en')
                      {{ $firstSlider->button_text_english }}
                    @else
                      {{ $firstSlider->button_text_arabic }}
                    @endif
                  </span>
                </span>
                <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@else
  <!-- Fallback if no sliders found -->
  <section class="tj-slider-section">
    <div class="swiper hero-slider">
      <div class="swiper-wrapper">
        <div class="swiper-slide tj-slider-item">
          <div class="slider-bg-image" data-bg-image="assets/images/hero/slider-1.webp"></div>
          <div class="container">
            <div class="slider-wrapper">
              <div class="slider-content">
                <h1 class="slider-title">Leading Future for <span>Business.</span></h1>
                <div class="slider-desc">Committed to delivering innovative solutions that drive success. With a focus on quality.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
<!-- end: Banner Slider / Mobile Hero -->
