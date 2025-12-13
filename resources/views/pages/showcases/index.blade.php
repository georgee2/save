@extends('layouts.master')
@section('title', __('lang.showcases_page_title'))

@section('content')

<!-- start: Breadcrumb Section -->
<section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">{{ __('lang.showcases_page_title') }}</h1>
          <div class="tj-page-link">
            <span><i class="tji-home"></i></span>
            <span>
              <a href="{{ url('/') }}">{{ __('lang.home') }}</a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              {{ __('lang.showcases') }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
</section>
<!-- end: Breadcrumb Section -->

<!-- start: Blog Section -->
<section class="tj-blog-section-3 section-gap section-gap-x">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-heading style-3 text-center">
          <span class="sub-title wow fadeInUp" data-wow-delay=".3s"><i class="tji-box"></i>
            {{ __('lang.showcases_page_title') }}
          </span>
          <h2 class="sec-title title-anim">{{ __('lang.explore_our_work') }}</h2>
        </div>
      </div>
    </div>
    <div class="row row-gap-4">
      @foreach($showcases as $index => $showcase)
      <div class="col-lg-4 col-md-6">
        <div class="blog-item style-3 wow fadeInUp" data-wow-delay="{{ 0.4 + ($index * 0.2) }}s">
          <div class="blog-thumb">
            <a href="{{ route('showcases.show', $showcase->id) }}">
              @if($showcase->page_image)
                <img src="{{ asset('storage' . $showcase->page_image) }}" alt="@if(App::getLocale() == 'en'){{ $showcase->title_english }}@else{{ $showcase->title_arabic }}@endif">
              @else
                <img src="assets/images/blog/blog-6.webp" alt="">
              @endif
            </a>
          </div>
          <div class="blog-content">
            <h4 class="title">
              <a href="{{ route('showcases.show', $showcase->id) }}">
                @if(App::getLocale() == 'en')
                  {{ $showcase->title_english }}
                @else
                  {{ $showcase->title_arabic }}
                @endif
              </a>
            </h4>
            <a class="text-btn" href="{{ route('showcases.show', $showcase->id) }}">
              <span class="btn-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Read More
                  @else
                    اقرأ المزيد
                  @endif
                </span>
              </span>
              <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    
    <!-- Pagination -->
    @if($showcases->hasPages())
    <div class="tj-pagination d-flex justify-content-center" style="margin-top: 50px;">
      <ul>
        {{-- Previous Page Link --}}
        @if ($showcases->onFirstPage())
          <li class="disabled"><span><i class="tji-arrow-left"></i></span></li>
        @else
          <li><a href="{{ $showcases->previousPageUrl() }}"><i class="tji-arrow-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($showcases->getUrlRange(1, $showcases->lastPage()) as $page => $url)
          @if ($page == $showcases->currentPage())
            <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
          @else
            <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($showcases->hasMorePages())
          <li><a class="next page-numbers" href="{{ $showcases->nextPageUrl() }}"><i class="tji-arrow-right"></i></a></li>
        @else
          <li class="disabled"><span><i class="tji-arrow-right"></i></span></li>
        @endif
      </ul>
    </div>
    @endif
    
  </div>
  <div class="bg-shape-1">
    <img src="assets/images/shape/pattern-2.svg" alt="">
  </div>
  <div class="bg-shape-2">
    <img src="assets/images/shape/pattern-3.svg" alt="">
  </div>
</section>
<!-- end: Blog Section -->

@endsection
