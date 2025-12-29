{{-- Home Contact & FAQ Section --}}
@if($homeContact || ($homeFaqs && $homeFaqs->count() > 0))
<section class="home-contact-faq-section py-lg-12 py-11">
    <div class="container">
        <div class="row">
            {{-- Left Side - Contact Card with Image --}}
            <div class="col-lg-5 mb-6 mb-lg-0">
                <div class="contact-card-wrapper position-relative h-100">
                    @if($homeContact && $homeContact->background)
                    <div class="contact-image-card position-relative rounded-lg overflow-hidden">
                        <img src="{{ url('/storage' . $homeContact->background) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $homeContact->title_arabic : $homeContact->title_english }}"
                             class="w-100 h-100">
                        <div class="contact-image-overlay"></div>
                        <div class="contact-image-content position-absolute">
                            <h3 class="contact-image-title">
                                {{ app()->getLocale() == 'ar' ? $homeContact->title_arabic : $homeContact->title_english }}
                            </h3>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Why Choose Us Card with Phone --}}
                    <div class="contact-phone-card">
                        <h4 class="contact-phone-title">{{ __('lang.why_choose_us') }}</h4>
                        @if($contactInfo && $contactInfo->mobile)
                        <div class="contact-phone-box">
                            <div class="phone-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <a href="tel:{{ $contactInfo->mobile }}" class="phone-number">
                                {{ $contactInfo->mobile }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Right Side - FAQ Accordion --}}
            <div class="col-lg-7">
                @if($homeFaqs && $homeFaqs->count() > 0)
                <div class="faq-wrapper">
                    <div class="accordion accordion-faq" id="homeFaqAccordion">
                        @foreach($homeFaqs as $index => $faq)
                        <div class="faq-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="faq-header" id="faqHeading{{ $faq->id }}">
                                <button class="faq-button {{ $index !== 0 ? 'collapsed' : '' }}" 
                                        type="button" 
                                        data-toggle="collapse" 
                                        data-target="#faqCollapse{{ $faq->id }}" 
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                        aria-controls="faqCollapse{{ $faq->id }}">
                                    <span class="faq-question">
                                        {{ app()->getLocale() == 'ar' ? $faq->question_arabic : $faq->question_english }}
                                    </span>
                                    <span class="faq-icon">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus"></i>
                                    </span>
                                </button>
                            </div>
                            <div id="faqCollapse{{ $faq->id }}" 
                                 class="faq-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                 aria-labelledby="faqHeading{{ $faq->id }}" 
                                 data-parent="#homeFaqAccordion">
                                <div class="faq-body">
                                    {!! app()->getLocale() == 'ar' ? $faq->answer_arabic : $faq->answer_english !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

