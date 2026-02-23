{{-- Branches Section --}}
@if($branches && $branches->count() > 0)
<section class="contact-branches-section py-12">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="branches-section-badge">
                <i class="fas fa-building"></i>
                <span>{{ __('lang.locations') }}</span>
            </div>
            <h2 class="branches-section-title">{{ __('lang.our_branches') }}</h2>
            <p class="branches-section-subtitle">{{ __('lang.branches_section_subtitle') }}</p>
        </div>
        
        {{-- Branches Grid --}}
        <div class="branches-grid">
            @foreach($branches as $index => $branch)
            <div class="branch-card" data-animate="fadeInUp" data-delay="{{ $index * 100 }}">
                {{-- Branch Header --}}
                <div class="branch-header">
                    <div class="branch-logo-wrapper">
                        @if($branch->logo_english && app()->getLocale() == 'en')
                        <img src="{{ asset('storage' . $branch->logo_english) }}" 
                             alt="{{ $branch->name_english }}" 
                             class="branch-logo">
                        @elseif($branch->logo_arabic && app()->getLocale() == 'ar')
                        <img src="{{ asset('storage' . $branch->logo_arabic) }}" 
                             alt="{{ $branch->name_arabic }}" 
                             class="branch-logo">
                        @elseif($branch->logo_english)
                        <img src="{{ asset('storage' . $branch->logo_english) }}" 
                             alt="{{ $branch->name_english }}" 
                             class="branch-logo">
                        @else
                        <div class="branch-logo-placeholder">
                            <i class="fas fa-building"></i>
                        </div>
                        @endif
                    </div>
                    <div class="branch-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                </div>
                
                {{-- Branch Content --}}
                <div class="branch-content">
                    <h3 class="branch-name">
                        {{ app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english }}
                    </h3>
                    
                    {{-- Location --}}
                    @if(($branch->location_text_english && app()->getLocale() == 'en') || ($branch->location_text_arabic && app()->getLocale() == 'ar'))
                    <div class="branch-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ app()->getLocale() == 'ar' ? $branch->location_text_arabic : $branch->location_text_english }}</span>
                    </div>
                    @endif
                    
                    {{-- Opening Hours --}}
                    @if($branch->opening_hours)
                    <div class="branch-hours">
                        <i class="fas fa-clock"></i>
                        <span>{{ $branch->opening_hours }}</span>
                    </div>
                    @endif
                    
                    {{-- Get Directions Button --}}
                    @if($branch->map_url)
                    <div class="branch-actions">
                        <a href="{{ $branch->map_url }}" target="_blank" class="btn-branch btn-directions">
                            <i class="fas fa-directions"></i>
                            <span>{{ __('lang.get_directions') }}</span>
                        </a>
                    </div>
                    @endif
                </div>
                
                {{-- Map Preview (if available) --}}
                @if($branch->map_url)
                <div class="branch-map-preview">
                    @if(strpos($branch->map_url, '<iframe') !== false)
                        {!! $branch->map_url !!}
                    @else
                        <iframe src="{{ $branch->map_url }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        
        {{-- View All Branches Link --}}
        <div class="text-center mt-8">
            <a href="{{ route('branches.index') }}" class="btn btn-view-branches">
                <i class="fas fa-building {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ __('lang.view_all_branches') }}
            </a>
        </div>
    </div>
</section>
@endif
