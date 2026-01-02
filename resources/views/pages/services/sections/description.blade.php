{{-- Description Section --}}
<section class="service-description-section py-12">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="description-image-wrapper">
                    @if($service->main_image)
                    <img src="{{ asset('storage' . $service->main_image) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}"
                         class="description-main-image">
                    @else
                    <div class="description-image-placeholder">
                        @if($service->icon)
                        <img src="{{ asset('storage' . $service->icon) }}" alt="" class="placeholder-icon">
                        @else
                        <i class="fal fa-cogs"></i>
                        @endif
                    </div>
                    @endif
                    <div class="description-image-accent"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="description-content">
                    <div class="section-badge mb-3">
                        <span class="badge-line"></span>
                        <span class="badge-text">{{ __('lang.about_service') }}</span>
                    </div>
                    <h2 class="section-title mb-4">
                        {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                    </h2>
                    <div class="description-text">
                        {!! app()->getLocale() == 'ar' ? $service->description_arabic : $service->description_english !!}
                    </div>
                    
                    @if($service->icon)
                    <div class="service-icon-display mt-4">
                        <img src="{{ asset('storage' . $service->icon) }}" alt="" class="service-icon-img">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

