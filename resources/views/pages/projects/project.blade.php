@extends('layouts.master')

@php
    $locale = app()->getLocale();
    $projectCategory = $project->category ? ($locale == 'ar' ? $project->category->title_arabic : $project->category->title_english) : '';
    $projectSubcategory = $project->subcategory ? ($locale == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english) : '';
    $projectSqft = $project->sqft ? number_format($project->sqft) . ' ' . __('lang.sqft') : '';

    // Smart SEO title: custom > auto-generated > plain title
    if ($project->{"seo_title_{$locale}"}) {
        $projectTitle = $project->{"seo_title_{$locale}"};
    } elseif ($locale === 'en') {
        $projectTitle = ($projectSubcategory ?: $projectCategory ?: $project->title_english) . ' Design'
            . ($project->sqft ? ' – ' . number_format($project->sqft) . ' Sq.Ft' : '')
            . ' | SVEC';
    } else {
        $projectTitle = 'تصميم ' . ($projectSubcategory ?: $projectCategory ?: $project->title_arabic)
            . ($project->sqft ? ' – ' . number_format($project->sqft) . ' قدم مربع' : '')
            . ' | SVEC';
    }

    $projectDesc = $project->{"seo_description_{$locale}"} ?: ($locale == 'ar' ? $project->bio_arabic : $project->bio_english);
    $projectImage = url('/storage' . $project->main_image);
    $projectAlt = $project->{"alt_text_{$locale}"} ?? ($locale == 'ar' ? $project->title_arabic : $project->title_english);

    $ogDescription = $projectDesc;
    if($projectSqft || $projectCategory) {
        $ogDescription = ($projectSqft ? $projectSqft . ' | ' : '') . ($projectCategory ? $projectCategory . ' | ' : '') . $projectDesc;
    }
@endphp

@section('title', $projectTitle)
@section('seo_desc', $projectDesc)
@section('seo_tags', $project->seo_tags ?: $projectTitle)

{{-- Open Graph Meta Tags --}}
@section('og_title', $projectTitle . ($projectCategory ? ' - ' . $projectCategory : ''))
@section('og_description', $ogDescription)
@section('og_image', $projectImage)
@section('og_type', 'article')

