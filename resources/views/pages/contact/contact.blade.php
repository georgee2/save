@extends('layouts.master')

@section('title', __('lang.contact_us_title'))

@section('seo_desc', $contactInfo->seo_description_english ?? __('lang.contact_us_seo_desc'))

@section('seo_tags', $contactInfo->tags ?? __('lang.contact_us'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/contact-page.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/branches-page.css') }}?v={{ time() }}">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')

{{-- Hero Section --}}
<section class="contact-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="contact-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="contact-hero-bg contact-hero-gradient"></div>
    @endif
    <div class="contact-hero-overlay"></div>
    <div class="container position-relative">
        <div class="contact-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.contact_us') }}</li>
                </ol>
            </nav>
            <h1 class="contact-hero-title">{{ __('lang.contact_us_title') }}</h1>
            <p class="contact-hero-subtitle">{{ __('lang.contact_us_subtitle') }}</p>
        </div>
    </div>
</section>

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

{{-- Company Profile Download Section --}}
@if($aboutInfo && $aboutInfo->company_profile)
<section class="company-profile-section py-10">
    <div class="container">
        <div class="company-profile-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="profile-content">
                        <div class="profile-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="profile-text">
                            <h3 class="profile-title">{{ __('lang.company_profile') }}</h3>
                            <p class="profile-description">{{ __('lang.company_profile_description') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-lg-right">
                    <a href="{{ asset('storage' . $aboutInfo->company_profile) }}" 
                       class="btn btn-download-profile" 
                       target="_blank" 
                       download>
                        <i class="fas fa-download"></i>
                        <span>{{ __('lang.download_company_profile') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Contact Form & Map Section --}}
<section class="contact-form-section py-10 bg-light">
    <div class="container">
        <div class="row">
            {{-- Contact Form --}}
            <div class="col-lg-6 mb-6 mb-lg-0" data-animate="fadeInLeft">
                <div class="contact-form-wrapper">
                    <div class="section-label">
                        <span class="label-line"></span>
                        <span class="label-text">{{ __('lang.get_in_touch') }}</span>
                    </div>
                    <h2 class="section-title mb-4">{{ __('lang.send_us_message') }}</h2>
                    
                    {{-- Success Message --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    
                    {{-- Error Messages --}}
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form" id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('lang.full_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('lang.enter_your_name') }}" required>
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ __('lang.email_address') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.enter_your_email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ __('lang.phone_number') }}</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ __('lang.enter_your_phone') }}">
                                    @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_id">{{ __('lang.select_service') }}</label>
                                    <select class="form-control @error('service_id') is-invalid @enderror" id="service_id" name="service_id">
                                        <option value="">{{ __('lang.choose_service') }}</option>
                                        @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">{{ __('lang.subject') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" placeholder="{{ __('lang.enter_subject') }}" required>
                            @error('subject')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="message">{{ __('lang.your_message') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="{{ __('lang.enter_your_message') }}" required>{{ old('message') }}</textarea>
                            @error('message')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane mr-2"></i> {{ __('lang.send_message') }}
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Map --}}
            <div class="col-lg-6" data-animate="fadeInRight">
                <div class="contact-map-wrapper">
                    <div class="section-label">
                        <span class="label-line"></span>
                        <span class="label-text">{{ __('lang.our_location') }}</span>
                    </div>
                    <h2 class="section-title mb-4">{{ __('lang.find_us') }}</h2>
                    
                    <div class="map-container">
                        @if($contactInfo->location_map)
                            @php
                                $mapValue = $contactInfo->location_map;
                                // Check if it's already an iframe
                                if (strpos($mapValue, '<iframe') !== false) {
                                    $mapEmbed = $mapValue;
                                } else {
                                    // It's a URL, wrap it in an iframe
                                    $mapEmbed = '<iframe src="' . e($mapValue) . '" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                                }
                            @endphp
                            {!! $mapEmbed !!}
                        @else
                        <div class="map-placeholder">
                            <i class="fas fa-map-marked-alt"></i>
                            <p>{{ __('lang.map_not_available') }}</p>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Social Media Links --}}
                    <div class="social-links-wrapper mt-5">
                        <h5 class="social-title">{{ __('lang.follow_us') }}</h5>
                        <div class="social-links">
                            @if($contactInfo->facebook)
                            <a href="{{ $contactInfo->facebook }}" target="_blank" class="social-link facebook" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if($contactInfo->instagram)
                            <a href="{{ $contactInfo->instagram }}" target="_blank" class="social-link instagram" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($contactInfo->twitter)
                            <a href="{{ $contactInfo->twitter }}" target="_blank" class="social-link twitter" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            @endif
                            @if($contactInfo->linkedin)
                            <a href="{{ $contactInfo->linkedin }}" target="_blank" class="social-link linkedin" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                            @if($contactInfo->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo->whatsapp) }}" target="_blank" class="social-link whatsapp" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            @endif
                            @if($contactInfo->pinterest)
                            <a href="{{ $contactInfo->pinterest }}" target="_blank" class="social-link pinterest" title="Pinterest">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Branches Section --}}
