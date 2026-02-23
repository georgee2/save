
<?php if(isset($projectCategories) && $projectCategories->count() > 0): ?>
<section class="pt-lg-12 pt-11 pb-11 home-projects-section">
    <div class="container container-xxl">
        <div class="row flex-lg-row flex-column">
            <div class="col-lg-5 col-xxl-6">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13"><?php echo e(__('lang.explore')); ?></span>
                <h2 class="text-heading mt-2 mb-0"><?php echo e(__('lang.our_projects')); ?></h2>
                <span class="heading-divider"></span>
                <p class="mb-7"><?php echo e(__('lang.projects_bio')); ?></p>
            </div>
            <div class="col-lg-7 col-xxl-6">
                
                <ul class="nav nav-pills mt-lg-4 justify-content-lg-end mb-lg-0 mb-6 d-none d-lg-flex project-category-nav" role="tablist">
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3">
                        <a class="pointer nav-link active fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 text-active-white bg-active-primary rounded-lg"
                           id="pills-all-projects-tab" data-toggle="pill" href="#pills-all-projects" role="tab"
                           aria-controls="pills-all-projects" aria-selected="true"><?php echo e(__('lang.all')); ?></a>
                    </li>
                    <?php $__currentLoopData = $projectCategories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3">
                        <a class="pointer nav-link fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 text-active-white bg-active-primary rounded-lg"
                           id="pills-cat-<?php echo e($category->id); ?>-tab" data-toggle="pill" href="#pills-cat-<?php echo e($category->id); ?>" role="tab"
                           aria-controls="pills-cat-<?php echo e($category->id); ?>" aria-selected="false">
                            <?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?>

                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <li class="nav-item pl-lg-3 pr-3 pr-lg-0 mb-3 dropdown project-more-dropdown">
                        <a class="pointer nav-link fs-13 letter-spacing-087 text-secondary text-uppercase px-4 bg-gray-01 rounded-lg dropdown-toggle"
                           href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo e(__('lang.more')); ?> <i class="fas fa-chevron-down ml-1 fs-10"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right project-dropdown-menu">
                            <?php $__currentLoopData = $projectCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item project-dropdown-item" href="#pills-cat-<?php echo e($category->id); ?>" 
                               data-toggle="pill" data-target="#pills-cat-<?php echo e($category->id); ?>"
                               role="tab" aria-controls="pills-cat-<?php echo e($category->id); ?>">
                                <?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </li>
                </ul>
                
                
                <div class="d-lg-none mb-4 project-category-mobile-wrapper">
                    <div class="project-category-mobile-nav">
                        <button type="button" class="project-mobile-pill active" data-target="pills-all-projects">
                            <?php echo e(__('lang.all')); ?>

                        </button>
                        <?php $__currentLoopData = $projectCategories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" class="project-mobile-pill" data-target="pills-cat-<?php echo e($category->id); ?>">
                            <?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?>

                        </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($projectCategories->count() > 2): ?>
                        <div class="project-mobile-more-dropdown">
                            <button type="button" class="project-mobile-pill project-mobile-more-btn">
                                <?php echo e(__('lang.more')); ?> <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div class="project-mobile-dropdown-menu">
                                <?php $__currentLoopData = $projectCategories->skip(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" class="project-mobile-dropdown-item" data-target="pills-cat-<?php echo e($category->id); ?>">
                                    <?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?>

                                </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-content p-0 shadow-none" id="pills-projects-tabContent">
            
            <div class="tab-pane fade show active" id="pills-all-projects" role="tabpanel" aria-labelledby="pills-all-projects-tab">
                <div class="row project-grid-container" data-mobile-limit="6" data-category-limit="6">
                    <?php
                        $allProjects = $projectCategories->flatMap(function($cat) {
                            return $cat->projects;
                        })->unique('id')->take(10);
                        $allProjectsCount = $allProjects->count();
                    ?>
                    <?php $__currentLoopData = $allProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $imgCount = ($project->images_count ?? 0) + 1;
                        $vidCount = (!empty($project->video_url) ? 1 : 0) + (!empty($project->tour_url) ? 1 : 0);
                    ?>
                    <div class="col-xxl-3 col-lg-4 col-md-6 mb-6 project-grid-item" data-index="<?php echo e($index); ?>" data-animate="zoomIn">
                        <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="card border-0 bg-overlay-gradient-light rounded-lg hover-change-image project-card-square d-block">
                            <img src="<?php echo e(url('/storage' . $project->main_image)); ?>" class="card-img"
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>">
                            <div class="card-img-overlay d-flex flex-column position-relative-sm pointer-events-none">
                                <div class="d-flex justify-content-between">
                                    <ul class="list-inline mb-0 d-flex justify-content-center align-items-center h-100 hover-image project-media-count">
                                        <?php if($imgCount > 0): ?>
                                        <li class="list-inline-item">
                                            <span class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="<?php echo e($imgCount); ?> <?php echo e(__('lang.images')); ?>">
                                                <i class="far fa-images"></i>
                                            </span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($vidCount > 0): ?>
                                        <li class="list-inline-item">
                                            <span class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="<?php echo e($vidCount); ?> <?php echo e(__('lang.videos')); ?>">
                                                <i class="far fa-play-circle"></i>
                                            </span>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="ml-auto h-24 d-flex">
                                        <?php if($project->category): ?>
                                        <span class="badge badge-primary">
                                            <?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?>

                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-auto px-2">
                                    <?php if($project->sqft): ?>
                                    <p class="fs-17 font-weight-bold text-white mb-0 lh-13">
                                        <?php echo e(number_format($project->sqft)); ?> <span class="fs-14 font-weight-500"><?php echo e(__('lang.sqft')); ?></span>
                                    </p>
                                    <?php endif; ?>
                                    <h4 class="mt-0 mb-2 lh-1">
                                        <span class="fs-16 text-white">
                                            <?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>

                                        </span>
                                    </h4>
                                    <?php if($project->specifications->count() > 0): ?>
                                    <div class="border-top border-white-opacity-03 pt-2">
                                        <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                            <?php $__currentLoopData = $project->specifications->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($spec->specification): ?>
                                            <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-4"
                                                data-toggle="tooltip" title="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>">
                                                <?php if($spec->specification->icon): ?>
                                                <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                                                     alt="" class="mr-1" style="width: 18px; height: 18px; object-fit: contain; filter: brightness(0) invert(1);">
                                                <?php endif; ?>
                                                <?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?>

                                            </li>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($allProjectsCount > 6): ?>
                <div class="text-center mt-4 d-lg-none project-load-more-wrapper">
                    <button type="button" class="btn btn-outline-primary project-load-more-btn" data-target="pills-all-projects">
                        <?php echo e(__('lang.load_more')); ?> <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            
            
            <?php $__currentLoopData = $projectCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane fade" id="pills-cat-<?php echo e($category->id); ?>" role="tabpanel" aria-labelledby="pills-cat-<?php echo e($category->id); ?>-tab">
                <div class="row project-grid-container" data-mobile-limit="3" data-category-limit="3">
                    <?php $__currentLoopData = $category->projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $imgCount = ($project->images_count ?? 0) + 1;
                        $vidCount = (!empty($project->video_url) ? 1 : 0) + (!empty($project->tour_url) ? 1 : 0);
                    ?>
                    <div class="col-xxl-3 col-lg-4 col-md-6 mb-6 project-grid-item" data-index="<?php echo e($index); ?>" data-animate="zoomIn">
                        <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="card border-0 bg-overlay-gradient-light rounded-lg hover-change-image project-card-square d-block">
                            <img src="<?php echo e(url('/storage' . $project->main_image)); ?>" class="card-img"
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>">
                            <div class="card-img-overlay d-flex flex-column position-relative-sm pointer-events-none">
                                <div class="d-flex justify-content-between">
                                    <ul class="list-inline mb-0 d-flex justify-content-center align-items-center h-100 hover-image project-media-count">
                                        <?php if($imgCount > 0): ?>
                                        <li class="list-inline-item">
                                            <span class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="<?php echo e($imgCount); ?> <?php echo e(__('lang.images')); ?>">
                                                <i class="far fa-images"></i>
                                            </span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($vidCount > 0): ?>
                                        <li class="list-inline-item">
                                            <span class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-dark-opacity-03"
                                                  data-toggle="tooltip" title="<?php echo e($vidCount); ?> <?php echo e(__('lang.videos')); ?>">
                                                <i class="far fa-play-circle"></i>
                                            </span>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="ml-auto h-24 d-flex">
                                        <?php if($project->subcategory): ?>
                                        <span class="badge badge-primary">
                                            <?php echo e(app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english); ?>

                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-auto px-2">
                                    <?php if($project->sqft): ?>
                                    <p class="fs-17 font-weight-bold text-white mb-0 lh-13">
                                        <?php echo e(number_format($project->sqft)); ?> <span class="fs-14 font-weight-500"><?php echo e(__('lang.sqft')); ?></span>
                                    </p>
                                    <?php endif; ?>
                                    <h4 class="mt-0 mb-2 lh-1">
                                        <span class="fs-16 text-white">
                                            <?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>

                                        </span>
                                    </h4>
                                    <?php if($project->specifications->count() > 0): ?>
                                    <div class="border-top border-white-opacity-03 pt-2">
                                        <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                            <?php $__currentLoopData = $project->specifications->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($spec->specification): ?>
                                            <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-4"
                                                data-toggle="tooltip" title="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>">
                                                <?php if($spec->specification->icon): ?>
                                                <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                                                     alt="" class="mr-1" style="width: 18px; height: 18px; object-fit: contain; filter: brightness(0) invert(1);">
                                                <?php endif; ?>
                                                <?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?>

                                            </li>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($category->projects->count() > 3): ?>
                <div class="text-center mt-4 d-lg-none project-load-more-wrapper">
                    <button type="button" class="btn btn-outline-primary project-load-more-btn" data-target="pills-cat-<?php echo e($category->id); ?>">
                        <?php echo e(__('lang.load_more')); ?> <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


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

/* Mobile Category - Pills with Dropdown */
.project-category-mobile-wrapper {
    position: relative;
}

.project-category-mobile-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
}

