
<?php if(isset($governmentPartners) && $governmentPartners->count() > 0): ?>
<section class="govt-partners-slider-section">
    <div class="container">
        
        <div class="govt-section-header">
            <div class="header-content">
                <span class="section-badge">
                    <i class="fas fa-landmark"></i>
                    <span><?php echo e(__('lang.government')); ?></span>
                </span>
                <h2 class="section-title"><?php echo e(__('lang.public_sector_collaboration')); ?></h2>
                <p class="section-subtitle"><?php echo e(__('lang.govt_partners_subtitle')); ?></p>
            </div>
            <div class="slider-nav-wrapper d-none d-lg-flex">
                <button class="govt-slider-prev slider-nav-btn">
                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>"></i>
                </button>
                <button class="govt-slider-next slider-nav-btn">
                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>"></i>
                </button>
            </div>
        </div>
        
        
        <div class="govt-partners-slider">
            <?php $__currentLoopData = $governmentPartners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="govt-partner-slide">
                <div class="govt-partner-card">
                    <div class="card-glow"></div>
                    <div class="partner-logo-wrapper">
                        <?php
                            $logoPath = null;
                            if (app()->getLocale() == 'ar' && $partner->logo_arabic) {
                                $logoPath = $partner->logo_arabic;
                            } elseif ($partner->logo_english) {
                                $logoPath = $partner->logo_english;
                            } elseif ($partner->logo_arabic) {
                                $logoPath = $partner->logo_arabic;
                            }
                        ?>
                        <?php if($logoPath): ?>
                        <img src="<?php echo e(url('/storage' . $logoPath)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $partner->name_arabic : $partner->name_english); ?>" 
                             class="partner-logo">
                        <?php else: ?>
                        <div class="partner-logo-placeholder">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="partner-info">
                        <h4 class="partner-name">
                            <?php echo e(app()->getLocale() == 'ar' ? $partner->name_arabic : $partner->name_english); ?>

                        </h4>
                        <span class="partner-type">
                            <i class="fas fa-shield-alt"></i>
                            <?php echo e(__('lang.government_entity')); ?>

                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="govt-slider-dots d-lg-none"></div>
    </div>
    
    
    <div class="govt-decoration govt-decoration-1"></div>
    <div class="govt-decoration govt-decoration-2"></div>
</section>

<style>
/* ===========================================
   Government Partners Slider Section
   =========================================== */
.govt-partners-slider-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    position: relative;
    overflow: hidden;
}

.govt-section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 50px;
}

.header-content {
    max-width: 600px;
}

.govt-partners-slider-section .section-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 24px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-radius: 50px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.govt-partners-slider-section .section-badge i {
    color: #19868b;
}

.govt-partners-slider-section .section-title {
    font-size: 42px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}

.govt-partners-slider-section .section-subtitle {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.7;
    margin: 0;
}

/* Slider Navigation */
.slider-nav-wrapper {
    display: flex;
    gap: 12px;
}

.slider-nav-btn {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 14px;
    color: #ffffff;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slider-nav-btn:hover {
    background: #19868b;
    border-color: #19868b;
    transform: translateY(-2px);
}

/* Partner Card */
.govt-partner-slide {
    padding: 10px;
    height: auto;
}

.govt-partner-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 35px 25px;
    text-align: center;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    height: 280px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.govt-partner-card:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(25, 134, 139, 0.4);
    transform: translateY(-8px);
}

.govt-partner-card .card-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #19868b 0%, #0d6b6f 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.govt-partner-card:hover .card-glow {
    opacity: 1;
}

.govt-partner-card .partner-logo-wrapper {
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 15px;
    transition: all 0.4s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.govt-partner-card:hover .partner-logo-wrapper {
    background: #ffffff;
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(25, 134, 139, 0.2);
}

.govt-partner-card .partner-logo {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: all 0.3s ease;
}

.govt-partner-card:hover .partner-logo {
    transform: scale(1.05);
}

.govt-partner-card .partner-logo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.govt-partner-card .partner-logo-placeholder i {
    font-size: 36px;
    color: rgba(255, 255, 255, 0.5);
}

.govt-partner-card .partner-info {
    position: relative;
    z-index: 2;
}

.govt-partner-card .partner-name {
    font-size: 16px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 10px;
    line-height: 1.4;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.govt-partner-card .partner-type {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #19868b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.govt-partner-card .partner-type i {
    font-size: 10px;
}

/* Slider Dots */
.govt-slider-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 30px;
}

.govt-slider-dots .slick-dots {
    display: flex !important;
    justify-content: center;
    gap: 8px;
    padding: 0;
    margin: 0;
    list-style: none;
}

.govt-slider-dots .slick-dots li {
    margin: 0;
}

.govt-slider-dots .slick-dots li button {
    width: 10px;
    height: 10px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    font-size: 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.govt-slider-dots .slick-dots li.slick-active button {
    background: #19868b;
    width: 28px;
    border-radius: 5px;
}

/* Background Decorations */
.govt-decoration {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.govt-decoration-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(25, 134, 139, 0.12) 0%, transparent 70%);
    top: -150px;
    right: -150px;
}

.govt-decoration-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(225, 39, 61, 0.08) 0%, transparent 70%);
    bottom: -100px;
    left: -100px;
}

/* Responsive */
@media (max-width: 991px) {
    .govt-partners-slider-section {
        padding: 70px 0;
    }
    
    .govt-section-header {
        flex-direction: column;
        align-items: flex-start;
        text-align: center;
    }
    
    .header-content {
        margin: 0 auto;
        text-align: center;
    }
    
    .govt-partners-slider-section .section-title {
        font-size: 32px;
    }
}

@media (max-width: 767px) {
    .govt-partners-slider-section .section-title {
        font-size: 26px;
    }
    
    .govt-partner-card {
        padding: 30px 20px;
        height: 250px;
    }
    
    .govt-partner-card .partner-logo-wrapper {
        width: 100px;
        height: 100px;
        padding: 12px;
    }
    
    .govt-partner-card .partner-name {
        font-size: 14px;
        min-height: 40px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $('.govt-partners-slider').length) {
        $('.govt-partners-slider').slick({
            dots: true,
            arrows: true,
            infinite: true,
            speed: 500,
            autoplay: true,
            autoplaySpeed: 3000,
            pauseOnHover: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            prevArrow: $('.govt-slider-prev'),
            nextArrow: $('.govt-slider-next'),
            appendDots: $('.govt-slider-dots'),
            rtl: $('html').attr('dir') === 'rtl',
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        arrows: false
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        arrows: false
                    }
                }
            ]
        });
    }
});
</script>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/government-partners.blade.php ENDPATH**/ ?>