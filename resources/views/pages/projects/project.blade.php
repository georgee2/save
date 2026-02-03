@extends('layouts.master')

@php
    $projectTitle = app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english;
    $projectDesc = $project->seo_desc ?? (app()->getLocale() == 'ar' ? $project->bio_arabic : $project->bio_english);
    $projectImage = url('/storage' . $project->main_image);
    $projectCategory = $project->category ? (app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english) : '';
    $projectSubcategory = $project->subcategory ? (app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english) : '';
    $projectSqft = $project->sqft ? number_format($project->sqft) . ' ' . __('lang.sqft') : '';
    $ogDescription = $projectDesc;
    if($projectSqft || $projectCategory) {
        $ogDescription = ($projectSqft ? $projectSqft . ' | ' : '') . ($projectCategory ? $projectCategory . ' | ' : '') . $projectDesc;
    }
@endphp

@section('title', $projectTitle)
@section('seo_desc', $projectDesc)
@section('seo_tags', $project->seo_tags ?? $projectTitle)

{{-- Open Graph Meta Tags --}}
@section('og_title', $projectTitle . ($projectCategory ? ' - ' . $projectCategory : ''))
@section('og_description', $ogDescription)
@section('og_image', $projectImage)
@section('og_type', 'article')

@section('meta_tags')
{{-- Additional Project Meta Tags --}}
@if($project->project_code)
<meta property="product:retailer_item_id" content="{{ $project->project_code }}">
@endif
@endsection

