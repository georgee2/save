<?php $__env->startSection('title', 'Activity Logs'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .activity-card {
        border-radius: 10px;
        border: 1px solid #e9ecef;
        margin-bottom: 15px;
        transition: all 0.2s ease;
    }
    
    .activity-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-color: #19868b;
    }
    
    .activity-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
    }
    
    .activity-icon.create { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
    .activity-icon.update { background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); }
    .activity-icon.delete { background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); }
    .activity-icon.restore { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }
    .activity-icon.toggle_status { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); }
    .activity-icon.reorder { background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); }
    .activity-icon.bulk_create { background: linear-gradient(135deg, #28a745 0%, #007bff 100%); }
    .activity-icon.force_delete { background: linear-gradient(135deg, #343a40 0%, #212529 100%); }
    .activity-icon.default { background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%); }
    
    .activity-info {
        flex: 1;
    }
    
    .activity-title {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .activity-meta {
        display: flex;
        gap: 15px;
        font-size: 12px;
        color: #6c757d;
    }
    
    .activity-meta i {
        margin-right: 4px;
    }
    
    .activity-body {
        padding: 15px;
    }
    
    .activity-description {
        font-size: 14px;
        color: #495057;
        margin-bottom: 10px;
    }
    
    .changed-fields {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .changed-field {
        font-size: 11px;
        padding: 3px 8px;
        background: #e9ecef;
        border-radius: 4px;
        color: #495057;
    }
    
    .filter-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .badge-action {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .badge-model {
        background: #e3f2fd;
        color: #1565c0;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .view-details-btn {
        padding: 5px 12px;
        font-size: 12px;
        border-radius: 6px;
    }
    
    .stats-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        flex: 1;
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        border: 1px solid #e9ecef;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #19868b;
    }
    
    .stat-label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .pagination-info {
        color: #6c757d;
        font-size: 14px;
    }
    .pagination-wrapper .pagination {
        margin: 0;
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    .pagination-wrapper .pagination .page-item .page-link {
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 14px;
        color: #495057;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover {
        background: #19868b;
        border-color: #19868b;
        color: white;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border-color: #19868b;
        color: white;
        font-weight: 600;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        color: #adb5bd;
        cursor: not-allowed;
    }
    .pagination-wrapper .pagination .page-item .page-link i {
        font-size: 12px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-history"></i> Activity Logs</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-history"></i> Activity Logs</h4>
                            <p class="text-muted mb-0">Track all changes made in the admin panel</p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <span class="text-muted">Total: <?php echo e($logs->total()); ?> records</span>
                        </div>
                    </div>
                    <hr>
                    
                    
                    <div class="filter-card">
                        <form method="GET" action="<?php echo e(route('admin.activity-logs.index')); ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">User</label>
                                        <select name="user_id" class="form-control form-control-sm">
                                            <option value="">All Users</option>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->user_id); ?>" <?php echo e($filters['user_id'] == $user->user_id ? 'selected' : ''); ?>>
                                                <?php echo e($user->user_name); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">Action</label>
                                        <select name="action" class="form-control form-control-sm">
                                            <option value="">All Actions</option>
                                            <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($action); ?>" <?php echo e($filters['action'] == $action ? 'selected' : ''); ?>>
                                                <?php echo e(ucfirst(str_replace('_', ' ', $action))); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">Model</label>
                                        <select name="model_name" class="form-control form-control-sm">
                                            <option value="">All Models</option>
                                            <?php $__currentLoopData = $modelNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($modelName); ?>" <?php echo e($filters['model_name'] == $modelName ? 'selected' : ''); ?>>
                                                <?php echo e($modelName); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">From Date</label>
                                        <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e($filters['date_from']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">To Date</label>
                                        <input type="date" name="date_to" class="form-control form-control-sm" value="<?php echo e($filters['date_to']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">Search</label>
                                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="<?php echo e($filters['search']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-filter"></i> Apply Filters
                                    </button>
                                    <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-times"></i> Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    
                    <?php if($logs->count() > 0): ?>
                    <div class="activity-list">
                        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $actionInfo = $log->getActionLabel();
                            $iconClass = str_replace('_', '-', $log->action);
                        ?>
                        <div class="activity-card">
                            <div class="activity-header">
                                <div class="activity-icon <?php echo e($log->action); ?>">
                                    <i class="fa <?php echo e($actionInfo['icon']); ?>"></i>
                                </div>
                                <div class="activity-info">
                                    <div class="activity-title">
                                        <span class="badge badge-<?php echo e($actionInfo['color']); ?> badge-action mr-2"><?php echo e($actionInfo['label']); ?></span>
                                        <span class="badge badge-model"><?php echo e($log->model_name); ?></span>
                                        <?php if($log->record_title): ?>
                                        <span class="text-muted ml-2">- <?php echo e(Str::limit($log->record_title, 50)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="activity-meta">
                                        <span><i class="fa fa-user"></i> <?php echo e($log->user_name ?? 'System'); ?></span>
                                        <span><i class="fa fa-clock"></i> <?php echo e($log->created_at->format('M d, Y H:i:s')); ?></span>
                                        <span><i class="fa fa-globe"></i> <?php echo e($log->ip_address); ?></span>
                                        <?php if($log->model_id): ?>
                                        <span><i class="fa fa-hashtag"></i> ID: <?php echo e($log->model_id); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <a href="<?php echo e(route('admin.activity-logs.show', $log->id)); ?>" class="btn btn-outline-primary view-details-btn">
                                        <i class="fa fa-eye"></i> Details
                                    </a>
                                </div>
                            </div>
                            <div class="activity-body">
                                <div class="activity-description">
                                    <?php echo e($log->description); ?>

                                </div>
                                <?php if($log->changed_fields && count($log->changed_fields) > 0): ?>
                                <div class="changed-fields">
                                    <span class="text-muted small mr-2">Changed:</span>
                                    <?php $__currentLoopData = $log->changed_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="changed-field"><?php echo e(str_replace('_', ' ', $field)); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    
                    <?php if($logs->hasPages()): ?>
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Showing <?php echo e($logs->firstItem()); ?> to <?php echo e($logs->lastItem()); ?> of <?php echo e($logs->total()); ?> logs
                        </div>
                        <div>
                            <?php echo e($logs->appends($filters)->links('admin::pagination.admin')); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                    <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">No activity logs found matching your criteria.</p>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/activity-logs/index.blade.php ENDPATH**/ ?>