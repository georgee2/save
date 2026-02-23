{{-- Hero Section with Cover Image --}}
<section class="about-hero-section position-relative">
    @if($aboutInfo->page_cover_image)
    <div class="about-hero-bg" style="background-image: url('{{ asset('storage' . $aboutInfo->page_cover_image) }}');"></div>
    @else
    <div class="about-hero-bg about-hero-gradient"></div>
    @endif
    <div class="about-hero-overlay"></div>
    <div class="container position-relative">
        <div class="about-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.about_us') }}</li>
                </ol>
            </nav>
            <h1 class="about-hero-title">
                {{ app()->getLocale() == 'ar' ? ($aboutInfo->title_arabic ?? __('lang.about_us')) : ($aboutInfo->title_english ?? __('lang.about_us')) }}
            </h1>
            @if($aboutInfo->subtitle_english || $aboutInfo->subtitle_arabic)
            <p class="about-hero-subtitle">
                {{ app()->getLocale() == 'ar' ? $aboutInfo->subtitle_arabic : $aboutInfo->subtitle_english }}
            </p>
            @endif
        </div>
    </div>
</section>
