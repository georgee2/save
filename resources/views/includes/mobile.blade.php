@php
  $contactInfo = App\Models\ContactInformation::getContactInfo();
@endphp

<!-- start: Hamburger Menu -->
  <div class="hamburger-area d-lg-none">
    <div class="hamburger_bg"></div>
    <div class="hamburger_wrapper">
      <div class="hamburger_inner">
        <div class="hamburger_top d-flex align-items-center justify-content-between">
          <div class="hamburger_logo">
            <a href="{{ route('index') }}" class="mobile_logo">
              <img src="{{url('/pic/white.png')}}" alt="Logo">
            </a>
          </div>
          <div class="hamburger_close">
            <button class="hamburger_close_btn"><i class="fa-thin fa-times"></i></button>
          </div>
        </div>
        <div class="hamburger_menu">
          <div class="mobile_menu"></div>
        </div>
        <div class="hamburger-infos">
          <h5 class="hamburger-title">{{ __('lang.contact_info') }}</h5>
          <div class="contact-info">
            @if($contactInfo && $contactInfo->mobile)
            <div class="contact-item">
              <span class="subtitle">{{ __('lang.phone') }}</span>
              <a class="contact-link" href="tel:{{ str_replace([' ', '-', '(', ')'], '', $contactInfo->mobile) }}">{{ $contactInfo->mobile }}</a>
            </div>
            @endif
            @if($contactInfo && $contactInfo->email)
            <div class="contact-item">
              <span class="subtitle">{{ __('lang.email') }}</span>
              <a class="contact-link" href="mailto:{{ $contactInfo->email }}">{{ $contactInfo->email }}</a>
            </div>
            @endif
            @if($contactInfo && (($contactInfo->location_text_english && App::getLocale() == 'en') || ($contactInfo->location_text_arabic && App::getLocale() == 'ar')))
            <div class="contact-item">
              <span class="subtitle">{{ __('lang.location') }}</span>
              <span class="contact-link">{{ App::getLocale() == 'en' ? $contactInfo->location_text_english : $contactInfo->location_text_arabic }}</span>
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="hamburger-socials">
        <h5 class="hamburger-title">{{ __('lang.follow_us') }}</h5>
        <div class="social-links style-3">
          <ul>
            @if($contactInfo && $contactInfo->facebook)
              <li><a href="{{ $contactInfo->facebook }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
            @endif
            @if($contactInfo && $contactInfo->instagram)
              <li><a href="{{ $contactInfo->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
            @endif
            @if($contactInfo && $contactInfo->twitter)
              <li><a href="{{ $contactInfo->twitter }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
            @endif
            @if($contactInfo && $contactInfo->linkedin)
              <li><a href="{{ $contactInfo->linkedin }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- end: Hamburger Menu -->
