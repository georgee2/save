{{-- Desktop Header - Hidden on mobile/tablet --}}
<header class="main-header navbar-light header-desktop">
      <div class="sticky-area">
        <div class="container">
          <nav class="navbar navbar-expand-lg px-0">
            <a class="navbar-brand" href="{{ route('index') }}">
              @if(app()->getLocale() == 'ar')
              <img style="max-width: 200px;max-height: 90px" src="{{ url('/pic/logos/logoar.png') }}" alt="{{ env('APP_NAME') }}">
              @else
              <img style="max-width: 200px;max-height: 90px" src="{{ url('/pic/logos/logoen.png') }}" alt="{{ env('APP_NAME') }}">
              @endif
            </a>
            <div class="collapse navbar-collapse mt-lg-0 mx-auto flex-grow-0" id="primaryMenu01">
              <ul class="navbar-nav hover-menu main-menu px-0 mx-lg-n4">
                <!-- Home Nav (No Child) -->
                <li id="navbar-item-home" aria-haspopup="false" aria-expanded="false"
        class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link p-0" href="{{ route('index') }}">
                    {{ __('lang.home') }}
                  </a>
                </li>
                <!-- Services Nav with Parent and Sub Services -->
                <li id="navbar-item-services" aria-haspopup="true" aria-expanded="false"
        class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link dropdown-toggle p-0"
           href="{{ route('services.index') }}" data-toggle="dropdown">
                    {{ __('lang.services') }}
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-services" style="min-width: 320px;">
                    <li class="dropdown-item">
                      <a class="dropdown-link font-weight-600" href="{{ route('services.index') }}">
                        <i class="fal fa-th-large mr-2"></i>
                        {{ __('lang.all_services') }}
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    @if(isset($headerServices) && $headerServices->count() > 0)
                      @foreach($headerServices as $headerService)
                        <li class="dropdown-item dropdown dropright">
                          <a id="navbar-link-service-{{ $headerService->id }}"
                       class="dropdown-link @if($headerService->subServices && $headerService->subServices->count() > 0) dropdown-toggle @endif"
                       href="{{ route('services.show', $headerService->slug) }}">
                            @if($headerService->icon)
                              <img src="{{ asset('storage' . $headerService->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                            @else
                              <i class="fal fa-cog mr-2"></i>
                            @endif
                            {{ app()->getLocale() == 'ar' ? $headerService->title_arabic : $headerService->title_english }}
                          </a>
                          @if($headerService->subServices && $headerService->subServices->count() > 0)
                            <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;"
                        aria-labelledby="navbar-link-service-{{ $headerService->id }}">
                              @foreach($headerService->subServices as $subService)
                                <li class="dropdown-item">
                                  <a class="dropdown-link" href="{{ route('services.show', $subService->slug) }}">
                                    @if($subService->icon)
                                      <img src="{{ asset('storage' . $subService->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                    @else
                                      <i class="fal fa-angle-right mr-2"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}
                                  </a>
                                </li>
                              @endforeach
                            </ul>
                          @endif
                        </li>
                      @endforeach
                    @endif
                  </ul>
                </li>
                <!-- Offers Nav with Categories and Subcategories -->
                <li id="navbar-item-offers" aria-haspopup="true" aria-expanded="false"
        class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link dropdown-toggle p-0"
           href="{{ route('offers.index') }}" data-toggle="dropdown">
                    {{ __('lang.offers') }}
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-offers" style="min-width: 320px;">
                    <li class="dropdown-item">
                      <a class="dropdown-link font-weight-600" href="{{ route('offers.index') }}">
                        <i class="fal fa-th-large mr-2"></i>
                        {{ __('lang.all_offers') }}
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    @if(isset($headerOfferCategories) && $headerOfferCategories->count() > 0)
                      @foreach($headerOfferCategories as $offerCategory)
                        <li class="dropdown-item dropdown dropright">
                          <a id="navbar-link-offer-category-{{ $offerCategory->id }}"
                       class="dropdown-link @if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0) dropdown-toggle @endif"
                       href="{{ route('offers.category', $offerCategory->slug) }}">
                            @if($offerCategory->icon)
                              <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                            @else
                              <i class="fal fa-tag mr-2"></i>
                            @endif
                            {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                          </a>
                          @if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0)
                            <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;"
                        aria-labelledby="navbar-link-offer-category-{{ $offerCategory->id }}">
                              @foreach($offerCategory->subCategories as $offerSubCategory)
                                <li class="dropdown-item">
                                  <a class="dropdown-link" href="{{ route('offers.subcategory', $offerSubCategory->slug) }}">
                                    @if($offerSubCategory->icon)
                                      <img src="{{ url('/storage' . $offerSubCategory->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                    @else
                                      <i class="fal fa-angle-right mr-2"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $offerSubCategory->title_arabic : $offerSubCategory->title_english }}
                                  </a>
                                </li>
                              @endforeach
                            </ul>
                          @endif
                        </li>
                      @endforeach
                    @endif
                  </ul>
                </li>
                <!-- Projects Nav with Categories and Subcategories -->
                <li id="navbar-item-projects" aria-haspopup="true" aria-expanded="false"
        class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link dropdown-toggle p-0"
           href="{{ route('projects.index') }}" data-toggle="dropdown">
                    Projects
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-projects" style="min-width: 320px;">
                    <li class="dropdown-item">
                      <a class="dropdown-link font-weight-600" href="{{ route('projects.index') }}">
                        <i class="fal fa-th-large mr-2"></i>
                        {{ __('lang.all_projects') }}
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    @if(isset($headerProjectCategories) && $headerProjectCategories->count() > 0)
                      @foreach($headerProjectCategories as $category)
                        <li class="dropdown-item dropdown dropright">
                          <a id="navbar-link-category-{{ $category->id }}"
                       class="dropdown-link @if($category->subCategories && $category->subCategories->count() > 0) dropdown-toggle @endif"
                       href="{{ route('category.show', $category->slug) }}">
                            @if($category->icon)
                              <img src="{{ url('/storage' . $category->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                            @endif
                            {{ $category->title_english }}
                          </a>
                          @if($category->subCategories && $category->subCategories->count() > 0)
                            <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;"
                        aria-labelledby="navbar-link-category-{{ $category->id }}">
                              @foreach($category->subCategories as $subCategory)
                                <li class="dropdown-item">
                                  <a class="dropdown-link" href="{{ route('subcategory.show', $subCategory->slug) }}">
                                    @if($subCategory->icon)
                                      <img src="{{ url('/storage' . $subCategory->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                    @endif
                                    {{ $subCategory->title_english }}
                                  </a>
                                </li>
                              @endforeach
                            </ul>
                          @endif
                        </li>
                      @endforeach
                    @endif
                  </ul>
                </li>
            
                <!-- News Nav with Categories -->
                <li hidden id="navbar-item-news" aria-haspopup="true" aria-expanded="false"
        class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link dropdown-toggle p-0"
           href="{{ route('blogs.index') }}" data-toggle="dropdown">
                    {{ __('lang.news') }}
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-news" style="min-width: 280px;">
                    <li class="dropdown-item">
                      <a class="dropdown-link font-weight-600" href="{{ route('blogs.index') }}">
                        <i class="fal fa-newspaper mr-2"></i>
                        {{ __('lang.all_news') }}
                      </a>
                    </li>
                    @if(isset($headerNewsCategories) && count($headerNewsCategories) > 0)
                      <li class="dropdown-divider"></li>
                      @foreach($headerNewsCategories as $newsCategory)
                        <li class="dropdown-item">
                          <a class="dropdown-link" href="{{ route('blogs.index', ['category' => $newsCategory->id]) }}">
                            <i class="fal fa-folder mr-2"></i>
                            {{ app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english }}
                          </a>
                        </li>
                      @endforeach
                    @endif
                  </ul>
                </li>
                
                <!-- About Nav with Team as Child -->
                <li id="navbar-item-about" aria-haspopup="true" aria-expanded="false"
        class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link dropdown-toggle p-0"
           href="{{ route('about') }}" data-toggle="dropdown">
                    {{ __('lang.about_us') }}
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-about" style="min-width: 250px;">
                    <li class="dropdown-item">
                      <a class="dropdown-link font-weight-600" href="{{ route('about') }}">
                        <i class="fal fa-info-circle mr-2"></i>
                        {{ __('lang.about_company') }}
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                      <a class="dropdown-link" href="{{ route('team.board') }}">
                        <i class="fal fa-user-tie mr-2"></i>
                        {{ __('lang.board_of_directors') }}
                      </a>
                    </li>
                    <li class="dropdown-item">
                      <a class="dropdown-link" href="{{ route('team.index') }}">
                        <i class="fal fa-users mr-2"></i>
                        {{ __('lang.our_team') }}
                      </a>
                    </li>
                    <li class="dropdown-item">
                      <a class="dropdown-link" href="{{ route('partners.index') }}">
                        <i class="fal fa-handshake mr-2"></i>
                        {{ __('lang.our_partners') }}
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                      <a class="dropdown-link" href="{{ route('branches.index') }}">
                        <i class="fal fa-building mr-2"></i>
                        {{ __('lang.our_branches') }}
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- Contact Nav (No Child) -->
                <li id="navbar-item-contact" aria-haspopup="false" aria-expanded="false"
        class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link p-0" href="{{ route('contact') }}">
                    {{ __('lang.contact_us') }}
                  </a>
                </li>

                <!-- Careers Nav (No Child) - Only show if there are active jobs -->
                @if(isset($hasActiveJobs) && $hasActiveJobs)
                <li hidden id="navbar-item-careers" aria-haspopup="false" aria-expanded="false"
        class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link p-0" href="{{ route('careers.index') }}">
                    {{ __('lang.careers') }}
                  </a>
                </li>
                @endif
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>

