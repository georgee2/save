
<?php if($whyChooseUsBlock): ?>
<section class="why-choose-us-section">
    <div class="container">
        <div class="why-choose-us-grid">
            
            <div class="why-cards-left why-cards-desktop">
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
            
            
            <div class="why-cards-right why-cards-desktop">
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
        
        
        <div class="why-cards-mobile">
            <?php $__currentLoopData = $whyChooseUsCards->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="why-mobile-slide">
                <div class="why-card">
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
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var $whySlider = $('.why-cards-mobile');
    var whyInitialized = false;

    function initWhySlider() {
        if ($(window).width() <= 767) {
            if (!whyInitialized && $whySlider.length) {
                $whySlider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 3500,
                    infinite: true,
                    speed: 400,
                    adaptiveHeight: true,
                    customPaging: function() {
                        return '<span></span>';
                    }
                });
                whyInitialized = true;
            }
        } else {
            if (whyInitialized) {
                $whySlider.slick('unslick');
                whyInitialized = false;
            }
        }
    }

    initWhySlider();
    $(window).on('resize', initWhySlider);
});
</script>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/whychooseus.blade.php ENDPATH**/ ?>