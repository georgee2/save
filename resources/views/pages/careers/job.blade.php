@extends('layouts.master')

@section('title', app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english)

@section('seo_desc', Str::limit(strip_tags(app()->getLocale() == 'ar' ? $job->job_description_ar : $job->job_description_en), 160))

@section('seo_tags', (app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english) . ', ' . (app()->getLocale() == 'ar' ? $job->job_category_arabic : $job->job_category_english))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/careers-page.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/job-single.css') }}?v={{ time() }}">
@endsection

@section('content')

{{-- Hero Section --}}
<section class="job-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="job-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="job-hero-bg job-hero-gradient"></div>
    @endif
    <div class="job-hero-overlay"></div>
    <div class="container position-relative">
        <div class="job-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('careers.index') }}">{{ __('lang.careers') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english }}
                    </li>
                </ol>
            </nav>
            <div class="job-type-badge-hero {{ strtolower(str_replace(' ', '-', $job->job_type)) }}">
                {{ $job->job_type }}
            </div>
            <h1 class="job-hero-title">{{ app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english }}</h1>
            <p class="job-hero-category">
                <i class="fal fa-folder-open"></i>
                {{ app()->getLocale() == 'ar' ? $job->job_category_arabic : $job->job_category_english }}
            </p>
        </div>
    </div>
</section>

{{-- Job Details Section --}}
<section class="job-details-section py-12">
    <div class="container">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="job-content-card">
                    {{-- Job Quick Info --}}
                    <div class="job-quick-info mb-6">
                        <div class="quick-info-item">
                            <div class="quick-info-icon">
                                <i class="fal fa-briefcase"></i>
                            </div>
                            <div class="quick-info-content">
                                <span class="quick-info-label">{{ __('lang.job_type') }}</span>
                                <span class="quick-info-value">{{ $job->job_type }}</span>
                            </div>
                        </div>
                        <div class="quick-info-item">
                            <div class="quick-info-icon">
                                <i class="fal fa-calendar-alt"></i>
                            </div>
                            <div class="quick-info-content">
                                <span class="quick-info-label">{{ __('lang.deadline') }}</span>
                                <span class="quick-info-value">{{ \Carbon\Carbon::parse($job->registration_end_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @if($job->show_salary && $job->salary)
                        <div class="quick-info-item">
                            <div class="quick-info-icon">
                                <i class="fal fa-money-bill-alt"></i>
                            </div>
                            <div class="quick-info-content">
                                <span class="quick-info-label">{{ __('lang.salary') }}</span>
                                <span class="quick-info-value">{{ number_format($job->salary, 0) }} AED</span>
                            </div>
                        </div>
                        @endif
                        <div class="quick-info-item">
                            <div class="quick-info-icon">
                                <i class="fal fa-hashtag"></i>
                            </div>
                            <div class="quick-info-content">
                                <span class="quick-info-label">{{ __('lang.job_code') }}</span>
                                <span class="quick-info-value">{{ $job->code }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Job Description --}}
                    <div class="job-section">
                        <h3 class="job-section-title">
                            <i class="fal fa-file-alt"></i>
                            {{ __('lang.job_description') }}
                        </h3>
                        <div class="job-section-content">
                            {!! app()->getLocale() == 'ar' ? $job->job_description_ar : $job->job_description_en !!}
                        </div>
                    </div>

                    {{-- Requirements --}}
                    @if((app()->getLocale() == 'ar' && $job->requirements_ar) || (app()->getLocale() == 'en' && $job->requirements_en))
                    <div class="job-section">
                        <h3 class="job-section-title">
                            <i class="fal fa-clipboard-list"></i>
                            {{ __('lang.requirements') }}
                        </h3>
                        <div class="job-section-content">
                            {!! app()->getLocale() == 'ar' ? $job->requirements_ar : $job->requirements_en !!}
                        </div>
                    </div>
                    @endif

                    {{-- Responsibilities --}}
                    @if((app()->getLocale() == 'ar' && $job->responsibilities_ar) || (app()->getLocale() == 'en' && $job->responsibilities_en))
                    <div class="job-section">
                        <h3 class="job-section-title">
                            <i class="fal fa-tasks"></i>
                            {{ __('lang.responsibilities') }}
                        </h3>
                        <div class="job-section-content">
                            {!! app()->getLocale() == 'ar' ? $job->responsibilities_ar : $job->responsibilities_en !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Application Form Card --}}
                <div class="application-card">
                    <div class="application-card-header">
                        <h4 class="application-title">
                            <i class="fal fa-paper-plane"></i>
                            {{ __('lang.apply_now') }}
                        </h4>
                        <p class="application-subtitle">{{ __('lang.application_form_subtitle') }}</p>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fal fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fal fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('careers.apply', $job->id) }}" method="POST" enctype="multipart/form-data" class="application-form" id="applicationForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="applicant_name">
                                <i class="fal fa-user"></i>
                                {{ __('lang.full_name') }} <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('applicant_name') is-invalid @enderror" 
                                   id="applicant_name" 
                                   name="applicant_name" 
                                   value="{{ old('applicant_name') }}"
                                   placeholder="{{ __('lang.enter_your_name') }}"
                                   required>
                            @error('applicant_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="fal fa-envelope"></i>
                                {{ __('lang.email') }} <span class="required">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('lang.enter_your_email') }}"
                                   required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">
                                <i class="fal fa-phone"></i>
                                {{ __('lang.phone') }} <span class="required">*</span>
                            </label>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   placeholder="{{ __('lang.enter_your_phone') }}"
                                   required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="resume">
                                <i class="fal fa-file-pdf"></i>
                                {{ __('lang.resume_cv') }} <span class="required">*</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" 
                                       class="form-control-file @error('resume') is-invalid @enderror" 
                                       id="resume" 
                                       name="resume" 
                                       accept=".pdf,.doc,.docx"
                                       required>
                                <div class="file-upload-info">
                                    <i class="fal fa-cloud-upload"></i>
                                    <span class="file-name">{{ __('lang.choose_file') }}</span>
                                    <small>PDF, DOC, DOCX ({{ __('lang.max_5mb') }})</small>
                                </div>
                            </div>
                            @error('resume')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cover_letter">
                                <i class="fal fa-file-signature"></i>
                                {{ __('lang.cover_letter') }}
                            </label>
                            <textarea class="form-control @error('cover_letter') is-invalid @enderror" 
                                      id="cover_letter" 
                                      name="cover_letter" 
                                      rows="4"
                                      placeholder="{{ __('lang.cover_letter_placeholder') }}">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-apply-submit">
                            <i class="fal fa-paper-plane"></i>
                            {{ __('lang.submit_application') }}
                        </button>
                    </form>

                    <div class="application-deadline">
                        <i class="fal fa-clock"></i>
                        {{ __('lang.applications_close') }}: 
                        <strong>{{ \Carbon\Carbon::parse($job->registration_end_date)->format('M d, Y') }}</strong>
                    </div>
                </div>

                {{-- Share Card --}}
                <div class="share-job-card mt-4">
                    <h5 class="share-title">
                        <i class="fal fa-share-alt"></i>
                        {{ __('lang.share_job') }}
                    </h5>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode(app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english) }}" 
                           target="_blank" 
                           class="share-btn twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode(app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english) }}" 
                           target="_blank" 
                           class="share-btn linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode((app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english) . ' - ' . request()->url()) }}" 
                           target="_blank" 
                           class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <button class="share-btn copy-link" onclick="copyJobLink()">
                            <i class="fal fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Jobs Section --}}
