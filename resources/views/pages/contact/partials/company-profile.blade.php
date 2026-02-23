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
