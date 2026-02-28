
<?php if($customBlocks && count($customBlocks) > 0): ?>
<section class="custom-blocks-section">
    <div class="container">
        
        <div class="blocks-section-header text-center" data-animate="fadeInUp">
            <span class="blocks-section-label"><?php echo e(__('lang.discover_more')); ?></span>
            <h2 class="blocks-section-title"><?php echo e(__('lang.more_about_us')); ?></h2>
            <div class="blocks-section-line"></div>
        </div>
        
        
        <div class="blocks-container">
            <?php $__currentLoopData = $customBlocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="custom-block <?php echo e($loop->even ? 'custom-block-reverse' : ''); ?>" data-animate="fadeInUp">
                <div class="custom-block-wrapper">
                    
                    <?php if($block->image): ?>
                    <div class="custom-block-image">
                        <div class="block-img-frame">
                            <img src="<?php echo e(asset('storage' . $block->image)); ?>" 
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english); ?>">
                            <div class="block-img-overlay"></div>
                        </div>
                        <div class="block-img-number"><?php echo e(str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)); ?></div>
                    </div>
                    <?php endif; ?>
                    
                    
                    <div class="custom-block-content <?php echo e(!$block->image ? 'custom-block-full' : ''); ?>">
                        <div class="block-content-box">
                            <span class="block-step-label"><?php echo e(__('lang.step')); ?> <?php echo e(str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)); ?></span>
                            <h3 class="block-content-title">
                                <?php echo e(app()->getLocale() == 'ar' ? $block->title_arabic : $block->title_english); ?>

                            </h3>
                            <div class="block-content-desc">
                                <?php echo nl2br(e(app()->getLocale() == 'ar' ? $block->description_arabic : $block->description_english)); ?>

                            </div>
                            <div class="block-content-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/custom-blocks.blade.php ENDPATH**/ ?>