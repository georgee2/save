@extends('layouts.master')
@if(App::getLocale() == 'en')
@section('title' , $project->title_english)
@else
@section('title' , $project->title_arabic)
@endif

@if($project->seo_tags != null)
@section('seo_tags'){{ $project->seo_tags }}@endsection
@endif

@if(App::getLocale() == 'en')
@if($project->seo_des_en != null)
@section('seo_desc'){{ $project->seo_des_en }}@endsection
@endif
@else
@if($project->seo_des_ar != null)
@section('seo_desc'){{ $project->seo_des_ar }}@endsection
@endif
@endif

@section('css')
<style>
/* Section Headers Style */
.section-header {
  position: relative;
  display: inline-block;
  margin-bottom: 30px;
  padding-bottom: 15px;
}

.section-header::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #ff5722 0%, #ff7043 100%);
  border-radius: 2px;
}

.section-header img {
  margin-right: 10px;
  vertical-align: middle;
}

h3.section-header {
  font-size: 28px;
  font-weight: 700;
  color: #1a1a1a;
}

/* Project Specifications Hover Effects */
.spec-item:hover {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%) !important;
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(255, 87, 34, 0.3);
}

.spec-item:hover .spec-icon {
  background: rgba(255, 255, 255, 0.2) !important;
  transform: scale(1.1);
}

.spec-item:hover .spec-icon i {
  color: #fff !important;
}

.spec-item:hover .spec-icon img {
  filter: brightness(0) invert(1);
}

.spec-item:hover .spec-text h6 {
  color: #fff !important;
}

/* Project Sidebar Enhancements */
.tj-sidebar-widget.widget-categories .infos-item {
  display: flex;
  align-items: center;
  padding: 20px;
  margin-bottom: 15px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 10px;
  transition: all 0.3s ease;
}

.tj-sidebar-widget.widget-categories .infos-item:hover {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  transform: translateX(5px);
  box-shadow: 0 5px 15px rgba(255, 87, 34, 0.3);
}

.tj-sidebar-widget.widget-categories .infos-item:hover .project-icons {
  background: rgba(255, 255, 255, 0.2);
  transform: scale(1.1);
}

.tj-sidebar-widget.widget-categories .infos-item:hover .project-icons i {
  color: #fff;
}

.tj-sidebar-widget.widget-categories .infos-item:hover .project-text span,
.tj-sidebar-widget.widget-categories .infos-item:hover .project-text .title {
  color: #fff;
}

.tj-sidebar-widget.widget-categories .infos-item:hover .project-text .title a {
  color: #fff !important;
}

.tj-sidebar-widget.widget-categories .project-icons {
  background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%);
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
  flex-shrink: 0;
  transition: all 0.3s ease;
}

.tj-sidebar-widget.widget-categories .project-icons i {
  font-size: 24px;
  color: #ff5722;
  transition: all 0.3s ease;
}

.tj-sidebar-widget.widget-categories .project-text {
  flex: 1;
}

.tj-sidebar-widget.widget-categories .project-text span {
  display: block;
  font-size: 12px;
  color: #666;
  text-transform: uppercase;
  font-weight: 600;
  margin-bottom: 5px;
  transition: color 0.3s ease;
}

.tj-sidebar-widget.widget-categories .project-text .title {
  font-size: 16px;
  font-weight: 600;
  color: #1a1a1a;
  margin: 0;
  line-height: 1.4;
  transition: color 0.3s ease;
}

.tj-sidebar-widget.widget-categories .project-text .title a {
  color: #ff5722;
  text-decoration: none;
  transition: color 0.3s ease;
}

.tj-sidebar-widget.widget-categories .project-text .title a:hover {
  color: #fff;
}
/* Feasibility Studies Accordion Styling */
.accordion-button:not(.collapsed) {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%) !important;
  color: #fff !important;
  box-shadow: none;
}

.accordion-button:not(.collapsed) .study-header-content h5,
.accordion-button:not(.collapsed) .study-header-content span {
  color: #fff !important;
}

