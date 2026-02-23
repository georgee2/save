{{-- Contact Info Cards Section --}}
<section class="contact-info-section py-10">
    <div class="container">
        <div class="row justify-content-center">
            {{-- Phone Card --}}
            <div class="col-lg-4 col-md-6 mb-4" data-animate="fadeInUp">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4 class="contact-card-title">{{ __('lang.call_us') }}</h4>
                    <div class="contact-card-content">
                        @if($contactInfo->mobile)
                        <a href="tel:{{ $contactInfo->mobile }}" class="contact-link">{{ $contactInfo->mobile }}</a>
                        @endif
                        @if($contactInfo->secondary_mobile)
                        <a href="tel:{{ $contactInfo->secondary_mobile }}" class="contact-link">{{ $contactInfo->secondary_mobile }}</a>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Email Card --}}
            <div class="col-lg-4 col-md-6 mb-4" data-animate="fadeInUp" data-delay="100">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4 class="contact-card-title">{{ __('lang.email_us') }}</h4>
                    <div class="contact-card-content">
                        @if($contactInfo->email)
                        <a href="mailto:{{ $contactInfo->email }}" class="contact-link">{{ $contactInfo->email }}</a>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Location Card --}}
            <div class="col-lg-4 col-md-6 mb-4" data-animate="fadeInUp" data-delay="200">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4 class="contact-card-title">{{ __('lang.visit_us') }}</h4>
                    <div class="contact-card-content">
                        <p class="contact-address">
                            {{ app()->getLocale() == 'ar' ? $contactInfo->location_text_arabic : $contactInfo->location_text_english }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
