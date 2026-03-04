<?php $__env->startSection('title', 'Engineering Categories List'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Basicdata')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Engineering Categories List</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <!-- Success/Error Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong>
                    <ul class="mb-0" style="margin-top: 10px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            Engineering Categories List</h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('engineeringcategory.create')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Category</button>
                            </a>
                            <a href="<?php echo e(route('engineeringcategory.trashed')); ?>" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Categories</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <?php if(count($categories) > 0): ?>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Bio (English)</th>
                                    <th>Icon</th>
                                    <th>Image</th>
                                    <th>Slug</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($category->id); ?></td>
                                <td><?php echo e($category->title_english); ?></td>
                                <td><?php echo e($category->title_arabic); ?></td>
                                <td><?php echo e(\Illuminate\Support\Str::limit($category->bio_english, 50)); ?></td>
                                <td>
                                    <?php if($category->icon): ?>
                                        <a data-lightbox="<?php echo e(url('/storage'.$category->icon)); ?>" href="<?php echo e(url('/storage'.$category->icon)); ?>">
                                            <img style="width:40px; height: 40px; object-fit: contain;" src="<?php echo e(url('/storage'.$category->icon)); ?>" alt="Icon">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($category->image): ?>
                                        <a data-lightbox="<?php echo e(url('/storage'.$category->image)); ?>" href="<?php echo e(url('/storage'.$category->image)); ?>">
                                            <img style="width:80px; height: 60px; object-fit: cover;" src="<?php echo e(url('/storage'.$category->image)); ?>" alt="Image">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge badge-info"><?php echo e($category->slug); ?></span></td>
                                <td><?php echo e(\Carbon\Carbon::parse($category->created_at)->format('M d, Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('engineeringcategory.show', ['id' => $category->id])); ?>" class="btn btn-primary btn-sm mr-2" title="Show">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
                                    <a href="<?php echo e(route('engineeringcategory.edit', ['id' => $category->id])); ?>" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo e($category->id); ?>" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo e($category->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="<?php echo e(route('engineeringcategory.delete', ['id' => $category->id])); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Engineering Category</p>
                                                        <p><strong><?php echo e($category->title_english); ?></strong></p>
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
                            <i class="fa fa-info-circle"></i> No engineering categories found. Click "Add New Category" to create your first engineering category.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Basicdata\resources/views/engineeringcategories/index.blade.php ENDPATH**/ ?>