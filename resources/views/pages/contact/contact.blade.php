@extends('layouts.master')

@section('title', __('lang.contact_us_title'))

@section('seo_desc', $contactInfo->seo_description_english ?? __('lang.contact_us_seo_desc'))

@section('seo_tags', $contactInfo->tags ?? __('lang.contact_us'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/contact-page.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/branches-page.css') }}?v={{ time() }}">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')

@if(isset($sections) && $sections->count() > 0)
    {{-- Render sections dynamically based on ordering --}}
    @foreach($sections as $section)
        @if($section->blade_partial && View::exists($section->blade_partial))
            @include($section->blade_partial)
        @endif
    @endforeach
@else
    {{-- Fallback to static sections if no sections defined --}}
    @include('pages.contact.partials.hero')
    @include('pages.contact.partials.info-cards')
    @include('pages.contact.partials.company-profile')
    @include('pages.contact.partials.form-map')
    @include('pages.contact.partials.branches')
    @include('pages.contact.partials.cta')
@endif

@endsection

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show success message with SweetAlert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ __("lang.message_sent_title") }}',
            text: '{{ session("success") }}',
            confirmButtonColor: '#19868b',
            confirmButtonText: '{{ __("lang.ok") }}',
            timer: 5000,
            timerProgressBar: true
        });
    @endif
    
    // Show error message with SweetAlert
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: '{{ __("lang.form_error_title") }}',
            html: '<ul style="text-align: left; list-style: disc; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#e1273d',
            confirmButtonText: '{{ __("lang.ok") }}'
        });
    @endif
    
    // Form submission with loading state
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> {{ __("lang.sending") }}...';
            submitBtn.disabled = true;
            
            // Show loading SweetAlert
            Swal.fire({
                title: '{{ __("lang.sending_message") }}',
                html: '{{ __("lang.please_wait") }}',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }
    
    // Animate elements on scroll for branches section
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('animated');
                }, delay);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endsection
