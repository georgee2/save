
<header class="main-header navbar-light header-desktop">
      <div class="sticky-area">
        <div class="container">
          <nav class="navbar navbar-expand-lg px-0">
            <a class="navbar-brand" href="<?php echo e(route('index')); ?>">
              <?php if(app()->getLocale() == 'ar'): ?>
              <img style="max-width: 200px;max-height: 90px" src="<?php echo e(url('/pic/logos/logoar.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
              <?php else: ?>
              <img style="max-width: 200px;max-height: 90px" src="<?php echo e(url('/pic/logos/logoen.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
              <?php endif; ?>
            </a>
            <div class="collapse navbar-collapse mt-lg-0 mx-auto flex-grow-0" id="primaryMenu01">
              <ul class="navbar-nav hover-menu main-menu px-0 mx-lg-n4">
                <?php if(isset($primaryMenuItems) && $primaryMenuItems->isNotEmpty()): ?>
                    
                    <?php $__currentLoopData = $primaryMenuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('includes.menu.desktop-item', ['item' => $menuItem, 'depth' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    
                    <!-- Home Nav (No Child) -->
                    <li id="navbar-item-home" aria-haspopup="false" aria-expanded="false"
            class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link p-0" href="<?php echo e(route('index')); ?>">
                        <?php echo e(__('lang.home')); ?>

                      </a>
                    </li>
                    <!-- Services Nav with Parent and Sub Services -->
                    <li id="navbar-item-services" aria-haspopup="true" aria-expanded="false"
            class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link dropdown-toggle p-0"
               href="<?php echo e(route('services.index')); ?>" data-toggle="dropdown">
                        <?php echo e(__('lang.services')); ?>

                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-services" style="min-width: 320px;">
                        <li class="dropdown-item">
                          <a class="dropdown-link font-weight-600" href="<?php echo e(route('services.index')); ?>">
                            <i class="fal fa-th-large mr-2"></i>
                            <?php echo e(__('lang.all_services')); ?>

                          </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <?php if(isset($headerServices) && $headerServices->count() > 0): ?>
                          <?php $__currentLoopData = $headerServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headerService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item dropdown dropright">
                              <a id="navbar-link-service-<?php echo e($headerService->id); ?>"
                           class="dropdown-link <?php if($headerService->subServices && $headerService->subServices->count() > 0): ?> dropdown-toggle <?php endif; ?>"
                           href="<?php echo e(route('services.show', $headerService->slug)); ?>">
                                <?php if($headerService->icon): ?>
                                  <img src="<?php echo e(asset('storage' . $headerService->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                <?php else: ?>
                                  <i class="fal fa-cog mr-2"></i>
                                <?php endif; ?>
                                <?php echo e(app()->getLocale() == 'ar' ? $headerService->title_arabic : $headerService->title_english); ?>

                              </a>
                              <?php if($headerService->subServices && $headerService->subServices->count() > 0): ?>
                                <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;"
                            aria-labelledby="navbar-link-service-<?php echo e($headerService->id); ?>">
                                  <?php $__currentLoopData = $headerService->subServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <?php endif; ?>
                      </ul>
                    </li>
                    <!-- Offers Nav with Categories and Subcategories -->
                    <li id="navbar-item-offers" aria-haspopup="true" aria-expanded="false"
            class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link dropdown-toggle p-0"
               href="<?php echo e(route('offers.index')); ?>" data-toggle="dropdown">
                        <?php echo e(__('lang.offers')); ?>

                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-offers" style="min-width: 320px;">
                        <li class="dropdown-item">
                          <a class="dropdown-link font-weight-600" href="<?php echo e(route('offers.index')); ?>">
                            <i class="fal fa-th-large mr-2"></i>
                            <?php echo e(__('lang.all_offers')); ?>

                          </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <?php if(isset($headerOfferCategories) && $headerOfferCategories->count() > 0): ?>
                          <?php $__currentLoopData = $headerOfferCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;"
                            aria-labelledby="navbar-link-offer-category-<?php echo e($offerCategory->id); ?>">
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
                        <?php endif; ?>
                      </ul>
                    </li>
                    <!-- Projects Nav with Categories and Subcategories -->
                    <li id="navbar-item-projects" aria-haspopup="true" aria-expanded="false"
            class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link dropdown-toggle p-0"
               href="<?php echo e(route('projects.index')); ?>" data-toggle="dropdown">
                        Projects
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-projects" style="min-width: 320px;">
                        <li class="dropdown-item">
                          <a class="dropdown-link font-weight-600" href="<?php echo e(route('projects.index')); ?>">
                            <i class="fal fa-th-large mr-2"></i>
                            <?php echo e(__('lang.all_projects')); ?>

                          </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <?php if(isset($headerProjectCategories) && $headerProjectCategories->count() > 0): ?>
                          <?php $__currentLoopData = $headerProjectCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item dropdown dropright">
                              <a id="navbar-link-category-<?php echo e($category->id); ?>"
                           class="dropdown-link <?php if($category->subCategories && $category->subCategories->count() > 0): ?> dropdown-toggle <?php endif; ?>"
                           href="<?php echo e(route('category.show', $category->slug)); ?>">
                                <?php if($category->icon): ?>
                                  <img src="<?php echo e(url('/storage' . $category->icon)); ?>" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                <?php endif; ?>
                                <?php echo e($category->title_english); ?>

                              </a>
                              <?php if($category->subCategories && $category->subCategories->count() > 0): ?>
                                <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;"
                            aria-labelledby="navbar-link-category-<?php echo e($category->id); ?>">
                                  <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="dropdown-item">
                                      <a class="dropdown-link" href="<?php echo e(route('subcategory.show', $subCategory->slug)); ?>">
                                        <?php if($subCategory->icon): ?>
                                          <img src="<?php echo e(url('/storage' . $subCategory->icon)); ?>" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                        <?php endif; ?>
                                        <?php echo e($subCategory->title_english); ?>

                                      </a>
                                    </li>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                              <?php endif; ?>
                            </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                      </ul>
                    </li>
                
                    <!-- News Nav with Categories -->
                    <li hidden id="navbar-item-news" aria-haspopup="true" aria-expanded="false"
            class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link dropdown-toggle p-0"
               href="<?php echo e(route('blogs.index')); ?>" data-toggle="dropdown">
                        <?php echo e(__('lang.news')); ?>

                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-news" style="min-width: 280px;">
                        <li class="dropdown-item">
                          <a class="dropdown-link font-weight-600" href="<?php echo e(route('blogs.index')); ?>">
                            <i class="fal fa-newspaper mr-2"></i>
                            <?php echo e(__('lang.all_news')); ?>

                          </a>
                        </li>
                        <?php if(isset($headerNewsCategories) && count($headerNewsCategories) > 0): ?>
                          <li class="dropdown-divider"></li>
                          <?php $__currentLoopData = $headerNewsCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item">
                              <a class="dropdown-link" href="<?php echo e(route('blogs.index', ['category' => $newsCategory->id])); ?>">
                                <i class="fal fa-folder mr-2"></i>
                                <?php echo e(app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english); ?>

                              </a>
                            </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                      </ul>
                    </li>
                    
                    <!-- About Nav with Team as Child -->
                    <li id="navbar-item-about" aria-haspopup="true" aria-expanded="false"
            class="nav-item dropdown py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link dropdown-toggle p-0"
               href="<?php echo e(route('about')); ?>" data-toggle="dropdown">
                        <?php echo e(__('lang.about_us')); ?>

                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="navbar-item-about" style="min-width: 250px;">
                        <li class="dropdown-item">
                          <a class="dropdown-link font-weight-600" href="<?php echo e(route('about')); ?>">
                            <i class="fal fa-info-circle mr-2"></i>
                            <?php echo e(__('lang.about_company')); ?>

                          </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item">
                          <a class="dropdown-link" href="<?php echo e(route('team.board')); ?>">
                            <i class="fal fa-user-tie mr-2"></i>
                            <?php echo e(__('lang.board_of_directors')); ?>

                          </a>
                        </li>
                        <li class="dropdown-item">
                          <a class="dropdown-link" href="<?php echo e(route('team.index')); ?>">
                            <i class="fal fa-users mr-2"></i>
                            <?php echo e(__('lang.our_team')); ?>

                          </a>
                        </li>
                        <li class="dropdown-item">
                          <a class="dropdown-link" href="<?php echo e(route('partners.index')); ?>">
                            <i class="fal fa-handshake mr-2"></i>
                            <?php echo e(__('lang.our_partners')); ?>

                          </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item">
                          <a class="dropdown-link" href="<?php echo e(route('branches.index')); ?>">
                            <i class="fal fa-building mr-2"></i>
                            <?php echo e(__('lang.our_branches')); ?>

                          </a>
                        </li>
                      </ul>
                    </li>
                    <!-- Contact Nav (No Child) -->
                    <li id="navbar-item-contact" aria-haspopup="false" aria-expanded="false"
            class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link p-0" href="<?php echo e(route('contact')); ?>">
                        <?php echo e(__('lang.contact_us')); ?>

                      </a>
                    </li>

                    <!-- Careers Nav (No Child) - Only show if there are active jobs -->
                    <?php if(isset($hasActiveJobs) && $hasActiveJobs): ?>
                    <li hidden id="navbar-item-careers" aria-haspopup="false" aria-expanded="false"
            class="nav-item py-2 py-lg-5 px-0 px-lg-4">
                      <a class="nav-link p-0" href="<?php echo e(route('careers.index')); ?>">
                        <?php echo e(__('lang.careers')); ?>

                      </a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>


<div class="mobile-header">
    <div class="mobile-header-content">
        
        <button class="mobile-hamburger" id="mobileMenuToggle" aria-label="Toggle menu">
            <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
        
        
        <a href="<?php echo e(route('index')); ?>" class="mobile-header-logo">
            <?php if(app()->getLocale() == 'ar'): ?>
            <img src="<?php echo e(url('/pic/logos/logoar.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
            <?php else: ?>
            <img src="<?php echo e(url('/pic/logos/logoen.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
            <?php endif; ?>
        </a>
        
        
        <div class="mobile-header-icons">
            <a href="<?php echo e(route('contact')); ?>" class="mobile-header-icon" title="<?php echo e(__('lang.contact_us')); ?>">
                <i class="fal fa-envelope"></i>
            </a>
        </div>
    </div>
</div>


<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
<nav class="mobile-sidebar" id="mobileSidebar">
    
    <div class="mobile-sidebar-header">
        <a href="<?php echo e(route('index')); ?>" class="mobile-sidebar-logo">
            <?php if(app()->getLocale() == 'ar'): ?>
            <img src="<?php echo e(url('/pic/logos/logoar.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
            <?php else: ?>
            <img src="<?php echo e(url('/pic/logos/logoen.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>">
            <?php endif; ?>
        </a>
        <button class="mobile-sidebar-close" id="mobileMenuClose" aria-label="Close menu">
            <i class="fal fa-times"></i>
        </button>
    </div>
    
    
    <div class="mobile-sidebar-nav">
        <?php if(isset($primaryMenuItems) && $primaryMenuItems->isNotEmpty()): ?>
            
            <?php $__currentLoopData = $primaryMenuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('includes.menu.mobile-item', ['item' => $menuItem, 'depth' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            
            
            <div class="mobile-nav-item">
                <a href="<?php echo e(route('index')); ?>" class="mobile-nav-link">
                    <?php echo e(__('lang.home')); ?>

                </a>
            </div>
            
            
            <div class="mobile-nav-item">
                <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                    <?php echo e(__('lang.services')); ?>

                    <i class="fal fa-chevron-right"></i>
                </a>
                <ul class="mobile-submenu">
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('services.index')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-th-large"></i>
                            <?php echo e(__('lang.all_services')); ?>

                        </a>
                    </li>
                    <?php if(isset($headerServices) && $headerServices->count() > 0): ?>
                        <?php $__currentLoopData = $headerServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headerService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($headerService->subServices && $headerService->subServices->count() > 0): ?>
                            <li class="mobile-submenu-item">
                                <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                    <?php if($headerService->icon): ?>
                                    <img src="<?php echo e(asset('storage' . $headerService->icon)); ?>" alt="">
                                    <?php else: ?>
                                    <i class="fal fa-cog"></i>
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? $headerService->title_arabic : $headerService->title_english); ?>

                                    <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                </a>
                                <ul class="mobile-nested-submenu">
                                    <li>
                                        <a href="<?php echo e(route('services.show', $headerService->slug)); ?>" class="mobile-nested-link">
                                            <i class="fal fa-arrow-right"></i>
                                            <?php echo e(__('lang.view_all')); ?>

                                        </a>
                                    </li>
                                    <?php $__currentLoopData = $headerService->subServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <a href="<?php echo e(route('services.show', $headerService->slug)); ?>" class="mobile-submenu-link">
                                    <?php if($headerService->icon): ?>
                                    <img src="<?php echo e(asset('storage' . $headerService->icon)); ?>" alt="">
                                    <?php else: ?>
                                    <i class="fal fa-cog"></i>
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? $headerService->title_arabic : $headerService->title_english); ?>

                                </a>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </div>
            
            
            <div class="mobile-nav-item">
                <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                    <?php echo e(__('lang.offers')); ?>

                    <i class="fal fa-chevron-right"></i>
                </a>
                <ul class="mobile-submenu">
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('offers.index')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-th-large"></i>
                            <?php echo e(__('lang.all_offers')); ?>

                        </a>
                    </li>
                    <?php if(isset($headerOfferCategories) && $headerOfferCategories->count() > 0): ?>
                        <?php $__currentLoopData = $headerOfferCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                    <?php endif; ?>
                </ul>
            </div>
            
            
            <div class="mobile-nav-item">
                <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                    <?php echo e(__('lang.projects')); ?>

                    <i class="fal fa-chevron-right"></i>
                </a>
                <ul class="mobile-submenu">
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('projects.index')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-th-large"></i>
                            <?php echo e(__('lang.all_projects')); ?>

                        </a>
                    </li>
                    <?php if(isset($headerProjectCategories) && $headerProjectCategories->count() > 0): ?>
                        <?php $__currentLoopData = $headerProjectCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($category->subCategories && $category->subCategories->count() > 0): ?>
                            <li class="mobile-submenu-item">
                                <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                    <?php if($category->icon): ?>
                                    <img src="<?php echo e(url('/storage' . $category->icon)); ?>" alt="">
                                    <?php endif; ?>
                                    <?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?>

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
                                            <?php echo e(app()->getLocale() == 'ar' ? $subCategory->title_arabic : $subCategory->title_english); ?>

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
                                    <?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?>

                                </a>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </div>
            
            
            <div class="mobile-nav-item">
                <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                    <?php echo e(__('lang.news')); ?>

                    <i class="fal fa-chevron-right"></i>
                </a>
                <ul class="mobile-submenu">
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('blogs.index')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-newspaper"></i>
                            <?php echo e(__('lang.all_news')); ?>

                        </a>
                    </li>
                    <?php if(isset($headerNewsCategories) && count($headerNewsCategories) > 0): ?>
                        <?php $__currentLoopData = $headerNewsCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="mobile-submenu-item">
                            <a href="<?php echo e(route('blogs.index', ['category' => $newsCategory->id])); ?>" class="mobile-submenu-link">
                                <i class="fal fa-folder"></i>
                                <?php echo e(app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english); ?>

                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </div>
            
            
            <div class="mobile-nav-item">
                <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                    <?php echo e(__('lang.about_us')); ?>

                    <i class="fal fa-chevron-right"></i>
                </a>
                <ul class="mobile-submenu">
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('about')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-info-circle"></i>
                            <?php echo e(__('lang.about_company')); ?>

                        </a>
                    </li>
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('team.board')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-user-tie"></i>
                            <?php echo e(__('lang.board_of_directors')); ?>

                        </a>
                    </li>
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('team.index')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-users"></i>
                            <?php echo e(__('lang.our_team')); ?>

                        </a>
                    </li>
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('partners.index')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-handshake"></i>
                            <?php echo e(__('lang.our_partners')); ?>

                        </a>
                    </li>
                    <li class="mobile-submenu-item">
                        <a href="<?php echo e(route('branches.index')); ?>" class="mobile-submenu-link">
                            <i class="fal fa-building"></i>
                            <?php echo e(__('lang.our_branches')); ?>

                        </a>
                    </li>
                </ul>
            </div>
            
            
            <div class="mobile-nav-item">
                <a href="<?php echo e(route('contact')); ?>" class="mobile-nav-link">
                    <?php echo e(__('lang.contact_us')); ?>

                </a>
            </div>
            
            
            <?php if(isset($hasActiveJobs) && $hasActiveJobs): ?>
            <div class="mobile-nav-item">
                <a href="<?php echo e(route('careers.index')); ?>" class="mobile-nav-link">
                    <?php echo e(__('lang.careers')); ?>

                </a>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    
    <div class="mobile-sidebar-footer">
        <?php
            $mobileContactInfo = $footerContactInfo ?? \App\Models\ContactInformation::getContactInfo();
        ?>
        <div class="mobile-sidebar-contact">
            <?php if($mobileContactInfo): ?>
                <?php if($mobileContactInfo->mobile): ?>
                <a href="tel:<?php echo e($mobileContactInfo->mobile); ?>">
                    <i class="fal fa-phone"></i>
                    <span><?php echo e($mobileContactInfo->mobile); ?></span>
                </a>
                <?php endif; ?>
                <?php if($mobileContactInfo->email): ?>
                <a href="mailto:<?php echo e($mobileContactInfo->email); ?>">
                    <i class="fal fa-envelope"></i>
                    <span><?php echo e($mobileContactInfo->email); ?></span>
                </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="mobile-sidebar-social">
            <?php if($mobileContactInfo): ?>
                <?php if($mobileContactInfo->whatsapp): ?>
                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $mobileContactInfo->whatsapp)); ?>" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <?php endif; ?>
                <?php if($mobileContactInfo->facebook): ?>
                <a href="<?php echo e($mobileContactInfo->facebook); ?>" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if($mobileContactInfo->instagram): ?>
                <a href="<?php echo e($mobileContactInfo->instagram); ?>" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
                <?php if($mobileContactInfo->twitter): ?>
                <a href="<?php echo e($mobileContactInfo->twitter); ?>" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                <?php endif; ?>
                <?php if($mobileContactInfo->linkedin): ?>
                <a href="<?php echo e($mobileContactInfo->linkedin); ?>" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <?php endif; ?>
                <?php if($mobileContactInfo->youtube): ?>
                <a href="<?php echo e($mobileContactInfo->youtube); ?>" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                <?php endif; ?>
                <?php if($mobileContactInfo->pinterest): ?>
                <a href="<?php echo e($mobileContactInfo->pinterest); ?>" target="_blank" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</nav>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobileMenuToggle');
    const menuClose = document.getElementById('mobileMenuClose');
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('mobileMenuOverlay');
    const body = document.body;
    
    // Toggle menu
    function openMenu() {
        menuToggle.classList.add('active');
        sidebar.classList.add('active');
        overlay.classList.add('active');
        body.classList.add('mobile-menu-open');
    }
    
    function closeMenu() {
        menuToggle.classList.remove('active');
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        body.classList.remove('mobile-menu-open');
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });
    }
    
    if (menuClose) {
        menuClose.addEventListener('click', closeMenu);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeMenu);
    }
    
    // Submenu toggles
    const navToggles = document.querySelectorAll('.mobile-nav-toggle');
    navToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.mobile-nav-item, .mobile-submenu-item');
            if (parent) {
                parent.classList.toggle('open');
            }
        });
    });
    
    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            closeMenu();
        }
    });
});
</script>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/includes/header.blade.php ENDPATH**/ ?>