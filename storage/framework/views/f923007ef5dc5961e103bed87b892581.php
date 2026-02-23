<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<style>
    :root {
        --primary-color: #19868b;
        --primary-dark: #146a6e;
        --primary-light: #1fa0a6;
        --secondary-color: #172e38;
        --accent-color: #e1273d;
        --accent-light: #f0cb82;
        --success-color: #10b981;
        --warning-color: #f6b500;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --orange-color: #ff6935;
        --light-bg: #f7f9fc;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .page-content-wrapper {
        background: linear-gradient(135deg, #f7f9fc 0%, #eef2f7 100%);
        min-height: 100vh;
        padding: 20px;
    }

    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        color: white;
        padding: 35px 40px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(25, 134, 139, 0.3);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 10%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(225,39,61,0.2) 0%, transparent 70%);
        border-radius: 50%;
    }

    .dashboard-header h2 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
        z-index: 1;
    }

    .dashboard-header h2 i {
        background: var(--accent-color);
        padding: 12px;
        border-radius: 12px;
        font-size: 24px;
    }

    .dashboard-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 15px;
        position: relative;
        z-index: 1;
    }

    .dashboard-header .header-stats {
        display: flex;
        gap: 20px;
        margin-top: 25px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    .dashboard-header .header-stat {
        text-align: center;
        padding: 15px 25px;
        background: rgba(255,255,255,0.1);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        min-width: 120px;
    }

    .dashboard-header .header-stat .number {
        font-size: 28px;
        font-weight: 700;
        color: #fff;
    }

    .dashboard-header .header-stat .label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.8;
        margin-top: 5px;
    }

    .dashboard-header .header-stat.highlight .number {
        color: var(--warning-color);
    }

    /* Summary Cards Row */
    .summary-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-mini-card {
        background: white;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }

    .summary-mini-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .summary-mini-card.primary { border-left-color: var(--primary-color); }
    .summary-mini-card.accent { border-left-color: var(--accent-color); }
    .summary-mini-card.success { border-left-color: var(--success-color); }
    .summary-mini-card.warning { border-left-color: var(--warning-color); }
    .summary-mini-card.info { border-left-color: var(--info-color); }
    .summary-mini-card.orange { border-left-color: var(--orange-color); }

    .summary-mini-card .mini-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        flex-shrink: 0;
    }

    .summary-mini-card.primary .mini-icon { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); }
    .summary-mini-card.accent .mini-icon { background: linear-gradient(135deg, var(--accent-color), #c41f33); }
    .summary-mini-card.success .mini-icon { background: linear-gradient(135deg, var(--success-color), #059669); }
    .summary-mini-card.warning .mini-icon { background: linear-gradient(135deg, var(--warning-color), #d97706); }
    .summary-mini-card.info .mini-icon { background: linear-gradient(135deg, var(--info-color), #2563eb); }
    .summary-mini-card.orange .mini-icon { background: linear-gradient(135deg, var(--orange-color), #e55a2b); }

    .summary-mini-card .mini-content .mini-value {
        font-size: 24px;
        font-weight: 800;
        color: var(--secondary-color);
        line-height: 1;
    }

    .summary-mini-card .mini-content .mini-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
        margin-top: 4px;
    }

    .summary-mini-card .mini-badge {
        margin-left: auto;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .summary-mini-card .mini-badge.up {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .summary-mini-card .mini-badge.pending {
        background: rgba(246, 181, 0, 0.1);
        color: var(--warning-color);
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 25px;
        box-shadow: var(--card-shadow);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(25, 134, 139, 0.15);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .stat-card.primary::before { background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); }
    .stat-card.accent::before { background: linear-gradient(90deg, var(--accent-color), #f0424e); }
    .stat-card.success::before { background: linear-gradient(90deg, var(--success-color), #34d399); }
    .stat-card.info::before { background: linear-gradient(90deg, var(--info-color), #60a5fa); }
    .stat-card.warning::before { background: linear-gradient(90deg, var(--warning-color), #fbbf24); }
    .stat-card.danger::before { background: linear-gradient(90deg, var(--danger-color), #f87171); }
    .stat-card.orange::before { background: linear-gradient(90deg, var(--orange-color), #ff8c5a); }

    .stat-card .icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(25, 134, 139, 0.3);
    }

    .stat-card.accent .icon { background: linear-gradient(135deg, var(--accent-color), #c41f33); box-shadow: 0 8px 20px rgba(225, 39, 61, 0.3); }
    .stat-card.success .icon { background: linear-gradient(135deg, var(--success-color), #059669); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
    .stat-card.info .icon { background: linear-gradient(135deg, var(--info-color), #2563eb); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3); }
    .stat-card.warning .icon { background: linear-gradient(135deg, var(--warning-color), #d97706); box-shadow: 0 8px 20px rgba(246, 181, 0, 0.3); }
    .stat-card.danger .icon { background: linear-gradient(135deg, var(--danger-color), #dc2626); box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3); }
    .stat-card.orange .icon { background: linear-gradient(135deg, var(--orange-color), #e55a2b); box-shadow: 0 8px 20px rgba(255, 105, 53, 0.3); }

    .stat-card .title {
        font-size: 13px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
    }

    .stat-card .value {
        font-size: 36px;
        font-weight: 800;
        color: var(--secondary-color);
        margin-bottom: 8px;
        line-height: 1;
    }

    .stat-card .subtitle {
        font-size: 13px;
        color: #9ca3af;
        line-height: 1.5;
    }

    .stat-card .subtitle .status-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .stat-card .subtitle .status-indicator.published { background: var(--success-color); }
    .stat-card .subtitle .status-indicator.unpublished { background: var(--danger-color); }
    .stat-card .subtitle .status-indicator.pending { background: var(--warning-color); }
    .stat-card .subtitle .status-indicator.trashed { background: #9ca3af; }

    .stat-card .badge-info {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(25, 134, 139, 0.25);
    }

    /* Chart Cards */
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 25px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .chart-card .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 2px solid #f3f4f6;
    }

    .chart-card .chart-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--secondary-color);
    }

    .chart-card .chart-subtitle {
        font-size: 13px;
        color: #9ca3af;
        margin-top: 4px;
    }

    /* Section Title */
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--secondary-color);
        margin: 40px 0 25px 0;
        padding-left: 18px;
        border-left: 5px solid var(--primary-color);
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--accent-color), transparent);
        border-radius: 2px;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: var(--card-shadow);
    }

    .quick-actions .action-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-actions .action-title i {
        color: var(--primary-color);
    }

    .quick-actions .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 12px;
    }

    .quick-actions .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 18px 12px;
        background: linear-gradient(135deg, #f7f9fc, #eef2f7);
        border-radius: 12px;
        text-decoration: none;
        color: var(--secondary-color);
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .quick-actions .action-item:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(25, 134, 139, 0.25);
    }

    .quick-actions .action-item i {
        font-size: 22px;
        margin-bottom: 8px;
        color: var(--primary-color);
        transition: color 0.3s ease;
    }

    .quick-actions .action-item:hover i {
        color: white;
    }

    .quick-actions .action-item span {
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }

    /* Activity Log Panel */
    .activity-panel {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: var(--card-shadow);
        height: 100%;
    }

    .activity-panel .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f3f4f6;
    }

    .activity-panel .panel-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .activity-panel .panel-title i {
        color: var(--primary-color);
    }

    .activity-panel .view-all-link {
        font-size: 13px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .activity-panel .view-all-link:hover {
        text-decoration: underline;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: white;
        flex-shrink: 0;
    }

    .activity-item .activity-icon.create { background: linear-gradient(135deg, var(--success-color), #059669); }
    .activity-item .activity-icon.update { background: linear-gradient(135deg, var(--info-color), #2563eb); }
    .activity-item .activity-icon.delete { background: linear-gradient(135deg, var(--danger-color), #dc2626); }
    .activity-item .activity-icon.login { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); }
    .activity-item .activity-icon.view { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .activity-item .activity-icon.restore { background: linear-gradient(135deg, var(--warning-color), #d97706); }

    .activity-item .activity-content {
        flex: 1;
        min-width: 0;
    }

    .activity-item .activity-text {
        font-size: 13px;
        color: var(--secondary-color);
        line-height: 1.4;
        margin-bottom: 4px;
    }

    .activity-item .activity-text strong {
        color: var(--primary-color);
    }

    .activity-item .activity-meta {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Top Creators Panel */
    .creators-panel {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: var(--card-shadow);
    }

    .creator-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .creator-item:last-child {
        border-bottom: none;
    }

    .creator-item .creator-rank {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .creator-item:nth-child(1) .creator-rank { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
    .creator-item:nth-child(2) .creator-rank { background: linear-gradient(135deg, #9ca3af, #6b7280); }
    .creator-item:nth-child(3) .creator-rank { background: linear-gradient(135deg, #cd7f32, #b87333); }
    .creator-item:nth-child(n+4) .creator-rank { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); }

    .creator-item .creator-info {
        flex: 1;
    }

    .creator-item .creator-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--secondary-color);
    }

    .creator-item .creator-actions {
        font-size: 12px;
        color: #9ca3af;
    }

    .creator-item .creator-count {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* System Health Panel */
    .health-panel {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: var(--card-shadow);
    }

    .health-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .health-item:last-child {
        border-bottom: none;
    }

    .health-item .health-label {
        font-size: 14px;
        color: var(--secondary-color);
        font-weight: 500;
    }

    .health-item .health-value {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .health-item .health-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .health-item .health-badge.good {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .health-item .health-badge.warning {
        background: rgba(246, 181, 0, 0.1);
        color: var(--warning-color);
    }

    .health-item .health-badge.danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    canvas {
        max-height: 350px;
    }

    /* Responsive */
    @media (max-width: 1400px) {
        .summary-row {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .summary-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .summary-row {
            grid-template-columns: 1fr;
        }

        .stat-card {
            margin-bottom: 15px;
        }
        
        .dashboard-header h2 {
            font-size: 24px;
        }

        .dashboard-header .header-stats {
            gap: 10px;
        }

        .dashboard-header .header-stat {
            padding: 10px 15px;
            min-width: 100px;
        }

        .quick-actions .action-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 576px) {
        .quick-actions .action-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <!-- Dashboard Header -->
        <div class="dashboard-header animate__animated animate__fadeInDown" style="margin-top:70px">
            <h2><i class="fa fa-pie-chart"></i> CMS Dashboard</h2>
            <p>Welcome back, <?php echo e(auth()->user()->name); ?>! Here's an overview of your content management system.</p>
            <div class="header-stats">
                <div class="header-stat">
                    <div class="number"><?php echo e(number_format($stats['services'] + $stats['projects'] + $stats['offers'] + $stats['interior_galleries'])); ?></div>
                    <div class="label">Total Content</div>
                </div>
                <div class="header-stat">
                    <div class="number"><?php echo e(number_format($stats['services_published'] + $stats['projects_published'] + $stats['offers_published'] + $stats['interior_galleries_published'])); ?></div>
                    <div class="label">Published</div>
                </div>
                <div class="header-stat highlight">
                    <div class="number"><?php echo e($weeklyActivity['services'] + $weeklyActivity['projects'] + $weeklyActivity['offers'] + $weeklyActivity['news']); ?></div>
                    <div class="label">New This Week</div>
                </div>
                <div class="header-stat">
                    <div class="number"><?php echo e(number_format($stats['contact_pending'] ?? 0)); ?></div>
                    <div class="label">Pending Contacts</div>
                </div>
                <div class="header-stat">
                    <div class="number"><?php echo e(number_format($stats['activity_logs_today'])); ?></div>
                    <div class="label">Actions Today</div>
                </div>
            </div>
        </div>

        <!-- Quick Summary Row -->
        <div class="summary-row animate__animated animate__fadeInUp">
            <div class="summary-mini-card primary">
                <div class="mini-icon"><i class="fa fa-cogs"></i></div>
                <div class="mini-content">
                    <div class="mini-value"><?php echo e($stats['services']); ?></div>
                    <div class="mini-label">Services</div>
                </div>
                <?php if($weeklyActivity['services'] > 0): ?>
                <span class="mini-badge up">+<?php echo e($weeklyActivity['services']); ?></span>
                <?php endif; ?>
            </div>
            <div class="summary-mini-card accent">
                <div class="mini-icon"><i class="fa fa-building"></i></div>
                <div class="mini-content">
                    <div class="mini-value"><?php echo e($stats['projects']); ?></div>
                    <div class="mini-label">Projects</div>
                </div>
                <?php if($weeklyActivity['projects'] > 0): ?>
                <span class="mini-badge up">+<?php echo e($weeklyActivity['projects']); ?></span>
                <?php endif; ?>
            </div>
            <div class="summary-mini-card success">
                <div class="mini-icon"><i class="fa fa-tags"></i></div>
                <div class="mini-content">
                    <div class="mini-value"><?php echo e($stats['offers']); ?></div>
                    <div class="mini-label">Offers</div>
                </div>
                <?php if($weeklyActivity['offers'] > 0): ?>
                <span class="mini-badge up">+<?php echo e($weeklyActivity['offers']); ?></span>
                <?php endif; ?>
            </div>
            <div class="summary-mini-card info">
                <div class="mini-icon"><i class="fa fa-paint-brush"></i></div>
                <div class="mini-content">
                    <div class="mini-value"><?php echo e($stats['interior_galleries']); ?></div>
                    <div class="mini-label">Interior Galleries</div>
                </div>
            </div>
            <div class="summary-mini-card warning">
                <div class="mini-icon"><i class="fa fa-envelope"></i></div>
                <div class="mini-content">
                    <div class="mini-value"><?php echo e($stats['contact_pending'] ?? 0); ?></div>
                    <div class="mini-label">Pending Contacts</div>
                </div>
                <?php if(($stats['contact_pending'] ?? 0) > 0): ?>
                <span class="mini-badge pending">Needs Review</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions animate__animated animate__fadeInUp">
            <div class="action-title"><i class="fa fa-bolt"></i> Quick Actions</div>
            <div class="action-grid">
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'services-view')): ?>
                <a href="<?php echo e(route('service.index')); ?>" class="action-item">
                    <i class="mdi mdi-briefcase"></i>
                    <span>Services</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'projects-view')): ?>
                <a href="<?php echo e(route('project.index')); ?>" class="action-item">
                    <i class="fa fa-building"></i>
                    <span>Projects</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'offers-view')): ?>
                <a href="<?php echo e(route('offer.index')); ?>" class="action-item">
                    <i class="fa fa-tag"></i>
                    <span>Offers</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'interior-design-galleries-view')): ?>
                <a href="<?php echo e(route('interior-design-gallery.index')); ?>" class="action-item">
                    <i class="fa fa-paint-brush"></i>
                    <span>Interior Gallery</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'news-view')): ?>
                <a href="<?php echo e(route('news-back.index')); ?>" class="action-item">
                    <i class="fa fa-newspaper-o"></i>
                    <span>News</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'sliders-view')): ?>
                <a href="<?php echo e(route('slider.index')); ?>" class="action-item">
                    <i class="mdi mdi-view-carousel"></i>
                    <span>Sliders</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'team-view')): ?>
                <a href="<?php echo e(route('admin.team.index')); ?>" class="action-item">
                    <i class="fa fa-users"></i>
                    <span>Team</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'partners-view')): ?>
                <a href="<?php echo e(route('partner.index')); ?>" class="action-item">
                    <i class="fa fa-handshake-o"></i>
                    <span>Partners</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'contact-information-view')): ?>
                <a href="<?php echo e(route('contact-information.index')); ?>" class="action-item">
                    <i class="fa fa-envelope"></i>
                    <span>Contact Info</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'jobs-postings-view')): ?>
                <a href="<?php echo e(route('jobs-posting.index')); ?>" class="action-item">
                    <i class="fa fa-briefcase"></i>
                    <span>Jobs</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'users-view')): ?>
                <a href="<?php echo e(route('users.index')); ?>" class="action-item">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'roles-view')): ?>
                <a href="<?php echo e(route('admin.roles.index')); ?>" class="action-item">
                    <i class="fa fa-shield"></i>
                    <span>Roles</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'activity-logs-view')): ?>
                <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="action-item">
                    <i class="fa fa-history"></i>
                    <span>Activity Logs</span>
                </a>
                <?php endif; ?>
                
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'settings-view')): ?>
                <a href="<?php echo e(route('site-settings.index')); ?>" class="action-item">
                    <i class="fa fa-cog"></i>
                    <span>Settings</span>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-lg-8">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Content Growth Trend</div>
                            <div class="chart-subtitle">Last 6 months content creation analysis</div>
                        </div>
                    </div>
                    <canvas id="monthlyGrowthChart"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Content Overview</div>
                            <div class="chart-subtitle">Total items by type</div>
                        </div>
                    </div>
                    <canvas id="contentOverviewChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Activity & Creators Row -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-lg-8">
                <div class="activity-panel">
                    <div class="panel-header">
                        <div class="panel-title"><i class="fa fa-history"></i> Recent Activity</div>
                        <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'activity-logs-view')): ?>
                        <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="view-all-link">View All <i class="fa fa-arrow-right"></i></a>
                        <?php endif; ?>
                    </div>
                    <?php $__empty_1 = true; $__currentLoopData = $recentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="activity-icon <?php echo e($log->action); ?>">
                            <?php if($log->action == 'create'): ?>
                            <i class="fa fa-plus"></i>
                            <?php elseif($log->action == 'update'): ?>
                            <i class="fa fa-pencil"></i>
                            <?php elseif($log->action == 'delete'): ?>
                            <i class="fa fa-trash"></i>
                            <?php elseif($log->action == 'login' || $log->action == 'logout'): ?>
                            <i class="fa fa-sign-in"></i>
                            <?php elseif($log->action == 'restore'): ?>
                            <i class="fa fa-undo"></i>
                            <?php else: ?>
                            <i class="fa fa-eye"></i>
                            <?php endif; ?>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">
                                <strong><?php echo e($log->user_name); ?></strong> 
                                <?php echo e($log->action == 'create' ? 'created' : ($log->action == 'update' ? 'updated' : ($log->action == 'delete' ? 'deleted' : ($log->action == 'restore' ? 'restored' : $log->action)))); ?>

                                <?php echo e($log->model_name ? strtolower($log->model_name) : 'record'); ?>

                                <?php if($log->record_title): ?>
                                "<em><?php echo e(Str::limit($log->record_title, 30)); ?></em>"
                                <?php endif; ?>
                            </div>
                            <div class="activity-meta">
                                <i class="fa fa-clock-o"></i> <?php echo e($log->created_at->diffForHumans()); ?>

                                <?php if($log->ip_address): ?>
                                &bull; <i class="fa fa-globe"></i> <?php echo e($log->ip_address); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p>No recent activity found</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="creators-panel mb-4">
                    <div class="panel-header">
                        <div class="panel-title"><i class="fa fa-trophy"></i> Top Contributors</div>
                    </div>
                    <?php $__empty_1 = true; $__currentLoopData = $topCreators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $creator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="creator-item">
                        <div class="creator-rank"><?php echo e($index + 1); ?></div>
                        <div class="creator-info">
                            <div class="creator-name"><?php echo e($creator->user_name); ?></div>
                            <div class="creator-actions"><?php echo e($creator->actions_count); ?> actions this month</div>
                        </div>
                        <span class="creator-count"><?php echo e($creator->actions_count); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-users fa-2x mb-2"></i>
                        <p>No activity data yet</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="health-panel">
                    <div class="panel-header">
                        <div class="panel-title"><i class="fa fa-heartbeat"></i> System Health</div>
                    </div>
                    <div class="health-item">
                        <span class="health-label">Published Content</span>
                        <div class="health-value">
                            <?php
                                $totalContent = $stats['services'] + $stats['projects'] + $stats['offers'];
                                $publishedContent = $stats['services_published'] + $stats['projects_published'] + $stats['offers_published'];
                                $publishRate = $totalContent > 0 ? round(($publishedContent / $totalContent) * 100) : 0;
                            ?>
                            <span class="health-badge <?php echo e($publishRate >= 70 ? 'good' : ($publishRate >= 40 ? 'warning' : 'danger')); ?>">
                                <?php echo e($publishRate); ?>%
                            </span>
                        </div>
                    </div>
                    <div class="health-item">
                        <span class="health-label">Pending Contacts</span>
                        <div class="health-value">
                            <span class="health-badge <?php echo e(($stats['contact_pending'] ?? 0) == 0 ? 'good' : (($stats['contact_pending'] ?? 0) <= 5 ? 'warning' : 'danger')); ?>">
                                <?php echo e($stats['contact_pending'] ?? 0); ?> pending
                            </span>
                        </div>
                    </div>
                    <div class="health-item">
                        <span class="health-label">Active Sliders</span>
                        <div class="health-value">
                            <span class="health-badge <?php echo e($stats['sliders_active'] > 0 ? 'good' : 'warning'); ?>">
                                <?php echo e($stats['sliders_active']); ?> / <?php echo e($stats['sliders']); ?>

                            </span>
                        </div>
                    </div>
                    <div class="health-item">
                        <span class="health-label">Active Jobs</span>
                        <div class="health-value">
                            <span class="health-badge <?php echo e(($stats['jobs_active'] ?? 0) > 0 ? 'good' : 'warning'); ?>">
                                <?php echo e($stats['jobs_active'] ?? 0); ?> active
                            </span>
                        </div>
                    </div>
                    <div class="health-item">
                        <span class="health-label">Trashed Items</span>
                        <div class="health-value">
                            <?php $trashedTotal = $stats['services_trashed'] + $stats['projects_trashed'] + $stats['offers_trashed'] + $stats['interior_galleries_trashed']; ?>
                            <span class="health-badge <?php echo e($trashedTotal == 0 ? 'good' : ($trashedTotal <= 10 ? 'warning' : 'danger')); ?>">
                                <?php echo e($trashedTotal); ?> items
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Statistics Cards -->
        <h3 class="section-title">Main Content Statistics</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Services -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon"><i class="fa fa-cogs"></i></div>
                    <div class="title">Services</div>
                    <div class="value"><?php echo e($stats['services']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['services_published']); ?> Published
                        <br>
                        <span class="status-indicator unpublished"></span> <?php echo e($stats['services_unpublished']); ?> Unpublished
                        <br>
                        <span class="status-indicator trashed"></span> <?php echo e($stats['services_trashed']); ?> Trashed
                    </div>
                    <?php if($recentActivity['services'] > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['services']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Projects -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon"><i class="fa fa-building"></i></div>
                    <div class="title">Projects</div>
                    <div class="value"><?php echo e($stats['projects']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['projects_published']); ?> Published
                        <br>
                        <span class="status-indicator unpublished"></span> <?php echo e($stats['projects_unpublished']); ?> Unpublished
                        <br>
                        <span class="status-indicator trashed"></span> <?php echo e($stats['projects_trashed']); ?> Trashed
                    </div>
                    <?php if($recentActivity['projects'] > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['projects']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Offers -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon"><i class="fa fa-tags"></i></div>
                    <div class="title">Offers</div>
                    <div class="value"><?php echo e($stats['offers']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['offers_published']); ?> Published
                        <br>
                        <span class="status-indicator unpublished"></span> <?php echo e($stats['offers_unpublished']); ?> Unpublished
                        <br>
                        <span class="status-indicator trashed"></span> <?php echo e($stats['offers_trashed']); ?> Trashed
                    </div>
                    <?php if($recentActivity['offers'] > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['offers']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Interior Galleries -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card orange">
                    <div class="icon"><i class="fa fa-paint-brush"></i></div>
                    <div class="title">Interior Galleries</div>
                    <div class="value"><?php echo e($stats['interior_galleries']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['interior_galleries_published']); ?> Published
                        <br>
                        <span class="status-indicator published"></span> <?php echo e($stats['interior_galleries_featured']); ?> Featured
                        <br>
                        <span class="status-indicator trashed"></span> <?php echo e($stats['interior_galleries_trashed']); ?> Trashed
                    </div>
                    <?php if($recentActivity['interior_galleries'] > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['interior_galleries']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Contact & Careers -->
        <h3 class="section-title">Contact & Careers</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Contact Submissions -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card warning">
                    <div class="icon"><i class="fa fa-envelope"></i></div>
                    <div class="title">Contact Submissions</div>
                    <div class="value"><?php echo e($stats['contact_submissions'] ?? 0); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator pending"></span> <?php echo e($stats['contact_pending'] ?? 0); ?> Pending
                        <br>
                        <span class="status-indicator published"></span> <?php echo e($stats['contact_replied'] ?? 0); ?> Replied
                    </div>
                    <?php if(($recentActivity['contact_submissions'] ?? 0) > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['contact_submissions']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Job Postings -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon"><i class="fa fa-briefcase"></i></div>
                    <div class="title">Job Postings</div>
                    <div class="value"><?php echo e($stats['jobs_postings'] ?? 0); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['jobs_active'] ?? 0); ?> Active Jobs
                    </div>
                </div>
            </div>

            <!-- Job Applications -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">Job Applications</div>
                    <div class="value"><?php echo e($stats['job_applications'] ?? 0); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator pending"></span> <?php echo e($stats['job_applications_pending'] ?? 0); ?> Pending
                        <br>
                        <span class="status-indicator published"></span> <?php echo e($stats['job_applications_reviewed'] ?? 0); ?> Reviewed
                    </div>
                    <?php if(($recentActivity['job_applications'] ?? 0) > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['job_applications']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- News -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon"><i class="fa fa-newspaper-o"></i></div>
                    <div class="title">News Articles</div>
                    <div class="value"><?php echo e($stats['news']); ?></div>
                    <div class="subtitle">
                        <?php echo e($stats['news_categories']); ?> Categories
                    </div>
                    <?php if($recentActivity['news'] > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['news']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Team & System -->
        <h3 class="section-title">Team & System</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Team Members -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="title">Team Members</div>
                    <div class="value"><?php echo e($stats['team_members']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['team_board_members']); ?> Board Members
                    </div>
                    <?php if($recentActivity['team_members'] > 0): ?>
                    <span class="badge-info">+<?php echo e($recentActivity['team_members']); ?> this month</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Partners -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon"><i class="fa fa-handshake-o"></i></div>
                    <div class="title">Partners</div>
                    <div class="value"><?php echo e($stats['partners']); ?></div>
                    <div class="subtitle">Business partners</div>
                </div>
            </div>

            <!-- System Users -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon"><i class="fa fa-user-secret"></i></div>
                    <div class="title">System Users</div>
                    <div class="value"><?php echo e($stats['users']); ?></div>
                    <div class="subtitle">
                        <?php echo e($stats['roles']); ?> Roles (<?php echo e($stats['roles_active']); ?> active)
                    </div>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon"><i class="fa fa-history"></i></div>
                    <div class="title">Activity Logs</div>
                    <div class="value"><?php echo e(number_format($stats['activity_logs'])); ?></div>
                    <div class="subtitle">
                        <?php echo e($stats['activity_logs_today']); ?> Today
                        <br>
                        <?php echo e($stats['activity_logs_week']); ?> This Week
                    </div>
                </div>
            </div>
        </div>

        <!-- Website Content -->
        <h3 class="section-title">Website Content</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Sliders -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon"><i class="fa fa-picture-o"></i></div>
                    <div class="title">Sliders</div>
                    <div class="value"><?php echo e($stats['sliders']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['sliders_active']); ?> Active
                        <br>
                        <span class="status-indicator unpublished"></span> <?php echo e($stats['sliders_inactive']); ?> Inactive
                    </div>
                </div>
            </div>

            <!-- Certificates -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon"><i class="fa fa-certificate"></i></div>
                    <div class="title">Certificates</div>
                    <div class="value"><?php echo e($stats['certificates']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['certificates_active']); ?> Active
                    </div>
                </div>
            </div>

            <!-- Menus -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon"><i class="fa fa-bars"></i></div>
                    <div class="title">Menus</div>
                    <div class="value"><?php echo e($stats['menus']); ?></div>
                    <div class="subtitle">
                        <?php echo e($stats['menu_items']); ?> Menu Items
                        <br>
                        <?php echo e($stats['menus_active']); ?> Active Menus
                    </div>
                </div>
            </div>

            <!-- Page Banners -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon"><i class="fa fa-image"></i></div>
                    <div class="title">Page Banners</div>
                    <div class="value"><?php echo e($stats['page_banners']); ?></div>
                    <div class="subtitle">Page header banners</div>
                </div>
            </div>

            <!-- FAQs -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card warning">
                    <div class="icon"><i class="fa fa-question-circle"></i></div>
                    <div class="title">FAQs</div>
                    <div class="value"><?php echo e($stats['faqs']); ?></div>
                    <div class="subtitle">Frequently asked questions</div>
                </div>
            </div>

            <!-- Home Blocks -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card orange">
                    <div class="icon"><i class="fa fa-th-large"></i></div>
                    <div class="title">Home Blocks</div>
                    <div class="value"><?php echo e($stats['home_blocks']); ?></div>
                    <div class="subtitle">Homepage content blocks</div>
                </div>
            </div>

            <!-- Cards -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon"><i class="fa fa-id-card"></i></div>
                    <div class="title">Cards</div>
                    <div class="value"><?php echo e($stats['cards']); ?></div>
                    <div class="subtitle">Content cards</div>
                </div>
            </div>

            <!-- About Features -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon"><i class="fa fa-star"></i></div>
                    <div class="title">About Features</div>
                    <div class="value"><?php echo e($stats['about_features']); ?></div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> <?php echo e($stats['about_features_active']); ?> Active
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic Data Categories -->
        <h3 class="section-title">Basic Data Categories</h3>
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon"><i class="fa fa-folder-open"></i></div>
                    <div class="title">Engineering Categories</div>
                    <div class="value"><?php echo e($stats['engineering_categories']); ?></div>
                    <div class="subtitle"><?php echo e($stats['engineering_subcategories']); ?> Subcategories</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon"><i class="fa fa-folder"></i></div>
                    <div class="title">Offer Categories</div>
                    <div class="value"><?php echo e($stats['offer_categories']); ?></div>
                    <div class="subtitle"><?php echo e($stats['offer_subcategories']); ?> Subcategories</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon"><i class="fa fa-paint-brush"></i></div>
                    <div class="title">Interior Categories</div>
                    <div class="value"><?php echo e($stats['interior_categories']); ?></div>
                    <div class="subtitle">Design categories</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon"><i class="fa fa-line-chart"></i></div>
                    <div class="title">Feasibility Studies</div>
                    <div class="value"><?php echo e($stats['feasibility_studies']); ?></div>
                    <div class="subtitle">Total studies</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <h3 class="section-title">Analytics & Distribution</h3>
        
        <!-- Status Charts - Row 1 -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Services Status</div>
                            <div class="chart-subtitle">Published vs Unpublished</div>
                        </div>
                    </div>
                    <canvas id="servicesStatusChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Projects Status</div>
                            <div class="chart-subtitle">Published vs Unpublished</div>
                        </div>
                    </div>
                    <canvas id="projectsStatusChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Status Charts - Row 2 -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Offers Status</div>
                            <div class="chart-subtitle">Published vs Unpublished</div>
                        </div>
                    </div>
                    <canvas id="offersStatusChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Interior Status</div>
                            <div class="chart-subtitle">Published vs Unpublished</div>
                        </div>
                    </div>
                    <canvas id="interiorStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Projects by Category</div>
                            <div class="chart-subtitle">Distribution across engineering categories</div>
                        </div>
                    </div>
                    <canvas id="categoryDistributionChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Offers by Category</div>
                            <div class="chart-subtitle">Distribution across offer categories</div>
                        </div>
                    </div>
                    <canvas id="offersCategoryChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function() {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded');
            return;
        }

        const colors = {
            primary: '#19868b',
            primaryDark: '#146a6e',
            accent: '#e1273d',
            success: '#10b981',
            info: '#3b82f6',
            warning: '#f6b500',
            danger: '#ef4444',
            orange: '#ff6935',
            secondary: '#172e38'
        };

        // Monthly Growth Chart
        var monthlyGrowthCtx = document.getElementById('monthlyGrowthChart');
        if (monthlyGrowthCtx) {
            monthlyGrowthCtx = monthlyGrowthCtx.getContext('2d');
            new Chart(monthlyGrowthCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($monthlyData['months']); ?>,
                    datasets: [
                        {
                            label: 'Services',
                            data: <?php echo json_encode($monthlyData['services']); ?>,
                            borderColor: colors.primary,
                            backgroundColor: 'rgba(25, 134, 139, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.primary,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Projects',
                            data: <?php echo json_encode($monthlyData['projects']); ?>,
                            borderColor: colors.accent,
                            backgroundColor: 'rgba(225, 39, 61, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.accent,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Offers',
                            data: <?php echo json_encode($monthlyData['offers']); ?>,
                            borderColor: colors.success,
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.success,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Interior Galleries',
                            data: <?php echo json_encode($monthlyData['interior_galleries']); ?>,
                            borderColor: colors.orange,
                            backgroundColor: 'rgba(255, 105, 53, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.orange,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'News',
                            data: <?php echo json_encode($monthlyData['news']); ?>,
                            borderColor: colors.info,
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.info,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: { padding: 20, usePointStyle: true, font: { size: 12, weight: '600' } }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(23, 46, 56, 0.95)',
                            padding: 14,
                            titleFont: { size: 14, weight: '700' },
                            bodyFont: { size: 13 },
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.04)' },
                            ticks: { font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Content Overview Chart
        var contentOverviewCtx = document.getElementById('contentOverviewChart');
        if (contentOverviewCtx) {
            contentOverviewCtx = contentOverviewCtx.getContext('2d');
            new Chart(contentOverviewCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Services', 'Projects', 'Offers', 'Interior', 'News', 'Team'],
                    datasets: [{
                        data: [
                            <?php echo e($stats['services']); ?>,
                            <?php echo e($stats['projects']); ?>,
                            <?php echo e($stats['offers']); ?>,
                            <?php echo e($stats['interior_galleries']); ?>,
                            <?php echo e($stats['news']); ?>,
                            <?php echo e($stats['team_members']); ?>

                        ],
                        backgroundColor: [
                            colors.primary,
                            colors.accent,
                            colors.success,
                            colors.orange,
                            colors.info,
                            colors.warning
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 12, usePointStyle: true, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Services Status Chart
        var servicesStatusCtx = document.getElementById('servicesStatusChart');
        if (servicesStatusCtx) {
            servicesStatusCtx = servicesStatusCtx.getContext('2d');
            new Chart(servicesStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Published', 'Unpublished'],
                    datasets: [{
                        data: [<?php echo e($statusDistribution['services']['published']); ?>, <?php echo e($statusDistribution['services']['unpublished']); ?>],
                        backgroundColor: [colors.success, colors.danger],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, font: { size: 12 } } }
                    }
                }
            });
        }

        // Projects Status Chart
        var projectsStatusCtx = document.getElementById('projectsStatusChart');
        if (projectsStatusCtx) {
            projectsStatusCtx = projectsStatusCtx.getContext('2d');
            new Chart(projectsStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Published', 'Unpublished'],
                    datasets: [{
                        data: [<?php echo e($statusDistribution['projects']['published']); ?>, <?php echo e($statusDistribution['projects']['unpublished']); ?>],
                        backgroundColor: [colors.success, colors.danger],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, font: { size: 12 } } }
                    }
                }
            });
        }

        // Offers Status Chart
        var offersStatusCtx = document.getElementById('offersStatusChart');
        if (offersStatusCtx) {
            offersStatusCtx = offersStatusCtx.getContext('2d');
            new Chart(offersStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Published', 'Unpublished'],
                    datasets: [{
                        data: [<?php echo e($statusDistribution['offers']['published']); ?>, <?php echo e($statusDistribution['offers']['unpublished']); ?>],
                        backgroundColor: [colors.success, colors.danger],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, font: { size: 12 } } }
                    }
                }
            });
        }

        // Interior Status Chart
        var interiorStatusCtx = document.getElementById('interiorStatusChart');
        if (interiorStatusCtx) {
            interiorStatusCtx = interiorStatusCtx.getContext('2d');
            new Chart(interiorStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Published', 'Unpublished'],
                    datasets: [{
                        data: [<?php echo e($statusDistribution['interior_galleries']['published']); ?>, <?php echo e($statusDistribution['interior_galleries']['unpublished']); ?>],
                        backgroundColor: [colors.success, colors.danger],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, font: { size: 12 } } }
                    }
                }
            });
        }

        // Category Distribution Chart
        var categoryDistributionCtx = document.getElementById('categoryDistributionChart');
        if (categoryDistributionCtx) {
            categoryDistributionCtx = categoryDistributionCtx.getContext('2d');
            new Chart(categoryDistributionCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($categoryDistribution['labels']); ?>,
                    datasets: [{
                        label: 'Projects',
                        data: <?php echo json_encode($categoryDistribution['data']); ?>,
                        backgroundColor: [
                            colors.primary,
                            colors.accent,
                            colors.success,
                            colors.info,
                            colors.warning,
                            colors.orange,
                            '#8b5cf6',
                            colors.secondary
                        ],
                        borderWidth: 0,
                        borderRadius: 8,
                        barThickness: 30
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: 'y',
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.04)' }
                        },
                        y: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Offers Category Chart
        var offersCategoryCtx = document.getElementById('offersCategoryChart');
        if (offersCategoryCtx) {
            offersCategoryCtx = offersCategoryCtx.getContext('2d');
            new Chart(offersCategoryCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($offersCategoryDistribution['labels']); ?>,
                    datasets: [{
                        label: 'Offers',
                        data: <?php echo json_encode($offersCategoryDistribution['data']); ?>,
                        backgroundColor: [
                            colors.accent,
                            colors.primary,
                            colors.success,
                            colors.info,
                            colors.warning,
                            colors.orange,
                            '#8b5cf6',
                            colors.secondary
                        ],
                        borderWidth: 0,
                        borderRadius: 8,
                        barThickness: 30
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: 'y',
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.04)' }
                        },
                        y: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/index.blade.php ENDPATH**/ ?>