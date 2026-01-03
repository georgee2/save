{{-- Team Slider Section --}}
@if(isset($allTeamMembers) && $allTeamMembers->count() > 0)
<section class="pt-lg-12 pb-lg-11 py-11 home-team-section">
    <div class="container container-xxl">
        <div class="row align-items-center mb-6">
            <div class="col-md-7">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13">{{ __('lang.meet_the_team') }}</span>
                <h2 class="text-heading mt-2 mb-0">{{ __('lang.our_team') }}</h2>
                <span class="heading-divider"></span>
                <p class="mb-0">{{ __('lang.team_slider_bio') }}</p>
            </div>
            <div class="col-md-5 text-md-right mt-4 mt-md-0">
                <a href="{{ route('team.index') }}" class="btn fs-14 text-secondary btn-accent py-3 lh-15 px-7 mb-6 mb-lg-0">
                    {{ __('lang.view_all_team') }}
                    <i class="far fa-long-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        {{-- Team Slider --}}
        <div class="home-team-slider slick-slider custom-arrow-spacing-30"
             data-slick-options='{"slidesToShow": 6, "slidesToScroll": 1, "autoplay": true, "autoplaySpeed": 2000, "speed": 500, "dots": true, "arrows": true, "infinite": true, "pauseOnHover": false, "responsive": [{"breakpoint": 1400, "settings": {"slidesToShow": 5}}, {"breakpoint": 1200, "settings": {"slidesToShow": 4}}, {"breakpoint": 992, "settings": {"slidesToShow": 3}}, {"breakpoint": 768, "settings": {"slidesToShow": 2}}, {"breakpoint": 480, "settings": {"slidesToShow": 1}}]}'>
            @foreach($allTeamMembers as $member)
            <div class="box px-2 pb-6 pt-2">
                <a href="{{ route('team.member', $member->id) }}" class="home-team-card d-block text-decoration-none">
                    <div class="team-card-inner bg-white rounded-lg overflow-hidden shadow-hover-3 text-center p-4">
                        {{-- Member Icon (100x100) --}}
                        <div class="team-icon-wrapper mx-auto mb-3 position-relative">
                            @if($member->icon)
                            <img src="{{ asset('storage' . $member->icon) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}" 
                                 class="team-icon-img">
                            @elseif($member->main_image)
                            <img src="{{ asset('storage' . $member->main_image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}" 
                                 class="team-icon-img">
                            @else
                            <div class="team-icon-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                            
                            {{-- Board Badge --}}
                            @if($member->is_board_director)
                            <div class="team-board-badge-small">
                                <i class="fas fa-star"></i>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Member Info --}}
                        <h5 class="team-card-name mb-1">
                            {{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}
                        </h5>
                        
                        @if($member->jobTitle)
                        <p class="team-card-job mb-1">
                            {{ app()->getLocale() == 'ar' ? $member->jobTitle->name_arabic : $member->jobTitle->name_english }}
                        </p>
                        @endif
                        
                        @if($member->rank)
                        <p class="team-card-rank-title mb-2">
                            {{ app()->getLocale() == 'ar' ? $member->rank->name_arabic : $member->rank->name_english }}
                        </p>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
/* Home Team Section Styles */
.home-team-section {
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
}

.home-team-card {
    display: block;
}

.home-team-card:hover {
    text-decoration: none;
}

.home-team-card .team-card-inner {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(25, 134, 139, 0.08);
    height: 260px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
}

.home-team-card:hover .team-card-inner {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(25, 134, 139, 0.15) !important;
    border-color: rgba(25, 134, 139, 0.2);
}

/* Team Icon (100x100) */
.team-icon-wrapper {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: visible;
    position: relative;
    border: 3px solid #19868b;
    box-shadow: 0 5px 20px rgba(25, 134, 139, 0.2);
    transition: all 0.3s ease;
}

.team-icon-wrapper img,
.team-icon-wrapper .team-icon-placeholder {
    border-radius: 50%;
    overflow: hidden;
}

.home-team-card:hover .team-icon-wrapper {
    border-color: #0d6b6f;
    box-shadow: 0 8px 30px rgba(25, 134, 139, 0.3);
    transform: scale(1.05);
}

.team-icon-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.4s ease;
}

.home-team-card:hover .team-icon-img {
    transform: scale(1.1);
}

.team-icon-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
}

.team-icon-placeholder i {
    font-size: 36px;
    color: #94a3b8;
}

/* Board Badge Small */
.team-board-badge-small {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e1273d 0%, #c41f34 100%);
    color: #ffffff;
    border-radius: 50%;
    font-size: 11px;
    box-shadow: 0 3px 10px rgba(225, 39, 61, 0.4);
    border: 3px solid #ffffff;
    z-index: 20;
}

/* Member Info */
.team-card-name {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
    transition: color 0.3s ease;
    line-height: 1.3;
}

.home-team-card:hover .team-card-name {
    color: #19868b;
}

.team-card-job {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
    line-height: 1.4;
    min-height: 36px;
    display: flex;
    align-items: center;
}

.team-card-rank-title {
    font-size: 12px;
    color: #19868b;
    font-weight: 600;
    line-height: 1.3;
    margin-top: auto;
}

/* Slider Arrows */
.home-team-slider .slick-arrow {
    width: 45px;
    height: 45px;
    background: #ffffff;
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    z-index: 10;
    transition: all 0.3s ease;
}

.home-team-slider .slick-arrow:hover {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
    box-shadow: 0 6px 20px rgba(25, 134, 139, 0.3);
}

.home-team-slider .slick-arrow:before {
    color: #19868b;
    font-size: 16px;
    transition: color 0.3s ease;
}

.home-team-slider .slick-arrow:hover:before {
    color: #ffffff;
}

.home-team-slider .slick-prev {
    left: -20px;
}

.home-team-slider .slick-next {
    right: -20px;
}

/* Slider Dots */
.home-team-slider .slick-dots {
    bottom: -35px;
}

.home-team-slider .slick-dots li button:before {
    font-size: 10px;
    color: #cbd5e1;
    opacity: 1;
}

.home-team-slider .slick-dots li.slick-active button:before {
    color: #19868b;
}

/* Responsive */
@media (max-width: 1199px) {
    .home-team-slider .slick-prev {
        left: 5px;
    }
    
    .home-team-slider .slick-next {
        right: 5px;
    }
}

@media (max-width: 767px) {
    .home-team-slider .slick-arrow {
        width: 38px;
        height: 38px;
    }
    
    .home-team-slider .slick-arrow:before {
        font-size: 14px;
    }
    
    .team-icon-wrapper {
        width: 90px;
        height: 90px;
    }
    
    .team-card-name {
        font-size: 14px;
    }
    
    .team-card-job {
        font-size: 12px;
    }
}
</style>
@endif

