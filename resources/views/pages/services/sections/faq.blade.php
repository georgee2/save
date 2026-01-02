{{-- FAQ Section --}}
<section class="service-faq-section py-12">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="faq-sidebar">
                    <div class="section-badge mb-3">
                        <span class="badge-line"></span>
                        <span class="badge-text">{{ __('lang.faq') }}</span>
                    </div>
                    @if(isset($titles['faqs']) && $titles['faqs'])
                    <h2 class="section-title">
                        {{ app()->getLocale() == 'ar' ? $titles['faqs']->title_arabic : $titles['faqs']->title_english }}
                    </h2>
                    @if($titles['faqs']->subtitle_english || $titles['faqs']->subtitle_arabic)
                    <p class="section-subtitle">
                        {{ app()->getLocale() == 'ar' ? $titles['faqs']->subtitle_arabic : $titles['faqs']->subtitle_english }}
                    </p>
                    @endif
                    @else
                    <h2 class="section-title">{{ __('lang.frequently_asked') }}</h2>
                    <p class="section-subtitle">{{ __('lang.faq_subtitle') }}</p>
                    @endif
                    
                    <div class="faq-cta mt-5">
                        <p class="faq-cta-text">{{ __('lang.have_more_questions') }}</p>
                        <a href="{{ route('contact') }}" class="faq-cta-btn">
                            <i class="fal fa-envelope"></i>
                            {{ __('lang.contact_us') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="faq-accordion" id="serviceFaqAccordion">
                    @foreach($service->faqs as $index => $faq)
                    <div class="faq-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="faq-question" data-toggle="collapse" data-target="#faq-{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                            <span class="faq-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <h5 class="faq-question-text">
                                {{ app()->getLocale() == 'ar' ? $faq->question_arabic : $faq->question_english }}
                            </h5>
                            <span class="faq-toggle-icon">
                                <i class="fal fa-plus"></i>
                                <i class="fal fa-minus"></i>
                            </span>
                        </div>
                        <div id="faq-{{ $faq->id }}" class="collapse {{ $index === 0 ? 'show' : '' }}" data-parent="#serviceFaqAccordion">
                            <div class="faq-answer">
                                <p>{{ app()->getLocale() == 'ar' ? $faq->answer_arabic : $faq->answer_english }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

