
<div class="site-topbar">
    <div class="container">
        <div class="topbar-content">
            
            <div class="topbar-social">
                <?php if(isset($footerContactInfo)): ?>
                    <?php if($footerContactInfo->facebook): ?>
                    <a href="<?php echo e($footerContactInfo->facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($footerContactInfo->instagram): ?>
                    <a href="<?php echo e($footerContactInfo->instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($footerContactInfo->twitter): ?>
                    <a href="<?php echo e($footerContactInfo->twitter); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($footerContactInfo->linkedin): ?>
                    <a href="<?php echo e($footerContactInfo->linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($footerContactInfo->pinterest): ?>
                    <a href="<?php echo e($footerContactInfo->pinterest); ?>" target="_blank" rel="noopener" aria-label="Pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($footerContactInfo->youtube): ?>
                    <a href="<?php echo e($footerContactInfo->youtube); ?>" target="_blank" rel="noopener" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            
            <div class="topbar-contact">
                <?php if(isset($footerContactInfo) && $footerContactInfo->mobile): ?>
                <a href="tel:<?php echo e($footerContactInfo->mobile); ?>" class="topbar-phone">
                    <i class="fas fa-phone-alt"></i>
                    <span><?php echo e($footerContactInfo->mobile); ?></span>
                </a>
                <?php endif; ?>
                <?php if(isset($footerContactInfo) && $footerContactInfo->whatsapp): ?>
                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp)); ?>" target="_blank" rel="noopener" class="topbar-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    <span><?php echo e(__('lang.whatsapp')); ?></span>
                </a>
                <?php endif; ?>
                
                
                <div class="topbar-links">
                    <a href="<?php echo e(route('blogs.index')); ?>" class="topbar-link">
                        <i class="fas fa-newspaper"></i>
                        <span><?php echo e(__('lang.news')); ?></span>
                    </a>
                    <a href="<?php echo e(route('careers.index')); ?>" class="topbar-link">
                        <i class="fas fa-briefcase"></i>
                        <span><?php echo e(__('lang.careers')); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/includes/topbar.blade.php ENDPATH**/ ?>