@php
  $contactInfo = App\Models\ContactInformation::getContactInfo();
@endphp

<!-- start: Offcanvas Menu -->
  <div class="tj-offcanvas-area d-none d-lg-block">
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
        @if($contactInfo->footer_bio_english || $contactInfo->footer_bio_arabic)
        <div class="offcanvas-text">
          <p>{{ App::getLocale() == 'en' ? $contactInfo->footer_bio_english : $contactInfo->footer_bio_arabic }}</p>
        </div>
        @endif
        <div class="hamburger-search-area">
          <h5 class="hamburger-title">{{ App::getLocale() == 'en' ? 'Search Now!' : 'ابحث الآن!' }}</h5>
          <div class="hamburger_search">
            <form method="get" action="{{ route('index') }}">
              <button type="submit"><i class="tji-search"></i></button>
              <input type="search" autocomplete="off" name="s" value="" placeholder="{{ App::getLocale() == 'en' ? 'Search here...' : 'ابحث هنا...' }}">
            </form>
          </div>
        </div>
        <div class="hamburger-infos">
          <h5 class="hamburger-title">{{ App::getLocale() == 'en' ? 'Contact Info' : 'معلومات الاتصال' }}</h5>
          <div class="contact-info">
            @if($contactInfo->mobile)
            <div class="contact-item">
              <span class="subtitle">{{ App::getLocale() == 'en' ? 'Phone' : 'الهاتف' }}</span>
              <a class="contact-link" href="tel:{{ $contactInfo->mobile }}">{{ $contactInfo->mobile }}</a>
            </div>
            @endif
            @if($contactInfo->email)
            <div class="contact-item">
              <span class="subtitle">{{ App::getLocale() == 'en' ? 'Email' : 'البريد الإلكتروني' }}</span>
              <a class="contact-link" href="mailto:{{ $contactInfo->email }}">{{ $contactInfo->email }}</a>
            </div>
            @endif
            @if($contactInfo->location_text_english || $contactInfo->location_text_arabic)
            <div class="contact-item">
              <span class="subtitle">{{ App::getLocale() == 'en' ? 'Location' : 'الموقع' }}</span>
              <span class="contact-link">{{ App::getLocale() == 'en' ? $contactInfo->location_text_english : $contactInfo->location_text_arabic }}</span>
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="hamburger-socials">
        <h5 class="hamburger-title">{{ App::getLocale() == 'en' ? 'Follow Us' : 'تابعنا' }}</h5>
        <div class="social-links style-3">
          <ul>
            @if($contactInfo->facebook)
            <li><a href="{{ $contactInfo->facebook }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
            @endif
            @if($contactInfo->instagram)
            <li><a href="{{ $contactInfo->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
            @endif
            @if($contactInfo->twitter)
            <li><a href="{{ $contactInfo->twitter }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
            @endif
            @if($contactInfo->linkedin)
            <li><a href="{{ $contactInfo->linkedin }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- end: Offcanvas Menu -->