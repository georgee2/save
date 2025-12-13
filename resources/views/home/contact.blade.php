<!-- start: Contact Section -->
<section class="tj-faq-section section-gap">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-6">
        <div class="faq-img-area wow fadeInLeft" data-wow-delay=".3s">
          <div class="faq-img">
            @if(isset($homeContact) && $homeContact && $homeContact->background)
              <img data-speed=".8" src="{{ asset('storage' . $homeContact->background) }}" alt="{{ App::getLocale() == 'en' ? ($homeContact->title_english ?? 'Contact Us') : ($homeContact->title_arabic ?? 'اتصل بنا') }}">
            @else
              <img data-speed=".8" src="{{ asset('assets/images/faq/faq.webp') }}" alt="Contact Us">
            @endif
            <h2 class="title title-anim">
              @if(isset($homeContact) && $homeContact)
                @if(App::getLocale() == 'en')
                  {{ $homeContact->title_english ?? 'Need Help? Start Here...' }}
                @else
                  {{ $homeContact->title_arabic ?? 'تحتاج مساعدة؟ ابدأ من هنا...' }}
                @endif
                @else
                  {{ __('lang.need_help_start_here') }}
                @endif
            </h2>
          </div>
          <div class="box-area">
            <div class="call-box wow fadeInUp" data-wow-delay=".5s">
              <h4 class="title">
                @if(isset($homeContact) && $homeContact && $homeContact->subtitle_english)
                  @if(App::getLocale() == 'en')
                    {{ $homeContact->subtitle_english }}
                  @else
                    {{ $homeContact->subtitle_arabic ?? $homeContact->subtitle_english }}
                  @endif
                @else
                  {{ __('lang.get_started_free_call') }}
                @endif
              </h4>
              <span class="call-icon"><i class="tji-phone"></i></span>
              @if(isset($contactInfo) && $contactInfo && $contactInfo->mobile)
                <a class="number" href="tel:{{ str_replace([' ', '-', '(', ')'], '', $contactInfo->mobile) }}">
                  <span>{{ $contactInfo->mobile }}</span>
                </a>
              @else
                <a class="number" href="tel:18884521505">
                  <span>1-888-452-1505</span>
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="accordion tj-faq style-2" id="faqTwo">
          @if(isset($homeFaqs) && count($homeFaqs) > 0)
            @foreach($homeFaqs as $index => $faq)
              <div class="accordion-item {{ $index == 0 ? 'active' : '' }} wow fadeInUp" data-wow-delay=".3s">
                <button class="faq-title {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo-{{ $faq->id }}"
                  aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                  @if(App::getLocale() == 'en')
                    {{ $faq->question_english }}
                  @else
                    {{ $faq->question_arabic }}
                  @endif
                </button>
                <div id="faqTwo-{{ $faq->id }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#faqTwo">
                  <div class="accordion-body faq-text">
                    <p>
                      @if(App::getLocale() == 'en')
                        {{ $faq->answer_english }}
                      @else
                        {{ $faq->answer_arabic }}
                      @endif
                    </p>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <!-- Fallback FAQs if none are added -->
            <div class="accordion-item active wow fadeInUp" data-wow-delay=".3s">
              <button class="faq-title" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo-default"
                aria-expanded="true">
                @if(App::getLocale() == 'en')
                  What services does our company offer to clients?
                @else
                  ما هي الخدمات التي تقدمها شركتنا للعملاء؟
                @endif
              </button>
              <div id="faqTwo-default" class="collapse show" data-bs-parent="#faqTwo">
                <div class="accordion-body faq-text">
                  <p>
                    @if(App::getLocale() == 'en')
                      Getting started is easy! Simply reach out to us through our contact form or give us a call, and we'll schedule a consultation to discuss your project and how we can best assist you.
                    @else
                      البدء سهل! ما عليك سوى التواصل معنا من خلال نموذج الاتصال أو الاتصال بنا، وسنحدد موعدًا للاستشارة لمناقشة مشروعك.
                    @endif
                  </p>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end: Contact Section -->
