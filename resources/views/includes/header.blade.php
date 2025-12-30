<header class="main-header navbar-light header-sticky header-sticky-smart header-mobile-lg">
      <div class="sticky-area">
        <div class="container">
          <nav class="navbar navbar-expand-lg px-0">
            <a class="navbar-brand" href=".">
              <img style="max-width: 200px;max-height: 90px" src="{{url('/pic/logo.png')}}" alt="HomeID"
                         class="d-none d-lg-inline-block">
              <img src="images/logo-white.png" alt="HomeID"
                         class="d-inline-block d-lg-none">
            </a>
            <div class="d-flex d-lg-none ml-auto">
              <a class="mr-4 position-relative text-white p-2" href="#">
                <i class="fal fa-heart fs-large-4"></i>
                <span class="badge badge-primary badge-circle badge-absolute">1</span>
              </a>
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
                    Home
                  </a>
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
                <!-- About Nav (No Child) -->
                <li id="navbar-item-about" aria-haspopup="false" aria-expanded="false"
        class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link p-0" href="{{ route('about') }}">
                    {{ __('lang.about_us') }}
                  </a>
                </li>
                <!-- Contact Nav (No Child) -->
                <li id="navbar-item-contact" aria-haspopup="false" aria-expanded="false"
        class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                  <a class="nav-link p-0" href="{{ route('contact') }}">
                    {{ __('lang.contact_us') }}
                  </a>
                </li>
              </ul>
              <div class="d-block d-lg-none">
                <ul class="navbar-nav flex-row justify-content-lg-end d-flex flex-wrap py-2">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-md-2 pr-2 pl-0 pl-lg-2"
           href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      ENG
                    </a>
                    <div class="dropdown-menu dropdown-sm dropdown-menu-left">
                      <a class="dropdown-item" href="#">VN</a>
                      <a class="dropdown-item active" href="#">ENG</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">ARB</a>
                      <a class="dropdown-item" href="#">KR</a>
                      <a class="dropdown-item" href="#">JN</a>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link  px-2" data-toggle="modal" href="#login-register-modal">SIGN IN</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <ul class="navbar-nav flex-row justify-content-lg-end d-flex flex-wrap text-body py-2">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle mr-md-2 pr-2 pl-0 pl-lg-2"
           href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ENG
                  </a>
                  <div class="dropdown-menu dropdown-sm dropdown-menu-right">
                    <a class="dropdown-item" href="#">VN</a>
                    <a class="dropdown-item active" href="#">ENG</a>
                    <a class="dropdown-item" href="#">ARB</a>
                    <a class="dropdown-item" href="#">KR</a>
                    <a class="dropdown-item" href="#">JN</a>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link  px-2" data-toggle="modal" href="#login-register-modal">SIGN IN</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link px-2 position-relative" href="#">
                    <i class="fal fa-heart fs-large-4"></i>
                    <span class="badge badge-primary badge-circle badge-absolute">1</span>
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>