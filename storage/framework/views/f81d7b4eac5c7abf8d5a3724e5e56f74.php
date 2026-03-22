<?php
    $offerTitle = app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english;
    $offerDesc = app()->getLocale() == 'ar' ? ($offer->seo_description_ar ?? $offer->title_arabic) : ($offer->seo_description ?? $offer->title_english);
    $offerImage = url('/storage' . $offer->main_image);
    $offerPrice = ($offer->default_price && $offer->currency) 
        ? ($offer->currency->abbreviation ?? 'AED') . ' ' . number_format($offer->default_price->price)
        : '';
    $offerEmirate = ($offer->default_price && $offer->default_price->emirate)
        ? (app()->getLocale() == 'ar' ? $offer->default_price->emirate->title_arabic : $offer->default_price->emirate->title_english)
        : '';
    $ogDescription = $offerDesc;
    if($offerPrice) {
        $ogDescription = $offerPrice . ($offerEmirate ? ' - ' . $offerEmirate : '') . ' | ' . $offerDesc;
    }
?>

<?php $__env->startSection('title', $offerTitle . ' - ' . __('lang.offers')); ?>
<?php $__env->startSection('seo_desc', $offerDesc); ?>
<?php $__env->startSection('seo_tags', $offer->seo_tags ?? $offerTitle); ?>


<?php $__env->startSection('og_title', $offerTitle . ($offerPrice ? ' - ' . $offerPrice : '')); ?>
<?php $__env->startSection('og_description', $ogDescription); ?>
<?php $__env->startSection('og_image', $offerImage); ?>
<?php $__env->startSection('og_type', 'product'); ?>

<?php $__env->startSection('meta_tags'); ?>

<?php if($offerPrice): ?>
<meta property="product:price:amount" content="<?php echo e($offer->default_price->price ?? ''); ?>">
<meta property="product:price:currency" content="<?php echo e($offer->currency->abbreviation ?? 'AED'); ?>">
<?php endif; ?>
<?php if($offer->offer_code): ?>
<meta property="product:retailer_item_id" content="<?php echo e($offer->offer_code); ?>">
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<section class="pb-8 page-title shadow">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
                <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('lang.home')); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('offers.index')); ?>"><?php echo e(__('lang.offers')); ?></a></li>
                <?php if($offer->category): ?>
                <li class="breadcrumb-item"><a href="<?php echo e(route('offers.category', $offer->category->slug)); ?>"><?php echo e(app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english); ?></a></li>
                <?php endif; ?>
                <?php if($offer->subcategory): ?>
                <li class="breadcrumb-item"><a href="<?php echo e(route('offers.subcategory', $offer->subcategory->slug)); ?>"><?php echo e(app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english); ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?></li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600"><?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?></h1>
        </nav>
    </div>
</section>