@if($branches && $branches->count() > 0)
<section class="contact-branches-section py-12">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="branches-section-badge">
                <i class="fas fa-building"></i>
                <span>{{ __('lang.locations') }}</span>
            </div>
            <h2 class="branches-section-title">{{ __('lang.our_branches') }}</h2>
            <p class="branches-section-subtitle">{{ __('lang.branches_section_subtitle') }}</p>
        </div>
        
        {{-- Branches Grid --}}
        <div class="branches-grid">
            @foreach($branches as $index => $branch)
            <div class="branch-card" data-animate="fadeInUp" data-delay="{{ $index * 100 }}">
                {{-- Branch Header --}}
                <div class="branch-header">
                    <div class="branch-logo-wrapper">
                        @if($branch->logo_english && app()->getLocale() == 'en')
                        <img src="{{ asset('storage' . $branch->logo_english) }}" 
                             alt="{{ $branch->name_english }}" 
                             class="branch-logo">
                        @elseif($branch->logo_arabic && app()->getLocale() == 'ar')
                        <img src="{{ asset('storage' . $branch->logo_arabic) }}" 
                             alt="{{ $branch->name_arabic }}" 
                             class="branch-logo">
                        @elseif($branch->logo_english)
                        <img src="{{ asset('storage' . $branch->logo_english) }}" 
                             alt="{{ $branch->name_english }}" 
                             class="branch-logo">
                        @else
                        <div class="branch-logo-placeholder">
                            <i class="fas fa-building"></i>
                        </div>
                        @endif
                    </div>
                    <div class="branch-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                </div>
                
                {{-- Branch Content --}}
                <div class="branch-content">
                    <h3 class="branch-name">
                        {{ app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english }}
                    </h3>
                    
                    {{-- Location --}}
                    @if(($branch->location_text_english && app()->getLocale() == 'en') || ($branch->location_text_arabic && app()->getLocale() == 'ar'))
                    <div class="branch-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ app()->getLocale() == 'ar' ? $branch->location_text_arabic : $branch->location_text_english }}</span>
                    </div>
                    @endif
                    
                    {{-- Opening Hours --}}
                    @if($branch->opening_hours)
                    <div class="branch-hours">
                        <i class="fas fa-clock"></i>
                        <span>{{ $branch->opening_hours }}</span>
                    </div>
                    @endif
                    
                    {{-- Get Directions Button --}}
                    @if($branch->map_url)
                    <div class="branch-actions">
                        <a href="{{ $branch->map_url }}" target="_blank" class="btn-branch btn-directions">
                            <i class="fas fa-directions"></i>
                            <span>{{ __('lang.get_directions') }}</span>
                        </a>
                    </div>
                    @endif
                </div>
                
                {{-- Map Preview (if available) --}}
                @if($branch->map_url)
                <div class="branch-map-preview">
                    @if(strpos($branch->map_url, '<iframe') !== false)
                        {!! $branch->map_url !!}
                    @else
                        <iframe src="{{ $branch->map_url }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        
        {{-- View All Branches Link --}}
        <div class="text-center mt-8">
            <a href="{{ route('branches.index') }}" class="btn btn-view-branches">
                <i class="fas fa-building {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ __('lang.view_all_branches') }}
            </a>
        </div>
    </div>
</section>
@endif

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

@endsection

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show success message with SweetAlert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ __("lang.message_sent_title") }}',
            text: '{{ session("success") }}',
            confirmButtonColor: '#19868b',
            confirmButtonText: '{{ __("lang.ok") }}',
            timer: 5000,
            timerProgressBar: true
        });
    @endif
    
    // Show error message with SweetAlert
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: '{{ __("lang.form_error_title") }}',
            html: '<ul style="text-align: left; list-style: disc; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#e1273d',
            confirmButtonText: '{{ __("lang.ok") }}'
        });
    @endif
    
    // Form submission with loading state
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> {{ __("lang.sending") }}...';
            submitBtn.disabled = true;
            
            // Show loading SweetAlert
            Swal.fire({
                title: '{{ __("lang.sending_message") }}',
                html: '{{ __("lang.please_wait") }}',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }
    
    // Animate elements on scroll for branches section
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('animated');
                }, delay);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endsection

