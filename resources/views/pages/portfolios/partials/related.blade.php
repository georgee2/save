<!-- Latest Portfolio Widget -->
<div class="sidebar-widget wow fadeInUp" data-wow-delay=".3s">
  <h4 class="widget-title">
    <img src="{{url('/pic/svg40.svg')}}">
    {{ __('lang.latest_projects') }}
  </h4>
  
  @php
    $latestPortfolios = \App\Models\Portfolio::with('portfolioType')
      ->where('status', 0)
      ->where('id', '!=', $portfolio->id)
      ->whereNull('deleted_at')
      ->orderBy('created_at', 'DESC')
      ->limit(3)
      ->get();
  @endphp
  
  <div class="latest-portfolio-list">
    @foreach($latestPortfolios as $item)
      <div class="portfolio-widget-item">
        <div class="portfolio-widget-img">
          <a href="{{ route('portfolios.show', $item->slug) }}">
            @if($item->main_image)
              <img src="{{ asset('storage' . $item->main_image) }}" 
                   alt="@if(App::getLocale() == 'en'){{ $item->title_english }}@else{{ $item->title_arabic }}@endif">
            @else
              <img src="{{ asset('assets/images/project/default.webp') }}" alt="Default Image">
            @endif
          </a>
        </div>
        <div class="portfolio-widget-content">
          <span class="portfolio-widget-category">
            @if(App::getLocale() == 'en')
              {{ $item->portfolioType->name_english ?? __('lang.uncategorized') }}
            @else
              {{ $item->portfolioType->name_arabic ?? __('lang.uncategorized') }}
            @endif
          </span>
          <h6 class="portfolio-widget-title">
            <a href="{{ route('portfolios.show', $item->slug) }}">
              @if(App::getLocale() == 'en')
                {{ Str::limit($item->title_english, 50) }}
              @else
                {{ Str::limit($item->title_arabic, 50) }}
              @endif
            </a>
          </h6>
        </div>
      </div>
    @endforeach
  </div>
  
  <div class="view-all-btn">
    <a href="{{ route('portfolios.index') }}" class="tj-primary-btn btn-sm">
      <span class="btn-text">
        <span>{{ __('lang.view_all') }}</span>
      </span>
      <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
    </a>
  </div>
</div>

<style>
/* Latest Portfolio Widget Styles */
.latest-portfolio-list {
  margin-top: 20px;
}

.portfolio-widget-item {
  display: flex;
  align-items: flex-start;
  padding: 15px 0;
  border-bottom: 1px solid #f0f0f0;
  transition: all 0.3s ease;
}

.portfolio-widget-item:last-child {
  border-bottom: none;
}

.portfolio-widget-item:hover {
  transform: translateX(5px);
}

.portfolio-widget-img {
  width: 80px;
  height: 80px;
  border-radius: 10px;
  overflow: hidden;
  flex-shrink: 0;
  margin-right: 15px;
}

.portfolio-widget-img a {
  display: block;
  width: 100%;
  height: 100%;
}

.portfolio-widget-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.portfolio-widget-item:hover .portfolio-widget-img img {
  transform: scale(1.1);
}

.portfolio-widget-content {
  flex: 1;
}

.portfolio-widget-category {
  display: inline-block;
  font-size: 11px;
  color: #ff5722;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 5px;
}

.portfolio-widget-title {
  font-size: 15px;
  font-weight: 600;
  color: #2c3e50;
  margin: 0;
  line-height: 1.4;
}

.portfolio-widget-title a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s ease;
}

.portfolio-widget-title a:hover {
  color: #ff5722;
}

.view-all-btn {
  margin-top: 20px;
  text-align: center;
}

.view-all-btn .tj-primary-btn {
  width: 100%;
  justify-content: center;
  padding: 12px 20px;
  font-size: 14px;
}

@media (max-width: 991px) {
  .portfolio-widget-img {
    width: 70px;
    height: 70px;
  }
  
  .portfolio-widget-title {
    font-size: 14px;
  }
}
</style>
