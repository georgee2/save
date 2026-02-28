
<?php if(isset($allTeamMembers) && $allTeamMembers->count() > 0): ?>
<section class="about-team-section py-12">
    <div class="container">
        <div class="text-center mb-8" data-animate="fadeInUp">
            <div class="section-label justify-content-center">
                <span class="label-line"></span>
                <span class="label-text"><?php echo e(__('lang.meet_the_team')); ?></span>
                <span class="label-line"></span>
            </div>
            <h2 class="section-title"><?php echo e(__('lang.our_team')); ?></h2>
            <p class="section-subtitle"><?php echo e(__('lang.team_slider_bio')); ?></p>
        </div>
        
        
        <div class="about-team-slider slick-slider"
             data-slick-options='{"slidesToShow": 5, "slidesToScroll": 1, "autoplay": true, "autoplaySpeed": 2000, "speed": 500, "dots": true, "arrows": true, "infinite": true, "pauseOnHover": false, "responsive": [{"breakpoint": 1200, "settings": {"slidesToShow": 4}}, {"breakpoint": 992, "settings": {"slidesToShow": 3}}, {"breakpoint": 768, "settings": {"slidesToShow": 2}}, {"breakpoint": 480, "settings": {"slidesToShow": 1}}]}'>
            <?php $__currentLoopData = $allTeamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="about-team-slide px-2 pb-4">
                <div class="about-team-card d-block">
                    <div class="about-team-card-inner">
                        
                        <div class="about-team-icon mx-auto mb-3">
                            <?php if($member->icon): ?>
                            <img src="<?php echo e(asset('storage' . $member->icon)); ?>" 
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english); ?>">
                            <?php elseif($member->main_image): ?>
                            <img src="<?php echo e(asset('storage' . $member->main_image)); ?>" 
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english); ?>">
                            <?php else: ?>
                            <div class="about-team-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            <?php endif; ?>
                            
                            
                            <?php if($member->is_board_director): ?>
                            <div class="about-team-badge">
                                <i class="fas fa-star"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        
                        <h5 class="about-team-name">
                            <?php echo e(app()->getLocale() == 'ar' ? $member->name_arabic : $member->name_english); ?>

                        </h5>
                        
                        <?php if($member->jobTitle): ?>
                        <p class="about-team-job">
                            <?php echo e(app()->getLocale() == 'ar' ? $member->jobTitle->name_arabic : $member->jobTitle->name_english); ?>

                        </p>
                        <?php endif; ?>
                        
                        <?php if($member->rank): ?>
                        <p class="about-team-rank">
                            <?php echo e(app()->getLocale() == 'ar' ? $member->rank->name_arabic : $member->rank->name_english); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="text-center mt-8">
            <a href="<?php echo e(route('team.index')); ?>" class="btn-view-team">
                <?php echo e(__('lang.view_all_team')); ?>

                <i class="fas fa-arrow-right <?php echo e(app()->getLocale() == 'ar' ? 'fa-flip-horizontal' : ''); ?> ml-2"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/about/partials/team.blade.php ENDPATH**/ ?>