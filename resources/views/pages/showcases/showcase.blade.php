@extends('layouts.master')
@if(App::getLocale() == 'en')
@section('title', $showcase->title_english)
@else
@section('title', $showcase->title_arabic)
@endif

@if($showcase->seo_tags != null)
@section('seo_tags'){{ $showcase->seo_tags }}@endsection
@endif

@if(App::getLocale() == 'en')
@if($showcase->seo_description_english != null)
@section('seo_desc'){{ $showcase->seo_description_english }}@endsection
@endif
@else
@if($showcase->seo_description_arabic != null)
@section('seo_desc'){{ $showcase->seo_description_arabic }}@endsection
@endif
@endif

@section('css')
<style>
/* Showcase Navigation Bar */
.showcase-nav-wrapper {
  background: white;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  position: sticky;
  top: 0;
  z-index: 999;
  border-bottom: 3px solid #ff5722;
}

.showcase-nav {
  position: relative;
}

.showcase-nav-list {
  display: flex;
  justify-content: center;
  align-items: center;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: 5px;
}

.showcase-nav-list li {
  margin: 0;
}

.showcase-nav-link {
  display: block;
  padding: 18px 25px;
  color: #2c3e50;
  font-weight: 600;
  font-size: 15px;
  text-decoration: none;
  transition: all 0.3s ease;
  position: relative;
}

.showcase-nav-link:hover,
.showcase-nav-link.active {
  color: #ff5722;
  background: #fff5f2;
}

.showcase-nav-link.active::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #ff5722 0%, #ff7043 100%);
}

.showcase-nav-toggle {
  display: none;
  background: #ff5722;
  border: none;
  color: white;
  padding: 12px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 18px;
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
}

.showcase-nav-toggle:hover {
  background: #e64a19;
}

/* Smooth Scroll Offset */
html {
  scroll-behavior: smooth;
  scroll-padding-top: 80px;
}

/* Responsive Navigation */
@media (max-width: 991px) {
  .showcase-nav-list {
    flex-direction: column;
    align-items: stretch;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }
  
  .showcase-nav-list.active {
    max-height: 500px;
  }
  
  .showcase-nav-toggle {
    display: block;
  }
  
  .showcase-nav-link {
    padding: 15px 20px;
    border-bottom: 1px solid #f0f0f0;
  }
  
  .showcase-nav-link.active::after {
    display: none;
  }
  
  .showcase-nav-link.active {
    border-left: 4px solid #ff5722;
  }
}

@media (max-width: 767px) {
  .showcase-nav-link {
    font-size: 14px;
    padding: 12px 15px;
  }
  
  html {
    scroll-padding-top: 70px;
  }
}

