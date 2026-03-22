<?php $__env->startSection('title', __('lang.careers')); ?>

<?php $__env->startSection('seo_desc', __('lang.careers_seo_desc')); ?>

<?php $__env->startSection('seo_tags', __('lang.careers')); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/careers-page.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<section class="careers-hero-section position-relative">
    <?php if($pageBanner && $pageBanner->cover): ?>
    <div class="careers-hero-bg" style="background-image: url('<?php echo e(asset($pageBanner->cover)); ?>');"></div>
    <?php else: ?>
    <div class="careers-hero-bg careers-hero-gradient"></div>
    <?php endif; ?>
    <div class="careers-hero-overlay"></div>
    <div class="container position-relative">
        <div class="careers-hero-content text-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('lang.home')); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('lang.careers')); ?></li>
                </ol>
            </nav>
            <h1 class="careers-hero-title"><?php echo e(__('lang.join_our_team')); ?></h1>
            <p class="careers-hero-subtitle"><?php echo e(__('lang.careers_subtitle')); ?></p>
        </div>
    </div>
</section>

<?php if($jobs->count() > 0): ?>


<section class="careers-intro-section py-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-badge mb-3">
                    <span class="badge-line"></span>
                    <span class="badge-text"><?php echo e(__('lang.work_with_us')); ?></span>
                    <span class="badge-line"></span>
                </div>
                <h2 class="section-title mb-4"><?php echo e(__('lang.build_your_future')); ?></h2>
                <p class="section-description"><?php echo e(__('lang.careers_intro_text')); ?></p>
            </div>
        </div>
    </div>
</section>


