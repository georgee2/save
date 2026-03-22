<?php $__env->startSection('title', 'Edit Partner'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/css/tagify.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/css/auto-translate.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('partner.index')); ?>" class="breadcrumbs__item"><i class="fa fa-handshake-o"></i> Partners List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Partner</a> 
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
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Partner: <?php echo e($partner->name_english); ?></h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('partner.index')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Partners List</button>
                            </a>
                            <a href="<?php echo e(route('partner.show', ['id' => $partner->id])); ?>" class="mr-2">
                                <button class="btn btn-info"><i class="fa fa-eye"></i> View Profile</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="<?php echo e(route('partner.update', ['id' => $partner->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <!-- Type Selection -->
                        <h5 class="mb-3 text-primary">Type Selection</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="partner_type" id="partner_type" required>
                                    <option value="partner" <?php echo e(old('partner_type', $partner->partner_type) == 'partner' ? 'selected' : ''); ?>>Partner</option>
                                    <option value="branch" <?php echo e(old('partner_type', $partner->partner_type) == 'branch' ? 'selected' : ''); ?>>Branch</option>
                                    <option value="government" <?php echo e(old('partner_type', $partner->partner_type) == 'government' ? 'selected' : ''); ?>>Government Partner</option>
                                </select>
                                <?php $__errorArgs = ['partner_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted" id="type-hint">Select partner type. Government partners only require name and logo.</small>
                            </div>
                        </div>
                        
                        <!-- Basic Information -->
                        <h5 class="mb-3 mt-4 text-primary">Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="<?php echo e(old('name_english', $partner->name_english)); ?>" type="text" name="name_english" required>
                                <?php $__errorArgs = ['name_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="name_english" data-translate-target="name_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="<?php echo e(old('name_arabic', $partner->name_arabic)); ?>" type="text" name="name_arabic" required>
                                <?php $__errorArgs = ['name_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Contact Information - Hidden for Government -->
                        <div id="contact-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">Contact Information</h5>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Email <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger required-icon"></i></label>
                                <input class="form-control" value="<?php echo e(old('email', $partner->email)); ?>" type="email" name="email" id="email_field">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Mobile <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger required-icon"></i></label>
                                <input class="form-control" value="<?php echo e(old('mobile', $partner->mobile)); ?>" type="text" name="mobile" id="mobile_field">
                                <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Office Number</label>
                                <input class="form-control" value="<?php echo e(old('office_number', $partner->office_number)); ?>" type="text" name="office_number">
                                <?php $__errorArgs = ['office_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Tax Number</label>
                                <input class="form-control" value="<?php echo e(old('tax_number', $partner->tax_number)); ?>" type="text" name="tax_number">
                                <?php $__errorArgs = ['tax_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Opening Hours</label>
                                <input class="form-control" value="<?php echo e(old('opening_hours', $partner->opening_hours)); ?>" type="text" name="opening_hours" placeholder="e.g., Mon-Fri 9AM-5PM">
                                <?php $__errorArgs = ['opening_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        </div>

                        <!-- Location Information - Hidden for Government -->
                        <div id="location-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">Location Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Location Text (English)</label>
                                <textarea class="form-control" name="location_text_english" rows="3"><?php echo e(old('location_text_english', $partner->location_text_english)); ?></textarea>
                                <?php $__errorArgs = ['location_text_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Location Text (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="location_text_english" data-translate-target="location_text_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control" name="location_text_arabic" rows="3"><?php echo e(old('location_text_arabic', $partner->location_text_arabic)); ?></textarea>
                                <?php $__errorArgs = ['location_text_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Map URL</label>
                                <textarea class="form-control" name="map_url" rows="3" placeholder="Google Maps embed URL or iframe code"><?php echo e(old('map_url', $partner->map_url)); ?></textarea>
                                <?php $__errorArgs = ['map_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        </div>

                        <!-- Social Media Links - Hidden for Government -->
                        <div id="social-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">Social Media Links</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Website URL</label>
                                <input class="form-control" value="<?php echo e(old('website_url', $partner->website_url)); ?>" type="url" name="website_url">
                                <?php $__errorArgs = ['website_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Facebook URL</label>
                                <input class="form-control" value="<?php echo e(old('facebook_url', $partner->facebook_url)); ?>" type="url" name="facebook_url">
                                <?php $__errorArgs = ['facebook_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Instagram URL</label>
                                <input class="form-control" value="<?php echo e(old('instagram_url', $partner->instagram_url)); ?>" type="url" name="instagram_url">
                                <?php $__errorArgs = ['instagram_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">LinkedIn URL</label>
                                <input class="form-control" value="<?php echo e(old('linkedin_url', $partner->linkedin_url)); ?>" type="url" name="linkedin_url">
                                <?php $__errorArgs = ['linkedin_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Twitter URL</label>
                                <input class="form-control" value="<?php echo e(old('twitter_url', $partner->twitter_url)); ?>" type="url" name="twitter_url">
                                <?php $__errorArgs = ['twitter_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        </div>

                        <!-- Logos -->
                        <h5 class="mb-3 mt-4 text-primary">Logos</h5>
                        <div class="alert alert-light border mb-3" style="background: #f8f9fa;">
                            <i class="fa fa-info-circle text-info mr-2"></i>
                            <strong>Logo Guidelines:</strong>
                            <ul class="mb-0 mt-2" style="font-size: 13px;">
                                <li><strong>Recommended Size:</strong> <code>200 x 80 px</code> (or proportional)</li>
                                <li><strong>Format:</strong> PNG with transparent background preferred</li>
                                <li><strong>Max File Size:</strong> 2MB</li>
                                <li><strong>Usage:</strong> Partner/Branch logos will be displayed in sliders, cards, and listing pages</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Logo (English)</label>
                                <?php if($partner->logo_english): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo e(url('/storage'.$partner->logo_english)); ?>" alt="Current Logo EN" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                    </div>
                                <?php endif; ?>
                                <input accept="image/*" class="form-control dropify" type="file" name="logo_english" data-default-file="<?php echo e($partner->logo_english ? url('/storage'.$partner->logo_english) : ''); ?>">
                                <small class="text-muted">Recommended: <strong>200x80px</strong>, PNG transparent</small>
                                <?php $__errorArgs = ['logo_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Logo (Arabic)</label>
                                <?php if($partner->logo_arabic): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo e(url('/storage'.$partner->logo_arabic)); ?>" alt="Current Logo AR" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                    </div>
                                <?php endif; ?>
                                <input accept="image/*" class="form-control dropify" type="file" name="logo_arabic" data-default-file="<?php echo e($partner->logo_arabic ? url('/storage'.$partner->logo_arabic) : ''); ?>">
                                <small class="text-muted">Recommended: <strong>200x80px</strong>, PNG transparent</small>
                                <?php $__errorArgs = ['logo_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- About, Mission, Vision - Hidden for Government -->
                        <div id="about-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">About, Mission & Vision</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">About (English)</label>
                                <textarea id="elm1" class="form-control" name="about_english"><?php echo old('about_english', $partner->about_english); ?></textarea>
                                <?php $__errorArgs = ['about_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">About (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="about_english" data-translate-target="about_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea id="elm2" class="form-control" name="about_arabic"><?php echo old('about_arabic', $partner->about_arabic); ?></textarea>
                                <?php $__errorArgs = ['about_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Mission (English)</label>
                                <textarea id="elm3" class="form-control" name="mission_english"><?php echo old('mission_english', $partner->mission_english); ?></textarea>
                                <?php $__errorArgs = ['mission_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Mission (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="mission_english" data-translate-target="mission_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea id="elm4" class="form-control" name="mission_arabic"><?php echo old('mission_arabic', $partner->mission_arabic); ?></textarea>
                                <?php $__errorArgs = ['mission_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Vision (English)</label>
                                <textarea id="elm5" class="form-control" name="vision_english"><?php echo old('vision_english', $partner->vision_english); ?></textarea>
                                <?php $__errorArgs = ['vision_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Vision (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="vision_english" data-translate-target="vision_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea id="elm6" class="form-control" name="vision_arabic"><?php echo old('vision_arabic', $partner->vision_arabic); ?></textarea>
                                <?php $__errorArgs = ['vision_arabic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        </div>

                        <!-- SEO Information - Hidden for Government -->
                        <div id="seo-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">SEO Information</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-muted">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="<?php echo e(old('seo_tags', $partner->seo_tags)); ?>" class="tagify form-control">
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
                                <textarea name="seo_description_english" class="form-control" maxlength="225" rows="3"><?php echo e(old('seo_description_english', $partner->seo_description_english)); ?></textarea>
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
                                <textarea name="seo_description_arabic" class="form-control" maxlength="225" rows="3"><?php echo e(old('seo_description_arabic', $partner->seo_description_arabic)); ?></textarea>
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
    
    // Toggle sections based on partner type
    function togglePartnerSections() {
        var partnerType = $('#partner_type').val();
        var isGovernment = partnerType === 'government';
        
        if (isGovernment) {
            // Hide all extra sections for government partners
            $('.partner-section').slideUp(300);
            // Remove required from email and mobile
            $('#email_field').removeAttr('required');
            $('#mobile_field').removeAttr('required');
            // Update hint text
            $('#type-hint').html('<i class="fa fa-building text-success"></i> Government partner - only name and logo required.');
        } else {
            // Show all sections for partners/branches
            $('.partner-section').slideDown(300);
            // Add required back to email and mobile
            $('#email_field').attr('required', true);
            $('#mobile_field').attr('required', true);
            // Update hint text
            $('#type-hint').html('Select partner type. Government partners only require name and logo.');
        }
    }
    
    // Run on page load
    $(document).ready(function() {
        togglePartnerSections();
        
        // Run on change
        $('#partner_type').on('change', function() {
            togglePartnerSections();
        });
    });
</script>

<script>
    if(document.querySelectorAll('.tagify').length > 0){
        const el = document.querySelector('.tagify');
        new Tagify(el);
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/partners/edit.blade.php ENDPATH**/ ?>