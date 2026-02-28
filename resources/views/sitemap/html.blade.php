@extends('layouts.master')

@section('title', __('lang.sitemap'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/sitemap-page.css') }}?v={{ time() }}">
@endsection

@section('content')

{{-- Hero Section --}}
<section class="sitemap-hero">
    <div class="container position-relative" style="z-index: 1;">
        <div class="text-center">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('lang.sitemap') }}</li>
                </ol>
            </nav>
            <h1 class="sitemap-hero-title">{{ __('lang.sitemap') }}</h1>
        </div>
    </div>
</section>

<section class="sitemap-content">
    <div class="container">

        {{-- Static / Main Pages --}}
        <div class="sitemap-static-pages">
            <a href="{{ route('index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-home"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.home') }}</span>
            </a>
            <a href="{{ route('about') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-info-circle"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.about_us') }}</span>
            </a>
            <a href="{{ route('services.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-cogs"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.services') }}</span>
            </a>
            <a href="{{ route('projects.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-building"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.projects') }}</span>
            </a>
            <a href="{{ route('offers.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-tags"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.offers') }}</span>
            </a>
            <a href="{{ route('blogs.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-newspaper"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.news') }}</span>
            </a>
            <a href="{{ route('contact') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-envelope"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.contact_us') }}</span>
            </a>
            <a href="{{ route('careers.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-briefcase"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.careers') }}</span>
            </a>
            <a href="{{ route('interior.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-paint-roller"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.interior_design') }}</span>
            </a>
            <a href="{{ route('team.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-users"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.our_team') }}</span>
            </a>
            <a href="{{ route('partners.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-handshake"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.our_partners') }}</span>
            </a>
            <a href="{{ route('branches.index') }}" class="sitemap-static-card">
                <div class="sitemap-static-card-icon"><i class="fas fa-map-marker-alt"></i></div>
                <span class="sitemap-static-card-label">{{ __('lang.our_branches') }}</span>
            </a>
        </div>

        <div class="row">
            <div class="col-lg-6">

                {{-- Services --}}
                @if($services->count())
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon primary"><i class="fas fa-cogs"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('services.index') }}">{{ __('lang.our_services') }}</a>
                        </h2>
                        <span class="sitemap-section-count">{{ $services->count() }}</span>
                    </div>
                    <ul class="sitemap-links">
                        @foreach($services as $service)
                        <li>
                            <a href="{{ route('services.show', $service->slug) }}">
                                {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Offers --}}
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon secondary"><i class="fas fa-tags"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('offers.index') }}">{{ __('lang.all_offers') }}</a>
                        </h2>
                    </div>
                    @foreach($offerCategories as $category)
                    <div class="sitemap-subcategory-title">
                        <i class="fas fa-folder-open"></i>
                        <a href="{{ route('offers.category', $category->slug) }}">
                            {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                        </a>
                    </div>
                    @if($category->subCategories->count())
                    <ul class="sitemap-sub-links">
                        @foreach($category->subCategories as $sub)
                        <li>
                            <a href="{{ route('offers.subcategory', $sub->slug) }}">
                                {{ app()->getLocale() == 'ar' ? $sub->title_arabic : $sub->title_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    @endforeach
                </div>

                {{-- Team --}}
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon teal"><i class="fas fa-users"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('team.index') }}">{{ __('lang.our_team') }}</a>
                        </h2>
                    </div>
                    <ul class="sitemap-links">
                        <li><a href="{{ route('team.index') }}">{{ __('lang.our_team') }}</a></li>
                        <li><a href="{{ route('team.board') }}">{{ __('lang.board_of_directors') }}</a></li>
                        @foreach($teamMembers as $member)
                        <li>
                            <a href="{{ route('team.member', $member->id) }}">
                                {{ app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Careers --}}
                @if($activeJobs->count())
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon dark"><i class="fas fa-briefcase"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('careers.index') }}">{{ __('lang.careers') }}</a>
                        </h2>
                        <span class="sitemap-section-count">{{ $activeJobs->count() }}</span>
                    </div>
                    <ul class="sitemap-links">
                        @foreach($activeJobs as $job)
                        <li>
                            <a href="{{ route('careers.show', $job->id) }}">
                                {{ app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>

            <div class="col-lg-6">

                {{-- Projects --}}
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon primary"><i class="fas fa-building"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('projects.index') }}">{{ __('lang.all_projects') }}</a>
                        </h2>
                    </div>
                    <ul class="sitemap-links" style="margin-bottom: 15px;">
                        <li><a href="{{ route('projects.featured') }}">{{ __('lang.featured_projects_title') }}</a></li>
                    </ul>
                    @foreach($projectCategories as $category)
                    <div class="sitemap-subcategory-title">
                        <i class="fas fa-folder-open"></i>
                        <a href="{{ route('category.show', $category->slug) }}">
                            {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                        </a>
                    </div>
                    @if($category->subCategories->count())
                    <ul class="sitemap-sub-links">
                        @foreach($category->subCategories as $sub)
                        <li>
                            <a href="{{ route('subcategory.show', $sub->slug) }}">
                                {{ app()->getLocale() == 'ar' ? $sub->title_arabic : $sub->title_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    @endforeach
                </div>

                {{-- News --}}
                @if($news->count())
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon secondary"><i class="fas fa-newspaper"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('blogs.index') }}">{{ __('lang.latest_news') }}</a>
                        </h2>
                        <span class="sitemap-section-count">{{ $news->count() }}</span>
                    </div>
                    <ul class="sitemap-links">
                        @foreach($news as $article)
                        @if(!empty($article->slug))
                        <li>
                            <a href="{{ route('blogs.show', $article->slug) }}">
                                {{ app()->getLocale() == 'ar' ? ($article->title_arabic ?? $article->title_english) : $article->title_english }}
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Partners --}}
                @if($partners->count())
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon teal"><i class="fas fa-handshake"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('partners.index') }}">{{ __('lang.our_partners') }}</a>
                        </h2>
                        <span class="sitemap-section-count">{{ $partners->count() }}</span>
                    </div>
                    <ul class="sitemap-links">
                        @foreach($partners as $partner)
                        <li>
                            <a href="{{ route('partners.show', $partner->id) }}">
                                {{ app()->getLocale() == 'ar' ? $partner->name_arabic : $partner->name_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Branches --}}
                @if($branches->count())
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon dark"><i class="fas fa-map-marker-alt"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('branches.index') }}">{{ __('lang.our_branches') }}</a>
                        </h2>
                        <span class="sitemap-section-count">{{ $branches->count() }}</span>
                    </div>
                    <ul class="sitemap-links">
                        @foreach($branches as $branch)
                        <li>
                            <a href="{{ route('branches.show', $branch->id) }}">
                                {{ app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Interior Design --}}
                <div class="sitemap-section">
                    <div class="sitemap-section-header">
                        <div class="sitemap-section-icon primary"><i class="fas fa-paint-roller"></i></div>
                        <h2 class="sitemap-section-title">
                            <a href="{{ route('interior.index') }}">{{ __('lang.interior_design') }}</a>
                        </h2>
                        @if($interiorCategories->count())
                        <span class="sitemap-section-count">{{ $interiorCategories->count() }}</span>
                        @endif
                    </div>
                    <ul class="sitemap-links">
                        <li><a href="{{ route('interior.index') }}">{{ __('lang.interior_design') }}</a></li>
                        @foreach($interiorCategories as $intCat)
                        <li>
                            <a href="{{ route('interior.category', $intCat->slug) }}">
                                {{ app()->getLocale() == 'ar' ? $intCat->title_arabic : $intCat->title_english }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
