
<section class="contact-hero-section position-relative">
    <?php if($pageBanner && $pageBanner->cover): ?>
    <div class="contact-hero-bg" style="background-image: url('<?php echo e(asset($pageBanner->cover)); ?>');"></div>
    <?php else: ?>
    <div class="contact-hero-bg contact-hero-gradient"></div>
    <?php endif; ?>
    <div class="contact-hero-overlay"></div>
    <div class="container position-relative">
        <div class="contact-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('lang.home')); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('lang.contact_us')); ?></li>
                </ol>
            </nav>
            <h1 class="contact-hero-title"><?php echo e(__('lang.contact_us_title')); ?></h1>
            <p class="contact-hero-subtitle"><?php echo e(__('lang.contact_us_subtitle')); ?></p>
        </div>
    </div>
</section>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/contact/partials/hero.blade.php ENDPATH**/ ?>