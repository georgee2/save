<!-- start: Header Area -->
  <header class="header-area header-1 header-absolute  section-gap-x">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="header-wrapper">
            <!-- site logo -->
            <div class="site_logo">
              <a class="logo" href="{{ route('index') }}"><img src="{{url('/pic/logo.png')}}" alt=""></a>
            </div>

            <!-- navigation -->
            <div class="menu-area d-none d-lg-inline-flex align-items-center">
              <nav id="mobile-menu" class="mainmenu">
                <ul>
                  <!-- Home -->
                  <li class="{{ request()->routeIs('index') ? 'current-menu-item' : '' }}">
                    <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                  </li>
                  
                  <!-- About -->
                  <li class="has-dropdown {{ request()->routeIs('about') || request()->routeIs('team.*') ? 'current-menu-ancestor' : '' }}">
                    <a href="{{ route('about') }}">{{ __('lang.about_us') }}</a>
                    <ul class="sub-menu">
                      <li class="{{ request()->routeIs('about') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('about') }}">{{ __('lang.about_us') }}</a>
                      </li>
                      <li class="{{ request()->routeIs('team.*') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('team.index') }}">{{ __('lang.our_team') }}</a>
                      </li>
                    </ul>
                  </li>
                  
                  <!-- Services -->
                  <li class="has-dropdown {{ request()->routeIs('services.*') ? 'current-menu-ancestor' : '' }}">
                    <a href="{{route('services.index')}}">{{ __('lang.services') }}</a>
                    <ul class="sub-menu  mega-menu-service">
                      @if(isset($headerServices) && $headerServices->count() > 0)
                        @foreach($headerServices as $service)
                          <li>
                            <a class="mega-menu-service-single {{ request()->is('services/' . $service->slug) ? 'active' : '' }}" href="{{ route('services.show', ['slug' => $service->slug]) }}">
                              <span class="mega-menu-service-icon">
                                @if($service->icon)
                                  <img src="{{ asset('storage' . $service->icon) }}" alt="{{ App::getLocale() == 'en' ? $service->title_english : $service->title_arabic }}" style="width: 40px; height: 40px; object-fit: contain;">
                                @else
                                  <i class="tji-service-1"></i>
                                @endif
                              </span>
                              <span class="mega-menu-service-title">
                                {{ App::getLocale() == 'en' ? $service->title_english : $service->title_arabic }}
                              </span>
                              <span class="mega-menu-service-nav">
                                <i class="tji-arrow-right-long"></i>
                                <i class="tji-arrow-right-long"></i>
                              </span>
                            </a>
                          </li>
                        @endforeach
                      @endif
                    </ul>
                  </li>
                  
                  <!-- Projects -->
                  @if(isset($hasPublishedProjects) && $hasPublishedProjects)
                  <li class="has-dropdown {{ request()->routeIs('projects.*') ? 'current-menu-ancestor' : '' }}">
                    <a href="{{ route('projects.index') }}">{{ __('lang.projects') }}</a>
                    <ul class="sub-menu  mega-menu-service">
                      @if(isset($headerProjectCategories) && $headerProjectCategories->count() > 0)
                        @foreach($headerProjectCategories as $category)
                          <li>
                            <a class="mega-menu-service-single {{ request()->input('category') == $category->id ? 'active' : '' }}" href="{{ route('projects.index', ['category' => $category->id]) }}">
                              <span class="mega-menu-service-icon">
                                @if($category->icon)
                                  <img src="{{ asset('storage' . $category->icon) }}" alt="{{ App::getLocale() == 'en' ? $category->title_english : $category->title_arabic }}" style="width: 40px; height: 40px; object-fit: contain;">
                                @else
                                  <i class="tji-service-1"></i>
                                @endif
                              </span>
                              <span class="mega-menu-service-title">
                                {{ App::getLocale() == 'en' ? $category->title_english : $category->title_arabic }}
                              </span>
                              <span class="mega-menu-service-nav">
                                <i class="tji-arrow-right-long"></i>
                                <i class="tji-arrow-right-long"></i>
                              </span>
                            </a>
                          </li>
                        @endforeach
                      @endif
                    </ul>
                  </li>
                  @endif
                  
                  <!-- Portfolios -->
                  @if(isset($hasPublishedPortfolios) && $hasPublishedPortfolios)
                  <li class="has-dropdown {{ request()->routeIs('portfolios.*') ? 'current-menu-ancestor' : '' }}">
                    <a href="{{ route('portfolios.index') }}">{{ __('lang.portfolio') }}</a>
                    <ul class="sub-menu">
                      @if(isset($headerPortfolios) && $headerPortfolios->count() > 0)
                        @foreach($headerPortfolios as $portfolio)
                          <li class="{{ request()->is('portfolios/' . $portfolio->slug) ? 'current-menu-item' : '' }}">
                            <a href="{{ route('portfolios.show', ['slug' => $portfolio->slug]) }}">
                              {{ App::getLocale() == 'en' ? $portfolio->title_english : $portfolio->title_arabic }}
                            </a>
                          </li>
                        @endforeach
                      @endif
                      <li class="{{ request()->routeIs('portfolios.index') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('portfolios.index') }}">{{ __('lang.view_all') }}</a>
                      </li>
                    </ul>
                  </li>
                  @endif
                  
                  <!-- Blogs -->
                  @if(isset($hasBlogs) && $hasBlogs)
                  <li class="has-dropdown {{ request()->routeIs('blogs.*') ? 'current-menu-ancestor' : '' }}">
                    <a href="{{ route('blogs.index') }}">{{ __('lang.blog') }}</a>
                    <ul class="sub-menu">
                      @if(isset($headerBlogCategories) && $headerBlogCategories->count() > 0)
                        @foreach($headerBlogCategories as $category)
                          <li class="{{ request()->input('category') == $category->id ? 'current-menu-item' : '' }}">
                            <a href="{{ route('blogs.index', ['category' => $category->id]) }}">
                              {{ App::getLocale() == 'en' ? $category->name_english : $category->name_arabic }}
                            </a>
                          </li>
                        @endforeach
                      @endif
                      <li class="{{ request()->routeIs('blogs.index') && !request()->has('category') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('blogs.index') }}">{{ __('lang.all_blogs') }}</a>
                      </li>
                    </ul>
                  </li>
                  @endif
                  
                  <!-- Contact -->
                  <li class="{{ request()->routeIs('contact') ? 'current-menu-item' : '' }}">
                    <a href="{{ route('contact') }}">{{ __('lang.contact') }}</a>
                  </li>
                  
                  <!-- Careers -->
                  <li class="{{ request()->routeIs('careers.*') ? 'current-menu-item' : '' }}">
                    <a href="{{ route('careers.index') }}">{{ __('lang.careers') }}</a>
                  </li>
                </ul>
              </nav>
            </div>

            <!-- header right info -->
            <div class="header-right-item d-none d-lg-inline-flex">
              <div class="header-search">
                <button class="search">
                  <i class="tji-search"></i>
                </button>
                <button type="button" class="search_close_btn">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round" />
                    <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
              </div>
              <div class="header-button">
                <a class="tj-primary-btn" href="{{ route('contact') }}">
                  <span class="btn-text"><span>{{ __('lang.lets_talk') }}</span></span>
                  <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                </a>
              </div>
              <div class="menu_bar menu_offcanvas d-none d-lg-inline-flex">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>

            <!-- menu bar -->
            <div class="menu_bar mobile_menu_bar d-lg-none">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Search Popup -->
    <div class="search_popup">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-8">
            <div class="tj_search_wrapper">
              <div class="search_form">
                <form action="{{ route('blogs.index') }}" method="GET">
                  <div class="search_input">
                    <div class="search-box">
                      <input class="search-form-input" name="search" type="text" placeholder="{{ __('lang.type_and_hit_enter') }}" required>
                      <button type="submit">
                        <i class="tji-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- end: Header Area -->

  <style>
    /* Make service and project icons white on hover */
    .mega-menu-service-single:hover .mega-menu-service-icon img {
      filter: brightness(0) invert(1);
      transition: filter 0.3s ease;
    }
    
    .mega-menu-service-single .mega-menu-service-icon img {
      transition: filter 0.3s ease;
    }
    
    /* Make default icons white on hover too */
    .mega-menu-service-single:hover .mega-menu-service-icon i {
      color: #ffffff !important;
      transition: color 0.3s ease;
    }
    
    .mega-menu-service-single .mega-menu-service-icon i {
      transition: color 0.3s ease;
    }
  </style>


