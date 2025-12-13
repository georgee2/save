@extends('layouts.master')
@section('title', __('lang.portfolio_page_title'))

@section('css')
<style>
/* Portfolio Type Filter Tabs */
.portfolio-filter-tabs {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 50px;
  padding: 0;
  list-style: none;
}

.portfolio-filter-tabs li {
  margin: 0;
}

.portfolio-filter-tabs a {
  display: inline-block;
  padding: 12px 30px;
  background: #f8f9fa;
  color: #2c3e50;
  border-radius: 50px;
  font-size: 15px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.portfolio-filter-tabs a:hover {
  background: #fff5f2;
  color: #ff5722;
  border-color: #ff5722;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(255, 87, 34, 0.2);
}

.portfolio-filter-tabs a.active {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  border-color: #ff5722;
  box-shadow: 0 5px 20px rgba(255, 87, 34, 0.3);
}

/* Mobile Dropdown Filter */
.mobile-filter-dropdown {
  display: none;
  margin-bottom: 30px;
}

.mobile-filter-dropdown select {
  width: 100%;
  padding: 15px 20px;
  border: 2px solid #f0f0f0;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  color: #2c3e50;
  background: white;
  cursor: pointer;
  transition: all 0.3s ease;
}

.mobile-filter-dropdown select:focus {
  border-color: #ff5722;
  outline: none;
  box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.1);
}

