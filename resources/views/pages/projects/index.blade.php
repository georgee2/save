@extends('layouts.master')
@section('title' , __('lang.projects'))
@section('seo_desc', __('lang.projects_seo_desc'))
@section('seo_tags', __('lang.projects'))
@section('content')


<section class="pb-8 page-title shadow">
        <div class="container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
              <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ __('lang.projects') }}</li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ __('lang.projects') }}</h1>
          </nav>
        </div>
      </section>




      <section class="pt-8 pb-11">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mb-8 mb-lg-0">
              <div class="row align-items-sm-center mb-6">
                <div class="col-md-6">
                  <h2 class="fs-15 text-dark mb-0">{{ __('lang.we_found') }} <span class="text-primary">{{ $projects->total() }}</span> {{ __('lang.projects_available') }}</h2>
                </div>
                <div class="col-md-6 mt-6 mt-md-0">
                  <div class="d-flex justify-content-md-end align-items-center">
                    <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                      <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3"
								       for="sortbySelect"><i
										class="fas fa-align-left fs-16 pr-2"></i>{{ __('lang.sortby') }}:</label>
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
                          @elseif($project->category)
                          <span class="badge badge-indigo">{{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}</span>
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
                              <span class="badge badge-primary">{{ __('lang.featured') }}</span>
                              @elseif($project->category)
                              <span class="badge badge-indigo">{{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}</span>
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
            @include('pages.projects.partials.filter-sidebar', [
                'formAction' => route('projects.index'),
                'categories' => $categories,
                'subcategories' => $subcategories,
                'styles' => $styles,
                'types' => $types,
                'specifications' => $specifications,
                'specificationValues' => $specificationValues ?? []
            ])
          </div>
        </div>
      </section>


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/category-page.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/area-slider.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
$(document).ready(function() {
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
            // Submit form after slider stops
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
            // Submit form after slider stops
            if (ui.values[0] !== sqmMinDefault || ui.values[1] !== sqmMaxDefault) {
                $('#projectFilterForm').submit();
            }
        }
    });
    $("#sqm-range-display").text(sqmMinVal + " {{ __('lang.sqm') }} {{ __('lang.to') }} " + sqmMaxVal + " {{ __('lang.sqm') }}");
    
    // Sort by change - auto submit
    $('.sortby-select').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    // Also bind on native change event as fallback
    $('#sortbySelect').on('change', function() {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    // Auto-submit for filter dropdowns
    $('.filter-select').on('changed.bs.select', function() {
        $('#projectFilterForm').submit();
    });
    
    // Dynamic subcategory filtering based on category selection
    $('#category_id').on('changed.bs.select', function() {
        var categoryId = $(this).val();
        if (categoryId) {
            // Filter subcategories based on selected category
            $('#subcategory_id option').each(function() {
                var $option = $(this);
                var optionCategoryId = $option.data('category');
                if (optionCategoryId && optionCategoryId != categoryId) {
                    $option.hide();
                } else {
                    $option.show();
                }
            });
            $('#subcategory_id').selectpicker('refresh');
        } else {
            // Show all subcategories
            $('#subcategory_id option').show();
            $('#subcategory_id').selectpicker('refresh');
        }
    });
    
    // Dynamic specification value loading based on specification selection
    $('#specification_id').on('changed.bs.select', function() {
        var specId = $(this).val();
        var $valueSelect = $('#specification_value');
        
        if (specId) {
            // Enable the value dropdown and load values via AJAX
            $valueSelect.prop('disabled', false);
            
            $.ajax({
                url: '{{ route("projects.specification-values") }}',
                type: 'GET',
                data: { specification_id: specId },
                success: function(response) {
                    // Clear existing options except the first one
                    $valueSelect.find('option:not(:first)').remove();
                    
                    // Add new options
                    if (response.values && response.values.length > 0) {
                        $.each(response.values, function(index, value) {
                            $valueSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                    
                    // Refresh the selectpicker
                    $valueSelect.selectpicker('refresh');
                },
                error: function() {
                    console.log('Error loading specification values');
                }
            });
        } else {
            // Disable and reset the value dropdown
            $valueSelect.prop('disabled', true);
            $valueSelect.find('option:not(:first)').remove();
            $valueSelect.selectpicker('refresh');
        }
    });
    
    // Auto-submit when specification value is selected
    $('#specification_value').on('changed.bs.select', function() {
        if ($(this).val()) {
            $('#projectFilterForm').submit();
        }
    });
});
</script>
@endsection

