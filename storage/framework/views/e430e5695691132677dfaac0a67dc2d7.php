<?php $__env->startSection('title', 'View Favourites - ' . $meta->ref_id); ?>
<?php $__env->startSection('css'); ?>
<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
    .text-gray-300 { color: #dddfeb !important; }
    .text-gray-800 { color: #5a5c69 !important; }
    .shadow-sm { box-shadow: 0 0.125rem 0.25rem 0 rgba(58,59,69,.2) !important; }
    .text-xs { font-size: .7rem; font-weight: 700; letter-spacing: .5px; }
    .card { transition: box-shadow .3s ease; }
    .card:hover { box-shadow: 0 .5rem 1rem 0 rgba(58,59,69,.3) !important; }
    .item-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 2px solid #eee; }
    .section-title { font-size: 18px; font-weight: 600; margin-bottom: 15px; }
    .share-link-box { background: #f8f9fc; border: 1px solid #e3e6f0; border-radius: 6px; padding: 10px 15px; font-size: 13px; word-break: break-all; }

    .agent-box {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%);
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 25px;
        position: relative;
        overflow: hidden;
    }
    .agent-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4e73df, #1cc88a, #36b9cc);
    }
    .agent-box .agent-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 28px;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
    }
    .agent-box .agent-detail-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #858796;
        margin-bottom: 3px;
    }
    .agent-box .agent-detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #2d3748;
    }
    .agent-no-assigned {
        background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
        border: 1px dashed #f6c23e;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
    }
    .agent-no-assigned .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 35px;
        color: #f6c23e;
        margin-bottom: 15px;
        box-shadow: 0 4px 15px rgba(246, 194, 62, 0.2);
    }

    .assign-modal-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        margin-bottom: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .assign-modal-icon.assign { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: #fff; }
    .assign-modal-icon.unassign { background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%); color: #fff; }
    .assign-modal-select {
        border: 2px solid #d1d3e2;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 15px;
        font-weight: 600;
        color: #2d3748;
        transition: all 0.3s ease;
        background-color: #fff;
        height: auto !important;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234e73df' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 40px;
        cursor: pointer;
    }
    .assign-modal-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        background-color: #fff;
        outline: none;
    }
    .assign-modal-select option {
        font-weight: 600;
        color: #2d3748;
        padding: 10px;
    }
    .assign-modal-select option:disabled {
        color: #adb5bd;
        font-weight: 400;
    }

    /* Timeline Comments */
    .timeline-section {
        position: relative;
        padding: 0;
    }
    .timeline-section::before {
        content: '';
        position: absolute;
        left: 28px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #4e73df 0%, #e9ecef 100%);
        border-radius: 3px;
    }
    .timeline-item {
        position: relative;
        padding-left: 65px;
        padding-bottom: 30px;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    .timeline-dot {
        position: absolute;
        left: 18px;
        top: 2px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #4e73df;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .timeline-dot i {
        font-size: 10px;
        color: #fff;
    }
    .timeline-card {
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: box-shadow 0.3s ease;
    }
    .timeline-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }
    .timeline-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    .timeline-author {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .timeline-author-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .timeline-author-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 14px;
    }
    .timeline-date {
        font-size: 12px;
        color: #858796;
    }
    .timeline-body {
        color: #4a5568;
        font-size: 14px;
        line-height: 1.6;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .timeline-delete-btn {
        background: none;
        border: none;
        color: #ccc;
        font-size: 14px;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .timeline-delete-btn:hover {
        color: #e74a3b;
        background: #fdf2f2;
    }
    .comment-form-box {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%);
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 20px;
        position: relative;
        overflow: hidden;
    }
    .comment-form-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #4e73df, #36b9cc);
    }
    .comment-textarea {
        border: 2px solid #d1d3e2;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        color: #2d3748;
        resize: vertical;
        min-height: 80px;
        transition: all 0.3s ease;
        width: 100%;
    }
    .comment-textarea:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        outline: none;
    }
    .comment-textarea::placeholder {
        color: #adb5bd;
    }
    .timeline-empty {
        text-align: center;
        padding: 30px 20px;
        color: #858796;
    }
    .timeline-empty i {
        font-size: 40px;
        color: #dee2e6;
        margin-bottom: 10px;
        display: block;
    }
    .edit-input {
        border: 2px solid #d1d3e2;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 600;
        color: #2d3748;
        transition: all 0.3s ease;
        background-color: #fff;
        width: 100%;
    }
    .edit-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        outline: none;
    }
    .delete-item-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid #f5c6cb;
        background: #fff;
        color: #e74a3b;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 13px;
    }
    .delete-item-btn:hover {
        background: #e74a3b;
        color: #fff;
        border-color: #e74a3b;
    }
    .email-action-card {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%);
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        transition: box-shadow 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .email-action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
    }
    .email-action-card.direct::before { background: linear-gradient(90deg, #4e73df, #224abe); }
    .email-action-card.notify::before { background: linear-gradient(90deg, #1cc88a, #17a673); }
    .email-action-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .email-action-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 12px;
    }
    .email-action-icon.direct { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: #fff; }
    .email-action-icon.notify { background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); color: #fff; }
    .email-log-item {
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 18px 20px;
        margin-bottom: 15px;
        background: #fff;
        transition: box-shadow 0.3s;
    }
    .email-log-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
    .email-log-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .email-log-badge.direct { background: #e8eaf6; color: #4e73df; }
    .email-log-badge.notification { background: #e8f5e9; color: #1cc88a; }
    .email-attachment-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        background: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        font-size: 12px;
        color: #5a5c69;
        margin-right: 5px;
        margin-top: 5px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="<?php echo e(route('CRM')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('crm-favourites.index')); ?>" class="breadcrumbs__item"><i class="fa fa-heart"></i> Favourites List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Favourites</a>
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
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #e74a3b; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong> <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            <i class="fa fa-heart text-danger"></i> Favourite Session Details
                        </h4>
                        <div class="buttons">
                            <a href="<?php echo e($meta->share_url); ?>" target="_blank" class="mr-2">
                                <button class="btn btn-success"><i class="fa fa-external-link"></i> Open Shared Page</button>
                            </a>
                            <a href="<?php echo e(route('crm-favourites.index')); ?>" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Favourites List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>

                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ref ID</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <code style="font-size: 16px;"><?php echo e($meta->ref_id); ?></code>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fa fa-hashtag fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-<?php echo e($meta->is_expired ? 'danger' : 'success'); ?> shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-<?php echo e($meta->is_expired ? 'danger' : 'success'); ?> text-uppercase mb-1">Status</div>
                                            <div class="h6 mb-0">
                                                <?php if($meta->is_permanent): ?>
                                                    <span class="badge badge-primary" style="font-size: 14px; padding: 8px 12px;"><i class="fa fa-lock"></i> Permanent</span>
                                                <?php elseif($meta->is_expired): ?>
                                                    <span class="badge badge-danger" style="font-size: 14px; padding: 8px 12px;"><i class="fa fa-times-circle"></i> Expired</span>
                                                <?php else: ?>
                                                    <span class="badge badge-success" style="font-size: 14px; padding: 8px 12px;"><i class="fa fa-check-circle"></i> Active</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fa fa-heartbeat fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-info shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Items</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalCount); ?></div>
                                        </div>
                                        <div class="col-auto"><i class="fa fa-cubes fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-warning shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Expires At</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                <?php if($meta->is_permanent): ?>
                                                    Never
                                                <?php elseif($meta->expires_at): ?>
                                                    <?php echo e(\Carbon\Carbon::parse($meta->expires_at)->format('M d, Y')); ?>

                                                <?php else: ?>
                                                    ---
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fa fa-calendar fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <h5 class="section-title text-primary mb-0"><i class="fa fa-user"></i> User Information</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#editUserInfoModal">
                                <i class="fa fa-pencil"></i> Edit Info
                            </button>
                        </div>
                    </div>
                    <?php if($userInfo->name || $userInfo->email || $userInfo->mobile): ?>
                    <div class="row mb-4">
                        <?php if($userInfo->name): ?>
                        <div class="col-md-4">
                            <div class="card border-left-info shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Name</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo e($userInfo->name); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($userInfo->email): ?>
                        <div class="col-md-4">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Email</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <a href="mailto:<?php echo e($userInfo->email); ?>"><?php echo e($userInfo->email); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($userInfo->mobile): ?>
                        <div class="col-md-4">
                            <div class="card border-left-success shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mobile</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo e($userInfo->mobile); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-light border text-center" style="color: #858796;">
                                <i class="fa fa-user-o" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                No user information provided yet.
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <hr>

                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary"><i class="fa fa-link"></i> Share Link</h5>
                            <div class="share-link-box">
                                <a href="<?php echo e($meta->share_url); ?>" target="_blank"><?php echo e($meta->share_url); ?></a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary"><i class="fa fa-user-secret"></i> Assigned Agent</h5>
                        </div>
                    </div>

                    <?php if($assignedAgent): ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="agent-box">
                                <div class="d-flex align-items-start" style="gap: 25px;">
                                    <div class="agent-avatar">
                                        <?php echo e(strtoupper(substr($assignedAgent->full_name_en, 0, 1))); ?>

                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Full Name (English)</div>
                                                <div class="agent-detail-value"><?php echo e($assignedAgent->full_name_en); ?></div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Full Name (Arabic)</div>
                                                <div class="agent-detail-value" dir="rtl"><?php echo e($assignedAgent->full_name_ar); ?></div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Job Title</div>
                                                <div class="agent-detail-value">
                                                    <span class="badge badge-info" style="font-size: 13px; padding: 5px 10px;"><?php echo e($assignedAgent->job_title_english); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Rank</div>
                                                <div class="agent-detail-value">
                                                    <span class="badge badge-primary" style="font-size: 13px; padding: 5px 10px;"><?php echo e($assignedAgent->rank_english); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex" style="gap: 10px; margin-top: 5px;">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#assignAgentModal">
                                                <i class="fa fa-refresh"></i> Change Agent
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#unassignAgentModal">
                                                <i class="fa fa-user-times"></i> Unassign
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php else: ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="agent-no-assigned">
                                <div class="icon-circle">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                                <h5 style="font-weight: 600; color: #5a5c69; margin-bottom: 8px;">No Agent Assigned</h5>
                                <p style="color: #858796; margin-bottom: 20px;">This favourite session does not have a sales agent yet.</p>
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#assignAgentModal">
                                    <i class="fa fa-user-plus"></i> Assign Agent Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <hr>

                    
                    <?php if($userInfo->email): ?>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary"><i class="fa fa-envelope"></i> Email Actions</h5>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="email-action-card direct">
                                <div class="email-action-icon direct">
                                    <i class="fa fa-paper-plane"></i>
                                </div>
                                <h6 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Send Direct Email</h6>
                                <p style="color: #858796; font-size: 13px; margin-bottom: 15px;">
                                    Send a custom email with attachments to <strong><?php echo e($userInfo->email); ?></strong>
                                </p>
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#sendEmailModal">
                                    <i class="fa fa-paper-plane"></i> Compose Email
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="email-action-card notify">
                                <div class="email-action-icon notify">
                                    <i class="fa fa-bell"></i>
                                </div>
                                <h6 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Send Favourites Update</h6>
                                <p style="color: #858796; font-size: 13px; margin-bottom: 15px;">
                                    Notify lead with the current items list to <strong><?php echo e($userInfo->email); ?></strong>
                                </p>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#sendNotificationModal">
                                    <i class="fa fa-bell"></i> Send Update
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if($assignedAgent): ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info mb-0" style="font-size: 13px;">
                                <i class="fa fa-info-circle"></i> Emails will be sent from <strong>care@svec.ae</strong> with <strong><?php echo e($assignedAgent->full_name_en); ?></strong> (<?php echo e($assignedAgent->user_email); ?>) on CC.
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <hr>
                    <?php endif; ?>

                    
                    <?php if($grouped['projects']->count() > 0): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary">
                                <i class="fa fa-building"></i> Projects
                                <span class="badge badge-primary"><?php echo e($grouped['projects']->count()); ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 70px;">Image</th>
                                    <th>Title (EN)</th>
                                    <th>Title (AR)</th>
                                    <th>Category</th>
                                    <th>Emirate</th>
                                    <th style="width: 80px;">Link</th>
                                    <th style="width: 50px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $grouped['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $item = $fav->itemData; ?>
                                <tr>
                                    <td>
                                        <?php if($item->main_image): ?>
                                            <img src="<?php echo e(url('/storage' . $item->main_image)); ?>" class="item-thumb" alt="">
                                        <?php else: ?>
                                            <span class="text-muted">---</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->title_english); ?></td>
                                    <td style="direction: rtl;"><?php echo e($item->title_arabic); ?></td>
                                    <td><?php echo e($item->category ? $item->category->title_english : '---'); ?></td>
                                    <td><?php echo e($item->emirate ? $item->emirate->title_english : '---'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('projects.show', $item->slug)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="delete-item-btn" data-toggle="modal" data-target="#deleteItemModal<?php echo e($fav->id); ?>" title="Remove from favourites">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($grouped['offers']->count() > 0): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="section-title text-warning">
                                <i class="fa fa-tags"></i> Offers
                                <span class="badge badge-warning"><?php echo e($grouped['offers']->count()); ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 70px;">Image</th>
                                    <th>Title (EN)</th>
                                    <th>Title (AR)</th>
                                    <th>Category</th>
                                    <th>Emirate</th>
                                    <th>Price</th>
                                    <th style="width: 80px;">Link</th>
                                    <th style="width: 50px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $grouped['offers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $item = $fav->itemData; ?>
                                <tr>
                                    <td>
                                        <?php if($item->main_image): ?>
                                            <img src="<?php echo e(url('/storage' . $item->main_image)); ?>" class="item-thumb" alt="">
                                        <?php else: ?>
                                            <span class="text-muted">---</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->title_english); ?></td>
                                    <td style="direction: rtl;"><?php echo e($item->title_arabic); ?></td>
                                    <td><?php echo e($item->category ? $item->category->title_english : '---'); ?></td>
                                    <td>
                                        <?php if(isset($fav->selectedPrice) && $fav->selectedPrice && $fav->selectedPrice->emirate): ?>
                                            <?php echo e($fav->selectedPrice->emirate->title_english); ?>

                                        <?php else: ?>
                                            ---
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($fav->price): ?>
                                            <strong><?php echo e(number_format($fav->price)); ?> <?php echo e($item->currency ? $item->currency->code : 'AED'); ?></strong>
                                        <?php else: ?>
                                            ---
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('offers.show', $item->slug)); ?>" target="_blank" class="btn btn-sm btn-outline-warning">
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="delete-item-btn" data-toggle="modal" data-target="#deleteItemModal<?php echo e($fav->id); ?>" title="Remove from favourites">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($grouped['interiors']->count() > 0): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="section-title text-success">
                                <i class="fa fa-paint-brush"></i> Interior Designs
                                <span class="badge badge-success"><?php echo e($grouped['interiors']->count()); ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 70px;">Image</th>
                                    <th>Title (EN)</th>
                                    <th>Title (AR)</th>
                                    <th>Category</th>
                                    <th>Style</th>
                                    <th style="width: 50px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $grouped['interiors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $item = $fav->itemData; ?>
                                <tr>
                                    <td>
                                        <?php if($item->image): ?>
                                            <img src="<?php echo e(url('/storage' . $item->image)); ?>" class="item-thumb" alt="">
                                        <?php else: ?>
                                            <span class="text-muted">---</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->title_english ?? '---'); ?></td>
                                    <td style="direction: rtl;"><?php echo e($item->title_arabic ?? '---'); ?></td>
                                    <td><?php echo e($item->category ? $item->category->title_english : '---'); ?></td>
                                    <td><?php echo e($item->projectStyle ? $item->projectStyle->title_english : '---'); ?></td>
                                    <td class="text-center">
                                        <button type="button" class="delete-item-btn" data-toggle="modal" data-target="#deleteItemModal<?php echo e($fav->id); ?>" title="Remove from favourites">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>

                    <hr>

                    
                    <div class="row">
                        <div class="col-md-6">
                            <strong>First Added:</strong>
                            <p class="text-muted"><?php echo e(\Carbon\Carbon::parse($meta->created_at)->format('M d, Y - h:i A')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Last Added:</strong>
                            <p class="text-muted"><?php echo e(\Carbon\Carbon::parse($meta->last_added_at)->format('M d, Y - h:i A')); ?></p>
                        </div>
                    </div>

                    <hr>

                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary">
                                <i class="fa fa-envelope-o"></i> Email Log
                                <span class="badge badge-secondary ml-1"><?php echo e($emailLogs->count()); ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <?php if($emailLogs->count() > 0): ?>
                                <?php $__currentLoopData = $emailLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="email-log-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center" style="gap: 10px;">
                                            <div class="timeline-author-avatar" style="width: 32px; height: 32px; font-size: 12px;">
                                                <?php echo e(strtoupper(substr($log->user->name ?? 'U', 0, 1))); ?>

                                            </div>
                                            <div>
                                                <span style="font-weight: 600; color: #2d3748; font-size: 14px;"><?php echo e($log->user->name ?? 'Unknown'); ?></span>
                                                <span class="email-log-badge <?php echo e($log->type); ?>"><?php echo e($log->type); ?></span>
                                            </div>
                                        </div>
                                        <span style="font-size: 12px; color: #858796;">
                                            <i class="fa fa-clock-o"></i>
                                            <?php echo e(\Carbon\Carbon::parse($log->created_at)->format('M d, Y - h:i A')); ?>

                                        </span>
                                    </div>
                                    <div style="margin-left: 42px;">
                                        <div style="font-size: 13px; color: #5a5c69; margin-bottom: 5px;">
                                            <strong>To:</strong> <?php echo e($log->to_email); ?>

                                            <?php if($log->cc_email): ?>
                                                <span style="margin-left: 12px;"><strong>CC:</strong> <?php echo e($log->cc_email); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="font-size: 14px; font-weight: 600; color: #2d3748; margin-bottom: 5px;">
                                            <?php echo e($log->subject); ?>

                                        </div>
                                        <?php if($log->body): ?>
                                        <div style="font-size: 13px; color: #4a5568; line-height: 1.5; white-space: pre-wrap; max-height: 80px; overflow-y: auto; background: #f8f9fc; border-radius: 6px; padding: 8px 12px;"><?php echo e(\Illuminate\Support\Str::limit($log->body, 300)); ?></div>
                                        <?php endif; ?>
                                        <?php if($log->attachments && count($log->attachments) > 0): ?>
                                        <div style="margin-top: 8px;">
                                            <?php $__currentLoopData = $log->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="email-attachment-tag"><i class="fa fa-paperclip"></i> <?php echo e($attachment); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <div class="timeline-empty">
                                <i class="fa fa-envelope-o"></i>
                                <p>No emails have been sent for this session yet.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary">
                                <i class="fa fa-comments"></i> Follow-up Comments
                                <span class="badge badge-secondary ml-1"><?php echo e($comments->count()); ?></span>
                            </h5>
                        </div>
                    </div>

                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="comment-form-box">
                                <form action="<?php echo e(route('crm-favourites.store-comment', ['sessionId' => $meta->session_id])); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="d-flex align-items-start" style="gap: 15px;">
                                        <div class="timeline-author-avatar" style="margin-top: 2px;">
                                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                                        </div>
                                        <div style="flex: 1;">
                                            <textarea class="comment-textarea" name="comment" placeholder="Write a follow-up comment..." required><?php echo e(old('comment')); ?></textarea>
                                            <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger mt-1" style="font-size: 13px;"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <div class="d-flex justify-content-end mt-2">
                                                <button type="submit" class="btn btn-dark btn-sm">
                                                    <i class="fa fa-paper-plane"></i> Add Comment
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12">
                            <?php if($comments->count() > 0): ?>
                            <div class="timeline-section">
                                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="timeline-item">
                                    <div class="timeline-dot"><i class="fa fa-comment"></i></div>
                                    <div class="timeline-card">
                                        <div class="timeline-card-header">
                                            <div class="timeline-author">
                                                <div class="timeline-author-avatar">
                                                    <?php echo e(strtoupper(substr($comment->user->name ?? 'U', 0, 1))); ?>

                                                </div>
                                                <div>
                                                    <div class="timeline-author-name"><?php echo e($comment->user->name ?? 'Unknown User'); ?></div>
                                                    <div class="timeline-date">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?php echo e(\Carbon\Carbon::parse($comment->created_at)->format('M d, Y - h:i A')); ?>

                                                        <span style="color: #b7b9cc; margin: 0 5px;">&middot;</span>
                                                        <?php echo e(\Carbon\Carbon::parse($comment->created_at)->diffForHumans()); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="timeline-delete-btn" data-toggle="modal" data-target="#deleteCommentModal<?php echo e($comment->id); ?>" title="Delete comment">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                        <div class="timeline-body"><?php echo e($comment->comment); ?></div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php else: ?>
                            <div class="timeline-empty">
                                <i class="fa fa-comments-o"></i>
                                <p>No follow-up comments yet. Add the first comment above.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<?php if($userInfo->email): ?>
<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="<?php echo e(route('crm-favourites.send-email', ['sessionId' => $meta->session_id])); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body" style="padding: 35px 30px 10px;">
                    <div class="text-center mb-4">
                        <div class="assign-modal-icon assign">
                            <i class="fa fa-paper-plane"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Send Direct Email</h4>
                        <p style="color: #858796; font-size: 14px;">
                            From <strong>care@svec.ae</strong> to <strong><?php echo e($userInfo->email); ?></strong>
                            <?php if($assignedAgent): ?> &middot; CC: <?php echo e($assignedAgent->user_email); ?> <?php endif; ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;">
                            <i class="fa fa-bookmark"></i> Subject <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="edit-input" name="subject" required placeholder="Enter email subject" value="<?php echo e(old('subject')); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;">
                            <i class="fa fa-pencil-square-o"></i> Message <span class="text-danger">*</span>
                        </label>
                        <textarea class="comment-textarea" name="body" required placeholder="Write your email message..." style="min-height: 150px;"><?php echo e(old('body')); ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;">
                            <i class="fa fa-paperclip"></i> Attachments <span style="color: #adb5bd; font-weight: 400;">(optional, up to 5 files, 10MB each)</span>
                        </label>
                        <div class="row" id="attachmentRows">
                            <div class="col-md-6 mb-2">
                                <input type="file" class="dropify" name="attachments[]" data-max-file-size="10M" data-height="100">
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" id="addAttachmentBtn" style="font-size: 12px;">
                            <i class="fa fa-plus"></i> Add Another File
                        </button>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-dark waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-paper-plane"></i> Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="sendNotificationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="<?php echo e(route('crm-favourites.send-notification', ['sessionId' => $meta->session_id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body" style="padding: 35px 30px 10px;">
                    <div class="text-center mb-4">
                        <div style="width: 90px; height: 90px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 38px; margin-bottom: 15px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); color: #fff;">
                            <i class="fa fa-bell"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Send Favourites Update</h4>
                        <p style="color: #858796; font-size: 14px;">
                            This will send the full items list (<?php echo e($totalCount); ?> items) to <strong><?php echo e($userInfo->email); ?></strong>
                            <?php if($assignedAgent): ?> with CC to <strong><?php echo e($assignedAgent->user_email); ?></strong> <?php endif; ?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;">
                            <i class="fa fa-sticky-note-o"></i> Update Note <span style="color: #adb5bd; font-weight: 400;">(optional — shown at the top of the email)</span>
                        </label>
                        <textarea class="comment-textarea" name="update_note" placeholder="e.g. Following our meeting, here are the updated items..." style="min-height: 80px;"><?php echo e(old('update_note')); ?></textarea>
                    </div>
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px 15px; font-size: 13px; color: #5a5c69;">
                        <i class="fa fa-info-circle text-info"></i> The email will include all <strong><?php echo e($totalCount); ?></strong> favourite items
                        (<?php echo e($grouped['projects']->count()); ?> Projects, <?php echo e($grouped['offers']->count()); ?> Offers, <?php echo e($grouped['interiors']->count()); ?> Interior Designs)
                        with images and a link to the shared page.
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-bell"></i> Send Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="modal fade" id="editUserInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="<?php echo e(route('crm-favourites.update-user-info', ['sessionId' => $meta->session_id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body" style="padding: 35px 30px 10px;">
                    <div class="text-center mb-4">
                        <div class="assign-modal-icon assign">
                            <i class="fa fa-pencil"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Edit User Information</h4>
                        <p style="color: #858796; font-size: 14px;">Update the contact details for this favourite session</p>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;">
                            <i class="fa fa-user"></i> Full Name
                        </label>
                        <input type="text" class="edit-input" name="name" value="<?php echo e($userInfo->name); ?>" placeholder="Enter full name">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;">
                            <i class="fa fa-envelope"></i> Email
                        </label>
                        <input type="email" class="edit-input" name="email" value="<?php echo e($userInfo->email); ?>" placeholder="Enter email address">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;">
                            <i class="fa fa-phone"></i> Mobile
                        </label>
                        <input type="text" class="edit-input" name="mobile" value="<?php echo e($userInfo->mobile); ?>" placeholder="Enter mobile number">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-dark waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-check"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
    $allFavItems = collect()
        ->merge($grouped['projects'])
        ->merge($grouped['offers'])
        ->merge($grouped['interiors']);
?>
<?php $__currentLoopData = $allFavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="deleteItemModal<?php echo e($favItem->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="<?php echo e(route('crm-favourites.delete-item', ['id' => $favItem->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body text-center" style="padding: 40px 30px 20px;">
                    <div class="assign-modal-icon unassign">
                        <i class="fa fa-trash-o"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 8px;">Remove Item?</h4>
                    <p style="color: #858796; font-size: 14px; margin-bottom: 10px;">This will remove the following item from this favourite session</p>
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px 15px; text-align: left;">
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <?php $itemData = $favItem->itemData; ?>
                            <?php if($favItem->item_type === 'interior' && $itemData->image): ?>
                                <img src="<?php echo e(url('/storage' . $itemData->image)); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            <?php elseif($itemData->main_image): ?>
                                <img src="<?php echo e(url('/storage' . $itemData->main_image)); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            <?php endif; ?>
                            <div>
                                <div style="font-weight: 600; color: #2d3748; font-size: 14px;"><?php echo e($itemData->title_english ?? '---'); ?></div>
                                <span class="badge badge-<?php echo e($favItem->item_type === 'project' ? 'primary' : ($favItem->item_type === 'offer' ? 'warning' : 'success')); ?>" style="font-size: 11px;">
                                    <?php echo e(ucfirst($favItem->item_type)); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-trash-o"></i> Remove</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="deleteCommentModal<?php echo e($comment->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="<?php echo e(route('crm-favourites.delete-comment', ['id' => $comment->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body text-center" style="padding: 40px 30px 20px;">
                    <div class="assign-modal-icon unassign">
                        <i class="fa fa-trash-o"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 8px;">Delete Comment?</h4>
                    <p style="color: #858796; font-size: 14px; margin-bottom: 5px;">This action cannot be undone</p>
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px 15px; margin-top: 15px; text-align: left; max-height: 100px; overflow-y: auto;">
                        <small style="color: #4a5568;"><?php echo e(\Illuminate\Support\Str::limit($comment->comment, 150)); ?></small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-trash-o"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<div class="modal fade" id="assignAgentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="<?php echo e(route('crm-favourites.assign-agent', ['sessionId' => $meta->session_id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body text-center" style="padding: 40px 30px 10px;">
                    <div class="assign-modal-icon assign">
                        <i class="fa fa-user-plus"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">
                        <?php echo e($assignedAgent ? 'Change Agent' : 'Assign Agent'); ?>

                    </h4>
                    <p style="color: #858796; font-size: 14px; margin-bottom: 25px;">Select a sales agent for this favourite session</p>
                    <div class="text-left" style="margin-bottom: 10px;">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px; margin-bottom: 8px;">
                            <i class="fa fa-user-secret"></i> Sales Agent <span class="text-danger">*</span>
                        </label>
                        <select class="form-control assign-modal-select" name="sales_agent_id" required>
                            <option selected disabled value="">-- Choose Agent --</option>
                            <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($agent->id); ?>" <?php echo e(($assignedAgent && $assignedAgent->id == $agent->id) ? 'selected' : ''); ?>>
                                    <?php echo e($agent->full_name_en); ?> — <?php echo e($agent->full_name_ar); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-dark waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-check"></i> Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php if($assignedAgent): ?>
<div class="modal fade" id="unassignAgentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="<?php echo e(route('crm-favourites.unassign-agent', ['sessionId' => $meta->session_id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body text-center" style="padding: 40px 30px 20px;">
                    <div class="assign-modal-icon unassign">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 8px;">Unassign Agent?</h4>
                    <p style="color: #858796; font-size: 15px; margin-bottom: 5px;">You are about to remove the assigned agent</p>
                    <p style="font-size: 18px; font-weight: 600; color: #e74a3b;"><?php echo e($assignedAgent->full_name_en); ?></p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-user-times"></i> Unassign</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('/js/dropify.min.js')); ?>"></script>
<script>
    function initDropify() {
        $('.dropify').dropify({
            messages: {
                'default': 'Drag & drop a file or click',
                'replace': 'Drag & drop or click to replace',
                'remove':  'Remove',
                'error':   'Oops, something went wrong.'
            }
        });
    }
    initDropify();

    var attachmentCount = 1;
    $('#addAttachmentBtn').on('click', function () {
        if (attachmentCount >= 5) {
            alert('Maximum 5 attachments allowed.');
            return;
        }
        attachmentCount++;
        var html = '<div class="col-md-6 mb-2">' +
                   '<input type="file" class="dropify" name="attachments[]" data-max-file-size="10M" data-height="100">' +
                   '</div>';
        $('#attachmentRows').append(html);
        initDropify();
        if (attachmentCount >= 5) {
            $(this).hide();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/CRM\resources/views/favourites/show.blade.php ENDPATH**/ ?>