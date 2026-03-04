
<?php if(isset($sliders) && $sliders->count() > 0): ?>
<section class="home-slider-wrapper position-relative">
    <div class="slick-slider arrow-inner mx-0" data-slick-options='{"slidesToShow": 1, "autoplay": true, "autoplaySpeed": 5000, "dots": false, "arrows": true, "fade": true, "pauseOnHover": false, "infinite": true}'>
        
        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Determine background image
            $bgImage = $slider->image ? url('/storage' . $slider->image) : '';
            
            if ($slider->slider_type == 'project' && $slider->project) {
                if (!$bgImage && $slider->project->cover_image) {
                    $bgImage = url('/storage' . $slider->project->cover_image);
                } elseif (!$bgImage && $slider->project->main_image) {
                    $bgImage = url('/storage' . $slider->project->main_image);
                }
            } elseif ($slider->slider_type == 'offer' && $slider->offer) {
                if (!$bgImage && $slider->offer->cover_image) {
                    $bgImage = url('/storage' . $slider->offer->cover_image);
                } elseif (!$bgImage && $slider->offer->main_image) {
                    $bgImage = url('/storage' . $slider->offer->main_image);
                }
            }
        ?>
        
        <div class="box px-0 d-flex flex-column">
            <div class="bg-cover custom-vh-04 d-flex align-items-center" style="background-image: url('<?php echo e($bgImage); ?>')">
                <div class="container">
                    <div class="row">
                        
                        <?php if(($slider->slider_type ?? 'default') == 'default'): ?>
                        <div class="col-lg-6 col-md-8 col-sm-10 mt-xl-1 py-8 pt-lg-12">
                            <div class="slider-default-content" data-animate="fadeInUp">
                                <h1 class="text-white fs-48 lh-12 mb-3 font-weight-bold slider-title-shadow">
                                    <?php echo e(app()->getLocale() == 'ar' ? $slider->title_arabic : $slider->title_english); ?>

                                </h1>
                                <?php if($slider->bio_english || $slider->bio_arabic): ?>
                                <p class="text-white fs-18 lh-17 mb-5 opacity-90">
                                    <?php echo e(app()->getLocale() == 'ar' ? $slider->bio_arabic : $slider->bio_english); ?>

                                </p>
                                <?php endif; ?>
                                <?php if($slider->button_text_english || $slider->button_text_arabic): ?>
                                <a href="<?php echo e(app()->getLocale() == 'ar' ? ($slider->url_arabic ?? $slider->url_english ?? '#') : ($slider->url_english ?? '#')); ?>" 
                                   class="btn btn-primary btn-lg px-6">
                                    <?php echo e(app()->getLocale() == 'ar' ? ($slider->button_text_arabic ?? $slider->button_text_english) : $slider->button_text_english); ?>

                                    <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'left ml-2' : 'right ml-2'); ?>"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        
                        <?php elseif($slider->slider_type == 'project' && $slider->project): ?>
                        <?php $project = $slider->project; ?>
                        
                        
                        <div class="col-12 d-block d-md-none py-6">
                            <div class="slider-mobile-content" data-animate="fadeInUp">
                                <div class="slider-mobile-badges mb-2">
                                    <?php if($project->home_status == 0): ?>
                                    <span class="badge badge-orange mr-1"><?php echo e(__('lang.featured')); ?></span>
                                    <?php endif; ?>
                                    <?php if($project->category): ?>
                                    <span class="badge badge-primary">
                                        <?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                <h2 class="text-white fs-24 font-weight-bold mb-2 slider-title-shadow">
                                    <?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>

                                </h2>
                                <?php if($project->location_english || $project->location_arabic): ?>
                                <p class="text-white fs-14 mb-3 opacity-90">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <?php echo e(app()->getLocale() == 'ar' ? ($project->location_arabic ?? $project->location_english) : ($project->location_english ?? $project->location_arabic)); ?>

                                </p>
                                <?php endif; ?>
                                <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="btn btn-primary btn-sm px-4">
                                    <?php echo e(__('lang.view_project')); ?>

                                    <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'left ml-2' : 'right ml-2'); ?>"></i>
                                </a>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-5 offset-lg-7 col-md-6 offset-md-3 col-sm-8 offset-sm-2 mt-xl-1 py-8 pt-lg-12 d-none d-md-block">
                            <div class="bg-white px-7 pt-6 pb-4 rounded-lg ml-lg-n1 mb-xl-15" data-animate="flipInX">
                                <div class="mt-n7 position-absolute d-flex">
                                    <?php if($project->home_status == 0): ?>
                                    <span class="badge badge-orange mr-2"><?php echo e(__('lang.featured')); ?></span>
                                    <?php endif; ?>
                                    <?php if($project->category): ?>
                                    <span class="badge badge-primary">
                                        <?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                <h2 class="my-0">
                                    <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="fs-30 lh-12 text-dark hover-primary">
                                        <?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>

                                    </a>
                                </h2>
                                <?php if($project->location_english || $project->location_arabic): ?>
                                <p class="my-3 font-weight-500 text-gray-light lh-15">
                                    <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                    <?php echo e(app()->getLocale() == 'ar' ? ($project->location_arabic ?? $project->location_english) : ($project->location_english ?? $project->location_arabic)); ?>

                                </p>
                                <?php endif; ?>
                                <p class="fs-14 font-weight-500 letter-spacing-087 text-primary text-uppercase lh-15 mb-1">
                                    <?php echo e(__('lang.project')); ?>

                                </p>
                                <?php if($project->sqft): ?>
                                <p class="fs-22 font-weight-bold text-heading mb-3">
                                    <?php echo e(number_format($project->sqft)); ?> <?php echo e(__('lang.sqft')); ?>

                                </p>
                                <?php endif; ?>
                                
                                
                                <?php if($project->specifications && $project->specifications->count() > 0): ?>
                                <ul class="list-inline d-flex mb-0 flex-wrap border-top justify-content-between pt-4 mr-n2">
                                    <?php $__currentLoopData = $project->specifications->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($spec->specification): ?>
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2" 
                                        data-toggle="tooltip" 
                                        title="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>">
                                        <?php if($spec->specification->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                                             alt="" class="mr-2" 
                                             style="width: 18px; height: 18px; object-fit: contain;">
                                        <?php else: ?>
                                        <i class="fas fa-check-circle fs-18 text-primary mr-2"></i>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?>

                                    </li>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php endif; ?>
                                
                                <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="btn btn-primary btn-block mt-4">
                                    <?php echo e(__('lang.view_project')); ?>

                                    <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'left ml-2' : 'right ml-2'); ?>"></i>
                                </a>
                            </div>
                        </div>
                        
                        
                        <?php elseif($slider->slider_type == 'offer' && $slider->offer): ?>
                        <?php 
                            $offer = $slider->offer;
                            $defaultPrice = $offer->prices ? $offer->prices->where('status', 0)->first() : null;
                        ?>
                        
                        
                        <div class="col-12 d-block d-md-none py-6">
                            <div class="slider-mobile-content" data-animate="fadeInUp">
                                <div class="slider-mobile-badges mb-2">
                                    <?php if($offer->home_status == 0): ?>
                                    <span class="badge badge-orange mr-1"><?php echo e(__('lang.featured')); ?></span>
                                    <?php endif; ?>
                                    <?php if($offer->category): ?>
                                    <span class="badge badge-primary mr-1">
                                        <?php echo e(app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english); ?>

                                    </span>
                                    <?php endif; ?>
                                    <span class="badge badge-secondary"><?php echo e(__('lang.special_offer')); ?></span>
                                </div>
                                <h2 class="text-white fs-24 font-weight-bold mb-2 slider-title-shadow">
                                    <?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?>

                                </h2>
                                <?php if($offer->location_english || $offer->location_arabic): ?>
                                <p class="text-white fs-14 mb-2 opacity-90">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <?php echo e(app()->getLocale() == 'ar' ? ($offer->location_arabic ?? $offer->location_english) : ($offer->location_english ?? $offer->location_arabic)); ?>

                                </p>
                                <?php endif; ?>
                                <?php if($defaultPrice || $offer->project_cost): ?>
                                <p class="text-white fs-18 font-weight-bold mb-3">
                                    <?php echo e($offer->currency ? $offer->currency->abbreviation : 'AED'); ?>

                                    <?php echo e(number_format($defaultPrice ? $defaultPrice->price : $offer->project_cost)); ?>

                                </p>
                                <?php endif; ?>
                                <a href="<?php echo e(route('offers.show', $offer->slug)); ?>" class="btn btn-secondary btn-sm px-4">
                                    <?php echo e(__('lang.view_offer')); ?>

                                    <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'left ml-2' : 'right ml-2'); ?>"></i>
                                </a>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-5 offset-lg-7 col-md-6 offset-md-3 col-sm-8 offset-sm-2 mt-xl-1 py-8 pt-lg-12 d-none d-md-block">
                            <div class="bg-white px-7 pt-6 pb-4 rounded-lg ml-lg-n1 mb-xl-15" data-animate="flipInX">
                                <div class="mt-n7 position-absolute d-flex">
                                    <?php if($offer->home_status == 0): ?>
                                    <span class="badge badge-orange mr-2"><?php echo e(__('lang.featured')); ?></span>
                                    <?php endif; ?>
                                    <?php if($offer->category): ?>
                                    <span class="badge badge-primary mr-2">
                                        <?php echo e(app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english); ?>

                                    </span>
                                    <?php endif; ?>
                                    <span class="badge badge-secondary"><?php echo e(__('lang.special_offer')); ?></span>
                                </div>
                                <h2 class="my-0">
                                    <a href="<?php echo e(route('offers.show', $offer->slug)); ?>" class="fs-30 lh-12 text-dark hover-primary">
                                        <?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?>

                                    </a>
                                </h2>
                                <?php if($offer->location_english || $offer->location_arabic): ?>
                                <p class="my-3 font-weight-500 text-gray-light lh-15">
                                    <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                    <?php echo e(app()->getLocale() == 'ar' ? ($offer->location_arabic ?? $offer->location_english) : ($offer->location_english ?? $offer->location_arabic)); ?>

                                </p>
                                <?php endif; ?>
                                <p class="fs-14 font-weight-500 letter-spacing-087 text-secondary text-uppercase lh-15 mb-1">
                                    <?php echo e(__('lang.for_sale')); ?>

                                </p>
                                <?php if($defaultPrice || $offer->project_cost): ?>
                                <p class="fs-22 font-weight-bold text-heading mb-3">
                                    <?php echo e($offer->currency ? $offer->currency->abbreviation : 'AED'); ?>

                                    <?php echo e(number_format($defaultPrice ? $defaultPrice->price : $offer->project_cost)); ?>

                                </p>
                                <?php endif; ?>
                                
                                
                                <?php if($offer->specifications && $offer->specifications->count() > 0): ?>
                                <ul class="list-inline d-flex mb-0 flex-wrap border-top justify-content-between pt-4 mr-n2">
                                    <?php $__currentLoopData = $offer->specifications->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($spec->specification): ?>
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2" 
                                        data-toggle="tooltip" 
                                        title="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>">
                                        <?php if($spec->specification->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                                             alt="" class="mr-2" 
                                             style="width: 18px; height: 18px; object-fit: contain;">
                                        <?php else: ?>
                                        <i class="fas fa-check-circle fs-18 text-primary mr-2"></i>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?>

                                    </li>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php endif; ?>
                                
                                <a href="<?php echo e(route('offers.show', $offer->slug)); ?>" class="btn btn-secondary btn-block mt-4">
                                    <?php echo e(__('lang.view_offer')); ?>

                                    <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'left ml-2' : 'right ml-2'); ?>"></i>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
    </div>
