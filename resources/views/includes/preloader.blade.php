{{-- Preloader --}}
<div id="preloader" class="preloader">
    <div class="preloader-inner">
        <div class="preloader-logo">
            <img src="{{ url('/pic/svgwhite.svg') }}" alt="{{ env('APP_NAME') }}">
        </div>
        <div class="preloader-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
        </div>
        <div class="preloader-text">{{ __('lang.loading') }}...</div>
    </div>
</div>

