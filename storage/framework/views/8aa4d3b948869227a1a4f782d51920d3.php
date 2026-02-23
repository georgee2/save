
<?php
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
    $dynamicChildren = collect();
    $hasDynamicContent = false;
    
    // Check visibility
    if (!$item->isVisible()) {
        return;
    }
    
    // Check desktop visibility
    if (!$item->is_visible_desktop) {
        return;
    }
    
    // Get dynamic children if applicable
    if ($item->isDynamic() && $item->show_children) {
        $dynamicChildren = $item->getDynamicChildren();
        $hasDynamicContent = $dynamicChildren->isNotEmpty();
    }
    
    // Get dynamic query results
    if ($item->isDynamicQuery() && $item->show_children) {
        $dynamicChildren = $item->getQueryResults();
        $hasDynamicContent = $dynamicChildren->isNotEmpty();
    }
    
    // Get category with subcategories children
    if ($item->isCategoryWithSubs()) {
        $dynamicChildren = $item->getCategorySubcategories();
        $hasDynamicContent = $dynamicChildren->isNotEmpty();
    }
    
    $hasChildren = $itemChildren->isNotEmpty() || $hasDynamicContent;
    $itemUrl = $item->getUrl() ?? 'javascript:void(0);';
    $itemTitle = $item->getTitle();
    $itemId = 'navbar-item-' . $item->id;
?>

<?php if($item->item_type === 'divider'): ?>
    <li class="dropdown-divider"></li>
<?php elseif($item->item_type === 'header'): ?>
    <li class="dropdown-header"><?php echo e($itemTitle); ?></li>
