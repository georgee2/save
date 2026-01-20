@extends('layouts.master')
@section('title' , app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english)
@section('seo_desc', app()->getLocale() == 'ar' ? $category->bio_arabic : $category->bio_english)
@section('seo_tags', app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english)
@section('content')


<section class="pb-8 page-title shadow">
        <div class="container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
              <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
              <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('lang.projects') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}</li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}</h1>
          </nav>
        </div>
      </section>

      {{-- Subcategory Filter Slider --}}
      @if(isset($subcategoriesWithCount) && $subcategoriesWithCount->count() > 0)
      <section class="subcategory-filter-section">
        <div class="container">
          <div class="subcategory-filter-slider slick-slider" 
               data-slick-options='{"slidesToShow": 6, "slidesToScroll": 2, "autoplay": false, "dots": false, "arrows": true, "infinite": false, "responsive":[{"breakpoint": 1400,"settings": {"slidesToShow": 5, "arrows": true}},{"breakpoint": 1200,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 992,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 768,"settings": {"slidesToShow": 3, "arrows": true}},{"breakpoint": 576,"settings": {"slidesToShow": 2, "arrows": false}}]}'>
            
            {{-- All Subcategories Option --}}
            <div class="box">
              <a href="{{ route('category.show', ['slug' => $category->slug, 'sortby' => request('sortby')]) }}" 
                 class="subcategory-filter-item all-item {{ !request('subcategory_id') ? 'active' : '' }}">
                <div class="subcategory-filter-icon">
                  <i class="fas fa-th-large"></i>
                </div>
                <p class="subcategory-filter-title">{{ __('lang.all') }}</p>
                <span class="subcategory-filter-count">{{ $projects->total() }} {{ __('lang.projects') }}</span>
              </a>
            </div>
            
            {{-- Subcategory Items --}}
            @foreach($subcategoriesWithCount as $subcat)
            <div class="box">
              <a href="{{ route('subcategory.show', $subcat->slug) }}" 
                 class="subcategory-filter-item {{ request('subcategory_id') == $subcat->id ? 'active' : '' }}">
                <div class="subcategory-filter-icon">
                  @if($subcat->icon)
                  <img src="{{ url('/storage' . $subcat->icon) }}" 
                       alt="{{ app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english }}">
                  @else
                  <i class="fas fa-folder"></i>
                  @endif
                </div>
                <p class="subcategory-filter-title">{{ app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english }}</p>
                <span class="subcategory-filter-count">{{ $subcat->projects_count }} {{ __('lang.projects') }}</span>
              </a>
            </div>
            @endforeach
            
          </div>
        </div>
      </section>
      @endif




      <section class="pt-8 pb-11">
        <div class="container">
          {{-- Mobile Filter Overlay --}}
          <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>
          
          <div class="row">
            {{-- Main Projects Container --}}
            <div class="projects-main-container filter-hidden mb-8 mb-lg-0" id="projectsContainer">
              <div class="row align-items-sm-center mb-6">
                <div class="col-md-6">
                  <h2 class="fs-15 text-dark mb-0">{{ __('lang.we_found') }} <span class="text-primary">{{ $projects->total() }}</span> {{ __('lang.projects_available') }}</h2>
                </div>
                <div class="col-md-6 mt-6 mt-md-0">
                  <div class="d-flex justify-content-md-end align-items-center flex-wrap">
                    {{-- Filter Toggle Button --}}
                    <button type="button" class="filter-toggle-btn mr-3" id="filterToggleBtn">
                      <i class="fas fa-filter"></i>
                      <span class="d-none d-sm-inline">{{ __('lang.filter') }}</span>
                      @php
                        $activeFilters = 0;
                        if(request('keyword')) $activeFilters++;
                        if(request('subcategory_id')) $activeFilters++;
                        if(request('style_id')) $activeFilters++;
                        if(request('type_id')) $activeFilters++;
                        if(request('sqft_min') || request('sqft_max')) $activeFilters++;
                        if(request('sqm_min') || request('sqm_max')) $activeFilters++;
                        if(request('specification_id')) $activeFilters++;
                      @endphp
                      @if($activeFilters > 0)
                      <span class="filter-count">{{ $activeFilters }}</span>
                      @endif
                    </button>
                    
                    <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                      <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3"
								       for="sortbySelect"><i
										class="fas fa-align-left fs-16 pr-2"></i><span class="d-none d-sm-inline">{{ __('lang.sortby') }}:</span></label>
                      <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby-select"
								        data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3"
								        id="sortbySelect" name="sortby">
                        <option value="newest" {{ request('sortby', 'newest') == 'newest' ? 'selected' : '' }}>{{ __('lang.newest') }}</option>
                        <option value="oldest" {{ request('sortby') == 'oldest' ? 'selected' : '' }}>{{ __('lang.oldest') }}</option>
                        <option value="area_low" {{ request('sortby') == 'area_low' ? 'selected' : '' }}>{{ __('lang.area_low_to_high') }}</option>
                        <option value="area_high" {{ request('sortby') == 'area_high' ? 'selected' : '' }}>{{ __('lang.area_high_to_low') }}</option>
                      </select>
                    </div>
                    <div class="d-none d-md-block">
                      <a class="fs-sm-18 text-dark view-toggle" href="#" id="listViewBtn" data-view="list">
                        <i class="fas fa-list"></i>
                      </a>
                      <a class="fs-sm-18 text-dark ml-5 view-toggle active" href="#" id="gridViewBtn" data-view="grid">
                        <i class="fa fa-th-large"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              
              {{-- Grid View --}}
              <div class="row" id="gridView">
                @forelse($projects as $project)
                <div class="col-md-6 mb-6">
                  <div class="card border-0 shadow-hover-2" data-animate="fadeInUp">
                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                      <img src="{{ url('/storage' . $project->main_image) }}"
								     alt="{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}">
                      <div class="card-img-overlay p-2 d-flex flex-column">
                        <div>
                          @if($project->home_status == 0)
                          <span class="badge badge-primary">{{ __('lang.featured') }}</span>
                          @else
                          <span class="badge badge-indigo">{{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}</span>
                          @endif
                        </div>
                        <ul class="list-inline mb-0 mt-auto hover-image">
                          @if($project->total_images > 0)
                          <li class="list-inline-item mr-2" data-toggle="tooltip" title="{{ $project->total_images }} {{ __('lang.images') }}">
                              <a href="{{ route('projects.show', $project->slug) }}" class="text-white hover-primary">
                              <i class="far fa-images"></i><span class="pl-1">{{ $project->total_images }}</span>
                              </a>
                            </li>
                          @endif
                          @if($project->video_count > 0)
                          <li class="list-inline-item" data-toggle="tooltip" title="{{ $project->video_count }} {{ __('lang.videos') }}">
                              <a href="{{ route('projects.show', $project->slug) }}" class="text-white hover-primary">
                              <i class="far fa-play-circle"></i><span class="pl-1">{{ $project->video_count }}</span>
                              </a>
                            </li>
                          @endif
                          </ul>
                      </div>
                    </div>
                    
                    {{-- Share Badge --}}
                    <div class="project-share-badge">
                        <div class="share-actions">
                            {{-- Share Slide Out --}}
                            <div class="share-slide-wrapper">
                                <button type="button" class="share-action-btn share-slide-btn">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                                <div class="share-slide-icons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('projects.show', $project->slug)) }}" 
                                       target="_blank" class="share-action-btn facebook-btn">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('projects.show', $project->slug)) }}&text={{ urlencode(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english) }}" 
                                       target="_blank" class="share-action-btn twitter-btn">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('projects.show', $project->slug)) }}" 
                                       target="_blank" class="share-action-btn linkedin-btn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="https://www.instagram.com/" 
                                       target="_blank" class="share-action-btn instagram-btn">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="mailto:?subject={{ rawurlencode(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english) }}&body={{ urlencode(route('projects.show', $project->slug)) }}" 
                                       class="share-action-btn email-btn">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- WhatsApp Separate --}}
                            <a href="https://wa.me/?text={{ urlencode(route('projects.show', $project->slug)) }}" 
                               target="_blank" 
                               class="share-action-btn whatsapp-share-btn" 
                               data-toggle="tooltip" 
                               data-placement="top"
                               title="{{ __('lang.share_whatsapp') }}">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body pt-3">
                      <h2 class="card-title fs-16 lh-2 mb-0">
                        <a href="{{ route('projects.show', $project->slug) }}" class="text-dark hover-primary">
                          {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                        </a>
                      </h2>
                      <p class="card-text font-weight-500 text-gray-light mb-2">
                        @if($project->category)
                          <a href="{{ route('category.show', $project->category->slug) }}" class="text-gray-light hover-primary">
                            {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}
                          </a>
                        @endif
                        @if($project->subcategory)
                          <span class="mx-1">/</span>
                          <a href="{{ route('subcategory.show', $project->subcategory->slug) }}" class="text-gray-light hover-primary">
                            {{ app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english }}
                          </a>
                        @endif
                      </p>
                      <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                        @foreach($project->specifications->take(3) as $spec)
                        @if($spec->specification)
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                            data-toggle="tooltip" title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                          @if($spec->specification->icon)
                          <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                               alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                               class="mr-2 spec-icon" 
                               style="width: 24px; height: 24px; object-fit: contain;">
                          @else
                          <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-2 spec-icon-placeholder" 
                                style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                              {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                          </span>
                          @endif
                          <span class="spec-value">{{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}</span>
                        </li>
                        @endif
                        @endforeach
                      </ul>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                      <p class="fs-17 font-weight-bold text-heading mb-0">
                        @if($project->sqft)
                        {{ number_format($project->sqft) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqft') }}</span>
                        @endif
                      </p>
                      <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                        {{ __('lang.view_project') }}
                        <i class="far fa-long-arrow-right ml-1"></i>
                      </a>
                    </div>
                  </div>
                </div>
                @empty
                <div class="col-12">
                  <div class="alert alert-info text-center">
                    {{ __('lang.no_projects_found') }}
                  </div>
                </div>
                @endforelse
                        </div>

              {{-- List View --}}
              <div class="row" id="listView" style="display: none;">
                @forelse($projects as $project)
                <div class="col-12 mb-6">
                  <div class="card border-0 shadow-hover-2" data-animate="fadeInUp">
                    <div class="row no-gutters">
                      <div class="col-md-5">
                        <div class="hover-change-image bg-hover-overlay rounded-lg card-img h-100">
                          <img src="{{ url('/storage' . $project->main_image) }}" class="h-100 object-fit-cover"
                               alt="{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}">
                          <div class="card-img-overlay p-2 d-flex flex-column">
                            <div>
                              @if($project->home_status == 0)
                              <span class="badge badge-primary">Featured</span>
                              @else
                              <span class="badge badge-indigo">{{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}</span>
                              @endif
                      </div>
                            <ul class="list-inline mb-0 mt-auto hover-image">
                              @if($project->total_images > 0)
                              <li class="list-inline-item mr-2" data-toggle="tooltip" title="{{ $project->total_images }} {{ __('lang.images') }}">
                              <a href="#" class="text-white hover-primary">
                                  <i class="far fa-images"></i><span class="pl-1">{{ $project->total_images }}</span>
                              </a>
                            </li>
                              @endif
                              @if($project->video_count > 0)
                              <li class="list-inline-item" data-toggle="tooltip" title="{{ $project->video_count }} {{ __('lang.videos') }}">
                              <a href="#" class="text-white hover-primary">
                                  <i class="far fa-play-circle"></i><span class="pl-1">{{ $project->video_count }}</span>
                              </a>
                            </li>
                              @endif
                      </ul>
                    </div>
                        </div>
                      </div>
                      <div class="col-md-7">
                        <div class="card-body p-4 d-flex flex-column h-100">
                          <h2 class="card-title fs-18 lh-2 mb-0">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-dark hover-primary">
                              {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                            </a>
                      </h2>
                          <p class="card-text font-weight-500 text-gray-light mb-2">
                            @if($project->category)
                              <a href="{{ route('category.show', $project->category->slug) }}" class="text-gray-light hover-primary">
                                {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}
                              </a>
                            @endif
                            @if($project->subcategory)
                              <span class="mx-1">/</span>
                              <a href="{{ route('subcategory.show', $project->subcategory->slug) }}" class="text-gray-light hover-primary">
                                {{ app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english }}
                              </a>
                            @endif
                          </p>
                          <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                            @foreach($project->specifications->take(3) as $spec)
                            @if($spec->specification)
                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                                data-toggle="tooltip" title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                              @if($spec->specification->icon)
                              <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                   alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                                   class="mr-2 spec-icon" 
                                   style="width: 24px; height: 24px; object-fit: contain;">
                              @else
                              <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-2 spec-icon-placeholder" 
                                    style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                                  {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                              </span>
                              @endif
                              <span class="spec-value">{{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}</span>
                            </li>
                            @endif
                            @endforeach
                          </ul>
                          <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                            <p class="fs-17 font-weight-bold text-heading mb-0">
                              @if($project->sqft)
                              {{ number_format($project->sqft) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqft') }}</span>
                              @endif
                            </p>
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                              {{ __('lang.view_details') }}
                              <i class="far fa-long-arrow-right ml-1"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @empty
                <div class="col-12">
                  <div class="alert alert-info text-center">
                    {{ __('lang.no_projects_found') }}
                  </div>
                </div>
                @endforelse
              </div>

              @if($projects->hasPages())
              <nav class="pt-4">
                <ul class="pagination rounded-active justify-content-center mb-0">
                  {{-- Previous Page Link --}}
                  @if($projects->onFirstPage())
                  <li class="page-item disabled"><span class="page-link"><i class="far fa-angle-double-left"></i></span></li>
                  @else
                  <li class="page-item"><a class="page-link" href="{{ $projects->previousPageUrl() }}"><i class="far fa-angle-double-left"></i></a></li>
                  @endif

                  {{-- Pagination Elements --}}
                  @foreach($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                    @if($page == $projects->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                  @endforeach

                  {{-- Next Page Link --}}
                  @if($projects->hasMorePages())
                  <li class="page-item"><a class="page-link" href="{{ $projects->nextPageUrl() }}"><i class="far fa-angle-double-right"></i></a></li>
                  @else
                  <li class="page-item disabled"><span class="page-link"><i class="far fa-angle-double-right"></i></span></li>
                  @endif
                </ul>
              </nav>
              @endif
            </div>
            
            {{-- Filter Sidebar Wrapper --}}
            <div class="filter-sidebar-wrapper hidden" id="filterSidebarWrapper">
                {{-- Mobile Filter Header --}}
                <div class="mobile-filter-header d-lg-none">
                    <h4>{{ __('lang.filter') }}</h4>
                    <button type="button" class="mobile-filter-close" id="mobileFilterClose">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                
            @include('pages.projects.partials.filter-sidebar', [
                'formAction' => route('category.show', $category->slug),
                'categories' => $categories,
                'subcategories' => $subcategories,
                'styles' => $styles,
                'types' => $types,
                'specifications' => $specifications,
                'specificationValues' => $specificationValues ?? [],
                'hideCategory' => true,
                'currentCategory' => $category
            ])
            </div>
          </div>
        </div>
      </section>


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/category-page.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/area-slider.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/projects-filter.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/projects-responsive.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Filter Toggle Functionality
    var filterToggleBtn = $('#filterToggleBtn');
    var filterSidebar = $('#filterSidebarWrapper');
    var projectsContainer = $('#projectsContainer');
    var mobileFilterOverlay = $('#mobileFilterOverlay');
    var mobileFilterClose = $('#mobileFilterClose');
    var body = $('body');
    
    // Check if we're on mobile
    function isMobile() {
        return window.innerWidth <= 991;
    }
    
    // Toggle filter visibility
    filterToggleBtn.on('click', function() {
        if (isMobile()) {
            // Mobile: slide in panel
            filterSidebar.toggleClass('visible hidden');
            mobileFilterOverlay.toggleClass('active');
            body.toggleClass('filter-open');
        } else {
            // Desktop: toggle sidebar visibility
            filterSidebar.toggleClass('visible hidden');
            projectsContainer.toggleClass('filter-visible filter-hidden');
        }
        
        $(this).toggleClass('active');
    });
    
    // Close mobile filter
    mobileFilterClose.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    // Close on overlay click
    mobileFilterOverlay.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if (!isMobile()) {
            // Reset mobile states when switching to desktop
            mobileFilterOverlay.removeClass('active');
            body.removeClass('filter-open');
        }
    });
    
    // View toggle functionality
    $('.view-toggle').on('click', function(e) {
        e.preventDefault();
        var view = $(this).data('view');
        
        // Update active state
        $('.view-toggle').removeClass('active opacity-2');
        $(this).addClass('active');
        $('.view-toggle').not(this).addClass('opacity-2');
        
        if (view === 'list') {
            $('#gridView').hide();
            $('#listView').show();
        } else {
            $('#listView').hide();
            $('#gridView').show();
        }
    });
    
    // Set initial state
    $('#listViewBtn').addClass('opacity-2');
    
    // Auto-submit for filter dropdowns
    $('.filter-select').on('changed.bs.select', function() {
        $('#projectFilterForm').submit();
    });
    
    // Initialize SQFT Range Slider
    var sqftMinDefault = 50;
    var sqftMaxDefault = 15000;
    var sqftMinVal = {{ request('sqft_min', 50) ?: 50 }};
    var sqftMaxVal = {{ request('sqft_max', 15000) ?: 15000 }};
    
    $("#sqft-slider").slider({
        range: true,
        min: sqftMinDefault,
        max: sqftMaxDefault,
        values: [sqftMinVal, sqftMaxVal],
        slide: function(event, ui) {
            $("#sqft-range-display").text(ui.values[0] + " {{ __('lang.sqft') }} {{ __('lang.to') }} " + ui.values[1] + " {{ __('lang.sqft') }}");
            $("#sqft_min").val(ui.values[0]);
            $("#sqft_max").val(ui.values[1]);
        },
        stop: function(event, ui) {
            if (ui.values[0] !== sqftMinDefault || ui.values[1] !== sqftMaxDefault) {
                $('#projectFilterForm').submit();
            }
        }
    });
    $("#sqft-range-display").text(sqftMinVal + " {{ __('lang.sqft') }} {{ __('lang.to') }} " + sqftMaxVal + " {{ __('lang.sqft') }}");
    
    // Initialize SQM Range Slider
    var sqmMinDefault = 5;
    var sqmMaxDefault = 1400;
    var sqmMinVal = {{ request('sqm_min', 5) ?: 5 }};
    var sqmMaxVal = {{ request('sqm_max', 1400) ?: 1400 }};
    
    $("#sqm-slider").slider({
        range: true,
        min: sqmMinDefault,
        max: sqmMaxDefault,
        values: [sqmMinVal, sqmMaxVal],
        slide: function(event, ui) {
            $("#sqm-range-display").text(ui.values[0] + " {{ __('lang.sqm') }} {{ __('lang.to') }} " + ui.values[1] + " {{ __('lang.sqm') }}");
            $("#sqm_min").val(ui.values[0]);
            $("#sqm_max").val(ui.values[1]);
        },
        stop: function(event, ui) {
            if (ui.values[0] !== sqmMinDefault || ui.values[1] !== sqmMaxDefault) {
                $('#projectFilterForm').submit();
            }
        }
    });
    $("#sqm-range-display").text(sqmMinVal + " {{ __('lang.sqm') }} {{ __('lang.to') }} " + sqmMaxVal + " {{ __('lang.sqm') }}");
    
    // Specification dropdown - load values dynamically
    $('#specification_id').on('changed.bs.select', function() {
        var specId = $(this).val();
        var $valueSelect = $('#specification_value');
        
        if (specId) {
            $.ajax({
                url: "{{ route('projects.specification-values') }}",
                type: 'GET',
                data: { specification_id: specId },
                success: function(response) {
                    $valueSelect.empty();
                    $valueSelect.append('<option value="">{{ __('lang.select_value') }}</option>');
                    if (response.values && response.values.length > 0) {
                        $.each(response.values, function(index, value) {
                            $valueSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                        $valueSelect.prop('disabled', false);
                    } else {
                        $valueSelect.prop('disabled', true);
                    }
                    $valueSelect.selectpicker('refresh');
                }
            });
        } else {
            $valueSelect.empty();
            $valueSelect.append('<option value="">{{ __('lang.select_value') }}</option>');
            $valueSelect.prop('disabled', true);
            $valueSelect.selectpicker('refresh');
        }
    });
    
    // Specification value dropdown - auto submit
    $('#specification_value').on('changed.bs.select', function() {
        if ($(this).val()) {
            $('#projectFilterForm').submit();
        }
    });
    
    // Sort by change - auto submit
    $('.sortby-select').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    // Fallback for native change event
    $('#sortbySelect').on('change', function() {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    // Close filter on escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && filterSidebar.hasClass('visible') && isMobile()) {
            filterSidebar.removeClass('visible').addClass('hidden');
            mobileFilterOverlay.removeClass('active');
            body.removeClass('filter-open');
            filterToggleBtn.removeClass('active');
        }
    });
});
</script>
@endsection
