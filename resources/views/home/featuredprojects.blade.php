{{-- Featured Projects Section --}}
@if(isset($featuredProjects) && $featuredProjects->count() > 0)
<section class="pt-lg-12 pb-lg-11 py-11 featured-projects-section">
    <div class="container container-xxl">
        <div class="row align-items-center mb-6">
            <div class="col-md-7">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13">{{ __('lang.our_work') }}</span>
                <h2 class="text-heading mt-2 mb-0">{{ __('lang.featured_projects_title') }}</h2>
                <span class="heading-divider"></span>
                <p class="mb-0">{{ __('lang.featured_projects_bio') }}</p>
            </div>
            <div class="col-md-5 text-md-right mt-4 mt-md-0">
                <a href="{{ route('projects.featured') }}" class="btn fs-14 text-secondary btn-accent py-3 lh-15 px-7 mb-6 mb-lg-0">
                    {{ __('lang.featured_projects_button') }}
                    <i class="far fa-long-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="slick-slider slick-dots-mt-0 custom-arrow-spacing-30"
            data-slick-options='{"slidesToShow": 4,"dots":true,"arrows":false,"responsive":[{"breakpoint": 1600,"settings": {"slidesToShow":3}},{"breakpoint": 992,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 768,"settings": {"slidesToShow": 2,"arrows":false,"dots":true,"autoplay":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":true,"autoplay":true}}]}'>
            
            @foreach($featuredProjects as $project)
            <div class="box box pb-7 pt-2" data-animate="fadeInUp">
                <div class="card shadow-hover-2">
                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                        <img src="{{ url('/storage' . $project->main_image) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}">
                        <div class="card-img-overlay p-2 d-flex flex-column">
                            <div class="d-flex justify-content-end">
                                <span class="badge badge-primary">{{ __('lang.featured') }}</span>
                            </div>
                            <ul class="list-inline mb-0 mt-auto hover-image">
                                @if($project->total_images > 0)
                                <li class="list-inline-item mr-2" data-toggle="tooltip" title="{{ $project->total_images }} {{ __('lang.images') }}">
                                    <a href="{{ route('projects.show', $project->slug) }}" class="text-white hover-primary">
                                        <i class="far fa-images"></i><span class="pl-1">{{ $project->total_images }}</span>
                                    </a>
                                </li>
                                @endif
                                @if($project->video_count > 0)
                                <li class="list-inline-item" data-toggle="tooltip" title="{{ $project->video_count }} {{ __('lang.videos') }}">
                                    <a href="{{ route('projects.show', $project->slug) }}" class="text-white hover-primary">
                                        <i class="far fa-play-circle"></i><span class="pl-1">{{ $project->video_count }}</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <h2 class="card-title fs-16 lh-2 mb-0">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-dark hover-primary">
                                {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                            </a>
                        </h2>
                        <p class="card-text font-weight-500 text-gray-light mb-2">
                            @if($project->category)
                                <a href="#" class="text-gray-light hover-primary">
                                    {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}
                                </a>
                            @endif
                            @if($project->subcategory)
                                <span class="mx-1">/</span>
                                <a href="#" class="text-gray-light hover-primary">
                                    {{ app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english }}
                                </a>
                            @endif
                        </p>
                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                            @foreach($project->specifications->take(4) as $spec)
                            @if($spec->specification)
                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                                data-toggle="tooltip" title="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}">
                                @if($spec->specification->icon)
                                <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                                     class="mr-2 spec-icon" 
                                     style="width: 24px; height: 24px; object-fit: contain;">
                                @else
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-2 spec-icon-placeholder" 
                                      style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                                    {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                                </span>
                                @endif
                                <span class="spec-value">{{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                        <p class="fs-17 font-weight-bold text-heading mb-0">
                            @if($project->sqft)
                            {{ number_format($project->sqft) }} <span class="text-gray-light font-weight-500 fs-14">{{ __('lang.sqft') }}</span>
                            @endif
                        </p>
                        <a href="{{ route('projects.show', $project->slug) }}" 
                           class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                            {{ __('lang.view_project') }}
                            <i class="far fa-long-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</section>

<style>
/* Home Featured Projects - Fixed Height Cards */
.featured-projects-section .slick-slider .card.shadow-hover-2 {
    height: 580px;
    display: flex;
    flex-direction: column;
}

.featured-projects-section .slick-slider .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.featured-projects-section .slick-slider .card-footer {
    margin-top: auto;
}
</style>
@endif
