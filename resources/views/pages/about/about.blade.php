@extends('layouts.master')
@section('title', __('lang.about_page_title'))

@section('content')

<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="{{ $aboutInfo->page_cover_image ? asset('storage/' . $aboutInfo->page_cover_image) : asset('assets/images/bg/pheader-bg.webp') }}">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ __('lang.about_page_title') }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.about_us') }}</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
        </section>
        <!-- end: Breadcrumb Section -->


        <!-- start: About Section -->
        <section class="tj-faq-section section-gap tj-arrange-container-2">
          <div class="container">
            <div class="row justify-content-between">
              <div class="col-lg-6">
                <div class="faq-img-area tj-arrange-item-2">
                  @if($aboutInfo->about_image)
                  <div class="faq-img overflow-hidden">
                    <img src="{{ asset('storage/' . $aboutInfo->about_image) }}" alt="{{ App::getLocale() == 'en' ? $aboutInfo->title_english : $aboutInfo->title_arabic }}">
                    <h2 class="title">{{ App::getLocale() == 'en' ? $aboutInfo->title_english : $aboutInfo->title_arabic }}</h2>
                  </div>
                  @endif
                  @if($contactInfo->mobile)
                  <div class="box-area ">
                    <div class="call-box">
                      <h4 class="title">{{ __('lang.get_started_free_call') }}</h4>
                      <span class="call-icon"><i class="tji-phone"></i></span>
                      <a class="number" href="tel:{{ $contactInfo->mobile }}"><span>{{ $contactInfo->mobile }}</span></a>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
              <div class="col-lg-6">
                <div class="tj-arrange-item-2">
                  <div class="sec-heading style-3">
                    @if($aboutInfo->subtitle_english || $aboutInfo->subtitle_arabic)
                    <span class="sub-title wow fadeInUp" data-wow-delay=".3s"> <img src="{{url('/pic/logosvg.svg')}}"> {{ App::getLocale() == 'en' ? $aboutInfo->subtitle_english : $aboutInfo->subtitle_arabic }}</span>
                    @endif
                    @if($aboutInfo->title_english || $aboutInfo->title_arabic)
                    <h2 class="sec-title title-anim">{{ App::getLocale() == 'en' ? $aboutInfo->title_english : $aboutInfo->title_arabic }}</h2>
                    @endif
                  </div>
                  @if($aboutInfo->about_english || $aboutInfo->about_arabic)
                  <div class="about-content wow fadeInUp" data-wow-delay=".5s">
                    <p>{!! App::getLocale() == 'en' ? nl2br(e($aboutInfo->about_english)) : nl2br(e($aboutInfo->about_arabic)) !!}</p>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- end: About Section -->


       @include('pages.about.partials.missions')
       @include('pages.about.partials.features')
       @include('pages.about.partials.team')
       @include('pages.about.partials.blocks')



@endsection