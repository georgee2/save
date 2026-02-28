
<?php if($aboutInfo->about_english || $aboutInfo->about_arabic): ?>
<section class="about-section-modern">
    <div class="about-section-bg">
        <div class="about-bg-shape about-bg-shape-1"></div>
        <div class="about-bg-shape about-bg-shape-2"></div>
        <div class="about-bg-shape about-bg-shape-3"></div>
    </div>
    <div class="container">
        <div class="about-modern-wrapper">
            <div class="row align-items-center g-5">
                <?php if($aboutInfo->about_image): ?>
                <div class="col-lg-6" data-animate="fadeInLeft">
                    <div class="about-image-modern">
                        <div class="about-image-frame">
                            <div class="about-image-inner">
                                <img src="<?php echo e(asset('storage' . $aboutInfo->about_image)); ?>" 
                                     alt="<?php echo e(__('lang.about_us')); ?>">
                            </div>
                            <div class="about-image-border"></div>
                        </div>
                        
                        <div class="about-float-element about-float-1">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="about-float-element about-float-2">
                            <i class="fas fa-award"></i>
                        </div>
                        
                        <?php
                            $yearsExperience = date('Y') - 2010;
                        ?>
                        <div class="about-experience-badge">
                            <div class="experience-number"><?php echo e($yearsExperience); ?>+</div>
                            <div class="experience-text"><?php echo e(__('lang.years_experience') ?? 'Years Experience'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-animate="fadeInRight">
                <?php else: ?>
                <div class="col-lg-12" data-animate="fadeInUp">
                <?php endif; ?>
                    <div class="about-content-modern">
                        
                        <div class="about-badge">
                            <span class="badge-icon"><i class="fas fa-info-circle"></i></span>
                            <span class="badge-text"><?php echo e(__('lang.who_we_are')); ?></span>
                        </div>
                        
                        
                        <h2 class="about-title-modern">
                            <?php echo e(__('lang.about_us')); ?>

                            <span class="title-highlight"></span>
                        </h2>
                        
                        
                        <?php if($aboutInfo->subtitle_english || $aboutInfo->subtitle_arabic): ?>
                        <p class="about-tagline">
                            <?php echo e(app()->getLocale() == 'ar' ? $aboutInfo->subtitle_arabic : $aboutInfo->subtitle_english); ?>

                        </p>
                        <?php endif; ?>
                        
                        
                        <div class="about-text-modern">
                            <div class="about-text-content">
                                <?php echo nl2br(e(app()->getLocale() == 'ar' ? $aboutInfo->about_arabic : $aboutInfo->about_english)); ?>

                            </div>
                        </div>
                        
                        
                        <div class="about-key-points">
                            <div class="key-point">
                                <div class="key-point-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span><?php echo e(__('lang.professional_team') ?? 'Professional Team'); ?></span>
                            </div>
                            <div class="key-point">
                                <div class="key-point-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span><?php echo e(__('lang.quality_service') ?? 'Quality Service'); ?></span>
                            </div>
                            <div class="key-point">
                                <div class="key-point-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span><?php echo e(__('lang.customer_satisfaction') ?? 'Customer Satisfaction'); ?></span>
                            </div>
                        </div>
                        
                        
                        <div class="about-actions">
                            <?php if($aboutInfo->company_profile): ?>
                            <a href="<?php echo e(asset('storage' . $aboutInfo->company_profile)); ?>" 
                               class="btn-about-primary" 
                               target="_blank" 
                               download>
                                <span class="btn-icon"><i class="fas fa-file-pdf"></i></span>
                                <span class="btn-text"><?php echo e(__('lang.download_company_profile')); ?></span>
                                <span class="btn-arrow"><i class="fas fa-download"></i></span>
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('contact')); ?>" class="btn-about-secondary">
                                <span><?php echo e(__('lang.contact_us')); ?></span>
                                <i class="fas fa-arrow-right <?php echo e(app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : ''); ?>"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/about-content.blade.php ENDPATH**/ ?>