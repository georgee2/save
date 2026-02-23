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
