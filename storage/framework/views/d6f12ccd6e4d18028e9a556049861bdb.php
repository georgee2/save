
<?php if($branches && $branches->count() > 0): ?>
<section class="contact-branches-section py-12">
    <div class="container">
        
        <div class="text-center mb-10" data-animate="fadeInUp">
            <div class="branches-section-badge">
                <i class="fas fa-building"></i>
                <span><?php echo e(__('lang.locations')); ?></span>
            </div>
            <h2 class="branches-section-title"><?php echo e(__('lang.our_branches')); ?></h2>
            <p class="branches-section-subtitle"><?php echo e(__('lang.branches_section_subtitle')); ?></p>
        </div>
        
        
        <div class="branches-grid">
            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="branch-card" data-animate="fadeInUp" data-delay="<?php echo e($index * 100); ?>">
                
                <div class="branch-header">
                    <div class="branch-logo-wrapper">
                        <?php if($branch->logo_english && app()->getLocale() == 'en'): ?>
                        <img src="<?php echo e(asset('storage' . $branch->logo_english)); ?>" 
                             alt="<?php echo e($branch->name_english); ?>" 
                             class="branch-logo">
                        <?php elseif($branch->logo_arabic && app()->getLocale() == 'ar'): ?>
                        <img src="<?php echo e(asset('storage' . $branch->logo_arabic)); ?>" 
                             alt="<?php echo e($branch->name_arabic); ?>" 
                             class="branch-logo">
                        <?php elseif($branch->logo_english): ?>
                        <img src="<?php echo e(asset('storage' . $branch->logo_english)); ?>" 
                             alt="<?php echo e($branch->name_english); ?>" 
                             class="branch-logo">
                        <?php else: ?>
                        <div class="branch-logo-placeholder">
                            <i class="fas fa-building"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="branch-number"><?php echo e(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?></div>
                </div>
                
                
                <div class="branch-content">
                    <h3 class="branch-name">
                        <?php echo e(app()->getLocale() == 'ar' ? $branch->name_arabic : $branch->name_english); ?>

                    </h3>
                    
                    
                    <?php if(($branch->location_text_english && app()->getLocale() == 'en') || ($branch->location_text_arabic && app()->getLocale() == 'ar')): ?>
                    <div class="branch-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo e(app()->getLocale() == 'ar' ? $branch->location_text_arabic : $branch->location_text_english); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if($branch->opening_hours): ?>
                    <div class="branch-hours">
                        <i class="fas fa-clock"></i>
                        <span><?php echo e($branch->opening_hours); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if($branch->map_url): ?>
                    <div class="branch-actions">
                        <a href="<?php echo e($branch->map_url); ?>" target="_blank" class="btn-branch btn-directions">
                            <i class="fas fa-directions"></i>
                            <span><?php echo e(__('lang.get_directions')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                
                <?php if($branch->map_url): ?>
                <div class="branch-map-preview">
                    <?php if(strpos($branch->map_url, '<iframe') !== false): ?>
                        <?php echo $branch->map_url; ?>

                    <?php else: ?>
                        <iframe src="<?php echo e($branch->map_url); ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="text-center mt-8">
            <a href="<?php echo e(route('branches.index')); ?>" class="btn btn-view-branches">
                <i class="fas fa-building <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>"></i>
                <?php echo e(__('lang.view_all_branches')); ?>

            </a>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/contact/partials/branches.blade.php ENDPATH**/ ?>