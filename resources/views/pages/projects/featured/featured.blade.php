@extends('layouts.master')
@section('title' , __('lang.featured_projects_title'))
@section('seo_desc', __('lang.featured_projects_seo_desc'))
@section('seo_tags', __('lang.featured_projects_title'))
@section('content')


<section class="pb-8 page-title shadow">
        <div class="container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
              <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
              <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('lang.projects') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ __('lang.featured_projects_title') }}</li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ __('lang.featured_projects_title') }}</h1>
          </nav>
        </div>
      </section>



      <section class="pt-8 pb-11">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mb-8 mb-lg-0">
              <div class="row align-items-sm-center mb-6">
                <div class="col-md-6">
                  <h2 class="fs-15 text-dark mb-0">{{ __('lang.we_found') }} <span class="text-primary">{{ $projects->total() }}</span> {{ __('lang.featured_projects_available') }}</h2>
                </div>
                <div class="col-md-6 mt-6 mt-md-0">
                  <div class="d-flex justify-content-md-end align-items-center">
                    <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                      <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3"
								       for="inputGroupSelect01"><i
										class="fas fa-align-left fs-16 pr-2"></i>{{ __('lang.sortby') }}:</label>
                      <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby"
								        data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3"
								        id="inputGroupSelect01" name="sortby">
                        <option selected>{{ __('lang.newest') }}</option>
                        <option value="1">{{ __('lang.oldest') }}</option>
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
                          <span class="badge badge-primary">{{ __('lang.featured') }}</span>
                        </div>
                        <ul class="list-inline mb-0 mt-auto hover-image">
                          @if($project->total_images > 0)
                          <li class="list-inline-item mr-2" data-toggle="tooltip" title="{{ $project->total_images }} Images">
                              <a href="#" class="text-white hover-primary">
                              <i class="far fa-images"></i><span class="pl-1">{{ $project->total_images }}</span>
                              </a>
                            </li>
                          @endif
                          @if($project->video_count > 0)
                          <li class="list-inline-item" data-toggle="tooltip" title="{{ $project->video_count }} Video">
                              <a href="#" class="text-white hover-primary">
                              <i class="far fa-play-circle"></i><span class="pl-1">{{ $project->video_count }}</span>
                              </a>
                            </li>
                          @endif
                          </ul>
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
                    {{ __('lang.no_featured_projects') }}
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
                              <span class="badge badge-primary">{{ __('lang.featured') }}</span>
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
                    {{ __('lang.no_featured_projects') }}
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
            <div class="col-lg-4 primary-sidebar sidebar-sticky" id="sidebar">
              <div class="primary-sidebar-inner">
                <div class="card border-0 mb-4">
                  <div class="card-body pl-0 pl-lg-6 pr-0 pt-2 pb-4">
                    <h4 class="card-title fs-16 lh-2 text-dark mb-3">{{ __('lang.find_your_project') }}</h4>
                    <form>
                      <div class="form-group">
                        <label for="key-word" class="sr-only">{{ __('lang.keyword') }}</label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-none"
									       id="key-word"
									       placeholder="{{ __('lang.enter_keyword') }}">
                      </div>
                      <div class="form-group">
                        <label for="category" class="sr-only">{{ __('lang.category') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker"
									        title="{{ __('lang.all_categories') }}" data-style="btn-lg py-2 h-52" id="category">
                          @if(isset($categories))
                          @foreach($categories as $cat)
                          <option value="{{ $cat->id }}">{{ app()->getLocale() == 'ar' ? $cat->title_arabic : $cat->title_english }}</option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="subcategory" class="sr-only">{{ __('lang.subcategory') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker"
									        title="{{ __('lang.all_subcategories') }}" data-style="btn-lg py-2 h-52" id="subcategory">
                          @if(isset($subcategories))
                          @foreach($subcategories as $subcat)
                          <option value="{{ $subcat->id }}">{{ app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english }}</option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="form-group slider-range slider-range-secondary">
                        <label for="area-size" class="mb-4 text-gray-light">{{ __('lang.area_size') }}</label>
                        <div data-slider="true"
									     data-slider-options='{"min":0,"max":15000,"values":[50,15000],"type":"sqrt"}'></div>
                        <div class="text-center mt-2">
                          <input id="area-size" type="text" readonly
										       class="border-0 amount text-center text-body font-weight-500">
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none mt-4">{{ __('lang.search') }}
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/category-page.css') }}">
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
});
</script>
@endsection

