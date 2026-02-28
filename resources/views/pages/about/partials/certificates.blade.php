{{-- Certificates Section --}}
@if(isset($certificates) && $certificates->count() > 0)
<section class="certificates-section">
    <div class="container">
        {{-- Section Header --}}
        <div class="certificates-header text-center">
            <span class="certificates-label">{{ __('lang.our_achievements') }}</span>
            <h2 class="certificates-title">{{ __('lang.certificates') }}</h2>
            <div class="certificates-title-line"></div>
            <p class="certificates-subtitle">{{ __('lang.certificates_subtitle') }}</p>
        </div>
        
        {{-- Certificates Slider --}}
        <div class="certificates-slider-wrapper">
            <div class="certificates-slider">
                @foreach($certificates as $certificate)
                <div class="certificate-slide">
                    <div class="certificate-card">
                        @if($certificate->image)
                        <a href="{{ url('/storage' . $certificate->image) }}" 
                           data-gtf-mfp="true" 
                           data-gallery-id="certificates-gallery"
                           title="{{ app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english }}">
                            <div class="certificate-image">
                                <img src="{{ url('/storage' . $certificate->image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english }}">
                                <div class="certificate-overlay">
                                    <div class="certificate-zoom">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @else
                        <div class="certificate-image certificate-no-image">
                            <div class="certificate-placeholder">
                                <i class="fas fa-certificate"></i>
                            </div>
                        </div>
                        @endif
                        <div class="certificate-info">
                            <h4 class="certificate-name">
                                {{ app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english }}
                            </h4>
                            @if($certificate->bio_english || $certificate->bio_arabic)
                            <p class="certificate-bio">
                                {{ app()->getLocale() == 'ar' ? $certificate->bio_arabic : $certificate->bio_english }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Slider Navigation is injected by slick via prevArrow/nextArrow --}}
            
            {{-- Slider Dots --}}
            <div class="certificates-dots"></div>
        </div>
    </div>
</section>
@endif
