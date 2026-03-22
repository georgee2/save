
<nav class="mobile-bottom-nav" id="mobileBottomNav" style="position:fixed!important;bottom:0!important;left:0!important;right:0!important;z-index:99999!important;background:#fff!important;">
    <div class="mobile-bottom-nav-container">
        
        <a href="<?php echo e(route('index')); ?>" class="mobile-bottom-nav-item <?php echo e(Route::currentRouteName() == 'index' ? 'active' : ''); ?>">
            <div class="nav-icon">
                <i class="fal fa-home"></i>
                <i class="fas fa-home active-icon"></i>
            </div>
            <span class="nav-label"><?php echo e(__('lang.home')); ?></span>
        </a>
        
        
        <a href="<?php echo e(route('offers.index')); ?>" class="mobile-bottom-nav-item <?php echo e(str_contains(Route::currentRouteName() ?? '', 'offers') ? 'active' : ''); ?>">
            <div class="nav-icon">
                <i class="fal fa-tags"></i>
                <i class="fas fa-tags active-icon"></i>
            </div>
            <span class="nav-label"><?php echo e(__('lang.offers')); ?></span>
        </a>
        
        
        <button type="button" class="mobile-bottom-nav-item contact-popup-trigger" id="contactPopupTrigger">
            <div class="nav-icon nav-icon-center">
                <i class="fal fa-envelope"></i>
            </div>
            <span class="nav-label"><?php echo e(__('lang.contact')); ?></span>
        </button>
        
        
        <a href="<?php echo e(route('favourites.index')); ?>" class="mobile-bottom-nav-item <?php echo e(Route::currentRouteName() == 'favourites.index' ? 'active' : ''); ?>">
            <div class="nav-icon">
                <i class="fal fa-heart"></i>
                <i class="fas fa-heart active-icon"></i>
            </div>
            <span class="nav-label"><?php echo e(__('lang.favourites')); ?></span>
            <span class="favourite-badge" style="display: none;">0</span>
        </a>
        
        
        <div class="mobile-bottom-nav-item login-item">
            <div class="nav-icon">
                <i class="fal fa-user"></i>
                <i class="fas fa-user active-icon"></i>
            </div>
            <span class="nav-label"><?php echo e(__('lang.login') ?? 'Login'); ?></span>
        </div>
    </div>
</nav>


<div class="contact-popup-overlay" id="contactPopupOverlay" style="z-index:999999!important;"></div>
<div class="contact-popup-modal" id="contactPopupModal" style="z-index:9999999!important;">
    <div class="contact-popup-header">
        <h4><i class="fal fa-envelope"></i> <?php echo e(__('lang.contact_us')); ?></h4>
        <button type="button" class="contact-popup-close" id="contactPopupClose">
            <i class="fal fa-times"></i>
        </button>
    </div>
    <div class="contact-popup-body">
        
        <a href="<?php echo e(route('contact')); ?>" class="contact-popup-link">
            <div class="contact-popup-link-icon">
                <i class="fal fa-paper-plane"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title"><?php echo e(__('lang.contact_us')); ?></span>
                <span class="contact-popup-link-desc"><?php echo e(__('lang.send_message') ?? 'Send us a message'); ?></span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        
        
        <?php
            $bottomNavContact = $footerContactInfo ?? \App\Models\ContactInformation::getContactInfo();
        ?>
        <?php if($bottomNavContact && $bottomNavContact->mobile): ?>
        <a href="tel:<?php echo e($bottomNavContact->mobile); ?>" class="contact-popup-link">
            <div class="contact-popup-link-icon">
                <i class="fal fa-phone"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title"><?php echo e(__('lang.call_us') ?? 'Call Us'); ?></span>
                <span class="contact-popup-link-desc"><?php echo e($bottomNavContact->mobile); ?></span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        <?php endif; ?>
        
        
        <?php if($bottomNavContact && $bottomNavContact->whatsapp): ?>
        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $bottomNavContact->whatsapp)); ?>" target="_blank" class="contact-popup-link whatsapp-link">
            <div class="contact-popup-link-icon">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title">WhatsApp</span>
                <span class="contact-popup-link-desc"><?php echo e(__('lang.chat_with_us') ?? 'Chat with us'); ?></span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        <?php endif; ?>
        
        
        <?php if($bottomNavContact && $bottomNavContact->email): ?>
        <a href="mailto:<?php echo e($bottomNavContact->email); ?>" class="contact-popup-link">
            <div class="contact-popup-link-icon">
                <i class="fal fa-envelope"></i>
            </div>
            <div class="contact-popup-link-content">
                <span class="contact-popup-link-title"><?php echo e(__('lang.email')); ?></span>
                <span class="contact-popup-link-desc"><?php echo e($bottomNavContact->email); ?></span>
            </div>
            <i class="fal fa-chevron-right"></i>
        </a>
        <?php endif; ?>
        
        
        <div class="contact-popup-social">
            <span class="contact-popup-social-title"><?php echo e(__('lang.follow_us') ?? 'Follow Us'); ?></span>
            <div class="contact-popup-social-icons">
                <?php if($bottomNavContact): ?>
                    <?php if($bottomNavContact->facebook): ?>
                    <a href="<?php echo e($bottomNavContact->facebook); ?>" target="_blank" class="social-icon facebook" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($bottomNavContact->instagram): ?>
                    <a href="<?php echo e($bottomNavContact->instagram); ?>" target="_blank" class="social-icon instagram" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($bottomNavContact->twitter): ?>
                    <a href="<?php echo e($bottomNavContact->twitter); ?>" target="_blank" class="social-icon twitter" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($bottomNavContact->linkedin): ?>
                    <a href="<?php echo e($bottomNavContact->linkedin); ?>" target="_blank" class="social-icon linkedin" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($bottomNavContact->youtube): ?>
                    <a href="<?php echo e($bottomNavContact->youtube); ?>" target="_blank" class="social-icon youtube" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($bottomNavContact->pinterest): ?>
                    <a href="<?php echo e($bottomNavContact->pinterest); ?>" target="_blank" class="social-icon pinterest" title="Pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($bottomNavContact->whatsapp): ?>
                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $bottomNavContact->whatsapp)); ?>" target="_blank" class="social-icon whatsapp" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactTrigger = document.getElementById('contactPopupTrigger');
    const contactOverlay = document.getElementById('contactPopupOverlay');
    const contactModal = document.getElementById('contactPopupModal');
    const contactClose = document.getElementById('contactPopupClose');
    
    function openContactPopup() {
        contactOverlay.classList.add('active');
        contactModal.classList.add('active');
        document.body.classList.add('contact-popup-open');
    }
    
    function closeContactPopup() {
        contactOverlay.classList.remove('active');
        contactModal.classList.remove('active');
        document.body.classList.remove('contact-popup-open');
    }
    
    if (contactTrigger) {
        contactTrigger.addEventListener('click', openContactPopup);
    }
    
    if (contactOverlay) {
        contactOverlay.addEventListener('click', closeContactPopup);
    }
    
    if (contactClose) {
        contactClose.addEventListener('click', closeContactPopup);
    }
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && contactModal.classList.contains('active')) {
            closeContactPopup();
        }
    });
});
</script>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/includes/mobile-bottom-nav.blade.php ENDPATH**/ ?>