<!-- start: Team Section -->
        <section class="h7-team section-gap section-gap-x">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading style-2 style-7 sec-heading-centered">
                  <span class="sub-title wow fadeInUp" data-wow-delay=".3s"><img src="{{url('/pic/logosvg.svg')}}"> {{ __('lang.meet_our_team') }}</span>
                  <h2 class="sec-title text-anim">{{ __('lang.people_empowering_business') }}</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="h7-team-wrapper">
                  @if($teamMembers->count() > 0)
                  <!-- First Slider (LTR) -->
                  <div class="h7-team-marquee swiper">
                    <div class="swiper-wrapper">
                      @foreach($teamMembers as $index => $member)
                        @if($index % 2 == 0) {{-- Even indexed members in first slider --}}
                        <div class="swiper-slide">
                          <div class="team-item">
                            <div class="team-content">
                              <h5 class="title">
                                <a href="#">
                                  {{ App::getLocale() == 'en' ? $member->name_english : $member->name_arabic }}
                                </a>
                              </h5>
                              <span class="designation">
                                @if($member->jobTitle)
                                  {{ App::getLocale() == 'en' ? $member->jobTitle->name_english : $member->jobTitle->name_arabic }}
                                @else
                                  {{ __('lang.team_member') }}
                                @endif
                              </span>
                            </div>
                            <div class="team-img">
                              <img src="{{ asset('storage' . $member->icon) }}" alt="{{ App::getLocale() == 'en' ? $member->name_english : $member->name_arabic }}">
                            </div>
                          </div>
                        </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
                  
                  <!-- Second Slider (RTL) -->
                  <div dir="rtl" class="h7-team-marquee swiper">
                    <div class="swiper-wrapper">
                      @foreach($teamMembers as $index => $member)
                        @if($index % 2 != 0) {{-- Odd indexed members in second slider --}}
                        <div class="swiper-slide">
                          <div class="team-item">
                            <div class="team-content">
                              <h5 class="title">
                                <a href="#">
                                  {{ App::getLocale() == 'en' ? $member->name_english : $member->name_arabic }}
                                </a>
                              </h5>
                              <span class="designation">
                                @if($member->jobTitle)
                                  {{ App::getLocale() == 'en' ? $member->jobTitle->name_english : $member->jobTitle->name_arabic }}
                                @else
                                  {{ __('lang.team_member') }}
                                @endif
                              </span>
                            </div>
                            <div class="team-img">
                              <img src="{{ asset('storage' . $member->icon) }}" alt="{{ App::getLocale() == 'en' ? $member->name_english : $member->name_arabic }}">
                            </div>
                          </div>
                        </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
                  @else
                  <!-- Fallback when no team members -->
                  <div class="h7-team-marquee swiper">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide">
                        <div class="team-item">
                          <div class="team-content">
                            <h5 class="title"><a href="#">{{ __('lang.no_team_members') }}</a></h5>
                            <span class="designation">{{ __('lang.add_team_members') }}</span>
                          </div>
                          <div class="team-img">
                            <img src="{{ asset('assets/images/team/h7-team-1.webp') }}" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif

                </div>

              </div>

            </div>
          </div>
        </section>
        <!-- end: Team Section -->

