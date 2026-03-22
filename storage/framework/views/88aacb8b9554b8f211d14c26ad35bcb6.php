<?php if($offer->floors && $offer->floors->count() > 0): ?>
<?php
    // Group floors by building component
    $floorsByBuilding = $offer->floors->groupBy(function($floor) {
        return $floor->buildingComponent ? $floor->buildingComponent->id : 0;
    });
    
    $buildingIndex = 0;
?>
<div class="card border-0 shadow-sm mb-6">
    <div class="card-body p-4">
        <div class="section-header">
            <h3 class="fs-20 text-heading font-weight-600">
                <i class="fas fa-layer-group"></i>
                <?php echo e(__('lang.floor_plans')); ?>

            </h3>
        </div>
        
        <?php $__currentLoopData = $floorsByBuilding; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buildingId => $floors): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $buildingComponent = $floors->first()->buildingComponent;
            $buildingIndex++;
            $floorIndex = 0;
        ?>
        
        
        <div class="building-component-section mb-5">
            
            <div class="building-header d-flex align-items-center mb-4 p-4 rounded-lg" 
                 style="background: linear-gradient(135deg, rgba(25, 134, 139, 0.08) 0%, rgba(25, 134, 139, 0.03) 100%); border-left: 4px solid #19868b;">
                <div class="building-icon mr-3 d-flex align-items-center justify-content-center rounded-circle" 
                     style="width: 50px; height: 50px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                    <?php if($buildingComponent && $buildingComponent->icon): ?>
                    <img src="<?php echo e(url('/storage' . $buildingComponent->icon)); ?>" 
                         alt="" 
                         style="width: 28px; height: 28px; object-fit: contain; filter: brightness(0) invert(1);">
                    <?php else: ?>
                    <i class="fal fa-building text-white fs-22"></i>
                    <?php endif; ?>
                </div>
                <div>
                    <h5 class="mb-0 fs-18 text-heading font-weight-600">
                        <?php if($buildingComponent): ?>
                            <?php echo e(app()->getLocale() == 'ar' ? $buildingComponent->name_arabic : $buildingComponent->name_english); ?>

                        <?php else: ?>
                            <?php echo e(__('lang.other_areas')); ?>

                        <?php endif; ?>
                    </h5>
                    <p class="mb-0 fs-13 text-muted">
                        <?php echo e($floors->count()); ?> <?php echo e($floors->count() == 1 ? __('lang.floor') : __('lang.floors')); ?>

                        <?php
                            $totalSqft = $floors->sum('sqft');
                            $totalSqm = $floors->sum('sqm');
                        ?>
                        <?php if($totalSqft > 0): ?>
                            <span class="mx-2">•</span>
                            <?php echo e(number_format($totalSqft)); ?> <?php echo e(__('lang.sqft')); ?>

                        <?php endif; ?>
                        <?php if($totalSqm > 0): ?>
                            <span class="mx-2">•</span>
                            <?php echo e(number_format($totalSqm, 2)); ?> <?php echo e(__('lang.sqm')); ?>

                        <?php endif; ?>
                    </p>
                </div>
            </div>
            
            
            <?php $__currentLoopData = $floors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $floorIndex++;
                $isFirstFloor = ($buildingIndex === 1 && $floorIndex === 1);
            ?>
            <div class="accordion accordion-03 mb-3 ml-md-4" id="accordion-floor-<?php echo e($floor->id); ?>">
                <div class="card border-0 shadow-xxs-5 bg-gray-01">
                    <div class="card-header bg-gray-01 border-gray border-0 p-0" id="floor-plans-<?php echo e($floor->id); ?>">
                        <div class="heading bg-gray-01 d-flex justify-content-between align-items-center px-6"
                             data-toggle="collapse" data-target="#collapse-floor-<?php echo e($floor->id); ?>" 
                             aria-expanded="<?php echo e($isFirstFloor ? 'true' : 'false'); ?>"
                             aria-controls="collapse-floor-<?php echo e($floor->id); ?>" role="button">
                            <h2 class="mb-0 fs-16 text-heading font-weight-500 py-4 lh-13">
                                <?php if($floor->floorComponent): ?>
                                    <?php if($floor->floorComponent->icon): ?>
                                    <img src="<?php echo e(url('/storage' . $floor->floorComponent->icon)); ?>" 
                                         alt="" 
                                         class="mr-2"
                                         style="width: 22px; height: 22px; object-fit: contain;">
                                    <?php else: ?>
                                    <i class="fal fa-layer-group text-primary mr-2"></i>
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? $floor->floorComponent->name_arabic : $floor->floorComponent->name_english); ?>

                                <?php else: ?>
                                    <?php echo e(__('lang.floor')); ?> <?php echo e($floorIndex); ?>

                                <?php endif; ?>
                            </h2>
                            <ul class="list-inline mb-0 d-none d-sm-block pr-2">
                                <?php if($floor->count): ?>
                                <li class="list-inline-item text-muted mr-4">
                                    <i class="fal fa-copy mr-1 fs-13"></i>
                                    <?php echo e(__('lang.count')); ?>: <span class="font-weight-500 text-heading"><?php echo e($floor->count); ?></span>
                                </li>
                                <?php endif; ?>
                                <?php if($floor->sqft): ?>
                                <li class="list-inline-item text-muted mr-4"><?php echo e(__('lang.sqft')); ?>: <span class="font-weight-500 text-heading"><?php echo e(number_format($floor->sqft)); ?></span></li>
                                <?php endif; ?>
                                <?php if($floor->sqm): ?>
                                <li class="list-inline-item text-muted"><?php echo e(__('lang.sqm')); ?>: <span class="font-weight-500 text-heading"><?php echo e(number_format($floor->sqm, 2)); ?></span></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div id="collapse-floor-<?php echo e($floor->id); ?>"
                         class="collapse <?php echo e($isFirstFloor ? 'show' : ''); ?> mx-6 mb-6 bg-white rounded-lg"
                         aria-labelledby="floor-plans-<?php echo e($floor->id); ?>"
                         data-parent="#accordion-floor-<?php echo e($floor->id); ?>">
                        <div class="card-body p-4">
                            
                            
                            <?php if($floor->image_2d || $floor->image_3d): ?>
                            <div class="row mb-4 galleries justify-content-center">
                                <?php if($floor->image_2d): ?>
                                <div class="<?php echo e($floor->image_3d ? 'col-md-6' : 'col-md-8 col-lg-6'); ?> mb-3 mb-md-0">
                                    <div class="position-relative">
                                        <a href="<?php echo e(url('/storage' . $floor->image_2d)); ?>" data-gtf-mfp="true" data-gallery-id="floor-<?php echo e($floor->id); ?>">
                                            <img src="<?php echo e(url('/storage' . $floor->image_2d)); ?>" class="rounded-lg w-100" alt="<?php echo e(__('lang.2d_floor_plan')); ?>" style="object-fit: contain;">
                                        </a>
                                        <span class="position-absolute bg-dark text-white px-3 py-1 rounded fs-13" style="bottom: 10px; left: 10px;">
                                            <i class="fal fa-drafting-compass mr-1"></i> <?php echo e(__('lang.2d_floor_plan')); ?>

                                        </span>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($floor->image_3d): ?>
                                <div class="<?php echo e($floor->image_2d ? 'col-md-6' : 'col-md-8 col-lg-6'); ?>">
                                    <div class="position-relative">
                                        <a href="<?php echo e(url('/storage' . $floor->image_3d)); ?>" data-gtf-mfp="true" data-gallery-id="floor-<?php echo e($floor->id); ?>">
                                            <img src="<?php echo e(url('/storage' . $floor->image_3d)); ?>" class="rounded-lg w-100" alt="<?php echo e(__('lang.3d_visualization')); ?>" style="object-fit: contain;">
                                        </a>
                                        <span class="position-absolute bg-primary text-white px-3 py-1 rounded fs-13" style="bottom: 10px; left: 10px;">
                                            <i class="fal fa-cube mr-1"></i> <?php echo e(__('lang.3d_visualization')); ?>

                                        </span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="fs-15 text-heading mb-3"><i class="fal fa-info-circle text-primary mr-2"></i><?php echo e(__('lang.floor_information')); ?></h6>
                                    <div class="row">
                                        <?php if($floor->floorComponent): ?>
                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <?php if($floor->floorComponent->icon): ?>
                                                    <img src="<?php echo e(url('/storage' . $floor->floorComponent->icon)); ?>" alt="" style="width: 22px; height: 22px; object-fit: contain;">
                                                    <?php else: ?>
                                                    <i class="fal fa-layer-group text-primary fs-18"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12"><?php echo e(__('lang.floor_type')); ?></span>
                                                    <p class="mb-0 fs-14 font-weight-500 text-heading"><?php echo e(app()->getLocale() == 'ar' ? $floor->floorComponent->name_arabic : $floor->floorComponent->name_english); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if($floor->count): ?>
                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fal fa-copy text-primary fs-18"></i>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12"><?php echo e(__('lang.count')); ?></span>
                                                    <p class="mb-0 fs-14 font-weight-500 text-heading"><?php echo e($floor->count); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if($floor->sqft): ?>
                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fal fa-ruler-combined text-primary fs-18"></i>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12"><?php echo e(__('lang.area')); ?> (<?php echo e(__('lang.sqft')); ?>)</span>
                                                    <p class="mb-0 fs-14 font-weight-500 text-heading"><?php echo e(number_format($floor->sqft)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if($floor->sqm): ?>
                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fal fa-vector-square text-primary fs-18"></i>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12"><?php echo e(__('lang.area')); ?> (<?php echo e(__('lang.sqm')); ?>)</span>
                                                    <p class="mb-0 fs-14 font-weight-500 text-heading"><?php echo e(number_format($floor->sqm, 2)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <?php if($floor->specifications && $floor->specifications->count() > 0): ?>
                            <div class="mb-4">
                                <h6 class="fs-15 text-heading mb-3"><i class="fal fa-list-alt text-primary mr-2"></i><?php echo e(__('lang.floor_specifications')); ?></h6>
                                <div class="row">
                                    <?php $__currentLoopData = $floor->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($spec->specification): ?>
                                    <div class="col-sm-6 mb-3">
                                        <div class="d-flex align-items-start bg-gray-01 rounded p-3">
                                            <div class="mr-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                                <?php if($spec->specification->icon): ?>
                                                <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                                                     alt="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>"
                                                     style="width: 32px; height: 32px; object-fit: contain;">
                                                <?php else: ?>
                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" 
                                                      style="width: 32px; height: 32px; font-size: 12px; font-weight: 600;">
                                                    <?php echo e(mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1)); ?>

                                                </span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <span class="text-muted fs-13 d-block"><?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?></span>
                                                <span class="fs-14 font-weight-500 text-heading d-block"><?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            
                            <?php if($floor->amenities && $floor->amenities->count() > 0): ?>
                            <div>
                                <h6 class="fs-15 text-heading mb-3"><i class="fal fa-sparkles text-primary mr-2"></i><?php echo e(__('lang.floor_amenities')); ?></h6>
                                <div class="d-flex flex-wrap">
                                    <?php $__currentLoopData = $floor->amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($amenity->amenity): ?>
                                    <div class="d-flex align-items-center bg-gray-01 rounded px-3 py-2 mr-2 mb-2">
                                        <?php if($amenity->amenity->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $amenity->amenity->icon)); ?>" 
                                             alt="<?php echo e(app()->getLocale() == 'ar' ? $amenity->amenity->name_arabic : $amenity->amenity->name_english); ?>"
                                             class="mr-2"
                                             style="width: 20px; height: 20px; object-fit: contain;">
                                        <?php else: ?>
                                        <i class="fal fa-check-circle text-primary mr-2 fs-14"></i>
                                        <?php endif; ?>
                                        <span class="fs-13 text-heading"><?php echo e(app()->getLocale() == 'ar' ? $amenity->amenity->name_arabic : $amenity->amenity->name_english); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
    </div>
