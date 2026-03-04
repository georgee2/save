<?php
    $specifications = \App\Models\ProjectSpecification::getByProject($project->id);
    $trashedSpecifications = \App\Models\ProjectSpecification::getTrashedByProject($project->id);
?>

<?php if($specifications->count() > 0 || $trashedSpecifications->count() > 0): ?>
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Specification</th>
                <th>Icon</th>
                <th>Value (English)</th>
                <th>Value (Arabic)</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($spec->id); ?></td>
                <td>
                    <strong><?php echo e($spec->title_english); ?></strong><br>
                    <small class="text-muted"><?php echo e($spec->title_arabic); ?></small>
                </td>
                <td>
                    <?php if($spec->icon): ?>
                        <img style="width:40px; height: 40px; object-fit: contain;" src="<?php echo e(url('/storage'.$spec->icon)); ?>" alt="Icon">
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($spec->value_english); ?></td>
                <td dir="rtl"><?php echo e($spec->value_arabic); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($spec->created_at)->format('M d, Y')); ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" 
                        onclick="openEditSpecificationModal(<?php echo e($spec->id); ?>, '<?php echo e($spec->title_english); ?>', '<?php echo e(addslashes($spec->value_english)); ?>', '<?php echo e(addslashes($spec->value_arabic)); ?>')" 
                        title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" 
                        onclick="openDeleteSpecificationModal(<?php echo e($spec->id); ?>, '<?php echo e($spec->title_english); ?>')" 
                        title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<?php if($trashedSpecifications->count() > 0): ?>
    <hr>
    <h6 class="text-danger mt-3 mb-2"><i class="fa fa-trash-o"></i> Deleted Specifications</h6>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Specification</th>
                    <th>Value (English)</th>
                    <th>Value (Arabic)</th>
                    <th>Deleted Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $trashedSpecifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="opacity: 0.7;">
                    <td><?php echo e($spec->id); ?></td>
                    <td>
                        <strong class="text-danger"><?php echo e($spec->title_english); ?></strong><br>
                        <small class="text-muted"><?php echo e($spec->title_arabic); ?></small>
                    </td>
                    <td><?php echo e($spec->value_english); ?></td>
                    <td dir="rtl"><?php echo e($spec->value_arabic); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($spec->deleted_at)->format('M d, Y')); ?></td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" 
                            onclick="restoreSpecification(<?php echo e($spec->id); ?>)" 
                            title="Restore">
                            <i class="fa fa-undo"></i> Restore
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" 
                            onclick="openForceDeleteSpecificationModal(<?php echo e($spec->id); ?>, '<?php echo e($spec->title_english); ?>')" 
                            title="Permanently Delete">
                            <i class="fa fa-times"></i> Force Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php else: ?>
<div class="alert alert-warning text-center mt-3">
    <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
    <h6>No Specifications Added Yet</h6>
    <p class="mb-2">Start by adding specifications to describe your project.</p>
    <button type="button" class="btn btn-primary btn-sm" onclick="openAddSpecificationModal()">
        <i class="fa fa-plus"></i> Add First Specification
    </button>
</div>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/specifications/_list.blade.php ENDPATH**/ ?>