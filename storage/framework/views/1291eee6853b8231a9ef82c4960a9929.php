<?php $__env->startSection('title', 'Edit SEO - ' . $seoPage->page_name); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/css/tagify.css')); ?>">
<style>
    :root {
        --main-color: #19868b;
        --secondary-color: #0d6b6f;
        --accent-color: #e1273d;
    }
    .char-count {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    .char-count.error {
        color: #dc3545;
        font-weight: bold;
    }
    .section-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin: -20px -20px 20px -20px;
    }
    .form-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid var(--main-color);
    }
    .form-section h5 {
        color: var(--main-color);
        border-bottom: 2px solid var(--main-color);
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: var(--main-color) !important;
        border-color: var(--main-color) !important;
    }
    .btn-primary:hover {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
    }
    .page-badge {
        background: var(--main-color);
        color: #fff;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 14px;
        display: inline-block;
        margin-bottom: 15px;
    }
    .seo-preview-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
    }
    .seo-preview-box .preview-title {
        color: #1a0dab;
        font-size: 18px;
        font-weight: 400;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .seo-preview-box .preview-url {
        color: #006621;
        font-size: 13px;
        margin-bottom: 3px;
    }
    .seo-preview-box .preview-desc {
        color: #545454;
        font-size: 13px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('admin.seo-pages.index')); ?>" class="breadcrumbs__item"><i class="fa fa-search"></i> SEO Pages</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit <?php echo e($seoPage->page_name); ?></a>
        </nav>

        <div class="col-lg-12">
            <hr>

            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <h4 class="mt-0 mb-0"><i class="fa fa-pencil"></i> Edit SEO — <?php echo e($seoPage->page_name); ?></h4>
                        <small>Update SEO title, description and keywords for this page</small>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <span class="page-badge"><i class="fa fa-file-text-o"></i> <?php echo e($seoPage->page_name); ?> <small>(<?php echo e($seoPage->page_key); ?>)</small></span>

                    <form action="<?php echo e(route('admin.seo-pages.update', $seoPage->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        
                        <div class="form-section">
                            <h5><i class="fa fa-header"></i> SEO Title</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SEO Title (English) <small>(Max 70 characters recommended)</small></label>
                                        <input type="text" class="form-control char-counter-input" name="seo_title_english"
                                               value="<?php echo e(old('seo_title_english', $seoPage->seo_title_english)); ?>"
                                               maxlength="255" id="seo_title_english"
                                               placeholder="Enter page title for search engines...">
                                        <div class="char-count" id="seo_title_english_count">0 / 70 characters</div>
                                        <?php $__errorArgs = ['seo_title_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SEO Title (Arabic) <small>(Max 70 characters recommended)</small></label>
                                        <input type="text" class="form-control char-counter-input" name="seo_title_arabic"
                                               value="<?php echo e(old('seo_title_arabic', $seoPage->seo_title_arabic)); ?>"
                                               maxlength="255" dir="rtl" id="seo_title_arabic"
                                               placeholder="أدخل عنوان الصفحة لمحركات البحث...">
                                        <div class="char-count" id="seo_title_arabic_count">0 / 70 characters</div>
                                        <?php $__errorArgs = ['seo_title_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-section">
                            <h5><i class="fa fa-align-left"></i> SEO Description</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SEO Description (English) <small>(Max 160 characters recommended)</small></label>
                                        <textarea class="form-control char-counter-input" name="seo_description_english"
                                                  rows="4" maxlength="500" id="seo_description_english"
                                                  placeholder="Enter page description for search engines..."><?php echo e(old('seo_description_english', $seoPage->seo_description_english)); ?></textarea>
                                        <div class="char-count" id="seo_description_english_count">0 / 160 characters</div>
                                        <?php $__errorArgs = ['seo_description_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SEO Description (Arabic) <small>(Max 160 characters recommended)</small></label>
                                        <textarea class="form-control char-counter-input" name="seo_description_arabic"
                                                  rows="4" maxlength="500" dir="rtl" id="seo_description_arabic"
                                                  placeholder="أدخل وصف الصفحة لمحركات البحث..."><?php echo e(old('seo_description_arabic', $seoPage->seo_description_arabic)); ?></textarea>
                                        <div class="char-count" id="seo_description_arabic_count">0 / 160 characters</div>
                                        <?php $__errorArgs = ['seo_description_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-section">
                            <h5><i class="fa fa-tags"></i> SEO Keywords / Tags</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Keywords <small>(Press Enter or comma to add tags)</small></label>
                                        <input type="text" class="tagify-seo" name="seo_tags" value="<?php echo e(old('seo_tags', $seoPage->seo_tags)); ?>" placeholder="Add keywords...">
                                        <?php $__errorArgs = ['seo_tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-section">
                            <h5><i class="fa fa-google"></i> Search Preview (English)</h5>
                            <div class="seo-preview-box">
                                <div class="preview-title" id="previewTitle"><?php echo e($seoPage->seo_title_english ?? 'Page Title'); ?></div>
                                <div class="preview-url"><?php echo e(url('/')); ?>/...</div>
                                <div class="preview-desc" id="previewDesc"><?php echo e($seoPage->seo_description_english ?? 'Page description will appear here...'); ?></div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save"></i> Save SEO Settings
                            </button>
                            <a href="<?php echo e(route('admin.seo-pages.index')); ?>" class="btn btn-default btn-lg">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('/js/tagify.min.js')); ?>"></script>
<script>
$(document).ready(function() {
    if (document.querySelector('.tagify-seo')) {
        var tagInput = document.querySelector('.tagify-seo');
        new Tagify(tagInput, {
            delimiters: ",",
            maxTags: 50,
            dropdown: { enabled: 0 }
        });
    }

    function updateCharCount(inputId, countId, recommended) {
        var input = document.getElementById(inputId);
        var countDiv = document.getElementById(countId);

        if (input && countDiv) {
            function update() {
                var len = input.value.length;
                countDiv.textContent = len + ' / ' + recommended + ' characters';
                if (len > recommended) {
                    countDiv.classList.add('error');
                } else {
                    countDiv.classList.remove('error');
                }
            }
            update();
            input.addEventListener('input', update);
        }
    }

    updateCharCount('seo_title_english', 'seo_title_english_count', 70);
    updateCharCount('seo_title_arabic', 'seo_title_arabic_count', 70);
    updateCharCount('seo_description_english', 'seo_description_english_count', 160);
    updateCharCount('seo_description_arabic', 'seo_description_arabic_count', 160);

    // Live preview
    var titleInput = document.getElementById('seo_title_english');
    var descInput = document.getElementById('seo_description_english');
    var previewTitle = document.getElementById('previewTitle');
    var previewDesc = document.getElementById('previewDesc');

    if (titleInput && previewTitle) {
        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value || 'Page Title';
        });
    }
    if (descInput && previewDesc) {
        descInput.addEventListener('input', function() {
            previewDesc.textContent = this.value || 'Page description will appear here...';
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/seo-pages/edit.blade.php ENDPATH**/ ?>