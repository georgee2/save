<?php $__env->startSection('title', __('lang.contact_us_title')); ?>

<?php $__env->startSection('seo_desc', $contactInfo->seo_description_english ?? __('lang.contact_us_seo_desc')); ?>

<?php $__env->startSection('seo_tags', $contactInfo->tags ?? __('lang.contact_us')); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/contact-page.css')); ?>?v=<?php echo e(time()); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/branches-page.css')); ?>?v=<?php echo e(time()); ?>">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(isset($sections) && $sections->count() > 0): ?>
    
    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($section->blade_partial && View::exists($section->blade_partial)): ?>
            <?php echo $__env->make($section->blade_partial, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    
    <?php echo $__env->make('pages.contact.partials.hero', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pages.contact.partials.info-cards', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pages.contact.partials.company-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pages.contact.partials.form-map', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pages.contact.partials.branches', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pages.contact.partials.cta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if(config('services.recaptcha.site_key')): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo e(config('services.recaptcha.site_key')); ?>"></script>
<?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: '<?php echo e(__("lang.message_sent_title")); ?>',
            text: '<?php echo e(session("success")); ?>',
            confirmButtonColor: '#19868b',
            confirmButtonText: '<?php echo e(__("lang.ok")); ?>',
            timer: 5000,
            timerProgressBar: true
        });
    <?php endif; ?>
    
    <?php if($errors->any()): ?>
        Swal.fire({
            icon: 'error',
            title: '<?php echo e(__("lang.form_error_title")); ?>',
            html: '<ul style="text-align: left; list-style: disc; padding-left: 20px;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>',
            confirmButtonColor: '#e1273d',
            confirmButtonText: '<?php echo e(__("lang.ok")); ?>'
        });
    <?php endif; ?>
    
    var recaptchaSiteKey = '<?php echo e(config("services.recaptcha.site_key")); ?>';

    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            var submitBtn = this.querySelector('.btn-submit');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> <?php echo e(__("lang.sending")); ?>...';
            submitBtn.disabled = true;
            
            Swal.fire({
                title: '<?php echo e(__("lang.sending_message")); ?>',
                html: '<?php echo e(__("lang.please_wait")); ?>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function() { Swal.showLoading(); }
            });

            if (recaptchaSiteKey && typeof grecaptcha !== 'undefined') {
                e.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute(recaptchaSiteKey, {action: 'contact_form'}).then(function(token) {
                        document.getElementById('contactRecaptchaToken').value = token;
                        contactForm.submit();
                    });
                });
            }
        });
    }
    
    var observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(function() { entry.target.classList.add('animated'); }, delay);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('[data-animate]').forEach(function(el) {
        observer.observe(el);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/contact/contact.blade.php ENDPATH**/ ?>