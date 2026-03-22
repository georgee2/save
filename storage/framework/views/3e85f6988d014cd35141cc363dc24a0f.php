<?php $__env->startSection('title', 'Add New Job Posting'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('CRM')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('jobs-posting.index')); ?>" class="breadcrumbs__item"><i class="fa fa-list"></i> Jobs Postings List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New Job Posting</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Job Posting</h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('jobs-posting.index')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Jobs Postings List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="<?php echo e(route('jobs-posting.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Basic Information -->
                        <h5 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Job Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="job_title_id">
                                    <option selected disabled value="">Choose Job Title</option>
                                    <?php $__currentLoopData = $jobTitles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($title->id); ?>" <?php echo e(old('job_title_id') == $title->id ? 'selected' : ''); ?>>
                                            <?php echo e(App::getLocale() == 'en' ? $title->name_english : $title->name_arabic); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['job_title_id'];
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

                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Job Category <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="job_category_id">
                                    <option selected disabled value="">Choose Job Category</option>
                                    <?php $__currentLoopData = $jobCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('job_category_id') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e(App::getLocale() == 'en' ? $category->name_english : $category->name_arabic); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['job_category_id'];
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

                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Job Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="job_type">
                                    <option selected disabled value="">Choose Job Type</option>
                                    <option value="Contract" <?php echo e(old('job_type') == 'Contract' ? 'selected' : ''); ?>>Contract</option>
                                    <option value="Full Time" <?php echo e(old('job_type') == 'Full Time' ? 'selected' : ''); ?>>Full Time</option>
                                    <option value="Intern" <?php echo e(old('job_type') == 'Intern' ? 'selected' : ''); ?>>Intern</option>
                                    <option value="Hybrid" <?php echo e(old('job_type') == 'Hybrid' ? 'selected' : ''); ?>>Hybrid</option>
                                    <option value="Remotely" <?php echo e(old('job_type') == 'Remotely' ? 'selected' : ''); ?>>Remotely</option>
                                    <option value="Part-time" <?php echo e(old('job_type') == 'Part-time' ? 'selected' : ''); ?>>Part-time</option>
                                </select>
                                <?php $__errorArgs = ['job_type'];
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

                        <!-- Salary & Registration -->
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Salary</label>
                                <input class="form-control" value="<?php echo e(old('salary')); ?>" type="number" step="0.01" name="salary" placeholder="Enter Salary">
                                <?php $__errorArgs = ['salary'];
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

                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Show Salary <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="show_salary">
                                    <option value="1" <?php echo e(old('show_salary') == '1' ? 'selected' : ''); ?>>Yes</option>
                                    <option value="0" <?php echo e(old('show_salary') == '0' ? 'selected' : ''); ?> selected>No</option>
                                </select>
                                <?php $__errorArgs = ['show_salary'];
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

                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Registration Start Date <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="<?php echo e(old('registration_start_date')); ?>" type="date" name="registration_start_date">
                                <?php $__errorArgs = ['registration_start_date'];
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

                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Registration End Date <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="<?php echo e(old('registration_end_date')); ?>" type="date" name="registration_end_date">
                                <?php $__errorArgs = ['registration_end_date'];
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

                        <!-- Status & Icon -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="status">
                                    <option value="Publish" <?php echo e(old('status') == 'Publish' ? 'selected' : ''); ?>>Publish</option>
                                    <option value="Not Publish" <?php echo e(old('status') == 'Not Publish' ? 'selected' : ''); ?> selected>Not Publish</option>
                                </select>
                                <?php $__errorArgs = ['status'];
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
                                <label class="text-capitalize">Icon (100x100)</label>
                                <input class="form-control" type="file" name="icon" accept="image/*">
                                <small class="text-muted">Recommended size: 100x100 pixels</small>
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
                        
                        <!-- Job Description -->
                        <h5 class="text-primary mb-3"><i class="fa fa-file-text"></i> Job Description</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Job Description (English) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea id="elm1" class="form-control" name="job_description_en"><?php echo e(old('job_description_en')); ?></textarea>
                                <?php $__errorArgs = ['job_description_en'];
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

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Job Description (Arabic) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea id="elm2" class="form-control" name="job_description_ar"><?php echo e(old('job_description_ar')); ?></textarea>
                                <?php $__errorArgs = ['job_description_ar'];
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

                        <!-- Requirements -->
                        <h5 class="text-primary mb-3"><i class="fa fa-check-square"></i> Requirements (Optional)</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Requirements (English)</label>
                                <textarea id="elm3" class="form-control" name="requirements_en"><?php echo e(old('requirements_en')); ?></textarea>
                                <?php $__errorArgs = ['requirements_en'];
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

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Requirements (Arabic)</label>
                                <textarea id="elm4" class="form-control" name="requirements_ar"><?php echo e(old('requirements_ar')); ?></textarea>
                                <?php $__errorArgs = ['requirements_ar'];
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

                        <!-- Responsibilities -->
                        <h5 class="text-primary mb-3"><i class="fa fa-tasks"></i> Responsibilities (Optional)</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Responsibilities (English)</label>
                                <textarea id="elm5" class="form-control" name="responsibilities_en"><?php echo e(old('responsibilities_en')); ?></textarea>
                                <?php $__errorArgs = ['responsibilities_en'];
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

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Responsibilities (Arabic)</label>
                                <textarea id="elm6" class="form-control" name="responsibilities_ar"><?php echo e(old('responsibilities_ar')); ?></textarea>
                                <?php $__errorArgs = ['responsibilities_ar'];
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
                                    <i class="fa fa-save"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5" onclick="window.history.back()">
                                    <i class="fa fa-times"></i> Cancel
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


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/CRM\resources/views/jobs-postings/create.blade.php ENDPATH**/ ?>