/* Showcase Details Styles */
.showcase-details-wrapper {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.showcase-main-image {
  width: 100%;
  max-height: 600px;
  height: auto;
  display: block;
  object-fit: cover;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.showcase-content {
  padding: 40px;
}

.showcase-title {
  font-size: 32px;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 25px;
  line-height: 1.3;
}

.showcase-description {
  font-size: 16px;
  line-height: 1.8;
  color: #444;
  margin-bottom: 30px;
}

/* Sidebar Styles */
.showcase-sidebar {
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
  display: flex;
  align-items: center;
}

.widget-title img {
  margin-right: 10px;
}

/* Stats Dashboard */
.stats-dashboard {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
  margin-top: 30px;
}

.stat-card {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.stat-card:hover {
  transform: translateY(-5px);
  border-color: #ff5722;
  box-shadow: 0 8px 20px rgba(255, 87, 34, 0.2);
}

.stat-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  margin: 0 auto 15px;
}

.stat-number {
  font-size: 32px;
  font-weight: 700;
  color: #ff5722;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 13px;
  color: #666;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 600;
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
  display: flex;
  align-items: center;
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

.section-header img {
  margin-right: 10px;
}

/* Centered Section Header */
.section-header-center {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0;
  padding-bottom: 20px;
  font-size: 32px;
  font-weight: 700;
  color: #1a1a1a;
}

.section-header-center::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 3px;
  background: linear-gradient(90deg, #ff5722 0%, #ff7043 100%);
  border-radius: 2px;
}

.section-header-center img {
  margin-right: 12px;
}

/* Sidebar Services List */
.sidebar-services-list {
  margin-top: 20px;
}

.sidebar-service-item {
  display: flex;
  align-items: flex-start;
  padding: 15px 0;
  border-bottom: 1px solid #f0f0f0;
  transition: all 0.3s ease;
}

.sidebar-service-item:last-child {
  border-bottom: none;
}

.sidebar-service-item:hover {
  transform: translateX(5px);
}

.sidebar-service-icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  overflow: hidden;
  flex-shrink: 0;
  margin-right: 15px;
  background: #f8f9fa;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sidebar-service-icon img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 8px;
}

.sidebar-service-content {
  flex: 1;
}

.sidebar-service-content h6 {
  font-size: 15px;
  font-weight: 600;
  color: #2c3e50;
  margin: 0 0 8px 0;
  line-height: 1.4;
}

.sidebar-service-link {
  display: inline-flex;
  align-items: center;
  color: #ff5722;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}

.sidebar-service-link:hover {
  transform: translateX(3px);
}

.sidebar-service-link i {
  margin-left: 5px;
  font-size: 12px;
}

/* Portfolio/Project Wrapper */
.portfolio-projects-wrapper {
  background: white;
  border-radius: 15px;
  padding: 35px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
  height: 100%;
}

.portfolio-list {
  margin-top: 25px;
}

.portfolio-list-item {
  display: flex;
  align-items: flex-start;
  padding: 20px 0;
  border-bottom: 1px solid #f0f0f0;
  transition: all 0.3s ease;
}

.portfolio-list-item:last-child {
  border-bottom: none;
}

.portfolio-list-item:hover {
  transform: translateX(5px);
  background: #f8f9fa;
  padding-left: 15px;
  padding-right: 15px;
  margin-left: -15px;
  margin-right: -15px;
  border-radius: 10px;
}

.portfolio-list-image {
  width: 120px;
  height: 100px;
  border-radius: 10px;
  overflow: hidden;
  flex-shrink: 0;
  margin-right: 20px;
  position: relative;
}

.portfolio-list-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.portfolio-list-item:hover .portfolio-list-image img {
  transform: scale(1.1);
}

.portfolio-type-badge {
  position: absolute;
  top: 8px;
  left: 8px;
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  padding: 4px 10px;
  border-radius: 15px;
  font-size: 11px;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(255, 87, 34, 0.3);
}

.portfolio-list-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.portfolio-list-content h5 {
  font-size: 17px;
  font-weight: 600;
  color: #1a1a1a;
  margin: 0 0 10px 0;
  line-height: 1.4;
}

.portfolio-list-content h5 a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s ease;
}

.portfolio-list-content h5 a:hover {
  color: #ff5722;
}

.portfolio-list-link {
  display: inline-flex;
  align-items: center;
  color: #ff5722;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}

.portfolio-list-link:hover {
  transform: translateX(5px);
}

.portfolio-list-link i {
  margin-left: 6px;
  font-size: 12px;
}

/* Team Grid */
.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 25px;
  margin-top: 30px;
}

.team-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  text-align: center;
}

.team-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.team-card .team-image {
  height: 280px;
  overflow: hidden;
}

.team-card .team-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.team-card:hover .team-image img {
  transform: scale(1.1);
}

.team-card .team-content {
  padding: 20px;
}

.team-card h5 {
  font-size: 18px;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 5px;
}

.team-card .team-job {
  font-size: 14px;
  color: #ff5722;
  font-weight: 500;
}

/* News Grid */
.news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 25px;
  margin-top: 30px;
}

.news-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}

.news-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.news-card .news-image {
  height: 200px;
  overflow: hidden;
}

.news-card .news-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.news-card:hover .news-image img {
  transform: scale(1.1);
}

.news-card .news-content {
  padding: 20px;
}

.news-card .news-date {
  font-size: 13px;
  color: #999;
  margin-bottom: 10px;
}

.news-card h5 {
  font-size: 18px;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 15px;
  line-height: 1.4;
}

.news-card h5 a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s ease;
}

