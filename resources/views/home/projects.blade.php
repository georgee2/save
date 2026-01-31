{{-- Projects by Category Section --}}
@if(isset($projectCategories) && $projectCategories->count() > 0)
<section class="pt-lg-12 pt-11 pb-11 home-projects-section">
    <div class="container container-xxl">
        <div class="row flex-lg-row flex-column">
            <div class="col-lg-5 col-xxl-6">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13">{{ __('lang.explore') }}</span>
                <h2 class="text-heading mt-2 mb-0">{{ __('lang.our_projects') }}</h2>
                <span class="heading-divider"></span>
                <p class="mb-7">{{ __('lang.projects_bio') }}</p>
            </div>
            <div class="col-lg-7 col-xxl-6">
                {{-- Desktop: Show first 3 categories + More dropdown for all --}}
                <ul class="nav nav-pills mt-lg-4 justify-content-lg-end mb-lg-0 mb-6 d-none d-lg-flex project-category-nav" role="tablist">
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3">
                        <a class="pointer nav-link active fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 text-active-white bg-active-primary rounded-lg"
                           id="pills-all-projects-tab" data-toggle="pill" href="#pills-all-projects" role="tab"
                           aria-controls="pills-all-projects" aria-selected="true">{{ __('lang.all') }}</a>
                    </li>
                    @foreach($projectCategories->take(2) as $category)
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3">
                        <a class="pointer nav-link fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 text-active-white bg-active-primary rounded-lg"
                           id="pills-cat-{{ $category->id }}-tab" data-toggle="pill" href="#pills-cat-{{ $category->id }}" role="tab"
                           aria-controls="pills-cat-{{ $category->id }}" aria-selected="false">
                            {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                        </a>
                    </li>
                    @endforeach
                    {{-- More dropdown with ALL categories --}}
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3 dropdown project-more-dropdown">
                        <a class="pointer nav-link fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 rounded-lg dropdown-toggle"
                           href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('lang.more') }} <i class="fas fa-chevron-down ml-1 fs-10"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right project-dropdown-menu">
                            @foreach($projectCategories as $category)
                            <a class="dropdown-item project-dropdown-item" href="#pills-cat-{{ $category->id }}" 
                               data-toggle="pill" data-target="#pills-cat-{{ $category->id }}"
                               role="tab" aria-controls="pills-cat-{{ $category->id }}">
                                {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                            </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                
                {{-- Mobile/Tablet: Horizontal scrollable pills --}}
                <div class="d-lg-none mb-4 project-category-mobile-wrapper">
                    <div class="project-category-mobile-scroll">
                        <button type="button" class="project-mobile-pill active" data-target="pills-all-projects">
                            {{ __('lang.all') }}
                        </button>
                        @foreach($projectCategories as $category)
                        <button type="button" class="project-mobile-pill" data-target="pills-cat-{{ $category->id }}">
                            {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-content p-0 shadow-none" id="pills-projects-tabContent">
            {{-- All Projects Tab --}}
            <div class="tab-pane fade show active" id="pills-all-projects" role="tabpanel" aria-labelledby="pills-all-projects-tab">
                <div class="row">
                    @php
                        $allProjects = $projectCategories->flatMap(function($cat) {
                            return $cat->projects;
                        })->unique('id')->take(8);
                    @endphp
                    @foreach($allProjects as $project)
                    @php
                        $imgCount = ($project->images_count ?? 0) + 1;
                        $vidCount = (!empty($project->video_url) ? 1 : 0) + (!empty($project->tour_url) ? 1 : 0);
                    @endphp
                    <div class="col-xxl-3 col-lg-4 col-md-6 mb-6" data-animate="zoomIn">
                        <div class="card border-0 bg-overlay-gradient-3 rounded-lg hover-change-image project-card-square">
                            <img src="{{ url('/storage' . $project->main_image) }}" class="card-img"
                                 alt="{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}">
                            <div class="card-img-overlay d-flex flex-column position-relative-sm">
                                <div class="d-flex justify-content-between">
                                    <ul class="list-inline mb-0 d-flex justify-content-center align-items-center h-100 hover-image project-media-count">
                                        @if($imgCount > 0)
                                        <li class="list-inline-item">
                                            <a href="{{ route('projects.show', $project->slug) }}" class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="{{ $imgCount }} {{ __('lang.images') }}">
                                                <i class="far fa-images"></i>
                                            </a>
                                        </li>
                                        @endif
                                        @if($vidCount > 0)
                                        <li class="list-inline-item">
                                            <a href="{{ route('projects.show', $project->slug) }}" class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="{{ $vidCount }} {{ __('lang.videos') }}">
                                                <i class="far fa-play-circle"></i>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="ml-auto h-24 d-flex">
                                        @if($project->category)
                                        <span class="badge badge-primary">
                                            {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-auto px-2">
                                    @if($project->sqft)
                                    <p class="fs-17 font-weight-bold text-white mb-0 lh-13">
                                        {{ number_format($project->sqft) }} <span class="fs-14 font-weight-500">{{ __('lang.sqft') }}</span>
                                    </p>
                                    @endif
                                    <h4 class="mt-0 mb-2 lh-1">
                                        <a href="{{ route('projects.show', $project->slug) }}" class="fs-16 text-white">
                                            {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                                        </a>
                                    </h4>
                                    @if($project->specifications->count() > 0)
                                    <div class="border-top border-white-opacity-03 pt-2">
                                        <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                            @foreach($project->specifications->take(4) as $spec)
                                            @if($spec->specification)
                                            <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-4"
                                                data-toggle="tooltip" title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                                                @if($spec->specification->icon)
                                                <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                                     alt="" class="mr-1" style="width: 18px; height: 18px; object-fit: contain; filter: brightness(0) invert(1);">
                                                @endif
                                                {{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Category Tabs --}}
            @foreach($projectCategories as $category)
            <div class="tab-pane fade" id="pills-cat-{{ $category->id }}" role="tabpanel" aria-labelledby="pills-cat-{{ $category->id }}-tab">
                <div class="row">
                    @foreach($category->projects as $project)
                    @php
                        $imgCount = ($project->images_count ?? 0) + 1;
                        $vidCount = (!empty($project->video_url) ? 1 : 0) + (!empty($project->tour_url) ? 1 : 0);
                    @endphp
                    <div class="col-xxl-3 col-lg-4 col-md-6 mb-6" data-animate="zoomIn">
                        <div class="card border-0 bg-overlay-gradient-3 rounded-lg hover-change-image project-card-square">
                            <img src="{{ url('/storage' . $project->main_image) }}" class="card-img"
                                 alt="{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}">
                            <div class="card-img-overlay d-flex flex-column position-relative-sm">
                                <div class="d-flex justify-content-between">
                                    <ul class="list-inline mb-0 d-flex justify-content-center align-items-center h-100 hover-image project-media-count">
                                        @if($imgCount > 0)
                                        <li class="list-inline-item">
                                            <a href="{{ route('projects.show', $project->slug) }}" class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="{{ $imgCount }} {{ __('lang.images') }}">
                                                <i class="far fa-images"></i>
                                            </a>
                                        </li>
                                        @endif
                                        @if($vidCount > 0)
                                        <li class="list-inline-item">
                                            <a href="{{ route('projects.show', $project->slug) }}" class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="{{ $vidCount }} {{ __('lang.videos') }}">
                                                <i class="far fa-play-circle"></i>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="ml-auto h-24 d-flex">
                                        @if($project->subcategory)
                                        <span class="badge badge-primary">
                                            {{ app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-auto px-2">
                                    @if($project->sqft)
                                    <p class="fs-17 font-weight-bold text-white mb-0 lh-13">
                                        {{ number_format($project->sqft) }} <span class="fs-14 font-weight-500">{{ __('lang.sqft') }}</span>
                                    </p>
                                    @endif
                                    <h4 class="mt-0 mb-2 lh-1">
                                        <a href="{{ route('projects.show', $project->slug) }}" class="fs-16 text-white">
                                            {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                                        </a>
                                    </h4>
                                    @if($project->specifications->count() > 0)
                                    <div class="border-top border-white-opacity-03 pt-2">
                                        <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                            @foreach($project->specifications->take(4) as $spec)
                                            @if($spec->specification)
                                            <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-4"
                                                data-toggle="tooltip" title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                                                @if($spec->specification->icon)
                                                <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                                     alt="" class="mr-1" style="width: 18px; height: 18px; object-fit: contain; filter: brightness(0) invert(1);">
                                                @endif
                                                {{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Project Category Filter Styles --}}
<style>
/* Desktop More Dropdown */
.project-more-dropdown .dropdown-toggle::after {
    display: none;
}

.project-dropdown-menu {
    min-width: 220px;
    padding: 8px 0;
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    max-height: 300px;
    overflow-y: auto;
}

.project-dropdown-item {
    padding: 10px 20px;
    font-size: 13px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: #696969;
    transition: all 0.2s ease;
}

.project-dropdown-item:hover,
.project-dropdown-item:focus {
    background-color: #eff6f7;
    color: #19868b;
}

.project-dropdown-item.active {
    background-color: #19868b;
    color: #fff;
}

/* Mobile Category - Horizontal Scrollable Pills */
.project-category-mobile-wrapper {
    position: relative;
    margin: 0 -15px;
    padding: 0 15px;
}

.project-category-mobile-scroll {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    overflow-y: hidden;
    padding: 8px 5px;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.project-category-mobile-scroll::-webkit-scrollbar {
    display: none;
}

.project-mobile-pill {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    padding: 0 20px;
    border: 2px solid #e0e0e0;
    border-radius: 20px;
    background: #fff;
    color: #555;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.25s ease;
}

.project-mobile-pill:hover {
    border-color: #19868b;
    color: #19868b;
}

.project-mobile-pill.active {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 12px rgba(25, 134, 139, 0.35);
}

/* RTL Support */
[dir="rtl"] .project-category-mobile-wrapper {
    margin: 0 -15px;
    padding: 0 15px;
}

[dir="rtl"] .project-dropdown-menu {
    text-align: right;
}

/* Desktop nav item - show complete text */
.project-category-nav .nav-link {
    white-space: nowrap;
}
</style>

{{-- Project Category Filter Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile pill buttons functionality
    document.querySelectorAll('.project-mobile-pill').forEach(function(pill) {
        pill.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var targetTab = document.getElementById(targetId);
            
            // Remove active from all tabs
            document.querySelectorAll('#pills-projects-tabContent .tab-pane').forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });
            
            // Remove active from all mobile pills
            document.querySelectorAll('.project-mobile-pill').forEach(function(p) {
                p.classList.remove('active');
            });
            
            // Remove active from all nav links (desktop)
            document.querySelectorAll('.project-category-nav .nav-link').forEach(function(link) {
                link.classList.remove('active');
                link.setAttribute('aria-selected', 'false');
            });
            
            // Remove active from dropdown items
            document.querySelectorAll('.project-dropdown-item').forEach(function(item) {
                item.classList.remove('active');
            });
            
            // Activate selected tab
            if (targetTab) {
                targetTab.classList.add('show', 'active');
            }
            
            // Mark this pill as active
            this.classList.add('active');
            
            // Sync desktop nav if visible
            var desktopTab = document.querySelector('[href="#' + targetId + '"]');
            if (desktopTab && desktopTab.classList.contains('nav-link')) {
                desktopTab.classList.add('active');
                desktopTab.setAttribute('aria-selected', 'true');
            }
        });
    });
    
    // Desktop dropdown items - sync with tabs
    document.querySelectorAll('.project-dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            var targetId = this.getAttribute('href').replace('#', '');
            var targetTab = document.getElementById(targetId);
            
            // Remove active from all tabs
            document.querySelectorAll('#pills-projects-tabContent .tab-pane').forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });
            
            // Remove active from all nav links
            document.querySelectorAll('.project-category-nav .nav-link').forEach(function(link) {
                link.classList.remove('active');
                link.setAttribute('aria-selected', 'false');
            });
            
            // Remove active from all dropdown items
            document.querySelectorAll('.project-dropdown-item').forEach(function(di) {
                di.classList.remove('active');
            });
            
            // Remove active from all mobile pills
            document.querySelectorAll('.project-mobile-pill').forEach(function(p) {
                p.classList.remove('active');
            });
            
            // Activate selected tab
            if (targetTab) {
                targetTab.classList.add('show', 'active');
            }
            
            // Mark dropdown item as active
            this.classList.add('active');
            
            // Sync mobile pill
            var mobilePill = document.querySelector('.project-mobile-pill[data-target="' + targetId + '"]');
            if (mobilePill) {
                mobilePill.classList.add('active');
            }
            
            // Close dropdown
            var dropdown = this.closest('.dropdown');
            if (dropdown) {
                var dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                if (dropdownToggle && typeof bootstrap !== 'undefined') {
                    bootstrap.Dropdown.getInstance(dropdownToggle)?.hide();
                } else {
                    $(dropdownToggle).dropdown('hide');
                }
            }
        });
    });
    
    // Sync mobile pills when desktop tabs are clicked
    document.querySelectorAll('.project-category-nav .nav-link[data-toggle="pill"]').forEach(function(tab) {
        tab.addEventListener('click', function() {
            var targetId = this.getAttribute('href').replace('#', '');
            
            // Remove active from all mobile pills
            document.querySelectorAll('.project-mobile-pill').forEach(function(p) {
                p.classList.remove('active');
            });
            
            // Sync mobile pill
            var mobilePill = document.querySelector('.project-mobile-pill[data-target="' + targetId + '"]');
            if (mobilePill) {
                mobilePill.classList.add('active');
            }
            
            // Remove active from dropdown items
            document.querySelectorAll('.project-dropdown-item').forEach(function(item) {
                item.classList.remove('active');
            });
        });
    });
});
</script>
@endif
