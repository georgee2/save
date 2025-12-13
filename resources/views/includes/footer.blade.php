@php
  $contactInfo = App\Models\ContactInformation::getContactInfo();
  $mainServices = App\Models\Service::where('publish_status', 0)
                    ->where('is_sub_service', 0)
                    ->whereNull('service_id')
                    ->whereNull('deleted_at')
                    ->orderBy('created_at', 'DESC')
                    ->limit(6)
                    ->get();
@endphp

<!-- start: Footer Section -->
      <footer class="tj-footer-section footer-3 section-gap-x" style="margin-top: 30px;">
        <div class="footer-main-area">
          <div class="container">
            <div class="row justify-content-between">
              <div class="col-xl-3 col-md-6">
                <div class="footer-widget footer-col-1 wow fadeInUp" data-wow-delay=".1s">
                  <div class="footer-logo">
                    <a href="{{ route('index') }}">
                      <img src="{{url('/pic/white.png')}}" alt="Logo">
                    </a>
                  </div>
                  <div class="footer-text">
                    <p>{{ App::getLocale() == 'en' ? ($contactInfo->footer_bio_english ?? '') : ($contactInfo->footer_bio_arabic ?? '') }}</p>
                  </div>
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
              <div class="col-xl-3 col-md-6">
                <div class="footer-widget footer-col-2 widget-nav-menu wow fadeInUp" data-wow-delay=".3s">
                  <h5 class="title">{{ __('lang.services') }}</h5>
                  <ul>
                    @if($mainServices && $mainServices->count() > 0)
                      @foreach($mainServices as $service)
                        <li><a href="{{ route('services.show', ['slug' => $service->slug]) }}">{{ App::getLocale() == 'en' ? $service->title_english : $service->title_arabic }}</a></li>
                      @endforeach
                    @endif
                  </ul>
                </div>
              </div>
              <div class="col-xl-3 col-md-6">
                <div class="footer-widget footer-col-3 widget-nav-menu wow fadeInUp" data-wow-delay=".5s">
                  <h5 class="title">{{ __('lang.resources') }}</h5>
                  <ul>
                    <li><a href="{{ route('about') }}">{{ __('lang.about_us') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('lang.contact_us') }}</a></li>
                    <li><a href="{{ route('careers.index') }}">{{ __('lang.careers') }}</a></li>
                    <li><a href="{{ route('blogs.index') }}">{{ __('lang.blog') }}</a></li>
                    <li><a href="{{ route('team.index') }}">{{ __('lang.our_team') }}</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-xl-3 col-md-6">
                <div class="footer-widget widget-contact wow fadeInUp" data-wow-delay=".7s">
                  <h5 class="title">{{ __('lang.contact_info') }}</h5>
                  <div class="footer-contact-info">
                    @if($contactInfo && (($contactInfo->location_text_english && App::getLocale() == 'en') || ($contactInfo->location_text_arabic && App::getLocale() == 'ar')))
                    <div class="contact-item">
                      <span>{{ App::getLocale() == 'en' ? $contactInfo->location_text_english : $contactInfo->location_text_arabic }}</span>
                    </div>
                    @endif
                    @if($contactInfo && $contactInfo->mobile)
                    <div class="contact-item">
                      <a href="tel:{{ str_replace([' ', '-', '(', ')'], '', $contactInfo->mobile) }}">{{ $contactInfo->mobile }}</a>
                    </div>
                    @endif
                    @if($contactInfo && $contactInfo->email)
                    <div class="contact-item">
                      <a href="mailto:{{ $contactInfo->email }}">{{ $contactInfo->email }}</a>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tj-copyright-area-3">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="copyright-content-area">
                  <div class="copyright-text">
                    <p>&copy; {{ date('Y') }} <a href="{{ route('index') }}">Smart Vision Group</a> {{ __('lang.all_rights_reserved') }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-shape-1">
          <img src="assets/images/shape/pattern-2.svg" alt="">
        </div>
        <div class="bg-shape-2">
          <img src="assets/images/shape/pattern-3.svg" alt="">
        </div>
      </footer>
      <!-- end: Footer Section -->