@section('content')

	

      <section class="pb-7 shadow-5">
        <div class="container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb py-3">
              <li class="breadcrumb-item letter-spacing-1">
                <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
              </li>
              <li class="breadcrumb-item letter-spacing-1">
                <a href="{{ route('projects.index') }}">{{ __('lang.projects') }}</a>
              </li>
              @if($project->category)
              <li class="breadcrumb-item letter-spacing-1">
                <a href="{{ route('category.show', $project->category->slug) }}">{{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}</a>
              </li>
              @endif
              <li class="breadcrumb-item letter-spacing-1 active">{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}</li>
            </ol>
          </nav>
          <div class="d-md-flex justify-content-md-between mb-1">
            <ul class="list-inline d-sm-flex align-items-sm-center mb-0">
              @if($project->home_status == 0)
              <li class="list-inline-item badge badge-danger mr-2">{{ __('lang.featured') }}</li>
              @endif
              @if($project->category)
              <li class="list-inline-item badge badge-primary mr-3">{{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}</li>
              @endif
              <li class="list-inline-item mr-2 mt-2 mt-sm-0"><i class="fal fa-clock mr-1"></i>{{ $project->created_at->diffForHumans() }}</li>
            </ul>
@php
                $shareTitle = app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english;
                $shareSqft = $project->sqft ? number_format($project->sqft) . ' ' . __('lang.sqft') : '';
                $shareCategory = $project->category ? (app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english) : '';
                $shareSubcategory = $project->subcategory ? (app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english) : '';
                $shareLocation = '';
                if($project->location_english || $project->location_arabic) {
                    $shareLocation = app()->getLocale() == 'ar' ? ($project->location_arabic ?? $project->location_english) : ($project->location_english ?? $project->location_arabic);
                } elseif($project->emirate) {
                    $shareLocation = app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english;
                }
                $shareText = $shareTitle;
                if($shareSqft) {
                    $shareText .= ' - ' . $shareSqft;
                }
                if($shareCategory) {
                    $shareText .= ' | ' . $shareCategory;
                    if($shareSubcategory) {
                        $shareText .= ' / ' . $shareSubcategory;
                    }
                }
                if($shareLocation) {
                    $shareText .= ' | ' . $shareLocation;
                }
                $shareUrl = request()->url();
                $shareImage = url('/storage' . $project->main_image);
            @endphp
            <div class="social-share-buttons d-flex flex-wrap my-4 my-md-0">
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}&quote={{ urlencode($shareText) }}" 
                 target="_blank" 
                 class="social-share-btn facebook"
                 data-toggle="tooltip" title="Facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareText) }}" 
                 target="_blank" 
                 class="social-share-btn twitter"
                 data-toggle="tooltip" title="X">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
              </a>
              <a href="https://wa.me/?text={{ urlencode($shareText . "\n" . $shareUrl) }}" 
                 target="_blank" 
                 class="social-share-btn whatsapp"
                 data-toggle="tooltip" title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
              </a>
              <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}&summary={{ urlencode($shareText) }}" 
                 target="_blank" 
                 class="social-share-btn linkedin"
                 data-toggle="tooltip" title="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="https://pinterest.com/pin/create/button/?url={{ urlencode($shareUrl) }}&media={{ urlencode($shareImage) }}&description={{ urlencode($shareText) }}" 
                 target="_blank" 
                 class="social-share-btn pinterest"
                 data-toggle="tooltip" title="Pinterest">
                <i class="fab fa-pinterest-p"></i>
              </a>
              <a href="mailto:?subject={{ rawurlencode($shareTitle) }}&body={{ urlencode($shareText . "\n\n" . $shareUrl) }}" 
                 class="social-share-btn email"
                 data-toggle="tooltip" title="Email">
                <i class="fas fa-envelope"></i>
              </a>
              <button type="button" 
                 class="social-share-btn copy-link copy-link-btn"
                 data-url="{{ $shareUrl }}"
                 data-toggle="tooltip" title="{{ __('lang.copy_link') }}">
                <i class="fas fa-link"></i>
              </button>
            </div>
          </div>
          <div class="d-md-flex justify-content-md-between mb-6">
            <div>
              <h2 class="fs-35 font-weight-600 lh-15 text-heading">{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}</h2>
              @if($project->location_english || $project->location_arabic)
              <p class="mb-1"><i class="fal fa-map-marker-alt mr-2 text-primary"></i>{{ app()->getLocale() == 'ar' ? ($project->location_arabic ?? $project->location_english) : ($project->location_english ?? $project->location_arabic) }}</p>
              @elseif($project->emirate)
              <p class="mb-1"><i class="fal fa-map-marker-alt mr-2 text-primary"></i>{{ app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english }}</p>
              @endif
              @if($project->project_code)
              <p class="mb-0"><span class="badge badge-secondary px-3 py-2" style="font-family: 'Courier New', monospace; font-size: 12px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); border: none;"><i class="fal fa-barcode mr-1"></i>{{ $project->project_code }}</span></p>
              @endif
            </div>
            <div class="mt-2 text-md-right">
              @if($project->project_cost)
              <p class="fs-28 font-weight-bold mb-1" style="color: #e1273d;">
                {{ $project->currency ? $project->currency->abbreviation : 'AED' }} {{ number_format($project->project_cost, 0) }}
              </p>
              <p class="fs-14 mb-2" style="color: #19868b; font-weight: 500;">{{ __('lang.project_cost') }}</p>
              @endif
              @if($project->sqft)
              <p class="fs-20 text-heading font-weight-bold mb-0">{{ number_format($project->sqft) }} {{ __('lang.sqft') }}</p>
              @endif
              @if($project->sqm)
              <p class="mb-0 text-muted">{{ number_format($project->sqm) }} {{ __('lang.sqm') }}</p>
              @endif
            </div>
          </div>
          @php
              $totalImages = $project->images->count();
          @endphp
          <div class="row galleries">
            {{-- Main Image --}}
            <div class="{{ $totalImages > 0 ? 'col-lg-6' : 'col-12' }} mb-3 mb-lg-0">
              <a href="{{ url('/storage' . $project->main_image) }}" 
                 data-gtf-mfp="true"
                 data-gallery-id="project-gallery"
                 class="d-block rounded-lg overflow-hidden position-relative gallery-hover main-image-container">
                <img src="{{ url('/storage' . $project->main_image) }}" 
                     alt="{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}"
                     class="w-100 rounded-lg"
                     style="object-fit: contain;">
                <div class="gallery-hover-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center rounded-lg" 
                     style="top: 0; left: 0; background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                  <i class="fal fa-search-plus text-white fs-40"></i>
                </div>
              </a>
            </div>
            
            {{-- Thumbnails --}}
            @if($totalImages > 0)
            <div class="col-lg-6">
              <div class="row no-gutters">
                @php
                    // Show max 4 thumbnails to fit nicely in a 2x2 grid
                    $galleryImages = $project->images->take(4);
                    $remainingImages = $totalImages > 4 ? $totalImages - 4 : 0;
                @endphp
                
                @foreach($galleryImages as $index => $image)
                <div class="col-6 p-1">
                  <a href="{{ url('/storage' . $image->image) }}" 
                     data-gtf-mfp="true"
                     data-gallery-id="project-gallery"
                     class="d-block position-relative rounded-lg overflow-hidden gallery-hover thumb-image-container">
                    <img src="{{ url('/storage' . $image->image) }}" 
                         alt=""
                         class="w-100 rounded-lg"
                         style="object-fit: contain;">
                    @if($index == 3 && $remainingImages > 0)
                    {{-- Show +X overlay on last thumbnail --}}
                    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center rounded-lg" 
                         style="top: 0; left: 0; background: rgba(0,0,0,0.5);">
                      <p class="fs-24 font-weight-600 text-white lh-1 mb-0">+{{ $remainingImages }}</p>
                    </div>
                    @else
                    <div class="gallery-hover-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center rounded-lg" 
                         style="top: 0; left: 0; background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                      <i class="fal fa-search-plus text-white fs-24"></i>
                    </div>
                    @endif
                  </a>
                </div>
                @endforeach
              </div>
              
              {{-- Hidden images for lightbox --}}
              @foreach($project->images->skip(4) as $hiddenImage)
              <a href="{{ url('/storage' . $hiddenImage->image) }}" 
                 data-gtf-mfp="true"
                 data-gallery-id="project-gallery"
                 style="display: none;">
              </a>
              @endforeach
            </div>
            @endif
          </div>
          
          <style>
            .gallery-hover:hover .gallery-hover-overlay {
              opacity: 1 !important;
            }
          </style>
        </div>
      </section>


      <div class="primary-content bg-gray-01 pt-7 pb-13">
        <div class="container">
          <div class="row">
            <article class="col-lg-8">
              @include('pages.projects.singleproject.description')
              @include('pages.projects.singleproject.specs')
              @include('pages.projects.singleproject.information')
              @include('pages.projects.singleproject.siteplan')
              @include('pages.projects.singleproject.floors')
              @include('pages.projects.singleproject.feasibility')
              @include('pages.projects.singleproject.location')

            </article>
            <aside class="col-lg-4 pl-xl-4 primary-sidebar sidebar-sticky" id="sidebar">
              <div class="primary-sidebar-inner">
              <div class="card border-0 widget-request-tour">
                <ul class="nav nav-tabs d-flex" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active px-3" data-toggle="tab" href="#schedule" role="tab"
                                   aria-selected="true">Schedule
                      A Tour</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link px-3" data-toggle="tab" href="#request-info" role="tab"
                                   aria-selected="false">Request
                      Info</a>
                  </li>
                </ul>
                <div class="card-body px-sm-6 shadow-xxs-2 pb-5 pt-0">
                  <form>
                    <div class="tab-content pt-1 pb-0 px-0 shadow-none">
                      <div class="tab-pane fade show active" id="schedule" role="tabpanel">
                        <div class="slick-slider calendar arrow-hide-disable mx-n1"
                                             data-slick-options='{"slidesToShow": 5, "autoplay":false,"dots":false}'>
                          <div class="box px-1 py-4">
                            <div class="card pointer active border-0 shadow-xxs-1"
                                                     data-date="March 17, 2020">
                              <div class="card-body p-1 text-center">
                                <p class="day fs-12 text-muted lh-2 mb-0">Tue</p>
                                <p class="date fs-18 text-heading lh-173 mb-0 font-weight-bold">
                                  17</p>
                                <p class="month fs-13 letter-spacing-087 mb-0">Mar</p>
                              </div>
                            </div>
                          </div>
                          <div class="box px-1 py-4">
                            <div class="card pointer border-0 shadow-xxs-1"
                                                     data-date="March 18, 2020">
                              <div class="card-body p-1 text-center">
                                <p class="day fs-12 text-muted lh-2 mb-0">Wed</p>
                                <p class="date fs-18 text-heading lh-173 mb-0 font-weight-bold">
                                  18</p>
                                <p class="month fs-13 letter-spacing-087 mb-0">Mar</p>
                              </div>
                            </div>
                          </div>
                          <div class="box px-1 py-4">
                            <div class="card pointer border-0 shadow-xxs-1"
                                                     data-date="March 19, 2020">
                              <div class="card-body p-1 text-center">
                                <p class="day fs-12 text-muted lh-2 mb-0">Thur</p>
                                <p class="date fs-18 text-heading lh-173 mb-0 font-weight-bold">
                                  19</p>
                                <p class="month fs-13 letter-spacing-087 mb-0">Mar</p>
                              </div>
                            </div>
                          </div>
                          <div class="box px-1 py-4">
                            <div class="card pointer border-0 shadow-xxs-1"
                                                     data-date="March 20, 2020">
                              <div class="card-body p-1 text-center">
                                <p class="day fs-12 text-muted lh-2 mb-0">Fri</p>
                                <p class="date fs-18 text-heading lh-173 mb-0 font-weight-bold">
                                  20</p>
                                <p class="month fs-13 letter-spacing-087 mb-0">Mar</p>
                              </div>
                            </div>
                          </div>
                          <div class="box px-1 py-4">
                            <div class="card pointer border-0 shadow-xxs-1"
                                                     data-date="March 21, 2020">
                              <div class="card-body p-1 text-center">
                                <p class="day fs-12 text-muted lh-2 mb-0">Sat</p>
                                <p class="date fs-18 text-heading lh-173 mb-0 font-weight-bold">
                                  21</p>
                                <p class="month fs-13 letter-spacing-087 mb-0">Mar</p>
                              </div>
                            </div>
                          </div>
                          <div class="box px-1 py-4">
                            <div class="card pointer border-0 shadow-xxs-1"
                                                     data-date="March 22, 2020">
                              <div class="card-body p-1 text-center">
                                <p class="day fs-12 text-muted lh-2 mb-0">Sun</p>
                                <p class="date fs-18 text-heading lh-173 mb-0 font-weight-bold">
                                  22</p>
                                <p class="month fs-13 letter-spacing-087 mb-0">Mar</p>
                              </div>
                            </div>
                          </div>
                          <div class="box px-1 py-4">
                            <div class="card pointer border-0 shadow-xxs-1"
                                                     data-date="March 23, 2020">
                              <div class="card-body p-1 text-center">
                                <p class="day fs-12 text-muted lh-2 mb-0">Mon</p>
                                <p class="date fs-18 text-heading lh-173 mb-0 font-weight-bold">
                                  23</p>
                                <p class="month fs-13 letter-spacing-087 mb-0">Mar</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <input type="hidden" class="date" name="date" value="March 17, 2020">
                        <div class="form-group mb-2">
                          <div class="input-group input-group-lg bootstrap-timepicker timepicker">
                            <input type="text" class="form-control border-0 text-body shadow-none"
                                                       placeholder="Choose a time">
                            <div class="input-group-append input-group-addon">
                              <button class="btn bg-input shadow-none fs-18 lh-1" type="button"><i
                                                            class="fal fa-angle-down"></i></button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group mb-2">
                          <input type="text" class="form-control form-control-lg border-0"
                                                   placeholder="First Name, Last Name">
                        </div>
                        <div class="form-group mb-2">
                          <input type="email" class="form-control form-control-lg border-0"
                                                   placeholder="Your Email">
                        </div>
                        <div class="form-group mb-4">
                          <input type="tel" class="form-control form-control-lg border-0"
                                                   placeholder="Your phone">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Schedule
                          A Tour
                        </button>
                        <div class="form-group form-check mt-2 mb-0">
                          <input type="checkbox" class="form-check-input" id="exampleCheck1">
                          <label class="form-check-label fs-13" for="exampleCheck1">Egestas fringilla
                            phasellus
                            faucibus
                            scelerisque
                            eleifend donec.</label>
                        </div>
                      </div>
                      <div class="tab-pane fade pt-5" id="request-info" role="tabpanel">
                        <div class="form-check d-flex align-items-center border-bottom pb-3 mb-3">
                          <input class="form-check-input" type="radio" name="agent" value="option1">
                          <div class="form-check-label ml-2">
                            <div class="d-flex align-items-center">
                              <a href="agent-details-1.html"
                                                       class="d-block w-60px h-60 mr-3">
                                <img src="images/agent-2.jpg"
                                                             class="rounded-circle" alt="agent-2">
                              </a>
                              <div>
                                <a href="agent-details-1.html"
                                                           class="d-block text-dark font-weight-500 lh-15 hover-primary">Oliver
                                  Beddows</a>
                                <p class="mb-0 fs-13 mb-0 lh-17">Sales Excutive</p>
                                <p class="mb-0 fs-13 mb-0 lh-17"><span>(+123)</span><span
                                                                class="text-heading d-inline-block ml-2">1900 68668</span>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-check d-flex align-items-center mb-6">
                          <input class="form-check-input" type="radio" name="agent" id="inlineRadio2"
                                                   value="option2">
                          <div class="form-check-label ml-2">
                            <div class="d-flex align-items-center">
                              <a href="agent-details-1.html"
                                                       class="d-block w-60px h-60 mr-3">
                                <img src="images/agent-1.jpg"
                                                             class="rounded-circle" alt="agent-1">
                              </a>
                              <div>
                                <a href="agent-details-1.html"
                                                           class="d-block text-dark font-weight-500 lh-15 hover-primary">Max
                                  Kordex</a>
                                <p class="mb-0 fs-13 mb-0 lh-17">Real estate broker</p>
                                <p class="mb-0 fs-13 mb-0 lh-17"><span>(+123)</span><span
                                                                class="text-heading d-inline-block ml-2">1900 68668</span>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group mb-2">
                          <input type="text" class="form-control form-control-lg border-0"
                                                   placeholder="First Name, Last Name">
                        </div>
                        <div class="form-group mb-2">
                          <input type="email" class="form-control form-control-lg border-0"
                                                   placeholder="Your Email">
                        </div>
                        <div class="form-group mb-2">
                          <input type="tel" class="form-control form-control-lg border-0"
                                                   placeholder="Your phone">
                        </div>
                        <div class="form-group mb-4">
                          <textarea class="form-control border-0" rows="4">Hello, I'm interested in Villa Called Archangel</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Request
                          Info
                        </button>
                        <div class="form-group form-check mt-2 mb-0">
                          <input type="checkbox" class="form-check-input" id="exampleCheck2">
                          <label class="form-check-label fs-13" for="exampleCheck2">Egestas fringilla
                            phasellus
                            faucibus
                            scelerisque
                            eleifend donec.</label>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            </aside>
          </div>
        </div>
      </div>

