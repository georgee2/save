<?php $__env->startSection('title', 'Engineering Sub Categories List'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Basicdata')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Eng.Sub Categories List</a> 
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
                            Engineering Sub Categories List</h4>
                        <div class="buttons">
                            <a href="<?php echo e(route('engineeringsubcategory.create')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Sub Category</button>
                            </a>
                            <a href="<?php echo e(route('engineeringsubcategory.trashed')); ?>" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Sub Categories</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <?php if(count($subCategories) > 0): ?>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
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
                                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($subCategory->id); ?></td>
                                <td><span class="badge badge-primary"><?php echo e($subCategory->category_name); ?></span></td>
                                <td><?php echo e($subCategory->title_english); ?></td>
                                <td><?php echo e($subCategory->title_arabic); ?></td>
                                <td><?php echo e(\Illuminate\Support\Str::limit($subCategory->bio_english, 50)); ?></td>
                                <td>
                                    <?php if($subCategory->icon): ?>
                                        <a data-lightbox="<?php echo e(url('/storage'.$subCategory->icon)); ?>" href="<?php echo e(url('/storage'.$subCategory->icon)); ?>">
                                            <img style="width:40px; height: 40px; object-fit: contain;" src="<?php echo e(url('/storage'.$subCategory->icon)); ?>" alt="Icon">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($subCategory->image): ?>
                                        <a data-lightbox="<?php echo e(url('/storage'.$subCategory->image)); ?>" href="<?php echo e(url('/storage'.$subCategory->image)); ?>">
                                            <img style="width:80px; height: 60px; object-fit: cover;" src="<?php echo e(url('/storage'.$subCategory->image)); ?>" alt="Image">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge badge-info"><?php echo e($subCategory->slug); ?></span></td>
                                <td><?php echo e(\Carbon\Carbon::parse($subCategory->created_at)->format('M d, Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('engineeringsubcategory.show', ['id' => $subCategory->id])); ?>" class="btn btn-primary btn-sm mr-2" title="Show">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
                                    <a href="<?php echo e(route('engineeringsubcategory.edit', ['id' => $subCategory->id])); ?>" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo e($subCategory->id); ?>" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo e($subCategory->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="<?php echo e(route('engineeringsubcategory.delete', ['id' => $subCategory->id])); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Sub Category</p>
                                                        <p><strong><?php echo e($subCategory->title_english); ?></strong></p>
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
                            <i class="fa fa-info-circle"></i> No engineering subcategories found. Click "Add New Subcategory" to create your first engineering subcategory.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Basicdata\resources/views/engineeringsubcategories/index.blade.php ENDPATH**/ ?>