.accordion-button:focus {
  box-shadow: none;
  border-color: transparent;
}

.accordion-button::after {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23666'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-button:not(.collapsed)::after {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-item {
  border: none !important;
}

.accordion-button:hover {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%) !important;
  color: #fff !important;
}

.accordion-button:hover .study-header-content h5,
.accordion-button:hover .study-header-content span {
  color: #fff !important;
}

/* Enhanced Table Styling */
.fs-table {
  border: 1px solid #dee2e6;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  margin-bottom: 0;
}

.fs-table thead {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.fs-table thead th {
  border-color: #dee2e6;
  padding: 15px 12px;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 12px;
  letter-spacing: 0.5px;
  color: #495057;
  border-bottom: 2px solid #dee2e6;
}

.fs-table tbody td {
  border-color: #dee2e6;
  padding: 12px;
  vertical-align: middle;
  color: #495057;
  transition: background-color 0.2s ease;
}

.fs-table tbody tr:hover td {
  background-color: #f8f9fa;
}

.fs-table tbody tr:nth-child(even) {
  background-color: #fafbfc;
}

.fs-table tbody tr:nth-child(even):hover {
  background-color: #f8f9fa;
}

/* Total Row Styling */
.fs-table tbody tr[style*="background: #f8f9fa"] td,
.fs-table tbody tr[style*="background:#f8f9fa"] td {
  background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%) !important;
  font-weight: 600;
  color: #212529;
  border-top: 2px solid #dee2e6;
}

