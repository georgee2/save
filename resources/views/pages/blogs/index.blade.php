@extends('layouts.master')
@section('title', __('lang.blog_page_title'))

@section('content')
<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ __('lang.blog_page_title') }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.blog') }}</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
        </section>
        <!-- end: Breadcrumb Section -->

        <!-- start: Blog Section -->
        <section class="tj-blog-section section-gap">
          <div class="container">
            <div class="row row-gap-5">
              <div class="col-lg-8">
                <div class="row row-gap-4">
                  @forelse($blogs as $blog)
                  <div class="col-md-6">
                    <div class="blog-item wow fadeInUp" data-wow-delay=".1s">
                      <div class="blog-thumb">
                        <a href="{{ route('blogs.show', $blog->slug) }}">
                          <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ App::getLocale() == 'en' ? $blog->title_english : $blog->title_arabic }}">
                        </a>
                        <div class="blog-date">
                          <span class="date">{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</span>
                          <span class="month">{{ \Carbon\Carbon::parse($blog->created_at)->format('M') }}</span>
                        </div>
                      </div>
                      <div class="blog-content">
                        <div class="blog-meta">
                          <span class="categories">
                            <a href="#">{{ App::getLocale() == 'en' ? $blog->category_name_en : $blog->category_name_ar }}</a>
                          </span>
                        </div>
                        <h4 class="title">
                          <a href="{{ route('blogs.show', $blog->slug) }}">
                            {{ App::getLocale() == 'en' ? $blog->title_english : $blog->title_arabic }}
                          </a>
                        </h4>
                        <a class="text-btn" href="{{ route('blogs.show', $blog->slug) }}">
                          <span class="btn-text"><span>{{ __('lang.read_more') }}</span></span>
                          <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                        </a>
                      </div>
                    </div>
                  </div>
                  @empty
                  <div class="col-12">
                    <p class="text-center">{{ __('lang.no_blogs_available') }}</p>
                  </div>
                  @endforelse
                </div>
                <!-- post pagination -->
                @if($blogs->hasPages())
                <div class="tj-pagination d-flex justify-content-center">
                  <ul>
                    {{-- Previous Page Link --}}
                    @if ($blogs->onFirstPage())
                      <li class="disabled" aria-disabled="true">
                        <span class="page-numbers"><i class="tji-arrow-left-long"></i></span>
                      </li>
                    @else
                      <li>
                        <a class="page-numbers" href="{{ $blogs->previousPageUrl() }}" rel="prev"><i class="tji-arrow-left-long"></i></a>
                      </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                      @if ($page == $blogs->currentPage())
                        <li>
                          <span aria-current="page" class="page-numbers current">{{ sprintf('%02d', $page) }}</span>
                        </li>
                      @else
                        <li>
                          <a class="page-numbers" href="{{ $url }}">{{ sprintf('%02d', $page) }}</a>
                        </li>
                      @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($blogs->hasMorePages())
                      <li>
                        <a class="next page-numbers" href="{{ $blogs->nextPageUrl() }}" rel="next"><i class="tji-arrow-right-long"></i></a>
                      </li>
                    @else
                      <li class="disabled" aria-disabled="true">
                        <span class="page-numbers"><i class="tji-arrow-right-long"></i></span>
                      </li>
                    @endif
                  </ul>
                </div>
                @endif
              </div>
              <div class="col-lg-4">
                <div class="tj-main-sidebar p-0 slidebar-stickiy">
                  <div class="tj-sidebar-widget tj-recent-posts wow fadeInUp" data-wow-delay=".3s" style="background: #f8f9fa; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
                    <h4 class="widget-title" style="display: flex; align-items: center; gap: 10px;">
                      <img src="{{url('/pic/logosvg.svg')}}">
                      {{ App::getLocale() == 'en' ? 'Recent Posts' : 'أحدث المقالات' }}
                    </h4>
                    <ul>
                      @foreach($recentBlogs as $recentBlog)
                      <li>
                        <div class="post-thumb">
                          <a href="{{ route('blogs.show', $recentBlog->slug) }}">
                            <img src="{{ asset('storage/' . $recentBlog->image) }}" alt="{{ App::getLocale() == 'en' ? $recentBlog->title_english : $recentBlog->title_arabic }}">
                          </a>
                        </div>
                        <div class="post-content">
                          <h6 class="post-title">
                            <a href="{{ route('blogs.show', $recentBlog->slug) }}">
                              {{ App::getLocale() == 'en' ? $recentBlog->title_english : $recentBlog->title_arabic }}
                            </a>
                          </h6>
                          <div class="blog-meta">
                            <ul>
                              <li>{{ \Carbon\Carbon::parse($recentBlog->created_at)->format('d M Y') }}</li>
                            </ul>
                          </div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                  <div class="tj-sidebar-widget widget-categories wow fadeInUp" data-wow-delay=".5s" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                    <h4 class="widget-title" style="display: flex; align-items: center; gap: 10px;">
                      <img src="{{url('/pic/logosvg.svg')}}">
                      {{ App::getLocale() == 'en' ? 'Categories' : 'التصنيفات' }}
                    </h4>
                    <ul>
                      @foreach($categories as $category)
                      <li>
                        <a href="#">
                          <i class="tji-arrow-right" style="margin-right: 8px; font-size: 12px; color: #ff6b35;"></i>
                          {{ App::getLocale() == 'en' ? $category->name_english : $category->name_arabic }}
                          <span class="number">({{ sprintf('%02d', $category->blog_count) }})</span>
                        </a>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>
        <!-- end: Blog Section -->

@endsection 