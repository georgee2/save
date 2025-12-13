<!-- start: Portfolio Process Section -->
<section class="h5-service-section h10-service" style="padding: 50px 0; background: #f8f9fa;">
  <div class="container-fluid" style="max-width: 100%; padding: 0 50px;">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading-wrap style-8">
                  <div class="heading-wrap-content">
                    <div class="sec-heading style-3">
              <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                <img src="{{url('/pic/logosvg.svg')}}">
                {{ __('lang.project_process') }}
              </span>
              <h2 class="sec-title text-anim">
                @if(App::getLocale() == 'en')
                  {{ $portfolio->title_english }}
                @else
                  {{ $portfolio->title_arabic }}
                @endif
              </h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    <div class="row">
              <div class="col-12">
                <div class="service-wrapper h10-service-wrapper wow fadeInUp" data-wow-delay=".4s">
                  <div class="swiper h10-service-slider">
                    <div class="swiper-wrapper">
              @foreach($portfolio->processes as $index => $process)
                      <div class="swiper-slide">
                  <div class="service-item style-4 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.2) }}s">
                    <h6 class="h10-service-sln">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.</h6>
                          <div class="service-icon">
                      @if($process->icon)
                        <img src="{{ asset('storage' . $process->icon) }}" alt="Icon" class="process-icon-img" style="width: 60px; height: 60px; object-fit: contain;">
                      @else
                        <i class="tji-service-{{ ($index % 5) + 1 }}"></i>
                      @endif
                          </div>
                          <div class="service-content">
                      <h4 class="title">
                        @if(App::getLocale() == 'en')
                          {{ $process->title_english }}
                        @else
                          {{ $process->title_arabic }}
                        @endif
                      </h4>
                      <p class="desc">
                        @if(App::getLocale() == 'en')
                          {{ $process->description_english }}
                        @else
                          {{ $process->description_arabic }}
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
<!-- end: Portfolio Process Section -->

@section('js')
@parent
<script>
  // Initialize Portfolio Process Slider
  if (document.querySelector('.h10-service-slider')) {
    var portfolioProcessSlider = new Swiper('.h10-service-slider', {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination-area',
        clickable: true,
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
      },
    });
  }
</script>
@endsection
