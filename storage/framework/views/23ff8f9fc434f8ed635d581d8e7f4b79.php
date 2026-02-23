
<?php if($aboutBlock): ?>
<section class="svg-about-section">
    <div class="container">
        <div class="svg-about-cards">
            
            <div class="svg-center-content svg-about-center">
                <?php if($aboutBlock->subtitle_english || $aboutBlock->subtitle_arabic): ?>
                <span class="section-badge" data-animate="fadeInUp">
                    <i class="fas fa-cloud"></i>
                    <?php echo e(app()->getLocale() == 'ar' ? $aboutBlock->subtitle_arabic : $aboutBlock->subtitle_english); ?>

                </span>
                <?php endif; ?>
                
                <h2 class="section-title" data-animate="fadeInUp">
                    <?php echo e(app()->getLocale() == 'ar' ? $aboutBlock->title_arabic : $aboutBlock->title_english); ?>

                </h2>
                
                <?php if($aboutBlock->button_text_english || $aboutBlock->button_text_arabic): ?>
                <a href="<?php echo e(app()->getLocale() == 'ar' ? ($aboutBlock->url_arabic ?? '#') : ($aboutBlock->url_english ?? '#')); ?>" 
                   class="section-btn" data-animate="fadeInUp">
                    <?php echo e(app()->getLocale() == 'ar' ? $aboutBlock->button_text_arabic : $aboutBlock->button_text_english); ?>

                    <span class="btn-icon">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </a>
                <?php endif; ?>
            </div>

            
            <?php
                $iconCards = $aboutCards->where('card_type', 'icon_card')->values();
                $bgCard = $aboutCards->where('card_type', 'card_with_background')->first();
                $cardPositions = ['svg-card-1', 'svg-card-2', 'svg-card-3', 'svg-card-4'];
            ?>

            
            <?php $__currentLoopData = $iconCards->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="svg-icon-card <?php echo e($cardPositions[$index] ?? ''); ?>" data-animate="fadeInUp">
                <?php if($card->icon_dark): ?>
                <div class="card-icon">
                    <img src="<?php echo e(asset('storage' . $card->icon_dark)); ?>" 
                         alt="<?php echo e(app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english); ?>">
                </div>
                <?php endif; ?>
                
                <h3 class="card-title">
                    <?php echo e(app()->getLocale() == 'ar' ? $card->title_arabic : $card->title_english); ?>

                </h3>
                
                <p class="card-text">
                    <?php echo e(app()->getLocale() == 'ar' ? $card->bio_arabic : $card->bio_english); ?>

                </p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($bgCard): ?>
            <div class="svg-bg-card svg-card-5" 
                 style="background-image: url('<?php echo e(asset('storage' . $bgCard->background)); ?>')"
                 data-animate="fadeInUp">
                <?php if($bgCard->icon_white): ?>
                <div class="card-icon-overlay">
                    <img src="<?php echo e(asset('storage' . $bgCard->icon_white)); ?>" alt="Icon">
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/about.blade.php ENDPATH**/ ?>