@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('news_index'); @endphp

@section('title', $seo['title'] ?? ($selectedCategory ? (app()->getLocale() == 'ar' ? $selectedCategory->name_arabic : $selectedCategory->name_english) : __('lang.news')))

@section('seo_desc', $seo['description'] ?? __('lang.news_seo_desc'))

@section('seo_tags', $seo['tags'] ?? __('lang.news'))

@section('content')

{{-- Hero Section --}}
<section class="blogs-hero-section position-relative">
    @if($pageBanner && $pageBanner->cover)
    <div class="blogs-hero-bg" style="background-image: url('{{ asset($pageBanner->cover) }}');"></div>
    @else
    <div class="blogs-hero-bg blogs-hero-gradient"></div>
    @endif
    <div class="blogs-hero-overlay"></div>
    <div class="container position-relative">
        <div class="blogs-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    @if($selectedCategory)
                    <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">{{ __('lang.news') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ app()->getLocale() == 'ar' ? $selectedCategory->name_arabic : $selectedCategory->name_english }}
                    </li>
                    @else
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.news') }}</li>
                    @endif
                </ol>
            </nav>
            <h1 class="blogs-hero-title">
                @if($selectedCategory)
                    {{ app()->getLocale() == 'ar' ? $selectedCategory->name_arabic : $selectedCategory->name_english }}
                @else
                    {{ __('lang.news_articles') }}
                @endif
            </h1>
            <p class="blogs-hero-subtitle">{{ __('lang.stay_updated') }}</p>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="blogs-section py-12">
    <div class="container">
        <div class="row">
            {{-- Blog Posts --}}
            <div class="col-lg-8">
                @if($blogs->count() > 0)
                <div class="blogs-grid">
                    @foreach($blogs as $blog)
                    <article class="blog-card" data-animate="fadeInUp">
                        <div class="blog-card-image">
                            <a href="{{ route('blogs.show', $blog->slug) }}">
                                @if($blog->image)
                                <img src="{{ asset('storage' . $blog->image) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english }}">
                                @else
                                <div class="blog-placeholder">
                                    <i class="fal fa-newspaper"></i>
                                </div>
                                @endif
                            </a>
                            <div class="blog-category">
                                <a href="{{ route('blogs.index', ['category' => $blog->category_id]) }}">
                                    {{ app()->getLocale() == 'ar' ? $blog->category_name_ar : $blog->category_name_en }}
                                </a>
                            </div>
                        </div>
                        <div class="blog-card-content">
                            <div class="blog-meta">
                                <span class="blog-date">
                                    <i class="fal fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}
                                </span>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blogs.show', $blog->slug) }}">
                                    {{ app()->getLocale() == 'ar' ? $blog->title_arabic : $blog->title_english }}
                                </a>
                            </h2>
                            <p class="blog-excerpt">
                                {{ Str::limit(app()->getLocale() == 'ar' ? $blog->bio_arabic : $blog->bio_english, 150) }}
                            </p>
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-read-more">
                                {{ __('lang.read_more') }}
                                <i class="fas fa-arrow-right {{ app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : '' }}"></i>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="blogs-pagination mt-8">
                    {{ $blogs->links('vendor.pagination.custom') }}
                </div>
                @else
                <div class="no-blogs-found text-center py-10">
                    <i class="fal fa-newspaper fa-4x text-muted mb-4"></i>
                    <h3>{{ __('lang.no_news_found') }}</h3>
                    <p class="text-muted">{{ __('lang.no_news_desc') }}</p>
                    @if($selectedCategory)
                    <a href="{{ route('blogs.index') }}" class="btn btn-primary mt-4">
                        {{ __('lang.view_all_news') }}
                    </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <aside class="blogs-sidebar">
                    {{-- Categories Widget --}}
                    <div class="sidebar-widget categories-widget">
                        <h4 class="widget-title">{{ __('lang.categories') }}</h4>
                        <ul class="category-list">
                            <li class="{{ !$selectedCategory ? 'active' : '' }}">
                                <a href="{{ route('blogs.index') }}">
                                    <span>{{ __('lang.all_categories') }}</span>
                                    <span class="count">{{ $blogs->total() }}</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li class="{{ $selectedCategory && $selectedCategory->id == $category->id ? 'active' : '' }}">
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
<link rel="stylesheet" href="{{ asset('/assets/css/blogs-page.css') }}?v={{ time() }}">
@endsection