.project-mobile-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    padding: 8px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 20px;
    background: #fff;
    color: #555;
    font-size: 12px;
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

/* Mobile More Dropdown */
.project-mobile-more-dropdown {
    position: relative;
    display: inline-block;
}

.project-mobile-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.project-mobile-more-btn i {
    font-size: 10px;
    transition: transform 0.3s ease;
}

.project-mobile-more-dropdown.open .project-mobile-more-btn i {
    transform: rotate(180deg);
}

.project-mobile-dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    min-width: 200px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    padding: 8px 0;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.project-mobile-more-dropdown.open .project-mobile-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.project-mobile-dropdown-item {
    display: block;
    width: 100%;
    padding: 12px 20px;
    background: transparent;
    border: none;
    text-align: left;
    color: #555;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.project-mobile-dropdown-item:hover {
    background: #f5f5f5;
    color: #19868b;
}

.project-mobile-dropdown-item.active {
    background: rgba(25, 134, 139, 0.1);
    color: #19868b;
    font-weight: 600;
}

/* RTL Support for dropdown */
[dir="rtl"] .project-mobile-dropdown-menu {
    left: auto;
    right: 0;
}

[dir="rtl"] .project-mobile-dropdown-item {
    text-align: right;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .project-category-mobile-wrapper {
        display: block !important;
    }
    
    .project-mobile-pill {
        font-size: 11px;
        padding: 6px 16px;
        min-height: 36px;
    }
}

