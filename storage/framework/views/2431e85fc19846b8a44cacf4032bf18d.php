
<?php if($project->show_feasibility_studies == 0 && $project->feasibilityStudies && $project->feasibilityStudies->count() > 0): ?>
<section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6"><?php echo e(__('lang.feasibility_studies')); ?></h4>
    
    <?php $__currentLoopData = $project->feasibilityStudies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $study): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="accordion accordion-03 mb-3" id="accordion-fs-<?php echo e($study->id); ?>">
        <div class="card border-0 shadow-xxs-5 bg-gray-01">
            <div class="card-header bg-gray-01 border-gray border-0 p-0" id="fs-heading-<?php echo e($study->id); ?>">
                <div class="heading bg-gray-01 d-flex justify-content-between align-items-center px-6"
                     data-toggle="collapse" data-target="#fs-collapse-<?php echo e($study->id); ?>" 
                     aria-expanded="<?php echo e($index === 0 ? 'true' : 'false'); ?>"
                     aria-controls="fs-collapse-<?php echo e($study->id); ?>" role="button">
                    <h2 class="mb-0 fs-16 text-heading font-weight-500 py-4 lh-13">
                        <i class="fal fa-chart-line text-primary mr-2"></i>
                        <?php echo e($study->study_name); ?>

                    </h2>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-<?php echo e($study->study_type == 'Master' ? 'primary' : 'secondary'); ?> mr-3">
                            <?php echo e($study->study_type); ?>

                        </span>
                        <?php if($study->currency): ?>
                        <span class="text-muted fs-13 font-weight-500 d-flex align-items-center" style="min-width: 180px;">
                            <?php if($study->currency->icon): ?>
                            <img src="<?php echo e(url('/storage' . $study->currency->icon)); ?>" alt="" class="mr-2" style="width: 20px; height: 20px; object-fit: contain;">
                            <?php else: ?>
                            <i class="fal fa-coins text-primary mr-2"></i>
                            <?php endif; ?>
                            <?php echo e(app()->getLocale() == 'ar' ? $study->currency->name_arabic : $study->currency->name_english); ?> (<?php echo e($study->currency->abbreviation); ?>)
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="fs-collapse-<?php echo e($study->id); ?>"
                 class="collapse <?php echo e($index === 0 ? 'show' : ''); ?> mx-6 mb-6 bg-white rounded-lg"
                 aria-labelledby="fs-heading-<?php echo e($study->id); ?>"
                 data-parent="#accordion-fs-<?php echo e($study->id); ?>">
                <div class="card-body p-4">
                    
                    
                    <?php if($study->description): ?>
                    <div class="mb-4">
                        <p class="text-muted mb-0"><?php echo e($study->description); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if($study->buildingComponents && $study->buildingComponents->count() > 0): ?>
                    <div class="mb-4">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-building text-primary mr-2"></i><?php echo e(__('lang.building_components')); ?>

                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500"><?php echo e(__('lang.component')); ?></th>
                                        <th class="fs-13 font-weight-500 text-right"><?php echo e(__('lang.construction_cost')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalBuildingCost = 0; ?>
                                    <?php $__currentLoopData = $study->buildingComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $totalBuildingCost += $bc->construction_cost; ?>
                                    <tr>
                                        <td class="fs-14">
                                            <?php if($bc->buildingComponent && $bc->buildingComponent->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $bc->buildingComponent->icon)); ?>" 
                                                 alt="" class="mr-2" style="width: 20px; height: 20px; object-fit: contain;">
                                            <?php endif; ?>
                                            <?php echo e($bc->buildingComponent ? (app()->getLocale() == 'ar' ? $bc->buildingComponent->name_arabic : $bc->buildingComponent->name_english) : '-'); ?>

                                        </td>
                                        <td class="fs-14 text-right font-weight-500">
                                            <?php echo e(number_format($bc->construction_cost, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="bg-gray-01">
                                        <td class="fs-14 font-weight-600"><?php echo e(__('lang.total')); ?></td>
                                        <td class="fs-14 text-right font-weight-600 text-primary">
                                            <?php echo e(number_format($totalBuildingCost, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if($study->incomeComponents && $study->incomeComponents->count() > 0): ?>
                    <div class="mb-4">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-hand-holding-usd text-primary mr-2"></i><?php echo e(__('lang.income_components')); ?>

                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500"><?php echo e(__('lang.component')); ?></th>
                                        <th class="fs-13 font-weight-500 text-center"><?php echo e(__('lang.number_of_units')); ?></th>
                                        <th class="fs-13 font-weight-500 text-right"><?php echo e(__('lang.rent_per_year')); ?></th>
                                        <th class="fs-13 font-weight-500 text-right"><?php echo e(__('lang.total_income')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalIncome = 0; ?>
                                    <?php $__currentLoopData = $study->incomeComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $lineTotal = $ic->number_of_units * $ic->rent_per_year;
                                        $totalIncome += $lineTotal;
                                    ?>
                                    <tr>
                                        <td class="fs-14">
                                            <?php if($ic->incomeComponent && $ic->incomeComponent->icon): ?>
                                            <img src="<?php echo e(url('/storage' . $ic->incomeComponent->icon)); ?>" 
                                                 alt="" class="mr-2" style="width: 20px; height: 20px; object-fit: contain;">
                                            <?php endif; ?>
                                            <?php echo e($ic->incomeComponent ? (app()->getLocale() == 'ar' ? $ic->incomeComponent->name_arabic : $ic->incomeComponent->name_english) : '-'); ?>

                                        </td>
                                        <td class="fs-14 text-center"><?php echo e(number_format($ic->number_of_units)); ?></td>
                                        <td class="fs-14 text-right">
                                            <?php echo e(number_format($ic->rent_per_year, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                        <td class="fs-14 text-right font-weight-500">
                                            <?php echo e(number_format($lineTotal, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="bg-gray-01">
                                        <td colspan="3" class="fs-14 font-weight-600"><?php echo e(__('lang.total')); ?></td>
                                        <td class="fs-14 text-right font-weight-600 text-success">
                                            <?php echo e(number_format($totalIncome, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if($study->constructionCosts && $study->constructionCosts->count() > 0): ?>
                    <div class="mb-4">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-hard-hat text-primary mr-2"></i><?php echo e(__('lang.construction_costs')); ?>

                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500"><?php echo e(__('lang.category')); ?></th>
                                        <th class="fs-13 font-weight-500"><?php echo e(__('lang.item')); ?></th>
                                        <th class="fs-13 font-weight-500 text-right"><?php echo e(__('lang.cost')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalConstCost = 0; ?>
                                    <?php $__currentLoopData = $study->constructionCosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($cc->substationRoom && $cc->substation_cost): ?>
                                        <?php $totalConstCost += $cc->substation_cost; ?>
                                        <tr>
                                            <td class="fs-14">
                                                <i class="fal fa-bolt text-warning mr-2"></i>
                                                <?php echo e(__('lang.substation_room')); ?>

                                            </td>
                                            <td class="fs-14">
                                                <?php echo e(app()->getLocale() == 'ar' ? $cc->substationRoom->name_arabic : $cc->substationRoom->name_english); ?>

                                            </td>
                                            <td class="fs-14 text-right font-weight-500">
                                                <?php echo e(number_format($cc->substation_cost, 2)); ?>

                                                <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($cc->pumpsRoom && $cc->pumps_cost): ?>
                                        <?php $totalConstCost += $cc->pumps_cost; ?>
                                        <tr>
                                            <td class="fs-14">
                                                <i class="fal fa-water text-info mr-2"></i>
                                                <?php echo e(__('lang.pumps_room')); ?>

                                            </td>
                                            <td class="fs-14">
                                                <?php echo e(app()->getLocale() == 'ar' ? $cc->pumpsRoom->name_arabic : $cc->pumpsRoom->name_english); ?>

                                            </td>
                                            <td class="fs-14 text-right font-weight-500">
                                                <?php echo e(number_format($cc->pumps_cost, 2)); ?>

                                                <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($totalConstCost > 0): ?>
                                    <tr class="bg-gray-01">
                                        <td colspan="2" class="fs-14 font-weight-600"><?php echo e(__('lang.total')); ?></td>
                                        <td class="fs-14 text-right font-weight-600 text-primary">
                                            <?php echo e(number_format($totalConstCost, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if($study->projectCost): ?>
                    <div class="mb-0">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-file-invoice-dollar text-primary mr-2"></i><?php echo e(__('lang.project_costs')); ?>

                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500"><?php echo e(__('lang.cost_type')); ?></th>
                                        <th class="fs-13 font-weight-500 text-right"><?php echo e(__('lang.amount')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $pc = $study->projectCost;
                                        $totalProjectCost = $pc->land_cost + $pc->consultant_cost + $pc->government_fees + $pc->additional_fees;
                                    ?>
                                    <?php if($pc->land_cost > 0): ?>
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-map-marked-alt text-primary mr-2"></i><?php echo e(__('lang.land_cost')); ?></td>
                                        <td class="fs-14 text-right font-weight-500">
                                            <?php echo e(number_format($pc->land_cost, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($pc->consultant_cost > 0): ?>
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-user-tie text-primary mr-2"></i><?php echo e(__('lang.consultant_cost')); ?></td>
                                        <td class="fs-14 text-right font-weight-500">
                                            <?php echo e(number_format($pc->consultant_cost, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($pc->government_fees > 0): ?>
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-landmark text-primary mr-2"></i><?php echo e(__('lang.government_fees')); ?></td>
                                        <td class="fs-14 text-right font-weight-500">
                                            <?php echo e(number_format($pc->government_fees, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($pc->additional_fees > 0): ?>
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-plus-circle text-primary mr-2"></i><?php echo e(__('lang.additional_fees')); ?></td>
                                        <td class="fs-14 text-right font-weight-500">
                                            <?php echo e(number_format($pc->additional_fees, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr class="bg-gray-01">
                                        <td class="fs-14 font-weight-600"><?php echo e(__('lang.total')); ?></td>
                                        <td class="fs-14 text-right font-weight-600 text-primary">
                                            <?php echo e(number_format($totalProjectCost, 2)); ?>

                                            <?php if($study->currency): ?> <?php echo e($study->currency->abbreviation); ?> <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
</section>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/projects/singleproject/feasibility.blade.php ENDPATH**/ ?>