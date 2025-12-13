@extends('layouts.master')
@section('title', __('lang.our_team'))

@section('content')


<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ __('lang.our_team') }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.team') }}</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-header-overlay" data-bg-image="assets/images/shape/pheader-overlay.webp"></div>
        </section>
        <!-- end: Breadcrumb Section -->

        <!-- start: Team Section -->
        <section class="tj-team-section">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading text-center">
                  <span class="sub-title wow fadeInUp" data-wow-delay=".1s"><img src="{{url('/pic/logosvg.svg')}}">  {{ __('lang.meet_our_team') }}</span>
                  <h2 class="sec-title title-anim">{{ __('lang.people_behind') }} <span>{{ __('lang.company_name') }}.</span></h2>
                </div>
              </div>
            </div>
            <div class="row">
              @foreach($teams as $index => $team)
              <div class="col-lg-3 col-sm-6">
                <div class="team-item wow fadeInUp" data-wow-delay="{{ ($index % 4) * 0.2 + 0.1 }}s">
                  <div class="team-img">
                    <div class="team-img-inner">
                      <img src="{{ asset('storage/' . $team->main_image) }}" alt="{{ App::getLocale() == 'en' ? $team->name_english : $team->name_arabic }}">
                    </div>
                    <div class="social-links">
                      <ul>
                        <li><a href="https://www.facebook.com/" target="_blank"><i
                              class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li><a href="https://www.instagram.com/" target="_blank"><i
                              class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li><a href="https://x.com/" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/" target="_blank"><i
                              class="fa-brands fa-linkedin-in"></i></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="team-content">
                    <h4 class="title"><a href="{{ route('team.member', $team->id) }}">{{ App::getLocale() == 'en' ? $team->name_english : $team->name_arabic }}</a></h4>
                    <span class="designation">{{ App::getLocale() == 'en' ? $team->jobTitle->name_english : $team->jobTitle->name_arabic }}</span>
                    <a class="mail-at" href="mailto:{{ $team->email }}"><i class="tji-at"></i></a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </section>
        <!-- end: Team Section -->


@endsection