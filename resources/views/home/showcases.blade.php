<!-- start: Showcases Section -->
<section class="tj-blog-section-2 section-gap">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading-wrap">
          <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/logosvg.svg')}}">
            {{ __('lang.our_showcases') }}
          </span>
          <div class="heading-wrap-content">
            <div class="sec-heading style-2">
              <h2 class="sec-title text-anim">
                {{ __('lang.strategies_insights') }}
              </h2>
            </div>
            <div class="wow fadeInUp" data-wow-delay=".5s">
              <p class="desc">
                {{ __('lang.developing_personalized_journeys') }}
              </p>
            </div>
            <div class="slider-navigation d-none d-md-inline-flex wow fadeInUp" data-wow-delay=".7s">
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
    <div class="row">
      <div class="col-12">
        <div class="blog-wrapper wow fadeIn" data-wow-delay=".5s">
          <div class="swiper blog-slider">
            <div class="swiper-wrapper">
              @if(isset($showcases) && $showcases->count() > 0)
                @foreach($showcases as $showcase)
                  <div class="swiper-slide">
                    <div class="blog-item style-2">
                      <div class="blog-thumb">
                        <a href="{{ route('showcases.show', ['id' => $showcase->id]) }}">
                          <img src="{{ asset('storage' . $showcase->main_image) }}" 
                               alt="{{ App::getLocale() == 'en' ? $showcase->title_english : $showcase->title_arabic }}"
                               style="width: 292px; height: 330px; object-fit: cover;">
                        </a>
                        <div class="blog-date">
                          <span class="date">{{ $showcase->created_at->format('d') }}</span>
                          <span class="month">{{ $showcase->created_at->format('M') }}</span>
                        </div>
                      </div>
                      <div class="blog-content">
                        <div class="title-area">
                          <div class="blog-meta">
                            <span class="categories">
                              <a href="{{ route('showcases.show', ['id' => $showcase->id]) }}">
                                @if(App::getLocale() == 'en')
                                  Showcase
                                @else
                                  معرض
                                @endif
                              </a>
                            </span>
                            <span>
                              @if(App::getLocale() == 'en')
                                {{ $showcase->created_at->format('M d, Y') }}
                              @else
                                {{ $showcase->created_at->format('Y/m/d') }}
                              @endif
                            </span>
                          </div>
                          <h4 class="title">
                            <a href="{{ route('showcases.show', ['id' => $showcase->id]) }}">
                              @if(App::getLocale() == 'en')
                                {{ Str::limit($showcase->title_english, 60) }}
                              @else
                                {{ Str::limit($showcase->title_arabic, 60) }}
                              @endif
                            </a>
                          </h4>
                        </div>
                        <a class="text-btn" href="{{ route('showcases.show', ['id' => $showcase->id]) }}">
                          <span class="btn-text">
                            <span>
                              @if(App::getLocale() == 'en')
                                Read More
                              @else
                                اقرأ المزيد
                              @endif
                            </span>
                          </span>
                          <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <!-- Fallback if no showcases -->
                <div class="swiper-slide">
                  <div class="blog-item style-2">
                    <div class="blog-thumb">
                      <a href="#"><img src="assets/images/blog/blog-4.webp" alt=""></a>
                      <div class="blog-date">
                        <span class="date">28</span>
                        <span class="month">Feb</span>
                      </div>
                    </div>
                    <div class="blog-content">
                      <div class="title-area">
                        <div class="blog-meta">
                          <span class="categories"><a href="#">Showcase</a></span>
                        </div>
                        <h4 class="title"><a href="#">No showcases available</a></h4>
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
</section>
<!-- end: Showcases Section -->