@media (max-width: 575px) {
    .project-category-mobile-nav {
        gap: 8px;
    }
    
    .project-mobile-pill {
        font-size: 10px;
        padding: 5px 14px;
        min-height: 34px;
        letter-spacing: 0.3px;
    }
    
    .project-mobile-dropdown-menu {
        min-width: 180px;
    }
    
    .project-mobile-dropdown-item {
        font-size: 12px;
        padding: 10px 16px;
    }
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

/* Ensure desktop nav is hidden on mobile/tablet */
@media (max-width: 991px) {
    .project-category-nav {
        display: none !important;
    }
}

/* Ensure mobile nav is hidden on desktop */
@media (min-width: 992px) {
    .project-category-mobile-wrapper {
        display: none !important;
    }
}

/* Load More Button Styles */
.project-load-more-wrapper {
    margin-top: 20px;
}

.project-load-more-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 30px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 2px solid #19868b;
    border-radius: 30px;
    color: #19868b;
    background: transparent;
    transition: all 0.3s ease;
}

.project-load-more-btn:hover {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 15px rgba(25, 134, 139, 0.3);
}

.project-load-more-btn i {
    transition: transform 0.3s ease;
}

.project-load-more-btn:hover i {
    transform: translateY(3px);
}

.project-load-more-btn.loading {
    pointer-events: none;
    opacity: 0.7;
}

.project-load-more-btn.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Mobile/Tablet: Hide items beyond limit */
@media (max-width: 991px) {
    .project-grid-item.mobile-hidden {
        display: none !important;
    }
    
    .project-load-more-wrapper.all-loaded {
        display: none !important;
    }
}

