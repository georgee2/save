
<?php if($whyChooseUsBlock): ?>
<section class="why-choose-us-section">
    <div class="container">
        <div class="why-choose-us-grid">
            
            <div class="why-cards-left">
                <?php $__currentLoopData = $whyChooseUsCards->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="why-card" data-animate="fadeInLeft">
                    <div class="why-card-icon">
                        <?php if($card->icon_dark): ?>
                        <img src="<?php echo e(url('/storage' . $card->icon_dark)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english); ?>">
                        <?php else: ?>
                        <i class="fas fa-star"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="why-card-title">
                        <?php echo e(app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english); ?>

                    </h3>
                    <p class="why-card-text">
                        <?php echo e(app()->getLocale() == 'ar' ? $card->bio_arabic : $card->bio_english); ?>

                    </p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            
            <div class="why-center" data-animate="fadeInUp">
                <div class="why-center-content">
                    <?php if($whyChooseUsBlock->subtitle_english || $whyChooseUsBlock->subtitle_arabic): ?>
                    <span class="why-subtitle">
                        <i class="fas fa-circle"></i>
                        <?php echo e(app()->getLocale() == 'ar' ? $whyChooseUsBlock->subtitle_arabic : $whyChooseUsBlock->subtitle_english); ?>

                    </span>
                    <?php endif; ?>
                    
                    <h2 class="why-title">
                        <?php echo e(app()->getLocale() == 'ar' ? $whyChooseUsBlock->title_arabic : $whyChooseUsBlock->title_english); ?>

                    </h2>
                    
                    <div class="why-logo">
                        <img src="<?php echo e(url('/pic/svgwhite.svg')); ?>" alt="SVG Logo">
                    </div>
                    
                    <?php if($whyChooseUsBlock->button_text_english || $whyChooseUsBlock->button_text_arabic): ?>
                    <a href="<?php echo e(app()->getLocale() == 'ar' ? ($whyChooseUsBlock->url_arabic ?? '#') : ($whyChooseUsBlock->url_english ?? '#')); ?>" 
                       class="why-btn">
                        <?php echo e(app()->getLocale() == 'ar' ? $whyChooseUsBlock->button_text_arabic : $whyChooseUsBlock->button_text_english); ?>

                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            
            <div class="why-cards-right">
                <?php $__currentLoopData = $whyChooseUsCards->skip(2)->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="why-card" data-animate="fadeInRight">
                    <div class="why-card-icon">
                        <?php if($card->icon_dark): ?>
                        <img src="<?php echo e(url('/storage' . $card->icon_dark)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english); ?>">
                        <?php else: ?>
                        <i class="fas fa-star"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="why-card-title">
                        <?php echo e(app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english); ?>

                    </h3>
                    <p class="why-card-text">
                        <?php echo e(app()->getLocale() == 'ar' ? $card->bio_arabic : $card->bio_english); ?>

                    </p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/whychooseus.blade.php ENDPATH**/ ?>