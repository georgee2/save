
<a href="#" class="back-to-top" id="backToTop" aria-label="Back to Top">
    <i class="fas fa-chevron-up"></i>
</a>


<footer class="site-footer">
    
    <div class="footer-main">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget footer-about">
                        <a href="<?php echo e(url('/')); ?>" class="footer-logo">
                            <?php if(app()->getLocale() == 'ar'): ?>
                            <img src="<?php echo e(url('/pic/logos/logoarfooter.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
                            <?php else: ?>
                            <img src="<?php echo e(url('/pic/logos/logoenfooter.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
                            <?php endif; ?>
                        </a>
                        <?php if($footerContactInfo && ($footerContactInfo->footer_bio_english || $footerContactInfo->footer_bio_arabic)): ?>
                        <p class="footer-bio">
                            <?php echo e(app()->getLocale() == 'ar' ? $footerContactInfo->footer_bio_arabic : $footerContactInfo->footer_bio_english); ?>

                        </p>
                        <?php else: ?>
                        <p class="footer-bio">
                            <?php echo e(__('lang.footer_default_bio')); ?>

                        </p>
                        <?php endif; ?>
                        
                        
                        <div class="footer-social">
                            <?php if($footerContactInfo): ?>
                                <?php if($footerContactInfo->facebook): ?>
                                <a href="<?php echo e($footerContactInfo->facebook); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($footerContactInfo->instagram): ?>
                                <a href="<?php echo e($footerContactInfo->instagram); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($footerContactInfo->twitter): ?>
                                <a href="<?php echo e($footerContactInfo->twitter); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($footerContactInfo->linkedin): ?>
                                <a href="<?php echo e($footerContactInfo->linkedin); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($footerContactInfo->pinterest): ?>
                                <a href="<?php echo e($footerContactInfo->pinterest); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="Pinterest">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($footerContactInfo->whatsapp): ?>
                                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp)); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <?php if(isset($footerQuickLinksMenu) && $footerQuickLinksMenu && $footerQuickLinksItems->count() > 0): ?>
                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-widget-title"><?php echo e($footerQuickLinksMenu->getTitle()); ?></h4>
                        <ul class="footer-links">
                            <?php $__currentLoopData = $footerQuickLinksItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->isVisible()): ?>
                                <li>
                                    <a href="<?php echo e($item->getUrl() ?? '#'); ?>" target="<?php echo e($item->link_target); ?>">
                                        <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                        <?php echo e($item->getTitle()); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <?php else: ?>
                
                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-widget-title"><?php echo e(__('lang.quick_links')); ?></h4>
                        <ul class="footer-links">
                            <li>
                                <a href="<?php echo e(route('index')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.home')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('services.index')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.services')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('offers.index')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.offers')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('projects.index')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.projects')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('contact')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.contact_us')); ?>

                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if(isset($footerCompanyMenu) && $footerCompanyMenu && $footerCompanyItems->count() > 0): ?>
                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-widget-title"><?php echo e($footerCompanyMenu->getTitle()); ?></h4>
                        <ul class="footer-links">
                            <?php $__currentLoopData = $footerCompanyItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->isVisible()): ?>
                                <?php
                                    $showItem = true;
                                    if ($item->route_name === 'careers.index' && (!isset($hasActiveJobs) || !$hasActiveJobs)) {
                                        $showItem = false;
                                    }
                                ?>
                                <?php if($showItem): ?>
                                <li>
                                    <a href="<?php echo e($item->getUrl() ?? '#'); ?>" target="<?php echo e($item->link_target); ?>">
                                        <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                        <?php echo e($item->getTitle()); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <?php else: ?>
                
                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-widget-title"><?php echo e(__('lang.company')); ?></h4>
                        <ul class="footer-links">
                            <li>
                                <a href="<?php echo e(route('about')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.about_us')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('team.index')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.our_team')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('partners.index')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.our_partners')); ?>

                                </a>
                            </li>
                            <?php if(isset($hasActiveJobs) && $hasActiveJobs): ?>
                            <li>
                                <a href="<?php echo e(route('careers.index')); ?>">
                                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                                    <?php echo e(__('lang.careers')); ?>

                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget footer-contact">
                        <h4 class="footer-widget-title"><?php echo e(__('lang.contact_info')); ?></h4>
                        <ul class="footer-contact-list">
                            <?php if($footerContactInfo): ?>
                                <?php if($footerContactInfo->location_text_english || $footerContactInfo->location_text_arabic): ?>
                                <li>
                                    <div class="contact-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-text">
                                        <span class="contact-label"><?php echo e(__('lang.address')); ?></span>
                                        <p><?php echo e(app()->getLocale() == 'ar' ? $footerContactInfo->location_text_arabic : $footerContactInfo->location_text_english); ?></p>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($footerContactInfo->mobile): ?>
                                <li>
                                    <div class="contact-icon">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div class="contact-text">
                                        <span class="contact-label"><?php echo e(__('lang.phone')); ?></span>
                                        <p>
                                            <a href="tel:<?php echo e($footerContactInfo->mobile); ?>"><?php echo e($footerContactInfo->mobile); ?></a>
                                            <?php if($footerContactInfo->secondary_mobile): ?>
                                            <br>
                                            <a href="tel:<?php echo e($footerContactInfo->secondary_mobile); ?>"><?php echo e($footerContactInfo->secondary_mobile); ?></a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($footerContactInfo->email): ?>
                                <li>
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-text">
                                        <span class="contact-label"><?php echo e(__('lang.email')); ?></span>
                                        <p><a href="mailto:<?php echo e($footerContactInfo->email); ?>"><?php echo e($footerContactInfo->email); ?></a></p>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($footerContactInfo->working_hours_english || $footerContactInfo->working_hours_arabic): ?>
                                <li>
                                    <div class="contact-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="contact-text">
                                        <span class="contact-label"><?php echo e(__('lang.working_hours')); ?></span>
                                        <p><?php echo e(app()->getLocale() == 'ar' ? $footerContactInfo->working_hours_arabic : $footerContactInfo->working_hours_english); ?></p>
                                    </div>
                                </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <p class="copyright">
                        &copy; <?php echo e(date('Y')); ?> <?php echo e(env('APP_NAME')); ?>. <?php echo e(__('lang.all_rights_reserved')); ?>

                    </p>
                </div>
                <div class="col-md-6 text-center text-md-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>">
                    <ul class="footer-bottom-links">
                        <li><a href="<?php echo e(route('about')); ?>"><?php echo e(__('lang.about_us')); ?></a></li>
                        <li><a href="<?php echo e(route('contact')); ?>"><?php echo e(__('lang.contact_us')); ?></a></li>
                        <li><a href="<?php echo e(route('sitemap')); ?>" target="_blank"><?php echo e(__('lang.sitemap')); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/includes/footer.blade.php ENDPATH**/ ?>