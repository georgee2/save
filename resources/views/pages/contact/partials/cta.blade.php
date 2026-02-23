{{-- CTA Section --}}
<section class="contact-cta-section py-10">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-center text-lg-left mb-4 mb-lg-0">
                <h2 class="cta-title">{{ __('lang.need_quick_response') }}</h2>
                <p class="cta-bio">{{ __('lang.quick_response_bio') }}</p>
            </div>
            <div class="col-lg-4 text-center text-lg-right">
                @if($contactInfo->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo->whatsapp) }}" target="_blank" class="btn cta-button whatsapp-btn">
                    <i class="fab fa-whatsapp mr-2"></i> {{ __('lang.chat_on_whatsapp') }}
                </a>
                @elseif($contactInfo->mobile)
                <a href="tel:{{ $contactInfo->mobile }}" class="btn cta-button">
                    <i class="fas fa-phone-alt mr-2"></i> {{ __('lang.call_now') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
