<section class="pb-8 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-3"><?php echo e(__('lang.description')); ?></h4>
                <?php if(app()->getLocale() == 'ar'): ?>
                  <?php if($project->bio_arabic): ?>
                  <p class="mb-0 lh-214"><?php echo $project->bio_arabic; ?></p>
                  <?php else: ?>
                  <p class="mb-0 lh-214 text-muted"><?php echo e(__('lang.no_description')); ?></p>
                  <?php endif; ?>
                <?php else: ?>
                  <?php if($project->bio_english): ?>
                  <p class="mb-0 lh-214"><?php echo $project->bio_english; ?></p>
                  <?php else: ?>
                  <p class="mb-0 lh-214 text-muted"><?php echo e(__('lang.no_description')); ?></p>
                  <?php endif; ?>
                <?php endif; ?>
                
                
                <?php if($project->project_cost || $project->location_english || $project->location_arabic || $project->sqft || $project->type || $project->style): ?>
                <div class="mt-5 pt-5 border-top">
                  <h5 class="fs-18 text-heading mb-4"><?php echo e(__('lang.project_overview')); ?></h5>
                  <div class="row">
                    <?php if($project->project_cost): ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                      <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px; background: linear-gradient(135deg, #e1273d 0%, #c41f33 100%);">
                          <i class="fal fa-dollar-sign text-white fs-20"></i>
                        </div>
                        <div>
                          <h6 class="fs-13 font-weight-500 text-muted mb-1"><?php echo e(__('lang.project_cost')); ?></h6>
                          <p class="mb-0 fs-16 font-weight-bold" style="color: #e1273d;">
                            <?php echo e($project->currency ? $project->currency->abbreviation : 'AED'); ?> <?php echo e(number_format($project->project_cost, 0)); ?>

                          </p>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($project->location_english || $project->location_arabic): ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                      <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                          <i class="fal fa-map-marker-alt text-white fs-20"></i>
                        </div>
                        <div>
                          <h6 class="fs-13 font-weight-500 text-muted mb-1"><?php echo e(__('lang.location')); ?></h6>
                          <p class="mb-0 fs-15 font-weight-bold text-heading">
                            <?php echo e(app()->getLocale() == 'ar' ? ($project->location_arabic ?? $project->location_english) : ($project->location_english ?? $project->location_arabic)); ?>

                          </p>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($project->sqft): ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                      <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                          <i class="fal fa-ruler-combined text-white fs-20"></i>
                        </div>
                        <div>
                          <h6 class="fs-13 font-weight-500 text-muted mb-1"><?php echo e(__('lang.total_area')); ?></h6>
                          <p class="mb-0 fs-15 font-weight-bold text-heading">
                            <?php echo e(number_format($project->sqft)); ?> <?php echo e(__('lang.sqft')); ?>

                            <?php if($project->sqm): ?>
                            <span class="text-muted fs-13">(<?php echo e(number_format($project->sqm)); ?> <?php echo e(__('lang.sqm')); ?>)</span>
                            <?php endif; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($project->type): ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                      <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                          <i class="fal fa-building text-white fs-20"></i>
                        </div>
                        <div>
                          <h6 class="fs-13 font-weight-500 text-muted mb-1"><?php echo e(__('lang.project_type')); ?></h6>
                          <p class="mb-0 fs-15 font-weight-bold text-heading">
                            <?php echo e(app()->getLocale() == 'ar' ? $project->type->name_arabic : $project->type->name_english); ?>

                          </p>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($project->style): ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                      <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                          <i class="fal fa-palette text-white fs-20"></i>
                        </div>
                        <div>
                          <h6 class="fs-13 font-weight-500 text-muted mb-1"><?php echo e(__('lang.project_style')); ?></h6>
                          <p class="mb-0 fs-15 font-weight-bold text-heading">
                            <?php echo e(app()->getLocale() == 'ar' ? $project->style->title_arabic : $project->style->title_english); ?>

                          </p>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($project->emirate): ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                      <div class="d-flex align-items-center">
                        <div class="p-2 rounded-lg mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                          <i class="fal fa-city text-white fs-20"></i>
                        </div>
                        <div>
                          <h6 class="fs-13 font-weight-500 text-muted mb-1"><?php echo e(__('lang.emirate')); ?></h6>
                          <p class="mb-0 fs-15 font-weight-bold text-heading">
                            <?php echo e(app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english); ?>

                          </p>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
                <?php endif; ?>
              </section>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/projects/singleproject/description.blade.php ENDPATH**/ ?>