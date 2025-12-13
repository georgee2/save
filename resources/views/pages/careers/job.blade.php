@extends('layouts.master')
@if(App::getLocale() == 'en')
@section('title', $job->job_title_english)
@else
@section('title', $job->job_title_arabic)
@endif


@section('content')
<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ __('lang.career_details') }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <a href="{{ route('careers.index') }}">{{ __('lang.careers') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.job_details') }}</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
        </section>
        <!-- end: Breadcrumb Section -->

        <!-- start: Careers Section -->
        <section class="tj-careers-details section-gap">
          <div class="container">
            <div class="row rg-50">
              <div class="col-lg-8">
                <div class="tj-post-wrapper">
                  <div class="tj-post-single-post">
                    <!-- top content -->
                    <div class="tj-careers-top mb-30">
                      <div class="tj-careers-top-icon">
                        @if($job->icon)
                          <img src="{{ asset('storage' . $job->icon) }}" alt="{{ App::getLocale() == 'en' ? $job->job_title_english : $job->job_title_arabic }}" style="width: 60px; height: 60px; object-fit: contain;">
                        @else
                          <i class="tji-briefcase"></i>
                        @endif
                      </div>
                      <div class="tj-careers-top-content">
                        <div class="tj-careers-tag">
                          <span>{{ $job->job_type }}</span>
                          @php
                            $daysLeft = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($job->registration_end_date), false);
                          @endphp
                          @if($daysLeft <= 7 && $daysLeft >= 0)
                            <span style="background-color: #ff6b35; color: white;">{{ __('lang.urgent') }}</span>
                          @endif
                        </div>
                        <h4 class="tj-careers-top-title text-anim">{{ App::getLocale() == 'en' ? $job->job_title_english : $job->job_title_arabic }}</h4>
                        <span class="location">
                          <i class="tji-folder"></i>
                          {{ App::getLocale() == 'en' ? $job->job_category_english : $job->job_category_arabic }}
                        </span>
                      </div>
                    </div>
                    <!-- content -->
                    <div class="tj-entry-content">
                      <h4 class="text-anim">{{ __('lang.job_description') }}</h4>
                      <div class="wow fadeInUp" data-wow-delay="0.1s">
                        {!! App::getLocale() == 'en' ? $job->job_description_en : $job->job_description_ar !!}
                      </div>

                      @if((App::getLocale() == 'en' && $job->requirements_en) || (App::getLocale() == 'ar' && $job->requirements_ar))
                      <div class="tj-check-list mt-4">
                        <h4 class="text-anim">{{ __('lang.requirements') }}</h4>
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                          {!! App::getLocale() == 'en' ? $job->requirements_en : $job->requirements_ar !!}
                        </div>
                      </div>
                      @endif

                      @if((App::getLocale() == 'en' && $job->responsibilities_en) || (App::getLocale() == 'ar' && $job->responsibilities_ar))
                      <div class="tj-check-list mt-4">
                        <h4 class="text-anim">{{ __('lang.responsibilities') }}</h4>
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                          {!! App::getLocale() == 'en' ? $job->responsibilities_en : $job->responsibilities_ar !!}
                        </div>
                      </div>
                      @endif
                    </div>

                    <!-- post navigation -->
                    @if($relatedJobs->count() > 0)
                    <div class="tj-post__navigation mb-0 wow fadeInUp" data-wow-delay=".3s">
                      <div class="tj-nav-post__grid">
                        <a href="{{ route('careers.index') }}"><i class="tji-window"></i></a>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <aside class="tj-blog-sidebar">
                  <!-- Job information  -->
                  <div class="tj-sidebar-widget wow fadeInUp" data-wow-delay="0.1s">
                    <h4 class="widget-title">{{ __('lang.job_information') }}</h4>
                    <div class="project_catagory">
                      <ul>
                        <li>
                          <span class="first-child">{{ __('lang.category') }}</span>
                          <span>{{ App::getLocale() == 'en' ? $job->job_category_english : $job->job_category_arabic }}</span>
                        </li>
                        <li>
                          <span class="first-child">{{ __('lang.job_code') }}</span>
                          <span>{{ $job->code }}</span>
                        </li>
                        <li>
                          <span class="first-child">{{ __('lang.job_type') }}</span>
                          <span>{{ $job->job_type }}</span>
                        </li>
                        @if($job->show_salary && $job->salary)
                        <li>
                          <span class="first-child">{{ __('lang.salary') }}</span>
                          <span>{{ number_format($job->salary, 0) }} {{ __('lang.egp') }} {{ __('lang.per_month') }}</span>
                        </li>
                        @endif
                        <li>
                          <span class="first-child">{{ __('lang.apply_before') }}</span>
                          <span>{{ \Carbon\Carbon::parse($job->registration_end_date)->format('M d, Y') }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- apply form -->
                  <div class="tj-sidebar-widget wow fadeInUp" data-wow-delay="0.3s">
                    <h4 class="widget-title">{{ __('lang.apply_online') }}</h4>
                    
                    <div class="tj-careers-form">
                      <form action="{{ route('careers.apply', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-input">
                          <input type="text" name="applicant_name" value="{{ old('applicant_name') }}" placeholder="{{ __('lang.full_name') }}*" required>
                          @error('applicant_name')
                          <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="form-input">
                          <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.email') }}*" required>
                          @error('email')
                          <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="form-input">
                          <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ __('lang.phone') }}*" required>
                          @error('phone')
                          <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="form-input">
                          <textarea name="cover_letter" placeholder="{{ __('lang.cover_letter') }}">{{ old('cover_letter') }}</textarea>
                          @error('cover_letter')
                          <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="form-input reduce">
                          <label class="label" for="inputFile">{{ __('lang.attach_resume') }}</label>
                          <input type="file" id="inputFile" name="resume" accept=".pdf,.doc,.docx" required>
                          @error('resume')
                          <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="tj-careers-button">
                          <button type="submit" class="tj-primary-btn">
                            <span class="btn-text"><span>{{ __('lang.submit') }}</span></span>
                            <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- Related Jobs -->
                  @if($relatedJobs->count() > 0)
                  <div class="tj-sidebar-widget wow fadeInUp" data-wow-delay="0.5s">
                    <h4 class="widget-title">{{ App::getLocale() == 'en' ? 'Related Jobs' : 'وظائف ذات صلة' }}</h4>
                    <div class="tj-recent-posts">
                      <ul>
                        @foreach($relatedJobs as $relatedJob)
                        <li>
                          <div class="post-content">
                            <h6 class="post-title">
                              <a href="{{ route('careers.show', $relatedJob->id) }}">
                                {{ App::getLocale() == 'en' ? $relatedJob->job_title_english : $relatedJob->job_title_arabic }}
                              </a>
                            </h6>
                            <div class="blog-meta">
                              <ul>
                                <li><i class="tji-folder"></i> {{ App::getLocale() == 'en' ? $relatedJob->job_category_english : $relatedJob->job_category_arabic }}</li>
                                <li><i class="tji-briefcase"></i> {{ $relatedJob->job_type }}</li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                  @endif
                </aside>
              </div>
            </div>
          </div>
        </section>
        <!-- end: Careers Section -->

