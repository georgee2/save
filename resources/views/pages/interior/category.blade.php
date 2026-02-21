@extends('layouts.master')
@section('title', (app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english) . ' - ' . __('lang.interior_design'))
@section('seo_desc', app()->getLocale() == 'ar' ? ($currentCategory->bio_arabic ?? $currentCategory->title_arabic) : ($currentCategory->bio_english ?? $currentCategory->title_english))
@section('seo_tags', (app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english) . ', ' . __('lang.interior_design'))

@section('content')

<section class="pb-8 page-title shadow">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('interior.index') }}">{{ __('lang.interior_design') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english }}</li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english }}</h1>
            @if($currentCategory->bio_english || $currentCategory->bio_arabic)
            <p class="mb-0 mt-2 text-muted">{{ app()->getLocale() == 'ar' ? $currentCategory->bio_arabic : $currentCategory->bio_english }}</p>
            @endif
        </nav>
    </div>
</section>

{{-- Category Filter Slider --}}
@if(isset($categoriesWithCount) && $categoriesWithCount->count() > 0)
<section class="subcategory-filter-section">
    <div class="container">
        <div class="subcategory-filter-slider slick-slider" 
             data-slick-options='{"slidesToShow": 6, "slidesToScroll": 2, "autoplay": false, "dots": false, "arrows": true, "infinite": false, "responsive":[{"breakpoint": 1400,"settings": {"slidesToShow": 5, "arrows": true}},{"breakpoint": 1200,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 992,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 768,"settings": {"slidesToShow": 3, "arrows": true}},{"breakpoint": 576,"settings": {"slidesToShow": 2, "arrows": false}}]}'>
            
            {{-- All Categories Option --}}
            <div class="box">
                <a href="{{ route('interior.index') }}" 
                   class="subcategory-filter-item all-item">
                    <div class="subcategory-filter-icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <p class="subcategory-filter-title">{{ __('lang.all') }}</p>
                    <span class="subcategory-filter-count">{{ __('lang.view_all') }}</span>
                </a>
            </div>
            
            {{-- Category Items --}}
            @foreach($categoriesWithCount as $cat)
            <div class="box">
                <a href="{{ route('interior.category', $cat->slug) }}" 
                   class="subcategory-filter-item {{ $currentCategory->id == $cat->id ? 'active' : '' }}">
                    <div class="subcategory-filter-icon">
                        @if($cat->icon)
                        <img src="{{ url('/storage' . $cat->icon) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $cat->title_arabic : $cat->title_english }}">
                        @else
                        <i class="fas fa-couch"></i>
                        @endif
                    </div>
                    <p class="subcategory-filter-title">{{ app()->getLocale() == 'ar' ? $cat->title_arabic : $cat->title_english }}</p>
                    <span class="subcategory-filter-count">{{ $cat->galleries_count }} {{ __('lang.designs') }}</span>
                </a>
            </div>
            @endforeach
            
        </div>
    </div>
</section>
@endif

