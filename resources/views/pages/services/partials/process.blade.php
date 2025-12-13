@if($service->processes && $service->processes->count() > 0)
<!-- start: Service Process Section -->
<section class="h5-service-section h10-service section-gap">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading-wrap style-8">
          <div class="heading-wrap-content">
            <div class="sec-heading style-3">
              <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                <img src="{{url('/pic/logosvg.svg')}}">  
                @if(isset($titles['processes']) && $titles['processes'])
                  @if(App::getLocale() == 'en')
                    {{ $titles['processes']->subtitle_english ?? __('lang.our_process') }}
                  @else
                    {{ $titles['processes']->subtitle_arabic ?? __('lang.our_process') }}
                  @endif
                @else
                  {{ __('lang.our_process') }}
                @endif
              </span>
              <h2 class="sec-title text-anim">
                @if(isset($titles['processes']) && $titles['processes'])
                  @if(App::getLocale() == 'en')
                    {{ $titles['processes']->title_english }}
                  @else
                    {{ $titles['processes']->title_arabic }}
                  @endif
                @else
                  {{ __('lang.service_process') }}
                @endif
              </h2>
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
              @foreach($service->processes as $index => $process)
              <div class="swiper-slide">
                <div class="service-item style-4 wow fadeInUp" data-wow-delay=".{{ ($index + 1) * 2 }}s">
                  <h6 class="h10-service-sln">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.</h6>
                  <div class="service-icon process-icon-bg">
                    @if($process->icon)
                      <img src="{{ asset('storage/' . $process->icon) }}" alt="{{ App::getLocale() == 'en' ? $process->title_english : $process->title_arabic }}" style="width: 50px; height: 50px; object-fit: contain;">
                    @else
                      <i class="tji-service-1" style="font-size: 40px;"></i>
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
<!-- end: Service Process Section -->
@endif