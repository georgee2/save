<!-- start: Working process Section -->
<section class="h6-working-process section-gap slidebar-stickiy-container">
  <div class="container">
    @if($defaultProcess && $processCards && $processCards->count() > 0)
      <div class="row">
        <!-- LEFT COLUMN: Process Cards -->
        <div class="col-lg-6 order-2 order-lg-1">
          <div class="h6-working-process-inner">
            <div class="h6-working-process-wrapper">
              @foreach($processCards as $index => $card)
                <div class="process-item h6-working-process-item tj-hover-active-item {{ $index === 0 ? 'active' : '' }}">
                  <div class="process-step">
                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.</span>
                  </div>
                  <div class="process-content">
                    <h4 class="title">
                      @if(App::getLocale() == 'en')
                        {{ $card->title_english }}
                      @else
                        {{ $card->title_arabic }}
                      @endif
                    </h4>
                    <p class="desc">
                      @if(App::getLocale() == 'en')
                        {{ $card->bio_english }}
                      @else
                        {{ $card->bio_arabic }}
                      @endif
                    </p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        
        <!-- RIGHT COLUMN: Process Information (Sticky) -->
        <div class="col-lg-6 order-1 order-lg-2">
          <div class="content-wrap slidebar-stickiy">
            <div class="sec-heading style-2 style-6">
              <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                <i class="tji-box"></i>
                @if(App::getLocale() == 'en')
                  {{ $defaultProcess->sub_title_english }}
                @else
                  {{ $defaultProcess->sub_title_arabic }}
                @endif
              </span>
              <h2 class="sec-title title-anim">
                @if(App::getLocale() == 'en')
                  {{ $defaultProcess->title_english }}
                @else
                  {{ $defaultProcess->title_arabic }}
                @endif
              </h2>
            </div>
            
            @if($defaultProcess->bio_english || $defaultProcess->bio_arabic)
              <p class="desc">
                @if(App::getLocale() == 'en')
                  {{ $defaultProcess->bio_english }}
                @else
                  {{ $defaultProcess->bio_arabic }}
                @endif
              </p>
            @endif
            
            @if(($defaultProcess->button_text_english || $defaultProcess->button_text_arabic) && ($defaultProcess->url_english || $defaultProcess->url_arabic))
              <div class="d-none d-lg-inline-flex wow fadeInUp" data-wow-delay=".6s">
                <a class="tj-primary-btn" href="{{ App::getLocale() == 'en' ? $defaultProcess->url_english : $defaultProcess->url_arabic }}">
                  <span class="btn-text">
                    <span>
                      @if(App::getLocale() == 'en')
                        {{ $defaultProcess->button_text_english }}
                      @else
                        {{ $defaultProcess->button_text_arabic }}
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
    @else
      <!-- Fallback content if no process or cards -->
      <div class="row">
        <div class="col-lg-6 order-2 order-lg-1">
          <div class="h6-working-process-inner">
            <div class="h6-working-process-wrapper">
              <div class="process-item h6-working-process-item tj-hover-active-item active">
                <div class="process-step">
                  <span>01.</span>
                </div>
                <div class="process-content">
                  <h4 class="title">
                    @if(App::getLocale() == 'en')
                      Discovery & Planning
                    @else
                      الاكتشاف والتخطيط
                    @endif
                  </h4>
                  <p class="desc">
                    @if(App::getLocale() == 'en')
                      The first step in our process is understanding your unique business needs, objectives, and challenges.
                    @else
                      الخطوة الأولى في عمليتنا هي فهم احتياجات عملك الفريدة وأهدافك وتحدياتك.
                    @endif
                  </p>
                </div>
              </div>
              <div class="process-item h6-working-process-item tj-hover-active-item">
                <div class="process-step">
                  <span>02.</span>
                </div>
                <div class="process-content">
                  <h4 class="title">
                    @if(App::getLocale() == 'en')
                      Execution & Delivery
                    @else
                      التنفيذ والتسليم
                    @endif
                  </h4>
                  <p class="desc">
                    @if(App::getLocale() == 'en')
                      We execute the plan with precision, ensuring timely delivery and quality results.
                    @else
                      ننفذ الخطة بدقة، مع ضمان التسليم في الوقت المحدد والنتائج عالية الجودة.
                    @endif
                  </p>
                </div>
              </div>
              <div class="process-item h6-working-process-item tj-hover-active-item">
                <div class="process-step">
                  <span>03.</span>
                </div>
                <div class="process-content">
                  <h4 class="title">
                    @if(App::getLocale() == 'en')
                      Review & Support
                    @else
                      المراجعة والدعم
                    @endif
                  </h4>
                  <p class="desc">
                    @if(App::getLocale() == 'en')
                      We provide ongoing support and review to ensure continued success and satisfaction.
                    @else
                      نقدم الدعم والمراجعة المستمرة لضمان النجاح والرضا المستمرين.
                    @endif
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
          <div class="content-wrap slidebar-stickiy">
            <div class="sec-heading style-2 style-6">
              <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                <i class="tji-box"></i>
                @if(App::getLocale() == 'en')
                  OUR PROCESS
                @else
                  عمليتنا
                @endif
              </span>
              <h2 class="sec-title title-anim">
                @if(App::getLocale() == 'en')
                  Seamless Process and Great Results.
                @else
                  عملية سلسة ونتائج رائعة.
                @endif
              </h2>
            </div>
            <p class="desc">
              @if(App::getLocale() == 'en')
                We stay ahead of the curve, leveraging cutting-edge technologies and strategies to stay competitive.
              @else
                نبقى في الطليعة، ونستفيد من التقنيات والاستراتيجيات المتطورة للبقاء في المنافسة.
              @endif
            </p>
          </div>
        </div>
      </div>
    @endif
  </div>
</section>
<!-- end: Working process Section -->