<section class="pt-8 pb-11 interior-gallery-page">
    <div class="container">
        {{-- Mobile Filter Overlay --}}
        <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>
        
        <div class="row">
            {{-- Main Gallery Container --}}
            <div class="gallery-main-container filter-hidden mb-8 mb-lg-0" id="galleryContainer">
                <div class="row align-items-sm-center mb-6">
                    <div class="col-md-6">
                        <h2 class="fs-15 text-dark mb-0">{{ __('lang.we_found') }} <span class="text-primary">{{ $galleries->total() }}</span> {{ __('lang.designs_available') ?? 'designs available' }}</h2>
                    </div>
                    <div class="col-md-6 mt-6 mt-md-0">
                        <div class="d-flex justify-content-md-end align-items-center flex-wrap">
                            {{-- Filter Toggle Button --}}
                            <button type="button" class="filter-toggle-btn mr-3" id="filterToggleBtn">
                                <i class="fas fa-filter"></i>
                                <span class="d-none d-sm-inline">{{ __('lang.filter') }}</span>
                                @php
                                    $activeFilters = 0;
                                    if(request('keyword')) $activeFilters++;
                                    if(request('style_id')) $activeFilters++;
                                    if(request('type_id')) $activeFilters++;
                                    if(request('emirate_id')) $activeFilters++;
                                @endphp
                                @if($activeFilters > 0)
                                <span class="filter-count">{{ $activeFilters }}</span>
                                @endif
                            </button>
                            
                            <div class="input-group border rounded input-group-lg w-auto bg-white">
                                <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3"
                                       for="sortbySelect"><i class="fas fa-align-left fs-16 pr-2"></i><span class="d-none d-sm-inline">{{ __('lang.sortby') }}:</span></label>
                                <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby-select"
                                        data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3"
                                        id="sortbySelect" name="sortby">
                                    <option value="newest" {{ request('sortby', 'newest') == 'newest' ? 'selected' : '' }}>{{ __('lang.newest') }}</option>
                                    <option value="oldest" {{ request('sortby') == 'oldest' ? 'selected' : '' }}>{{ __('lang.oldest') }}</option>
                                    <option value="title_asc" {{ request('sortby') == 'title_asc' ? 'selected' : '' }}>{{ __('lang.title_a_z') ?? 'Title A-Z' }}</option>
                                    <option value="title_desc" {{ request('sortby') == 'title_desc' ? 'selected' : '' }}>{{ __('lang.title_z_a') ?? 'Title Z-A' }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Gallery Grid --}}
                <div class="interior-gallery-grid" id="galleryGrid">
                    @forelse($galleries as $item)
                    <div class="interior-gallery-card" 
                         data-gallery-id="{{ $item->id }}"
                         data-title="{{ app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english }}"
                         data-bio="{{ app()->getLocale() == 'ar' ? $item->bio_arabic : $item->bio_english }}"
                         data-image="{{ url('/storage' . $item->image) }}"
                         data-category="{{ $item->category ? (app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english) : '' }}"
                         data-style="{{ $item->projectStyle ? (app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english) : '' }}"
                         data-emirate="{{ $item->emirate ? (app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english) : '' }}"
                         @if($item->project)
                         data-project-title="{{ app()->getLocale() == 'ar' ? $item->project->title_arabic : $item->project->title_english }}"
                         data-project-image="{{ $item->project->main_image ? url('/storage' . $item->project->main_image) : '' }}"
                         data-project-url="{{ route('projects.show', $item->project->slug) }}"
                         @endif
                    >
                        {{-- Card Image --}}
                        <div class="card-image">
                            <img src="{{ url('/storage' . $item->image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english }}"
                                 loading="lazy">
                            <div class="card-overlay"></div>
                        </div>
                        
                        {{-- View Button --}}
                        <div class="view-btn">
                            <i class="fas fa-expand"></i>
                        </div>
                        
                        {{-- Share Options --}}
                        @php
                            $shareTitle = app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english;
                            $shareCategory = $item->category ? (app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english) : '';
                            $shareStyle = $item->projectStyle ? (app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english) : '';
                            $shareEmirate = $item->emirate ? (app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english) : '';
                            $shareText = $shareTitle;
                            if($shareCategory) {
                                $shareText .= ' - ' . $shareCategory;
                            }
                            if($shareStyle) {
                                $shareText .= ' (' . $shareStyle . ')';
                            }
                            if($shareEmirate) {
                                $shareText .= ' | ' . $shareEmirate;
                            }
                            $shareUrl = route('interior.category', $currentCategory->slug);
                            $shareImage = url('/storage' . $item->image);
                        @endphp
                        <div class="interior-share-badge" onclick="event.stopPropagation();">
                            <div class="share-actions">
                                <div class="share-slide-wrapper">
                                    <button type="button" class="share-action-btn share-slide-btn">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    <div class="share-slide-icons">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}&quote={{ urlencode($shareText) }}" 
                                           target="_blank" class="share-action-btn facebook-btn" onclick="event.stopPropagation();">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareText) }}" 
                                           target="_blank" class="share-action-btn twitter-btn" onclick="event.stopPropagation();">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}&summary={{ urlencode($shareText) }}" 
                                           target="_blank" class="share-action-btn linkedin-btn" onclick="event.stopPropagation();">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode($shareUrl) }}&media={{ urlencode($shareImage) }}&description={{ urlencode($shareText) }}" 
                                           target="_blank" class="share-action-btn pinterest-btn" onclick="event.stopPropagation();">
                                            <i class="fab fa-pinterest-p"></i>
                                        </a>
                                        <a href="mailto:?subject={{ rawurlencode($shareTitle) }}&body={{ urlencode($shareText . "\n\n" . $shareUrl) }}" 
                                           class="share-action-btn email-btn" onclick="event.stopPropagation();">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </div>
                                </div>
                                <a href="https://wa.me/?text={{ urlencode($shareText . "\n" . $shareUrl) }}" 
                                   target="_blank" 
                                   class="share-action-btn whatsapp-share-btn"
                                   onclick="event.stopPropagation();">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                        
                        {{-- Card Content --}}
                        <div class="card-content">
                            <h4 class="card-category-title">
                                {{ app()->getLocale() == 'ar' ? $currentCategory->title_arabic : $currentCategory->title_english }}
                            </h4>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            {{ __('lang.no_designs_found') ?? 'No designs found' }}
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($galleries->hasPages())
                <nav class="pt-6">
                    <ul class="pagination rounded-active justify-content-center mb-0">
                        @if($galleries->onFirstPage())
                        <li class="page-item disabled"><span class="page-link"><i class="far fa-angle-double-left"></i></span></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ $galleries->previousPageUrl() }}"><i class="far fa-angle-double-left"></i></a></li>
                        @endif

                        @foreach($galleries->getUrlRange(1, $galleries->lastPage()) as $page => $url)
                            @if($page == $galleries->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if($galleries->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $galleries->nextPageUrl() }}"><i class="far fa-angle-double-right"></i></a></li>
                        @else
                        <li class="page-item disabled"><span class="page-link"><i class="far fa-angle-double-right"></i></span></li>
                        @endif
                    </ul>
                </nav>
                @endif
            </div>
            
            {{-- Filter Sidebar Wrapper --}}
            <div class="filter-sidebar-wrapper hidden" id="filterSidebarWrapper">
                {{-- Mobile Filter Header --}}
                <div class="mobile-filter-header d-lg-none">
                    <h4>{{ __('lang.filter') }}</h4>
                    <button type="button" class="mobile-filter-close" id="mobileFilterClose">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                
                @include('pages.interior.partials.filter-sidebar', [
                    'formAction' => route('interior.category', $currentCategory->slug),
                    'categories' => $categories,
                    'styles' => $styles,
                    'emirates' => $emirates,
                    'hideCategory' => true,
                    'currentCategory' => $currentCategory
                ])
            </div>
        </div>
    </div>