</section>

<style>
/* Home Slider - Image dimensions: 1890x883 */
.home-slider-wrapper {
    position: relative;
}

/* Override custom-vh-04 to use exact aspect ratio from backend */
.home-slider-wrapper .custom-vh-04 {
    min-height: auto !important;
    aspect-ratio: 1890 / 883;
    background-position: center;
    background-size: cover;
}

.home-slider-wrapper .slider-title-shadow {
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
}

.home-slider-wrapper .slider-default-content {
    max-width: 600px;
}

.home-slider-wrapper .opacity-90 {
    opacity: 0.9;
}

/* Override arrow positioning for this slider */
.home-slider-wrapper .slick-arrow {
    z-index: 100;
}

.home-slider-wrapper .slick-prev {
    left: 30px !important;
}

.home-slider-wrapper .slick-next {
    right: 30px !important;
}

/* RTL Support */
[dir="rtl"] .home-slider-wrapper .slider-default-content {
    text-align: right;
}

[dir="rtl"] .home-slider-wrapper .ml-lg-n1 {
    margin-left: 0 !important;
    margin-right: -0.25rem !important;
}

[dir="rtl"] .home-slider-wrapper .slick-prev {
    left: auto !important;
    right: 30px !important;
}

[dir="rtl"] .home-slider-wrapper .slick-next {
    right: auto !important;
    left: 30px !important;
}

