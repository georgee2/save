<?php $__env->startSection('title', 'Contact Message #' . $contact->id); ?>

<?php $__env->startSection('css'); ?>
<style>
    .detail-card {
        border-radius: 10px;
        border: 1px solid #e3e6f0;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .detail-card-header {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        padding: 15px 20px;
        font-weight: 600;
    }
    .detail-card-header i { margin-right: 8px; }
    .detail-card-body { padding: 25px; }
    .detail-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        align-items: flex-start;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-label {
        width: 140px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #858796;
        flex-shrink: 0;
        padding-top: 2px;
    }
    .detail-value {
        flex: 1;
        font-size: 15px;
        color: #333;
        font-weight: 500;
    }
    .message-box {
        background: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        padding: 20px;
        line-height: 1.8;
        font-size: 14px;
        color: #444;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .status-form-card {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%);
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 25px;
        position: relative;
        overflow: hidden;
    }
    .status-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffc107, #17a2b8, #28a745);
    }
    .notes-box textarea {
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 15px;
        font-size: 14px;
        resize: vertical;
        transition: border-color 0.3s ease;
    }
    .notes-box textarea:focus {
        border-color: #19868b;
        box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.15);
        outline: none;
    }
    .status-badge-pending { background: #ffc107; color: #333; }
    .status-badge-inprogress { background: #17a2b8; color: #fff; }
    .status-badge-done { background: #28a745; color: #fff; }
    .meta-badges { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px; }
    .meta-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .action-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        border: none;
    }
    .action-btn:hover { transform: translateY(-2px); }
    .btn-status-update {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
    }
    .btn-status-update:hover { color: white; box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3); }
    .time-info {
        font-size: 13px;
        color: #858796;
    }
    .time-info i { color: #19868b; margin-right: 5px; }

    /* Email Log Timeline */
    .email-timeline { position: relative; padding-left: 28px; }
    .email-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #19868b, #e3e6f0);
    }
    .email-timeline-item {
        position: relative;
        margin-bottom: 24px;
        padding: 16px 18px;
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        transition: box-shadow 0.3s ease;
    }
    .email-timeline-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .email-timeline-item::before {
        content: '';
        position: absolute;
        left: -23px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #19868b;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #19868b;
    }
    .email-log-subject {
        font-weight: 700;
        font-size: 14px;
        color: #333;
        margin-bottom: 6px;
    }
    .email-log-body {
        font-size: 13px;
        color: #555;
        line-height: 1.7;
        background: #f8f9fc;
        border-radius: 6px;
        padding: 12px;
        margin-top: 10px;
        white-space: pre-wrap;
        word-break: break-word;
        max-height: 120px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        transition: max-height 0.4s ease;
    }
    .email-log-body.expanded { max-height: none; }
    .email-log-body:not(.expanded)::after {
        content: 'Click to expand...';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40px;
        background: linear-gradient(to bottom, transparent, #f8f9fc);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        font-size: 11px;
        color: #19868b;
        font-weight: 600;
        padding-bottom: 4px;
    }
    .email-log-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 11px;
        color: #858796;
    }
    .email-log-meta i { margin-right: 3px; color: #19868b; }

    /* Reply Modal */
    .reply-modal .modal-header {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: #fff;
        border-radius: 0;
        padding: 18px 24px;
    }
    .reply-modal .modal-header .close { color: #fff; opacity: 0.8; }
    .reply-modal .modal-body { padding: 24px; }
    .reply-modal .form-control:focus {
        border-color: #19868b;
        box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.15);
    }
    .reply-modal textarea {
        resize: vertical;
        min-height: 140px;
    }
    .btn-send-reply {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 28px;
        font-weight: 600;
    }
    .btn-send-reply:hover {
        color: #fff;
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
    }

    /* Comments Timeline */
    .comment-timeline { position: relative; padding-left: 28px; }
    .comment-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #4e73df, #e3e6f0);
    }
    .comment-item {
        position: relative;
        margin-bottom: 20px;
        padding: 14px 16px;
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        transition: box-shadow 0.3s ease;
    }
    .comment-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .comment-item::before {
        content: '';
        position: absolute;
        left: -23px;
        top: 18px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #4e73df;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #4e73df;
    }
    .comment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .comment-user {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .comment-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4e73df, #224abe);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .comment-user-name {
        font-weight: 700;
        font-size: 13px;
        color: #333;
    }
    .comment-time {
        font-size: 11px;
        color: #858796;
    }
    .comment-time i { color: #4e73df; margin-right: 3px; }
    .comment-body {
        font-size: 13px;
        color: #555;
        line-height: 1.7;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .comment-delete-btn {
        background: none;
        border: none;
        color: #e74a3b;
        font-size: 12px;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .comment-item:hover .comment-delete-btn { opacity: 1; }
    .comment-delete-btn:hover { background: #fce4e4; }
    .comment-form textarea {
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 12px;
        font-size: 13px;
        resize: vertical;
        min-height: 80px;
        transition: border-color 0.3s ease;
    }
    .comment-form textarea:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        outline: none;
    }
    .btn-add-comment {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 13px;
    }
    .btn-add-comment:hover {
        color: #fff;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="<?php echo e(route('CRM')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('crm-contact-us.index')); ?>" class="breadcrumbs__item"><i class="fa fa-envelope"></i> Contact Us</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Message #<?php echo e($contact->id); ?></a>
        </nav>

        <div class="col-lg-12">
            <hr>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fa fa-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <div class="row">
                
                <div class="col-lg-8">
                    
                    <div class="meta-badges">
                        <span class="meta-badge" style="background: #eef1f8; color: #4e73df;">
                            <i class="fa fa-hashtag"></i> ID: <?php echo e($contact->id); ?>

                        </span>
                        <?php if($contact->status === 'Pending'): ?>
                            <span class="meta-badge status-badge-pending"><i class="fa fa-clock-o"></i> Pending</span>
                        <?php elseif($contact->status === 'InProgress'): ?>
                            <span class="meta-badge status-badge-inprogress"><i class="fa fa-spinner"></i> In Progress</span>
                        <?php else: ?>
                            <span class="meta-badge status-badge-done"><i class="fa fa-check"></i> Done</span>
                        <?php endif; ?>
                        <span class="meta-badge" style="background: #f0f0f0; color: #666;">
                            <i class="fa fa-calendar"></i> <?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('M d, Y - h:i A')); ?>

                        </span>
                    </div>

                    
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fa fa-user"></i> Contact Information
                        </div>
                        <div class="detail-card-body">
                            <div class="detail-row">
                                <div class="detail-label">Name</div>
                                <div class="detail-value"><?php echo e($contact->name); ?></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Email</div>
                                <div class="detail-value">
                                    <a href="mailto:<?php echo e($contact->email); ?>"><i class="fa fa-envelope" style="color:#19868b;"></i> <?php echo e($contact->email); ?></a>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Phone</div>
                                <div class="detail-value">
                                    <?php if($contact->phone): ?>
                                        <a href="tel:<?php echo e($contact->phone); ?>"><i class="fa fa-phone" style="color:#19868b;"></i> <?php echo e($contact->phone); ?></a>
                                    <?php else: ?>
                                        <span class="text-muted">Not provided</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Subject</div>
                                <div class="detail-value"><strong><?php echo e($contact->subject); ?></strong></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Service</div>
                                <div class="detail-value">
                                    <?php if($contact->service_name): ?>
                                        <span class="badge badge-info" style="font-size:13px;"><?php echo e($contact->service_name); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">No service selected</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fa fa-comment"></i> Message
                        </div>
                        <div class="detail-card-body">
                            <div class="message-box"><?php echo e($contact->message); ?></div>
                        </div>
                    </div>

                    
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fa fa-envelope"></i> Email Reply Log
                            <span style="float:right;font-size:12px;opacity:0.85;font-weight:400;"><?php echo e($emailLogs->count()); ?> <?php echo e($emailLogs->count() === 1 ? 'reply' : 'replies'); ?></span>
                        </div>
                        <div class="detail-card-body">
                            <?php if($emailLogs->count() > 0): ?>
                                <div class="email-timeline">
                                    <?php $__currentLoopData = $emailLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="email-timeline-item">
                                        <div class="email-log-subject">
                                            <i class="fa fa-paper-plane" style="color:#19868b;margin-right:6px;"></i>
                                            <?php echo e($log->subject); ?>

                                        </div>
                                        <div class="email-log-meta">
                                            <span><i class="fa fa-user"></i> <?php echo e($log->sent_by_name ?? 'System'); ?></span>
                                            <span><i class="fa fa-envelope-o"></i> <?php echo e($log->to_email); ?></span>
                                            <span><i class="fa fa-clock-o"></i> <?php echo e(\Carbon\Carbon::parse($log->created_at)->format('M d, Y h:i A')); ?></span>
                                        </div>
                                        <div class="email-log-body" onclick="this.classList.toggle('expanded')"><?php echo e($log->body); ?></div>
                                        <?php
                                            $logAttachments = $log->attachments ? json_decode($log->attachments, true) : [];
                                            $logLinks = $log->links ? json_decode($log->links, true) : [];
                                        ?>
                                        <?php if(count($logAttachments) > 0): ?>
                                        <div style="margin-top:8px;padding:8px 10px;background:#f8f9fc;border-radius:6px;border:1px solid #e3e6f0;">
                                            <span style="font-size:11px;font-weight:700;color:#858796;text-transform:uppercase;">
                                                <i class="fa fa-paperclip" style="color:#19868b;"></i> Attachments (<?php echo e(count($logAttachments)); ?>)
                                            </span>
                                            <?php $__currentLoopData = $logAttachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div style="font-size:12px;color:#555;margin-top:4px;"><i class="fa fa-file-o" style="color:#19868b;margin-right:4px;"></i> <?php echo e($att); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php if(count($logLinks) > 0): ?>
                                        <div style="margin-top:8px;padding:8px 10px;background:#f0fafa;border-radius:6px;border:1px solid #d1ecee;">
                                            <span style="font-size:11px;font-weight:700;color:#19868b;text-transform:uppercase;">
                                                <i class="fa fa-link"></i> Links (<?php echo e(count($logLinks)); ?>)
                                            </span>
                                            <?php $__currentLoopData = $logLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lnk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div style="font-size:12px;margin-top:4px;">
                                                <a href="<?php echo e($lnk['url']); ?>" target="_blank" style="color:#19868b;text-decoration:none;">
                                                    <i class="fa fa-external-link" style="margin-right:3px;"></i> <?php echo e($lnk['title'] ?: $lnk['url']); ?>

                                                </a>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div style="text-align:center;padding:30px 0;color:#ccc;">
                                    <i class="fa fa-envelope-o" style="font-size:36px;margin-bottom:10px;display:block;"></i>
                                    <span style="color:#aaa;font-size:14px;">No replies sent yet</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="detail-card">
                        <div class="detail-card-header" style="background:linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                            <i class="fa fa-comments"></i> Follow-up Comments
                            <span style="float:right;font-size:12px;opacity:0.85;font-weight:400;"><?php echo e($comments->count()); ?> <?php echo e($comments->count() === 1 ? 'comment' : 'comments'); ?></span>
                        </div>
                        <div class="detail-card-body">
                            
                            <form action="<?php echo e(route('crm-contact-us.add-comment', $contact->id)); ?>" method="POST" class="comment-form" style="margin-bottom:24px;">
                                <?php echo csrf_field(); ?>
                                <div class="form-group mb-2">
                                    <textarea name="comment" class="form-control" rows="3" placeholder="Write a follow-up comment..." required></textarea>
                                </div>
                                <div style="text-align:right;">
                                    <button type="submit" class="btn btn-add-comment">
                                        <i class="fa fa-plus"></i> Add Comment
                                    </button>
                                </div>
                            </form>

                            <?php if($comments->count() > 0): ?>
                                <div class="comment-timeline">
                                    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="comment-item">
                                        <div class="comment-header">
                                            <div class="comment-user">
                                                <div class="comment-avatar">
                                                    <?php echo e(strtoupper(substr($comment->user_name ?? 'S', 0, 1))); ?>

                                                </div>
                                                <div>
                                                    <div class="comment-user-name"><?php echo e($comment->user_name ?? 'System'); ?></div>
                                                    <div class="comment-time">
                                                        <i class="fa fa-clock-o"></i> <?php echo e(\Carbon\Carbon::parse($comment->created_at)->format('M d, Y h:i A')); ?>

                                                        <span style="margin-left:4px;color:#bbb;">&middot;</span>
                                                        <span style="margin-left:4px;"><?php echo e(\Carbon\Carbon::parse($comment->created_at)->diffForHumans()); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="<?php echo e(route('crm-contact-us.delete-comment', $comment->id)); ?>" method="POST" onsubmit="return confirm('Delete this comment?')" style="margin:0;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="comment-delete-btn" title="Delete comment">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="comment-body"><?php echo e($comment->comment); ?></div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div style="text-align:center;padding:20px 0;color:#ccc;">
                                    <i class="fa fa-comments-o" style="font-size:32px;margin-bottom:8px;display:block;"></i>
                                    <span style="color:#aaa;font-size:13px;">No comments yet. Add a follow-up above.</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4">
                    
                    <div class="status-form-card mb-4">
                        <h5 style="color: #19868b; margin-bottom: 15px; font-weight: 700;">
                            <i class="fa fa-user-secret"></i> Assigned Agent
                        </h5>
                        <?php if($contact->agent_id): ?>
                            <div style="background:#fff;border-radius:10px;padding:15px;border:1px solid #e3e6f0;margin-bottom:15px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div style="width:45px;height:45px;border-radius:50%;background:linear-gradient(135deg,#4e73df,#224abe);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;font-weight:700;flex-shrink:0;">
                                        <?php echo e(strtoupper(substr($contact->agent_name, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:#333;font-size:15px;"><?php echo e($contact->agent_name); ?></div>
                                        <?php if($contact->agent_email): ?>
                                        <div style="font-size:12px;color:#858796;"><?php echo e($contact->agent_email); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <form action="<?php echo e(route('crm-contact-us.unassign-agent', $contact->id)); ?>" method="POST" onsubmit="return confirm('Unassign this agent?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger btn-block" style="border-radius:8px;">
                                    <i class="fa fa-user-times"></i> Unassign Agent
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="<?php echo e(route('crm-contact-us.assign-agent', $contact->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <select name="agent_id" class="form-control" style="font-weight:600;padding:10px;" required>
                                        <option value="">-- Select Agent --</option>
                                        <?php $__currentLoopData = $agentsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agentItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($agentItem->id); ?>"><?php echo e($agentItem->full_name_en); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn action-btn btn-status-update btn-block">
                                    <i class="fa fa-user-plus"></i> Assign Agent
                                </button>
                                <small class="text-muted d-block mt-2"><i class="fa fa-info-circle"></i> Assigning will set status to In Progress</small>
                            </form>
                        <?php endif; ?>
                    </div>

                    
                    <div class="status-form-card mb-4">
                        <h5 style="color: #19868b; margin-bottom: 15px; font-weight: 700;">
                            <i class="fa fa-flag"></i> Update Status
                        </h5>
                        <form action="<?php echo e(route('crm-contact-us.update-status', $contact->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <select name="status" class="form-control" style="font-weight:600; padding: 10px;">
                                    <option value="Pending" <?php echo e($contact->status === 'Pending' ? 'selected' : ''); ?>>&#128992; Pending</option>
                                    <option value="InProgress" <?php echo e($contact->status === 'InProgress' ? 'selected' : ''); ?>>&#128309; In Progress</option>
                                    <option value="Done" <?php echo e($contact->status === 'Done' ? 'selected' : ''); ?>>&#128994; Done</option>
                                </select>
                            </div>
                            <button type="submit" class="btn action-btn btn-status-update btn-block">
                                <i class="fa fa-refresh"></i> Update Status
                            </button>
                        </form>
                    </div>

                    
                    <div class="status-form-card notes-box mb-4">
                        <h5 style="color: #19868b; margin-bottom: 15px; font-weight: 700;">
                            <i class="fa fa-sticky-note"></i> Internal Notes
                        </h5>
                        <form action="<?php echo e(route('crm-contact-us.update-notes', $contact->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <textarea name="notes" class="form-control" rows="5" placeholder="Add internal notes about this contact..."><?php echo e($contact->notes); ?></textarea>
                            </div>
                            <button type="submit" class="btn action-btn btn-status-update btn-block">
                                <i class="fa fa-save"></i> Save Notes
                            </button>
                        </form>
                    </div>

                    
                    <div class="status-form-card">
                        <h5 style="color: #19868b; margin-bottom: 15px; font-weight: 700;">
                            <i class="fa fa-bolt"></i> Quick Actions
                        </h5>
                        <button type="button" class="btn btn-primary btn-block mb-2" style="border-radius: 8px;" data-toggle="modal" data-target="#replyEmailModal">
                            <i class="fa fa-reply"></i> Reply via Email
                        </button>
                        <?php if($contact->phone): ?>
                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $contact->phone)); ?>" target="_blank" class="btn btn-success btn-block mb-2" style="border-radius: 8px;">
                            <i class="fa fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="tel:<?php echo e($contact->phone); ?>" class="btn btn-info btn-block mb-2" style="border-radius: 8px;">
                            <i class="fa fa-phone"></i> Call
                        </a>
                        <?php endif; ?>
                        <hr>
                        <form action="<?php echo e(route('crm-contact-us.delete', $contact->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this message permanently?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger btn-block" style="border-radius: 8px;">
                                <i class="fa fa-trash"></i> Delete Message
                            </button>
                        </form>
                    </div>

                    
                    <div class="mt-3">
                        <div class="time-info mb-2">
                            <i class="fa fa-clock-o"></i> Created: <?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('M d, Y h:i A')); ?>

                        </div>
                        <?php if($contact->updated_at && $contact->updated_at !== $contact->created_at): ?>
                        <div class="time-info">
                            <i class="fa fa-refresh"></i> Updated: <?php echo e(\Carbon\Carbon::parse($contact->updated_at)->format('M d, Y h:i A')); ?>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade reply-modal" id="replyEmailModal" tabindex="-1" role="dialog" aria-labelledby="replyEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:12px;overflow:hidden;border:none;">
            <div class="modal-header">
                <h5 class="modal-title" id="replyEmailModalLabel">
                    <i class="fa fa-reply"></i> Reply to <?php echo e($contact->name); ?>

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('crm-contact-us.send-reply', $contact->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body" style="max-height:70vh;overflow-y:auto;">
                    <div class="form-group">
                        <label style="font-weight:600;color:#555;"><i class="fa fa-envelope-o" style="color:#19868b;"></i> To</label>
                        <input type="text" class="form-control" value="<?php echo e($contact->email); ?>" readonly style="background:#f8f9fc;font-weight:600;">
                    </div>
                    <?php if($contact->agent_email): ?>
                    <div class="form-group">
                        <label style="font-weight:600;color:#555;"><i class="fa fa-users" style="color:#19868b;"></i> CC (Assigned Agent)</label>
                        <input type="text" class="form-control" value="<?php echo e($contact->agent_email); ?>" readonly style="background:#f8f9fc;font-weight:600;">
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label style="font-weight:600;color:#555;"><i class="fa fa-tag" style="color:#19868b;"></i> Subject</label>
                        <input type="text" name="subject" class="form-control" value="Re: <?php echo e($contact->subject); ?>" required style="font-weight:600;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight:600;color:#555;"><i class="fa fa-pencil" style="color:#19868b;"></i> Message</label>
                        <textarea name="body" class="form-control" rows="6" required placeholder="Type your reply here..."></textarea>
                    </div>

                    
                    <div class="form-group">
                        <label style="font-weight:600;color:#555;"><i class="fa fa-paperclip" style="color:#19868b;"></i> Attachments</label>
                        <div id="attachmentsContainer">
                            <div class="attachment-row mb-2">
                                <input type="file" name="attachments[]" class="dropify" data-max-file-size="10M" data-height="80">
                            </div>
                        </div>
                        <button type="button" id="addAttachmentBtn" class="btn btn-sm btn-outline-secondary mt-1" style="border-radius:6px;">
                            <i class="fa fa-plus"></i> Add Another File
                        </button>
                    </div>

                    
                    <div class="form-group">
                        <label style="font-weight:600;color:#555;"><i class="fa fa-link" style="color:#19868b;"></i> External Links</label>
                        <div id="linksContainer">
                            <div class="link-row mb-2" style="display:flex;gap:8px;align-items:center;">
                                <input type="text" name="link_titles[]" class="form-control" placeholder="Link title (optional)" style="flex:1;">
                                <input type="url" name="link_urls[]" class="form-control" placeholder="https://example.com" style="flex:2;">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-link-btn" style="border-radius:6px;flex-shrink:0;visibility:hidden;" title="Remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="addLinkBtn" class="btn btn-sm btn-outline-secondary mt-1" style="border-radius:6px;">
                            <i class="fa fa-plus"></i> Add Another Link
                        </button>
                    </div>

                    <div style="background:#f0fafa;border-radius:8px;padding:12px 16px;border-left:4px solid #19868b;font-size:12px;color:#666;">
                        <strong style="color:#19868b;">Original Message:</strong><br>
                        <span style="color:#888;"><?php echo e(Str::limit($contact->message, 200)); ?></span>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #e3e6f0;padding:16px 24px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:8px;">Cancel</button>
                    <button type="submit" class="btn btn-send-reply">
                        <i class="fa fa-paper-plane"></i> Send Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('/js/dropify.min.js')); ?>"></script>
<script>
$(document).ready(function() {
    $('#replyEmailModal').on('shown.bs.modal', function () {
        $(this).find('.dropify').each(function() {
            if (!$(this).data('dropify-init')) {
                $(this).dropify({
                    messages: { 'default': 'Drag & drop or click', 'replace': 'Replace file', 'remove': 'Remove', 'error': 'File too large' }
                });
                $(this).data('dropify-init', true);
            }
        });
    });

    $('#addAttachmentBtn').on('click', function() {
        var newRow = $('<div class="attachment-row mb-2">' +
            '<div style="display:flex;align-items:center;gap:8px;">' +
            '<div style="flex:1;"><input type="file" name="attachments[]" class="dropify" data-max-file-size="10M" data-height="80"></div>' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-attachment-btn" style="border-radius:6px;flex-shrink:0;" title="Remove"><i class="fa fa-times"></i></button>' +
            '</div></div>');
        $('#attachmentsContainer').append(newRow);
        newRow.find('.dropify').dropify({
            messages: { 'default': 'Drag & drop or click', 'replace': 'Replace file', 'remove': 'Remove', 'error': 'File too large' }
        });
    });

    $(document).on('click', '.remove-attachment-btn', function() {
        $(this).closest('.attachment-row').remove();
    });

    $('#addLinkBtn').on('click', function() {
        var newRow = $('<div class="link-row mb-2" style="display:flex;gap:8px;align-items:center;">' +
            '<input type="text" name="link_titles[]" class="form-control" placeholder="Link title (optional)" style="flex:1;">' +
            '<input type="url" name="link_urls[]" class="form-control" placeholder="https://example.com" style="flex:2;">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-link-btn" style="border-radius:6px;flex-shrink:0;" title="Remove"><i class="fa fa-times"></i></button>' +
            '</div>');
        $('#linksContainer').append(newRow);
    });

    $(document).on('click', '.remove-link-btn', function() {
        if ($('#linksContainer .link-row').length > 1) {
            $(this).closest('.link-row').remove();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/CRM\resources/views/contact-us/show.blade.php ENDPATH**/ ?>