/* Desktop: Always show all items and hide load more button */
@media (min-width: 992px) {
    .project-grid-item.mobile-hidden {
        display: block !important;
    }
    
    .project-load-more-wrapper {
        display: none !important;
    }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Track if initial load has been done for each container
    var initializedContainers = new Set();
    var previousWidth = window.innerWidth;
    
    // Check if we're on mobile/tablet
    function isMobileOrTablet() {
        return window.innerWidth < 992;
    }
    
    // Initialize mobile load more functionality (only on first load or when crossing breakpoint)
    function initMobileLoadMore(forceReset) {
        document.querySelectorAll('.project-grid-container').forEach(function(container) {
            var containerId = container.closest('.tab-pane')?.id || 'default';
            
            // Only initialize if not already done (unless forced)
            if (!forceReset && initializedContainers.has(containerId)) {
                return;
            }
            
            var limit = parseInt(container.getAttribute('data-mobile-limit')) || 6;
            var items = container.querySelectorAll('.project-grid-item');
            
            items.forEach(function(item, index) {
                if (isMobileOrTablet() && index >= limit) {
                    item.classList.add('mobile-hidden');
                } else {
                    item.classList.remove('mobile-hidden');
                }
            });
            
            // Mark as initialized
            initializedContainers.add(containerId);
            
            // Update load more button visibility
            var tabPane = container.closest('.tab-pane');
            if (tabPane) {
                var loadMoreWrapper = tabPane.querySelector('.project-load-more-wrapper');
                if (loadMoreWrapper) {
                    var hiddenItems = container.querySelectorAll('.project-grid-item.mobile-hidden');
                    if (hiddenItems.length === 0) {
                        loadMoreWrapper.classList.add('all-loaded');
                    } else {
                        loadMoreWrapper.classList.remove('all-loaded');
                    }
                }
            }
        });
    }
    
    // Load more button click handler
    document.querySelectorAll('.project-load-more-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var tabPane = document.getElementById(targetId);
            if (!tabPane) return;
            
            var container = tabPane.querySelector('.project-grid-container');
            if (!container) return;
            
            var loadMoreWrapper = this.closest('.project-load-more-wrapper');
            var hiddenItems = container.querySelectorAll('.project-grid-item.mobile-hidden');
            var limit = parseInt(container.getAttribute('data-mobile-limit')) || 6;
            
            // Show loading state
            this.classList.add('loading');
            var icon = this.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-spinner ml-2';
            }
            
            // Simulate loading delay for smooth UX
            setTimeout(function() {
                // Show next batch of items
                var shown = 0;
                hiddenItems.forEach(function(item) {
                    if (shown < limit) {
                        item.classList.remove('mobile-hidden');
                        item.setAttribute('data-loaded', 'true');
                        shown++;
                    }
                });
                
                // Reset button state
                btn.classList.remove('loading');
                if (icon) {
                    icon.className = 'fas fa-chevron-down ml-2';
                }
                
                // Check if all items are now visible
                var remainingHidden = container.querySelectorAll('.project-grid-item.mobile-hidden');
                if (remainingHidden.length === 0) {
                    loadMoreWrapper.classList.add('all-loaded');
                }
            }, 300);
        });
    });
    
    // Initialize on page load
    initMobileLoadMore(true);
    
    // Re-initialize on window resize ONLY when crossing the mobile/desktop breakpoint
    var resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            var currentWidth = window.innerWidth;
            var crossedBreakpoint = (previousWidth >= 992 && currentWidth < 992) || 
                                    (previousWidth < 992 && currentWidth >= 992);
            
            if (crossedBreakpoint) {
                // Reset all containers when crossing breakpoint
                initializedContainers.clear();
                initMobileLoadMore(true);
            }
            
            previousWidth = currentWidth;
        }, 250);
    });
    
    // Reset load more when switching tabs
    function resetTabLoadMore(targetId) {
        var tabPane = document.getElementById(targetId);
        if (!tabPane) return;
        
        var container = tabPane.querySelector('.project-grid-container');
        if (!container) return;
        
        var limit = parseInt(container.getAttribute('data-mobile-limit')) || 6;
        var items = container.querySelectorAll('.project-grid-item');
        
        if (isMobileOrTablet()) {
            items.forEach(function(item, index) {
                if (index >= limit) {
                    item.classList.add('mobile-hidden');
                    item.removeAttribute('data-loaded');
                } else {
                    item.classList.remove('mobile-hidden');
                }
            });
            
            // Reset load more button
            var loadMoreWrapper = tabPane.querySelector('.project-load-more-wrapper');
            if (loadMoreWrapper) {
                var hiddenItems = container.querySelectorAll('.project-grid-item.mobile-hidden');
                if (hiddenItems.length === 0) {
                    loadMoreWrapper.classList.add('all-loaded');
                } else {
                    loadMoreWrapper.classList.remove('all-loaded');
                }
            }
        }
    }
    
    // Helper function to switch tabs
    function switchToTab(targetId) {
        var targetTab = document.getElementById(targetId);
        
        // Remove active from all tabs
        document.querySelectorAll('#pills-projects-tabContent .tab-pane').forEach(function(pane) {
            pane.classList.remove('show', 'active');
        });
        
        // Remove active from all mobile pills
        document.querySelectorAll('.project-mobile-pill:not(.project-mobile-more-btn)').forEach(function(p) {
            p.classList.remove('active');
        });
        
        // Remove active from all nav links (desktop)
        document.querySelectorAll('.project-category-nav .nav-link').forEach(function(link) {
            link.classList.remove('active');
            link.setAttribute('aria-selected', 'false');
        });
        
        // Remove active from desktop dropdown items
        document.querySelectorAll('.project-dropdown-item').forEach(function(item) {
            item.classList.remove('active');
        });
        
        // Remove active from mobile dropdown items
        document.querySelectorAll('.project-mobile-dropdown-item').forEach(function(item) {
            item.classList.remove('active');
        });
        
        // Activate selected tab
        if (targetTab) {
            targetTab.classList.add('show', 'active');
        }
        
        // Sync desktop nav if visible
        var desktopTab = document.querySelector('[href="#' + targetId + '"]');
        if (desktopTab && desktopTab.classList.contains('nav-link')) {
            desktopTab.classList.add('active');
            desktopTab.setAttribute('aria-selected', 'true');
        }
        
        // Sync desktop dropdown item
        var desktopDropdownItem = document.querySelector('.project-dropdown-item[href="#' + targetId + '"]');
        if (desktopDropdownItem) {
            desktopDropdownItem.classList.add('active');
        }
        
        // Reset load more for the new tab
        resetTabLoadMore(targetId);
    }
    
    // Mobile pill buttons functionality (not the More button)
    document.querySelectorAll('.project-mobile-pill:not(.project-mobile-more-btn)').forEach(function(pill) {
        pill.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            if (!targetId) return;
            
            switchToTab(targetId);
            this.classList.add('active');
            
            // Close mobile dropdown if open
            var mobileDropdown = document.querySelector('.project-mobile-more-dropdown');
            if (mobileDropdown) {
                mobileDropdown.classList.remove('open');
            }
        });
    });
    
    // Mobile More dropdown toggle
    var mobileMoreBtn = document.querySelector('.project-mobile-more-btn');
    var mobileMoreDropdown = document.querySelector('.project-mobile-more-dropdown');
    
    if (mobileMoreBtn && mobileMoreDropdown) {
        mobileMoreBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMoreDropdown.classList.toggle('open');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMoreDropdown.contains(e.target)) {
                mobileMoreDropdown.classList.remove('open');
            }
        });
    }
    
    // Mobile dropdown items
    document.querySelectorAll('.project-mobile-dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            var targetId = this.getAttribute('data-target');
            if (!targetId) return;
            
            switchToTab(targetId);
            this.classList.add('active');
            
            // Update More button to show it has active selection
            if (mobileMoreBtn) {
                mobileMoreBtn.classList.add('active');
            }
            
            // Close mobile dropdown
            if (mobileMoreDropdown) {
                mobileMoreDropdown.classList.remove('open');
            }
        });
    });
    
    // Desktop dropdown items - sync with tabs
    document.querySelectorAll('.project-dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            var targetId = this.getAttribute('href').replace('#', '');
            
            switchToTab(targetId);
            this.classList.add('active');
            
            // Sync mobile dropdown item
            var mobileDropdownItem = document.querySelector('.project-mobile-dropdown-item[data-target="' + targetId + '"]');
            if (mobileDropdownItem) {
                mobileDropdownItem.classList.add('active');
                if (mobileMoreBtn) {
                    mobileMoreBtn.classList.add('active');
                }
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
            
            // Remove active from mobile dropdown items
            document.querySelectorAll('.project-mobile-dropdown-item').forEach(function(item) {
                item.classList.remove('active');
            });
            
            // Sync mobile pill
            var mobilePill = document.querySelector('.project-mobile-pill[data-target="' + targetId + '"]');
            if (mobilePill) {
                mobilePill.classList.add('active');
            }
            
            // Sync mobile dropdown item
            var mobileDropdownItem = document.querySelector('.project-mobile-dropdown-item[data-target="' + targetId + '"]');
            if (mobileDropdownItem) {
                mobileDropdownItem.classList.add('active');
                if (mobileMoreBtn) {
                    mobileMoreBtn.classList.add('active');
                }
            }
            
            // Remove active from desktop dropdown items
            document.querySelectorAll('.project-dropdown-item').forEach(function(item) {
                item.classList.remove('active');
            });
            
            // Reset load more for the new tab
            resetTabLoadMore(targetId);
        });
    });
});
</script>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/projects.blade.php ENDPATH**/ ?>