/* Responsive - maintain aspect ratio but set min-height for small screens */
@media (max-width: 1199px) {
    .home-slider-wrapper .custom-vh-04 {
        aspect-ratio: 1890 / 883;
    }
}

@media (max-width: 991px) {
    .home-slider-wrapper .fs-48 {
        font-size: 36px !important;
    }
    
    .home-slider-wrapper .slick-arrow {
        display: none !important;
    }
    
    .home-slider-wrapper .custom-vh-04 {
        aspect-ratio: 1890 / 883;
        min-height: 400px;
    }
}

@media (max-width: 767px) {
    .home-slider-wrapper .fs-48 {
        font-size: 28px !important;
    }
    
    .home-slider-wrapper .fs-18 {
        font-size: 15px !important;
    }
    
    .home-slider-wrapper .custom-vh-04 {
        aspect-ratio: 1890 / 883;
        min-height: 300px;
    }
}

@media (max-width: 575px) {
    .home-slider-wrapper .custom-vh-04 {
        min-height: 250px;
    }
    
    .home-slider-wrapper .fs-48 {
        font-size: 24px !important;
    }
}

/* Mobile Slider Content for Projects and Offers */
.home-slider-wrapper .slider-mobile-content {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.4) 70%, transparent 100%);
    padding: 20px;
    border-radius: 12px;
    max-width: 100%;
}

