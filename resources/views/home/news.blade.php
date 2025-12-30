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
                 data-slick-options='{"slidesToShow": 3, "autoplay": true, "dots": true, "arrows": true, "responsive":[{"breakpoint": 1200,"settings": {"slidesToShow": 3}},{"breakpoint": 992,"settings": {"slidesToShow": 2}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                @foreach($blogs as $news)
                <div class="box px-2" data-animate="fadeInUp">
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
                            <p class="news-excerpt">
                                {{ Str::limit(app()->getLocale() == 'ar' ? $news->bio_arabic : $news->bio_english, 100) }}
                            </p>
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
@endif

