<!-- start: Portfolio Section -->
<section class="h10-project section-gap tj-sticky-panel-container">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading style-3 sec-heading-centered">
          <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/logosvg.svg')}}">
            {{ __('lang.latest_portfolio') }}
          </span>
          <h2 class="sec-title text-anim">
            {{ __('lang.breaking_boundaries_building_dreams') }}
          </h2>
          <div class="portfolio-filter h10-project-filter text-center wow fadeInUp" data-wow-delay=".5s">
            <div class="button-group h10-project-button-group filter-button-group">
              <button data-filter="*" class="active">
                {{ __('lang.all') }}
              </button>
              @if(isset($portfolioTypes) && count($portfolioTypes) > 0)
                @foreach($portfolioTypes as $type)
                  <button data-filter=".type-{{ $type->id }}">
                    @if(App::getLocale() == 'en')
                      {{ $type->name_english }}
                    @else
                      {{ $type->name_arabic }}
                    @endif
                  </button>
                @endforeach
              @endif
              <div class="active-bg"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="project-wrapper h7-project-wrapper h10-project-wrapper portfolio-filter-box">
          <div class="portfolio-sizer"></div>
          <div class="gutter-sizer"></div>
          
          @if(isset($portfolios) && count($portfolios) > 0)
            @foreach($portfolios as $portfolio)
              <div class="portfolio-filter-item project-item h4-project-item type-{{ $portfolio->portfolio_type_id }}">
                <div class="project-img" data-cursor-text="{{ __('lang.view_portfolio') }}
                ">
                  <a href="{{ route('portfolios.show', ['slug' => $portfolio->slug]) }}">
                    <img src="{{ asset('storage' . $portfolio->main_image) }}" 
                         alt="{{ App::getLocale() == 'en' ? $portfolio->title_english : $portfolio->title_arabic }}">
                  </a>
                </div>
                <div class="project-content">
                  <div class="project-text">
                    <div>
                      <h4 class="title">
                        <a href="{{ route('portfolios.show', ['slug' => $portfolio->slug]) }}">
                          @if(App::getLocale() == 'en')
                            {{ $portfolio->title_english }}
                          @else
                            {{ $portfolio->title_arabic }}
                          @endif
                        </a>
                      </h4>
                      <span class="categories">
                        <a href="{{ route('portfolios.show', ['slug' => $portfolio->slug]) }}">
                          @if(App::getLocale() == 'en')
                            {{ $portfolio->portfolioType->name_english ?? 'Portfolio' }}
                          @else
                            {{ $portfolio->portfolioType->name_arabic ?? 'عمل' }}
                          @endif
                        </a>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <!-- Fallback if no portfolios -->
            <div class="col-12 text-center">
              <p class="text-muted">
                @if(App::getLocale() == 'en')
                  No portfolios available at the moment.
                @else
                  لا توجد أعمال متاحة في الوقت الحالي.
                @endif
              </p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end: Portfolio Section -->

