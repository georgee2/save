@extends('layouts.master')

@section('title', app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english)

@section('seo_desc', app()->getLocale() == 'ar' ? $blog->seo_des_ar : $blog->seo_des_en)

@section('seo_tags', $blog->seo_tags)

@section('content')

{{-- Hero Section with Cover --}}
<section class="blog-hero-section position-relative">
    @if($blog->cover)
    <div class="blog-hero-bg" style="background-image: url('{{ asset('storage' . $blog->cover) }}');"></div>
    @else
    <div class="blog-hero-bg blog-hero-gradient"></div>
    @endif
    <div class="blog-hero-overlay"></div>
    <div class="container position-relative">
        <div class="blog-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">{{ __('lang.news') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Str::limit(app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english, 40) }}
                    </li>
                </ol>
            </nav>
            <div class="blog-hero-category mb-3">
                <a href="{{ route('blogs.index', ['category' => $blog->category_code]) }}">
                    {{ app()->getLocale() == 'ar' ? $blog->category_name_ar : $blog->category_name_en }}
                </a>
            </div>
            <h1 class="blog-hero-title">
                {{ app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english }}
            </h1>
            <div class="blog-hero-meta">
                <span class="blog-date">
                    <i class="fal fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}
                </span>
            </div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="blog-content-section py-12">
    <div class="container">
        <div class="row">
            {{-- Blog Content --}}
            <div class="col-lg-8">
                <article class="blog-article" data-animate="fadeInUp">
                    {{-- Featured Image --}}
                    @if($blog->page_image || $blog->image)
                    <div class="blog-featured-image mb-6">
                        <img src="{{ asset('storage' . ($blog->page_image ?: $blog->image)) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english }}"
                             class="img-fluid rounded-lg">
                    </div>
                    @endif

                    {{-- Article Body --}}
                    <div class="blog-body">
                        {!! app()->getLocale() == 'ar' ? $blog->body_arabic : $blog->body_english !!}
                    </div>

                    {{-- Tags --}}
                    @if($blog->seo_tags)
                    <div class="blog-tags mt-6">
                        <div class="tags-label">
                            <i class="fal fa-tags"></i>
                            {{ __('lang.tags') }}:
                        </div>
                        <div class="tags-list">
                            @foreach(explode(',', $blog->seo_tags) as $tag)
                            <span class="tag-item">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Share Section --}}
                    <div class="blog-share mt-6">
                        <div class="share-label">{{ __('lang.share_article') }}:</div>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="share-btn facebook" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode(app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english) }}" 
                               target="_blank" class="share-btn twitter" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode(app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english) }}" 
                               target="_blank" class="share-btn linkedin" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode((app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english) . ' ' . request()->url()) }}" 
                               target="_blank" class="share-btn whatsapp" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <button class="share-btn copy-link" onclick="copyToClipboard('{{ request()->url() }}')" title="Copy Link">
                                <i class="fal fa-link"></i>
                            </button>
                        </div>
                    </div>
                </article>

                {{-- Navigation --}}
                <div class="blog-navigation mt-8">
                    <a href="{{ route('blogs.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }}"></i>
                        {{ __('lang.back_to_news') }}
                    </a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <aside class="blog-sidebar">
                    {{-- Categories Widget --}}
                    <div class="sidebar-widget categories-widget">
                        <h4 class="widget-title">{{ __('lang.categories') }}</h4>
                        <ul class="category-list">
                            @foreach($categories as $category)
                            <li class="{{ $blog->category_code == $category->id ? 'active' : '' }}">
                                <a href="{{ route('blogs.index', ['category' => $category->id]) }}">
                                    <span>{{ app()->getLocale() == 'ar' ? $category->name_arabic : $category->name_english }}</span>
                                    <span class="count">{{ $category->blog_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Recent Posts Widget --}}
                    @if($recentBlogs->count() > 0)
                    <div class="sidebar-widget recent-posts-widget">
                        <h4 class="widget-title">{{ __('lang.recent_news') }}</h4>
                        <div class="recent-posts-list">
                            @foreach($recentBlogs as $recentBlog)
                            <div class="recent-post-item">
                                <div class="recent-post-image">
                                    <a href="{{ route('blogs.show', $recentBlog->slug) }}">
                                        @if($recentBlog->image)
                                        <img src="{{ asset('storage' . $recentBlog->image) }}" 
                                             alt="{{ app()->getLocale() == 'ar' ? $recentBlog->title_arabic : $recentBlog->title_english }}">
                                        @else
                                        <div class="recent-post-placeholder">
                                            <i class="fal fa-newspaper"></i>
                                        </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="recent-post-content">
                                    <h5 class="recent-post-title">
                                        <a href="{{ route('blogs.show', $recentBlog->slug) }}">
                                            {{ Str::limit(app()->getLocale() == 'ar' ? $recentBlog->title_arabic : $recentBlog->title_english, 50) }}
                                        </a>
                                    </h5>
                                    <span class="recent-post-date">
                                        <i class="fal fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($recentBlog->created_at)->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/blog-single.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const btn = document.querySelector('.copy-link');
        const originalIcon = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.classList.add('copied');
        setTimeout(function() {
            btn.innerHTML = originalIcon;
            btn.classList.remove('copied');
        }, 2000);
    });
}
</script>
@endsection

