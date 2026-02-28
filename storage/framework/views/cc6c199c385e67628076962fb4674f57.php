
<section class="about-cta-section py-10">
    <div class="container">
        <div class="about-cta-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="cta-title"><?php echo e(__('lang.ready_to_start')); ?></h3>
                    <p class="cta-text"><?php echo e(__('lang.cta_description')); ?></p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="<?php echo e(route('contact')); ?>" class="btn btn-cta">
                        <span><?php echo e(__('lang.contact_us')); ?></span>
                        <i class="fas fa-arrow-right <?php echo e(app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : ''); ?>"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/cta.blade.php ENDPATH**/ ?>