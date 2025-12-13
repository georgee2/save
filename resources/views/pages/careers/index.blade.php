@extends('layouts.master')
@section('title', __('lang.careers'))

@section('content')


<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ __('lang.careers') }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.careers') }}</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
        </section>
        <!-- end: Breadcrumb Section -->

        <!-- start: Careers Section -->
        <section class="tj-careers-section section-gap">
          <div class="container">
            <div class="row rg-30">
              @forelse($jobs as $index => $job)
              <div class="col-xl-4 col-md-6">
                <div class="tj-careers wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.2 + 0.1 }}s">
                  @if($job->icon)
                  <div class="tj-careers-icon mb-30">
                    <img src="{{ asset('storage' . $job->icon) }}" alt="{{ App::getLocale() == 'en' ? $job->job_title_english : $job->job_title_arabic }}" style="width: 60px; height: 60px; object-fit: contain;">
                  </div>
                  @else
                  <div class="tj-careers-icon mb-30">
                    <i class="tji-briefcase"></i>
                  </div>
                  @endif
                  <div class="tj-careers-tag">
                    <span>{{ $job->job_type }}</span>
                    @php
                      $daysLeft = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($job->registration_end_date), false);
                    @endphp
                    @if($daysLeft <= 7 && $daysLeft >= 0)
                      <span style="background-color: #ff6b35; color: white;">{{ __('lang.urgent') }}</span>
                    @endif
                  </div>
                  <h4 class="tj-careers-title">
                    <a href="{{ route('careers.show', $job->id) }}">
                      {{ App::getLocale() == 'en' ? $job->job_title_english : $job->job_title_arabic }}
                    </a>
                  </h4>
                  @if($job->show_salary && $job->salary)
                  <div class="tj-careers-salary">
                    <span>{{ number_format($job->salary, 0) }} {{ __('lang.egp') }}</span> {{ __('lang.per_month') }}
                  </div>
                  @endif
                  <div class="tj-careers-bottom">
                    <span class="location">
                      <i class="tji-folder"></i>
                      {{ App::getLocale() == 'en' ? $job->job_category_english : $job->job_category_arabic }}
                    </span>
                    <a href="{{ route('careers.show', $job->id) }}" class="tj-careers-btn">
                      <div class="btn-text">
                        <span>{{ __('lang.apply_now') }}</span>
                      </div>
                      <span class="btn-icon">
                        <i class="tji-arrow-right"></i>
                        <i class="tji-arrow-right"></i>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
              @empty
              <div class="col-12">
                <div class="alert alert-warning text-center" style="padding: 40px; border-radius: 10px; background-color: #fff3cd; border-color: #ffc107; color: #856404;">
                  <i class="tji-info-circle" style="font-size: 48px; color: #ffc107; margin-bottom: 20px;"></i>
                  <h4 style="color: #856404; margin-bottom: 15px;">{{ __('lang.no_available_positions') }}</h4>
                  <p style="color: #856404; margin-bottom: 0;">{{ __('lang.no_positions_message') }}</p>
                </div>
              </div>
              @endforelse
            </div>
            <!-- post pagination -->
            @if($jobs->hasPages())
            <div class="tj-pagination d-flex justify-content-center">
              <ul>
                {{-- Previous Page Link --}}
                @if ($jobs->onFirstPage())
                  <li class="disabled" aria-disabled="true">
                    <span class="page-numbers"><i class="tji-arrow-left-long"></i></span>
                  </li>
                @else
                  <li>
                    <a class="page-numbers" href="{{ $jobs->previousPageUrl() }}" rel="prev"><i class="tji-arrow-left-long"></i></a>
                  </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                  @if ($page == $jobs->currentPage())
                    <li>
                      <span aria-current="page" class="page-numbers current">{{ sprintf('%02d', $page) }}</span>
                    </li>
                  @else
                    <li>
                      <a class="page-numbers" href="{{ $url }}">{{ sprintf('%02d', $page) }}</a>
                    </li>
                  @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($jobs->hasMorePages())
                  <li>
                    <a class="next page-numbers" href="{{ $jobs->nextPageUrl() }}" rel="next"><i class="tji-arrow-right-long"></i></a>
                  </li>
                @else
                  <li class="disabled" aria-disabled="true">
                    <span class="page-numbers"><i class="tji-arrow-right-long"></i></span>
                  </li>
                @endif
              </ul>
            </div>
            @endif
          </div>
        </section>
        <!-- end: Careers Section -->


@endsection

@section('css')
<style>
    /* Make icon white on hover */
    .tj-careers:hover .tj-careers-icon img {
        filter: brightness(0) invert(1);
        transition: filter 0.3s ease;
    }
    
    .tj-careers-icon img {
        transition: filter 0.3s ease;
    }
</style>
@endsection