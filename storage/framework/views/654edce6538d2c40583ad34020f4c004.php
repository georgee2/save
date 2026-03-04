<?php $__env->startSection('title', 'Edit Engineering Category'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/css/tagify.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/css/auto-translate.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Basicdata')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('engineeringcategory.index')); ?>" class="breadcrumbs__item"><i class="fa fa-list"></i> Engineering Categories List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Category</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Engineering Category</h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('engineeringcategory.index')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Engineering Categories List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="<?php echo e(route('engineeringcategory.update', ['id' => $category->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="<?php echo e(old('title_english', $category->title_english)); ?>" type="text" name="title_english">
                                <?php $__errorArgs = ['title_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="<?php echo e(old('title_arabic', $category->title_arabic)); ?>" type="text" name="title_arabic">
                                <?php $__errorArgs = ['title_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio English (Max 500 characters)</label>
                                <textarea class="form-control" id="bio_english" name="bio_english" rows="3" maxlength="500"><?php echo e(old('bio_english', $category->bio_english)); ?></textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_english_count">0</span> / 500 characters
                                </small>
                                <?php $__errorArgs = ['bio_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio Arabic (Max 500 characters) <button type="button" class="auto-translate-btn" data-translate-source="bio_english" data-translate-target="bio_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control" id="bio_arabic" name="bio_arabic" rows="3" maxlength="500"><?php echo e(old('bio_arabic', $category->bio_arabic)); ?></textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_arabic_count">0</span> / 500 characters
                                </small>
                                <?php $__errorArgs = ['bio_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Description (Max 1500 characters)</label>
                                <textarea class="form-control" id="description_english" name="description_english" rows="5" maxlength="1500"><?php echo e(old('description_english', $category->description_english)); ?></textarea>
                                <small class="form-text text-muted">
                                    <span id="description_english_count">0</span> / 1500 characters
                                </small>
                                <?php $__errorArgs = ['description_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Description (Max 1500 characters) <button type="button" class="auto-translate-btn" data-translate-source="description_english" data-translate-target="description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control" id="description_arabic" name="description_arabic" rows="5" maxlength="1500"><?php echo e(old('description_arabic', $category->description_arabic)); ?></textarea>
                                <small class="form-text text-muted">
                                    <span id="description_arabic_count">0</span> / 1500 characters
                                </small>
                                <?php $__errorArgs = ['description_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Icon <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input accept="image/*" class="form-control dropify" type="file" name="icon" 
                                    <?php if($category->icon): ?> data-default-file="<?php echo e(url('/storage'.$category->icon)); ?>" <?php endif; ?>>
                                <small class="form-text text-muted">
                                    <i class="fa fa-info-circle"></i> Recommended size: <strong>150px x 150px</strong>. Image will be automatically resized and converted to WebP format.
                                </small>
                                <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger mt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-danger">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="<?php echo e($category->seo_tags); ?>" class="tagify form-control">
                                <?php $__errorArgs = ['seo_tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description English</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars."><?php echo e($category->seo_description_english); ?></textarea>
                                <?php $__errorArgs = ['seo_description_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description Arabic <button type="button" class="auto-translate-btn" data-translate-source="seo_description_english" data-translate-target="seo_description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars."><?php echo e($category->seo_description_arabic); ?></textarea>
                                <?php $__errorArgs = ['seo_description_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5"
                                    onclick="window.history.back()">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('/js/auto-translate.js')); ?>"></script>
<script src="<?php echo e(asset('/js/tagify.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/dropify.min.js')); ?>"></script>
<script>
    $('.dropify').dropify();
</script>
<script>
    if(document.querySelectorAll('.tagify').length > 0){
        var input = document.querySelector('.tagify');
        new Tagify(input);
    }
</script>
<script>
    // Character counters
    function updateCharCount(textareaId, counterId) {
        const textarea = document.getElementById(textareaId);
        const counter = document.getElementById(counterId);
        
        if (textarea && counter) {
            // Update on page load
            counter.textContent = textarea.value.length;
            
            // Update on input
            textarea.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }
    }
    
    // Initialize character counters
    updateCharCount('bio_english', 'bio_english_count');
    updateCharCount('bio_arabic', 'bio_arabic_count');
    updateCharCount('description_english', 'description_english_count');
    updateCharCount('description_arabic', 'description_arabic_count');
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Basicdata\resources/views/engineeringcategories/edit.blade.php ENDPATH**/ ?>