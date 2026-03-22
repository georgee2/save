<?php $__env->startSection('title', __('lang.shared_favourites')); ?>
<?php $__env->startSection('seo_desc', __('lang.shared_favourites')); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/favourites-page.css')); ?>?v=1.4">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="favourites-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('lang.home')); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('lang.shared_favourites')); ?></li>
            </ol>
        </nav>
        <h1><i class="fal fa-share-alt"></i> <?php echo e(__('lang.shared_favourites')); ?></h1>
        <p><?php echo e($totalCount); ?> <?php echo e(__('lang.favourite_items')); ?></p>
    </div>
</section>

<section class="favourites-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                
                <div class="fav-toolbar d-flex align-items-center flex-wrap mb-3">
                    <div class="fav-tabs">
                        <button class="fav-tab active" data-target="all">
                            <?php echo e(__('lang.all') ?? 'All'); ?>

                            <span class="tab-count"><?php echo e($totalCount); ?></span>
                        </button>
                        <?php if($grouped['projects']->count() > 0): ?>
                        <button class="fav-tab" data-target="projects">
                            <i class="fal fa-building"></i>
                            <?php echo e(__('lang.favourite_projects')); ?>

                            <span class="tab-count"><?php echo e($grouped['projects']->count()); ?></span>
                        </button>
                        <?php endif; ?>
                        <?php if($grouped['offers']->count() > 0): ?>
                        <button class="fav-tab" data-target="offers">
                            <i class="fal fa-tags"></i>
                            <?php echo e(__('lang.favourite_offers')); ?>

                            <span class="tab-count"><?php echo e($grouped['offers']->count()); ?></span>
                        </button>
                        <?php endif; ?>
                        <?php if($grouped['interiors']->count() > 0): ?>
                        <button class="fav-tab" data-target="interiors">
                            <i class="fal fa-paint-roller"></i>
                            <?php echo e(__('lang.favourite_interior')); ?>

                            <span class="tab-count"><?php echo e($grouped['interiors']->count()); ?></span>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php if($grouped['projects']->count() > 0): ?>
                <div class="fav-section" data-section="projects">
                    <?php $__currentLoopData = $grouped['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $project = $fav->itemData; ?>
                    <div class="fav-item">
                        <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="fav-item-image">
                            <img src="<?php echo e(url('/storage' . $project->main_image)); ?>" alt="<?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>">
                        </a>
                        <div class="fav-item-body">
                            <span class="fav-type-badge project"><?php echo e(__('lang.projects')); ?></span>
                            <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="fav-item-title">
                                <?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>

                            </a>
                            <div class="fav-item-meta">
                                <?php if($project->category): ?>
                                <span><i class="fal fa-folder"></i> <?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?></span>
                                <?php endif; ?>
                                <?php if($project->emirate): ?>
                                <span><i class="fal fa-map-marker-alt"></i> <?php echo e(app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                
                <?php if($grouped['offers']->count() > 0): ?>
                <div class="fav-section" data-section="offers">
                    <?php $__currentLoopData = $grouped['offers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $offer = $fav->itemData; ?>
                    <div class="fav-item">
                        <a href="<?php echo e(route('offers.show', $offer->slug)); ?>" class="fav-item-image">
                            <img src="<?php echo e(url('/storage' . $offer->main_image)); ?>" alt="<?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?>">
                        </a>
                        <div class="fav-item-body">
                            <span class="fav-type-badge offer"><?php echo e(__('lang.offers')); ?></span>
                            <a href="<?php echo e(route('offers.show', $offer->slug)); ?>" class="fav-item-title">
                                <?php echo e(app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english); ?>

                            </a>
                            <div class="fav-item-meta">
                                <?php if($offer->category): ?>
                                <span><i class="fal fa-folder"></i> <?php echo e(app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english); ?></span>
                                <?php endif; ?>
                                <?php if(isset($fav->selectedPrice) && $fav->selectedPrice): ?>
                                <span><i class="fal fa-map-marker-alt"></i> <?php echo e(app()->getLocale() == 'ar' ? $fav->selectedPrice->emirate->title_arabic : $fav->selectedPrice->emirate->title_english); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if($fav->price): ?>
                            <div class="fav-item-price">
                                <?php echo e(number_format($fav->price)); ?> <?php echo e($offer->currency ? $offer->currency->code : 'AED'); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                
                <?php if($grouped['interiors']->count() > 0): ?>
                <div class="fav-section" data-section="interiors">
                    <?php $__currentLoopData = $grouped['interiors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $interior = $fav->itemData; ?>
                    <div class="fav-item">
                        <div class="fav-item-image">
                            <img src="<?php echo e(url('/storage' . $interior->image)); ?>" alt="<?php echo e(app()->getLocale() == 'ar' ? $interior->title_arabic : $interior->title_english); ?>">
                        </div>
                        <div class="fav-item-body">
                            <span class="fav-type-badge interior"><?php echo e(__('lang.interior_design') ?? 'Interior'); ?></span>
                            <span class="fav-item-title">
                                <?php echo e(app()->getLocale() == 'ar' ? $interior->title_arabic : $interior->title_english); ?>

                            </span>
                            <div class="fav-item-meta">
                                <?php if($interior->category): ?>
                                <span><i class="fal fa-folder"></i> <?php echo e(app()->getLocale() == 'ar' ? $interior->category->title_arabic : $interior->category->title_english); ?></span>
                                <?php endif; ?>
                                <?php if($interior->projectStyle): ?>
                                <span><i class="fal fa-palette"></i> <?php echo e(app()->getLocale() == 'ar' ? $interior->projectStyle->title_arabic : $interior->projectStyle->title_english); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.fav-tab');
    var sections = document.querySelectorAll('.fav-section');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            var target = tab.getAttribute('data-target');

            sections.forEach(function(section) {
                if (target === 'all') {
                    section.style.display = '';
                } else {
                    section.style.display = section.getAttribute('data-section') === target ? '' : 'none';
                }
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/favourites/shared.blade.php ENDPATH**/ ?>