<section class="pt-8 pb-11 offers-page">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 mb-8 mb-lg-0">
                
                <div class="offer-gallery-container mb-6">
                    <div class="row no-gutters">
                        
                        <div class="col-2 col-md-2 pr-2">
                            <div class="offer-thumbnails-wrapper">
                                <div class="offer-thumbnails-slider" id="offerThumbnails">
                                    
                                    <div class="thumbnail-item active" data-index="0">
                                        <img src="<?php echo e(url('/storage' . $offer->main_image)); ?>" 
                                             alt="<?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?>"
                                             class="thumbnail-img">
                                    </div>
                                    
                                    <?php if($offer->images && $offer->images->count() > 0): ?>
                                        <?php $__currentLoopData = $offer->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="thumbnail-item" data-index="<?php echo e($index + 1); ?>">
                                            <img src="<?php echo e(url('/storage' . $image->image)); ?>" 
                                                 alt=""
                                                 class="thumbnail-img">
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if($offer->images && $offer->images->count() > 4): ?>
                                <div class="thumbnail-nav">
                                    <button type="button" class="thumb-nav-btn thumb-prev" id="thumbPrev">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button type="button" class="thumb-nav-btn thumb-next" id="thumbNext">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        
                        <div class="col-10 col-md-10">
                            <div class="offer-main-slider-wrapper position-relative">
                                <div class="offer-main-slider" id="offerMainSlider">
                                    
                                    <div class="main-slide">
                                        <a href="<?php echo e(url('/storage' . $offer->main_image)); ?>" 
                                           class="offer-gallery-item"
                                           data-gtf-mfp="true" 
                                           data-gallery-id="offer-gallery">
                                            <img src="<?php echo e(url('/storage' . $offer->main_image)); ?>" 
                                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?>"
                                                 class="main-slide-img">
                                        </a>
                                    </div>
                                    
                                    <?php if($offer->images && $offer->images->count() > 0): ?>
                                        <?php $__currentLoopData = $offer->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="main-slide">
                                            <a href="<?php echo e(url('/storage' . $image->image)); ?>" 
                                               class="offer-gallery-item"
                                               data-gtf-mfp="true" 
                                               data-gallery-id="offer-gallery">
                                                <img src="<?php echo e(url('/storage' . $image->image)); ?>" 
                                                     alt=""
                                                     class="main-slide-img">
                                            </a>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                                
                                
                                <?php if($offer->selected_price): ?>
                                <div class="offer-price-tag offer-price-tag-show position-absolute" id="galleryPriceTag" style="top: 20px; right: 20px; left: auto; bottom: auto; z-index: 5;">
                                    <div class="price-label"><?php echo e(__('lang.starting_from')); ?></div>
                                    <div class="price-value">
                                        <?php echo e($offer->currency->abbreviation ?? 'AED'); ?> <span id="galleryPriceAmount"><?php echo e(number_format($offer->selected_price->price)); ?></span>
                                    </div>
                                    <div class="price-emirate" id="galleryEmirateName">
                                        <?php echo e($offer->selected_price->emirate ? (app()->getLocale() == 'ar' ? $offer->selected_price->emirate->title_arabic : $offer->selected_price->emirate->title_english) : ''); ?>

                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                
                                <div class="position-absolute d-flex" style="bottom: 20px; right: 20px; z-index: 5; gap: 10px;">
                                    <?php if($offer->total_images > 0): ?>
                                    <span class="media-item text-white" style="background: rgba(0,0,0,0.6); padding: 8px 12px; border-radius: 6px; font-size: 14px;">
                                        <i class="far fa-images mr-1"></i> <?php echo e($offer->total_images); ?> <?php echo e(__('lang.images')); ?>

                                    </span>
                                    <?php endif; ?>
                                    <?php if($offer->video_count > 0): ?>
                                    <span class="media-item text-white" style="background: rgba(0,0,0,0.6); padding: 8px 12px; border-radius: 6px; font-size: 14px;">
                                        <i class="far fa-play-circle mr-1"></i> <?php echo e($offer->video_count); ?> <?php echo e(__('lang.videos')); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                
                                
                                <button type="button" class="slider-nav-btn slider-prev" id="sliderPrev">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="slider-nav-btn slider-next" id="sliderNext">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-align-left"></i>
                                <?php echo e(__('lang.description')); ?>

                            </h3>
                        </div>
                        <div class="offer-description">
                            <?php echo app()->getLocale() == 'ar' ? ($offer->description_arabic ?? __('lang.no_description')) : ($offer->description_english ?? __('lang.no_description')); ?>

                        </div>
                    </div>
                </div>
                
                
                <?php if($offer->specifications && $offer->specifications->count() > 0): ?>
                <div class="card border-0 shadow-sm mb-6 specifications-card">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-clipboard-list"></i>
                                <?php echo e(__('lang.specifications')); ?>

                            </h3>
                        </div>
                        <div class="specifications-grid">
                            <?php $__currentLoopData = $offer->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($spec->specification): ?>
                            <div class="spec-item">
                                <div class="spec-icon-wrapper">
                                    <?php if($spec->specification->icon): ?>
                                    <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                                         alt="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>">
                                    <?php else: ?>
                                    <span class="spec-placeholder">
                                        <?php echo e(mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1)); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="spec-content">
                                    <span class="spec-label"><?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?></span>
                                    <span class="spec-value"><?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                
                <?php if($offer->plan_3d_image): ?>
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-cube"></i>
                                <?php echo e(__('lang.3d_image')); ?>

                            </h3>
                        </div>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10 col-12 mb-4">
                                <div class="position-relative rounded-lg overflow-hidden visual-image-wrapper">
                                    <a href="<?php echo e(url('/storage' . $offer->plan_3d_image)); ?>" 
                                       data-gtf-mfp="true" 
                                       data-gallery-id="visual-plan-gallery"
                                       class="d-block">
                                        <img src="<?php echo e(url('/storage' . $offer->plan_3d_image)); ?>" 
                                             alt="<?php echo e(__('lang.3d_image')); ?>" 
                                             class="w-100 rounded-lg"
                                             style="object-fit: contain; max-height: 600px;">
                                        <div class="position-absolute d-flex align-items-center justify-content-center" 
                                             style="bottom: 15px; left: 15px; background: rgba(0,0,0,0.7); padding: 8px 16px; border-radius: 6px;">
                                            <i class="fal fa-cube text-white mr-2"></i>
                                            <span class="text-white font-weight-500 fs-14"><?php echo e(__('lang.3d_image')); ?></span>
                                        </div>
                                        <div class="position-absolute d-flex align-items-center justify-content-center hover-overlay-visual" 
                                             style="top: 0; left: 0; right: 0; bottom: 0; background: rgba(25,134,139,0.3); opacity: 0; transition: opacity 0.3s;">
                                            <i class="fal fa-search-plus text-white fs-40"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                
                <div class="card border-0 shadow-sm mb-6 facts-features-card">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-info-circle"></i>
                                <?php echo e(__('lang.facts_and_features')); ?>

                            </h3>
                        </div>
                        <div class="facts-grid">
                            <?php if($offer->category): ?>
                            <div class="fact-item">
                                <div class="fact-icon-wrapper category-icon">
                                    <?php if($offer->category->icon): ?>
                                    <img src="<?php echo e(url('/storage' . $offer->category->icon)); ?>" 
                                         alt="<?php echo e(app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english); ?>">
                                    <?php else: ?>
                                    <span class="fact-placeholder">
                                        <i class="fas fa-folder"></i>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label"><?php echo e(__('lang.category')); ?></span>
                                    <span class="fact-value"><?php echo e(app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($offer->subcategory): ?>
                            <div class="fact-item">
                                <div class="fact-icon-wrapper subcategory-icon">
                                    <?php if($offer->subcategory->icon): ?>
                                    <img src="<?php echo e(url('/storage' . $offer->subcategory->icon)); ?>" 
                                         alt="<?php echo e(app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english); ?>">
                                    <?php else: ?>
                                    <span class="fact-placeholder">
                                        <i class="fas fa-folder-open"></i>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label"><?php echo e(__('lang.subcategory')); ?></span>
                                    <span class="fact-value"><?php echo e(app()->getLocale() == 'ar' ? $offer->subcategory->title_arabic : $offer->subcategory->title_english); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($offer->type): ?>
                            <div class="fact-item">
                                <div class="fact-icon-wrapper type-icon">
                                    <?php if($offer->type->icon): ?>
                                    <img src="<?php echo e(url('/storage' . $offer->type->icon)); ?>" 
                                         alt="<?php echo e(app()->getLocale() == 'ar' ? $offer->type->name_arabic : $offer->type->name_english); ?>">
                                    <?php else: ?>
                                    <span class="fact-placeholder">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label"><?php echo e(__('lang.type')); ?></span>
                                    <span class="fact-value"><?php echo e(app()->getLocale() == 'ar' ? $offer->type->name_arabic : $offer->type->name_english); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($offer->style): ?>
                            <div class="fact-item">
                                <div class="fact-icon-wrapper style-icon">
                                    <?php if($offer->style->icon): ?>
                                    <img src="<?php echo e(url('/storage' . $offer->style->icon)); ?>" 
                                         alt="<?php echo e(app()->getLocale() == 'ar' ? $offer->style->title_arabic : $offer->style->title_english); ?>">
                                    <?php else: ?>
                                    <span class="fact-placeholder">
                                        <i class="fas fa-paint-brush"></i>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label"><?php echo e(__('lang.style')); ?></span>
                                    <span class="fact-value"><?php echo e(app()->getLocale() == 'ar' ? $offer->style->title_arabic : $offer->style->title_english); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($offer->sqft): ?>
                            <div class="fact-item">
                                <div class="fact-icon-wrapper sqft-icon">
                                    <span class="fact-placeholder">
                                        <i class="fas fa-ruler-combined"></i>
                                    </span>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label"><?php echo e(__('lang.sqft')); ?></span>
                                    <span class="fact-value"><?php echo e(number_format($offer->sqft)); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($offer->sqm): ?>
                            <div class="fact-item">
                                <div class="fact-icon-wrapper sqm-icon">
                                    <span class="fact-placeholder">
                                        <i class="fas fa-vector-square"></i>
                                    </span>
                                </div>
                                <div class="fact-content">
                                    <span class="fact-label"><?php echo e(__('lang.sqm')); ?></span>
                                    <span class="fact-value"><?php echo e(number_format($offer->sqm)); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                
                <?php echo $__env->make('pages.offers.partials.floors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
                
                <?php echo $__env->make('pages.offers.partials.feasibility', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
                
                <?php if($offer->video_url): ?>
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-video"></i>
                                <?php echo e(__('lang.offer_video')); ?>

                            </h3>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9 rounded overflow-hidden">
                            <?php
                                $videoUrl = $offer->video_url;
                                // Convert YouTube watch URLs to embed format
                                if (strpos($videoUrl, 'youtube.com/watch') !== false) {
                                    preg_match('/[?&]v=([^&]+)/', $videoUrl, $matches);
                                    if (isset($matches[1])) {
                                        $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                    }
                                } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                    $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 1);
                                    $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                                }
                            ?>
                            <iframe class="embed-responsive-item" src="<?php echo e($videoUrl); ?>" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                
                <?php if($offer->tour_url): ?>
                <div class="card border-0 shadow-sm mb-6">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <h3 class="fs-20 text-heading font-weight-600">
                                <i class="fas fa-vr-cardboard"></i>
                                <?php echo e(__('lang.virtual_tour')); ?>

                            </h3>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9 rounded overflow-hidden">
                            <iframe class="embed-responsive-item" src="<?php echo e($offer->tour_url); ?>" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            
            <div class="col-lg-4 primary-sidebar sidebar-sticky" id="sidebar">
                <div class="primary-sidebar-inner">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        
                        <div class="offer-price-header mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge badge-offer" style="background: linear-gradient(135deg, #e1273d 0%, #c41f33 100%); padding: 6px 12px; font-size: 11px; border-radius: 20px;">
                                    <?php echo e(__('lang.special_offer')); ?>

                                </span>
                                <?php if($offer->offer_code): ?>
                                <span class="badge" style="background: #19868b; color: white; padding: 6px 12px; font-size: 11px; border-radius: 20px;">
                                    <i class="fas fa-barcode mr-1"></i> <?php echo e($offer->offer_code); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                            <h4 class="fs-18 text-heading font-weight-600 mb-0"><?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?></h4>
                        </div>
                        
                        
                        <?php if($offer->all_prices && $offer->all_prices->count() > 0): ?>
                        <div class="emirates-selector mb-4">
                            <h5 class="fs-14 text-heading font-weight-600 mb-3">
                                <i class="fas fa-map-marker-alt text-primary mr-2"></i><?php echo e(__('lang.select_emirate')); ?>

                            </h5>
                            <div class="emirates-grid">
                                <?php $__currentLoopData = $offer->all_prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priceItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($priceItem->emirate): ?>
                                <div class="emirate-item <?php echo e($offer->selected_price && $offer->selected_price->emirate_id == $priceItem->emirate_id ? 'active-emirate' : ''); ?>" 
                                     data-emirate-id="<?php echo e($priceItem->emirate_id); ?>"
                                     data-price="<?php echo e(number_format($priceItem->price)); ?>"
                                     data-raw-price="<?php echo e($priceItem->price); ?>"
                                     data-emirate-name="<?php echo e(app()->getLocale() == 'ar' ? $priceItem->emirate->title_arabic : $priceItem->emirate->title_english); ?>">
                                    <div class="emirate-icon-wrapper">
                                        <?php if($priceItem->emirate->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $priceItem->emirate->icon)); ?>" alt="<?php echo e(app()->getLocale() == 'ar' ? $priceItem->emirate->title_arabic : $priceItem->emirate->title_english); ?>">
                                        <?php else: ?>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php endif; ?>
                                    </div>
                                    <span class="emirate-name"><?php echo e(app()->getLocale() == 'ar' ? $priceItem->emirate->title_arabic : $priceItem->emirate->title_english); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        
                        <div class="quick-info mb-4">
                            <?php if($offer->sqft): ?>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-gray-light"><?php echo e(__('lang.sqft')); ?></span>
                                <span class="font-weight-600"><?php echo e(number_format($offer->sqft)); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if($offer->sqm): ?>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-gray-light"><?php echo e(__('lang.sqm')); ?></span>
                                <span class="font-weight-600"><?php echo e(number_format($offer->sqm)); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        
                        <div class="cta-buttons">
                            <a href="<?php echo e(route('contact')); ?>" class="btn btn-primary btn-lg btn-block mb-2">
                                <i class="fas fa-phone-alt mr-2"></i> <?php echo e(__('lang.contact_us')); ?>

                            </a>
                            <?php if($offer->plan_2d_image): ?>
                            <a href="<?php echo e(url('/storage' . $offer->plan_2d_image)); ?>" target="_blank" class="btn btn-outline-primary btn-lg btn-block mb-3">
                                <i class="fas fa-file-pdf mr-2"></i> <?php echo e(__('lang.offer_file')); ?>

                            </a>
                            <?php endif; ?>
                        </div>
                        
                        
                        <div class="pt-3 border-top mb-3">
                            <button class="btn-favourite" style="width:auto;border-radius:50px;padding:8px 20px;gap:8px;font-size:14px;"
                                    data-type="offer" data-id="<?php echo e($offer->id); ?>"
                                    data-emirate="<?php echo e($offer->selected_price->emirate_id ?? ($offer->prices->first()->emirate_id ?? '')); ?>"
                                    data-price="<?php echo e($offer->selected_price->price ?? ($offer->prices->first()->price ?? '')); ?>"
                                    title="<?php echo e(__('lang.add_to_favourites')); ?>">
                                <i class="fal fa-heart"></i> <?php echo e(__('lang.add_to_favourites')); ?>

                            </button>
                        </div>

                        
                        <?php
                            $shareTitle = app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english;
                            $shareCurrency = $offer->currency->abbreviation ?? 'AED';
                            $shareUrl = request()->url();
                            $shareImage = url('/storage' . $offer->main_image);
                        ?>
                        <div class="share-section pt-3 border-top">
                            <h6 class="fs-13 text-muted text-uppercase mb-3"><?php echo e(__('lang.share')); ?></h6>
                            <div class="d-flex justify-content-between flex-wrap">
                                <a id="shareFacebook" href="#" target="_blank" class="btn btn-sm btn-outline-primary flex-fill mr-1 mb-2" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a id="shareTwitter" href="#" target="_blank" class="btn btn-sm btn-outline-info flex-fill mr-1 mb-2" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a id="shareWhatsapp" href="#" target="_blank" class="btn btn-sm btn-outline-success flex-fill mr-1 mb-2" title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a id="shareLinkedin" href="#" target="_blank" class="btn btn-sm btn-outline-primary flex-fill mr-1 mb-2" title="LinkedIn" style="border-color: #0077b5; color: #0077b5;">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a id="sharePinterest" href="#" target="_blank" class="btn btn-sm btn-outline-danger flex-fill mr-1 mb-2" title="Pinterest" style="border-color: #e60023; color: #e60023;">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a id="shareEmail" href="#" class="btn btn-sm btn-outline-secondary flex-fill mb-2" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                        <script>
                        (function() {
                            var shareTitle = <?php echo json_encode($shareTitle, 15, 512) ?>;
                            var shareCurrency = <?php echo json_encode($shareCurrency, 15, 512) ?>;
                            var shareUrl = <?php echo json_encode($shareUrl, 15, 512) ?>;
                            var shareImage = <?php echo json_encode($shareImage, 15, 512) ?>;
                            var currentPrice = '';
                            var currentEmirate = '';

                            <?php if($offer->selected_price): ?>
                                currentPrice = '<?php echo e(number_format($offer->selected_price->price)); ?>';
                                currentEmirate = '<?php echo e($offer->selected_price->emirate ? (app()->getLocale() == "ar" ? $offer->selected_price->emirate->title_arabic : $offer->selected_price->emirate->title_english) : ""); ?>';
                            <?php endif; ?>

                            function buildShareText() {
                                var text = shareTitle;
                                if (currentPrice) text += ' - ' + shareCurrency + ' ' + currentPrice;
                                if (currentEmirate) text += ' (' + currentEmirate + ')';
                                return text;
                            }

                            function updateShareLinks() {
                                var text = buildShareText();
                                var enc = encodeURIComponent;
                                document.getElementById('shareFacebook').href = 'https://www.facebook.com/sharer/sharer.php?u=' + enc(shareUrl) + '&quote=' + enc(text);
                                document.getElementById('shareTwitter').href = 'https://twitter.com/intent/tweet?url=' + enc(shareUrl) + '&text=' + enc(text);
                                document.getElementById('shareWhatsapp').href = 'https://wa.me/?text=' + enc(text + '\n' + shareUrl);
                                document.getElementById('shareLinkedin').href = 'https://www.linkedin.com/shareArticle?mini=true&url=' + enc(shareUrl) + '&title=' + enc(shareTitle) + '&summary=' + enc(text);
                                document.getElementById('sharePinterest').href = 'https://pinterest.com/pin/create/button/?url=' + enc(shareUrl) + '&media=' + enc(shareImage) + '&description=' + enc(text);
                                document.getElementById('shareEmail').href = 'mailto:?subject=' + enc(shareTitle) + '&body=' + enc(text + '\n\n' + shareUrl);
                            }

                            updateShareLinks();

                            window.updateSharePrice = function(price, emirateName) {
                                currentPrice = price;
                                currentEmirate = emirateName;
                                updateShareLinks();
                            };
                        })();
                        </script>
                    </div>
                </div>
                
                
                <?php
                    $showOfferScheduleTour = env('OFFERS_SCHEDULE_TOUR', false);
                    $showOfferRequestInfo = env('OFFERS_REQUEST_INFO', false);
                    $showOfferForms = $showOfferScheduleTour || $showOfferRequestInfo;
                ?>
                <?php if($showOfferForms): ?>
                <div class="card border-0 shadow-sm widget-request-tour">
                    <?php if($showOfferScheduleTour && $showOfferRequestInfo): ?>
                    
                    <ul class="nav nav-tabs d-flex" role="tablist">
                        <li class="nav-item flex-fill">
                            <a class="nav-link active text-center px-3 py-3" data-toggle="tab" href="#schedule-tour" role="tab" aria-selected="true">
                                <i class="fas fa-calendar-alt mr-2"></i><?php echo e(__('lang.schedule_a_tour')); ?>

                            </a>
                        </li>
                        <li class="nav-item flex-fill">
                            <a class="nav-link text-center px-3 py-3" data-toggle="tab" href="#request-info" role="tab" aria-selected="false">
                                <i class="fas fa-info-circle mr-2"></i><?php echo e(__('lang.request_info')); ?>

                            </a>
                        </li>
                    </ul>
                    <?php elseif($showOfferScheduleTour): ?>
                    
                    <div class="card-header bg-primary text-white text-center py-3">
                        <i class="fas fa-calendar-alt mr-2"></i><?php echo e(__('lang.schedule_a_tour')); ?>

                    </div>
                    <?php else: ?>
                    
                    <div class="card-header bg-primary text-white text-center py-3">
                        <i class="fas fa-info-circle mr-2"></i><?php echo e(__('lang.request_info')); ?>

                    </div>
                    <?php endif; ?>
                    <div class="card-body px-4 shadow-xxs-2 pb-4 pt-0">
                        <form id="tourRequestForm">
                            <div class="tab-content pt-1 pb-0 px-0 shadow-none">
                                <?php if($showOfferScheduleTour): ?>
                                
                                <div class="tab-pane fade <?php echo e($showOfferScheduleTour ? 'show active' : ''); ?>" id="schedule-tour" role="tabpanel">
                                    
                                    <div class="calendar-slider-wrapper mt-4 mb-3">
                                        <button type="button" class="calendar-nav calendar-prev" id="calendarPrev">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <div class="slick-slider calendar-slider" id="calendarSlider"
                                             data-slick-options='{"slidesToShow": 5, "autoplay":false, "dots":false, "arrows":false, "infinite":false, "responsive":[{"breakpoint": 400,"settings": {"slidesToShow":3}},{"breakpoint": 576,"settings": {"slidesToShow":4}}]}'>
                                            <?php
                                                $today = \Carbon\Carbon::now();
                                            ?>
                                            <?php for($i = 0; $i < 14; $i++): ?>
                                            <?php
                                                $date = $today->copy()->addDays($i);
                                            ?>
                                            <div class="box px-1 py-2">
                                                <div class="calendar-day text-center px-2 py-3 rounded <?php echo e($i === 0 ? 'active' : ''); ?>" 
                                                     data-date="<?php echo e($date->format('Y-m-d')); ?>"
                                                     style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                                                    <span class="d-block fs-12 text-muted text-uppercase"><?php echo e($date->format('D')); ?></span>
                                                    <span class="d-block fs-20 font-weight-600 text-heading"><?php echo e($date->format('d')); ?></span>
                                                    <span class="d-block fs-11 text-muted"><?php echo e($date->format('M')); ?></span>
                                                </div>
                                            </div>
                                            <?php endfor; ?>
                                        </div>
                                        <button type="button" class="calendar-nav calendar-next" id="calendarNext">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" id="selectedDate" name="date" value="<?php echo e($today->format('Y-m-d')); ?>">
                                    
                                    <div class="form-group mb-3">
                                        <label class="fs-13 text-muted mb-1"><?php echo e(__('lang.preferred_time')); ?></label>
                                        <select class="form-control form-control-lg border-0 bg-gray-01" name="time">
                                            <option value=""><?php echo e(__('lang.select_time')); ?></option>
                                            <option value="09:00">09:00 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="13:00">01:00 PM</option>
                                            <option value="14:00">02:00 PM</option>
                                            <option value="15:00">03:00 PM</option>
                                            <option value="16:00">04:00 PM</option>
                                            <option value="17:00">05:00 PM</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg border-0 bg-gray-01" name="name" placeholder="<?php echo e(__('lang.full_name')); ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control form-control-lg border-0 bg-gray-01" name="email" placeholder="<?php echo e(__('lang.email_address')); ?>">
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="tel" class="form-control form-control-lg border-0 bg-gray-01" name="phone" placeholder="<?php echo e(__('lang.phone_number')); ?>">
                                    </div>
                                    <button type="button" class="btn btn-primary btn-lg btn-block rounded">
                                        <i class="fas fa-calendar-check mr-2"></i><?php echo e(__('lang.schedule_a_tour')); ?>

                                    </button>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($showOfferRequestInfo): ?>
                                
                                <div class="tab-pane fade <?php echo e(!$showOfferScheduleTour ? 'show active' : ''); ?> pt-4" id="request-info" role="tabpanel">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg border-0 bg-gray-01" name="info_name" placeholder="<?php echo e(__('lang.full_name')); ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control form-control-lg border-0 bg-gray-01" name="info_email" placeholder="<?php echo e(__('lang.email_address')); ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="tel" class="form-control form-control-lg border-0 bg-gray-01" name="info_phone" placeholder="<?php echo e(__('lang.phone_number')); ?>">
                                    </div>
                                    <div class="form-group mb-4">
                                        <textarea class="form-control border-0 bg-gray-01" name="message" rows="4" placeholder="<?php echo e(__('lang.interested_message')); ?>"><?php echo e(__('lang.interested_in_offer', ['offer' => app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english])); ?></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-lg btn-block rounded">
                                        <i class="fas fa-paper-plane mr-2"></i><?php echo e(__('lang.request_info')); ?>

                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                
                <?php echo $__env->make('pages.offers.partials.contact-card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/offer-show.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
// Price Update Function - Updates price tag on gallery image
function updateGalleryPrice(price, emirateName) {
    var galleryPriceAmount = document.getElementById('galleryPriceAmount');
    var galleryEmirateName = document.getElementById('galleryEmirateName');
    
    if (galleryPriceAmount) {
        galleryPriceAmount.textContent = price;
    }
    if (galleryEmirateName) {
        galleryEmirateName.textContent = emirateName;
    }
}

// Gallery Slideshow
document.addEventListener('DOMContentLoaded', function() {
    // Emirates Items Click - Update price tag on image
    var emirateItems = document.querySelectorAll('.emirate-item');
    
    emirateItems.forEach(function(item) {
        item.addEventListener('click', function() {
            var price = this.getAttribute('data-price');
            var emirateName = this.getAttribute('data-emirate-name');
            var emirateId = this.getAttribute('data-emirate-id');
            
            // Update gallery price tag
            updateGalleryPrice(price, emirateName);
            
            // Update share links with selected emirate price
            if (typeof updateSharePrice === 'function') {
                updateSharePrice(price, emirateName);
            }
            
            // Update active state in emirates grid
            emirateItems.forEach(function(el) {
                el.classList.remove('active-emirate');
            });
            this.classList.add('active-emirate');

            // Update favourite button with selected emirate and price
            var favBtn = document.querySelector('.btn-favourite[data-type="offer"]');
            if (favBtn) {
                favBtn.setAttribute('data-emirate', emirateId);
                favBtn.setAttribute('data-price', this.getAttribute('data-raw-price') || '');
            }
            
            // Update Feasibility Studies section based on selected emirate
            updateFeasibilityStudies(emirateId, emirateName);
        });
    });
    
    // Function to update Feasibility Studies section
    function updateFeasibilityStudies(emirateId, emirateName) {
        var fsSection = document.getElementById('feasibilityStudiesSection');
        var fsStudies = document.querySelectorAll('.feasibility-study-item');
        var fsBadge = document.getElementById('fsEmirateNameDisplay');
        var noStudiesMsg = document.getElementById('noFeasibilityStudiesMsg');
        
        if (!fsSection) return;
        
        var hasVisibleStudies = false;
        
        // Show/hide studies based on emirate
        fsStudies.forEach(function(study) {
            var studyEmirateId = study.getAttribute('data-emirate-id');
            if (studyEmirateId == emirateId) {
                study.style.display = '';
                hasVisibleStudies = true;
            } else {
                study.style.display = 'none';
                // Collapse hidden studies
                var collapseEl = study.querySelector('.collapse');
                if (collapseEl) {
                    $(collapseEl).collapse('hide');
                }
            }
        });
        
        // Update emirate badge
        if (fsBadge) {
            fsBadge.textContent = emirateName;
        }
        
        // Show/hide the entire section based on whether there are matching studies
        if (hasVisibleStudies) {
            fsSection.style.display = '';
            if (noStudiesMsg) noStudiesMsg.style.display = 'none';
        } else {
            // Hide entire section if no studies for this emirate
            fsSection.style.display = 'none';
        }
    }
    
    // Gallery Slideshow
    var thumbnails = document.querySelectorAll('.thumbnail-item');
    var mainSlides = document.querySelectorAll('.main-slide');
    var currentSlide = 0;
    var totalSlides = mainSlides.length;
    
    // Show first slide
    if (mainSlides.length > 0) {
        mainSlides[0].classList.add('active');
    }
    
    // Function to go to specific slide
    function goToSlide(index) {
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;
        
        // Update main slides
        mainSlides.forEach(function(slide, i) {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });
        
        // Update thumbnails
        thumbnails.forEach(function(thumb, i) {
            thumb.classList.remove('active');
            if (i === index) {
                thumb.classList.add('active');
                // Scroll thumbnail into view
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
        
        currentSlide = index;
    }
    
    // Thumbnail click handlers
    thumbnails.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            var index = parseInt(this.getAttribute('data-index'));
            goToSlide(index);
        });
    });
    
    // Main slider navigation
    var sliderPrev = document.getElementById('sliderPrev');
    var sliderNext = document.getElementById('sliderNext');
    
    if (sliderPrev) {
        sliderPrev.addEventListener('click', function() {
            goToSlide(currentSlide - 1);
        });
    }
    
    if (sliderNext) {
        sliderNext.addEventListener('click', function() {
            goToSlide(currentSlide + 1);
        });
    }
    
    // Thumbnail navigation
    var thumbPrev = document.getElementById('thumbPrev');
    var thumbNext = document.getElementById('thumbNext');
    var thumbnailsSlider = document.getElementById('offerThumbnails');
    
    if (thumbPrev && thumbnailsSlider) {
        thumbPrev.addEventListener('click', function() {
            thumbnailsSlider.scrollBy({ top: -100, behavior: 'smooth' });
        });
    }
    
    if (thumbNext && thumbnailsSlider) {
        thumbNext.addEventListener('click', function() {
            thumbnailsSlider.scrollBy({ top: 100, behavior: 'smooth' });
        });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            goToSlide(currentSlide - 1);
        } else if (e.key === 'ArrowRight') {
            goToSlide(currentSlide + 1);
        }
    });
    
    // Initialize Magnific Popup for offer gallery
    if (typeof $.fn.magnificPopup !== 'undefined') {
        var $galleryItems = $('.offer-gallery-item');
        if ($galleryItems.length > 0) {
            var galleryImages = [];
            $galleryItems.each(function() {
                galleryImages.push({
                    src: $(this).attr('href')
                });
            });
            
            $galleryItems.magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                items: galleryImages,
                closeOnBgClick: true,
                closeBtnInside: false,
                mainClass: 'mfp-zoom-in',
                midClick: true,
                removalDelay: 300,
                callbacks: {
                    beforeOpen: function() {
                        var index = $galleryItems.index(this.st.el);
                        if (index !== -1) {
                            this.goTo(index);
                        }
                    }
                }
            });
        }
    }
    
    // Calendar Day Selection for Tour Form
    var calendarDays = document.querySelectorAll('.calendar-day');
    var selectedDateInput = document.getElementById('selectedDate');
    
    calendarDays.forEach(function(day) {
        day.addEventListener('click', function() {
            // Remove active class from all days
            calendarDays.forEach(function(d) {
                d.classList.remove('active');
            });
            
            // Add active class to clicked day
            this.classList.add('active');
            
            // Update hidden input with selected date
            if (selectedDateInput) {
                selectedDateInput.value = this.getAttribute('data-date');
            }
        });
    });
    
    // Initialize Calendar Slider with Custom Navigation
    if (typeof $.fn.slick !== 'undefined') {
        var $calendarSlider = $('#calendarSlider');
        
        if ($calendarSlider.length && !$calendarSlider.hasClass('slick-initialized')) {
            $calendarSlider.slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: false,
                dots: false,
                arrows: false,
                infinite: false,
                responsive: [
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 4
                        }
                    }
                ]
            });
            
            // Custom navigation buttons
            $('#calendarPrev').on('click', function() {
                $calendarSlider.slick('slickPrev');
            });
            
            $('#calendarNext').on('click', function() {
                $calendarSlider.slick('slickNext');
            });
        }
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/offers/show.blade.php ENDPATH**/ ?>