/* Grand Total Row Styling */
.fs-table tbody tr[style*="linear-gradient(135deg, #ff5722"] td {
  font-weight: 700;
  font-size: 15px;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.fs-table tbody tr[style*="linear-gradient(135deg, #28a745"] td {
  font-weight: 700;
  font-size: 15px;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Responsive Table */
.table-responsive {
  border-radius: 10px;
  overflow: hidden;
}

@media (max-width: 768px) {
  .fs-table {
    font-size: 12px;
  }
  
  .fs-table thead th,
  .fs-table tbody td {
    padding: 10px 8px;
  }
}
</style>
@endsection

@section('content')

<!-- start: Breadcrumb Section -->
<section class="tj-page-header section-gap-x" data-bg-image="{{ asset('storage/' . $project->cover_image) }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">
            @if(App::getLocale() == 'en')
              {{ $project->title_english }}
            @else
              {{ $project->title_arabic }}
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
              <a href="#">
                @if(App::getLocale() == 'en')
                  Projects
                @else
                  المشاريع
                @endif
              </a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              <span>
                @if(App::getLocale() == 'en')
                  {{ $project->title_english }}
                @else
                  {{ $project->title_arabic }}
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

<!-- start: Project Details Section -->
<section class="tj-blog-section section-gap slidebar-stickiy-container">
  <div class="container">
    <div class="row row-gap-5 align-items-start">
      <!-- Main Content -->
      <div class="col-lg-8">
        <div class="post-details-wrapper">
          <!-- Project Cover Image -->
          @if($project->page_image)
          <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
            <img src="{{ asset('storage/' . $project->page_image) }}" alt="{{ App::getLocale() == 'en' ? $project->title_english : $project->title_arabic }}" style="width: 100%; height: auto; object-fit: cover; border-radius: 10px;">
          </div>
          @endif
          
          <!-- Project Title -->
          <h2 class="title title-anim">
            @if(App::getLocale() == 'en')
              {{ $project->title_english }}
            @else
              {{ $project->title_arabic }}
            @endif
          </h2>
          
          <!-- Project Description -->
          <div class="blog-text">
            @if($project->description_english || $project->description_arabic)
            <p class="wow fadeInUp" data-wow-delay=".3s">
              @if(App::getLocale() == 'en')
                {!! $project->description_english !!}
              @else
                {!! $project->description_arabic !!}
              @endif
            </p>
            @endif
            
            <!-- Project Images (3D & Site) -->
            @if($project->plan_3d_image || $project->site_image)
            <div class="row wow fadeInUp" data-wow-delay=".3s" style="margin-top: 30px; margin-bottom: 30px;">
              @php
                $hasOnlyOneImage = ($project->plan_3d_image && !$project->site_image) || (!$project->plan_3d_image && $project->site_image);
                $colClass = $hasOnlyOneImage ? 'col-12 d-flex justify-content-center' : 'col-md-6';
              @endphp
              
              @if($project->plan_3d_image)
              <div class="{{ $colClass }} mb-3">
                <div class="image-box" style="max-width: {{ $hasOnlyOneImage ? '600px' : '100%' }}; width: 100%;">
                  <a class="gallery" data-gall="project-gallery" href="{{ asset('storage/' . $project->plan_3d_image) }}">
                    <img src="{{ asset('storage/' . $project->plan_3d_image) }}" alt="3D Visualization" style="width: 100%; height: auto; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                  </a>
                </div>
              </div>
              @endif
              
              @if($project->site_image)
              <div class="{{ $colClass }} mb-3">
                <div class="image-box" style="max-width: {{ $hasOnlyOneImage ? '600px' : '100%' }}; width: 100%;">
                  <a class="gallery" data-gall="project-gallery" href="{{ asset('storage/' . $project->site_image) }}">
                    <img src="{{ asset('storage/' . $project->site_image) }}" alt="Site Image" style="width: 100%; height: auto; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                  </a>
                </div>
              </div>
              @endif
            </div>
            @endif
            
            <!-- Project Specifications -->
            @if($project->specifications && $project->specifications->count() > 0)
            <h3 class="section-header wow fadeInUp" data-wow-delay=".3s">
              <img src="{{url('/pic/svg40.svg')}}">
              @if(App::getLocale() == 'en')
                Project Specifications
              @else
                مواصفات المشروع
              @endif
            </h3>
            <div class="row wow fadeInUp" data-wow-delay=".3s" style="margin-top: 30px;">
              @foreach($project->specifications as $projectSpec)
                @if($projectSpec->specification)
                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="spec-item" style="display: flex; align-items: center; padding: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; transition: all 0.3s ease;">
                    @if($projectSpec->specification->icon)
                    <div class="spec-icon" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%); display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                      <img src="{{ asset('storage' . $projectSpec->specification->icon) }}" alt="{{ App::getLocale() == 'en' ? $projectSpec->specification->title_english : $projectSpec->specification->title_arabic }}" style="width: 40px; height: 40px; object-fit: contain;">
                    </div>
                    @else
                    <div class="spec-icon" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%); display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                      <i class="tji-check" style="font-size: 24px; color: #ff5722;"></i>
                    </div>
                    @endif
                    <div class="spec-text" style="flex: 1;">
                      <h6 style="margin: 0; font-size: 14px; font-weight: 600; color: #1a1a1a; line-height: 1.4;">
                        @if(App::getLocale() == 'en')
                          {{ $projectSpec->specification->title_english }}
                        @else
                          {{ $projectSpec->specification->title_arabic }}
                        @endif
                      </h6>
                      @if($projectSpec->value_english || $projectSpec->value_arabic)
                      <p style="margin: 5px 0 0 0; font-size: 12px; color: #666; line-height: 1.3;">
                        @if(App::getLocale() == 'en')
                          {{ $projectSpec->value_english }}
                        @else
                          {{ $projectSpec->value_arabic }}
                        @endif
                      </p>
                      @endif
                    </div>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
            @endif
          </div>
        </div>
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="tj-main-sidebar slidebar-stickiy">
          <div class="tj-sidebar-widget widget-categories wow fadeInUp" data-wow-delay=".1s">
            <h4 class="widget-title">
              @if(App::getLocale() == 'en')
                <img src="{{url('/pic/svg40.svg')}}"> Project Info
              @else
                معلومات المشروع
              @endif
            </h4>
            
            <!-- Category -->
            @if($project->category)
            <div class="infos-item">
              <div class="project-icons">
                <i class="tji-chart"></i>
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Category
                  @else
                    الفئة
                  @endif
                </span>
                <h6 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $project->category->title_english }}
                  @else
                    {{ $project->category->title_arabic }}
                  @endif
                </h6>
              </div>
            </div>
            @endif
            
            <!-- Type -->
            @if($project->type)
            <div class="infos-item">
              <div class="project-icons">
                <i class="tji-service-1"></i>
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Type
                  @else
                    النوع
                  @endif
                </span>
                <h6 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $project->type->name_english }}
                  @else
                    {{ $project->type->name_arabic }}
                  @endif
                </h6>
              </div>
            </div>
            @endif
            
            <!-- Style -->
            @if($project->style)
            <div class="infos-item">
              <div class="project-icons">
                <i class="fa fa-tools"></i>
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Style
                  @else
                    الأسلوب
                  @endif
                </span>
                <h6 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $project->style->title_english }}
                  @else
                    {{ $project->style->title_arabic }}
                  @endif
                </h6>
              </div>
            </div>
            @endif
            
            <!-- Area -->
            @if($project->sqm || $project->sqft)
            <div class="infos-item">
              <div class="project-icons">
                <i class="tji-location-2"></i>
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Area
                  @else
                    المساحة
                  @endif
                </span>
                <h6 class="title">
                  @if($project->sqm)
                    {{ number_format($project->sqm, 2) }} m²
                  @endif
                  @if($project->sqm && $project->sqft)
                    /
                  @endif
                  @if($project->sqft)
                    {{ number_format($project->sqft, 2) }} ft²
                  @endif
                </h6>
              </div>
            </div>
            @endif
            
            <!-- Partner -->
            @if($project->partner)
            <div class="infos-item">
              <div class="project-icons">
                <i class="tji-user"></i>
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Partner
                  @else
                    الشريك
                  @endif
                </span>
                <h6 class="title">
                  @if(App::getLocale() == 'en')
                    {{ $project->partner->name_english }}
                  @else
                    {{ $project->partner->name_arabic }}
                  @endif
                </h6>
              </div>
            </div>
            @endif
            
            <!-- Video URL -->
            @if($project->video_url)
            <div class="infos-item">
              <div class="project-icons">
                <i class="tji-play"></i>
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Video
                  @else
                    فيديو
                  @endif
                </span>
                <h6 class="title">
                  <a href="{{ $project->video_url }}" target="_blank" style="color: #ff5722;">
                    @if(App::getLocale() == 'en')
                      Watch Video
                    @else
                      شاهد الفيديو
                    @endif
                  </a>
                </h6>
              </div>
            </div>
            @endif
            
            <!-- Tour URL -->
            @if($project->tour_url)
            <div class="infos-item">
              <div class="project-icons">
                <i class="fa fa-video-camera"></i>
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Virtual Tour
                  @else
                    جولة افتراضية
                  @endif
                </span>
                <h6 class="title">
                  <a href="{{ $project->tour_url }}" target="_blank">
                    @if(App::getLocale() == 'en')
                      Take Tour
                    @else
                      خذ جولة
                    @endif
                  </a>
                </h6>
              </div>
            </div>
            @endif
            
            <!-- Project File (PDF) -->
            @if($project->plan_2d_image)
            <div class="infos-item">
              <div class="project-icons">
                <img src="{{ asset('pic/pdf.png') }}" alt="PDF" style="width: 24px; height: 24px; object-fit: contain;">
              </div>
              <div class="project-text">
                <span>
                  @if(App::getLocale() == 'en')
                    Project File
                  @else
                    ملف المشروع
                  @endif
                </span>
                <h6 class="title">
                  <a href="{{ asset('storage' . $project->plan_2d_image) }}" download>
                    @if(App::getLocale() == 'en')
                      Download PDF
                    @else
                      تحميل PDF
                    @endif
                  </a>
                </h6>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end: Project Details Section -->

<!-- Include Project Floors -->
@include('pages.projects.partials.floors')

<!-- Include Feasibility Studies -->
@include('pages.projects.partials.feasibility-studies')

<!-- Include Project Gallery -->
@include('pages.projects.partials.gallery')

@endsection
