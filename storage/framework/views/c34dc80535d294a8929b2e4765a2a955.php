
<?php
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
    $dynamicChildren = collect();
    $hasDynamicContent = false;
    
    // Check visibility
    if (!$item->isVisible()) {
        return;
    }
    
    // Check mobile visibility
    if (!$item->is_visible_mobile) {
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
    $depth = $depth ?? 0;
?>

<?php if($item->item_type === 'divider'): ?>
    
    <div class="mobile-nav-divider"></div>
<?php elseif($item->item_type === 'header'): ?>
    <div class="mobile-nav-header"><?php echo e($itemTitle); ?></div>
<?php else: ?>
    <div class="mobile-nav-item <?php echo e($item->css_class ?? ''); ?>">
        <?php if($hasChildren): ?>
            <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                <?php if($item->icon): ?>
                    <?php if($item->icon_type === 'image'): ?>
                        <img src="<?php echo e(asset('storage' . $item->icon)); ?>" alt="">
                    <?php else: ?>
                        <i class="<?php echo e($item->icon); ?>"></i>
                    <?php endif; ?>
                <?php endif; ?>
                <?php echo e($itemTitle); ?>

                <i class="fal fa-chevron-right"></i>
            </a>
            <ul class="mobile-submenu">
                
                <?php if($item->item_type === 'category_with_subs' && $itemUrl && $itemUrl !== 'javascript:void(0);'): ?>
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e($itemUrl); ?>" class="mobile-submenu-link" style="font-weight: 600; color: #19868b;">
                            <i class="fal fa-arrow-right"></i>
                            <?php echo e(__('lang.view_all')); ?> <?php echo e($itemTitle); ?>

                        </a>
                    </li>
                <?php endif; ?>
                
                
                <?php $__currentLoopData = $itemChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('includes.menu.mobile-submenu-item', ['item' => $child, 'depth' => $depth + 1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
                <?php if($hasDynamicContent): ?>
                    <?php if($item->item_type === 'dynamic_services'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($service->subServices && $service->subServices->count() > 0): ?>
                                <li class="mobile-submenu-item">
                                    <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                        <?php if($service->icon): ?>
                                            <img src="<?php echo e(asset('storage' . $service->icon)); ?>" alt="">
                                        <?php else: ?>
                                            <i class="fal fa-cog"></i>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english); ?>

                                        <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                    </a>
                                    <ul class="mobile-nested-submenu">
                                        <li>
                                            <a href="<?php echo e(route('services.show', $service->slug)); ?>" class="mobile-nested-link">
                                                <i class="fal fa-arrow-right"></i>
                                                <?php echo e(__('lang.view_all')); ?>

                                            </a>
                                        </li>
                                        <?php $__currentLoopData = $service->subServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a href="<?php echo e(route('services.show', $subService->slug)); ?>" class="mobile-nested-link">
                                                    <?php if($subService->icon): ?>
                                                        <img src="<?php echo e(asset('storage' . $subService->icon)); ?>" alt="">
                                                    <?php else: ?>
                                                        <i class="fal fa-angle-right"></i>
                                                    <?php endif; ?>
                                                    <?php echo e(app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="mobile-submenu-item">
                                    <a href="<?php echo e(route('services.show', $service->slug)); ?>" class="mobile-submenu-link">
                                        <?php if($service->icon): ?>
                                            <img src="<?php echo e(asset('storage' . $service->icon)); ?>" alt="">
                                        <?php else: ?>
                                            <i class="fal fa-cog"></i>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_offers'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0): ?>
                                <li class="mobile-submenu-item">
                                    <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                        <?php if($offerCategory->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $offerCategory->icon)); ?>" alt="">
                                        <?php else: ?>
                                            <i class="fal fa-tag"></i>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english); ?>

                                        <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                    </a>
                                    <ul class="mobile-nested-submenu">
                                        <li>
                                            <a href="<?php echo e(route('offers.category', $offerCategory->slug)); ?>" class="mobile-nested-link">
                                                <i class="fal fa-arrow-right"></i>
                                                <?php echo e(__('lang.view_all')); ?>

                                            </a>
                                        </li>
                                        <?php $__currentLoopData = $offerCategory->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerSubCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a href="<?php echo e(route('offers.subcategory', $offerSubCategory->slug)); ?>" class="mobile-nested-link">
                                                    <?php if($offerSubCategory->icon): ?>
                                                        <img src="<?php echo e(url('/storage' . $offerSubCategory->icon)); ?>" alt="">
                                                    <?php else: ?>
                                                        <i class="fal fa-angle-right"></i>
                                                    <?php endif; ?>
                                                    <?php echo e(app()->getLocale() == 'ar' ? $offerSubCategory->title_arabic : $offerSubCategory->title_english); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="mobile-submenu-item">
                                    <a href="<?php echo e(route('offers.category', $offerCategory->slug)); ?>" class="mobile-submenu-link">
                                        <?php if($offerCategory->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $offerCategory->icon)); ?>" alt="">
                                        <?php else: ?>
                                            <i class="fal fa-tag"></i>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_projects'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($category->subCategories && $category->subCategories->count() > 0): ?>
                                <li class="mobile-submenu-item">
                                    <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                        <?php if($category->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $category->icon)); ?>" alt="">
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english); ?>

                                        <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                    </a>
                                    <ul class="mobile-nested-submenu">
                                        <li>
                                            <a href="<?php echo e(route('category.show', $category->slug)); ?>" class="mobile-nested-link">
                                                <i class="fal fa-arrow-right"></i>
                                                <?php echo e(__('lang.view_all')); ?>

                                            </a>
                                        </li>
                                        <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a href="<?php echo e(route('subcategory.show', $subCategory->slug)); ?>" class="mobile-nested-link">
                                                    <?php if($subCategory->icon): ?>
                                                        <img src="<?php echo e(url('/storage' . $subCategory->icon)); ?>" alt="">
                                                    <?php endif; ?>
                                                    <?php echo e(app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="mobile-submenu-item">
                                    <a href="<?php echo e(route('category.show', $category->slug)); ?>" class="mobile-submenu-link">
                                        <?php if($category->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $category->icon)); ?>" alt="">
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_news'): ?>
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="mobile-submenu-item">
                                <a href="<?php echo e(route('blogs.index', ['category' => $newsCategory->id])); ?>" class="mobile-submenu-link">
                                    <i class="fal fa-folder"></i>
                                    <?php echo e(app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'dynamic_query'): ?>
                        
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($queryItem->is_subcategory ?? false): ?>
                                
                                <li class="mobile-submenu-item">
                                    <a href="<?php echo e(route($queryItem->route_name, $queryItem->slug)); ?>" class="mobile-submenu-link">
                                        <?php if($queryItem->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $queryItem->icon)); ?>" alt="">
                                        <?php else: ?>
                                            <?php if($item->query_source === 'offers'): ?>
                                                <i class="fal fa-tag"></i>
                                            <?php elseif($item->query_source === 'projects'): ?>
                                                <i class="fal fa-project-diagram"></i>
                                            <?php else: ?>
                                                <i class="fal fa-folder"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php echo e(app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english); ?>

                                    </a>
                                </li>
                            <?php else: ?>
                                
                                <?php if($queryItem->subCategories && $queryItem->subCategories->count() > 0): ?>
                                    <li class="mobile-submenu-item">
                                        <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                            <?php if($queryItem->icon): ?>
                                                <img src="<?php echo e(url('/storage' . $queryItem->icon)); ?>" alt="">
                                            <?php else: ?>
                                                <?php if($item->query_source === 'offers'): ?>
                                                    <i class="fal fa-tag"></i>
                                                <?php elseif($item->query_source === 'projects'): ?>
                                                    <i class="fal fa-project-diagram"></i>
                                                <?php elseif($item->query_source === 'interior'): ?>
                                                    <i class="fal fa-couch"></i>
                                                <?php else: ?>
                                                    <i class="fal fa-folder"></i>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php echo e(app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english); ?>

                                            <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                        </a>
                                        <ul class="mobile-nested-submenu">
                                            <li>
                                                <a href="<?php echo e(route($queryItem->route_name, $queryItem->slug)); ?>" class="mobile-nested-link">
                                                    <i class="fal fa-arrow-right"></i>
                                                    <?php echo e(__('lang.view_all')); ?>

                                                </a>
                                            </li>
                                            <?php $__currentLoopData = $queryItem->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <?php
                                                        $subRoute = match($item->query_source) {
                                                            'offers' => 'offers.subcategory',
                                                            'projects' => 'subcategory.show',
                                                            default => 'subcategory.show'
                                                        };
                                                    ?>
                                                    <a href="<?php echo e(route($subRoute, $subCat->slug)); ?>" class="mobile-nested-link">
                                                        <?php if($subCat->icon): ?>
                                                            <img src="<?php echo e(url('/storage' . $subCat->icon)); ?>" alt="">
                                                        <?php else: ?>
                                                            <i class="fal fa-angle-right"></i>
                                                        <?php endif; ?>
                                                        <?php echo e(app()->getLocale() == 'ar' ? ($subCat->title_arabic ?? $subCat->title_english) : $subCat->title_english); ?>

                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    
                                    <li class="mobile-submenu-item">
                                        <a href="<?php echo e(route($queryItem->route_name, $queryItem->slug)); ?>" class="mobile-submenu-link">
                                            <?php if($queryItem->icon): ?>
                                                <img src="<?php echo e(url('/storage' . $queryItem->icon)); ?>" alt="">
                                            <?php else: ?>
                                                <?php if($item->query_source === 'offers'): ?>
                                                    <i class="fal fa-tag"></i>
                                                <?php elseif($item->query_source === 'projects'): ?>
                                                    <i class="fal fa-project-diagram"></i>
                                                <?php elseif($item->query_source === 'interior'): ?>
                                                    <i class="fal fa-couch"></i>
                                                <?php else: ?>
                                                    <i class="fal fa-folder"></i>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php echo e(app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php elseif($item->item_type === 'category_with_subs'): ?>
                        
                        <?php $__currentLoopData = $dynamicChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="mobile-submenu-item">
                                <a href="<?php echo e($subCategory->menu_url ?? '#'); ?>" class="mobile-submenu-link">
                                    <?php if($subCategory->icon): ?>
                                        <img src="<?php echo e(url('/storage' . $subCategory->icon)); ?>" alt="">
                                    <?php else: ?>
                                        <?php if($item->query_source === 'offers'): ?>
                                            <i class="fal fa-tag"></i>
                                        <?php elseif($item->query_source === 'projects'): ?>
                                            <i class="fal fa-project-diagram"></i>
                                        <?php else: ?>
                                            <i class="fal fa-folder"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        <?php else: ?>
            <a href="<?php echo e($itemUrl); ?>" class="mobile-nav-link" <?php if($item->link_target): ?> target="<?php echo e($item->link_target); ?>" <?php endif; ?>>
                <?php if($item->icon): ?>
                    <?php if($item->icon_type === 'image'): ?>
                        <img src="<?php echo e(asset('storage' . $item->icon)); ?>" alt="">
                    <?php else: ?>
                        <i class="<?php echo e($item->icon); ?>"></i>
                    <?php endif; ?>
                <?php endif; ?>
                <?php echo e($itemTitle); ?>

            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/includes/menu/mobile-item.blade.php ENDPATH**/ ?>