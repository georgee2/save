{{-- Contact Card - Shown when contact forms are disabled --}}
@php
    $aboutInfo = \App\Models\AboutInformation::getAboutInfo();
@endphp

<div class="contact-info-card">
    {{-- Header --}}
    <div class="contact-card-header">
        <div class="header-icon">
            <i class="fas fa-headset"></i>
        </div>
        <h4 class="header-title">{{ __('lang.get_in_touch') }}</h4>
        <p class="header-subtitle">{{ __('lang.we_are_here_to_help') }}</p>
    </div>
    
    {{-- Contact Methods --}}
    <div class="contact-card-body">
        @if($footerContactInfo)
            {{-- Phone --}}
            @if($footerContactInfo->mobile)
            <a href="tel:{{ $footerContactInfo->mobile }}" class="contact-method phone-method">
                <div class="method-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="method-info">
                    <span class="method-label">{{ __('lang.call_us') }}</span>
                    <span class="method-value">{{ $footerContactInfo->mobile }}</span>
                </div>
                <div class="method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
            
            {{-- WhatsApp --}}
            @if($footerContactInfo->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}" target="_blank" rel="noopener" class="contact-method whatsapp-method">
                <div class="method-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="method-info">
                    <span class="method-label">{{ __('lang.whatsapp') }}</span>
                    <span class="method-value">{{ __('lang.chat_with_us') }}</span>
                </div>
                <div class="method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
            
            {{-- Email --}}
            @if($footerContactInfo->email)
            <a href="mailto:{{ trim($footerContactInfo->email) }}" target="_blank" class="contact-method email-method">
                <div class="method-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="method-info">
                    <span class="method-label">{{ __('lang.email_us') }}</span>
                    <span class="method-value">{{ trim($footerContactInfo->email) }}</span>
                </div>
                <div class="method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
        @endif
        
        {{-- Contact Page Button --}}
        <a href="{{ route('contact') }}" class="btn-contact-page">
            <i class="fas fa-paper-plane"></i>
            <span>{{ __('lang.contact_us') }}</span>
        </a>
        
        {{-- Company Profile Download --}}
        @if($aboutInfo && $aboutInfo->company_profile)
        <a href="{{ asset('storage' . $aboutInfo->company_profile) }}" target="_blank" download class="btn-company-profile">
            <i class="fas fa-file-pdf"></i>
            <span>{{ __('lang.download_company_profile') }}</span>
            <i class="fas fa-download download-icon"></i>
        </a>
        @endif
    </div>
    
    {{-- Social Icons --}}
    @if($footerContactInfo)
    <div class="contact-card-footer">
        <span class="social-label">{{ __('lang.follow_us') }}</span>
        <div class="social-icons">
            @if($footerContactInfo->facebook)
            <a href="{{ $footerContactInfo->facebook }}" target="_blank" rel="noopener" class="social-icon facebook" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            @endif
            @if($footerContactInfo->instagram)
            <a href="{{ $footerContactInfo->instagram }}" target="_blank" rel="noopener" class="social-icon instagram" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            @endif
            @if($footerContactInfo->twitter)
            <a href="{{ $footerContactInfo->twitter }}" target="_blank" rel="noopener" class="social-icon twitter" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            @endif
            @if($footerContactInfo->linkedin)
            <a href="{{ $footerContactInfo->linkedin }}" target="_blank" rel="noopener" class="social-icon linkedin" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            @endif
            @if($footerContactInfo->pinterest)
            <a href="{{ $footerContactInfo->pinterest }}" target="_blank" rel="noopener" class="social-icon pinterest" aria-label="Pinterest">
                <i class="fab fa-pinterest-p"></i>
            </a>
            @endif
            @if($footerContactInfo->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}" target="_blank" rel="noopener" class="social-icon whatsapp" aria-label="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            @endif
        </div>
    </div>
    @endif
</div>
