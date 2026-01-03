<header class="main-header navbar-light header-sticky header-sticky-smart header-mobile-lg">
      <div class="sticky-area">
        <div class="container">
          <nav class="navbar navbar-expand-lg px-0">
            <a class="navbar-brand" href="{{ route('index') }}">
              @if(app()->getLocale() == 'ar')
              <img style="max-width: 200px;max-height: 90px" src="{{ url('/pic/logos/logoar.png') }}" alt="{{ env('APP_NAME') }}"
                         class="d-none d-lg-inline-block">
              <img style="max-width: 150px;max-height: 70px" src="{{ url('/pic/logos/logoar.png') }}" alt="{{ env('APP_NAME') }}"
                         class="d-inline-block d-lg-none">
              @else
              <img style="max-width: 200px;max-height: 90px" src="{{ url('/pic/logos/logoen.png') }}" alt="{{ env('APP_NAME') }}"
                         class="d-none d-lg-inline-block">
              <img style="max-width: 150px;max-height: 70px" src="{{ url('/pic/logos/logoen.png') }}" alt="{{ env('APP_NAME') }}"
                         class="d-inline-block d-lg-none">
              @endif
            </a>
            <div class="d-flex d-lg-none ml-auto">
              <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse"
                            data-target="#primaryMenu01"
                            aria-controls="primaryMenu01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="text-white fs-24"><i class="fal fa-bars"></i></span>
              </button>
            </div>
            <div class="collapse navbar-collapse mt-3 mt-lg-0 mx-auto flex-grow-0" id="primaryMenu01">
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
                <li id="navbar-item-news" aria-haspopup="true" aria-expanded="false"
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
                <li id="navbar-item-careers" aria-haspopup="false" aria-expanded="false"
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