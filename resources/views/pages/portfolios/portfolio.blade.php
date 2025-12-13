@extends('layouts.master')
@if(App::getLocale() == 'en')
@section('title', $portfolio->title_english)
@else
@section('title', $portfolio->title_arabic)
@endif

@if($portfolio->seo_tags != null)
@section('seo_tags'){{ $portfolio->seo_tags }}@endsection
@endif

@if(App::getLocale() == 'en')
@if($portfolio->seo_description_english != null)
@section('seo_desc'){{ $portfolio->seo_description_english }}@endsection
@endif
@else
@if($portfolio->seo_description_arabic != null)
@section('seo_desc'){{ $portfolio->seo_description_arabic }}@endsection
@endif
@endif

@section('css')
<style>
/* Portfolio Details Styles */
.portfolio-details-wrapper {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.portfolio-main-image {
  width: 100%;
  height: auto;
  display: block;
}

.portfolio-content {
  padding: 40px;
}

.portfolio-title {
  font-size: 32px;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 20px;
  line-height: 1.3;
}

.portfolio-bio {
  font-size: 18px;
  color: #666;
  font-style: italic;
  margin-bottom: 25px;
  padding-left: 20px;
  border-left: 4px solid #ff5722;
}

.portfolio-description {
  font-size: 16px;
  line-height: 1.8;
  color: #444;
  margin-bottom: 30px;
}

.portfolio-description p {
  margin-bottom: 15px;
}

/* Sidebar Styles */
.portfolio-sidebar {
  position: sticky;
  top: 100px;
}

.sidebar-widget {
  background: white;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
  margin-bottom: 30px;
}

.widget-title {
  font-size: 22px;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 3px solid #ff5722;
}

.info-item {
  display: flex;
  align-items: flex-start;
  padding: 15px 0;
  border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
  border-bottom: none;
}

.info-icon {
  width: 45px;
  height: 45px;
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  margin-right: 15px;
  flex-shrink: 0;
}

.info-text {
  flex: 1;
}

.info-text span {
  display: block;
  font-size: 13px;
  color: #999;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 5px;
}

.info-text h6 {
  font-size: 16px;
  font-weight: 600;
  color: #2c3e50;
  margin: 0;
  line-height: 1.4;
}

/* Section Header */
.section-header {
  position: relative;
  display: inline-block;
  margin-bottom: 30px;
  padding-bottom: 15px;
  font-size: 28px;
  font-weight: 700;
  color: #1a1a1a;
}

.section-header::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #ff5722 0%, #ff7043 100%);
  border-radius: 2px;
}

/* Process Icon Hover Effect */
.service-item.style-4:hover .process-icon-img {
  filter: brightness(0) invert(1) !important;
  transition: filter 0.3s ease;
}

.process-icon-img {
  transition: filter 0.3s ease;
}

/* Responsive */
@media (max-width: 991px) {
  .portfolio-sidebar {
    position: relative;
    top: 0;
    margin-top: 40px;
  }
  
  .portfolio-content {
    padding: 30px 20px;
  }
  
  .portfolio-title {
    font-size: 26px;
  }
}

@media (max-width: 767px) {
  .portfolio-title {
    font-size: 22px;
  }
  
  .portfolio-bio {
    font-size: 16px;
  }
  
  .section-header {
    font-size: 24px;
  }
}
</style>
@endsection

@section('content')

<!-- start: Breadcrumb Section with Portfolio Cover -->
<section class="tj-page-header section-gap-x" 
         @if($portfolio->cover)
         style="background-image: url('{{ asset('storage' . $portfolio->cover) }}'); background-size: cover; background-position: center;"
         @else
         data-bg-image="assets/images/bg/pheader-bg.webp"
         @endif>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">
            @if(App::getLocale() == 'en')
              {{ $portfolio->title_english }}
            @else
              {{ $portfolio->title_arabic }}
            @endif
          </h1>
          <div class="tj-page-link">
            <span><i class="tji-home"></i></span>
            <span>
              <a href="{{ url('/') }}">{{ __('lang.home') }}</a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              <a href="{{ route('portfolios.index') }}">{{ __('lang.portfolio') }}</a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              @if(App::getLocale() == 'en')
                {{ $portfolio->title_english }}
              @else
                {{ $portfolio->title_arabic }}
              @endif
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
</section>
<!-- end: Breadcrumb Section -->

