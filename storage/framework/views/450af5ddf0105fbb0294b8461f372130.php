<?php
    $components = \App\Models\ProjectLengthComponent::getByProject($project->id);
    $trashedComponents = \App\Models\ProjectLengthComponent::getTrashedByProject($project->id);
?>

<?php if($components->count() > 0 || $trashedComponents->count() > 0): ?>
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Building Component</th>
                <th>Length Component</th>
                <th>Icon</th>
                <th>Unit Cost</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($component->id); ?></td>
                <td>
                    <strong><?php echo e($component->building_component_name_english); ?></strong><br>
                    <small class="text-muted"><?php echo e($component->building_component_name_arabic); ?></small>
                </td>
                <td>
                    <strong><?php echo e($component->length_component_name_english); ?></strong><br>
                    <small class="text-muted"><?php echo e($component->length_component_name_arabic); ?></small>
                </td>
                <td>
                    <?php if($component->length_component_icon): ?>
                        <img style="width:40px; height: 40px; object-fit: contain;" src="<?php echo e(url('/storage'.$component->length_component_icon)); ?>" alt="Icon">
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
                <td><span class="badge badge-success"><?php echo e(number_format($component->unit_cost, 2)); ?></span></td>
                <td><?php echo e(\Carbon\Carbon::parse($component->created_at)->format('M d, Y')); ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditLengthModal(<?php echo e($component->id); ?>, '<?php echo e($component->building_component_name_english); ?> - <?php echo e($component->length_component_name_english); ?>', <?php echo e($component->unit_cost); ?>)" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteLengthModal(<?php echo e($component->id); ?>, '<?php echo e($component->length_component_name_english); ?>')" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($trashedComponents->count() > 0): ?>
            <tr class="bg-light">
                <td colspan="7" class="text-center"><strong><i class="fa fa-trash"></i> Trashed Length Components</strong></td>
            </tr>
            <?php $__currentLoopData = $trashedComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="table-secondary">
                <td><?php echo e($component->id); ?></td>
                <td>
                    <strong><?php echo e($component->building_component_name_english); ?></strong>
                </td>
                <td>
                    <strong><?php echo e($component->length_component_name_english); ?></strong>
                </td>
                <td>-</td>
                <td><span class="badge badge-secondary"><?php echo e(number_format($component->unit_cost, 2)); ?></span></td>
                <td><?php echo e(\Carbon\Carbon::parse($component->deleted_at)->format('M d, Y H:i')); ?></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" onclick="restoreLengthComponent(<?php echo e($component->id); ?>)" title="Restore">
                        <i class="fa fa-undo"></i> Restore
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
        <tfoot class="bg-light">
            <tr>
                <th colspan="4" class="text-right">Total Unit Cost:</th>
                <th colspan="3">
                    <span class="badge badge-primary" style="font-size: 14px;">
                        <?php echo e(number_format($components->sum('unit_cost'), 2)); ?>

                    </span>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
<?php else: ?>
<div class="alert alert-warning mt-3">
    <i class="fa fa-exclamation-triangle"></i> 
    No length components have been added to this project yet. Click "Add Length Component" to get started.
</div>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/lengthcomponents/_list.blade.php ENDPATH**/ ?>