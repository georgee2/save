@extends('layouts.master')

@section('title', __('lang.shared_favourites'))
@section('seo_desc', __('lang.shared_favourites'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/favourites-page.css') }}?v=1.4">
@endsection

@section('content')
<section class="favourites-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.shared_favourites') }}</li>
            </ol>
        </nav>
        <h1><i class="fal fa-share-alt"></i> {{ __('lang.shared_favourites') }}</h1>
        <p>{{ $totalCount }} {{ __('lang.favourite_items') }}</p>
    </div>
</section>

<section class="favourites-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                {{-- Tabs --}}
                <div class="fav-toolbar d-flex align-items-center flex-wrap mb-3">
                    <div class="fav-tabs">
                        <button class="fav-tab active" data-target="all">
                            {{ __('lang.all') ?? 'All' }}
                            <span class="tab-count">{{ $totalCount }}</span>
                        </button>
                        @if($grouped['projects']->count() > 0)
                        <button class="fav-tab" data-target="projects">
                            <i class="fal fa-building"></i>
                            {{ __('lang.favourite_projects') }}
                            <span class="tab-count">{{ $grouped['projects']->count() }}</span>
                        </button>
                        @endif
                        @if($grouped['offers']->count() > 0)
                        <button class="fav-tab" data-target="offers">
                            <i class="fal fa-tags"></i>
                            {{ __('lang.favourite_offers') }}
                            <span class="tab-count">{{ $grouped['offers']->count() }}</span>
                        </button>
                        @endif
                        @if($grouped['interiors']->count() > 0)
                        <button class="fav-tab" data-target="interiors">
                            <i class="fal fa-paint-roller"></i>
                            {{ __('lang.favourite_interior') }}
                            <span class="tab-count">{{ $grouped['interiors']->count() }}</span>
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Projects --}}
                @if($grouped['projects']->count() > 0)
                <div class="fav-section" data-section="projects">
                    @foreach($grouped['projects'] as $fav)
                    @php $project = $fav->itemData; @endphp
                    <div class="fav-item">
                        <a href="{{ route('projects.show', $project->slug) }}" class="fav-item-image">
                            <img src="{{ url('/storage' . $project->main_image) }}" alt="{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}">
                        </a>
                        <div class="fav-item-body">
                            <span class="fav-type-badge project">{{ __('lang.projects') }}</span>
                            <a href="{{ route('projects.show', $project->slug) }}" class="fav-item-title">
                                {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                            </a>
                            <div class="fav-item-meta">
                                @if($project->category)
                                <span><i class="fal fa-folder"></i> {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}</span>
                                @endif
                                @if($project->emirate)
                                <span><i class="fal fa-map-marker-alt"></i> {{ app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Offers --}}
                @if($grouped['offers']->count() > 0)
                <div class="fav-section" data-section="offers">
                    @foreach($grouped['offers'] as $fav)
                    @php $offer = $fav->itemData; @endphp
                    <div class="fav-item">
                        <a href="{{ route('offers.show', $offer->slug) }}" class="fav-item-image">
                            <img src="{{ url('/storage' . $offer->main_image) }}" alt="{{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}">
                        </a>
                        <div class="fav-item-body">
                            <span class="fav-type-badge offer">{{ __('lang.offers') }}</span>
                            <a href="{{ route('offers.show', $offer->slug) }}" class="fav-item-title">
                                {{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}
                            </a>
                            <div class="fav-item-meta">
                                @if($offer->category)
                                <span><i class="fal fa-folder"></i> {{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}</span>
                                @endif
                                @if(isset($fav->selectedPrice) && $fav->selectedPrice)
                                <span><i class="fal fa-map-marker-alt"></i> {{ app()->getLocale() == 'ar' ? $fav->selectedPrice->emirate->title_arabic : $fav->selectedPrice->emirate->title_english }}</span>
                                @endif
                            </div>
                            @if($fav->price)
                            <div class="fav-item-price">
                                {{ number_format($fav->price) }} {{ $offer->currency ? $offer->currency->code : 'AED' }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Interior --}}
                @if($grouped['interiors']->count() > 0)
                <div class="fav-section" data-section="interiors">
                    @foreach($grouped['interiors'] as $fav)
                    @php $interior = $fav->itemData; @endphp
                    <div class="fav-item">
                        <div class="fav-item-image">
                            <img src="{{ url('/storage' . $interior->image) }}" alt="{{ app()->getLocale() == 'ar' ? $interior->title_arabic : $interior->title_english }}">
                        </div>
                        <div class="fav-item-body">
                            <span class="fav-type-badge interior">{{ __('lang.interior_design') ?? 'Interior' }}</span>
                            <span class="fav-item-title">
                                {{ app()->getLocale() == 'ar' ? $interior->title_arabic : $interior->title_english }}
                            </span>
                            <div class="fav-item-meta">
                                @if($interior->category)
                                <span><i class="fal fa-folder"></i> {{ app()->getLocale() == 'ar' ? $interior->category->title_arabic : $interior->category->title_english }}</span>
                                @endif
                                @if($interior->projectStyle)
                                <span><i class="fal fa-palette"></i> {{ app()->getLocale() == 'ar' ? $interior->projectStyle->title_arabic : $interior->projectStyle->title_english }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.fav-tab');
    var sections = document.querySelectorAll('.fav-section');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            var target = tab.getAttribute('data-target');

            sections.forEach(function(section) {
                if (target === 'all') {
                    section.style.display = '';
                } else {
                    section.style.display = section.getAttribute('data-section') === target ? '' : 'none';
                }
            });
        });
    });
});
</script>
@endsection
