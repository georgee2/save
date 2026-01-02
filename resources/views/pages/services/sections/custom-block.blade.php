{{-- Custom Block Section --}}
@if($block->block_type === 'banner')
<section class="service-banner-block" style="@if($block->image) background-image: url('{{ asset('storage' . $block->image) }}'); @endif">
    <div class="banner-overlay"></div>
    <div class="container position-relative">
        <div class="banner-content text-center">
            <h2 class="banner-title">
                {{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}
            </h2>
            @if($block->description_english || $block->description_arabic)
            <p class="banner-description">
                {{ app()->getLocale() == 'ar' ? $block->description_arabic : $block->description_english }}
            </p>
            @endif
            <a href="{{ route('contact') }}" class="banner-cta-btn">
                <i class="fal fa-arrow-right"></i>
                {{ __('lang.get_started') }}
            </a>
        </div>
    </div>
</section>
@elseif($block->block_type === 'image_with_text')
<section class="service-image-text-block py-12">
    <div class="container">
        <div class="image-text-wrapper">
            @if($block->image)
            <div class="image-text-visual">
                <div class="image-frame">
                    <div class="image-frame-border"></div>
                    <img src="{{ asset('storage' . $block->image) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}"
                         class="image-text-img">
                    <div class="image-decoration image-decoration-top"></div>
                    <div class="image-decoration image-decoration-bottom"></div>
                </div>
            </div>
            @endif
            <div class="image-text-content {{ !$block->image ? 'full-width' : '' }}">
                <div class="content-inner">
                    <div class="content-badge">
                        <span class="badge-icon"><i class="fal fa-layer-group"></i></span>
                        <span class="badge-text">{{ __('lang.explore_service') }}</span>
                    </div>
                    <h2 class="content-title">
                        {{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}
                    </h2>
                    @if($block->description_english || $block->description_arabic)
                    <div class="content-description">
                        {!! app()->getLocale() == 'ar' ? $block->description_arabic : $block->description_english !!}
                    </div>
                    @endif
                    <div class="content-actions">
                        <a href="{{ route('contact') }}" class="action-btn action-btn-primary">
                            <span>{{ __('lang.get_consultation') }}</span>
                            <i class="fal fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
