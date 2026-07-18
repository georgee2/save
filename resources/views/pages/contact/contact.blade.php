@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('contact'); @endphp
@section('title', $seo['title'] ?? __('lang.contact_us_title'))
@section('seo_desc', $seo['description'] ?? __('lang.contact_us_seo_desc'))
@section('seo_tags', $seo['tags'] ?? __('lang.contact_us'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/contact-page.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/branches-page.css') }}?v={{ time() }}">
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
{{-- SweetAlert2 is loaded globally in layouts.master --}}
@if(config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
@endif
<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: '{{ __("lang.form_error_title") }}',
            html: '<ul style="text-align: left; list-style: disc; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#e1273d',
            confirmButtonText: '{{ __("lang.ok") }}'
        });
    @endif
    
    var recaptchaSiteKey = '{{ config("services.recaptcha.site_key") }}';

    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            var submitBtn = this.querySelector('.btn-submit');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> {{ __("lang.sending") }}...';
            submitBtn.disabled = true;
            
            Swal.fire({
                title: '{{ __("lang.sending_message") }}',
                html: '{{ __("lang.please_wait") }}',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function() { Swal.showLoading(); }
            });

            if (recaptchaSiteKey && typeof grecaptcha !== 'undefined') {
                e.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute(recaptchaSiteKey, {action: 'contact_form'}).then(function(token) {
                        document.getElementById('contactRecaptchaToken').value = token;
                        contactForm.submit();
                    });
                });
            }
        });
    }
    
    var observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(function() { entry.target.classList.add('animated'); }, delay);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('[data-animate]').forEach(function(el) {
        observer.observe(el);
    });
});
</script>
@endsection
