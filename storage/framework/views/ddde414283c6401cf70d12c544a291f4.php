<?php $__env->startSection('title' , app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?>
<?php $__env->startSection('seo_desc', app()->getLocale() == 'ar' ? ($category->seo_description_arabic ?? $category->bio_arabic) : ($category->seo_description_english ?? $category->bio_english)); ?>
<?php $__env->startSection('seo_tags', $category->seo_tags ?? (app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english)); ?>
<?php $__env->startSection('content'); ?>


<section class="pb-8 page-title shadow">
        <div class="container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
              <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('lang.home')); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo e(route('projects.index')); ?>"><?php echo e(__('lang.projects')); ?></a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?></li>
            </ol>
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600"><?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?></h1>
          </nav>
        </div>
      </section>

      
      <?php if(isset($subcategoriesWithCount) && $subcategoriesWithCount->count() > 0): ?>
      <section class="subcategory-filter-section">
        <div class="container">
          <div class="subcategory-filter-slider slick-slider" 
               data-slick-options='{"slidesToShow": 6, "slidesToScroll": 2, "autoplay": false, "dots": false, "arrows": true, "infinite": false, "responsive":[{"breakpoint": 1400,"settings": {"slidesToShow": 5, "arrows": true}},{"breakpoint": 1200,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 992,"settings": {"slidesToShow": 4, "arrows": true}},{"breakpoint": 768,"settings": {"slidesToShow": 3, "arrows": true}},{"breakpoint": 576,"settings": {"slidesToShow": 2, "arrows": false}}]}'>
            
            
            <div class="box">
              <a href="<?php echo e(route('category.show', ['slug' => $category->slug, 'sortby' => request('sortby')])); ?>" 
                 class="subcategory-filter-item all-item <?php echo e(!request('subcategory_id') ? 'active' : ''); ?>">
                <div class="subcategory-filter-icon">
                  <i class="fas fa-th-large"></i>
                </div>
                <p class="subcategory-filter-title"><?php echo e(__('lang.all')); ?></p>
                <span class="subcategory-filter-count"><?php echo e($projects->total()); ?> <?php echo e(__('lang.projects')); ?></span>
              </a>
            </div>
            
            
            <?php $__currentLoopData = $subcategoriesWithCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box">
              <a href="<?php echo e(route('subcategory.show', $subcat->slug)); ?>" 
                 class="subcategory-filter-item <?php echo e(request('subcategory_id') == $subcat->id ? 'active' : ''); ?>">
                <div class="subcategory-filter-icon">
                  <?php if($subcat->icon): ?>
                  <img src="<?php echo e(url('/storage' . $subcat->icon)); ?>" 
                       alt="<?php echo e(app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english); ?>">
                  <?php else: ?>
                  <i class="fas fa-folder"></i>
                  <?php endif; ?>
                </div>
                <p class="subcategory-filter-title"><?php echo e(app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english); ?></p>
                <span class="subcategory-filter-count"><?php echo e($subcat->projects_count); ?> <?php echo e(__('lang.projects')); ?></span>
              </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
          </div>
        </div>
      </section>
      <?php endif; ?>




      <section class="pt-8 pb-11">
        <div class="container">
          
          <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>
          
          <div class="row">
            
            <div class="projects-main-container filter-hidden mb-8 mb-lg-0" id="projectsContainer">
              <div class="row align-items-sm-center mb-6">
                <div class="col-md-6">
                  <h2 class="fs-15 text-dark mb-0"><?php echo e(__('lang.we_found')); ?> <span class="text-primary"><?php echo e($projects->total()); ?></span> <?php echo e(__('lang.projects_available')); ?></h2>
                </div>
                <div class="col-md-6 mt-6 mt-md-0">
                  <div class="d-flex justify-content-md-end align-items-center flex-wrap">
                    
                    <button type="button" class="filter-toggle-btn mr-3" id="filterToggleBtn">
                      <i class="fas fa-filter"></i>
                      <span class="d-none d-sm-inline"><?php echo e(__('lang.filter')); ?></span>
                      <?php
                        $activeFilters = 0;
                        if(request('keyword')) $activeFilters++;
                        if(request('subcategory_id')) $activeFilters++;
                        if(request('style_id')) $activeFilters++;
                        if(request('type_id')) $activeFilters++;
                        if(request('sqft_min') || request('sqft_max')) $activeFilters++;
                        if(request('sqm_min') || request('sqm_max')) $activeFilters++;
                        if(request('specification_id')) $activeFilters++;
                      ?>
                      <?php if($activeFilters > 0): ?>
                      <span class="filter-count"><?php echo e($activeFilters); ?></span>
                      <?php endif; ?>
                    </button>
                    
                    <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                      <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3"
								       for="sortbySelect"><i
										class="fas fa-align-left fs-16 pr-2"></i><span class="d-none d-sm-inline"><?php echo e(__('lang.sortby')); ?>:</span></label>
                      <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby-select"
								        data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3"
								        id="sortbySelect" name="sortby">
                        <option value="newest" <?php echo e(request('sortby', 'newest') == 'newest' ? 'selected' : ''); ?>><?php echo e(__('lang.newest')); ?></option>
                        <option value="oldest" <?php echo e(request('sortby') == 'oldest' ? 'selected' : ''); ?>><?php echo e(__('lang.oldest')); ?></option>
                        <option value="area_low" <?php echo e(request('sortby') == 'area_low' ? 'selected' : ''); ?>><?php echo e(__('lang.area_low_to_high')); ?></option>
                        <option value="area_high" <?php echo e(request('sortby') == 'area_high' ? 'selected' : ''); ?>><?php echo e(__('lang.area_high_to_low')); ?></option>
                      </select>
                    </div>
                    <div class="d-none d-md-block">
                      <a class="fs-sm-18 text-dark view-toggle" href="#" id="listViewBtn" data-view="list">
                        <i class="fas fa-list"></i>
                      </a>
                      <a class="fs-sm-18 text-dark ml-5 view-toggle active" href="#" id="gridViewBtn" data-view="grid">
                        <i class="fa fa-th-large"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              
              
              <div class="row" id="gridView">
                <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 mb-6">
                  <div class="card border-0 shadow-hover-2" data-animate="fadeInUp">
                    <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="hover-change-image bg-hover-overlay rounded-lg card-img-top d-block">
                      <img src="<?php echo e(url('/storage' . $project->main_image)); ?>"
								     alt="<?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>">
                      <div class="card-img-overlay p-2 d-flex flex-column pointer-events-none">
                        <div>
                          <?php if($project->home_status == 0): ?>
                          <span class="badge badge-primary"><?php echo e(__('lang.featured')); ?></span>
                          <?php else: ?>
                          <span class="badge badge-indigo"><?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?></span>
                          <?php endif; ?>
                        </div>
                        <ul class="list-inline mb-0 mt-auto hover-image media-count-badges">
                          <?php if($project->total_images > 0): ?>
                          <li class="list-inline-item mr-2" data-toggle="tooltip" title="<?php echo e($project->total_images); ?> <?php echo e(__('lang.images')); ?>">
                              <span class="media-count-badge">
                              <i class="far fa-images"></i><span class="pl-1"><?php echo e($project->total_images); ?></span>
                              </span>
                            </li>
                          <?php endif; ?>
                          <?php if($project->video_count > 0): ?>
                          <li class="list-inline-item" data-toggle="tooltip" title="<?php echo e($project->video_count); ?> <?php echo e(__('lang.videos')); ?>">
                              <span class="media-count-badge">
                              <i class="far fa-play-circle"></i><span class="pl-1"><?php echo e($project->video_count); ?></span>
                              </span>
                            </li>
                          <?php endif; ?>
                          </ul>
                      </div>
                    </a>
                    
                    
                    <?php
                        $shareTitle = app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english;
                        $shareSqft = $project->sqft ? number_format($project->sqft) . ' ' . __('lang.sqft') : '';
                        $shareCategory = $project->category ? (app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english) : '';
                        $shareSubcategory = $project->subcategory ? (app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english) : '';
                        $shareText = $shareTitle;
                        if($shareSqft) {
                            $shareText .= ' - ' . $shareSqft;
                        }
                        if($shareCategory) {
                            $shareText .= ' (' . $shareCategory . ($shareSubcategory ? ' / ' . $shareSubcategory : '') . ')';
                        }
                        $shareUrl = route('projects.show', $project->slug);
                        $shareImage = url('/storage' . $project->main_image);
                    ?>
                    <div class="project-share-badge">
                        <div class="share-actions">
                            
                            <div class="share-slide-wrapper">
                                <button type="button" class="share-action-btn share-slide-btn">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                                <div class="share-slide-icons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode($shareUrl)); ?>&quote=<?php echo e(urlencode($shareText)); ?>" 
                                       target="_blank" class="share-action-btn facebook-btn">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode($shareUrl)); ?>&text=<?php echo e(urlencode($shareText)); ?>" 
                                       target="_blank" class="share-action-btn twitter-btn">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(urlencode($shareUrl)); ?>&title=<?php echo e(urlencode($shareTitle)); ?>&summary=<?php echo e(urlencode($shareText)); ?>" 
                                       target="_blank" class="share-action-btn linkedin-btn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo e(urlencode($shareUrl)); ?>&media=<?php echo e(urlencode($shareImage)); ?>&description=<?php echo e(urlencode($shareText)); ?>" 
                                       target="_blank" class="share-action-btn pinterest-btn">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                    <a href="mailto:?subject=<?php echo e(rawurlencode($shareTitle)); ?>&body=<?php echo e(urlencode($shareText . "\n\n" . $shareUrl)); ?>" 
                                       class="share-action-btn email-btn">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <a href="https://wa.me/?text=<?php echo e(urlencode($shareText . "\n" . $shareUrl)); ?>" 
                               target="_blank" 
                               class="share-action-btn whatsapp-share-btn" 
                               data-toggle="tooltip" 
                               data-placement="top"
                               title="<?php echo e(__('lang.share_whatsapp')); ?>">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body pt-3">
                      <h2 class="card-title fs-16 lh-2 mb-0">
                        <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="text-dark hover-primary">
                          <?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>

                        </a>
                      </h2>
                      <p class="card-text font-weight-500 text-gray-light mb-2">
                        <?php if($project->category): ?>
                          <a href="<?php echo e(route('category.show', $project->category->slug)); ?>" class="text-gray-light hover-primary">
                            <?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?>

                          </a>
                        <?php endif; ?>
                        <?php if($project->subcategory): ?>
                          <span class="mx-1">/</span>
                          <a href="<?php echo e(route('subcategory.show', $project->subcategory->slug)); ?>" class="text-gray-light hover-primary">
                            <?php echo e(app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english); ?>

                          </a>
                        <?php endif; ?>
                      </p>
                      <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                        <?php $__currentLoopData = $project->specifications->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($spec->specification): ?>
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                            data-toggle="tooltip" title="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>">
                          <?php if($spec->specification->icon): ?>
                          <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                               alt="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>"
                               class="mr-2 spec-icon" 
                               style="width: 24px; height: 24px; object-fit: contain;">
                          <?php else: ?>
                          <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-2 spec-icon-placeholder" 
                                style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                              <?php echo e(mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1)); ?>

                          </span>
                          <?php endif; ?>
                          <span class="spec-value"><?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                      <p class="fs-17 font-weight-bold text-heading mb-0">
                        <?php if($project->sqft): ?>
                        <?php echo e(number_format($project->sqft)); ?> <span class="text-gray-light font-weight-500 fs-14"><?php echo e(__('lang.sqft')); ?></span>
                        <?php endif; ?>
                      </p>
                      <div class="d-flex align-items-center">
                        <button type="button" class="btn-favourite mr-2" data-type="project" data-id="<?php echo e($project->id); ?>" title="<?php echo e(__('lang.add_to_favourites')); ?>">
                            <i class="fal fa-heart"></i>
                        </button>
                        <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                          <?php echo e(__('lang.view_project')); ?>

                          <i class="far fa-long-arrow-right ml-1"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                  <div class="alert alert-info text-center">
                    <?php echo e(__('lang.no_projects_found')); ?>

                  </div>
                </div>
                <?php endif; ?>
                        </div>

              
              <div class="row" id="listView" style="display: none;">
                <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-12 mb-6">
                  <div class="card border-0 shadow-hover-2" data-animate="fadeInUp">
                    <div class="row no-gutters">
                      <div class="col-md-5">
                        <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="hover-change-image bg-hover-overlay rounded-lg card-img h-100 d-block">
                          <img src="<?php echo e(url('/storage' . $project->main_image)); ?>" class="h-100 object-fit-cover"
                               alt="<?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>">
                          <div class="card-img-overlay p-2 d-flex flex-column pointer-events-none">
                            <div>
                              <?php if($project->home_status == 0): ?>
                              <span class="badge badge-primary">Featured</span>
                              <?php else: ?>
                              <span class="badge badge-indigo"><?php echo e(app()->getLocale() == 'ar' ? $category->title_arabic : $category->title_english); ?></span>
                              <?php endif; ?>
                      </div>
                            <ul class="list-inline mb-0 mt-auto hover-image media-count-badges">
                              <?php if($project->total_images > 0): ?>
                              <li class="list-inline-item mr-2" data-toggle="tooltip" title="<?php echo e($project->total_images); ?> <?php echo e(__('lang.images')); ?>">
                              <span class="media-count-badge">
                                  <i class="far fa-images"></i><span class="pl-1"><?php echo e($project->total_images); ?></span>
                              </span>
                            </li>
                              <?php endif; ?>
                              <?php if($project->video_count > 0): ?>
                              <li class="list-inline-item" data-toggle="tooltip" title="<?php echo e($project->video_count); ?> <?php echo e(__('lang.videos')); ?>">
                              <span class="media-count-badge">
                                  <i class="far fa-play-circle"></i><span class="pl-1"><?php echo e($project->video_count); ?></span>
                              </span>
                            </li>
                              <?php endif; ?>
                      </ul>
                    </div>
                        </a>
                      </div>
                      <div class="col-md-7">
                        <div class="card-body p-4 d-flex flex-column h-100">
                          <h2 class="card-title fs-18 lh-2 mb-0">
                            <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="text-dark hover-primary">
                              <?php echo e(app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english); ?>

                            </a>
                      </h2>
                          <p class="card-text font-weight-500 text-gray-light mb-2">
                            <?php if($project->category): ?>
                              <a href="<?php echo e(route('category.show', $project->category->slug)); ?>" class="text-gray-light hover-primary">
                                <?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?>

                              </a>
                            <?php endif; ?>
                            <?php if($project->subcategory): ?>
                              <span class="mx-1">/</span>
                              <a href="<?php echo e(route('subcategory.show', $project->subcategory->slug)); ?>" class="text-gray-light hover-primary">
                                <?php echo e(app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english); ?>

                              </a>
                            <?php endif; ?>
                          </p>
                          <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                            <?php $__currentLoopData = $project->specifications->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($spec->specification): ?>
                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5 mb-2"
                                data-toggle="tooltip" title="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>">
                              <?php if($spec->specification->icon): ?>
                              <img src="<?php echo e(url('/storage' . $spec->specification->icon)); ?>" 
                                   alt="<?php echo e(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english); ?>"
                                   class="mr-2 spec-icon" 
                                   style="width: 24px; height: 24px; object-fit: contain;">
                              <?php else: ?>
                              <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mr-2 spec-icon-placeholder" 
                                    style="width: 24px; height: 24px; font-size: 12px; font-weight: 600;">
                                  <?php echo e(mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1)); ?>

                              </span>
                              <?php endif; ?>
                              <span class="spec-value"><?php echo e(app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english); ?></span>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ul>
                          <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                            <p class="fs-17 font-weight-bold text-heading mb-0">
                              <?php if($project->sqft): ?>
                              <?php echo e(number_format($project->sqft)); ?> <span class="text-gray-light font-weight-500 fs-14"><?php echo e(__('lang.sqft')); ?></span>
                              <?php endif; ?>
                            </p>
                            <div class="d-flex align-items-center">
                              <button type="button" class="btn-favourite mr-2" data-type="project" data-id="<?php echo e($project->id); ?>" title="<?php echo e(__('lang.add_to_favourites')); ?>">
                                  <i class="fal fa-heart"></i>
                              </button>
                              <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="btn btn-primary btn-sm px-4 py-2 rounded-lg">
                                <?php echo e(__('lang.view_details')); ?>

                                <i class="far fa-long-arrow-right ml-1"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                  <div class="alert alert-info text-center">
                    <?php echo e(__('lang.no_projects_found')); ?>

                  </div>
                </div>
                <?php endif; ?>
              </div>

              <?php if($projects->hasPages()): ?>
              <nav class="pt-4 projects-pagination-wrapper">
                <ul class="pagination projects-smart-pagination justify-content-center mb-0">
                  
                  <?php if($projects->onFirstPage()): ?>
                  <li class="page-item page-nav disabled"><span class="page-link"><i class="far fa-chevron-left"></i></span></li>
                  <?php else: ?>
                  <li class="page-item page-nav"><a class="page-link" href="<?php echo e($projects->previousPageUrl()); ?>"><i class="far fa-chevron-left"></i></a></li>
                  <?php endif; ?>

                  
                  <?php
                      $currentPage = $projects->currentPage();
                      $lastPage = $projects->lastPage();
                      $maxVisible = 4;
                      
                      if ($lastPage <= $maxVisible) {
                          $startPage = 1;
                          $endPage = $lastPage;
                      } else {
                          $half = floor($maxVisible / 2);
                          if ($currentPage <= $half + 1) {
                              $startPage = 1;
                              $endPage = $maxVisible;
                          } elseif ($currentPage >= $lastPage - $half) {
                              $startPage = $lastPage - $maxVisible + 1;
                              $endPage = $lastPage;
                          } else {
                              $startPage = $currentPage - $half;
                              $endPage = $currentPage + $half - 1;
                          }
                      }
                  ?>

                  
                  <?php if($startPage > 1): ?>
                  <li class="page-item"><a class="page-link" href="<?php echo e($projects->url(1)); ?>">1</a></li>
                  <?php if($startPage > 2): ?>
                  <li class="page-item page-dots disabled"><span class="page-link">...</span></li>
                  <?php endif; ?>
                  <?php endif; ?>

                  
                  <?php for($page = $startPage; $page <= $endPage; $page++): ?>
                      <?php if($page == $currentPage): ?>
                      <li class="page-item active"><span class="page-link"><?php echo e($page); ?></span></li>
                      <?php else: ?>
                      <li class="page-item"><a class="page-link" href="<?php echo e($projects->url($page)); ?>"><?php echo e($page); ?></a></li>
                      <?php endif; ?>
                  <?php endfor; ?>

                  
                  <?php if($endPage < $lastPage): ?>
                  <?php if($endPage < $lastPage - 1): ?>
                  <li class="page-item page-dots disabled"><span class="page-link">...</span></li>
                  <?php endif; ?>
                  <li class="page-item"><a class="page-link" href="<?php echo e($projects->url($lastPage)); ?>"><?php echo e($lastPage); ?></a></li>
                  <?php endif; ?>

                  
                  <?php if($projects->hasMorePages()): ?>
                  <li class="page-item page-nav"><a class="page-link" href="<?php echo e($projects->nextPageUrl()); ?>"><i class="far fa-chevron-right"></i></a></li>
                  <?php else: ?>
                  <li class="page-item page-nav disabled"><span class="page-link"><i class="far fa-chevron-right"></i></span></li>
                  <?php endif; ?>
                </ul>
              </nav>
              <?php endif; ?>
            </div>
            
            
            <div class="filter-sidebar-wrapper hidden" id="filterSidebarWrapper">
                
                <div class="mobile-filter-header d-lg-none">
                    <h4><?php echo e(__('lang.filter')); ?></h4>
                    <button type="button" class="mobile-filter-close" id="mobileFilterClose">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                
            <?php echo $__env->make('pages.projects.partials.filter-sidebar', [
                'formAction' => route('category.show', $category->slug),
                'categories' => $categories,
                'subcategories' => $subcategories,
                'styles' => $styles,
                'types' => $types,
                'specifications' => $specifications,
                'specificationValues' => $specificationValues ?? [],
                'hideCategory' => true,
                'currentCategory' => $category
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
          </div>
        </div>
      </section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/category-page.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/area-slider.css')); ?>?v=<?php echo e(time()); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/projects-filter.css')); ?>?v=<?php echo e(time()); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/projects-responsive.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Filter Toggle Functionality
    var filterToggleBtn = $('#filterToggleBtn');
    var filterSidebar = $('#filterSidebarWrapper');
    var projectsContainer = $('#projectsContainer');
    var mobileFilterOverlay = $('#mobileFilterOverlay');
    var mobileFilterClose = $('#mobileFilterClose');
    var body = $('body');
    
    // Check if we're on mobile
    function isMobile() {
        return window.innerWidth <= 991;
    }
    
    // Toggle filter visibility
    filterToggleBtn.on('click', function() {
        if (isMobile()) {
            // Mobile: slide in panel
            filterSidebar.toggleClass('visible hidden');
            mobileFilterOverlay.toggleClass('active');
            body.toggleClass('filter-open');
        } else {
            // Desktop: toggle sidebar visibility
            filterSidebar.toggleClass('visible hidden');
            projectsContainer.toggleClass('filter-visible filter-hidden');
        }
        
        $(this).toggleClass('active');
    });
    
    // Close mobile filter
    mobileFilterClose.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    // Close on overlay click
    mobileFilterOverlay.on('click', function() {
        filterSidebar.removeClass('visible').addClass('hidden');
        mobileFilterOverlay.removeClass('active');
        body.removeClass('filter-open');
        filterToggleBtn.removeClass('active');
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if (!isMobile()) {
            // Reset mobile states when switching to desktop
            mobileFilterOverlay.removeClass('active');
            body.removeClass('filter-open');
        }
    });
    
    // View toggle functionality
    $('.view-toggle').on('click', function(e) {
        e.preventDefault();
        var view = $(this).data('view');
        
        // Update active state
        $('.view-toggle').removeClass('active opacity-2');
        $(this).addClass('active');
        $('.view-toggle').not(this).addClass('opacity-2');
        
        if (view === 'list') {
            $('#gridView').hide();
            $('#listView').show();
        } else {
            $('#listView').hide();
            $('#gridView').show();
        }
    });
    
    // Set initial state
    $('#listViewBtn').addClass('opacity-2');
    
    // Auto-submit for filter dropdowns
    $('.filter-select').on('changed.bs.select', function() {
        $('#projectFilterForm').submit();
    });
    
    // Initialize SQFT Range Slider
    var sqftMinDefault = 50;
    var sqftMaxDefault = 15000;
    var sqftMinVal = <?php echo e(request('sqft_min', 50) ?: 50); ?>;
    var sqftMaxVal = <?php echo e(request('sqft_max', 15000) ?: 15000); ?>;
    
    $("#sqft-slider").slider({
        range: true,
        min: sqftMinDefault,
        max: sqftMaxDefault,
        values: [sqftMinVal, sqftMaxVal],
        slide: function(event, ui) {
            $("#sqft-range-display").text(ui.values[0] + " <?php echo e(__('lang.sqft')); ?> <?php echo e(__('lang.to')); ?> " + ui.values[1] + " <?php echo e(__('lang.sqft')); ?>");
            $("#sqft_min").val(ui.values[0]);
            $("#sqft_max").val(ui.values[1]);
        },
        stop: function(event, ui) {
            if (ui.values[0] !== sqftMinDefault || ui.values[1] !== sqftMaxDefault) {
                $('#projectFilterForm').submit();
            }
        }
    });
    $("#sqft-range-display").text(sqftMinVal + " <?php echo e(__('lang.sqft')); ?> <?php echo e(__('lang.to')); ?> " + sqftMaxVal + " <?php echo e(__('lang.sqft')); ?>");
    
    // Initialize SQM Range Slider
    var sqmMinDefault = 5;
    var sqmMaxDefault = 1400;
    var sqmMinVal = <?php echo e(request('sqm_min', 5) ?: 5); ?>;
    var sqmMaxVal = <?php echo e(request('sqm_max', 1400) ?: 1400); ?>;
    
    $("#sqm-slider").slider({
        range: true,
        min: sqmMinDefault,
        max: sqmMaxDefault,
        values: [sqmMinVal, sqmMaxVal],
        slide: function(event, ui) {
            $("#sqm-range-display").text(ui.values[0] + " <?php echo e(__('lang.sqm')); ?> <?php echo e(__('lang.to')); ?> " + ui.values[1] + " <?php echo e(__('lang.sqm')); ?>");
            $("#sqm_min").val(ui.values[0]);
            $("#sqm_max").val(ui.values[1]);
        },
        stop: function(event, ui) {
            if (ui.values[0] !== sqmMinDefault || ui.values[1] !== sqmMaxDefault) {
                $('#projectFilterForm').submit();
            }
        }
    });
    $("#sqm-range-display").text(sqmMinVal + " <?php echo e(__('lang.sqm')); ?> <?php echo e(__('lang.to')); ?> " + sqmMaxVal + " <?php echo e(__('lang.sqm')); ?>");
    
    // Specification dropdown - load values dynamically
    $('#specification_id').on('changed.bs.select', function() {
        var specId = $(this).val();
        var $valueSelect = $('#specification_value');
        
        if (specId) {
            $.ajax({
                url: "<?php echo e(route('projects.specification-values')); ?>",
                type: 'GET',
                data: { specification_id: specId },
                success: function(response) {
                    $valueSelect.empty();
                    $valueSelect.append('<option value=""><?php echo e(__('lang.select_value')); ?></option>');
                    if (response.values && response.values.length > 0) {
                        $.each(response.values, function(index, value) {
                            $valueSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                        $valueSelect.prop('disabled', false);
                    } else {
                        $valueSelect.prop('disabled', true);
                    }
                    $valueSelect.selectpicker('refresh');
                }
            });
        } else {
            $valueSelect.empty();
            $valueSelect.append('<option value=""><?php echo e(__('lang.select_value')); ?></option>');
            $valueSelect.prop('disabled', true);
            $valueSelect.selectpicker('refresh');
        }
    });
    
    // Specification value dropdown - auto submit
    $('#specification_value').on('changed.bs.select', function() {
        if ($(this).val()) {
            $('#projectFilterForm').submit();
        }
    });
    
    // Sort by change - auto submit
    $('.sortby-select').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    // Fallback for native change event
    $('#sortbySelect').on('change', function() {
        var sortby = $(this).val();
        if (sortby) {
            var url = new URL(window.location.href);
            url.searchParams.set('sortby', sortby);
            window.location.href = url.toString();
        }
    });
    
    // Close filter on escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && filterSidebar.hasClass('visible') && isMobile()) {
            filterSidebar.removeClass('visible').addClass('hidden');
            mobileFilterOverlay.removeClass('active');
            body.removeClass('filter-open');
            filterToggleBtn.removeClass('active');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/projects/categories/categories.blade.php ENDPATH**/ ?>