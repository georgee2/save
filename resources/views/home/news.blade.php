{{-- Home News Section --}}
@if($blogs && count($blogs) > 0)
<section class="home-news-section py-lg-12 py-11">
    <div class="container container-xxl">
        {{-- Section Header --}}
        <div class="row align-items-center mb-6">
            <div class="col-md-7">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13">{{ __('lang.latest_news') }}</span>
                <h2 class="text-heading mt-2 mb-0">{{ __('lang.news_and_articles') }}</h2>
                <span class="heading-divider"></span>
                <p class="mb-0">{{ __('lang.news_bio') }}</p>
            </div>
            <div class="col-md-5 text-md-right mt-4 mt-md-0">
                <a href="{{ route('blogs.index') }}" class="btn fs-14 text-secondary btn-accent py-3 lh-15 px-7 mb-6 mb-lg-0">
                    {{ __('lang.view_all_news') }}
                    <i class="far fa-long-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        {{-- News Slider --}}
        <div class="news-slider-wrapper">
            <div class="slick-slider news-slider" 
                 data-slick-options='{"slidesToShow": 3, "autoplay": true, "dots": true, "arrows": true, "infinite": true, "rtl": {{ app()->getLocale() == "ar" ? "true" : "false" }}, "responsive":[{"breakpoint": 1200,"settings": {"slidesToShow": 3}},{"breakpoint": 992,"settings": {"slidesToShow": 2}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                @foreach($blogs as $news)
                <div class="box px-2">
                    <div class="news-card">
                        <div class="news-card-image">
                            <a href="{{ route('blogs.show', $news->slug) }}">
                                <img src="{{ url('/storage' . $news->image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $news->title_arabic : $news->title_english }}">
                            </a>
                            <div class="news-category">
                                <span>{{ app()->getLocale() == 'ar' ? $news->catar : $news->caten }}</span>
                            </div>
                        </div>
                        <div class="news-card-content">
                            <div class="news-meta">
                                <span class="news-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($news->created_at)->format('M d, Y') }}
                                </span>
                            </div>
                            <h3 class="news-title">
                                <a href="{{ route('blogs.show', $news->slug) }}">
                                    {{ app()->getLocale() == 'ar' ? $news->title_arabic : $news->title_english }}
                                </a>
                            </h3>
                            @php
                                $excerpt = app()->getLocale() == 'ar' ? $news->bio_arabic : $news->bio_english;
                                if (empty($excerpt) || strtolower($excerpt) == 'none') {
                                    $bodyContent = app()->getLocale() == 'ar' ? $news->body_arabic : $news->body_english;
                                    $excerpt = strip_tags($bodyContent);
                                }
                            @endphp
                            @if(!empty($excerpt) && strtolower($excerpt) != 'none')
                            <p class="news-excerpt">
                                {{ Str::limit($excerpt, 100) }}
                            </p>
                            @endif
                            <a href="{{ route('blogs.show', $news->slug) }}" class="news-read-more">
                                {{ __('lang.read_more') }}
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var maxVisible = 5;

    function updateNewsSmartDots() {
        var $dots = $('.home-news-section .news-slider .slick-dots li');
        var total = $dots.length;
        if (total <= maxVisible) return;

        var activeIndex = $dots.filter('.slick-active').index();
        $dots.removeClass('smart-dot-hidden smart-dot-far');

        $dots.each(function(i) {
            var distance = Math.abs(i - activeIndex);
            if (distance > Math.floor(maxVisible / 2) + 1) {
                $(this).addClass('smart-dot-far');
            } else if (distance > Math.floor(maxVisible / 2)) {
                $(this).addClass('smart-dot-hidden');
            }
        });
    }

    var $newsSlider = $('.home-news-section .news-slider');
    if ($newsSlider.length) {
        $newsSlider.on('afterChange', updateNewsSmartDots);
        $newsSlider.on('init', updateNewsSmartDots);
        setTimeout(updateNewsSmartDots, 500);
    }
});
</script>
@endif

