<section class="mt-2 pb-3 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-6"><?php echo e(__('lang.facts_and_features')); ?></h4>
                <div class="row">
                  
                  <?php if($project->category): ?>
                  <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-2 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <?php if($project->category->icon): ?>
                        <img src="<?php echo e(url('/storage' . $project->category->icon)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?>"
                             style="width: 32px; height: 32px; object-fit: contain;">
                        <?php else: ?>
                        <i class="fal fa-folder fs-32 text-primary"></i>
                        <?php endif; ?>
                      </div>
                      <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal"><?php echo e(__('lang.category')); ?></h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">
                          <?php echo e(app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english); ?>

                        </p>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>

                  
                  <?php if($project->subcategory): ?>
                  <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-2 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <?php if($project->subcategory->icon): ?>
                        <img src="<?php echo e(url('/storage' . $project->subcategory->icon)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english); ?>"
                             style="width: 32px; height: 32px; object-fit: contain;">
                        <?php else: ?>
                        <i class="fal fa-folder-open fs-32 text-primary"></i>
                        <?php endif; ?>
                      </div>
                      <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal"><?php echo e(__('lang.subcategory')); ?></h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">
                          <?php echo e(app()->getLocale() == 'ar' ? $project->subcategory->title_arabic : $project->subcategory->title_english); ?>

                        </p>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>

                  
                  <?php if($project->style): ?>
                  <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-2 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <?php if($project->style->icon): ?>
                        <img src="<?php echo e(url('/storage' . $project->style->icon)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $project->style->title_arabic : $project->style->title_english); ?>"
                             style="width: 32px; height: 32px; object-fit: contain;">
                        <?php else: ?>
                        <i class="fal fa-paint-brush fs-32 text-primary"></i>
                        <?php endif; ?>
                      </div>
                      <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal"><?php echo e(__('lang.style')); ?></h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">
                          <?php echo e(app()->getLocale() == 'ar' ? $project->style->title_arabic : $project->style->title_english); ?>

                        </p>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>

                  
                  <?php if($project->sqft): ?>
                  <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-2 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fal fa-ruler-combined fs-32 text-primary"></i>
                      </div>
                      <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal"><?php echo e(__('lang.sqft')); ?></h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading"><?php echo e(number_format($project->sqft)); ?></p>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>

                  
                  <?php if($project->sqm): ?>
                  <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-2 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fal fa-vector-square fs-32 text-primary"></i>
                      </div>
                      <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal"><?php echo e(__('lang.sqm')); ?></h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading"><?php echo e(number_format($project->sqm)); ?></p>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>

                  
                  <?php if($project->emirate): ?>
                  <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-2 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <?php if($project->emirate->icon): ?>
                        <img src="<?php echo e(url('/storage' . $project->emirate->icon)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english); ?>"
                             style="width: 32px; height: 32px; object-fit: contain;">
                        <?php else: ?>
                        <i class="fal fa-map-marker-alt fs-32 text-primary"></i>
                        <?php endif; ?>
                      </div>
                      <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal"><?php echo e(__('lang.location')); ?></h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">
                          <?php echo e(app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english); ?>

                        </p>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>

                  
                  <?php if($project->partner): ?>
                  <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-2 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <?php if($project->partner->logo): ?>
                        <img src="<?php echo e(url('/storage' . $project->partner->logo)); ?>" 
                             alt="<?php echo e(app()->getLocale() == 'ar' ? $project->partner->name_arabic : $project->partner->name_english); ?>"
                             style="width: 32px; height: 32px; object-fit: contain;">
                        <?php else: ?>
                        <i class="fal fa-handshake fs-32 text-primary"></i>
                        <?php endif; ?>
                      </div>
                      <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal"><?php echo e(__('lang.partner')); ?></h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">
                          <?php echo e(app()->getLocale() == 'ar' ? $project->partner->name_arabic : $project->partner->name_english); ?>

                        </p>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </section>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/projects/singleproject/specs.blade.php ENDPATH**/ ?>