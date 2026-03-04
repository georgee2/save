<?php $__env->startSection('title', 'Add New Floor Component'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/css/auto-translate.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Basicdata')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('floorcomponent.index')); ?>" class="breadcrumbs__item"><i class="fa fa-list"></i> Floor Components List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New Floor Component</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Floor Component</h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('floorcomponent.index')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Floor Components List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="<?php echo e(route('floorcomponent.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="project_type_id" id="project_type_id" required>
                                    <option value="">Select Project Type</option>
                                    <?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($projectType->id); ?>" <?php echo e(old('project_type_id') == $projectType->id ? 'selected' : ''); ?>>
                                            <?php echo e($projectType->name_english); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['project_type_id'];
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
                                <label class="text-capitalize">Building Component <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="component_id" id="component_id" required>
                                    <option value="">Select Building Component</option>
                                    <?php $__currentLoopData = $buildingComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($component->id); ?>" data-project-type="<?php echo e($component->project_type_id); ?>" <?php echo e(old('component_id') == $component->id ? 'selected' : ''); ?>>
                                            <?php echo e($component->name_english); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['component_id'];
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
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="<?php echo e(old('name_english')); ?>" type="text" name="name_english">
                                <?php $__errorArgs = ['name_english'];
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
                                <label class="text-capitalize">Arabic Name <button type="button" class="auto-translate-btn" data-translate-source="name_english" data-translate-target="name_arabic"><i class="fa fa-language"></i> Auto</button> <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="<?php echo e(old('name_arabic')); ?>" type="text" name="name_arabic">
                                <?php $__errorArgs = ['name_arabic'];
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
                                <input accept="image/*" class="form-control dropify" type="file" name="icon">
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
<script src="<?php echo e(asset('/js/dropify.min.js')); ?>"></script>
<script>
    $('.dropify').dropify();
    
    // Filter building components based on selected project type
    $('#project_type_id').on('change', function() {
        var projectTypeId = $(this).val();
        var componentSelect = $('#component_id');
        
        if (projectTypeId) {
            componentSelect.find('option').each(function() {
                var option = $(this);
                if (option.val() === '') {
                    option.show();
                } else if (option.data('project-type') == projectTypeId) {
                    option.show();
                } else {
                    option.hide();
                }
            });
            componentSelect.val('').trigger('change');
        } else {
            componentSelect.find('option').show();
            componentSelect.val('').trigger('change');
        }
    });
    
    // Trigger on page load if project type is already selected
    if ($('#project_type_id').val()) {
        $('#project_type_id').trigger('change');
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Basicdata\resources/views/floorcomponents/create.blade.php ENDPATH**/ ?>