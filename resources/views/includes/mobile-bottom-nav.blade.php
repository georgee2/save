{{-- Mobile Bottom Navigation - Only visible on mobile/tablet --}}
<nav class="mobile-bottom-nav" id="mobileBottomNav" style="position:fixed!important;bottom:0!important;left:0!important;right:0!important;z-index:99999!important;background:#fff!important;">
    <div class="mobile-bottom-nav-container">
        {{-- Home --}}
        <a href="{{ route('index') }}" class="mobile-bottom-nav-item {{ Route::currentRouteName() == 'index' ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fal fa-home"></i>
                <i class="fas fa-home active-icon"></i>
            </div>
            <span class="nav-label">{{ __('lang.home') }}</span>
        </a>
        
        {{-- Offers --}}
        <a href="{{ route('offers.index') }}" class="mobile-bottom-nav-item {{ str_contains(Route::currentRouteName() ?? '', 'offers') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fal fa-tags"></i>
                <i class="fas fa-tags active-icon"></i>
            </div>
            <span class="nav-label">{{ __('lang.offers') }}</span>
        </a>
        
        {{-- Contact Us (Popup Trigger) --}}
        <button type="button" class="mobile-bottom-nav-item contact-popup-trigger" id="contactPopupTrigger">
            <div class="nav-icon nav-icon-center">
                <i class="fal fa-envelope"></i>
            </div>
            <span class="nav-label">{{ __('lang.contact') }}</span>
        </button>
        
        {{-- Favourites --}}
        <a href="{{ route('favourites.index') }}" class="mobile-bottom-nav-item {{ Route::currentRouteName() == 'favourites.index' ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fal fa-heart"></i>
                <i class="fas fa-heart active-icon"></i>
            </div>
            <span class="nav-label">{{ __('lang.favourites') }}</span>
            <span class="favourite-badge" style="display: none;">0</span>
        </a>
        
        {{-- Login / Account --}}
        @auth
            @if(auth()->user()->isCustomer())
            <a href="{{ route('account.dashboard') }}" class="mobile-bottom-nav-item login-item {{ str_contains(Route::currentRouteName() ?? '', 'account') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="fal fa-user"></i>
                    <i class="fas fa-user active-icon"></i>
                </div>
                <span class="nav-label">{{ __('lang.account') }}</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="mobile-bottom-nav-item login-item">
                <div class="nav-icon">
                    <i class="fal fa-user"></i>
                    <i class="fas fa-user active-icon"></i>
                </div>
                <span class="nav-label">{{ __('lang.login') }}</span>
            </a>
            @endif
        @else
        <a href="{{ route('login') }}" class="mobile-bottom-nav-item login-item {{ Route::currentRouteName() == 'login' ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fal fa-user"></i>
                <i class="fas fa-user active-icon"></i>
            </div>
            <span class="nav-label">{{ __('lang.login') }}</span>
        </a>
        @endauth
    </div>
</nav>

{{-- Contact Popup Modal --}}
<div class="contact-popup-overlay" id="contactPopupOverlay" style="z-index:999999!important;"></div>
<div class="contact-popup-modal" id="contactPopupModal" style="z-index:9999999!important;">
    <div class="contact-popup-header">
        <h4><i class="fal fa-envelope"></i> {{ __('lang.contact_us') }}</h4>
        <button type="button" class="contact-popup-close" id="contactPopupClose">
            <i class="fal fa-times"></i>
        </button>
    </div>
    <div class="contact-popup-body">
        {{-- Contact Page Link --}}
        <a href="{{ route('contact') }}" class="contact-popup-link">
            <div class="contact-popup-link-icon">
                <i class="fal fa-paper-plane"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title">{{ __('lang.contact_us') }}</span>
                <span class="contact-popup-link-desc">{{ __('lang.send_message') ?? 'Send us a message' }}</span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        
        {{-- Phone --}}
        @php
            $bottomNavContact = $footerContactInfo ?? \App\Models\ContactInformation::getContactInfo();
        @endphp
        @if($bottomNavContact && $bottomNavContact->mobile)
        <a href="tel:{{ $bottomNavContact->mobile }}" class="contact-popup-link">
            <div class="contact-popup-link-icon">
                <i class="fal fa-phone"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title">{{ __('lang.call_us') ?? 'Call Us' }}</span>
                <span class="contact-popup-link-desc">{{ $bottomNavContact->mobile }}</span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        @endif
        
        {{-- WhatsApp --}}
        @if($bottomNavContact && $bottomNavContact->whatsapp)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bottomNavContact->whatsapp) }}" target="_blank" class="contact-popup-link whatsapp-link">
            <div class="contact-popup-link-icon">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title">WhatsApp</span>
                <span class="contact-popup-link-desc">{{ __('lang.chat_with_us') ?? 'Chat with us' }}</span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        @endif
        
        {{-- Email --}}
        @if($bottomNavContact && $bottomNavContact->email)
        <a href="mailto:{{ $bottomNavContact->email }}" class="contact-popup-link">
            <div class="contact-popup-link-icon">
                <i class="fal fa-envelope"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title">{{ __('lang.email') }}</span>
                <span class="contact-popup-link-desc">{{ $bottomNavContact->email }}</span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        @endif
        
        {{-- Social Icons --}}
        <div class="contact-popup-social">
            <span class="contact-popup-social-title">{{ __('lang.follow_us') ?? 'Follow Us' }}</span>
            <div class="contact-popup-social-icons">
                @if($bottomNavContact)
                    @if($bottomNavContact->facebook)
                    <a href="{{ $bottomNavContact->facebook }}" target="_blank" class="social-icon facebook" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if($bottomNavContact->instagram)
                    <a href="{{ $bottomNavContact->instagram }}" target="_blank" class="social-icon instagram" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if($bottomNavContact->twitter)
                    <a href="{{ $bottomNavContact->twitter }}" target="_blank" class="social-icon twitter" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if($bottomNavContact->linkedin)
                    <a href="{{ $bottomNavContact->linkedin }}" target="_blank" class="social-icon linkedin" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if($bottomNavContact->youtube)
                    <a href="{{ $bottomNavContact->youtube }}" target="_blank" class="social-icon youtube" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                    @if($bottomNavContact->pinterest)
                    <a href="{{ $bottomNavContact->pinterest }}" target="_blank" class="social-icon pinterest" title="Pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    @endif
                    @if($bottomNavContact->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bottomNavContact->whatsapp) }}" target="_blank" class="social-icon whatsapp" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Mobile Bottom Nav JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactTrigger = document.getElementById('contactPopupTrigger');
    const contactOverlay = document.getElementById('contactPopupOverlay');
    const contactModal = document.getElementById('contactPopupModal');
    const contactClose = document.getElementById('contactPopupClose');
    
    function openContactPopup() {
        contactOverlay.classList.add('active');
        contactModal.classList.add('active');
        document.body.classList.add('contact-popup-open');
    }
    
    function closeContactPopup() {
        contactOverlay.classList.remove('active');
        contactModal.classList.remove('active');
        document.body.classList.remove('contact-popup-open');
    }
    
    if (contactTrigger) {
        contactTrigger.addEventListener('click', openContactPopup);
    }
    
    if (contactOverlay) {
        contactOverlay.addEventListener('click', closeContactPopup);
    }
    
    if (contactClose) {
        contactClose.addEventListener('click', closeContactPopup);
    }
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && contactModal.classList.contains('active')) {
            closeContactPopup();
        }
    });
});
</script>