{{-- Mobile Header - Only visible on tablet and mobile --}}
<div class="mobile-header">
    <div class="mobile-header-content">
        {{-- Hamburger Menu Button --}}
        <button class="mobile-hamburger" id="mobileMenuToggle" aria-label="Toggle menu">
            <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
        
        {{-- Logo (Center) --}}
        <a href="{{ route('index') }}" class="mobile-header-logo">
            @if(app()->getLocale() == 'ar')
            <img src="{{ url('/pic/logos/logoar.png') }}" alt="{{ env('APP_NAME') }}">
            @else
            <img src="{{ url('/pic/logos/logoen.png') }}" alt="{{ env('APP_NAME') }}">
            @endif
        </a>
        
        {{-- Icons (Right) --}}
        <div class="mobile-header-icons">
            <a href="{{ route('contact') }}" class="mobile-header-icon" title="{{ __('lang.contact_us') }}">
                <i class="fal fa-envelope"></i>
            </a>
        </div>
    </div>
</div>

{{-- Mobile Sidebar Menu --}}
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
<nav class="mobile-sidebar" id="mobileSidebar">
    {{-- Sidebar Header --}}
    <div class="mobile-sidebar-header">
        <a href="{{ route('index') }}" class="mobile-sidebar-logo">
            @if(app()->getLocale() == 'ar')
            <img src="{{ url('/pic/logos/logoar.png') }}" alt="{{ env('APP_NAME') }}">
            @else
            <img src="{{ url('/pic/logos/logoen.png') }}" alt="{{ env('APP_NAME') }}">
            @endif
        </a>
        <button class="mobile-sidebar-close" id="mobileMenuClose" aria-label="Close menu">
            <i class="fal fa-times"></i>
        </button>
    </div>
    
    {{-- Sidebar Navigation --}}
    <div class="mobile-sidebar-nav">
        {{-- Home --}}
        <div class="mobile-nav-item">
            <a href="{{ route('index') }}" class="mobile-nav-link">
                {{ __('lang.home') }}
            </a>
        </div>
        
        {{-- Services --}}
        <div class="mobile-nav-item">
            <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                {{ __('lang.services') }}
                <i class="fal fa-chevron-right"></i>
            </a>
            <ul class="mobile-submenu">
                <li class="mobile-submenu-item">
                    <a href="{{ route('services.index') }}" class="mobile-submenu-link">
                        <i class="fal fa-th-large"></i>
                        {{ __('lang.all_services') }}
                    </a>
                </li>
                @if(isset($headerServices) && $headerServices->count() > 0)
                    @foreach($headerServices as $headerService)
                        @if($headerService->subServices && $headerService->subServices->count() > 0)
                        <li class="mobile-submenu-item">
                            <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                @if($headerService->icon)
                                <img src="{{ asset('storage' . $headerService->icon) }}" alt="">
                                @else
                                <i class="fal fa-cog"></i>
                                @endif
                                {{ app()->getLocale() == 'ar' ? $headerService->title_arabic : $headerService->title_english }}
                                <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                            </a>
                            <ul class="mobile-nested-submenu">
                                <li>
                                    <a href="{{ route('services.show', $headerService->slug) }}" class="mobile-nested-link">
                                        <i class="fal fa-arrow-right"></i>
                                        {{ __('lang.view_all') }}
                                    </a>
                                </li>
                                @foreach($headerService->subServices as $subService)
                                <li>
                                    <a href="{{ route('services.show', $subService->slug) }}" class="mobile-nested-link">
                                        @if($subService->icon)
                                        <img src="{{ asset('storage' . $subService->icon) }}" alt="">
                                        @else
                                        <i class="fal fa-angle-right"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <li class="mobile-submenu-item">
                            <a href="{{ route('services.show', $headerService->slug) }}" class="mobile-submenu-link">
                                @if($headerService->icon)
                                <img src="{{ asset('storage' . $headerService->icon) }}" alt="">
                                @else
                                <i class="fal fa-cog"></i>
                                @endif
                                {{ app()->getLocale() == 'ar' ? $headerService->title_arabic : $headerService->title_english }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        
        {{-- Offers --}}
        <div class="mobile-nav-item">
            <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                {{ __('lang.offers') }}
                <i class="fal fa-chevron-right"></i>
            </a>
            <ul class="mobile-submenu">
                <li class="mobile-submenu-item">
                    <a href="{{ route('offers.index') }}" class="mobile-submenu-link">
                        <i class="fal fa-th-large"></i>
                        {{ __('lang.all_offers') }}
                    </a>
                </li>
                @if(isset($headerOfferCategories) && $headerOfferCategories->count() > 0)
                    @foreach($headerOfferCategories as $offerCategory)
                        @if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0)
                        <li class="mobile-submenu-item">
                            <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                @if($offerCategory->icon)
                                <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="">
                                @else
                                <i class="fal fa-tag"></i>
                                @endif
                                {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                                <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                            </a>
                            <ul class="mobile-nested-submenu">
                                <li>
                                    <a href="{{ route('offers.category', $offerCategory->slug) }}" class="mobile-nested-link">
                                        <i class="fal fa-arrow-right"></i>
                                        {{ __('lang.view_all') }}
                                    </a>
                                </li>
                                @foreach($offerCategory->subCategories as $offerSubCategory)
                                <li>
                                    <a href="{{ route('offers.subcategory', $offerSubCategory->slug) }}" class="mobile-nested-link">
                                        @if($offerSubCategory->icon)
                                        <img src="{{ url('/storage' . $offerSubCategory->icon) }}" alt="">
                                        @else
                                        <i class="fal fa-angle-right"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? $offerSubCategory->title_arabic : $offerSubCategory->title_english }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <li class="mobile-submenu-item">
                            <a href="{{ route('offers.category', $offerCategory->slug) }}" class="mobile-submenu-link">
                                @if($offerCategory->icon)
                                <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="">
                                @else
                                <i class="fal fa-tag"></i>
                                @endif
                                {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        
        {{-- Projects --}}
        <div class="mobile-nav-item">
            <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                {{ __('lang.projects') }}
                <i class="fal fa-chevron-right"></i>
            </a>
            <ul class="mobile-submenu">
                <li class="mobile-submenu-item">
                    <a href="{{ route('projects.index') }}" class="mobile-submenu-link">
                        <i class="fal fa-th-large"></i>
                        {{ __('lang.all_projects') }}
                    </a>
                </li>
                @if(isset($headerProjectCategories) && $headerProjectCategories->count() > 0)
                    @foreach($headerProjectCategories as $category)
                        @if($category->subCategories && $category->subCategories->count() > 0)
                        <li class="mobile-submenu-item">
                            <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                @if($category->icon)
                                <img src="{{ url('/storage' . $category->icon) }}" alt="">
                                @endif
                                {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                                <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                            </a>
                            <ul class="mobile-nested-submenu">
                                <li>
                                    <a href="{{ route('category.show', $category->slug) }}" class="mobile-nested-link">
                                        <i class="fal fa-arrow-right"></i>
                                        {{ __('lang.view_all') }}
                                    </a>
                                </li>
                                @foreach($category->subCategories as $subCategory)
                                <li>
                                    <a href="{{ route('subcategory.show', $subCategory->slug) }}" class="mobile-nested-link">
                                        @if($subCategory->icon)
                                        <img src="{{ url('/storage' . $subCategory->icon) }}" alt="">
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? $subCategory->title_arabic : $subCategory->title_english }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <li class="mobile-submenu-item">
                            <a href="{{ route('category.show', $category->slug) }}" class="mobile-submenu-link">
                                @if($category->icon)
                                <img src="{{ url('/storage' . $category->icon) }}" alt="">
                                @endif
                                {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        
        {{-- News --}}
        <div class="mobile-nav-item">
            <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                {{ __('lang.news') }}
                <i class="fal fa-chevron-right"></i>
            </a>
            <ul class="mobile-submenu">
                <li class="mobile-submenu-item">
                    <a href="{{ route('blogs.index') }}" class="mobile-submenu-link">
                        <i class="fal fa-newspaper"></i>
                        {{ __('lang.all_news') }}
                    </a>
                </li>
                @if(isset($headerNewsCategories) && count($headerNewsCategories) > 0)
                    @foreach($headerNewsCategories as $newsCategory)
                    <li class="mobile-submenu-item">
                        <a href="{{ route('blogs.index', ['category' => $newsCategory->id]) }}" class="mobile-submenu-link">
                            <i class="fal fa-folder"></i>
                            {{ app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english }}
                        </a>
                    </li>
                    @endforeach
                @endif
            </ul>
        </div>
        
        {{-- About --}}
        <div class="mobile-nav-item">
            <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                {{ __('lang.about_us') }}
                <i class="fal fa-chevron-right"></i>
            </a>
            <ul class="mobile-submenu">
                <li class="mobile-submenu-item">
                    <a href="{{ route('about') }}" class="mobile-submenu-link">
                        <i class="fal fa-info-circle"></i>
                        {{ __('lang.about_company') }}
                    </a>
                </li>
                <li class="mobile-submenu-item">
                    <a href="{{ route('team.board') }}" class="mobile-submenu-link">
                        <i class="fal fa-user-tie"></i>
                        {{ __('lang.board_of_directors') }}
                    </a>
                </li>
                <li class="mobile-submenu-item">
                    <a href="{{ route('team.index') }}" class="mobile-submenu-link">
                        <i class="fal fa-users"></i>
                        {{ __('lang.our_team') }}
                    </a>
                </li>
                <li class="mobile-submenu-item">
                    <a href="{{ route('partners.index') }}" class="mobile-submenu-link">
                        <i class="fal fa-handshake"></i>
                        {{ __('lang.our_partners') }}
                    </a>
                </li>
                <li class="mobile-submenu-item">
                    <a href="{{ route('branches.index') }}" class="mobile-submenu-link">
                        <i class="fal fa-building"></i>
                        {{ __('lang.our_branches') }}
                    </a>
                </li>
            </ul>
        </div>
        
        {{-- Contact --}}
        <div class="mobile-nav-item">
            <a href="{{ route('contact') }}" class="mobile-nav-link">
                {{ __('lang.contact_us') }}
            </a>
        </div>
        
        {{-- Careers (if active jobs) --}}
        @if(isset($hasActiveJobs) && $hasActiveJobs)
        <div class="mobile-nav-item">
            <a href="{{ route('careers.index') }}" class="mobile-nav-link">
                {{ __('lang.careers') }}
            </a>
        </div>
        @endif
    </div>
    
    {{-- Sidebar Footer --}}
    <div class="mobile-sidebar-footer">
        <div class="mobile-sidebar-contact">
            @if(isset($contactInfo) && $contactInfo)
                @if($contactInfo->phone)
                <a href="tel:{{ $contactInfo->phone }}">
                    <i class="fal fa-phone"></i>
                    <span>{{ $contactInfo->phone }}</span>
                </a>
                @endif
                @if($contactInfo->email)
                <a href="mailto:{{ $contactInfo->email }}">
                    <i class="fal fa-envelope"></i>
                    <span>{{ $contactInfo->email }}</span>
                </a>
                @endif
            @endif
        </div>
        <div class="mobile-sidebar-social">
            @if(isset($contactInfo) && $contactInfo)
                @if($contactInfo->facebook)
                <a href="{{ $contactInfo->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if($contactInfo->instagram)
                <a href="{{ $contactInfo->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif
                @if($contactInfo->twitter)
                <a href="{{ $contactInfo->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                @endif
                @if($contactInfo->linkedin)
                <a href="{{ $contactInfo->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                @endif
                @if($contactInfo->youtube)
                <a href="{{ $contactInfo->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                @endif
            @endif
        </div>
    </div>
</nav>

{{-- Mobile Menu JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobileMenuToggle');
    const menuClose = document.getElementById('mobileMenuClose');
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('mobileMenuOverlay');
    const body = document.body;
    
    // Toggle menu
    function openMenu() {
        menuToggle.classList.add('active');
        sidebar.classList.add('active');
        overlay.classList.add('active');
        body.classList.add('mobile-menu-open');
    }
    
    function closeMenu() {
        menuToggle.classList.remove('active');
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        body.classList.remove('mobile-menu-open');
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });
    }
    
    if (menuClose) {
        menuClose.addEventListener('click', closeMenu);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeMenu);
    }
    
    // Submenu toggles
    const navToggles = document.querySelectorAll('.mobile-nav-toggle');
    navToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.mobile-nav-item, .mobile-submenu-item');
            if (parent) {
                parent.classList.toggle('open');
            }
        });
    });
    
    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            closeMenu();
        }
    });
});
</script>
