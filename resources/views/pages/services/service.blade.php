@extends('layouts.master')
@if(App::getLocale() == 'en')
@section('title' , App::getLocale() == 'en' ? $service->title_english : $service->title_arabic)
@else
@section('title' , App::getLocale() == 'en' ? $service->title_english : $service->title_arabic)
@endif

@if($service->seo_tags != null)
@section('seo_tags'){{ $service->seo_tags }}@endsection
@endif

@if(App::getLocale() == 'en')
@if($service->seo_des_en != null)
@section('seo_desc'){{ $service->seo_des_en }}@endsection
@endif
@else
@if($service->seo_des_ar != null)
@section('seo_desc'){{ $service->seo_des_ar }}@endsection
@endif
@endif

@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/service-enhancements.css')}}">
<style>
/* ==========================================
   Enhanced Service Details Section
   ========================================== */

/* Service Details Section */
.tj-service-details-section {
  position: relative;
  overflow: hidden;
}

/* Service Image Wrapper with Modern Design */
.service-image-wrapper {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  transition: all 0.4s ease;
}

.service-image-wrapper:hover {
  transform: translateY(-10px);
  box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
}

.service-main-image {
  width: 100%;
  height: auto;
  min-height: 400px;
  object-fit: cover;
  display: block;
  border-radius: 20px;
  transition: transform 0.6s ease;
}

.service-image-wrapper:hover .service-main-image {
  transform: scale(1.05);
}

/* Image Overlay with Gradient */
.service-image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(255, 90, 0, 0.1) 0%, rgba(255, 90, 0, 0.3) 100%);
  opacity: 0;
  transition: opacity 0.4s ease;
  border-radius: 20px;
  pointer-events: none;
}

.service-image-wrapper:hover .service-image-overlay {
  opacity: 1;
}

/* Decorative Shape Behind Image */
.service-image-shape {
  position: absolute;
  top: -20px;
  right: -20px;
  width: 150px;
  height: 150px;
  background: linear-gradient(135deg, var(--tj-color-theme-primary, #FF5A00) 0%, #ff7043 100%);
  border-radius: 50%;
  opacity: 0.15;
  z-index: -1;
  transition: all 0.4s ease;
}

.service-image-wrapper:hover .service-image-shape {
  transform: scale(1.2);
  opacity: 0.25;
}

/* Service Badge */
.service-badge {
  display: inline-block;
}

.badge-text {
  display: inline-block;
  padding: 8px 20px;
  background: linear-gradient(135deg, var(--tj-color-theme-primary, #FF5A00) 0%, #ff7043 100%);
  color: #ffffff;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 50px;
  box-shadow: 0 4px 15px rgba(255, 90, 0, 0.3);
  transition: all 0.3s ease;
}

.badge-text:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 90, 0, 0.4);
}

/* Service Details Title */
.service-details-title {
  font-size: 42px;
  font-weight: 700;
  line-height: 1.2;
  color: var(--tj-color-heading-primary, #1a1a1a);
  margin-bottom: 20px;
}

/* Service Details Description */
.service-details-description {
  font-size: 16px;
  line-height: 1.8;
  color: var(--tj-color-text-body, #666);
}

.service-details-description p {
  margin-bottom: 15px;
}

.service-details-description p:last-child {
  margin-bottom: 0;
}

/* Service Details Content */
.service-details-content {
  padding: 20px 0;
}

/* Responsive Design */
@media only screen and (max-width: 991px) {
  .service-details-title {
    font-size: 32px;
  }
  
  .service-main-image {
    min-height: 300px;
  }
  
  .service-details-content {
    padding: 0;
    margin-top: 30px;
  }
  
  .service-image-shape {
    width: 100px;
    height: 100px;
    top: -15px;
    right: -15px;
  }
}

@media only screen and (max-width: 575px) {
  .service-details-title {
    font-size: 28px;
  }
  
  .service-details-description {
    font-size: 15px;
  }
  
  .service-main-image {
    min-height: 250px;
  }
  
  .badge-text {
    font-size: 12px;
    padding: 6px 16px;
  }
}

/* Override default style-6 to always show content */
.service-item.style-6.feature-hover-item .service-content {
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
  max-height: none !important;
  height: auto !important;
  overflow: visible !important;
  position: static !important;
  transform: none !important;
}

.service-item.style-6.feature-hover-item .service-content .desc {
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
  height: auto !important;
  max-height: none !important;
  overflow: visible !important;
}

/* Force show on hover too - Override the default style-6 behavior that hides desc on hover */
.service-item.style-6.feature-hover-item:hover .service-content {
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
  transform: none !important;
}

.service-item.style-6.feature-hover-item:hover .service-content .desc {
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
  transform: scaleY(1) !important;
}

/* Override the default hiding behavior */
.service-item.style-6.feature-hover-item:hover .desc {
  opacity: 1 !important;
  visibility: visible !important;
  transform: scaleY(1) !important;
}

/* Features Hover Effects */
.feature-hover-item {
  transition: all 0.3s ease;
}

/* Default colors (before hover) */
.feature-hover-item .title {
  color: #1a1a1a !important;
  transition: color 0.3s ease;
}

.feature-hover-item .desc {
  color: #666 !important;
  transition: color 0.3s ease;
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
}

/* Make sure paragraphs inside desc are visible */
.feature-hover-item .service-content p {
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
  margin: 10px 0 !important;
}

/* Hover effects */
.feature-hover-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%) !important;
  border-radius: 15px;
}

.feature-hover-item:hover .title {
  color: #fff !important;
}

.feature-hover-item:hover .desc {
  color: #fff !important;
}

.feature-hover-item:hover .service-icon {
  background: rgba(255, 255, 255, 0.2) !important;
  transform: scale(1.05);
  transition: all 0.3s ease;
}

.feature-hover-item:hover .service-icon img {
  filter: brightness(0) invert(1);
}

/* Values Section Styling and Hover Effects */
.choose-icon {
  position: relative;
}

.values-icon-bg {
  background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%);
  width: 100px;
  height: 100px;
  border-radius: 50%;
  display: flex !important;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  transition: all 0.3s ease;
  opacity: 1 !important;
  visibility: visible !important;
}

.values-icon-bg img {
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
  transition: filter 0.3s ease;
  width: 50px;
  height: 50px;
  object-fit: contain;
}

.h7-choose-box:hover .choose-icon {
  opacity: 1 !important;
  visibility: visible !important;
}

.h7-choose-box:hover .values-icon-bg {
  background: rgba(255, 255, 255, 0.2) !important;
  transform: scale(1.05);
  display: flex !important;
  opacity: 1 !important;
  visibility: visible !important;
}

.h7-choose-box:hover .values-icon-bg img {
  filter: brightness(0) invert(1) !important;
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
}

.h7-choose-box:hover .choose-icon img {
  filter: brightness(0) invert(1) !important;
  display: block !important;
  opacity: 1 !important;
  visibility: visible !important;
}

/* Process Section Hover Effects */
.process-icon-bg {
  background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%);
  width: 100px;
  height: 100px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  transition: all 0.3s ease;
}