<?php else: ?>
    <?php
        // For category_with_subs, we want the parent to be clickable (no data-toggle)
        $isClickableParent = $item->item_type === 'category_with_subs';
    ?>
    <li id="<?php echo e($itemId); ?>" 
        aria-haspopup="<?php echo e($hasChildren ? 'true' : 'false'); ?>" 
        aria-expanded="false"
        class="nav-item <?php echo e($hasChildren ? 'dropdown' : ''); ?> py-2 py-lg-5 px-0 px-lg-4 <?php echo e($item->css_class ?? ''); ?>">
        
        <a class="nav-link <?php echo e($hasChildren ? 'dropdown-toggle' : ''); ?> p-0"
           href="<?php echo e($itemUrl); ?>" 
           <?php if($hasChildren && !$isClickableParent): ?> data-toggle="dropdown" <?php endif; ?>
           <?php if($item->link_target): ?> target="<?php echo e($item->link_target); ?>" <?php endif; ?>>
            <?php if($item->icon): ?>
                <?php if($item->icon_type === 'image'): ?>
                    <img src="<?php echo e(asset('storage' . $item->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                <?php else: ?>
                    <i class="<?php echo e($item->icon); ?> mr-2"></i>
                <?php endif; ?>
            <?php endif; ?>
            <?php echo e($itemTitle); ?>

            <?php if($hasChildren): ?>
                <span class="caret"></span>
            <?php endif; ?>
        </a>
        
        <?php if($hasChildren): ?>
            <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="<?php echo e($itemId); ?>" style="min-width: 320px;">
                
                <?php $__currentLoopData = $itemChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('includes.menu.desktop-dropdown-item', ['item' => $child, 'depth' => ($depth ?? 0) + 1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
                <?php if($hasDynamicContent): ?>
                    <?php if($item->item_type === 'dynamic_services'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item dropdown dropright">
                                <a id="navbar-link-service-<?php echo e($service->id); ?>"
                                   class="dropdown-link <?php if($service->subServices && $service->subServices->count() > 0): ?> dropdown-toggle <?php endif; ?>"
                                   href="<?php echo e(route('services.show', $service->slug)); ?>">
                                    <?php if($service->icon): ?>
                                        <img src="<?php echo e(asset('storage' . $service->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="fal fa-cog mr-2"></i>
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english); ?>

                                </a>
                                <?php if($service->subServices && $service->subServices->count() > 0): ?>
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                        <?php $__currentLoopData = $service->subServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="<?php echo e(route('services.show', $subService->slug)); ?>">
                                                    <?php if($subService->icon): ?>
                                                        <img src="<?php echo e(asset('storage' . $subService->icon)); ?>" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                    <?php else: ?>
                                                        <i class="fal fa-angle-right mr-2"></i>
                                                    <?php endif; ?>
                                                    <?php echo e(app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_offers'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item dropdown dropright">
                                <a id="navbar-link-offer-category-<?php echo e($offerCategory->id); ?>"
                                   class="dropdown-link <?php if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0): ?> dropdown-toggle <?php endif; ?>"
                                   href="<?php echo e(route('offers.category', $offerCategory->slug)); ?>">
                                    <?php if($offerCategory->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $offerCategory->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="fal fa-tag mr-2"></i>
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english); ?>

                                </a>
                                <?php if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0): ?>
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                        <?php $__currentLoopData = $offerCategory->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerSubCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="<?php echo e(route('offers.subcategory', $offerSubCategory->slug)); ?>">
                                                    <?php if($offerSubCategory->icon): ?>
                                                        <img src="<?php echo e(url('/storage' . $offerSubCategory->icon)); ?>" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                    <?php else: ?>
                                                        <i class="fal fa-angle-right mr-2"></i>
                                                    <?php endif; ?>
                                                    <?php echo e(app()->getLocale() == 'ar' ? $offerSubCategory->title_arabic : $offerSubCategory->title_english); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_projects'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item dropdown dropright">
                                <a id="navbar-link-category-<?php echo e($category->id); ?>"
                                   class="dropdown-link <?php if($category->subCategories && $category->subCategories->count() > 0): ?> dropdown-toggle <?php endif; ?>"
                                   href="<?php echo e(route('category.show', $category->slug)); ?>">
                                    <?php if($category->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $category->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english); ?>

                                </a>
                                <?php if($category->subCategories && $category->subCategories->count() > 0): ?>
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                        <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="<?php echo e(route('subcategory.show', $subCategory->slug)); ?>">
                                                    <?php if($subCategory->icon): ?>
                                                        <img src="<?php echo e(url('/storage' . $subCategory->icon)); ?>" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                    <?php endif; ?>
                                                    <?php echo e(app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_news'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item">
                                <a class="dropdown-link" href="<?php echo e(route('blogs.index', ['category' => $newsCategory->id])); ?>">
                                    <i class="fal fa-folder mr-2"></i>
                                    <?php echo e(app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_query'): ?>
                        
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($queryItem->is_subcategory ?? false): ?>
                                
                                <li class="dropdown-item">
                                    <a class="dropdown-link" href="<?php echo e(route($queryItem->route_name, $queryItem->slug)); ?>">
                                        <?php if($queryItem->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $queryItem->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                        <?php else: ?>
                                            <?php if($item->query_source === 'offers'): ?>
                                                <i class="fal fa-tag mr-2"></i>
                                            <?php elseif($item->query_source === 'projects'): ?>
                                                <i class="fal fa-project-diagram mr-2"></i>
                                            <?php else: ?>
                                                <i class="fal fa-folder mr-2"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english); ?>

                                    </a>
                                </li>
                            <?php else: ?>
                                
                                <li class="dropdown-item dropdown dropright">
                                    <a id="navbar-link-query-<?php echo e($queryItem->id); ?>"
                                       class="dropdown-link <?php if($queryItem->subCategories && $queryItem->subCategories->count() > 0): ?> dropdown-toggle <?php endif; ?>"
                                       href="<?php echo e(route($queryItem->route_name, $queryItem->slug)); ?>">
                                        <?php if($queryItem->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $queryItem->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                        <?php else: ?>
                                            <?php if($item->query_source === 'offers'): ?>
                                                <i class="fal fa-tag mr-2"></i>
                                            <?php elseif($item->query_source === 'projects'): ?>
                                                <i class="fal fa-project-diagram mr-2"></i>
                                            <?php elseif($item->query_source === 'interior'): ?>
                                                <i class="fal fa-couch mr-2"></i>
                                            <?php else: ?>
                                                <i class="fal fa-folder mr-2"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english); ?>

                                    </a>
                                    <?php if($queryItem->subCategories && $queryItem->subCategories->count() > 0): ?>
                                        <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                            <?php $__currentLoopData = $queryItem->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="dropdown-item">
                                                    <?php
                                                        // Determine subcategory route based on source
                                                        $subRoute = match($item->query_source) {
                                                            'offers' => 'offers.subcategory',
                                                            'projects' => 'subcategory.show',
                                                            default => 'subcategory.show'
                                                        };
                                                    ?>
                                                    <a class="dropdown-link" href="<?php echo e(route($subRoute, $subCat->slug)); ?>">
                                                        <?php if($subCat->icon): ?>
                                                            <img src="<?php echo e(url('/storage' . $subCat->icon)); ?>" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                        <?php else: ?>
                                                            <i class="fal fa-angle-right mr-2"></i>
                                                        <?php endif; ?>
                                                        <?php echo e(app()->getLocale() == 'ar' ? ($subCat->title_arabic ?? $subCat->title_english) : $subCat->title_english); ?>

                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'category_with_subs'): ?>
                        
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item">
                                <a class="dropdown-link" href="<?php echo e($subCategory->menu_url ?? '#'); ?>">
                                    <?php if($subCategory->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $subCategory->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    <?php else: ?>
                                        <?php if($item->query_source === 'offers'): ?>
                                            <i class="fal fa-tag mr-2"></i>
                                        <?php elseif($item->query_source === 'projects'): ?>
                                            <i class="fal fa-project-diagram mr-2"></i>
                                        <?php else: ?>
                                            <i class="fal fa-folder mr-2"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/includes/menu/desktop-item.blade.php ENDPATH**/ ?>