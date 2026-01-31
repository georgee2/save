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
                    
                    {{-- Share Badge --}}
                    <div class="project-share-badge">
                        <div class="share-actions">
                            {{-- Share Slide Out --}}
                            <div class="share-slide-wrapper">
                                <button type="button" class="share-action-btn share-slide-btn">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                                <div class="share-slide-icons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('projects.show', $project->slug)) }}" 
                                       target="_blank" class="share-action-btn facebook-btn">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('projects.show', $project->slug)) }}&text={{ urlencode(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english) }}" 
                                       target="_blank" class="share-action-btn twitter-btn">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('projects.show', $project->slug)) }}" 
                                       target="_blank" class="share-action-btn linkedin-btn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="https://www.instagram.com/" 
                                       target="_blank" class="share-action-btn instagram-btn">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="mailto:?subject={{ rawurlencode(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english) }}&body={{ urlencode(route('projects.show', $project->slug)) }}" 
                                       class="share-action-btn email-btn">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- WhatsApp Separate --}}
                            <a href="https://wa.me/?text={{ urlencode(route('projects.show', $project->slug)) }}" 
                               target="_blank" 
                               class="share-action-btn whatsapp-share-btn" 
                               data-toggle="tooltip" 
                               data-placement="top"
                               title="{{ __('lang.share_whatsapp') }}">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body pt-3">
                        <h2 class="card-title fs-16 lh-2 mb-0">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-dark hover-primary">
                                {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                            </a>
                        </h2>
                        <div class="project-category-info mb-2">
                            @if($project->category)
                            <a href="{{ route('category.show', $project->category->slug) }}" class="project-cat-link" title="{{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}">
                                {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}
                            </a>
                            @endif
                            @if($project->category && $project->subcategory)
                            <span class="cat-divider">•</span>
                            @endif
                            @if($project->subcategory)
                            <a href="{{ route('subcategory.show', $project->subcategory->slug) }}" class="project-subcat-link" title="{{ app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english }}">
                                {{ app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english }}
                            </a>
                            @endif
                        </div>
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
    height: 620px;
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

/* Project Share Badge */
.project-share-badge {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
    padding: 8px 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: visible !important;
    position: relative;
    z-index: 10;
}

/* Ensure card doesn't clip dropdown */
.featured-projects-section .card.shadow-hover-2 {
    overflow: visible !important;
}

.featured-projects-section .hover-change-image {
    overflow: hidden !important;
    border-radius: 0 !important;
}

.featured-projects-section .card-img-top {
    border-radius: 0 !important;
}

.project-share-badge .share-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.project-share-badge .share-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 12px;
}

.project-share-badge .share-action-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
    color: #ffffff;
}

.project-share-badge .whatsapp-share-btn:hover {
    background: #25D366;
}

/* Share Slide Out for Projects */
.project-share-badge .share-slide-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.project-share-badge .share-slide-btn {
    background: rgba(255, 255, 255, 0.2) !important;
    z-index: 2;
    position: relative;
}

.project-share-badge .share-slide-btn:hover {
    background: rgba(255, 255, 255, 0.3) !important;
}

.project-share-badge .share-slide-icons {
    display: flex;
    align-items: center;
    gap: 4px;
    position: absolute;
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    padding: 6px 10px;
    margin-right: 6px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    background: rgba(0, 0, 0, 0.7);
    border-radius: 20px;
    backdrop-filter: blur(5px);
}

.project-share-badge .share-slide-wrapper:hover .share-slide-icons {
    opacity: 1;
    visibility: visible;
}

.project-share-badge .share-slide-icons .share-action-btn {
    width: 26px;
    height: 26px;
    font-size: 11px;
}

.project-share-badge .share-slide-icons .facebook-btn {
    background: #3b5998;
}

.project-share-badge .share-slide-icons .facebook-btn:hover {
    background: #2d4373;
}

.project-share-badge .share-slide-icons .twitter-btn {
    background: #1da1f2;
}

.project-share-badge .share-slide-icons .twitter-btn:hover {
    background: #0c85d0;
}

.project-share-badge .share-slide-icons .linkedin-btn {
    background: #0077b5;
}

.project-share-badge .share-slide-icons .linkedin-btn:hover {
    background: #005885;
}

.project-share-badge .share-slide-icons .instagram-btn {
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}

.project-share-badge .share-slide-icons .instagram-btn:hover {
    background: linear-gradient(45deg, #e08323 0%, #d6582c 25%, #cc1733 50%, #bc1356 75%, #ac0878 100%);
}

.project-share-badge .share-slide-icons .email-btn {
    background: #6c757d;
}

.project-share-badge .share-slide-icons .email-btn:hover {
    background: #545b62;
}

/* Category/Subcategory - Simple Text Links */
.featured-projects-section .project-category-info {
    font-size: 13px;
    line-height: 1.5;
    color: #6c757d;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 40px;
}

.featured-projects-section .project-cat-link,
.featured-projects-section .project-subcat-link {
    color: #19868b;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.featured-projects-section .project-cat-link:hover,
.featured-projects-section .project-subcat-link:hover {
    color: #e1273d;
    text-decoration: underline;
}

.featured-projects-section .cat-divider {
    color: #adb5bd;
    margin: 0 6px;
}
</style>
@endif
