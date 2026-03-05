<?php $__env->startSection('title', 'Edit Project'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/css/tagify.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/css/auto-translate.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('project.index')); ?>" class="breadcrumbs__item"><i class="fa fa-building"></i> Projects</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Project</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
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
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Project: <?php echo e($project->title_english); ?></h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('project.index')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Projects List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="<?php echo e(route('project.update', ['id' => $project->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <!-- Basic Information -->
                        <h5 class="mb-3 text-primary">Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="<?php echo e(old('title_english', $project->title_english)); ?>" type="text" name="title_english" required>
                                <?php $__errorArgs = ['title_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="<?php echo e(old('title_arabic', $project->title_arabic)); ?>" type="text" name="title_arabic" required>
                                <?php $__errorArgs = ['title_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Number</label>
                                <input class="form-control" value="<?php echo e(old('project_number', $project->project_number)); ?>" type="text" name="project_number" placeholder="e.g., 001, 2024-001">
                                <small class="form-text text-muted">Enter project number. Project Code will be auto-generated as: <strong>CATEGORY-SUBCATEGORY-NUMBER</strong></small>
                                <?php $__errorArgs = ['project_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Classifications -->
                        <h5 class="mb-3 mt-4 text-primary">Classifications</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Engineering Category <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="category_id" id="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $project->category_id) == $category->id ? 'selected' : ''); ?>><?php echo e($category->title_english); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Engineering Sub Category</label>
                                <select class="form-control select2" name="subcategory_id" id="subcategory_id">
                                    <option value="">Select Sub Category</option>
                                    <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subcategory->id); ?>" <?php echo e(old('subcategory_id', $project->subcategory_id) == $subcategory->id ? 'selected' : ''); ?>><?php echo e($subcategory->title_english); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Project Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="type_id" required>
                                    <option value="">Select Type</option>
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php echo e(old('type_id', $project->type_id) == $type->id ? 'selected' : ''); ?>><?php echo e($type->name_english); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Project Style</label>
                                <select class="form-control select2" name="style_id">
                                    <option value="">Select Style</option>
                                    <?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($style->id); ?>" <?php echo e(old('style_id', $project->style_id) == $style->id ? 'selected' : ''); ?>><?php echo e($style->title_english); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['style_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Currency</label>
                                <select class="form-control select2" name="currency_id">
                                    <option value="">Select Currency</option>
                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currency->id); ?>" <?php echo e(old('currency_id', $project->currency_id) == $currency->id ? 'selected' : ''); ?>><?php echo e($currency->name_english); ?> (<?php echo e($currency->abbreviation); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['currency_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Partner</label>
                                <select class="form-control select2" name="partner_id">
                                    <option value="">Select Partner</option>
                                    <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($partner->id); ?>" <?php echo e(old('partner_id', $project->partner_id) == $partner->id ? 'selected' : ''); ?>><?php echo e($partner->name_english); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['partner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Emirate</label>
                                <select class="form-control select2" name="emirate_id">
                                    <option value="">Select Emirate</option>
                                    <?php $__currentLoopData = $emirates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emirate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($emirate->id); ?>" <?php echo e(old('emirate_id', $project->emirate_id) == $emirate->id ? 'selected' : ''); ?>><?php echo e($emirate->title_english); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['emirate_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Area Measurements -->
                        <h5 class="mb-3 mt-4 text-primary">Area Measurements</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Square Feet (SQFT)</label>
                                <input class="form-control" value="<?php echo e(old('sqft', $project->sqft)); ?>" type="number" step="0.01" name="sqft" id="sqft" placeholder="Enter area in square feet">
                                <small class="form-text text-muted">Enter value - SQM will be calculated automatically</small>
                                <?php $__errorArgs = ['sqft'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Square Meters (SQM) <span class="badge badge-info">Auto-calculated</span></label>
                                <input class="form-control" value="<?php echo e(old('sqm', $project->sqm)); ?>" type="number" step="0.01" name="sqm" id="sqm" placeholder="Auto-calculated from SQFT" readonly>
                                <small class="form-text text-muted">1 SQFT = 0.092903 SQM</small>
                                <?php $__errorArgs = ['sqm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- URLs -->
                        <h5 class="mb-3 mt-4 text-primary">Media URLs</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Video URL</label>
                                <input class="form-control" value="<?php echo e(old('video_url', $project->video_url)); ?>" type="url" name="video_url" placeholder="https://youtube.com/...">
                                <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Virtual Tour URL</label>
                                <input class="form-control" value="<?php echo e(old('tour_url', $project->tour_url)); ?>" type="url" name="tour_url" placeholder="https://...">
                                <?php $__errorArgs = ['tour_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Images -->
                        <h5 class="mb-3 mt-4 text-primary">Project Images</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Main Image (1080x1080)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="main_image" data-default-file="<?php echo e(asset('storage' . $project->main_image)); ?>">
                                <small class="form-text text-muted">Leave empty to keep current image. Recommended: 1080x1080 pixels. Will be converted to WebP with 80% quality.</small>
                                <?php $__errorArgs = ['main_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Site Image (1080x1080)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="site_image" data-default-file="<?php echo e($project->site_image ? asset('storage' . $project->site_image) : ''); ?>">
                                <small class="form-text text-muted">Recommended: 1080x1080 pixels. Will be converted to WebP.</small>
                                <?php $__errorArgs = ['site_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project File (PDF)</label>
                                <input accept=".pdf,application/pdf" class="form-control dropify" type="file" name="plan_2d_image">
                                <?php if($project->plan_2d_image): ?>
                                    <small class="form-text text-muted">Current file: <a href="<?php echo e(asset('storage' . $project->plan_2d_image)); ?>" target="_blank">View PDF</a></small>
                                <?php endif; ?>
                                <small class="form-text text-muted">Upload project file in PDF format. Max size: 10MB.</small>
                                <?php $__errorArgs = ['plan_2d_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">3D Image (1080x1080)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="plan_3d_image" data-default-file="<?php echo e($project->plan_3d_image ? asset('storage' . $project->plan_3d_image) : ''); ?>">
                                <small class="form-text text-muted">Recommended: 1080x1080 pixels. Will be converted to WebP.</small>
                                <?php $__errorArgs = ['plan_3d_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Bio -->
                        <h5 class="mb-3 mt-4 text-primary">Bio (Short Description)</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio English (Max 500 characters)</label>
                                <textarea class="form-control" id="bio_english" name="bio_english" rows="3" maxlength="500"><?php echo e(old('bio_english', $project->bio_english)); ?></textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_english_count">0</span> / 500 characters
                                </small>
                                <?php $__errorArgs = ['bio_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio Arabic (Max 500 characters) <button type="button" class="auto-translate-btn" data-translate-source="bio_english" data-translate-target="bio_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control" id="bio_arabic" name="bio_arabic" rows="3" maxlength="500"><?php echo e(old('bio_arabic', $project->bio_arabic)); ?></textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_arabic_count">0</span> / 500 characters
                                </small>
                                <?php $__errorArgs = ['bio_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Full Description -->
                        <h5 class="mb-3 mt-4 text-primary">Full Description</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description English (Max 3000 characters)</label>
                                <textarea id="elm1" class="form-control" name="description_english"><?php echo old('description_english', $project->description_english); ?></textarea>
                                <?php $__errorArgs = ['description_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description Arabic (Max 3000 characters) <button type="button" class="auto-translate-btn" data-translate-source="description_english" data-translate-target="description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea id="elm2" class="form-control" name="description_arabic"><?php echo old('description_arabic', $project->description_arabic); ?></textarea>
                                <?php $__errorArgs = ['description_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Location & Cost -->
                        <h5 class="mb-3 mt-4 text-primary">Location & Cost</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Location (English)</label>
                                <input class="form-control" value="<?php echo e(old('location_english', $project->location_english)); ?>" type="text" name="location_english" placeholder="e.g., Dubai Marina, UAE">
                                <?php $__errorArgs = ['location_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Location (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="location_english" data-translate-target="location_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="<?php echo e(old('location_arabic', $project->location_arabic)); ?>" type="text" name="location_arabic" placeholder="e.g., دبي مارينا، الإمارات">
                                <?php $__errorArgs = ['location_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Cost</label>
                                <input class="form-control" value="<?php echo e(old('project_cost', $project->project_cost)); ?>" type="number" step="0.01" name="project_cost" placeholder="Enter project cost">
                                <small class="form-text text-muted">Enter the total project cost (optional)</small>
                                <?php $__errorArgs = ['project_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <?php if($project->project_code): ?>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Code <span class="badge badge-info">Auto-generated</span></label>
                                <input class="form-control" value="<?php echo e($project->project_code); ?>" type="text" readonly style="background-color: #f8f9fa; font-weight: bold; color: #19868b;">
                                <small class="form-text text-muted">Format: CATEGORY-SUBCATEGORY-NUMBER (Auto-updated when category, subcategory, or project number changes)</small>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- SEO -->
                        <h5 class="mb-3 mt-4 text-primary">SEO Information</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-muted">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="<?php echo e(old('seo_tags', $project->seo_tags)); ?>" class="tagify form-control">
                                <?php $__errorArgs = ['seo_tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (English)</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="1000" rows="3"><?php echo e(old('seo_description_english', $project->seo_description_english)); ?></textarea>
                                <?php $__errorArgs = ['seo_description_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="seo_description_english" data-translate-target="seo_description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="1000" rows="3"><?php echo e(old('seo_description_arabic', $project->seo_description_arabic)); ?></textarea>
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

                        <!-- Status -->
                        <h5 class="mb-3 mt-4 text-primary">Status Settings</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Publish Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="publish_status" required>
                                    <option value="">Select Status</option>
                                    <option value="0" <?php echo e(old('publish_status', $project->publish_status) == '0' ? 'selected' : ''); ?>>Published</option>
                                    <option value="1" <?php echo e(old('publish_status', $project->publish_status) == '1' ? 'selected' : ''); ?>>Unpublished</option>
                                </select>
                                <?php $__errorArgs = ['publish_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Home Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="home_status" required>
                                    <option value="">Select Status</option>
                                    <option value="0" <?php echo e(old('home_status', $project->home_status) == '0' ? 'selected' : ''); ?>>Shown on Home</option>
                                    <option value="1" <?php echo e(old('home_status', $project->home_status) == '1' ? 'selected' : ''); ?>>Not Shown on Home</option>
                                </select>
                                <?php $__errorArgs = ['home_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    <i class="fa fa-save"></i> Update
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

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('/js/auto-translate.js')); ?>"></script>
<script src="<?php echo e(asset('/js/tagify.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/dropify.min.js')); ?>"></script>

<script>
    $('.dropify').dropify();
</script>

<script>
    if(document.querySelectorAll('.tagify').length > 0){
        const el = document.querySelector('.tagify');
        new Tagify(el);
    }
</script>

<script>
    // Auto-calculate SQM from SQFT
    document.getElementById('sqft').addEventListener('input', function() {
        const sqft = parseFloat(this.value) || 0;
        const sqm = (sqft * 0.092903).toFixed(2);
        document.getElementById('sqm').value = sqm;
    });

    // Load subcategories when category changes
    $('#category_id').on('change', function() {
        const categoryId = $(this).val();
        const subcategorySelect = $('#subcategory_id');
        
        if (!categoryId) {
            subcategorySelect.empty().append('<option value="">Select Sub Category</option>').trigger('change');
            return;
        }
        
        // Show loading state
        subcategorySelect.empty().append('<option value="">Loading...</option>').trigger('change');
        
        fetch(`<?php echo e(route('project.subcategories')); ?>?category_id=${categoryId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Subcategories received:', data);
            subcategorySelect.empty().append('<option value="">Select Sub Category</option>');
            
            if (data && data.length > 0) {
                data.forEach(subcategory => {
                    const option = new Option(subcategory.title_english, subcategory.id, false, false);
                    subcategorySelect.append(option);
                });
            } else {
                subcategorySelect.empty().append('<option value="">No subcategories available</option>');
            }
            
            // Trigger change to update Select2
            subcategorySelect.trigger('change');
        })
        .catch(error => {
            console.error('Error loading subcategories:', error);
            subcategorySelect.empty().append('<option value="">Error loading subcategories</option>').trigger('change');
        });
    });

    // Character counter for Bio English
    const bioEnglish = document.getElementById('bio_english');
    const bioEnglishCount = document.getElementById('bio_english_count');
    
    function updateBioEnglishCount() {
        const count = bioEnglish.value.length;
        bioEnglishCount.textContent = count;
        if (count > 450) {
            bioEnglishCount.style.color = '#dc3545'; // Red when close to limit
        } else if (count > 400) {
            bioEnglishCount.style.color = '#ffc107'; // Yellow warning
        } else {
            bioEnglishCount.style.color = '#6c757d'; // Default gray
        }
    }
    
    bioEnglish.addEventListener('input', updateBioEnglishCount);
    updateBioEnglishCount(); // Initial count on page load

    // Character counter for Bio Arabic
    const bioArabic = document.getElementById('bio_arabic');
    const bioArabicCount = document.getElementById('bio_arabic_count');
    
    function updateBioArabicCount() {
        const count = bioArabic.value.length;
        bioArabicCount.textContent = count;
        if (count > 450) {
            bioArabicCount.style.color = '#dc3545'; // Red when close to limit
        } else if (count > 400) {
            bioArabicCount.style.color = '#ffc107'; // Yellow warning
        } else {
            bioArabicCount.style.color = '#6c757d'; // Default gray
        }
    }
    
    bioArabic.addEventListener('input', updateBioArabicCount);
    updateBioArabicCount(); // Initial count on page load
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/edit.blade.php ENDPATH**/ ?>