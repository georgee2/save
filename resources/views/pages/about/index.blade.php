@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('about'); @endphp
@section('title', $seo['title'] ?? (app()->getLocale() == 'ar' ? ($aboutInfo->title_arabic ?? __('lang.about_us')) : ($aboutInfo->title_english ?? __('lang.about_us'))))
@section('seo_desc', $seo['description'] ?? '')
@section('seo_tags', $seo['tags'] ?? (app()->getLocale() == 'ar' ? ($aboutInfo->title_arabic ?? __('lang.about_us')) : ($aboutInfo->title_english ?? __('lang.about_us'))))

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
    @include('pages.about.partials.hero')
    @include('pages.about.partials.about-content')
    @include('pages.about.partials.features')
    @include('pages.about.partials.mission-vision-values')
    @include('pages.about.partials.certificates')
    @include('pages.about.partials.team')
    @include('pages.about.partials.custom-blocks')
    @include('pages.about.partials.government-partners')
    @include('pages.about.partials.cta')
@endif

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/about-page.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Smooth tab transitions
    $('#mvvTabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    // Certificates Slider
    if ($('.certificates-slider').length) {
        $('.certificates-slider').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 600,
            dots: true,
            arrows: true,
            infinite: true,
            pauseOnHover: true,
            prevArrow: '<button class="cert-nav-btn cert-prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button class="cert-nav-btn cert-next"><i class="fas fa-chevron-right"></i></button>',
            appendDots: '.certificates-dots',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        centerMode: true,
                        centerPadding: '30px'
                    }
                }
            ]
        });
    }
});
</script>
@endsection
