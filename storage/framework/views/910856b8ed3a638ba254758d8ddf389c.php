<?php $__env->startSection('title', 'Floor Components List'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Basicdata')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Floor Components List</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            Floor Components List</h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('floorcomponent.create')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Floor Component</button>
                            </a>
                            <a href="<?php echo e(route('floorcomponent.trashed')); ?>" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Floor Components</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <?php if(count($floorComponents) > 0): ?>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Project Type</th>
                                    <th>Building Component</th>
                                    <th>Name (English)</th>
                                    <th>Name (Arabic)</th>
                                    <th>Icon</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $floorComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floorComponent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($floorComponent->id); ?></td>
                                <td><span class="badge badge-success"><?php echo e($floorComponent->project_type_name); ?></span></td>
                                <td><span class="badge badge-primary"><?php echo e($floorComponent->component_name); ?></span></td>
                                <td><?php echo e($floorComponent->name_english); ?></td>
                                <td><?php echo e($floorComponent->name_arabic); ?></td>
                                <td>
                                    <?php if($floorComponent->icon): ?>
                                        <a data-lightbox="<?php echo e(url('/storage'.$floorComponent->icon)); ?>" href="<?php echo e(url('/storage'.$floorComponent->icon)); ?>">
                                            <img style="width:40px; height: 40px; object-fit: contain;" src="<?php echo e(url('/storage'.$floorComponent->icon)); ?>" alt="Icon">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(\Carbon\Carbon::parse($floorComponent->created_at)->format('M d, Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('floorcomponent.edit', ['id' => $floorComponent->id])); ?>" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo e($floorComponent->id); ?>" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo e($floorComponent->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="<?php echo e(route('floorcomponent.delete', ['id' => $floorComponent->id])); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Floor Component</p>
                                                        <p><strong><?php echo e($floorComponent->name_english); ?></strong></p>
                                                    </div>
                                                    <br>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No floor components found. Click "Add New Component" to create your first floor component.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Basicdata\resources/views/floorcomponents/index.blade.php ENDPATH**/ ?>