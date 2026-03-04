<?php
    $floors = \App\Models\ProjectFloor::getByProject($project->id);
?>

<div class="floors-summary-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0"><i class="fa fa-layer-group"></i> Project Floors</h5>
        <a href="<?php echo e(route('project.floor.index', ['projectId' => $project->id])); ?>" class="btn btn-primary btn-sm">
            <i class="fa fa-list"></i> Manage Floors
        </a>
    </div>
    
    <?php if($floors->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 60px;">Icon</th>
                        <th>Floor Component</th>
                        <th>Building Component</th>
                        <th>Area (SqFt)</th>
                        <th>Area (SqM)</th>
                        <th>Count</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $floors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center">
                            <?php if($floor->floor_component_icon): ?>
                                <img src="<?php echo e(asset('storage' . $floor->floor_component_icon)); ?>" 
                                     style="width: 40px; height: 40px; object-fit: contain;" 
                                     alt="Floor Icon">
                            <?php else: ?>
                                <i class="fa fa-layer-group fa-2x text-muted"></i>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo e($floor->floor_component_name_en); ?></strong><br>
                            <small class="text-muted"><?php echo e($floor->floor_component_name_ar); ?></small>
                        </td>
                        <td>
                            <span class="badge badge-primary"><?php echo e($floor->building_component_name_en); ?></span>
                        </td>
                        <td><?php echo e(number_format($floor->sqft, 2)); ?> ft²</td>
                        <td><?php echo e(number_format($floor->sqm, 2)); ?> m²</td>
                        <td>
                            <span class="badge badge-success"><?php echo e($floor->count); ?></span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <?php if($floor->image_2d): ?>
                                    <img src="<?php echo e(asset('storage' . $floor->image_2d)); ?>" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; cursor: pointer;" 
                                         onclick="openLightbox('<?php echo e(asset('storage' . $floor->image_2d)); ?>')" 
                                         title="2D Image">
                                <?php endif; ?>
                                <?php if($floor->image_3d): ?>
                                    <img src="<?php echo e(asset('storage' . $floor->image_3d)); ?>" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; cursor: pointer;" 
                                         onclick="openLightbox('<?php echo e(asset('storage' . $floor->image_3d)); ?>')" 
                                         title="3D Image">
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <a href="<?php echo e(route('project.floor.show', ['projectId' => $project->id, 'id' => $floor->id])); ?>" 
                               class="btn btn-info btn-sm" title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('project.floor.edit', ['projectId' => $project->id, 'id' => $floor->id])); ?>" 
                               class="btn btn-warning btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <div class="alert alert-info mt-3">
            <i class="fa fa-info-circle"></i> 
            <strong>Total Floors:</strong> <?php echo e($floors->count()); ?> floor component(s) added to this project.
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
            <h6>No Floors Added Yet</h6>
            <p class="mb-2">Start by adding floors to this project.</p>
            <a href="<?php echo e(route('project.floor.create', ['projectId' => $project->id])); ?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add First Floor
            </a>
        </div>
    <?php endif; ?>
</div>

<?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/floors/_list.blade.php ENDPATH**/ ?>