@if($relatedJobs->count() > 0)
<section class="related-jobs-section py-12">
    <div class="container">
        <div class="section-header text-center mb-8">
            <div class="section-badge mb-3">
                <span class="badge-line"></span>
                <span class="badge-text">{{ __('lang.more_opportunities') }}</span>
                <span class="badge-line"></span>
            </div>
            <h2 class="section-title">{{ __('lang.related_jobs') }}</h2>
        </div>

        <div class="related-jobs-grid">
            @foreach($relatedJobs as $relatedJob)
            <div class="job-card">
                <div class="job-card-header">
                    <div class="job-icon">
                        @if($relatedJob->icon)
                        <img src="{{ asset('storage' . $relatedJob->icon) }}" alt="">
                        @else
                        <i class="fal fa-briefcase"></i>
                        @endif
                    </div>
                    <div class="job-type-badge {{ strtolower(str_replace(' ', '-', $relatedJob->job_type)) }}">
                        {{ $relatedJob->job_type }}
                    </div>
                </div>
                
                <div class="job-card-body">
                    <span class="job-category">
                        {{ app()->getLocale() == 'ar' ? $relatedJob->job_category_arabic : $relatedJob->job_category_english }}
                    </span>
                    <h3 class="job-title">
                        <a href="{{ route('careers.show', $relatedJob->id) }}">
                            {{ app()->getLocale() == 'ar' ? $relatedJob->job_title_arabic : $relatedJob->job_title_english }}
                        </a>
                    </h3>
                    <p class="job-description">
                        {!! Str::limit(strip_tags(app()->getLocale() == 'ar' ? $relatedJob->job_description_ar : $relatedJob->job_description_en), 100) !!}
                    </p>
                </div>
                
                <div class="job-card-footer">
                    <div class="job-meta">
                        <div class="job-meta-item">
                            <i class="fal fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($relatedJob->registration_end_date)->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('careers.show', $relatedJob->id) }}" class="job-apply-btn">
                        <span>{{ __('lang.view_details') }}</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('careers.index') }}" class="btn-view-all-jobs">
                <i class="fal fa-th-large"></i>
                {{ __('lang.view_all_positions') }}
            </a>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="job-cta-section py-12">
    <div class="container">
        <div class="cta-wrapper">
            <div class="cta-content">
                <h3 class="cta-title">{{ __('lang.have_questions') }}</h3>
                <p class="cta-text">{{ __('lang.contact_hr_about_job') }}</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="cta-btn-primary">
                    <i class="fal fa-envelope"></i>
                    <span>{{ __('lang.contact_us') }}</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
{{-- SweetAlert2 is loaded globally in layouts.master --}}
<script>
// File upload visual feedback
document.getElementById('resume').addEventListener('change', function(e) {
    const fileName = e.target.files[0] ? e.target.files[0].name : '{{ __("lang.choose_file") }}';
    document.querySelector('.file-name').textContent = fileName;
    
    if (e.target.files[0]) {
        document.querySelector('.file-upload-wrapper').classList.add('has-file');
    } else {
        document.querySelector('.file-upload-wrapper').classList.remove('has-file');
    }
});

// Copy job link function
function copyJobLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        Swal.fire({
            icon: 'success',
            title: '{{ __("lang.link_copied") }}',
            text: '{{ __("lang.link_copied_desc") }}',
            timer: 2000,
            showConfirmButton: false
        });
    });
}

// Form submission with SweetAlert
document.getElementById('applicationForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fal fa-spinner fa-spin"></i> {{ __("lang.submitting") }}...';
    submitBtn.disabled = true;
});

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: '{{ __("lang.application_submitted") }}',
    text: '{{ session("success") }}',
    confirmButtonColor: '#19868b'
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: '{{ __("lang.submission_failed") }}',
    text: '{{ session("error") }}',
    confirmButtonColor: '#19868b'
});
@endif
</script>
@endsection

