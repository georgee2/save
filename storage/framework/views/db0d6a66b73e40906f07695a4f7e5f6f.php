
<?php if(($aboutInfo->mission_english || $aboutInfo->mission_arabic) || ($aboutInfo->vision_english || $aboutInfo->vision_arabic) || ($aboutInfo->values_english || $aboutInfo->values_arabic)): ?>
<section class="mvv-section-v2">
    <div class="container">
        
        <div class="mvv-section-header text-center" data-animate="fadeInUp">
            <span class="mvv-label"><?php echo e(__('lang.our_foundation')); ?></span>
            <h2 class="mvv-heading"><?php echo e(__('lang.mission_vision_values')); ?></h2>
            <div class="mvv-heading-line"></div>
        </div>
        
        
        <div class="mvv-items-wrapper">
            
            <?php if($aboutInfo->mission_english || $aboutInfo->mission_arabic): ?>
            <div class="mvv-item" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    <?php if($aboutInfo->mission_image): ?>
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="<?php echo e(asset('storage' . $aboutInfo->mission_image)); ?>" alt="<?php echo e(__('lang.mission')); ?>">
                            <div class="mvv-image-badge">
                                <i class="fas fa-bullseye"></i>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="mvv-item-content <?php echo e(!$aboutInfo->mission_image ? 'mvv-full-width' : ''); ?>">
                        <div class="mvv-item-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="mvv-item-title"><?php echo e(__('lang.our_mission')); ?></h3>
                        <div class="mvv-item-text">
                            <?php echo nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->mission_arabic : $aboutInfo->mission_english)); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            
            <?php if($aboutInfo->vision_english || $aboutInfo->vision_arabic): ?>
            <div class="mvv-item mvv-item-reverse" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    <?php if($aboutInfo->vision_image): ?>
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="<?php echo e(asset('storage' . $aboutInfo->vision_image)); ?>" alt="<?php echo e(__('lang.vision')); ?>">
                            <div class="mvv-image-badge mvv-badge-vision">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="mvv-item-content <?php echo e(!$aboutInfo->vision_image ? 'mvv-full-width' : ''); ?>">
                        <div class="mvv-item-icon mvv-icon-vision">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="mvv-item-title"><?php echo e(__('lang.our_vision')); ?></h3>
                        <div class="mvv-item-text">
                            <?php echo nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->vision_arabic : $aboutInfo->vision_english)); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            
            <?php if($aboutInfo->values_english || $aboutInfo->values_arabic): ?>
            <div class="mvv-item" data-animate="fadeInUp">
                <div class="mvv-item-row">
                    <?php if($aboutInfo->values_image): ?>
                    <div class="mvv-item-image">
                        <div class="mvv-image-container">
                            <img src="<?php echo e(asset('storage' . $aboutInfo->values_image)); ?>" alt="<?php echo e(__('lang.values')); ?>">
                            <div class="mvv-image-badge mvv-badge-values">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="mvv-item-content <?php echo e(!$aboutInfo->values_image ? 'mvv-full-width' : ''); ?>">
                        <div class="mvv-item-icon mvv-icon-values">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="mvv-item-title"><?php echo e(__('lang.our_values')); ?></h3>
                        <div class="mvv-item-text">
                            <?php echo nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->values_arabic : $aboutInfo->values_english)); ?>

                        </div>
                        <?php
                            $valuesPoints = app()->getLocale() == 'ar' ? $aboutInfo->values_points_arabic : $aboutInfo->values_points_english;
                        ?>
                        <?php if($valuesPoints): ?>
                        <ul class="mvv-values-points">
                            <?php $__currentLoopData = explode(', ', $valuesPoints); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(trim($point)): ?>
                                <li><i class="fas fa-check-circle"></i> <?php echo e(trim($point)); ?></li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/mission-vision-values.blade.php ENDPATH**/ ?>