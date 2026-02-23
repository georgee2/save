{{-- Features Section - Modern Design --}}
@if($features && count($features) > 0)
<section class="features-section-modern">
    {{-- Background Elements --}}
    <div class="features-bg-wrapper">
        <div class="features-bg-gradient"></div>
        <div class="features-bg-pattern"></div>
        <div class="features-bg-glow features-glow-1"></div>
        <div class="features-bg-glow features-glow-2"></div>
    </div>
    
    <div class="container position-relative">
        {{-- Section Header --}}
        <div class="features-header" data-animate="fadeInUp">
            <div class="features-badge">
                <span class="badge-dot"></span>
                <span class="badge-text">{{ __('lang.what_we_offer') }}</span>
            </div>
            <h2 class="features-title">
                {{ __('lang.our_features') }}
                <span class="title-decoration">
                    <svg viewBox="0 0 200 20" preserveAspectRatio="none">
                        <path d="M0,10 Q50,0 100,10 T200,10" fill="none" stroke="currentColor" stroke-width="3"/>
                    </svg>
                </span>
            </h2>
            <p class="features-subtitle">{{ __('lang.features_subtitle') ?? 'Discover what makes us stand out from the rest' }}</p>
        </div>
        
        {{-- Features Grid --}}
        <div class="features-grid-modern">
            @foreach($features as $index => $feature)
            <div class="feature-card-modern" data-animate="fadeInUp" data-delay="{{ $loop->index * 100 }}">
                {{-- Card Glow Effect --}}
                <div class="feature-card-glow"></div>
                
                {{-- Card Inner --}}
                <div class="feature-card-inner">
                    {{-- Number Badge --}}
                    <div class="feature-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    
                    {{-- Icon Container --}}
                    <div class="feature-icon-modern">
                        <div class="icon-bg">
                            <div class="icon-bg-inner"></div>
                        </div>
                        <div class="icon-content">
                            @if($feature->icon)
                            <img src="{{ asset('storage' . $feature->icon) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}">
                            @else
                            <i class="fas fa-star"></i>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="feature-content-modern">
                        <h4 class="feature-title-modern">
                            {{ app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english }}
                        </h4>
                        <p class="feature-desc-modern">
                            {{ app()->getLocale() == 'ar' ? $feature->description_arabic : $feature->description_english }}
                        </p>
                    </div>
                    
                    {{-- Hover Arrow --}}
                    <div class="feature-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    
                    {{-- Bottom Accent Line --}}
                    <div class="feature-accent-line"></div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Bottom Decoration --}}
        <div class="features-bottom-decoration">
            <div class="decoration-line"></div>
            <div class="decoration-icon">
                <i class="fas fa-gem"></i>
            </div>
            <div class="decoration-line"></div>
        </div>
    </div>
</section>
@endif