.news-card h5 a:hover {
  color: #ff5722;
}

/* Responsive */
@media (max-width: 991px) {
  .showcase-sidebar {
    position: relative;
    top: 0;
    margin-top: 40px;
  }
  
  .showcase-content {
    padding: 30px 20px;
  }
  
  .showcase-title {
    font-size: 26px;
  }
  
  .stats-dashboard {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .portfolio-projects-wrapper {
    margin-bottom: 30px;
  }
  
  .portfolio-list-image {
    width: 100px;
    height: 85px;
  }
}

@media (max-width: 767px) {
  .showcase-title {
    font-size: 22px;
  }
  
  .section-header {
    font-size: 20px;
  }
  
  .stats-dashboard {
    grid-template-columns: 1fr;
  }
  
  .portfolio-projects-wrapper {
    padding: 25px 20px;
  }
  
  .portfolio-list-item {
    flex-direction: column;
    align-items: stretch;
  }
  
  .portfolio-list-image {
    width: 100%;
    height: 180px;
    margin-right: 0;
    margin-bottom: 15px;
  }
  
  .portfolio-list-content h5 {
    font-size: 16px;
  }
  
  .team-grid,
  .news-grid {
    grid-template-columns: 1fr;
  }
}
</style>
@endsection

@section('content')

<!-- start: Breadcrumb Section with Showcase Cover -->
<section class="tj-page-header section-gap-x" 
         @if($showcase->cover_image)
         style="background-image: url('{{ asset('storage' . $showcase->cover_image) }}'); background-size: cover; background-position: center;"
         @else
         data-bg-image="assets/images/bg/pheader-bg.webp"
         @endif>
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">
            @if(App::getLocale() == 'en')
              {{ $showcase->title_english }}
            @else
              {{ $showcase->title_arabic }}
            @endif
          </h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
              <a href="{{ url('/') }}">{{ __('lang.home') }}</a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              <a href="{{ route('showcases.index') }}">{{ __('lang.showcases') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
              @if(App::getLocale() == 'en')
                {{ $showcase->title_english }}
              @else
                {{ $showcase->title_arabic }}
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

<!-- Showcase Navigation Bar -->
<div class="showcase-nav-wrapper">
  <div class="container">
    <nav class="showcase-nav">
      <ul class="showcase-nav-list">
        <li><a href="#overview" class="showcase-nav-link active">
          @if(App::getLocale() == 'en')
            Overview
          @else
            نظرة عامة
          @endif
        </a></li>
        
        @if(($showcase->portfolios && $showcase->portfolios->count() > 0) || ($showcase->projects && $showcase->projects->count() > 0))
        <li><a href="#work" class="showcase-nav-link">
          @if(App::getLocale() == 'en')
            Related Work
          @else
            الأعمال
          @endif
        </a></li>
        @endif
        
        @if($showcase->teams && $showcase->teams->count() > 0)
        <li><a href="#team" class="showcase-nav-link">
          @if(App::getLocale() == 'en')
            Team
          @else
            الفريق
          @endif
        </a></li>
        @endif
        
        @if($showcase->news && $showcase->news->count() > 0)
        <li><a href="#news" class="showcase-nav-link">
          @if(App::getLocale() == 'en')
            News
          @else
            الأخبار
          @endif
        </a></li>
        @endif
      </ul>
      
      <!-- Mobile Menu Toggle -->
      <button class="showcase-nav-toggle">
        <i class="fa fa-bars"></i>
      </button>
    </nav>
  </div>
</div>

<!-- start: Showcase Details Section -->
<section id="overview" class="tj-blog-section section-gap">
          <div class="container">
    <div class="row">
      
      <!-- Main Content -->
              <div class="col-lg-8">
        <div class="showcase-details-wrapper wow fadeInUp" data-wow-delay=".1s">
          
          <!-- Page Image -->
          @if($showcase->page_image)
            <img src="{{ asset('storage' . $showcase->page_image) }}" 
                 alt="@if(App::getLocale() == 'en'){{ $showcase->title_english }}@else{{ $showcase->title_arabic }}@endif"
                 class="showcase-main-image">
          @endif
          
          <div class="showcase-content">
            <!-- Title -->
            <h2 class="showcase-title">
              @if(App::getLocale() == 'en')
                {{ $showcase->title_english }}
              @else
                {{ $showcase->title_arabic }}
              @endif
            </h2>
            
            <!-- Description -->
            <div class="showcase-description">
              @if(App::getLocale() == 'en')
                {!! $showcase->description_english !!}
              @else
                {!! $showcase->description_arabic !!}
              @endif
                          </div>
                        </div>
                      </div>
        
                    </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="showcase-sidebar">
          <div class="sidebar-widget wow fadeInUp" data-wow-delay=".1s">
            <h4 class="widget-title">
              <img src="{{url('/pic/svg40.svg')}}">
              @if(App::getLocale() == 'en')
                Showcase Info
              @else
                معلومات المعرض
              @endif
            </h4>
            
            <!-- Stats Dashboard -->
            <div class="stats-dashboard">
              <!-- Projects Count -->
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="tji-chart"></i>
                  </div>
                <div class="stat-number">{{ $showcase->projects->count() }}</div>
                <div class="stat-label">
                  @if(App::getLocale() == 'en')
                    Projects
                  @else
                    المشاريع
                  @endif
                      </div>
                    </div>
              
              <!-- Portfolios Count -->
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="fa fa-pie-chart"></i>
                    </div>
                <div class="stat-number">{{ $showcase->portfolios->count() }}</div>
                <div class="stat-label">
                  @if(App::getLocale() == 'en')
                    Portfolios
                  @else
                    المعارض
                  @endif
                      </div>
                    </div>
              
              <!-- Services Count -->
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="tji-service-1"></i>
                  </div>
                <div class="stat-number">{{ $showcase->services->count() }}</div>
                <div class="stat-label">
                  @if(App::getLocale() == 'en')
                    Services
                  @else
                    الخدمات
                  @endif
                </div>
              </div>
              
              <!-- Team Count -->
              <div class="stat-card">
                <div class="stat-icon">
                        <i class="tji-user"></i>
                      </div>
                <div class="stat-number">{{ $showcase->teams->count() }}</div>
                <div class="stat-label">
                  @if(App::getLocale() == 'en')
                    Team Members
                  @else
                    أعضاء الفريق
                  @endif
                      </div>
                    </div>
                      </div>
            
                      </div>
          
          <!-- Related Services Widget -->
          @if($showcase->services && $showcase->services->count() > 0)
          <div class="sidebar-widget wow fadeInUp" data-wow-delay=".3s">
            <h4 class="widget-title">
              <img src="{{url('/pic/svg40.svg')}}">
              @if(App::getLocale() == 'en')
                Related Services
              @else
                الخدمات ذات الصلة
              @endif
            </h4>
            
            <div class="sidebar-services-list">
              @foreach($showcase->services->take(6) as $service)
                <div class="sidebar-service-item">
                  @if($service->icon)
                    <div class="sidebar-service-icon">
                      <img src="{{ asset('storage' . $service->icon) }}" alt="Service Icon">
                    </div>
                  @endif
                  <div class="sidebar-service-content">
                    <h6>
                      @if(App::getLocale() == 'en')
                        {{ $service->title_english }}
                      @else
                        {{ $service->title_arabic }}
                      @endif
                    </h6>
                    <a href="{{ route('services.show', $service->slug) }}" class="sidebar-service-link">
                      @if(App::getLocale() == 'en')
                        View Details
                      @else
                        عرض التفاصيل
                      @endif
                      <i class="tji-arrow-right-long"></i>
                    </a>
                      </div>
                    </div>
              @endforeach
                      </div>
            
                      </div>
          @endif
          
                      </div>
                    </div>

            </div>
          </div>
        </section>
<!-- end: Showcase Details Section -->

<!-- Portfolios & Projects Section -->
@if(($showcase->portfolios && $showcase->portfolios->count() > 0) || ($showcase->projects && $showcase->projects->count() > 0))
<section id="work" class="section-gap" style="padding-top: 20px;">
          <div class="container">
    <!-- Section Title -->
    <div class="text-center mb-5">
      <h3 class="section-header-center wow fadeInUp" data-wow-delay=".3s">
        <img src="{{url('/pic/svg40.svg')}}">
        @if(App::getLocale() == 'en')
          Related Work
        @else
          الأعمال ذات الصلة
        @endif
      </h3>
                </div>
    
            <div class="row">
      
      <!-- Portfolios Section (50%) -->
      @if($showcase->portfolios && $showcase->portfolios->count() > 0)
      <div class="col-lg-6">
        <div class="portfolio-projects-wrapper">
          <h3 class="section-header wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/svg40.svg')}}">
            @if(App::getLocale() == 'en')
              Related Portfolios
            @else
              المعارض ذات الصلة
            @endif
          </h3>
          
          <div class="portfolio-list">
            @foreach($showcase->portfolios as $portfolio)
              <div class="portfolio-list-item wow fadeInUp" data-wow-delay=".{{ 1 + ($loop->index * 0.1) }}s">
                <div class="portfolio-list-image">
                  @if($portfolio->main_image)
                    <img src="{{ asset('storage' . $portfolio->main_image) }}" alt="Portfolio">
                  @else
                    <img src="{{ asset('assets/images/project/default.webp') }}" alt="Default">
                  @endif
                  @if($portfolio->portfolioType)
                    <span class="portfolio-type-badge">
                      @if(App::getLocale() == 'en')
                        {{ $portfolio->portfolioType->name_english }}
                      @else
                        {{ $portfolio->portfolioType->name_arabic }}
                      @endif
                    </span>
                  @endif
                    </div>
                <div class="portfolio-list-content">
                  <h5>
                    <a href="{{ route('portfolios.show', $portfolio->slug) }}">
                      @if(App::getLocale() == 'en')
                        {{ $portfolio->title_english }}
                      @else
                        {{ $portfolio->title_arabic }}
                      @endif
                    </a>
                  </h5>
                  <a href="{{ route('portfolios.show', $portfolio->slug) }}" class="portfolio-list-link">
                    @if(App::getLocale() == 'en')
                      View Details
                    @else
                      عرض التفاصيل
                    @endif
                    <i class="tji-arrow-right-long"></i>
                  </a>
                    </div>
                  </div>
            @endforeach
                  </div>
                </div>
              </div>
      @endif
      
      <!-- Projects Section (50%) -->
      @if($showcase->projects && $showcase->projects->count() > 0)
      <div class="col-lg-6">
        <div class="portfolio-projects-wrapper">
          <h3 class="section-header wow fadeInUp" data-wow-delay=".3s">
            <img src="{{url('/pic/svg40.svg')}}">
            @if(App::getLocale() == 'en')
              Related Projects
            @else
              المشاريع ذات الصلة
            @endif
          </h3>
          
          <div class="portfolio-list">
            @foreach($showcase->projects as $project)
              <div class="portfolio-list-item wow fadeInUp" data-wow-delay=".{{ 1 + ($loop->index * 0.1) }}s">
                <div class="portfolio-list-image">
                  @if($project->main_image)
                    <img src="{{ asset('storage' . $project->main_image) }}" alt="Project">
                  @else
                    <img src="{{ asset('assets/images/project/default.webp') }}" alt="Default">
                  @endif
                    </div>
                <div class="portfolio-list-content">
                  <h5>
                    <a href="{{ route('projects.show', $project->slug) }}">
                      @if(App::getLocale() == 'en')
                        {{ $project->title_english }}
                      @else
                        {{ $project->title_arabic }}
                      @endif
                    </a>
                  </h5>
                  <a href="{{ route('projects.show', $project->slug) }}" class="portfolio-list-link">
                    @if(App::getLocale() == 'en')
                      View Details
                    @else
                      عرض التفاصيل
                    @endif
                    <i class="tji-arrow-right-long"></i>
                  </a>
                    </div>
                  </div>
            @endforeach
                  </div>
                </div>
              </div>
      @endif
      
                    </div>
                  </div>
</section>
@endif

<!-- Team Section -->
@if($showcase->teams && $showcase->teams->count() > 0)
<section id="team" class="section-gap" style="padding-top: 20px; padding-bottom: 20px;">
  <div class="container">
    <div class="text-center mb-5">
      <h3 class="section-header-center wow fadeInUp" data-wow-delay=".3s">
        <img src="{{url('/pic/svg40.svg')}}">
        @if(App::getLocale() == 'en')
          Team Members
        @else
          أعضاء الفريق
        @endif
      </h3>
                  </div>
    
    <div class="team-grid">
      @foreach($showcase->teams as $member)
        <div class="team-card wow fadeInUp" data-wow-delay=".{{ 1 + ($loop->index * 0.1) }}s">
          <div class="team-image">
            @if($member->main_image)
              <img src="{{ asset('storage' . $member->main_image) }}" alt="Team Member">
            @else
              <img src="{{ asset('assets/images/team/default.webp') }}" alt="Default">
            @endif
                  </div>
                  <div class="team-content">
            <h5>
              @if(App::getLocale() == 'en')
                {{ $member->name_english }}
              @else
                {{ $member->name_arabic }}
              @endif
            </h5>
            @if($member->jobTitle)
              <p class="team-job">
                @if(App::getLocale() == 'en')
                  {{ $member->jobTitle->name_english }}
                @else
                  {{ $member->jobTitle->name_arabic }}
                @endif
              </p>
            @endif
                  </div>
                </div>
      @endforeach
                    </div>
                  </div>
</section>
@endif

<!-- News Section -->
@if($showcase->news && $showcase->news->count() > 0)
<section id="news" class="section-gap" style="padding-top: 40px; padding-bottom: 30px; background: #f8f9fa; margin-top: 50px;">
  <div class="container">
    <div class="text-center mb-5">
      <h3 class="section-header-center wow fadeInUp" data-wow-delay=".3s">
        <img src="{{url('/pic/svg40.svg')}}">
        @if(App::getLocale() == 'en')
          Related News
        @else
          الأخبار ذات الصلة
        @endif
      </h3>
                  </div>
    
    <div class="news-grid">
      @foreach($showcase->news as $newsItem)
        <div class="news-card wow fadeInUp" data-wow-delay=".{{ 1 + ($loop->index * 0.1) }}s">
          <div class="news-image">
            @if($newsItem->page_image)
              <img src="{{ asset('storage' . $newsItem->page_image) }}" alt="News">
            @elseif($newsItem->image)
              <img src="{{ asset('storage' . $newsItem->image) }}" alt="News">
            @else
              <img src="{{ asset('assets/images/blog/default.webp') }}" alt="Default">
            @endif
                </div>
          <div class="news-content">
            <p class="news-date">
              {{ $newsItem->created_at->format('M d, Y') }}
            </p>
            <h5>
              <a href="#">
                @if(App::getLocale() == 'en')
                  {{ $newsItem->title_english }}
                @else
                  {{ $newsItem->title_arabic }}
                @endif
              </a>
            </h5>
                    </div>
                  </div>
      @endforeach
            </div>
          </div>
        </section>
@endif

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Mobile Navigation Toggle
  const navToggle = document.querySelector('.showcase-nav-toggle');
  const navList = document.querySelector('.showcase-nav-list');
  const navLinks = document.querySelectorAll('.showcase-nav-link');
  
  if (navToggle) {
    navToggle.addEventListener('click', function() {
      navList.classList.toggle('active');
    });
  }
  
  // Close mobile menu when clicking a link
  navLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 991) {
        navList.classList.remove('active');
      }
    });
  });
  
  // Active link on scroll
  const sections = document.querySelectorAll('section[id]');
  
  function setActiveLink() {
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
      const sectionHeight = section.offsetHeight;
      const sectionTop = section.offsetTop - 100;
      const sectionId = section.getAttribute('id');
      
      if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
        navLinks.forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('href') === '#' + sectionId) {
            link.classList.add('active');
          }
        });
      }
    });
  }
  
  window.addEventListener('scroll', setActiveLink);
  
  // Smooth scroll with offset
  navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('href');
      const targetSection = document.querySelector(targetId);
      
      if (targetSection) {
        const offsetTop = targetSection.offsetTop - 80;
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
      }
    });
  });
});
</script>
@endsection 
