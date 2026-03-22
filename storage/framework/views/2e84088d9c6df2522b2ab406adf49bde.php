
<div class="primary-sidebar sidebar-sticky" id="sidebar">
    <div class="primary-sidebar-inner">
        <div class="card border-0 mb-4">
            <div class="card-body pl-0 pl-lg-6 pr-0 pt-2 pb-4">
                <h4 class="card-title fs-16 lh-2 text-dark mb-3"><?php echo e(__('lang.find_your_offer')); ?></h4>
                <form method="GET" action="<?php echo e($formAction ?? request()->url()); ?>" id="offerFilterForm">
                    
                    <div class="form-group">
                        <label for="keyword" class="sr-only"><?php echo e(__('lang.keyword')); ?></label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-none"
                               id="keyword" name="keyword" value="<?php echo e(request('keyword')); ?>"
                               placeholder="<?php echo e(__('lang.enter_keyword')); ?>">
                    </div>
                    
                    
                    <?php if(!isset($hideCategory) || !$hideCategory): ?>
                    <div class="form-group">
                        <label for="category_id" class="sr-only"><?php echo e(__('lang.category')); ?></label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="<?php echo e(__('lang.all_categories')); ?>" data-style="btn-lg py-2 h-52" 
                                id="category_id" name="category_id">
                            <option value=""><?php echo e(__('lang.all_categories')); ?></option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id || (isset($currentCategory) && $currentCategory->id == $cat->id) ? 'selected' : ''); ?>>
                                <?php echo e(app()->getLocale() == 'ar' ? $cat->title_arabic : $cat->title_english); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if(!isset($hideSubcategory) || !$hideSubcategory): ?>
                    <div class="form-group">
                        <label for="subcategory_id" class="sr-only"><?php echo e(__('lang.subcategory')); ?></label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="<?php echo e(__('lang.all_subcategories')); ?>" data-style="btn-lg py-2 h-52" 
                                id="subcategory_id" name="subcategory_id">
                            <option value=""><?php echo e(__('lang.all_subcategories')); ?></option>
                            <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($subcat->id); ?>" data-category="<?php echo e($subcat->category_id); ?>" <?php echo e(request('subcategory_id') == $subcat->id || (isset($currentSubcategory) && $currentSubcategory->id == $subcat->id) ? 'selected' : ''); ?>>
                                <?php echo e(app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if(isset($types) && $types->count() > 0): ?>
                    <div class="form-group">
                        <label for="type_id" class="sr-only"><?php echo e(__('lang.type')); ?></label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="<?php echo e(__('lang.all_types')); ?>" data-style="btn-lg py-2 h-52" 
                                id="type_id" name="type_id">
                            <option value=""><?php echo e(__('lang.all_types')); ?></option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>" <?php echo e(request('type_id') == $type->id ? 'selected' : ''); ?>>
                                <?php echo e(app()->getLocale() == 'ar' ? $type->name_arabic : $type->name_english); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if(isset($styles) && $styles->count() > 0): ?>
                    <div class="form-group">
                        <label for="style_id" class="sr-only"><?php echo e(__('lang.style')); ?></label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="<?php echo e(__('lang.all_styles')); ?>" data-style="btn-lg py-2 h-52" 
                                id="style_id" name="style_id">
                            <option value=""><?php echo e(__('lang.all_styles')); ?></option>
                            <?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($style->id); ?>" <?php echo e(request('style_id') == $style->id ? 'selected' : ''); ?>>
                                <?php echo e(app()->getLocale() == 'ar' ? $style->title_arabic : $style->title_english); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if(isset($emirates) && $emirates->count() > 0): ?>
                    <div class="form-group">
                        <label for="emirate_id" class="sr-only"><?php echo e(__('lang.emirate')); ?></label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="<?php echo e(__('lang.all_emirates')); ?>" data-style="btn-lg py-2 h-52" 
                                id="emirate_id" name="emirate_id">
                            <option value=""><?php echo e(__('lang.all_emirates')); ?></option>
                            <?php $__currentLoopData = $emirates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emirate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($emirate->id); ?>" <?php echo e(request('emirate_id') == $emirate->id ? 'selected' : ''); ?>>
                                <?php echo e(app()->getLocale() == 'ar' ? $emirate->title_arabic : $emirate->title_english); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    
                    <div class="form-group area-slider-group">
                        <label class="text-gray-light mb-3"><?php echo e(__('lang.area_size')); ?> (<?php echo e(__('lang.sqft')); ?>)</label>
                        <div class="area-slider-container">
                            <div id="sqft-slider" class="area-range-slider"></div>
                            <div class="area-slider-values text-center mt-3">
                                <span id="sqft-range-display" class="font-weight-600 text-heading">
                                    <?php echo e(request('sqft_min', 50)); ?> <?php echo e(__('lang.sqft')); ?> <?php echo e(__('lang.to')); ?> <?php echo e(request('sqft_max', 15000)); ?> <?php echo e(__('lang.sqft')); ?>

                                </span>
                            </div>
                            <input type="hidden" id="sqft_min" name="sqft_min" value="<?php echo e(request('sqft_min', '')); ?>">
                            <input type="hidden" id="sqft_max" name="sqft_max" value="<?php echo e(request('sqft_max', '')); ?>">
                        </div>
                    </div>
                    
                    
                    <div class="form-group area-slider-group">
                        <label class="text-gray-light mb-3"><?php echo e(__('lang.area_size')); ?> (<?php echo e(__('lang.sqm')); ?>)</label>
                        <div class="area-slider-container">
                            <div id="sqm-slider" class="area-range-slider"></div>
                            <div class="area-slider-values text-center mt-3">
                                <span id="sqm-range-display" class="font-weight-600 text-heading">
                                    <?php echo e(request('sqm_min', 5)); ?> <?php echo e(__('lang.sqm')); ?> <?php echo e(__('lang.to')); ?> <?php echo e(request('sqm_max', 1400)); ?> <?php echo e(__('lang.sqm')); ?>

                                </span>
                            </div>
                            <input type="hidden" id="sqm_min" name="sqm_min" value="<?php echo e(request('sqm_min', '')); ?>">
                            <input type="hidden" id="sqm_max" name="sqm_max" value="<?php echo e(request('sqm_max', '')); ?>">
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <a class="lh-17 d-inline-block" data-toggle="collapse" href="#price-filter"
                           role="button" aria-expanded="<?php echo e(request('price_min') || request('price_max') ? 'true' : 'false'); ?>" aria-controls="price-filter">
                            <span class="text-primary d-inline-block mr-1"><i class="far fa-plus-square"></i></span>
                            <span class="fs-15 text-heading font-weight-500 hover-primary"><?php echo e(__('lang.filter_by_price')); ?></span>
                        </a>
                        <div class="collapse <?php echo e(request('price_min') || request('price_max') ? 'show' : ''); ?>" id="price-filter">
                            <div class="card card-body border-0 px-0 pb-0 pt-3">
                                <label class="text-gray-light mb-2"><?php echo e(__('lang.price_range')); ?> (AED)</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-lg border-0 shadow-none"
                                               id="price_min" name="price_min" value="<?php echo e(request('price_min')); ?>"
                                               placeholder="<?php echo e(__('lang.min')); ?>">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-lg border-0 shadow-none"
                                               id="price_max" name="price_max" value="<?php echo e(request('price_max')); ?>"
                                               placeholder="<?php echo e(__('lang.max')); ?>">
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1"><?php echo e(__('lang.price_filter_note')); ?></small>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1 shadow-none mr-2">
                            <i class="fas fa-search mr-2"></i><?php echo e(__('lang.search')); ?>

                        </button>
                        <a href="<?php echo e($formAction ?? request()->url()); ?>" class="btn btn-outline-secondary btn-lg shadow-none">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/offers/partials/new-filter-sidebar.blade.php ENDPATH**/ ?>