
<?php if($aboutInfo && $aboutInfo->company_profile): ?>
<section class="company-profile-section py-10">
    <div class="container">
        <div class="company-profile-wrapper" data-animate="fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="profile-content">
                        <div class="profile-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="profile-text">
                            <h3 class="profile-title"><?php echo e(__('lang.company_profile')); ?></h3>
                            <p class="profile-description"><?php echo e(__('lang.company_profile_description')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-lg-right">
                    <a href="<?php echo e(asset('storage' . $aboutInfo->company_profile)); ?>" 
                       class="btn btn-download-profile" 
                       target="_blank" 
                       download>
                        <i class="fas fa-download"></i>
                        <span><?php echo e(__('lang.download_company_profile')); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/contact/partials/company-profile.blade.php ENDPATH**/ ?>