@endsection

@section('css')
<style>
/* Social Share Buttons */
.social-share-buttons {
    gap: 8px;
}

.social-share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.social-share-btn.facebook {
    background: #1877f2;
    color: #fff;
}
.social-share-btn.facebook:hover {
    background: #0d65d9;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(24, 119, 242, 0.4);
}

.social-share-btn.twitter {
    background: #000000;
    color: #fff;
}
.social-share-btn.twitter:hover {
    background: #333333;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}
.social-share-btn.twitter svg {
    width: 14px;
    height: 14px;
}

.social-share-btn.whatsapp {
    background: #25d366;
    color: #fff;
}
.social-share-btn.whatsapp:hover {
    background: #1da851;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
}

.social-share-btn.linkedin {
    background: #0077b5;
    color: #fff;
}
.social-share-btn.linkedin:hover {
    background: #005e93;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 119, 181, 0.4);
}

.social-share-btn.pinterest {
    background: #bd081c;
    color: #fff;
}
.social-share-btn.pinterest:hover {
    background: #a00718;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(189, 8, 28, 0.4);
}

.social-share-btn.email {
    background: #ea4335;
    color: #fff;
}
.social-share-btn.email:hover {
    background: #d33426;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(234, 67, 53, 0.4);
}

.social-share-btn.copy-link {
    background: #19868b;
    color: #fff;
}
.social-share-btn.copy-link:hover {
    background: #0d6d71;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(25, 134, 139, 0.4);
}

.social-share-btn.copy-link.copied {
    background: #28a745;
}

/* RTL Support */
[dir="rtl"] .social-share-buttons {
    flex-direction: row-reverse;
}
</style>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Copy link functionality
    $('.copy-link-btn').on('click', function() {
        var url = $(this).data('url');
        var $btn = $(this);
        
        // Copy to clipboard
        navigator.clipboard.writeText(url).then(function() {
            // Show success feedback
            var originalTitle = $btn.attr('data-original-title') || $btn.attr('title');
            $btn.attr('data-original-title', '{{ __("lang.link_copied") }}').tooltip('show');
            
            // Change icon and add copied class
            $btn.find('i').removeClass('fa-link').addClass('fa-check');
            $btn.addClass('copied');
            
            // Reset after 2 seconds
            setTimeout(function() {
                $btn.attr('data-original-title', originalTitle).tooltip('hide');
                $btn.find('i').removeClass('fa-check').addClass('fa-link');
                $btn.removeClass('copied');
            }, 2000);
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
        });
    });
});
</script>
@endsection
