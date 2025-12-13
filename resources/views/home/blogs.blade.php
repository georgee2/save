<!-- start: Blog Section -->
        <section class="h6-service ">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading sec-heading-centered style-2 style-6 ">
                  <span class="sub-title wow fadeInUp" data-wow-delay=".3s"><img src="{{url('/pic/logosvg.svg')}}">
                    {{ __('lang.latest_news') }}
                  </span>
                  <h2 class="sec-title title-anim">
                    {{ __('lang.latest_news_articles') }}
                  </h2>
                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-12">
                <div class="h6-service-slider swiper">
                  <div class="swiper-wrapper">
                    @forelse($blogs as $index => $blog)
                    <div class="swiper-slide">
                      <div class="h6-service-item">
                        <div class="h6-service-thumb">
                          <a href="{{ route('blogs.show', ['slug' => $blog->slug]) }}">
                            <img src="{{ url('/storage' . $blog->image) }}" alt="{{ App::getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english }}">
                          </a>
                        </div>
                        <div class="h6-service-content">
                          <h5 class="h6-service-index">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                          </h5>
                          <div class="h6-service-title-wrap">
                            <h4 class="title">
                              <a href="{{ route('blogs.show', ['slug' => $blog->slug]) }}">
                                {{ App::getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english }}
                              </a>
                            </h4>
                            <a class="text-btn" href="{{ route('blogs.show', ['slug' => $blog->slug]) }}">
                              <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                      <div class="h6-service-item">
                        <div class="h6-service-content">
                          <p>
                            @if(App::getLocale() == 'ar')
                              لا توجد أخبار متاحة حالياً
                            @else
                              No news available at the moment
                            @endif
                          </p>
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
        </section>
        <!-- end: Blog Section -->