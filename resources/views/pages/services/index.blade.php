@extends('layouts.master')
@section('title', __('lang.services_page_title'))
@section('content')

<!-- start: Breadcrumb Section -->
<section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">{{ __('lang.services_page_title') }}</h1>
          <div class="tj-page-link">
            <span><i class="tji-home"></i></span>
            <span>
              <a href="{{ url(App::getLocale() . '/') }}">{{ __('lang.home') }}</a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              <span>{{ __('lang.services') }}</span>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
</section>
<!-- end: Breadcrumb Section -->

@if(isset($mainServices) && $mainServices->count() > 0)
  @foreach($mainServices as $mainService)
    <!-- start: Main Service Section -->
    <section class="tj-blog-section h7-blog " style="padding: 50px;">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="sec-heading-wrap">
              <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                <img src="{{url('/pic/logosvg.svg')}}"> 
                Our Services
              </span>
              <div class="heading-wrap-content">
                <div class="sec-heading">
                  <h2 class="sec-title title-anim">
                    @if(App::getLocale() == 'en')
                      {{ $mainService->title_english }}
                    @else
                      {{ $mainService->title_arabic }}
                    @endif
                      </h2>
                </div>
                <p class="desc wow fadeInUp" data-wow-delay=".5s">
                  @if(App::getLocale() == 'en')
                    {{ $mainService->bio_english }}
                  @else
                    {{ $mainService->bio_arabic }}
                  @endif
                </p>
                <div class="btn-wrap wow fadeInUp" data-wow-delay=".6s">
                  <a class="tj-primary-btn" href="{{ route('services.show', ['slug' => $mainService->slug]) }}">
                    <span class="btn-text">
                      <span>
                        @if(App::getLocale() == 'en')
                          View Service
                        @else
                          عرض الخدمة
                        @endif
                      </span>
                    </span>
                    <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        @if($mainService->subServices && $mainService->subServices->count() > 0)
          <!-- Sub Services Grid -->
          <div class="row row-gap-4 h7-blog-wrapper">
            @foreach($mainService->subServices as $subService)
              <div class="col-xl-4 col-md-6">
                <div class="blog-item wow fadeInUp" data-wow-delay=".4s">
                  <div class="blog-thumb">
                    <a href="{{ route('services.show', ['slug' => $subService->slug]) }}">
                      <img src="{{ asset('storage' . $subService->main_image) }}" 
                           alt="{{ App::getLocale() == 'en' ? $subService->title_english : $subService->title_arabic }}">
                    </a>
                    <div class="blog-meta">
                      <span class="categories">
                        <a href="{{ route('services.show', ['slug' => $mainService->slug]) }}">
                          @if(App::getLocale() == 'en')
                            {{ $mainService->title_english }}
                          @else
                            {{ $mainService->title_arabic }}
                          @endif
                        </a>
                      </span>
                    </div>
                  </div>
                  <div class="blog-content">
                    <div class="title-wrapper">
                      <h4 class="title">
                        <a href="{{ route('services.show', ['slug' => $subService->slug]) }}">
                          @if(App::getLocale() == 'en')
                            {{ $subService->title_english }}
                          @else
                            {{ $subService->title_arabic }}
                          @endif
                        </a>
                      </h4>
                      <a class="text-btn" href="{{ route('services.show', ['slug' => $subService->slug]) }}">
                        <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </section>
    <!-- end: Main Service Section -->

    <hr>
  @endforeach
@else
  <!-- No Services Available -->
  <section class="tj-blog-section h7-blog section-gap">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="sec-heading-wrap text-center">
            <h2 class="sec-title">
              @if(App::getLocale() == 'en')
                No Services Available
              @else
                لا توجد خدمات متاحة
              @endif
            </h2>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif

@endsection