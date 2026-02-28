{{-- Mission, Vision, Values Section - Clean Modern Design --}}
@if(($aboutInfo->mission_english || $aboutInfo->mission_arabic) || ($aboutInfo->vision_english || $aboutInfo->vision_arabic) || ($aboutInfo->values_english || $aboutInfo->values_arabic))
<section class="mvv-section-v2">
    <div class="container">
        {{-- Section Header --}}
        <div class="mvv-section-header text-center" data-animate="fadeInUp">
            <span class="mvv-label">{{ __('lang.our_foundation') }}</span>
            <h2 class="mvv-heading">{{ __('lang.mission_vision_values') }}</h2>
            <div class="mvv-heading-line"></div>
        </div>
        
        {{-- MVV Items --}}
        <div class="mvv-items-wrapper">
            {{-- Mission --}}
            @if($aboutInfo->mission_english || $aboutInfo->mission_arabic)
            <div class="mvv-item" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    @if($aboutInfo->mission_image)
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="{{ asset('storage' . $aboutInfo->mission_image) }}" alt="{{ __('lang.mission') }}">
                            <div class="mvv-image-badge">
                                <i class="fas fa-bullseye"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mvv-item-content {{ !$aboutInfo->mission_image ? 'mvv-full-width' : '' }}">
                        <div class="mvv-item-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="mvv-item-title">{{ __('lang.our_mission') }}</h3>
                        <div class="mvv-item-text">
                            {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->mission_arabic : $aboutInfo->mission_english)) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            {{-- Vision --}}
            @if($aboutInfo->vision_english || $aboutInfo->vision_arabic)
            <div class="mvv-item mvv-item-reverse" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    @if($aboutInfo->vision_image)
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="{{ asset('storage' . $aboutInfo->vision_image) }}" alt="{{ __('lang.vision') }}">
                            <div class="mvv-image-badge mvv-badge-vision">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mvv-item-content {{ !$aboutInfo->vision_image ? 'mvv-full-width' : '' }}">
                        <div class="mvv-item-icon mvv-icon-vision">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="mvv-item-title">{{ __('lang.our_vision') }}</h3>
                        <div class="mvv-item-text">
                            {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->vision_arabic : $aboutInfo->vision_english)) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            {{-- Values --}}
            @if($aboutInfo->values_english || $aboutInfo->values_arabic)
            <div class="mvv-item" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    @if($aboutInfo->values_image)
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="{{ asset('storage' . $aboutInfo->values_image) }}" alt="{{ __('lang.values') }}">
                            <div class="mvv-image-badge mvv-badge-values">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mvv-item-content {{ !$aboutInfo->values_image ? 'mvv-full-width' : '' }}">
                        <div class="mvv-item-icon mvv-icon-values">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="mvv-item-title">{{ __('lang.our_values') }}</h3>
                        <div class="mvv-item-text">
                            {!! nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->values_arabic : $aboutInfo->values_english)) !!}
                        </div>
                        @php
                            $valuesPoints = app()->getLocale() == 'ar' ? $aboutInfo->values_points_arabic : $aboutInfo->values_points_english;
                        @endphp
                        @if($valuesPoints)
                        <ul class="mvv-values-points">
                            @foreach(explode(', ', $valuesPoints) as $point)
                                @if(trim($point))
                                <li><i class="fas fa-check-circle"></i> {{ trim($point) }}</li>
                                @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif
