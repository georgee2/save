<?php $__env->startSection('title', 'SEO Pages Management'); ?>

<?php $__env->startSection('css'); ?>
<style>
    :root {
        --main-color: #19868b;
        --secondary-color: #0d6b6f;
        --accent-color: #e1273d;
    }
    .section-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin: -20px -20px 20px -20px;
    }
    .seo-table th {
        background: var(--main-color);
        color: #fff;
        font-weight: 600;
        border: none;
        vertical-align: middle;
    }
    .seo-table td {
        vertical-align: middle;
    }
    .badge-page {
        background: var(--main-color);
        color: #fff;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 20px;
    }
    .badge-empty {
        background: #f8d7da;
        color: #721c24;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 12px;
    }
    .badge-filled {
        background: #d4edda;
        color: #155724;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 12px;
    }
    .btn-edit {
        background: var(--main-color);
        color: #fff;
        border: none;
        padding: 6px 16px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
    }
    .btn-edit:hover {
        background: var(--secondary-color);
        color: #fff;
    }
    .seo-preview {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #6c757d;
        font-size: 13px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-search"></i> SEO Pages</a>
        </nav>

        <div class="col-lg-12">
            <hr>

            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <h4 class="mt-0 mb-0"><i class="fa fa-search"></i> SEO Pages Management</h4>
                        <small>Manage SEO titles, descriptions and keywords for each page</small>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fa fa-check-circle"></i> <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover seo-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Page</th>
                                    <th width="20%">SEO Title (EN)</th>
                                    <th width="20%">SEO Title (AR)</th>
                                    <th width="10%">Description</th>
                                    <th width="10%">Tags</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $seoPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><span class="badge-page"><?php echo e($page->page_name); ?></span></td>
                                    <td>
                                        <div class="seo-preview"><?php echo e($page->seo_title_english ?? '—'); ?></div>
                                    </td>
                                    <td>
                                        <div class="seo-preview" dir="rtl"><?php echo e($page->seo_title_arabic ?? '—'); ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($page->seo_description_english || $page->seo_description_arabic): ?>
                                            <span class="badge-filled"><i class="fa fa-check"></i> Set</span>
                                        <?php else: ?>
                                            <span class="badge-empty"><i class="fa fa-times"></i> Empty</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($page->seo_tags): ?>
                                            <span class="badge-filled"><i class="fa fa-check"></i> Set</span>
                                        <?php else: ?>
                                            <span class="badge-empty"><i class="fa fa-times"></i> Empty</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('admin.seo-pages.edit', $page->id)); ?>" class="btn-edit">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/seo-pages/index.blade.php ENDPATH**/ ?>