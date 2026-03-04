<?php
    $costs = \App\Models\ProjectConstructionCost::getByProject($project->id);
    $trashedCosts = \App\Models\ProjectConstructionCost::getTrashedByProject($project->id);
?>

<?php if($costs->count() > 0 || $trashedCosts->count() > 0): ?>
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Feasibility Study Component</th>
                <th>Target</th>
                <th>Substation Room</th>
                <th>Pumps Room</th>
                <th>Total Cost</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $costs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($cost->id); ?></td>
                <td>
                    <strong><?php echo e($cost->fsc_header_english); ?></strong><br>
                    <small class="text-muted"><?php echo e($cost->fsc_header_arabic); ?></small><br>
                    <span class="badge badge-secondary"><?php echo e($cost->fsc_title_english); ?></span>
                </td>
                <td>
                    <?php if($cost->fsc_target == 'Building Components'): ?>
                        <span class="badge badge-info"><i class="fa fa-cube"></i> <?php echo e($cost->fsc_target); ?></span>
                    <?php elseif($cost->fsc_target == 'Income Components'): ?>
                        <span class="badge badge-success"><i class="fa fa-dollar"></i> <?php echo e($cost->fsc_target); ?></span>
                    <?php else: ?>
                        <span class="badge badge-warning"><i class="mdi mdi-ruler"></i> <?php echo e($cost->fsc_target); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($cost->substation_name_english): ?>
                        <strong><?php echo e($cost->substation_name_english); ?></strong><br>
                        <small class="text-muted"><?php echo e($cost->substation_name_arabic); ?></small><br>
                        <span class="badge badge-primary"><?php echo e(number_format($cost->substation_price, 2)); ?></span>
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($cost->pumps_name_english): ?>
                        <strong><?php echo e($cost->pumps_name_english); ?></strong><br>
                        <small class="text-muted"><?php echo e($cost->pumps_name_arabic); ?></small><br>
                        <span class="badge badge-primary"><?php echo e(number_format($cost->pumps_price, 2)); ?></span>
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge badge-success" style="font-size: 14px;">
                        <?php echo e(number_format(($cost->substation_price ?? 0) + ($cost->pumps_price ?? 0), 2)); ?>

                    </span>
                </td>
                <td><?php echo e(\Carbon\Carbon::parse($cost->created_at)->format('M d, Y')); ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditConstructionCostModal(<?php echo e($cost->id); ?>, <?php echo e($cost->substation_room_id ?? 'null'); ?>, <?php echo e($cost->pumps_room_id ?? 'null'); ?>)" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteConstructionCostModal(<?php echo e($cost->id); ?>, '<?php echo e($cost->fsc_header_english); ?>')" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($trashedCosts->count() > 0): ?>
            <tr class="bg-light">
                <td colspan="8" class="text-center"><strong><i class="fa fa-trash"></i> Trashed Construction Costs</strong></td>
            </tr>
            <?php $__currentLoopData = $trashedCosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="table-secondary">
                <td><?php echo e($cost->id); ?></td>
                <td>
                    <strong><?php echo e($cost->fsc_header_english); ?></strong>
                </td>
                <td>-</td>
                <td>
                    <?php if($cost->substation_name_english): ?>
                        <?php echo e($cost->substation_name_english); ?>

                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($cost->pumps_name_english): ?>
                        <?php echo e($cost->pumps_name_english); ?>

                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
                <td>-</td>
                <td><?php echo e(\Carbon\Carbon::parse($cost->deleted_at)->format('M d, Y H:i')); ?></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" onclick="restoreConstructionCost(<?php echo e($cost->id); ?>)" title="Restore">
                        <i class="fa fa-undo"></i> Restore
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
        <tfoot class="bg-light">
            <tr>
                <th colspan="5" class="text-right">Total Construction Cost:</th>
                <th colspan="3">
                    <span class="badge badge-primary" style="font-size: 14px;">
                        <?php echo e(number_format($costs->sum(function($cost) { return ($cost->substation_price ?? 0) + ($cost->pumps_price ?? 0); }), 2)); ?>

                    </span>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
<?php else: ?>
<div class="alert alert-warning mt-3">
    <i class="fa fa-exclamation-triangle"></i> 
    No construction costs have been added to this project yet. Click "Add Construction Cost" to get started.
</div>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/constructioncosts/_list.blade.php ENDPATH**/ ?>