<section class="careers-stats-section py-8">
    <div class="container">
        <div class="stats-wrapper">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fal fa-users"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">50+</span>
                    <span class="stat-label"><?php echo e(__('lang.team_members')); ?></span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fal fa-briefcase"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number"><?php echo e($jobs->total()); ?></span>
                    <span class="stat-label"><?php echo e(__('lang.open_positions')); ?></span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fal fa-globe"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">UAE</span>
                    <span class="stat-label"><?php echo e(__('lang.location')); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="careers-positions-section py-12">
    <div class="container">
        <div class="section-header text-center mb-8">
            <div class="section-badge mb-3">
                <span class="badge-line"></span>
                <span class="badge-text"><?php echo e(__('lang.opportunities')); ?></span>
                <span class="badge-line"></span>
            </div>
            <h2 class="section-title"><?php echo e(__('lang.open_positions')); ?></h2>
            <p class="section-subtitle"><?php echo e(__('lang.find_your_role')); ?></p>
        </div>

        <div class="jobs-grid">
            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="job-card" data-animate="fadeInUp">
                <div class="job-card-header">
                    <div class="job-icon">
                        <?php if($job->icon): ?>
                        <img src="<?php echo e(asset('storage' . $job->icon)); ?>" alt="">
                        <?php else: ?>
                        <i class="fal fa-briefcase"></i>
                        <?php endif; ?>
                    </div>
                    <div class="job-type-badge <?php echo e(strtolower(str_replace(' ', '-', $job->job_type))); ?>">
                        <?php echo e($job->job_type); ?>

                    </div>
                </div>
                
                <div class="job-card-body">
                    <span class="job-category">
                        <?php echo e(app()->getLocale() == 'ar' ? $job->job_category_arabic : $job->job_category_english); ?>

                    </span>
                    <h3 class="job-title">
                        <a href="<?php echo e(route('careers.show', $job->id)); ?>">
                            <?php echo e(app()->getLocale() == 'ar' ? $job->job_title_arabic : $job->job_title_english); ?>

                        </a>
                    </h3>
                    <p class="job-description">
                        <?php echo Str::limit(strip_tags(app()->getLocale() == 'ar' ? $job->job_description_ar : $job->job_description_en), 120); ?>

                    </p>
                </div>
                
                <div class="job-card-footer">
                    <div class="job-meta">
                        <div class="job-meta-item">
                            <i class="fal fa-calendar-alt"></i>
                            <span><?php echo e(__('lang.deadline')); ?>: <?php echo e(\Carbon\Carbon::parse($job->registration_end_date)->format('M d, Y')); ?></span>
                        </div>
                        <?php if($job->show_salary && $job->salary): ?>
                        <div class="job-meta-item">
                            <i class="fal fa-money-bill-alt"></i>
                            <span><?php echo e(number_format($job->salary, 0)); ?> AED</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo e(route('careers.show', $job->id)); ?>" class="job-apply-btn">
                        <span><?php echo e(__('lang.view_details')); ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="job-code"><?php echo e($job->code); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($jobs->hasPages()): ?>
        <div class="careers-pagination mt-8">
            <?php echo e($jobs->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</section>


<section class="careers-benefits-section py-12">
    <div class="container">
        <div class="section-header text-center mb-8">
            <div class="section-badge mb-3">
                <span class="badge-line"></span>
                <span class="badge-text"><?php echo e(__('lang.benefits')); ?></span>
                <span class="badge-line"></span>
            </div>
            <h2 class="section-title"><?php echo e(__('lang.why_join_us')); ?></h2>
        </div>
        
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fal fa-chart-line"></i>
                </div>
                <h4 class="benefit-title"><?php echo e(__('lang.career_growth')); ?></h4>
                <p class="benefit-text"><?php echo e(__('lang.career_growth_desc')); ?></p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fal fa-graduation-cap"></i>
                </div>
                <h4 class="benefit-title"><?php echo e(__('lang.learning_development')); ?></h4>
                <p class="benefit-text"><?php echo e(__('lang.learning_development_desc')); ?></p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fal fa-heart"></i>
                </div>
                <h4 class="benefit-title"><?php echo e(__('lang.work_life_balance')); ?></h4>
                <p class="benefit-text"><?php echo e(__('lang.work_life_balance_desc')); ?></p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fal fa-hand-holding-usd"></i>
                </div>
                <h4 class="benefit-title"><?php echo e(__('lang.competitive_salary')); ?></h4>
                <p class="benefit-text"><?php echo e(__('lang.competitive_salary_desc')); ?></p>
            </div>
        </div>
    </div>
</section>


<section class="careers-cta-section py-12">
    <div class="container">
        <div class="cta-wrapper">
            <div class="cta-content">
                <h3 class="cta-title"><?php echo e(__('lang.dont_see_position')); ?></h3>
                <p class="cta-text"><?php echo e(__('lang.submit_resume_text')); ?></p>
            </div>
            <div class="cta-actions">
                <a href="<?php echo e(route('contact')); ?>" class="cta-btn-primary">
                    <i class="fal fa-paper-plane"></i>
                    <span><?php echo e(__('lang.submit_resume')); ?></span>
                </a>
                <a href="<?php echo e(route('contact')); ?>" class="cta-btn-secondary">
                    <i class="fal fa-envelope"></i>
                    <span><?php echo e(__('lang.contact_hr')); ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php else: ?>


<section class="py-12">
    <div class="container">
        <div class="text-center py-10">
            <div style="font-size: 80px; color: #dee2e6; margin-bottom: 30px;">
                <i class="fal fa-briefcase"></i>
            </div>
            <h2 style="color: #2c3e50; font-weight: 600; margin-bottom: 15px;"><?php echo e(__('lang.no_open_positions')); ?></h2>
            <p style="color: #6c757d; font-size: 18px; max-width: 500px; margin: 0 auto 30px;"><?php echo e(__('lang.no_positions_desc')); ?></p>
            <a href="<?php echo e(route('contact')); ?>" class="btn" style="background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); color: white; padding: 12px 30px; border-radius: 8px; font-weight: 500; font-size: 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fal fa-envelope"></i>
                <?php echo e(__('lang.contact_us')); ?>

            </a>
        </div>
    </div>
</section>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/careers/index.blade.php ENDPATH**/ ?>