.service-item.style-4:hover .process-icon-bg {
  background: rgba(255, 255, 255, 0.2) !important;
  transform: scale(1.05);
}

.service-item.style-4:hover .service-icon img {
  filter: brightness(0) invert(1);
  transition: filter 0.3s ease;
}

.service-item.style-4 .service-icon img {
  transition: filter 0.3s ease;
}
</style>
@endsection
@section('content')

<!-- start: Breadcrumb Section -->
<section class="tj-page-header section-gap-x" @if($service->hero_image) data-bg-image="{{ asset('storage/' . $service->hero_image) }}" @else data-bg-image="{{ asset('assets/images/bg/pheader-bg.webp') }}" @endif>
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">
            @if(App::getLocale() == 'en')
              {{ $service->title_english }}
            @else
              {{ $service->title_arabic }}
            @endif
          </h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
              <a href="{{ url(App::getLocale() . '/') }}">
                @if(App::getLocale() == 'en')
                  Home
                @else
                  الرئيسية
                @endif
              </a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              <a href="{{ route('services.index') }}">
                @if(App::getLocale() == 'en')
                  Services
                @else
                  الخدمات
                @endif
              </a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
              <span>
                @if(App::getLocale() == 'en')
                  {{ $service->title_english }}
                @else
                  {{ $service->title_arabic }}
                @endif
              </span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
  <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
        </section>
        <!-- end: Breadcrumb Section -->


