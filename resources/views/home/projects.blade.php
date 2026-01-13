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
                <ul class="nav nav-pills mt-lg-4 justify-content-lg-end mb-lg-0 mb-6" role="tablist">
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3">
                        <a class="pointer nav-link active fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 text-active-white bg-active-primary rounded-lg"
                           id="pills-all-projects-tab" data-toggle="pill" href="#pills-all-projects" role="tab"
                           aria-controls="pills-all-projects" aria-selected="true">{{ __('lang.all') }}</a>
                    </li>
                    @foreach($projectCategories as $category)
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3">
                        <a class="pointer nav-link fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 text-active-white bg-active-primary rounded-lg"
                           id="pills-cat-{{ $category->id }}-tab" data-toggle="pill" href="#pills-cat-{{ $category->id }}" role="tab"
                           aria-controls="pills-cat-{{ $category->id }}" aria-selected="false">
                            {{ app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english }}
                        </a>
                    </li>
                    @endforeach
                </ul>
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
@endif
