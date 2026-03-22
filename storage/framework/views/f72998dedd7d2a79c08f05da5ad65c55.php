
<?php
    $aboutInfo = \App\Models\AboutInformation::getAboutInfo();
?>

<div class="contact-info-card">
    
    <div class="contact-card-header">
        <div class="header-icon">
            <i class="fas fa-headset"></i>
        </div>
        <h4 class="header-title"><?php echo e(__('lang.get_in_touch')); ?></h4>
        <p class="header-subtitle"><?php echo e(__('lang.we_are_here_to_help')); ?></p>
    </div>
    
    
    <div class="contact-card-body">
        <?php if($footerContactInfo): ?>
            
            <?php if($footerContactInfo->mobile): ?>
            <a href="tel:<?php echo e($footerContactInfo->mobile); ?>" class="contact-method phone-method">
                <div class="method-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="method-info">
                    <span class="method-label"><?php echo e(__('lang.call_us')); ?></span>
                    <span class="method-value"><?php echo e($footerContactInfo->mobile); ?></span>
                </div>
                <div class="method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            <?php endif; ?>
            
            
            <?php if($footerContactInfo->whatsapp): ?>
            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp)); ?>" target="_blank" rel="noopener" class="contact-method whatsapp-method">
                <div class="method-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="method-info">
                    <span class="method-label"><?php echo e(__('lang.whatsapp')); ?></span>
                    <span class="method-value"><?php echo e(__('lang.chat_with_us')); ?></span>
                </div>
                <div class="method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            <?php endif; ?>
            
            
            <?php if($footerContactInfo->email): ?>
            <a href="mailto:<?php echo e(trim($footerContactInfo->email)); ?>" target="_blank" class="contact-method email-method">
                <div class="method-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="method-info">
                    <span class="method-label"><?php echo e(__('lang.email_us')); ?></span>
                    <span class="method-value"><?php echo e(trim($footerContactInfo->email)); ?></span>
                </div>
                <div class="method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            <?php endif; ?>
        <?php endif; ?>
        
        
        <a href="<?php echo e(route('contact')); ?>" class="btn-contact-page">
            <i class="fas fa-paper-plane"></i>
            <span><?php echo e(__('lang.contact_us')); ?></span>
        </a>
        
        
        <?php if($aboutInfo && $aboutInfo->company_profile): ?>
        <a href="<?php echo e(asset('storage' . $aboutInfo->company_profile)); ?>" target="_blank" download class="btn-company-profile">
            <i class="fas fa-file-pdf"></i>
            <span><?php echo e(__('lang.download_company_profile')); ?></span>
            <i class="fas fa-download download-icon"></i>
        </a>
        <?php endif; ?>
    </div>
    
    
    <?php if($footerContactInfo): ?>
    <div class="contact-card-footer">
        <span class="social-label"><?php echo e(__('lang.follow_us')); ?></span>
        <div class="social-icons">
            <?php if($footerContactInfo->facebook): ?>
            <a href="<?php echo e($footerContactInfo->facebook); ?>" target="_blank" rel="noopener" class="social-icon facebook" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->instagram): ?>
            <a href="<?php echo e($footerContactInfo->instagram); ?>" target="_blank" rel="noopener" class="social-icon instagram" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->twitter): ?>
            <a href="<?php echo e($footerContactInfo->twitter); ?>" target="_blank" rel="noopener" class="social-icon twitter" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->linkedin): ?>
            <a href="<?php echo e($footerContactInfo->linkedin); ?>" target="_blank" rel="noopener" class="social-icon linkedin" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->pinterest): ?>
            <a href="<?php echo e($footerContactInfo->pinterest); ?>" target="_blank" rel="noopener" class="social-icon pinterest" aria-label="Pinterest">
                <i class="fab fa-pinterest-p"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->whatsapp): ?>
            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp)); ?>" target="_blank" rel="noopener" class="social-icon whatsapp" aria-label="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/projects/singleproject/contact-card.blade.php ENDPATH**/ ?>