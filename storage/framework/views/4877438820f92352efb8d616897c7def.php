
<section class="about-hero-section position-relative">
    <?php if($aboutInfo->page_cover_image): ?>
    <div class="about-hero-bg" style="background-image: url('<?php echo e(asset('storage' . $aboutInfo->page_cover_image)); ?>');"></div>
    <?php else: ?>
    <div class="about-hero-bg about-hero-gradient"></div>
    <?php endif; ?>
    <div class="about-hero-overlay"></div>
    <div class="container position-relative">
        <div class="about-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('lang.home')); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('lang.about_us')); ?></li>
                </ol>
            </nav>
            <h1 class="about-hero-title">
                <?php echo e(app()->getLocale() == 'ar' ? ($aboutInfo->title_arabic ?? __('lang.about_us')) : ($aboutInfo->title_english ?? __('lang.about_us'))); ?>

            </h1>
            <?php if($aboutInfo->subtitle_english || $aboutInfo->subtitle_arabic): ?>
            <p class="about-hero-subtitle">
                <?php echo e(app()->getLocale() == 'ar' ? $aboutInfo->subtitle_arabic : $aboutInfo->subtitle_english); ?>

            </p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/hero.blade.php ENDPATH**/ ?>