.home-slider-wrapper .slider-mobile-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.home-slider-wrapper .slider-mobile-badges .badge {
    font-size: 10px;
    padding: 4px 8px;
}

.home-slider-wrapper .slider-mobile-content h2 {
    line-height: 1.3;
}

.home-slider-wrapper .slider-mobile-content .opacity-90 {
    opacity: 0.9;
}

/* RTL Support for Mobile */
[dir="rtl"] .home-slider-wrapper .slider-mobile-content {
    text-align: right;
}

@media (max-width: 400px) {
    .home-slider-wrapper .slider-mobile-content {
        padding: 15px;
    }
    
    .home-slider-wrapper .slider-mobile-content h2 {
        font-size: 20px !important;
    }
    
    .home-slider-wrapper .slider-mobile-content .fs-14 {
        font-size: 12px !important;
    }
    
    .home-slider-wrapper .slider-mobile-content .fs-18 {
        font-size: 16px !important;
    }
}
</style>
<?php else: ?>

<section class="bg-cover custom-vh-04 d-flex align-items-center" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto text-center py-8">
                <h1 class="text-white fs-48 font-weight-bold mb-4"><?php echo e(__('lang.welcome')); ?></h1>
                <p class="text-white opacity-75 fs-18"><?php echo e(__('lang.site_description')); ?></p>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/slider.blade.php ENDPATH**/ ?>