<!-- start: Service Details Section -->
<section class="tj-service-details-section" style="padding: 80px 0;">
  <div class="container">
    <div class="row align-items-center g-4">
      @if($service->main_image)
      <div class="col-lg-6 order-2 order-lg-1">
        <div class="service-details-image wow fadeInLeft" data-wow-delay=".2s">
          <div class="service-image-wrapper">
            <img src="{{ asset('storage/' . $service->main_image) }}" 
                 alt="{{ App::getLocale() == 'en' ? $service->title_english : $service->title_arabic }}" 
                 class="service-main-image">
            <div class="service-image-overlay"></div>
            <div class="service-image-shape"></div>
          </div>
        </div>
      </div>
      @endif
      
      <div class="{{ $service->main_image ? 'col-lg-6 order-1 order-lg-2' : 'col-lg-12' }}">
        <div class="service-details-content wow fadeInRight" data-wow-delay=".3s">
          <div class="service-badge mb-3">
            <span class="badge-text">
              @if(App::getLocale() == 'en')
                Our Service
              @else
                خدمتنا
              @endif
            </span>
          </div>
          
          <h2 class="service-details-title mb-4">
            @if(App::getLocale() == 'en')
              {{ $service->title_english }}
            @else
              {{ $service->title_arabic }}
            @endif
          </h2>
          
          <!-- Decorative Line with Logo -->
          <div class="title-divider-with-logo wow fadeInUp" data-wow-delay=".4s">
            <span class="divider-line divider-line-left"></span>
            <span class="divider-logo">
              <img src="{{url('/pic/logosvg.svg')}}" alt="Logo">
            </span>
            <span class="divider-line divider-line-right"></span>
          </div>
          
          <div class="service-details-description">
            @if(App::getLocale() == 'en')
              {!! $service->description_english !!}
            @else
              {!! $service->description_arabic !!}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end: Service Details Section -->


{{-- Render sections based on ordering --}}
@php
    // Get ordered sections from database
    $orderedSections = $service->sectionOrders->where('is_visible', true)->sortBy('order');
    
    // Convert to array for easier manipulation
    $sectionsArray = [];
    
    if ($orderedSections->isNotEmpty()) {
        // Use database-defined sections
        foreach ($orderedSections as $section) {
            $sectionsArray[] = [
                'type' => $section->section_type,
                'id' => $section->section_id,
                'object' => $section
            ];
        }
        
        // IMPORTANT: Add sub_services after features if not already in the list
        $hasSubServices = collect($sectionsArray)->contains(function($s) {
            return $s['type'] == 'sub_services' || $s['type'] == 'subservices';
        });
        
        if (!$hasSubServices && $service->subServices && $service->subServices->count() > 0) {
            // Find the position after 'features'
            $featuresIndex = -1;
            foreach ($sectionsArray as $index => $section) {
                if ($section['type'] == 'features') {
                    $featuresIndex = $index;
                    break;
                }
            }
            
            // Insert sub_services after features
            if ($featuresIndex >= 0) {
                array_splice($sectionsArray, $featuresIndex + 1, 0, [['type' => 'sub_services', 'id' => null, 'object' => null]]);
            } else {
                // If no features section, add at the beginning
                array_unshift($sectionsArray, ['type' => 'sub_services', 'id' => null, 'object' => null]);
            }
        }
    } else {
        // No section orders defined, use default order
        $sectionsArray = [
            ['type' => 'features', 'id' => null, 'object' => null],
            ['type' => 'sub_services', 'id' => null, 'object' => null],
            ['type' => 'values', 'id' => null, 'object' => null],
            ['type' => 'process', 'id' => null, 'object' => null],
            ['type' => 'faq', 'id' => null, 'object' => null],
        ];
        
        // Add custom blocks
        foreach ($service->blocks as $block) {
            $sectionsArray[] = ['type' => 'custom_block', 'id' => $block->id, 'object' => null];
        }
    }
    
    $orderedSections = collect($sectionsArray);
@endphp

@foreach($orderedSections as $section)
    @php
        $sectionType = $section['type'];
        $sectionId = $section['id'] ?? null;
        
        // Get the block object if it's a custom_block to check its type
        $blockObject = null;
        if ($sectionType == 'custom_block' && $sectionId) {
            $blockObject = $service->blocks->firstWhere('id', $sectionId);
        }
    @endphp
    
    @if($sectionType == 'features')
        @include('pages.services.partials.features')
    @elseif($sectionType == 'sub_services' || $sectionType == 'subservices')
        @include('pages.services.partials.subservices')
    @elseif($sectionType == 'values')
        @include('pages.services.partials.values')
    @elseif($sectionType == 'process')
        @include('pages.services.partials.process')
    @elseif($sectionType == 'faq' || $sectionType == 'faqs')
        @include('pages.services.partials.faq')
    @elseif($sectionType == 'custom_block' && $sectionId && $blockObject)
        @if($blockObject->block_type == 'banner')
            @include('pages.services.partials.banner', ['blockId' => $sectionId])
        @elseif($blockObject->block_type == 'image_with_text')
            @include('pages.services.partials.blocks', ['blockId' => $sectionId])
        @endif
    @elseif($sectionType == 'main_info' || $sectionType == 'description')
        {{-- These sections are handled in the main content area above --}}
    @endif
@endforeach



        



        




@endsection