@extends('layouts.master')
@section('title', __('lang.contact_us'))

@section('content')

<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ __('lang.contact_us') }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.contact_us') }}</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-header-overlay" data-bg-image="assets/images/shape/pheader-overlay.webp"></div>
        </section>
        <!-- end: Breadcrumb Section -->

        <!-- start: Contact Top Section -->
        <div class="tj-contact-area section-gap">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading text-center">
                  <span class="sub-title wow fadeInUp" data-wow-delay=".1s"><img src="{{url('/pic/logosvg.svg')}}">  {{ __('lang.contact_info') }}</span>
                  <h2 class="sec-title title-anim">{{ __('lang.reach_out_to_us') }}</h2>
                </div>
              </div>
            </div>
            <div class="row row-gap-4">
              @if($contactInfo->location_text_english || $contactInfo->location_text_arabic)
              <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="contact-item style-2 wow fadeInUp" data-wow-delay=".3s">
                  <div class="contact-icon">
                    <i class="tji-location-3"></i>
                  </div>
                  <h3 class="contact-title">{{ __('lang.our_location') }}</h3>
                  <p>{{ App::getLocale() == 'en' ? $contactInfo->location_text_english : $contactInfo->location_text_arabic }}</p>
                </div>
              </div>
              @endif
              
              @if($contactInfo->email)
              <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="contact-item style-2 wow fadeInUp" data-wow-delay=".5s">
                  <div class="contact-icon">
                    <i class="tji-envelop"></i>
                  </div>
                  <h3 class="contact-title">{{ __('lang.email_us') }}</h3>
                  <ul class="contact-list">
                    <li><a href="mailto:{{ $contactInfo->email }}">{{ $contactInfo->email }}</a></li>
                  </ul>
                </div>
              </div>
              @endif
              
              @if($contactInfo->mobile || $contactInfo->secondary_mobile)
              <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="contact-item style-2 wow fadeInUp" data-wow-delay=".7s">
                  <div class="contact-icon">
                    <i class="tji-phone"></i>
                  </div>
                  <h3 class="contact-title">{{ __('lang.call_us') }}</h3>
                  <ul class="contact-list">
                    @if($contactInfo->mobile)
                    <li><a href="tel:{{ $contactInfo->mobile }}">{{ $contactInfo->mobile }}</a></li>
                    @endif
                    @if($contactInfo->secondary_mobile)
                    <li><a href="tel:{{ $contactInfo->secondary_mobile }}">{{ $contactInfo->secondary_mobile }}</a></li>
                    @endif
                  </ul>
                </div>
              </div>
              @endif
              
              @if($contactInfo->whatsapp)
              <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="contact-item style-2 wow fadeInUp" data-wow-delay=".9s">
                  <div class="contact-icon">
                    <i class="fa-brands fa-whatsapp"></i>
                  </div>
                  <h3 class="contact-title">{{ __('lang.whatsapp') }}</h3>
                  <ul class="contact-list">
                    <li><a href="https://wa.me/{{ $contactInfo->whatsapp }}" target="_blank">{{ $contactInfo->whatsapp }}</a></li>
                  </ul>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
        <!-- end: Contact Top Section -->

        <!-- start: Contact Section -->
        <section class="tj-contact-section-2 section-bottom-gap">
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="contact-form wow fadeInUp" data-wow-delay=".1s">
                  <h3 class="title">{{ __('lang.feel_free_to_get_in_touch') }}</h3>
                  
                  <form id="contact-form" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-input">
                          <input type="text" name="name" value="{{ old('name') }}" class="{{ old('name') ? 'has-value' : '' }}">
                          <label class="cf-label">{{ __('lang.full_name') }} <span>*</span></label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-input">
                          <input type="email" name="email" value="{{ old('email') }}" class="{{ old('email') ? 'has-value' : '' }}">
                          <label class="cf-label">{{ __('lang.email_address') }} <span>*</span></label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-input">
                          <input type="tel" name="phone" value="{{ old('phone') }}" class="{{ old('phone') ? 'has-value' : '' }}">
                          <label class="cf-label">{{ __('lang.phone_number') }}</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-input">
                          <div class="tj-nice-select-box">
                            <div class="tj-select">
                              <select name="service_id">
                                <option value="">{{ __('lang.choose_service') }}</option>
                                @foreach($services as $service)
                                  <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ App::getLocale() == 'en' ? $service->title_english : $service->title_arabic }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-input">
                          <input type="text" name="subject" value="{{ old('subject') }}" class="{{ old('subject') ? 'has-value' : '' }}">
                          <label class="cf-label">{{ __('lang.subject') }} <span>*</span></label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-input message-input">
                          <textarea name="message" id="message" class="{{ old('message') ? 'has-value' : '' }}">{{ old('message') }}</textarea>
                          <label class="cf-label">{{ __('lang.type_message') }} <span>*</span></label>
                        </div>
                      </div>
                      <div class="submit-btn">
                        <button class="tj-primary-btn" type="submit">
                          <span class="btn-text"><span>{{ __('lang.submit') }}</span></span>
                          <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="map-area wow fadeInUp" data-wow-delay=".3s">
                  @if($contactInfo->location_map)
                  <iframe
                      src="{!! $contactInfo->location_map !!}"></iframe>
                    
                  @else
                    <iframe
                      src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d316440.5712687838!2d-74.01091796224334!3d40.67186885683901!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1745918398047!5m2!1sen!2sbd"></iframe>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- end: Contact Section -->

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Handle floating labels for contact form
  document.addEventListener('DOMContentLoaded', function() {
    const formInputs = document.querySelectorAll('#contact-form input:not([type="submit"]), #contact-form textarea');
    
    // Function to check if input has value and update class
    function updateInputState(input) {
      if (input.value && input.value.trim() !== '') {
        input.parentElement.classList.add('input-filled');
      } else {
        input.parentElement.classList.remove('input-filled');
      }
    }
    
    formInputs.forEach(function(input) {
      // Check on page load if input has value
      updateInputState(input);
      
      // Add class when user types
      input.addEventListener('input', function() {
        updateInputState(this);
      });
      
      // Handle focus
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('input-focused');
      });
      
      // Handle blur
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('input-focused');
        updateInputState(this);
      });
    });

    // Show success message as popup
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: '{{ App::getLocale() == "en" ? "Success!" : "نجح!" }}',
        text: '{{ session("success") }}',
        confirmButtonText: '{{ App::getLocale() == "en" ? "OK" : "حسناً" }}',
        confirmButtonColor: '#28a745'
      });
    @endif

    // Show error messages as popup
    @if($errors->any())
      Swal.fire({
        icon: 'error',
        title: '{{ App::getLocale() == "en" ? "Error!" : "خطأ!" }}',
        html: '<ul style="text-align: left; list-style: none; padding: 0;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        confirmButtonText: '{{ App::getLocale() == "en" ? "OK" : "حسناً" }}',
        confirmButtonColor: '#dc3545'
      });
    @endif
  });
</script>

<style>
  /* Fix floating label issue */
  .form-input.input-focused label.cf-label,
  .form-input.input-filled label.cf-label {
    transform: translateY(-20px);
    font-size: 12px;
    opacity: 0.7;
  }
  
  .form-input label.cf-label {
    transition: all 0.3s ease;
  }
</style>
@endsection