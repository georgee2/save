@if($service->faqs && $service->faqs->count() > 0)
<!-- start: Service FAQ Section -->
<section class="tj-faq-section section-gap section-separator">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading text-center">
          <span class="sub-title wow fadeInUp" data-wow-delay=".1s">
            <img src="{{url('/pic/logosvg.svg')}}"> 
            @if(isset($titles['faqs']) && $titles['faqs'])
              @if(App::getLocale() == 'en')
                {{ $titles['faqs']->subtitle_english ?? __('lang.common_questions') }}
              @else
                {{ $titles['faqs']->subtitle_arabic ?? __('lang.common_questions') }}
              @endif
            @else
              {{ __('lang.common_questions') }}
            @endif
          </span>
          <h2 class="sec-title title-anim">
            @if(isset($titles['faqs']) && $titles['faqs'])
              @if(App::getLocale() == 'en')
                {{ $titles['faqs']->title_english }}
              @else
                {{ $titles['faqs']->title_arabic }}
              @endif
            @else
              {{ __('lang.faq') }}
            @endif
          </h2>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="accordion tj-faq" id="faqOne">
            @foreach($service->faqs as $index => $faq)
            <div class="accordion-item {{ $index === 0 ? 'active' : '' }} wow fadeInUp" data-wow-delay=".3s">
              <button class="faq-title {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" 
                data-bs-target="#faq-{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                @if(App::getLocale() == 'en')
                  {{ $faq->question_english }}
                @else
                  {{ $faq->question_arabic }}
                @endif
              </button>
              <div id="faq-{{ $faq->id }}" class="collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqOne">
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
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end: Service FAQ Section -->
@endif