@endsection

@section('css')
<style>
    /* Make icon white with background */
    .tj-careers-top-icon {
        background: #ff6b35;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .tj-careers-top-icon img {
        filter: brightness(0) invert(1);
    }
    
    .tj-careers-top-icon i {
        color: #ffffff !important;
        font-size: 40px;
    }
    
    /* Add background to Job Information widget */
    .tj-sidebar-widget:first-child {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }
    
    .tj-sidebar-widget:first-child .widget-title {
        color: #1a1a1a;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .tj-sidebar-widget:first-child .project_catagory ul li {
        background: #ffffff;
        padding: 12px 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .tj-sidebar-widget:first-child .project_catagory ul li:hover {
        background: #fff5f2;
        border-color: #ff6b35;
        transform: translateX(5px);
    }
    
    .tj-sidebar-widget:first-child .project_catagory ul li .first-child {
        color: #6c757d;
    }
    
    /* Add background to Apply Online form widget */
    .tj-sidebar-widget:nth-child(2) {
        background: #ff6b35;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
    }
    
    .tj-sidebar-widget:nth-child(2) .widget-title {
        color: #ffffff;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .tj-sidebar-widget:nth-child(2) .tj-careers-form .form-input input,
    .tj-sidebar-widget:nth-child(2) .tj-careers-form .form-input textarea {
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .tj-sidebar-widget:nth-child(2) .tj-careers-form .form-input input:focus,
    .tj-sidebar-widget:nth-child(2) .tj-careers-form .form-input textarea:focus {
        background: #ffffff;
        border-color: #ffffff;
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
    }
    
    .tj-sidebar-widget:nth-child(2) .tj-careers-form .form-input.reduce label {
        color: #ffffff;
        font-weight: 600;
    }
    
    .tj-sidebar-widget:nth-child(2) .tj-careers-form .form-input.reduce input[type="file"] {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 8px;
        padding: 10px;
    }
    
    .tj-sidebar-widget:nth-child(2) .tj-careers-button .tj-primary-btn {
        background: #1a1a1a;
        color: #ffffff;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .tj-sidebar-widget:nth-child(2) .tj-careers-button .tj-primary-btn:hover {
        background: #000000;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    .tj-sidebar-widget:nth-child(2) .tj-careers-button .tj-primary-btn .btn-icon i {
        color: #ffffff;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ App::getLocale() == "en" ? "Success!" : "نجح!" }}',
            text: '{{ session("success") }}',
            confirmButtonText: '{{ App::getLocale() == "en" ? "OK" : "حسناً" }}',
            confirmButtonColor: '#667eea',
            background: '#fff',
            customClass: {
                popup: 'animated fadeInDown'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '{{ App::getLocale() == "en" ? "Error!" : "خطأ!" }}',
            text: '{{ session("error") }}',
            confirmButtonText: '{{ App::getLocale() == "en" ? "OK" : "حسناً" }}',
            confirmButtonColor: '#e74a3b',
            background: '#fff',
            customClass: {
                popup: 'animated fadeInDown'
            }
        });
    @endif

    @if($errors->any())
        let errorMessages = '<ul style="text-align: left; list-style: none; padding: 0;">';
        @foreach($errors->all() as $error)
            errorMessages += '<li style="margin-bottom: 8px;"><i class="fa fa-exclamation-circle"></i> {{ $error }}</li>';
        @endforeach
        errorMessages += '</ul>';
        
        Swal.fire({
            icon: 'error',
            title: '{{ App::getLocale() == "en" ? "Validation Error" : "خطأ في التحقق" }}',
            html: errorMessages,
            confirmButtonText: '{{ App::getLocale() == "en" ? "OK" : "حسناً" }}',
            confirmButtonColor: '#e74a3b',
            background: '#fff',
            customClass: {
                popup: 'animated fadeInDown'
            }
        });
    @endif
});
</script>
@endsection
