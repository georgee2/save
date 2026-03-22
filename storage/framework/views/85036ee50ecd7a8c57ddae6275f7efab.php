<?php $__env->startSection('title', 'Contact Us Messages'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .filter-toggle-btn {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .filter-toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
        color: white;
    }
    .filter-toggle-btn i { transition: transform 0.3s ease; }
    .filter-toggle-btn.active i { transform: rotate(180deg); }
    .filter-panel {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
        display: none;
    }
    .filter-panel.show {
        display: block;
        animation: slideDown 0.3s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .filter-panel .form-group label {
        font-weight: 600;
        color: #495057;
        font-size: 13px;
        margin-bottom: 5px;
    }
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }
    .active-filter-tag {
        background: #19868b;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .active-filter-tag .remove-filter { cursor: pointer; opacity: 0.8; }
    .active-filter-tag .remove-filter:hover { opacity: 1; }
    .status-badge-pending { background: #ffc107; color: #333; }
    .status-badge-inprogress { background: #17a2b8; color: #fff; }
    .status-badge-done { background: #28a745; color: #fff; }
    .status-count-card {
        border-radius: 8px;
        padding: 12px 20px;
        text-align: center;
        color: white;
        flex: 1;
    }
    .status-count-card .count { font-size: 24px; font-weight: 700; }
    .status-count-card .label { font-size: 12px; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px; }
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .pagination-info { color: #6c757d; font-size: 14px; }
    .pagination-wrapper .pagination { margin: 0; display: flex; gap: 5px; flex-wrap: wrap; }
    .pagination-wrapper .pagination .page-item .page-link {
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 14px;
        color: #495057;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover { background: #19868b; border-color: #19868b; color: white; }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border-color: #19868b;
        color: white;
        font-weight: 600;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link { background: #f8f9fa; color: #adb5bd; }
    .msg-preview {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #666;
        font-size: 13px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="<?php echo e(route('CRM')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-envelope"></i> Contact Us Messages</a>
        </nav>

        <div class="col-lg-12">
            <hr>

            
            <div class="d-flex gap-3 mb-4" style="gap: 15px;">
                <div class="status-count-card" style="background: linear-gradient(135deg, #ffc107, #e0a800);">
                    <div class="count"><?php echo e($statusCounts['Pending'] ?? 0); ?></div>
                    <div class="label">Pending</div>
                </div>
                <div class="status-count-card" style="background: linear-gradient(135deg, #17a2b8, #117a8b);">
                    <div class="count"><?php echo e($statusCounts['InProgress'] ?? 0); ?></div>
                    <div class="label">In Progress</div>
                </div>
                <div class="status-count-card" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                    <div class="count"><?php echo e($statusCounts['Done'] ?? 0); ?></div>
                    <div class="label">Done</div>
                </div>
                <div class="status-count-card" style="background: linear-gradient(135deg, #19868b, #0d6b6f);">
                    <div class="count"><?php echo e($totalCount); ?></div>
                    <div class="label">Total</div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mt-0 header-title align-self-center">
                            <i class="fa fa-envelope" style="color: #19868b;"></i> Contact Us Messages
                            <span class="badge badge-secondary ml-2"><?php echo e($totalCount); ?></span>
                        </h4>
                        <div class="buttons">
                            <button type="button" class="btn filter-toggle-btn mr-2" id="filterToggleBtn">
                                <i class="fa fa-filter"></i> Filters
                            </button>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>

                    
                    <div class="filter-panel" id="filterPanel">
                        <form action="<?php echo e(route('crm-contact-us.index')); ?>" method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-user"></i> Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo e(request('name')); ?>" placeholder="Search name...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-envelope"></i> Email</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo e(request('email')); ?>" placeholder="Search email...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-phone"></i> Phone</label>
                                        <input type="text" class="form-control" name="phone" value="<?php echo e(request('phone')); ?>" placeholder="Search phone...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-flag"></i> Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">All Statuses</option>
                                            <option value="Pending" <?php echo e(request('status') === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                            <option value="InProgress" <?php echo e(request('status') === 'InProgress' ? 'selected' : ''); ?>>In Progress</option>
                                            <option value="Done" <?php echo e(request('status') === 'Done' ? 'selected' : ''); ?>>Done</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-cogs"></i> Service</label>
                                        <select class="form-control" name="service_id">
                                            <option value="">All Services</option>
                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id); ?>" <?php echo e(request('service_id') == $service->id ? 'selected' : ''); ?>><?php echo e($service->title_english); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-user-secret"></i> Agent</label>
                                        <select class="form-control" name="agent">
                                            <option value="">All Agents</option>
                                            <option value="unassigned" <?php echo e(request('agent') === 'unassigned' ? 'selected' : ''); ?>>Unassigned</option>
                                            <?php $__currentLoopData = $agentsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agentItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($agentItem->id); ?>" <?php echo e(request('agent') == $agentItem->id ? 'selected' : ''); ?>><?php echo e($agentItem->full_name_en); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-calendar"></i> Date From</label>
                                        <input type="date" class="form-control" name="date_from" value="<?php echo e(request('date_from')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-calendar"></i> Date To</label>
                                        <input type="date" class="form-control" name="date_to" value="<?php echo e(request('date_to')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <a href="<?php echo e(route('crm-contact-us.index')); ?>" class="btn btn-secondary btn-block"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    
                    <?php if(request()->hasAny(['name', 'email', 'phone', 'status', 'service_id', 'agent', 'date_from', 'date_to'])): ?>
                    <div class="active-filters">
                        <span class="text-muted mr-2"><i class="fa fa-filter"></i> Active Filters:</span>
                        <?php if(request('name')): ?>
                            <span class="active-filter-tag">
                                Name: <?php echo e(request('name')); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['name' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('email')): ?>
                            <span class="active-filter-tag">
                                Email: <?php echo e(request('email')); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['email' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('phone')): ?>
                            <span class="active-filter-tag">
                                Phone: <?php echo e(request('phone')); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['phone' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('status')): ?>
                            <span class="active-filter-tag">
                                Status: <?php echo e(request('status')); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['status' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('service_id')): ?>
                            <span class="active-filter-tag">
                                Service: <?php echo e($services->firstWhere('id', request('service_id'))->title_english ?? request('service_id')); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['service_id' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('agent')): ?>
                            <span class="active-filter-tag">
                                Agent: <?php echo e(request('agent') === 'unassigned' ? 'Unassigned' : ($agentsList->firstWhere('id', request('agent'))->full_name_en ?? request('agent'))); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['agent' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('date_from')): ?>
                            <span class="active-filter-tag">
                                From: <?php echo e(request('date_from')); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['date_from' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('date_to')): ?>
                            <span class="active-filter-tag">
                                To: <?php echo e(request('date_to')); ?>

                                <a href="<?php echo e(request()->fullUrlWithQuery(['date_to' => null])); ?>" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Service</th>
                                    <th>Message</th>
                                    <th>Agent</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($contact->id); ?></td>
                                    <td><strong><?php echo e($contact->name); ?></strong></td>
                                    <td><a href="mailto:<?php echo e($contact->email); ?>"><?php echo e($contact->email); ?></a></td>
                                    <td>
                                        <?php if($contact->phone): ?>
                                            <a href="tel:<?php echo e($contact->phone); ?>"><?php echo e($contact->phone); ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">---</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($contact->subject); ?></td>
                                    <td>
                                        <?php if($contact->service_name): ?>
                                            <span class="badge badge-info"><?php echo e($contact->service_name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">---</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><div class="msg-preview" title="<?php echo e($contact->message); ?>"><?php echo e($contact->message); ?></div></td>
                                    <td>
                                        <?php if($contact->agent_name): ?>
                                            <span class="badge badge-dark" style="font-size: 12px;"><i class="fa fa-user-secret"></i> <?php echo e($contact->agent_name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">---</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($contact->status === 'Pending'): ?>
                                            <span class="badge status-badge-pending" style="font-size: 12px;"><i class="fa fa-clock-o"></i> Pending</span>
                                        <?php elseif($contact->status === 'InProgress'): ?>
                                            <span class="badge status-badge-inprogress" style="font-size: 12px;"><i class="fa fa-spinner"></i> In Progress</span>
                                        <?php else: ?>
                                            <span class="badge status-badge-done" style="font-size: 12px;"><i class="fa fa-check"></i> Done</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('M d, Y')); ?></small>
                                        <br><small class="text-muted"><?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('h:i A')); ?></small>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('crm-contact-us.show', $contact->id)); ?>" class="btn btn-info btn-sm" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <form action="<?php echo e(route('crm-contact-us.delete', $contact->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <i class="fa fa-envelope-o fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No contact messages found.</p>
                                        <?php if(request()->hasAny(['name', 'email', 'phone', 'status', 'service_id', 'agent', 'date_from', 'date_to'])): ?>
                                            <a href="<?php echo e(route('crm-contact-us.index')); ?>" class="btn btn-sm btn-primary">Clear Filters</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($contacts->hasPages()): ?>
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Showing <?php echo e($contacts->firstItem()); ?> to <?php echo e($contacts->lastItem()); ?> of <?php echo e($contacts->total()); ?> messages
                        </div>
                        <div>
                            <?php echo e($contacts->links('admin::pagination.admin')); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    var filterToggleBtn = document.getElementById('filterToggleBtn');
    var filterPanel = document.getElementById('filterPanel');

    <?php if(request()->hasAny(['name', 'email', 'phone', 'status', 'service_id', 'agent', 'date_from', 'date_to'])): ?>
        filterPanel.classList.add('show');
        filterToggleBtn.classList.add('active');
    <?php endif; ?>

    filterToggleBtn.addEventListener('click', function() {
        filterPanel.classList.toggle('show');
        this.classList.toggle('active');
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/CRM\resources/views/contact-us/index.blade.php ENDPATH**/ ?>