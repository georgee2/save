{{-- Contact Card - Shown when contact forms are disabled --}}
@php
    $aboutInfo = \App\Models\AboutInformation::getAboutInfo();
@endphp

<div class="offer-contact-card">
    {{-- Header --}}
    <div class="offer-contact-header">
        <div class="offer-contact-icon">
            <i class="fas fa-headset"></i>
        </div>
        <h4 class="offer-contact-title">{{ __('lang.get_in_touch') }}</h4>
        <p class="offer-contact-subtitle">{{ __('lang.we_are_here_to_help') }}</p>
    </div>
    
    {{-- Contact Methods --}}
    <div class="offer-contact-body">
        @if($footerContactInfo)
            {{-- Phone --}}
            @if($footerContactInfo->mobile)
            <a href="tel:{{ $footerContactInfo->mobile }}" class="offer-contact-method offer-phone-method">
                <div class="offer-method-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="offer-method-info">
                    <span class="offer-method-label">{{ __('lang.call_us') }}</span>
                    <span class="offer-method-value">{{ $footerContactInfo->mobile }}</span>
                </div>
                <div class="offer-method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
            
            {{-- WhatsApp --}}
            @if($footerContactInfo->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}" target="_blank" rel="noopener" class="offer-contact-method offer-whatsapp-method">
                <div class="offer-method-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="offer-method-info">
                    <span class="offer-method-label">{{ __('lang.whatsapp') }}</span>
                    <span class="offer-method-value">{{ __('lang.chat_with_us') }}</span>
                </div>
                <div class="offer-method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
            
            {{-- Email --}}
            @if($footerContactInfo->email)
            <a href="mailto:{{ trim($footerContactInfo->email) }}" target="_blank" class="offer-contact-method offer-email-method">
                <div class="offer-method-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="offer-method-info">
                    <span class="offer-method-label">{{ __('lang.email_us') }}</span>
                    <span class="offer-method-value">{{ trim($footerContactInfo->email) }}</span>
                </div>
                <div class="offer-method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
        @endif
        
        {{-- Contact Page Button --}}
        <a href="{{ route('contact') }}" class="offer-btn-contact">
            <i class="fas fa-paper-plane"></i>
            <span>{{ __('lang.contact_us') }}</span>
        </a>
        
        {{-- Company Profile Download --}}
        @if($aboutInfo && $aboutInfo->company_profile)
        <a href="{{ asset('storage' . $aboutInfo->company_profile) }}" target="_blank" download class="offer-btn-profile">
            <i class="fas fa-file-pdf"></i>
            <span>{{ __('lang.download_company_profile') }}</span>
            <i class="fas fa-download offer-download-icon"></i>
        </a>
        @endif
    </div>
    
    {{-- Social Icons --}}
    @if($footerContactInfo)
    <div class="offer-contact-footer">
        <span class="offer-social-label">{{ __('lang.follow_us') }}</span>
        <div class="offer-social-icons">
            @if($footerContactInfo->facebook)
            <a href="{{ $footerContactInfo->facebook }}" target="_blank" rel="noopener" class="offer-social-icon offer-social-facebook" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            @endif
            @if($footerContactInfo->instagram)
            <a href="{{ $footerContactInfo->instagram }}" target="_blank" rel="noopener" class="offer-social-icon offer-social-instagram" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            @endif
            @if($footerContactInfo->twitter)
            <a href="{{ $footerContactInfo->twitter }}" target="_blank" rel="noopener" class="offer-social-icon offer-social-twitter" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            @endif
            @if($footerContactInfo->linkedin)
            <a href="{{ $footerContactInfo->linkedin }}" target="_blank" rel="noopener" class="offer-social-icon offer-social-linkedin" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            @endif
            @if($footerContactInfo->pinterest)
            <a href="{{ $footerContactInfo->pinterest }}" target="_blank" rel="noopener" class="offer-social-icon offer-social-pinterest" aria-label="Pinterest">
                <i class="fab fa-pinterest-p"></i>
            </a>
            @endif
            @if($footerContactInfo->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}" target="_blank" rel="noopener" class="offer-social-icon offer-social-whatsapp" aria-label="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            @endif
        </div>
    </div>
    @endif
</div>
