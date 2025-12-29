{{-- Back to Top Button --}}
<a href="#" class="back-to-top" id="backToTop" aria-label="Back to Top">
    <i class="fas fa-chevron-up"></i>
</a>

{{-- Footer --}}
<footer class="site-footer">
    {{-- Main Footer --}}
    <div class="footer-main">
        <div class="container">
            <div class="row">
                {{-- Logo & About Column --}}
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget footer-about">
                        <a href="{{ url('/') }}" class="footer-logo">
                            <img src="{{ url('/pic/svgwhite.svg') }}" alt="{{ env('APP_NAME') }}">
                        </a>
                        @if($footerContactInfo && ($footerContactInfo->footer_bio_english || $footerContactInfo->footer_bio_arabic))
                        <p class="footer-bio">
                            {{ app()->getLocale() == 'ar' ? $footerContactInfo->footer_bio_arabic : $footerContactInfo->footer_bio_english }}
                        </p>
                        @else
                        <p class="footer-bio">
                            {{ __('lang.footer_default_bio') }}
                        </p>
                        @endif
                        
                        {{-- Social Icons --}}
                        <div class="footer-social">
                            @if($footerContactInfo)
                                @if($footerContactInfo->facebook)
                                <a href="{{ $footerContactInfo->facebook }}" target="_blank" rel="noopener" class="social-icon" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                @endif
                                @if($footerContactInfo->instagram)
                                <a href="{{ $footerContactInfo->instagram }}" target="_blank" rel="noopener" class="social-icon" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif
                                @if($footerContactInfo->twitter)
                                <a href="{{ $footerContactInfo->twitter }}" target="_blank" rel="noopener" class="social-icon" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif
                                @if($footerContactInfo->linkedin)
                                <a href="{{ $footerContactInfo->linkedin }}" target="_blank" rel="noopener" class="social-icon" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                @endif
                                @if($footerContactInfo->pinterest)
                                <a href="{{ $footerContactInfo->pinterest }}" target="_blank" rel="noopener" class="social-icon" aria-label="Pinterest">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                @endif
                                @if($footerContactInfo->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}" target="_blank" rel="noopener" class="social-icon" aria-label="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Categories Column --}}
                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-widget-title">{{ __('lang.categories') }}</h4>
                        <ul class="footer-links">
                            @if(isset($headerProjectCategories))
                                @foreach($headerProjectCategories->take(6) as $category)
                                <li>
                                    <a href="{{ route('category.show', $category->slug) }}">
                                        <i class="fas fa-chevron-right"></i>
                                        {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Resources Column --}}
                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-widget-title">{{ __('lang.resources') }}</h4>
                        <ul class="footer-links">
                            <li>
                                <a href="{{ route('blogs.index') }}">
                                    <i class="fas fa-chevron-right"></i>
                                    {{ __('lang.news_and_articles') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/sitemap.xml') }}" target="_blank">
                                    <i class="fas fa-chevron-right"></i>
                                    {{ __('lang.sitemap') }}
                                </a>
                            </li>
                            {{-- Add more resource links here --}}
                        </ul>
                    </div>
                </div>

                {{-- Contact Info Column --}}
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget footer-contact">
                        <h4 class="footer-widget-title">{{ __('lang.contact_info') }}</h4>
                        <ul class="footer-contact-list">
                            @if($footerContactInfo)
                                @if($footerContactInfo->location_text_english || $footerContactInfo->location_text_arabic)
                                <li>
                                    <div class="contact-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-text">
                                        <span class="contact-label">{{ __('lang.address') }}</span>
                                        <p>{{ app()->getLocale() == 'ar' ? $footerContactInfo->location_text_arabic : $footerContactInfo->location_text_english }}</p>
                                    </div>
                                </li>
                                @endif
                                @if($footerContactInfo->mobile)
                                <li>
                                    <div class="contact-icon">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div class="contact-text">
                                        <span class="contact-label">{{ __('lang.phone') }}</span>
                                        <p>
                                            <a href="tel:{{ $footerContactInfo->mobile }}">{{ $footerContactInfo->mobile }}</a>
                                            @if($footerContactInfo->secondary_mobile)
                                            <br>
                                            <a href="tel:{{ $footerContactInfo->secondary_mobile }}">{{ $footerContactInfo->secondary_mobile }}</a>
                                            @endif
                                        </p>
                                    </div>
                                </li>
                                @endif
                                @if($footerContactInfo->email)
                                <li>
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-text">
                                        <span class="contact-label">{{ __('lang.email') }}</span>
                                        <p><a href="mailto:{{ $footerContactInfo->email }}">{{ $footerContactInfo->email }}</a></p>
                                    </div>
                                </li>
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-left">
                    <p class="copyright">
                        &copy; {{ date('Y') }} {{ env('APP_NAME') }}. {{ __('lang.all_rights_reserved') }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <ul class="footer-bottom-links">
                        <li><a href="{{ url('/sitemap.xml') }}" target="_blank">{{ __('lang.sitemap') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

