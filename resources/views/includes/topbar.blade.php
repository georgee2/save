{{-- Top Bar --}}
<div class="site-topbar">
    <div class="container">
        <div class="topbar-content">
            {{-- Social Icons - Left Side --}}
            <div class="topbar-social">
                @if(isset($footerContactInfo))
                    @if($footerContactInfo->facebook)
                    <a href="{{ $footerContactInfo->facebook }}" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if($footerContactInfo->instagram)
                    <a href="{{ $footerContactInfo->instagram }}" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if($footerContactInfo->twitter)
                    <a href="{{ $footerContactInfo->twitter }}" target="_blank" rel="noopener" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if($footerContactInfo->linkedin)
                    <a href="{{ $footerContactInfo->linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if($footerContactInfo->pinterest)
                    <a href="{{ $footerContactInfo->pinterest }}" target="_blank" rel="noopener" aria-label="Pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    @endif
                    @if($footerContactInfo->youtube)
                    <a href="{{ $footerContactInfo->youtube }}" target="_blank" rel="noopener" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                @endif
            </div>

            {{-- Contact Info & Links - Right Side --}}
            <div class="topbar-contact">
                @if(isset($footerContactInfo) && $footerContactInfo->mobile)
                <a href="tel:{{ $footerContactInfo->mobile }}" class="topbar-phone">
                    <i class="fas fa-phone-alt"></i>
                    <span>{{ $footerContactInfo->mobile }}</span>
                </a>
                @endif
                @if(isset($footerContactInfo) && $footerContactInfo->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}" target="_blank" rel="noopener" class="topbar-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    <span>{{ __('lang.whatsapp') }}</span>
                </a>
                @endif
                
                {{-- Quick Links --}}
                <div class="topbar-links">
                    <a href="{{ route('blogs.index') }}" class="topbar-link">
                        <i class="fas fa-newspaper"></i>
                        <span>{{ __('lang.news') }}</span>
                    </a>
                    <a href="{{ route('careers.index') }}" class="topbar-link">
                        <i class="fas fa-briefcase"></i>
                        <span>{{ __('lang.careers') }}</span>
                    </a>
                    <span class="topbar-divider" aria-hidden="true"></span>
                    @auth
                        @if(auth()->user()->isCustomer())
                        <a href="{{ route('account.dashboard') }}" class="topbar-link">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ __('lang.account') }}</span>
                        </a>
                        <a href="{{ route('logout') }}" class="topbar-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>{{ __('lang.logout') }}</span>
                        </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="topbar-link">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ __('lang.login') }}</span>
                        </a>
                        <a href="{{ route('account.register') }}" class="topbar-link topbar-link-register">
                            <i class="fas fa-user-plus"></i>
                            <span>{{ __('lang.register') }}</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

