@if($service->values && $service->values->count() > 0)
<!-- start: Service Values Section -->
<section id="choose" class="tj-choose-section h6-choose h7-choose section-gap">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading style-2 style-7 text-center">
          <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/logosvg.svg')}}"> 
            @if(isset($titles['values']) && $titles['values'])
              @if(App::getLocale() == 'en')
                {{ $titles['values']->subtitle_english ?? __('lang.our_values') }}
              @else
                {{ $titles['values']->subtitle_arabic ?? __('lang.our_values') }}
              @endif
            @else
              {{ __('lang.our_values') }}
            @endif
          </span>
          <h2 class="sec-title text-anim">
            @if(isset($titles['values']) && $titles['values'])
              @if(App::getLocale() == 'en')
                {{ $titles['values']->title_english }}
              @else
                {{ $titles['values']->title_arabic }}
              @endif
            @else
              {{ __('lang.service_values') }}
            @endif
          </h2>
        </div>
      </div>
    </div>
    <div class="row rightSwipeWrap h7-choose-item-wrapper wow fadeInLeftBig" data-wow-delay=".4s">
      @foreach($service->values as $value)
      <div class="col-lg-4 h7-choose-item">
        <div class="choose-box h6-choose-box h7-choose-box">
          <div class="choose-content">
            <div class="choose-icon">
              <div class="values-icon-bg">
                @if($value->icon)
                  <img src="{{ asset('storage/' . $value->icon) }}" alt="{{ App::getLocale() == 'en' ? $value->title_english : $value->title_arabic }}" style="width: 50px; height: 50px; object-fit: contain;">
                @else
                  <i class="tji-innovative" style="font-size: 40px;"></i>
                @endif
              </div>
            </div>
            <h4 class="title">
              @if(App::getLocale() == 'en')
                {{ $value->title_english }}
              @else
                {{ $value->title_arabic }}
              @endif
            </h4>
            <p class="desc">
              @if(App::getLocale() == 'en')
                {{ $value->description_english }}
              @else
                {{ $value->description_arabic }}
              @endif
            </p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
<!-- end: Service Values Section -->
@endif