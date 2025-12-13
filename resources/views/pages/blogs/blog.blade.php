@extends('layouts.master')
@if(App::getLocale() == 'en')
@section('title', $blog->title_english)
@else
@section('title', $blog->title_arabic)
@endif

@if($blog->seo_tags != null)
@section('seo_tags'){{ $blog->seo_tags }}@endsection
@endif

@if(App::getLocale() == 'en')
@if($blog->seo_des_en != null)
@section('seo_desc'){{ $blog->seo_des_en }}@endsection
@endif
@else
@if($blog->seo_des_ar != null)
@section('seo_desc'){{ $blog->seo_des_ar }}@endsection
@endif
@endif

@section('content')

<!-- start: Breadcrumb Section -->
        <section class="tj-page-header section-gap-x" data-bg-image="{{ $blog->cover ? asset('storage/' . $blog->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="tj-page-header-content text-center">
                  <h1 class="tj-page-title">{{ App::getLocale() == 'en' ? $blog->title_english : $blog->title_arabic }}</h1>
                  <div class="tj-page-link">
                    <span><i class="tji-home"></i></span>
                    <span>
                      <a href="{{ route('index') }}">{{ __('lang.home') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <a href="{{ route('blogs.index') }}">{{ __('lang.blog') }}</a>
                    </span>
                    <span><i class="tji-arrow-right"></i></span>
                    <span>
                      <span>{{ __('lang.blog_details') }}</span>
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
        <section class="tj-blog-section section-gap slidebar-stickiy-container">
          <div class="container">
            <div class="row row-gap-5">
              <div class="col-lg-8">
                <div class="post-details-wrapper">
                  <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ App::getLocale() == 'en' ? $blog->title_english : $blog->title_arabic }}">
                  </div>
                  <h2 class="title title-anim">{{ App::getLocale() == 'en' ? $blog->title_english : $blog->title_arabic }}</h2>
                  <div class="blog-category-two wow fadeInUp" data-wow-delay=".3s">
                    <div class="category-item">
                      <div class="cate-icons">
                        <i class="tji-folder"></i>
                      </div>
                      <div class="cate-text">
                        <span class="degination">{{ App::getLocale() == 'en' ? 'Category' : 'التصنيف' }}</span>
                        <h6 class="title"><a href="#">{{ App::getLocale() == 'en' ? $blog->category_name_en : $blog->category_name_ar }}</a></h6>
                      </div>
                    </div>
                    <div class="category-item">
                      <div class="cate-icons">
                        <i class="tji-calendar"></i>
                      </div>
                      <div class="cate-text">
                        <span class="degination">{{ App::getLocale() == 'en' ? 'Date Released' : 'تاريخ النشر' }}</span>
                        <h6 class="text">{{ \Carbon\Carbon::parse($blog->created_at)->format('d F, Y') }}</h6>
                      </div>
                    </div>
                  </div>
                  <div class="blog-text">
                    <div class="wow fadeInUp" data-wow-delay=".3s">
                      {!! App::getLocale() == 'en' ? $blog->body_english : $blog->body_arabic !!}
                    </div>
                  </div>
                  @if($blog->seo_tags)
                  @php
                    $tags = array_filter(array_map('trim', explode(',', $blog->seo_tags)));
                  @endphp
                  @if(count($tags) > 0)
                  <div class="tj-tags-post wow fadeInUp" data-wow-delay=".3s">
                    <div class="tagcloud">
                      <span>{{ App::getLocale() == 'en' ? 'Tags:' : 'الوسوم:' }}</span>
                      @foreach($tags as $tag)
                      <a href="#">{{ $tag }}</a>
                      @endforeach
                    </div>
                    <div class="post-share">
                      <ul>
                        <li>{{ App::getLocale() == 'en' ? 'Share:' : 'مشاركة:' }}</li>
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blogs.show', $blog->slug)) }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blogs.show', $blog->slug)) }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blogs.show', $blog->slug)) }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
                      </ul>
                    </div>
                  </div>
                  @endif
                  @endif
                </div>
              </div>
              <div class="col-lg-4">
                <div class="tj-main-sidebar slidebar-stickiy">
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