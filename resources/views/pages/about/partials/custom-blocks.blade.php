{{-- Custom Blocks Section - Enhanced Design --}}
@if($customBlocks && count($customBlocks) > 0)
<section class="custom-blocks-section">
    <div class="container">
        {{-- Section Header --}}
        <div class="blocks-section-header text-center" data-animate="fadeInUp">
            <span class="blocks-section-label">{{ __('lang.discover_more') }}</span>
            <h2 class="blocks-section-title">{{ __('lang.more_about_us') }}</h2>
            <div class="blocks-section-line"></div>
        </div>
        
        {{-- Blocks Container --}}
        <div class="blocks-container">
            @foreach($customBlocks as $block)
            <div class="custom-block {{ $loop->even ? 'custom-block-reverse' : '' }}" data-animate="fadeInUp">
                <div class="custom-block-wrapper">
                    {{-- Image Column --}}
                    @if($block->image)
                    <div class="custom-block-image">
                        <div class="block-img-frame">
                            <img src="{{ asset('storage' . $block->image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}">
                            <div class="block-img-overlay"></div>
                        </div>
                        <div class="block-img-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    @endif
                    
                    {{-- Content Column --}}
                    <div class="custom-block-content {{ !$block->image ? 'custom-block-full' : '' }}">
                        <div class="block-content-box">
                            <span class="block-step-label">{{ __('lang.step') }} {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="block-content-title">
                                {{ app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english }}
                            </h3>
                            <div class="block-content-desc">
                                {!! nl2br(e(app()->getLocale() == 'ar' ? $block->description_arabic : $block->description_english)) !!}
                            </div>
                            <div class="block-content-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