/* Project Item Styles */
.project-item {
  transition: all 0.4s ease;
  border-radius: 15px;
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
  background: white;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.project-item:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.project-item .project-img {
  height: 320px;
  overflow: hidden;
  position: relative;
}

.project-item .project-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.project-item:hover .project-img img {
  transform: scale(1.1);
}

.project-item .project-content {
  padding: 25px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.project-item .categories {
  display: inline-block;
  padding: 6px 16px;
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 15px;
  text-decoration: none;
  align-self: flex-start;
  transition: all 0.3s ease;
}

.project-item .categories:hover {
  transform: translateX(5px);
  box-shadow: 0 4px 15px rgba(255, 87, 34, 0.3);
}

.project-item .project-text {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: auto;
}

.project-item .project-text .title {
  font-size: 20px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0;
  flex: 1;
  line-height: 1.4;
}

.project-item .project-text .title a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s ease;
}

.project-item .project-text .title a:hover {
  color: #ff5722;
}

.project-item .project-btn {
  width: 45px;
  height: 45px;
  background: #fff5f2;
  color: #ff5722;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  transition: all 0.3s ease;
  margin-left: 15px;
  flex-shrink: 0;
}

.project-item:hover .project-btn {
  background: #ff5722;
  color: white;
  transform: rotate(45deg);
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 80px 40px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 15px;
}

.empty-state i {
  font-size: 64px;
  color: #ff5722;
  margin-bottom: 20px;
  opacity: 0.8;
}

.empty-state h4 {
  font-size: 24px;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 15px;
}

.empty-state p {
  font-size: 16px;
  color: #666;
  margin: 0;
}

/* Pagination Styles */
.tj-pagination ul {
  display: flex;
  align-items: center;
  gap: 10px;
  list-style: none;
  padding: 0;
  margin: 0;
}

.tj-pagination ul li {
  margin: 0;
}

.tj-pagination ul li a,
.tj-pagination ul li span {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 45px;
  height: 45px;
  padding: 0 15px;
  background: #fff;
  color: #2c3e50;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}

.tj-pagination ul li a:hover {
  background: #ff5722;
  color: white;
  border-color: #ff5722;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 87, 34, 0.3);
}

.tj-pagination ul li span.current {
  background: #ff5722;
  color: white;
  border-color: #ff5722;
  box-shadow: 0 4px 12px rgba(255, 87, 34, 0.3);
}

.tj-pagination ul li.disabled span {
  background: #f5f5f5;
  color: #ccc;
  border-color: #e0e0e0;
  cursor: not-allowed;
}

.tj-pagination ul li a i {
  font-size: 14px;
}

/* Responsive Styles */
@media (max-width: 991px) {
  .portfolio-filter-tabs {
    display: none;
  }
  
  .mobile-filter-dropdown {
    display: block;
  }
  
  .project-item .project-img {
    height: 280px;
  }
}

@media (max-width: 767px) {
  .project-item .project-img {
    height: 240px;
  }
  
  .project-item .project-content {
    padding: 20px;
  }
  
  .project-item .project-text .title {
    font-size: 18px;
  }
}
</style>
@endsection

@section('content')

<!-- start: Breadcrumb Section -->
<section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">{{ __('lang.portfolio_page_title') }}</h1>
          <div class="tj-page-link">
            <span><i class="tji-home"></i></span>
            <span>
              <a href="{{ url('/') }}">{{ __('lang.home') }}</a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              {{ __('lang.portfolio') }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
</section>
<!-- end: Breadcrumb Section -->

<!-- start: Portfolio Section -->
<section class="tj-project-section section-gap">
  <div class="container">
    
    <!-- Desktop Tabs Filter -->
    <ul class="portfolio-filter-tabs">
      <li>
        <a href="{{ route('portfolios.index') }}" class="{{ !request('type') ? 'active' : '' }}">
          {{ __('lang.all_projects') }}
        </a>
      </li>
      @foreach($portfolioTypes as $type)
        <li>
          <a href="{{ route('portfolios.index', ['type' => $type->id]) }}" 
             class="{{ request('type') == $type->id ? 'active' : '' }}">
            @if(App::getLocale() == 'en')
              {{ $type->name_english }}
            @else
              {{ $type->name_arabic }}
            @endif
          </a>
        </li>
      @endforeach
    </ul>
    
    <!-- Mobile Dropdown Filter -->
    <div class="mobile-filter-dropdown">
      <select onchange="window.location.href=this.value" class="form-select">
        <option value="{{ route('portfolios.index') }}" {{ !request('type') ? 'selected' : '' }}>
          {{ __('lang.all_projects') }}
        </option>
        @foreach($portfolioTypes as $type)
          <option value="{{ route('portfolios.index', ['type' => $type->id]) }}" 
                  {{ request('type') == $type->id ? 'selected' : '' }}>
            @if(App::getLocale() == 'en')
              {{ $type->name_english }}
            @else
              {{ $type->name_arabic }}
            @endif
          </option>
        @endforeach
      </select>
    </div>
    
    <!-- Portfolio Items -->
    @if($portfolios->count() > 0)
      <div class="row row-gap-4">
        @foreach($portfolios as $index => $portfolio)
          <div class="col-xl-4 col-md-6">
            <div class="project-item wow fadeInUp" data-wow-delay="{{ 0.1 + ($index % 3) * 0.2 }}s">
              <div class="project-img">
                @if($portfolio->main_image)
                  <img src="{{ asset('storage' . $portfolio->main_image) }}" 
                       alt="@if(App::getLocale() == 'en'){{ $portfolio->title_english }}@else{{ $portfolio->title_arabic }}@endif">
                @else
                  <img src="{{ asset('assets/images/project/default.webp') }}" alt="Default Image">
                @endif
              </div>
              <div class="project-content">
                <span class="categories">
                  @if(App::getLocale() == 'en')
                    {{ $portfolio->portfolioType->name_english ?? 'Uncategorized' }}
                  @else
                    {{ $portfolio->portfolioType->name_arabic ?? 'غير مصنف' }}
                  @endif
                </span>
                <div class="project-text">
                  <h4 class="title">
                    <a href="{{ route('portfolios.show', $portfolio->slug) }}">
                      @if(App::getLocale() == 'en')
                        {{ $portfolio->title_english }}
                      @else
                        {{ $portfolio->title_arabic }}
                      @endif
                    </a>
                  </h4>
                  <a class="project-btn" href="{{ route('portfolios.show', $portfolio->slug) }}">
                    <i class="tji-arrow-right-big"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      
      <!-- Pagination -->
      @if($portfolios->hasPages())
        <div class="tj-pagination d-flex justify-content-center" style="margin-top: 50px;">
          <ul>
            {{-- Previous Page Link --}}
            @if ($portfolios->onFirstPage())
              <li class="disabled"><span><i class="tji-arrow-left"></i></span></li>
            @else
              <li><a href="{{ $portfolios->previousPageUrl() }}"><i class="tji-arrow-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($portfolios->getUrlRange(1, $portfolios->lastPage()) as $page => $url)
              @if ($page == $portfolios->currentPage())
                <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
              @else
                <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
              @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($portfolios->hasMorePages())
              <li><a class="next page-numbers" href="{{ $portfolios->nextPageUrl() }}"><i class="tji-arrow-right"></i></a></li>
            @else
              <li class="disabled"><span><i class="tji-arrow-right"></i></span></li>
            @endif
          </ul>
        </div>
      @endif
    @else
      <!-- Empty State -->
      <div class="empty-state">
        <i class="fa fa-folder-open"></i>
        <h4>
          @if(App::getLocale() == 'en')
            No Portfolios Found
          @else
            لا توجد مشاريع
          @endif
        </h4>
        <p>
          @if(App::getLocale() == 'en')
            There are no portfolio items available at the moment.
          @else
            لا توجد مشاريع متاحة في الوقت الحالي.
          @endif
        </p>
      </div>
    @endif
    
  </div>
</section>
<!-- end: Portfolio Section -->

@endsection
