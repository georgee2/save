<?php $__env->startSection('title', 'Edit Language Key'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/css/auto-translate.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('language.index')); ?>" class="breadcrumbs__item"><i class="fa fa-language"></i> Language Manager</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Language Key</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong>
                    <ul class="mb-0" style="margin-top: 10px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Language Key</h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('language.index')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Language Keys List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form action="<?php echo e(route('language.update', ['key' => $language['key']])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <!-- Language Key (Read-only) -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="key">Language Key <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="key" value="<?php echo e($language['key']); ?>" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                                    <small class="form-text text-muted">This is the unique identifier for this language string. It cannot be changed.</small>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- English Translation -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="english">English Translation <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="english" name="english" rows="4" required><?php echo e(old('english', $language['english'])); ?></textarea>
                                    <small class="form-text text-muted">Enter the English translation for this key.</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Arabic Translation -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="arabic">Arabic Translation <button type="button" class="auto-translate-btn" data-translate-source="english" data-translate-target="arabic"><i class="fa fa-language"></i> Auto</button> <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="arabic" name="arabic" rows="4" required style="direction: rtl; text-align: right;"><?php echo e(old('arabic', $language['arabic'])); ?></textarea>
                                    <small class="form-text text-muted">أدخل الترجمة العربية لهذا المفتاح.</small>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Preview Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h5><i class="fa fa-eye"></i> Preview</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>English:</strong>
                                            <p id="preview-english"><?php echo e($language['english']); ?></p>
                                        </div>
                                        <div class="col-md-6" style="direction: rtl; text-align: right;">
                                            <strong>:العربية</strong>
                                            <p id="preview-arabic"><?php echo e($language['arabic']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fa fa-save"></i> Update Language Key
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
<script>
    // Live preview
    document.getElementById('english').addEventListener('input', function() {
        document.getElementById('preview-english').textContent = this.value;
    });
    
    document.getElementById('arabic').addEventListener('input', function() {
        document.getElementById('preview-arabic').textContent = this.value;
    });
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Basicdata\resources/views/languages/edit.blade.php ENDPATH**/ ?>