@section('meta_tags')
@if($project->project_code)
<meta property="product:retailer_item_id" content="{{ $project->project_code }}">
@endif
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CreativeWork",
    "name": "{{ e($projectTitle) }}",
    "description": "{{ e(Str::limit(strip_tags($projectDesc), 300)) }}",
    "image": "{{ $projectImage }}",
    "creator": {
        "@type": "Organization",
        "name": "Smart Vision Engineering Consultants"
    }@if($project->emirate),
    "spatialCoverage": {
        "@type": "Place",
        "name": "{{ $project->emirate->{'name_' . $locale} ?? 'UAE' }}"
    }@endif
}
</script>
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
            <div class="social-share-buttons d-flex flex-wrap my-4 my-md-0 align-items-center">
              <button class="btn-favourite mr-2" data-type="project" data-id="{{ $project->id }}" title="{{ __('lang.add_to_favourites') }}">
                  <i class="fal fa-heart"></i>
              </button>
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
              $galleryImagesCount = $project->images->count();
              // Total with main image
              $totalWithMain = $galleryImagesCount + 1;
              // We need minimum 5 items (1 main + 4 thumbnails)
              $maxThumbnails = 4;
              // Get actual gallery images (max 4)
              $galleryImages = $project->images->take($maxThumbnails);
              $actualThumbnails = $galleryImages->count();
              // Remaining for +X overlay
              $remainingImages = $galleryImagesCount > $maxThumbnails ? $galleryImagesCount - $maxThumbnails : 0;
              // How many placeholders needed to fill 4 thumbnail slots
              $placeholdersNeeded = $maxThumbnails - $actualThumbnails;
          @endphp
          <div class="row galleries">
            {{-- Main Image --}}
            <div class="col-lg-6 mb-3 mb-lg-0">
              <a href="{{ url('/storage' . $project->main_image) }}" 
                 data-gtf-mfp="true"
                 data-gallery-id="project-gallery"
                 class="d-block rounded-lg overflow-hidden position-relative gallery-hover main-image-container">
                <img src="{{ url('/storage' . $project->main_image) }}"
                     alt="{{ $projectAlt }}"
                     class="w-100 rounded-lg"
                     style="object-fit: contain;">
                <div class="gallery-hover-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center rounded-lg" 
                     style="top: 0; left: 0; background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                  <i class="fal fa-search-plus text-white fs-40"></i>
                </div>
              </a>
            </div>
            
            {{-- Thumbnails Grid (always show 4 items - real images + placeholders) --}}
            <div class="col-lg-6">
              <div class="row no-gutters">
                {{-- Real Gallery Images --}}
                @foreach($galleryImages as $index => $image)
                <div class="col-6 p-1">
                  <a href="{{ url('/storage' . $image->image) }}" 
                     data-gtf-mfp="true"
                     data-gallery-id="project-gallery"
                     class="d-block position-relative rounded-lg overflow-hidden gallery-hover gallery-thumb">
                    <img src="{{ url('/storage' . $image->image) }}" 
                         alt=""
                         class="w-100 rounded-lg gallery-thumb-img">
                    @if($index == 3 && $remainingImages > 0)
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
                
                {{-- Placeholder Shapes - NOT clickable, NOT in slideshow --}}
                @for($p = 0; $p < $placeholdersNeeded; $p++)
                <div class="col-6 p-1">
                  <div class="gallery-placeholder rounded-lg">
                    @if($p % 2 == 0)
                    {{-- Icon placeholder --}}
                    <img src="{{ asset('pic/holder/icon.webp') }}" alt="" class="gallery-placeholder-icon">
                    @else
                    {{-- Name placeholder --}}
                    <img src="{{ asset('pic/holder/name.webp') }}" alt="" class="gallery-placeholder-name">
                    @endif
                  </div>
                </div>
                @endfor
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
          </div>
          
          <style>
            .gallery-hover:hover .gallery-hover-overlay {
              opacity: 1 !important;
            }
            
            /* Gallery Thumbnails */
            .gallery-thumb {
              aspect-ratio: 1 / 1;
            }
            .gallery-thumb-img {
              width: 100%;
              height: 100%;
              object-fit: cover;
            }
            
            /* Placeholder Shapes - Not clickable */
            .gallery-placeholder {
              aspect-ratio: 1 / 1;
              background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
              display: flex;
              align-items: center;
              justify-content: center;
              pointer-events: none;
              cursor: default;
              position: relative;
              overflow: hidden;
            }
            
            /* Subtle pattern overlay */
            .gallery-placeholder::before {
              content: '';
              position: absolute;
              top: 0;
              left: 0;
              right: 0;
              bottom: 0;
              background-image: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255,255,255,0.02) 10px,
                rgba(255,255,255,0.02) 20px
              );
            }
            
            /* Icon image */
            .gallery-placeholder-icon {
              width: 40%;
              height: auto;
              opacity: 0.5;
              position: relative;
              z-index: 1;
            }
            
            /* Name image */
            .gallery-placeholder-name {
              width: 70%;
              height: auto;
              opacity: 0.5;
              position: relative;
              z-index: 1;
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
              @php
                  $showProjectScheduleTour = config('features.projects.schedule_tour');
                  $showProjectRequestInfo = config('features.projects.request_info');
                  $showProjectForms = $showProjectScheduleTour || $showProjectRequestInfo;
              @endphp
              @if($showProjectForms)
              <div class="card border-0 widget-request-tour">
                @if($showProjectScheduleTour && $showProjectRequestInfo)
                {{-- Both tabs enabled --}}
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
                @elseif($showProjectScheduleTour)
                {{-- Only Schedule a Tour --}}
                <div class="card-header bg-primary text-white text-center py-3">
                    <i class="fas fa-calendar-alt mr-2"></i>Schedule A Tour
                </div>
                @else
                {{-- Only Request Info --}}
                <div class="card-header bg-primary text-white text-center py-3">
                    <i class="fas fa-info-circle mr-2"></i>Request Info
                </div>
                @endif
                <div class="card-body px-sm-6 shadow-xxs-2 pb-5 pt-0">
                  <div class="tab-content pt-1 pb-0 px-0 shadow-none">
                    @php
                      $projectTitle = app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english;
                      $projectToday = \Carbon\Carbon::now();
                    @endphp
                    @if($showProjectScheduleTour)
                    <div class="tab-pane fade {{ $showProjectScheduleTour ? 'show active' : '' }}" id="schedule" role="tabpanel">
                      <form action="{{ route('contact.store') }}" method="POST" class="project-inquiry-form" id="projectTourForm">
                        @csrf
                        @include('includes.form-guard')
                        <input type="hidden" name="source" value="project_tour">
                        <input type="hidden" name="related_type" value="project">
                        <input type="hidden" name="related_id" value="{{ $project->id }}">
                        <input type="hidden" name="subject" value="{{ __('lang.schedule_a_tour') }} - {{ $projectTitle }}">
                        <input type="hidden" name="message" value="{{ __('lang.interested_in_project', ['project' => $projectTitle]) }}">
                        <input type="hidden" name="g-recaptcha-response" class="project-recaptcha-token">

                        {{-- 14 days forward from today. This calendar was previously hardcoded
                             to March 2020, so every date offered was five years in the past. --}}
                        <div class="calendar-slider-wrapper mt-4 mb-3">
                          <button type="button" class="calendar-nav calendar-prev" id="projectCalendarPrev">
                            <i class="fas fa-chevron-left"></i>
                          </button>
                          <div class="slick-slider calendar-slider" id="projectCalendarSlider"
                               data-slick-options='{"slidesToShow": 5, "autoplay":false, "dots":false, "arrows":false, "infinite":false, "responsive":[{"breakpoint": 400,"settings": {"slidesToShow":3}},{"breakpoint": 576,"settings": {"slidesToShow":4}}]}'>
                            @for($i = 0; $i < 14; $i++)
                            @php $projectDate = $projectToday->copy()->addDays($i); @endphp
                            <div class="box px-1 py-2">
                              <div class="calendar-day text-center px-2 py-3 rounded {{ $i === 0 ? 'active' : '' }}"
                                   data-date="{{ $projectDate->format('Y-m-d') }}"
                                   style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                                <span class="d-block fs-12 text-muted text-uppercase">{{ $projectDate->format('D') }}</span>
                                <span class="d-block fs-20 font-weight-600 text-heading">{{ $projectDate->format('d') }}</span>
                                <span class="d-block fs-11 text-muted">{{ $projectDate->format('M') }}</span>
                              </div>
                            </div>
                            @endfor
                          </div>
                          <button type="button" class="calendar-nav calendar-next" id="projectCalendarNext">
                            <i class="fas fa-chevron-right"></i>
                          </button>
                        </div>
                        <input type="hidden" id="projectSelectedDate" name="preferred_date" value="{{ $projectToday->format('Y-m-d') }}">

                        <div class="form-group mb-3">
                          <label class="fs-13 text-muted mb-1">{{ __('lang.preferred_time') }}</label>
                          <select class="form-control form-control-lg border-0 bg-gray-01" name="preferred_time">
                            <option value="">{{ __('lang.select_time') }}</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="13:00">01:00 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="17:00">05:00 PM</option>
                          </select>
                        </div>
                        <div class="form-group mb-3">
                          <input type="text" class="form-control form-control-lg border-0 bg-gray-01" name="name" placeholder="{{ __('lang.full_name') }}">
                        </div>
                        <div class="form-group mb-3">
                          <input type="email" class="form-control form-control-lg border-0 bg-gray-01" name="email" placeholder="{{ __('lang.email_address') }}">
                        </div>
                        <div class="form-group mb-4">
                          <input type="tel" class="form-control form-control-lg border-0 bg-gray-01" name="phone" placeholder="{{ __('lang.phone_number') }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block rounded">
                          <i class="fas fa-calendar-check mr-2"></i>{{ __('lang.schedule_a_tour') }}
                        </button>
                      </form>
                    </div>
                    @endif

                    @if($showProjectRequestInfo)
                    <div class="tab-pane fade {{ !$showProjectScheduleTour ? 'show active' : '' }} pt-4" id="request-info" role="tabpanel">
                      <form action="{{ route('contact.store') }}" method="POST" class="project-inquiry-form" id="projectInfoForm">
                        @csrf
                        @include('includes.form-guard')
                        <input type="hidden" name="source" value="project_info">
                        <input type="hidden" name="related_type" value="project">
                        <input type="hidden" name="related_id" value="{{ $project->id }}">
                        <input type="hidden" name="subject" value="{{ __('lang.request_info') }} - {{ $projectTitle }}">
                        <input type="hidden" name="g-recaptcha-response" class="project-recaptcha-token">

                        <div class="form-group mb-3">
                          <input type="text" class="form-control form-control-lg border-0 bg-gray-01" name="name" placeholder="{{ __('lang.full_name') }}">
                        </div>
                        <div class="form-group mb-3">
                          <input type="email" class="form-control form-control-lg border-0 bg-gray-01" name="email" placeholder="{{ __('lang.email_address') }}">
                        </div>
                        <div class="form-group mb-3">
                          <input type="tel" class="form-control form-control-lg border-0 bg-gray-01" name="phone" placeholder="{{ __('lang.phone_number') }}">
                        </div>
                        <div class="form-group mb-4">
                          <textarea class="form-control border-0 bg-gray-01" name="message" rows="4" placeholder="{{ __('lang.interested_message') }}">{{ __('lang.interested_in_project', ['project' => $projectTitle]) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block rounded">
                          <i class="fas fa-paper-plane mr-2"></i>{{ __('lang.request_info') }}
                        </button>
                      </form>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
              @else
              {{-- Show Contact Card when forms are disabled --}}
              @include('pages.projects.singleproject.contact-card')
              @endif
            </div>
            </aside>
          </div>
        </div>
      </div>

@endsection

@section('css')
<style>
/* Contact Info Card Styles */
.contact-info-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.contact-card-header {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
    padding: 25px 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.contact-card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.contact-card-header .header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    backdrop-filter: blur(10px);
}

.contact-card-header .header-icon i {
    font-size: 26px;
    color: #fff;
}

.contact-card-header .header-title {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 5px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.contact-card-header .header-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 13px;
    margin: 0;
}

.contact-card-body {
    padding: 20px;
}

.contact-method {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    background: #fff;
    border-radius: 12px;
    margin-bottom: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #eee;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.contact-method:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    text-decoration: none;
}

.contact-method .method-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 14px;
    flex-shrink: 0;
}

.contact-method .method-icon i {
    font-size: 18px;
    color: #fff;
}

.contact-method.phone-method .method-icon {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
}

.contact-method.whatsapp-method .method-icon {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
}

.contact-method.email-method .method-icon {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
}

.contact-method .method-info {
    flex: 1;
    min-width: 0;
}

.contact-method .method-label {
    display: block;
    font-size: 11px;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.contact-method .method-value {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.contact-method .method-arrow {
    color: #ccc;
    font-size: 12px;
    transition: all 0.3s ease;
}

.contact-method:hover .method-arrow {
    color: #19868b;
    transform: translateX(3px);
}

.btn-contact-page {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 20px;
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-top: 5px;
    box-shadow: 0 4px 15px rgba(25, 134, 139, 0.3);
}

.btn-contact-page:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(25, 134, 139, 0.4);
    color: #fff;
    text-decoration: none;
}

.btn-contact-page i {
    font-size: 16px;
}

.btn-company-profile {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 20px;
    background: linear-gradient(135deg, #0d6b6f 0%, #095456 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-top: 12px;
    position: relative;
    overflow: hidden;
}

.btn-company-profile::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-company-profile:hover::before {
    left: 100%;
}

.btn-company-profile:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(13, 107, 111, 0.4);
    color: #fff;
    text-decoration: none;
}

.btn-company-profile .fa-file-pdf {
    font-size: 18px;
    color: #ff6b6b;
}

.btn-company-profile .download-icon {
    margin-left: auto;
    font-size: 14px;
    opacity: 0.8;
}

.contact-card-footer {
    padding: 20px;
    background: linear-gradient(135deg, #f0f9f9 0%, #e8f4f4 100%);
    border-top: 1px solid rgba(25, 134, 139, 0.1);
    text-align: center;
}

.contact-card-footer .social-label {
    display: block;
    font-size: 12px;
    color: #19868b;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
    font-weight: 600;
}

.contact-card-footer .social-icons {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.contact-card-footer .social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

.contact-card-footer .social-icon:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.contact-card-footer .social-icon.facebook {
    background: linear-gradient(135deg, #1877f2 0%, #0d65d9 100%);
}

.contact-card-footer .social-icon.instagram {
    background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}

.contact-card-footer .social-icon.twitter {
    background: linear-gradient(135deg, #1da1f2 0%, #0d8ecf 100%);
}

.contact-card-footer .social-icon.linkedin {
    background: linear-gradient(135deg, #0077b5 0%, #005885 100%);
}

.contact-card-footer .social-icon.pinterest {
    background: linear-gradient(135deg, #e60023 0%, #c8001e 100%);
}

.contact-card-footer .social-icon.whatsapp {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
}

/* Contact Card Responsive Styles */
@media (max-width: 1199px) {
    .contact-info-card {
        margin-bottom: 30px;
    }
    
    .contact-card-header {
        padding: 22px 18px;
    }
    
    .contact-card-header .header-icon {
        width: 55px;
        height: 55px;
    }
    
    .contact-card-header .header-icon i {
        font-size: 24px;
    }
    
    .contact-card-header .header-title {
        font-size: 18px;
    }
}

@media (max-width: 991px) {
    .contact-info-card {
        max-width: 500px;
        margin: 0 auto 30px;
    }
    
    .contact-card-header {
        padding: 25px 20px;
    }
    
    .contact-card-header .header-icon {
        width: 60px;
        height: 60px;
    }
    
    .contact-card-header .header-icon i {
        font-size: 26px;
    }
    
    .contact-card-header .header-title {
        font-size: 20px;
    }
    
    .contact-card-body {
        padding: 25px;
    }
    
    .contact-method {
        padding: 16px 18px;
    }
    
    .contact-method .method-icon {
        width: 48px;
        height: 48px;
    }
    
    .contact-method .method-icon i {
        font-size: 20px;
    }
    
    .contact-method .method-value {
        font-size: 15px;
    }
    
    .btn-contact-page,
    .btn-company-profile {
        padding: 16px 24px;
        font-size: 16px;
    }
    
    .contact-card-footer {
        padding: 25px;
    }
    
    .contact-card-footer .social-icon {
        width: 44px;
        height: 44px;
        font-size: 18px;
    }
}

@media (max-width: 767px) {
    .contact-info-card {
        max-width: 100%;
        border-radius: 12px;
    }
    
    .contact-card-header {
        padding: 20px 15px;
    }
    
    .contact-card-header .header-icon {
        width: 50px;
        height: 50px;
        margin-bottom: 12px;
    }
    
    .contact-card-header .header-icon i {
        font-size: 22px;
    }
    
    .contact-card-header .header-title {
        font-size: 18px;
    }
    
    .contact-card-header .header-subtitle {
        font-size: 12px;
    }
    
    .contact-card-body {
        padding: 15px;
    }
    
    .contact-method {
        padding: 12px 14px;
        margin-bottom: 10px;
        border-radius: 10px;
    }
    
    .contact-method .method-icon {
        width: 40px;
        height: 40px;
        margin-right: 12px;
        border-radius: 8px;
    }
    
    .contact-method .method-icon i {
        font-size: 16px;
    }
    
    .contact-method .method-label {
        font-size: 10px;
    }
    
    .contact-method .method-value {
        font-size: 13px;
    }
    
    .contact-method .method-arrow {
        font-size: 11px;
    }
    
    .btn-contact-page {
        padding: 12px 18px;
        font-size: 14px;
        border-radius: 10px;
        gap: 8px;
    }
    
    .btn-contact-page i {
        font-size: 14px;
    }
    
    .btn-company-profile {
        padding: 12px 18px;
        font-size: 13px;
        border-radius: 10px;
        gap: 8px;
        margin-top: 10px;
    }
    
    .btn-company-profile .fa-file-pdf {
        font-size: 16px;
    }
    
    .btn-company-profile .download-icon {
        font-size: 12px;
    }
    
    .contact-card-footer {
        padding: 15px;
    }
    
    .contact-card-footer .social-label {
        font-size: 11px;
        margin-bottom: 12px;
    }
    
    .contact-card-footer .social-icons {
        gap: 8px;
    }
    
    .contact-card-footer .social-icon {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }
    
    /* RTL adjustments for mobile */
    html[dir="rtl"] .contact-method .method-icon {
        margin-left: 12px;
    }
}

@media (max-width: 480px) {
    .contact-info-card {
        border-radius: 10px;
    }
    
    .contact-card-header {
        padding: 18px 12px;
    }
    
    .contact-card-header .header-icon {
        width: 45px;
        height: 45px;
        margin-bottom: 10px;
    }
    
    .contact-card-header .header-icon i {
        font-size: 20px;
    }
    
    .contact-card-header .header-title {
        font-size: 16px;
    }
    
    .contact-card-header .header-subtitle {
        font-size: 11px;
    }
    
    .contact-card-body {
        padding: 12px;
    }
    
    .contact-method {
        padding: 10px 12px;
        margin-bottom: 8px;
    }
    
    .contact-method .method-icon {
        width: 36px;
        height: 36px;
        margin-right: 10px;
    }
    
    .contact-method .method-icon i {
        font-size: 14px;
    }
    
    .contact-method .method-value {
        font-size: 12px;
    }
    
    .btn-contact-page,
    .btn-company-profile {
        padding: 11px 15px;
        font-size: 13px;
    }
    
    .contact-card-footer {
        padding: 12px;
    }
    
    .contact-card-footer .social-icon {
        width: 34px;
        height: 34px;
        font-size: 13px;
    }
    
    /* RTL adjustments for small mobile */
    html[dir="rtl"] .contact-method .method-icon {
        margin-left: 10px;
    }
}

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

@if($showProjectScheduleTour || $showProjectRequestInfo)
<script>
// Date picker for the tour form. Mirrors the offers page: clicking a day highlights it and
// writes the ISO date into the hidden field the controller validates.
document.addEventListener('DOMContentLoaded', function () {
    var days = document.querySelectorAll('#projectCalendarSlider .calendar-day');
    var hidden = document.getElementById('projectSelectedDate');

    days.forEach(function (day) {
        day.addEventListener('click', function () {
            days.forEach(function (d) { d.classList.remove('active'); });
            day.classList.add('active');
            if (hidden) { hidden.value = day.getAttribute('data-date'); }
        });
    });

    if (typeof jQuery !== 'undefined' && jQuery.fn.slick) {
        var $slider = jQuery('#projectCalendarSlider');
        if ($slider.length && !$slider.hasClass('slick-initialized')) {
            $slider.slick(JSON.parse($slider.attr('data-slick-options')));
            jQuery('#projectCalendarPrev').on('click', function () { $slider.slick('slickPrev'); });
            jQuery('#projectCalendarNext').on('click', function () { $slider.slick('slickNext'); });
        }
    }
});
</script>

    @include('includes.inquiry-form-scripts', [
        'inquiryFormSelector' => '.project-inquiry-form',
        'inquiryRecaptchaAction' => 'project_enquiry',
    ])
@endif
@endsection