</section>

{{-- Gallery Modal --}}
<div class="interior-gallery-modal" id="interiorGalleryModal">
    <div class="modal-container">
        <button class="modal-close" id="closeGalleryModal">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-image-section">
            <img src="" alt="" id="modalImage">
        </div>
        
        <div class="modal-content-section">
            <span class="modal-category-badge" id="modalCategory"></span>
            <div class="modal-meta" id="modalMeta"></div>
            <div id="relatedProjectContainer"></div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/offers-filter.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('/assets/css/interior-gallery.css') }}?v={{ time() }}">
@endsection

@section('js')
<script>
$(document).ready(function() {
    var filterToggleBtn = $('#filterToggleBtn');
    var filterSidebar = $('#filterSidebarWrapper');
    var galleryContainer = $('#galleryContainer');
    var mobileFilterOverlay = $('#mobileFilterOverlay');
    var mobileFilterClose = $('#mobileFilterClose');
    var body = $('body');
    
    function isMobile() {
        return window.innerWidth <= 991;
    }
    
    filterToggleBtn.on('click', function() {
        if (isMobile()) {
            filterSidebar.toggleClass('visible hidden');
            mobileFilterOverlay.toggleClass('active');
            body.toggleClass('filter-open');
        } else {
            filterSidebar.toggleClass('visible hidden');
            galleryContainer.toggleClass('filter-visible filter-hidden');
        }
        $(this).toggleClass('active');
    });
    
    mobileFilterClose.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    mobileFilterOverlay.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    $('#sortbySelect').on('change', function() {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    $('.filter-select').on('changed.bs.select', function() {
        $('#interiorFilterForm').submit();
    });
});

// Gallery Modal
document.addEventListener('DOMContentLoaded', function() {
    const galleryCards = document.querySelectorAll('.interior-gallery-card');
    const modal = document.getElementById('interiorGalleryModal');
    const closeBtn = document.getElementById('closeGalleryModal');
    const modalImage = document.getElementById('modalImage');
    const modalCategory = document.getElementById('modalCategory');
    const modalMeta = document.getElementById('modalMeta');
    const relatedProjectContainer = document.getElementById('relatedProjectContainer');
    
    galleryCards.forEach(card => {
        card.addEventListener('click', function() {
            const image = this.dataset.image;
            const category = this.dataset.category;
            const style = this.dataset.style;
            const emirate = this.dataset.emirate;
            const projectTitle = this.dataset.projectTitle;
            const projectImage = this.dataset.projectImage;
            const projectUrl = this.dataset.projectUrl;
            
            modalImage.src = image;
            modalImage.alt = category || '';
            modalCategory.textContent = category || '';
            
            let metaHtml = '';
            if (style) metaHtml += `<div class="modal-meta-item"><i class="fas fa-palette"></i><div><span class="meta-label">{{ __('lang.style') }}</span><span class="meta-value">${style}</span></div></div>`;
            if (emirate) metaHtml += `<div class="modal-meta-item"><i class="fas fa-map-marker-alt"></i><div><span class="meta-label">{{ __('lang.location') }}</span><span class="meta-value">${emirate}</span></div></div>`;
            modalMeta.innerHTML = metaHtml;
            
            let projectHtml = '';
            if (projectTitle && projectUrl) {
                projectHtml = `<a href="${projectUrl}" class="related-project">${projectImage ? `<div class="related-project-image"><img src="${projectImage}" alt="${projectTitle}"></div>` : ''}<div class="related-project-info"><span class="related-project-label">{{ __('lang.related_project') ?? 'Related Project' }}</span><span class="related-project-title">${projectTitle}</span></div><i class="fas fa-arrow-right"></i></a>`;
            }
            relatedProjectContainer.innerHTML = projectHtml;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });
    
    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (modal) modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && modal && modal.classList.contains('active')) closeModal(); });
});
</script>
@endsection