<!-- start: Portfolio Details Section -->
<section class="tj-blog-section section-gap">
  <div class="container">
    <div class="row">
      
      <!-- Main Content -->
      <div class="col-lg-8">
        <div class="portfolio-details-wrapper wow fadeInUp" data-wow-delay=".1s">
          
          <!-- Page Image -->
          @if($portfolio->page_image)
            <img src="{{ asset('storage' . $portfolio->page_image) }}" 
                 alt="@if(App::getLocale() == 'en'){{ $portfolio->title_english }}@else{{ $portfolio->title_arabic }}@endif"
                 class="portfolio-main-image">
          @endif
          
          <div class="portfolio-content">
            <!-- Title -->
            <h2 class="portfolio-title">
              @if(App::getLocale() == 'en')
                {{ $portfolio->title_english }}
              @else
                {{ $portfolio->title_arabic }}
              @endif
            </h2>
            
            <!-- Bio (Short Description) -->
            @if(App::getLocale() == 'en' && $portfolio->bio_english)
              <div class="portfolio-bio">
                {{ $portfolio->bio_english }}
              </div>
            @elseif(App::getLocale() == 'ar' && $portfolio->bio_arabic)
              <div class="portfolio-bio">
                {{ $portfolio->bio_arabic }}
              </div>
            @endif
            
            <!-- Description -->
            <div class="portfolio-description">
              @if(App::getLocale() == 'en')
                {!! nl2br(e($portfolio->description_english)) !!}
              @else
                {!! nl2br(e($portfolio->description_arabic)) !!}
              @endif
            </div>
          </div>
        </div>
        
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="portfolio-sidebar">
          <div class="sidebar-widget wow fadeInUp" data-wow-delay=".1s">
            <h4 class="widget-title">
            	<img src="{{url('/pic/svg40.svg')}}">
              @if(App::getLocale() == 'en')
                Project Info
              @else
                معلومات المشروع
              @endif
            </h4>
            
            <!-- Client Name -->
            <div class="info-item">
              <div class="info-icon">
                <i class="tji-user"></i>
              </div>
              <div class="info-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Client
                  @else
                    العميل
                  @endif
                </span>
                <h6>{{ $portfolio->client_name }}</h6>
              </div>
            </div>
            
            <!-- Portfolio Type -->
            <div class="info-item">
              <div class="info-icon">
                <i class="tji-chart"></i>
              </div>
              <div class="info-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Type
                  @else
                    النوع
                  @endif
                </span>
                <h6>
                  @if(App::getLocale() == 'en')
                    {{ $portfolio->portfolioType->name_english ?? 'N/A' }}
                  @else
                    {{ $portfolio->portfolioType->name_arabic ?? 'غير محدد' }}
                  @endif
                </h6>
              </div>
            </div>
            
            <!-- Date -->
            <div class="info-item">
              <div class="info-icon">
                <i class="tji-calendar"></i>
              </div>
              <div class="info-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Date
                  @else
                    التاريخ
                  @endif
                </span>
                <h6>{{ $portfolio->date ? $portfolio->date->format('M d, Y') : 'N/A' }}</h6>
              </div>
            </div>
            
          </div>
          
          <!-- Latest Portfolio Projects in Sidebar -->
          @include('pages.portfolios.partials.related')
          
        </div>
      </div>
      
    </div>
  </div>
</section>
<!-- end: Portfolio Details Section -->

<!-- Portfolio Process -->
@if($portfolio->processes && $portfolio->processes->count() > 0)
  @include('pages.portfolios.partials.process')
@endif

<!-- Portfolio Gallery -->
<section class="section-gap" style="padding-top: 0;">
  <div class="container">
    @if($portfolio->images && $portfolio->images->count() > 0)
      @include('pages.portfolios.partials.gallery')
    @endif
  </div>
</section>

@endsection