</div>

<style>
/* Building Component Section Styles */
.building-component-section {
    position: relative;
}

.building-header {
    transition: all 0.3s ease;
}

.building-header:hover {
    box-shadow: 0 4px 15px rgba(25, 134, 139, 0.15);
}

.building-icon {
    box-shadow: 0 4px 10px rgba(25, 134, 139, 0.3);
    transition: transform 0.3s ease;
}

.building-header:hover .building-icon {
    transform: scale(1.05);
}

/* RTL Support */
[dir="rtl"] .building-header {
    border-left: none;
    border-right: 4px solid #19868b;
}

[dir="rtl"] .building-icon {
    margin-right: 0;
    margin-left: 1rem;
}

[dir="rtl"] .ml-md-4 {
    margin-left: 0 !important;
    margin-right: 1.5rem !important;
}

/* Accordion Styles */
.accordion-03 .heading {
    transition: background-color 0.2s ease;
}

.accordion-03 .heading:hover {
    background-color: #f8fafc !important;
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .building-header {
        flex-direction: column;
        text-align: center;
    }
    
    .building-icon {
        margin-right: 0;
        margin-bottom: 0.75rem;
    }
    
    [dir="rtl"] .building-icon {
        margin-left: 0;
    }
    
    .ml-md-4 {
        margin-left: 0 !important;
    }
    
    [dir="rtl"] .ml-md-4 {
        margin-right: 0 !important;
    }
}
</style>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/offers/partials/floors.blade.php ENDPATH**/ ?>