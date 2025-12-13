<!-- start: Fun fact Section -->
<section class="tj-funfact-section section-gap section-gap-x">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-wrap-content">
          <div class="sec-heading style-4">
            <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
              <i class="tji-box"></i>
              @if(App::getLocale() == 'en')
                OUR FUN FACTS
              @else
                حقائقنا الممتعة
              @endif
            </span>
            <h2 class="sec-title title-anim">
              @if(App::getLocale() == 'en')
                Numbers and facts that define performance.
              @else
                أرقام وحقائق تحدد الأداء.
              @endif
            </h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row row-gap-4">
      @if(isset($facts) && $facts->count() > 0)
        @foreach($facts as $index => $fact)
          <div class="col-lg-4 col-md-6">
            <div class="countup-item style-2 wow fadeInUp" data-wow-delay=".{{ ($index + 1) * 2 }}s">
              <span class="count-icon">
                <img src="{{ asset('storage' . $fact->icon) }}" 
                     alt="{{ App::getLocale() == 'en' ? $fact->title_english : $fact->title_arabic }}"
                     style="width: 60px; height: 60px; object-fit: contain;">
              </span>
              <span class="steps">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.</span>
              <div class="count-inner">
                <span class="count-text">
                  @if(App::getLocale() == 'en')
                    {{ $fact->title_english }}
                  @else
                    {{ $fact->title_arabic }}
                  @endif
                </span>
                <div class="inline-content">
                  <span class="count-number" style="font-size: 48px; font-weight: 700; color: var(--tj-color-theme-primary);">
                    {{ $fact->fact_number }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <!-- Default facts if none are added -->
        <div class="col-lg-4 col-md-6">
          <div class="countup-item style-2 wow fadeInUp" data-wow-delay=".7s">
            <span class="count-icon"><i class="tji-growth"></i></span>
            <span class="steps">01.</span>
            <div class="count-inner">
              <span class="count-text">
                @if(App::getLocale() == 'en')
                  Faster Growth
                @else
                  نمو أسرع
                @endif
              </span>
              <div class="inline-content">
                <span class="odometer countup-number" data-count="8.5"></span>
                <span class="count-plus">X</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="countup-item style-2 wow fadeInUp" data-wow-delay=".5s">
            <span class="count-icon"><i class="tji-worldwide"></i></span>
            <span class="steps">02.</span>
            <div class="count-inner">
              <span class="count-text">
                @if(App::getLocale() == 'en')
                  Reach Worldwide
                @else
                  وصول عالمي
                @endif
              </span>
              <div class="inline-content">
                <span class="odometer countup-number" data-count="20"></span>
                <span class="count-plus">M</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="countup-item style-2 wow fadeInUp" data-wow-delay=".1s">
            <span class="count-icon"><i class="tji-complete"></i></span>
            <span class="steps">03.</span>
            <div class="count-inner">
              <span class="count-text">
                @if(App::getLocale() == 'en')
                  Projects Completed
                @else
                  المشاريع المكتملة
                @endif
              </span>
              <div class="inline-content">
                <span class="odometer countup-number" data-count="93"></span>
                <span class="count-plus">%</span>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
  <div class="bg-shape-1">
    <img src="{{asset('assets/images/shape/pattern-2.svg')}}" alt="">
  </div>
  <div class="bg-shape-2">
    <img src="{{asset('assets/images/shape/pattern-3.svg')}}" alt="">
  </div>
</section>
<!-- end: Fun fact Section -->
