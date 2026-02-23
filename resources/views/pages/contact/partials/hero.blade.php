{{-- Hero Section --}}
<section class="contact-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="contact-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="contact-hero-bg contact-hero-gradient"></div>
    @endif
    <div class="contact-hero-overlay"></div>
    <div class="container position-relative">
        <div class="contact-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.contact_us') }}</li>
                </ol>
            </nav>
            <h1 class="contact-hero-title">{{ __('lang.contact_us_title') }}</h1>
            <p class="contact-hero-subtitle">{{ __('lang.contact_us_subtitle') }}</p>
        </div>
    </div>
</section>
