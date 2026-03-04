<?php
    $components = \App\Models\ProjectBuildingComponent::getByProject($project->id);
    $trashedComponents = \App\Models\ProjectBuildingComponent::getTrashedByProject($project->id);
?>

<?php if($components->count() > 0 || $trashedComponents->count() > 0): ?>
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Component Name</th>
                <th>Icon</th>
                <th>Construction Cost</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($component->id); ?></td>
                <td>
                    <strong><?php echo e($component->name_english); ?></strong><br>
                    <small class="text-muted"><?php echo e($component->name_arabic); ?></small>
                </td>
                <td>
                    <?php if($component->icon): ?>
                        <img style="width:40px; height: 40px; object-fit: contain;" src="<?php echo e(url('/storage'.$component->icon)); ?>" alt="Icon">
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
                <td><span class="badge badge-success"><?php echo e(number_format($component->construction_cost, 2)); ?></span></td>
                <td><?php echo e(\Carbon\Carbon::parse($component->created_at)->format('M d, Y')); ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(<?php echo e($component->id); ?>, '<?php echo e($component->name_english); ?> - <?php echo e($component->name_arabic); ?>', <?php echo e($component->construction_cost); ?>)" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(<?php echo e($component->id); ?>, '<?php echo e($component->name_english); ?>')" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($trashedComponents->count() > 0): ?>
            <tr class="bg-light">
                <td colspan="6" class="text-center"><strong><i class="fa fa-trash"></i> Trashed Components</strong></td>
            </tr>
            <?php $__currentLoopData = $trashedComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="table-secondary">
                <td><?php echo e($component->id); ?></td>
                <td>
                    <strong><?php echo e($component->name_english); ?></strong><br>
                    <small class="text-muted"><?php echo e($component->name_arabic); ?></small>
                </td>
                <td>-</td>
                <td><span class="badge badge-secondary"><?php echo e(number_format($component->construction_cost, 2)); ?></span></td>
                <td><?php echo e(\Carbon\Carbon::parse($component->deleted_at)->format('M d, Y H:i')); ?></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" onclick="restoreComponent(<?php echo e($component->id); ?>)" title="Restore">
                        <i class="fa fa-undo"></i> Restore
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
        <tfoot class="bg-light">
            <tr>
                <th colspan="3" class="text-right">Total Construction Cost:</th>
                <th colspan="3">
                    <span class="badge badge-primary" style="font-size: 14px;">
                        <?php echo e(number_format($components->sum('construction_cost'), 2)); ?>

                    </span>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
<?php else: ?>
<div class="alert alert-warning mt-3">
    <i class="fa fa-exclamation-triangle"></i> 
    No building components have been added to this project yet. Click "Add Component" to get started.
</div>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/buildingcomponents/_list.blade.php ENDPATH**/ ?>