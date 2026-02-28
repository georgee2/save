
<?php if($features && count($features) > 0): ?>
<section class="features-section-modern">
    
    <div class="features-bg-wrapper">
        <div class="features-bg-gradient"></div>
        <div class="features-bg-pattern"></div>
        <div class="features-bg-glow features-glow-1"></div>
        <div class="features-bg-glow features-glow-2"></div>
    </div>
    
    <div class="container position-relative">
        
        <div class="features-header" data-animate="fadeInUp">
            <div class="features-badge">
                <span class="badge-dot"></span>
                <span class="badge-text"><?php echo e(__('lang.what_we_offer')); ?></span>
            </div>
            <h2 class="features-title">
                <?php echo e(__('lang.our_features')); ?>

                <span class="title-decoration">
                    <svg viewBox="0 0 200 20" preserveAspectRatio="none">
                        <path d="M0,10 Q50,0 100,10 T200,10" fill="none" stroke="currentColor" stroke-width="3"/>
                    </svg>
                </span>
            </h2>
            <p class="features-subtitle"><?php echo e(__('lang.features_subtitle') ?? 'Discover what makes us stand out from the rest'); ?></p>
        </div>
        
        
        <div class="features-grid-modern">
            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="feature-card-modern" data-animate="fadeInUp" data-delay="<?php echo e($loop->index * 100); ?>">
                
                <div class="feature-card-glow"></div>
                
                
                <div class="feature-card-inner">
                    
                    <div class="feature-number"><?php echo e(str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)); ?></div>
                    
                    
                    <div class="feature-icon-modern">
                        <div class="icon-bg">
                            <div class="icon-bg-inner"></div>
                        </div>
                        <div class="icon-content">
                            <?php if($feature->icon): ?>
                            <img src="<?php echo e(asset('storage' . $feature->icon)); ?>" 
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english); ?>">
                            <?php else: ?>
                            <i class="fas fa-star"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    
                    <div class="feature-content-modern">
                        <h4 class="feature-title-modern">
                            <?php echo e(app()->getLocale() == 'ar' ? $feature->title_arabic : $feature->title_english); ?>

                        </h4>
                        <p class="feature-desc-modern">
                            <?php echo e(app()->getLocale() == 'ar' ? $feature->description_arabic : $feature->description_english); ?>

                        </p>
                    </div>
                    
                    
                    <div class="feature-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    
                    
                    <div class="feature-accent-line"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="features-bottom-decoration">
            <div class="decoration-line"></div>
            <div class="decoration-icon">
                <i class="fas fa-gem"></i>
            </div>
            <div class="decoration-line"></div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/features.blade.php ENDPATH**/ ?>