
<?php
    $aboutInfo = \App\Models\AboutInformation::getAboutInfo();
?>

<div class="offer-contact-card">
    
    <div class="offer-contact-header">
        <div class="offer-contact-icon">
            <i class="fas fa-headset"></i>
        </div>
        <h4 class="offer-contact-title"><?php echo e(__('lang.get_in_touch')); ?></h4>
        <p class="offer-contact-subtitle"><?php echo e(__('lang.we_are_here_to_help')); ?></p>
    </div>
    
    
    <div class="offer-contact-body">
        <?php if($footerContactInfo): ?>
            
            <?php if($footerContactInfo->mobile): ?>
            <a href="tel:<?php echo e($footerContactInfo->mobile); ?>" class="offer-contact-method offer-phone-method">
                <div class="offer-method-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="offer-method-info">
                    <span class="offer-method-label"><?php echo e(__('lang.call_us')); ?></span>
                    <span class="offer-method-value"><?php echo e($footerContactInfo->mobile); ?></span>
                </div>
                <div class="offer-method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            <?php endif; ?>
            
            
            <?php if($footerContactInfo->whatsapp): ?>
            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp)); ?>" target="_blank" rel="noopener" class="offer-contact-method offer-whatsapp-method">
                <div class="offer-method-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="offer-method-info">
                    <span class="offer-method-label"><?php echo e(__('lang.whatsapp')); ?></span>
                    <span class="offer-method-value"><?php echo e(__('lang.chat_with_us')); ?></span>
                </div>
                <div class="offer-method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            <?php endif; ?>
            
            
            <?php if($footerContactInfo->email): ?>
            <a href="mailto:<?php echo e(trim($footerContactInfo->email)); ?>" target="_blank" class="offer-contact-method offer-email-method">
                <div class="offer-method-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="offer-method-info">
                    <span class="offer-method-label"><?php echo e(__('lang.email_us')); ?></span>
                    <span class="offer-method-value"><?php echo e(trim($footerContactInfo->email)); ?></span>
                </div>
                <div class="offer-method-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            <?php endif; ?>
        <?php endif; ?>
        
        
        <a href="<?php echo e(route('contact')); ?>" class="offer-btn-contact">
            <i class="fas fa-paper-plane"></i>
            <span><?php echo e(__('lang.contact_us')); ?></span>
        </a>
        
        
        <?php if($aboutInfo && $aboutInfo->company_profile): ?>
        <a href="<?php echo e(asset('storage' . $aboutInfo->company_profile)); ?>" target="_blank" download class="offer-btn-profile">
            <i class="fas fa-file-pdf"></i>
            <span><?php echo e(__('lang.download_company_profile')); ?></span>
            <i class="fas fa-download offer-download-icon"></i>
        </a>
        <?php endif; ?>
    </div>
    
    
    <?php if($footerContactInfo): ?>
    <div class="offer-contact-footer">
        <span class="offer-social-label"><?php echo e(__('lang.follow_us')); ?></span>
        <div class="offer-social-icons">
            <?php if($footerContactInfo->facebook): ?>
            <a href="<?php echo e($footerContactInfo->facebook); ?>" target="_blank" rel="noopener" class="offer-social-icon offer-social-facebook" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->instagram): ?>
            <a href="<?php echo e($footerContactInfo->instagram); ?>" target="_blank" rel="noopener" class="offer-social-icon offer-social-instagram" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->twitter): ?>
            <a href="<?php echo e($footerContactInfo->twitter); ?>" target="_blank" rel="noopener" class="offer-social-icon offer-social-twitter" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->linkedin): ?>
            <a href="<?php echo e($footerContactInfo->linkedin); ?>" target="_blank" rel="noopener" class="offer-social-icon offer-social-linkedin" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->pinterest): ?>
            <a href="<?php echo e($footerContactInfo->pinterest); ?>" target="_blank" rel="noopener" class="offer-social-icon offer-social-pinterest" aria-label="Pinterest">
                <i class="fab fa-pinterest-p"></i>
            </a>
            <?php endif; ?>
            <?php if($footerContactInfo->whatsapp): ?>
            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp)); ?>" target="_blank" rel="noopener" class="offer-social-icon offer-social-whatsapp" aria-label="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/offers/partials/contact-card.blade.php ENDPATH**/ ?>