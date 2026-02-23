{{-- Team Slider Section --}}
@if(isset($allTeamMembers) && $allTeamMembers->count() > 0)
<section class="about-team-section py-12">
    <div class="container">
        <div class="text-center mb-8" data-animate="fadeInUp">
            <div class="section-label justify-content-center">
                <span class="label-line"></span>
                <span class="label-text">{{ __('lang.meet_the_team') }}</span>
                <span class="label-line"></span>
            </div>
            <h2 class="section-title">{{ __('lang.our_team') }}</h2>
            <p class="section-subtitle">{{ __('lang.team_slider_bio') }}</p>
        </div>
        
        {{-- Team Slider --}}
        <div class="about-team-slider slick-slider"
             data-slick-options='{"slidesToShow": 5, "slidesToScroll": 1, "autoplay": true, "autoplaySpeed": 2000, "speed": 500, "dots": true, "arrows": true, "infinite": true, "pauseOnHover": false, "responsive": [{"breakpoint": 1200, "settings": {"slidesToShow": 4}}, {"breakpoint": 992, "settings": {"slidesToShow": 3}}, {"breakpoint": 768, "settings": {"slidesToShow": 2}}, {"breakpoint": 480, "settings": {"slidesToShow": 1}}]}'>
            @foreach($allTeamMembers as $member)
            <div class="about-team-slide px-2 pb-4">
                <div class="about-team-card d-block">
                    <div class="about-team-card-inner">
                        {{-- Member Icon --}}
                        <div class="about-team-icon mx-auto mb-3">
                            @if($member->icon)
                            <img src="{{ asset('storage' . $member->icon) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}">
                            @elseif($member->main_image)
                            <img src="{{ asset('storage' . $member->main_image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}">
                            @else
                            <div class="about-team-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                            
                            {{-- Board Badge --}}
                            @if($member->is_board_director)
                            <div class="about-team-badge">
                                <i class="fas fa-star"></i>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Member Info --}}
                        <h5 class="about-team-name">
                            {{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}
                        </h5>
                        
                        @if($member->jobTitle)
                        <p class="about-team-job">
                            {{ app()->getLocale() == 'ar' ? $member->jobTitle->name_arabic : $member->jobTitle->name_english }}
                        </p>
                        @endif
                        
                        @if($member->rank)
                        <p class="about-team-rank">
                            {{ app()->getLocale() == 'ar' ? $member->rank->name_arabic : $member->rank->name_english }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- View All Button --}}
        <div class="text-center mt-8">
            <a href="{{ route('team.index') }}" class="btn-view-team">
                {{ __('lang.view_all_team') }}
                <i class="fas fa-arrow-right {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }} ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif
