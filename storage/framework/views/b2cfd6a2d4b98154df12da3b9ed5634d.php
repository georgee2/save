
<?php if(isset($services) && count($services) > 0): ?>
<section class="pt-lg-12 pb-lg-11 py-11 services-section">
    <div class="container container-xxl">
        <div class="row align-items-center mb-6">
            <div class="col-md-7">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13"><?php echo e(__('lang.what_we_do')); ?></span>
                <h2 class="text-heading mt-2 mb-0"><?php echo e(__('lang.our_services')); ?></h2>
                <span class="heading-divider"></span>
                <p class="mb-0"><?php echo e(__('lang.services_bio')); ?></p>
            </div>
            <div class="col-md-5 text-md-right mt-4 mt-md-0">
                <a href="<?php echo e(route('services.index')); ?>" class="btn fs-14 text-secondary btn-accent py-3 lh-15 px-7 mb-6 mb-lg-0">
                    <?php echo e(__('lang.view_all_services')); ?>

                    <i class="far fa-long-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        <div class="slick-slider services-slider custom-arrow-spacing-30"
            data-slick-options='{"slidesToShow": 3,"dots":true,"arrows":false,"autoplay":true,"autoplaySpeed":5000,"responsive":[{"breakpoint": 1400,"settings": {"slidesToShow":3}},{"breakpoint": 1200,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":true}}]}'>
            
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box pb-7 pt-2 px-2" data-animate="fadeInUp">
                <div class="service-card position-relative rounded-lg overflow-hidden shadow-hover-3">
                    
                    <div class="service-card-image position-relative">
                        <a href="<?php echo e(route('services.show', $service->slug)); ?>">
                            <?php if($service->main_image): ?>
                            <img src="<?php echo e(url('/storage' . $service->main_image)); ?>" 
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english); ?>"
                                 class="w-100">
                            <?php else: ?>
                            <div class="service-placeholder-image w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-cogs fa-4x text-primary opacity-50"></i>
                            </div>
                            <?php endif; ?>
                        </a>
                        
                        
                        <div class="service-gradient-overlay"></div>
                        
                        
                        <?php if($service->icon): ?>
                        <div class="service-icon-badge">
                            <img src="<?php echo e(url('/storage' . $service->icon)); ?>" 
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    
                    <div class="service-card-body bg-white p-4">
                        
                        <h3 class="service-title fs-18 font-weight-600 lh-14 mb-2">
                            <a href="<?php echo e(route('services.show', $service->slug)); ?>" class="text-heading hover-primary">
                                <?php echo e(app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english); ?>

                            </a>
                        </h3>
                        
                        
                        <?php
                            $bio = app()->getLocale() == 'ar' ? $service->bio_arabic : $service->bio_english;
                        ?>
                        <?php if($bio): ?>
                        <p class="service-bio text-gray-light fs-14 mb-0">
                            <?php echo e(\Illuminate\Support\Str::limit(strip_tags($bio), 100)); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                    
                    
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                        <span class="text-primary font-weight-500 fs-13">
                            <i class="far fa-cog mr-1"></i>
                            <?php echo e(__('lang.service')); ?>

                        </span>
                        <a href="<?php echo e(route('services.show', $service->slug)); ?>" 
                           class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                            <?php echo e(__('lang.learn_more')); ?>

                            <i class="far fa-long-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/services.blade.php ENDPATH**/ ?>