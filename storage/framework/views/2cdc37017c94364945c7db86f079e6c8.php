
<?php if(isset($certificates) && $certificates->count() > 0): ?>
<section class="certificates-section">
    <div class="container">
        
        <div class="certificates-header text-center">
            <span class="certificates-label"><?php echo e(__('lang.our_achievements')); ?></span>
            <h2 class="certificates-title"><?php echo e(__('lang.certificates')); ?></h2>
            <div class="certificates-title-line"></div>
            <p class="certificates-subtitle"><?php echo e(__('lang.certificates_subtitle')); ?></p>
        </div>
        
        
        <div class="certificates-slider-wrapper">
            <div class="certificates-slider">
                <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="certificate-slide">
                    <div class="certificate-card">
                        <?php if($certificate->image): ?>
                        <a href="<?php echo e(url('/storage' . $certificate->image)); ?>" 
                           data-gtf-mfp="true" 
                           data-gallery-id="certificates-gallery"
                           title="<?php echo e(app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english); ?>">
                            <div class="certificate-image">
                                <img src="<?php echo e(url('/storage' . $certificate->image)); ?>" 
                                     alt="<?php echo e(app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english); ?>">
                                <div class="certificate-overlay">
                                    <div class="certificate-zoom">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php else: ?>
                        <div class="certificate-image certificate-no-image">
                            <div class="certificate-placeholder">
                                <i class="fas fa-certificate"></i>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="certificate-info">
                            <h4 class="certificate-name">
                                <?php echo e(app()->getLocale() == 'ar' ? $certificate->name_arabic : $certificate->name_english); ?>

                            </h4>
                            <?php if($certificate->bio_english || $certificate->bio_arabic): ?>
                            <p class="certificate-bio">
                                <?php echo e(app()->getLocale() == 'ar' ? $certificate->bio_arabic : $certificate->bio_english); ?>

                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            
            
            
            <div class="certificates-dots"></div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/certificates.blade.php ENDPATH**/ ?>