@extends('layouts.master')
@if(App::getLocale() == 'en')
@section('title', $team->name_english)
@else
@section('title', $team->name_arabic)
@endif

@section('content')

<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="assets/images/bg/pheader-bg.webp">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ App::getLocale() == 'en' ? $team->name_english : $team->name_arabic }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <a href="{{ route('team.index') }}">{{ __('lang.team') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.team_details') }}</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-header-overlay" data-bg-image="assets/images/shape/pheader-overlay.webp"></div>
        </section>
        <!-- end: Breadcrumb Section -->

        <!-- start: Team Details Section -->
        <section class="team-details slidebar-stickiy-container">

          <div class="container">
            <div class="row justify-content-center">
              <!--  left -->
              <div class="col-12 col-md-8 col-lg-5">
                <div class="team-details__img slidebar-stickiy wow fadeInUp" data-wow-delay=".1s">
                  <img src="{{ asset('storage/' . $team->page_image) }}" alt="{{ App::getLocale() == 'en' ? $team->name_english : $team->name_arabic }}">
                </div>
              </div>
              <!-- right -->
              <div class="col-12 col-lg-7 ">
                <div class="team-details__content">
                  <h2 class="team-details__name title-anim">{{ __('lang.hello_i_am') }} {{ App::getLocale() == 'en' ? $team->name_english : $team->name_arabic }}</h2>
                  <span class="team-details__desig wow fadeInUp" data-wow-delay=".1s">{{ App::getLocale() == 'en' ? $team->jobTitle->name_english : $team->jobTitle->name_arabic }}</span>
                  <div class="team-details__contact-info wow fadeInUp" data-wow-delay=".5s">
                    <ul>
                      <li>
                        <span>{{ __('lang.email_address') }}</span>
                        <a href="mailto:{{ $team->email }}">{{ $team->email }}</a>
                      </li>
                      <li>
                        <span>{{ __('lang.phone_number') }}</span>
                        <a href="tel:{{ $team->mobile }}">{{ $team->mobile }}</a>
                      </li>
                    </ul>
                  </div>
                  <div class="social-links wow fadeInUp" data-wow-delay=".5s">
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
                  @if((App::getLocale() == 'en' && $team->work_experience_english) || (App::getLocale() == 'ar' && $team->work_experience_arabic))
                  <div class="team-details__experience">
                    <h4 class="team-details__subtitle wow fadeInUp" data-wow-delay=".3s">{{ __('lang.work_experience') }}</h4>
                    <p class="wow fadeInUp" data-wow-delay=".3s">
                      @if(App::getLocale() == 'en')
                        {!! $team->work_experience_english !!}
                      @else
                        {!! $team->work_experience_arabic !!}
                      @endif
                    </p>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- end: Team Details Section -->


@endsection