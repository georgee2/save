
<section class="contact-info-section py-10">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-lg-4 col-md-6 mb-4" data-animate="fadeInUp">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4 class="contact-card-title"><?php echo e(__('lang.call_us')); ?></h4>
                    <div class="contact-card-content">
                        <?php if($contactInfo->mobile): ?>
                        <a href="tel:<?php echo e($contactInfo->mobile); ?>" class="contact-link"><?php echo e($contactInfo->mobile); ?></a>
                        <?php endif; ?>
                        <?php if($contactInfo->secondary_mobile): ?>
                        <a href="tel:<?php echo e($contactInfo->secondary_mobile); ?>" class="contact-link"><?php echo e($contactInfo->secondary_mobile); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            
            <div class="col-lg-4 col-md-6 mb-4" data-animate="fadeInUp" data-delay="100">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4 class="contact-card-title"><?php echo e(__('lang.email_us')); ?></h4>
                    <div class="contact-card-content">
                        <?php if($contactInfo->email): ?>
                        <a href="mailto:<?php echo e($contactInfo->email); ?>" class="contact-link"><?php echo e($contactInfo->email); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            
            <div class="col-lg-4 col-md-6 mb-4" data-animate="fadeInUp" data-delay="200">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4 class="contact-card-title"><?php echo e(__('lang.visit_us')); ?></h4>
                    <div class="contact-card-content">
                        <p class="contact-address">
                            <?php echo e(app()->getLocale() == 'ar' ? $contactInfo->location_text_arabic : $contactInfo->location_text_english); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/contact/partials/info-cards.blade.php ENDPATH**/ ?>