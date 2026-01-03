@extends('admin::layouts.master')
@section('title', 'Admin Dashboard')

@section('css')
<style>
    :root {
        --primary-color: #1a7d6b;
        --primary-dark: #145f52;
        --primary-light: #22a88f;
        --secondary-color: #2d3748;
        --accent-color: #e8b85e;
        --accent-light: #f0cb82;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f7f9fc;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .page-content-wrapper {
        background: linear-gradient(135deg, #f7f9fc 0%, #eef2f7 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        color: white;
        padding: 35px 40px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(26, 125, 107, 0.3);
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
        background: radial-gradient(circle, rgba(232,184,94,0.2) 0%, transparent 70%);
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
        gap: 30px;
        margin-top: 25px;
        position: relative;
        z-index: 1;
    }

    .dashboard-header .header-stat {
        text-align: center;
        padding: 15px 25px;
        background: rgba(255,255,255,0.1);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
    }

    .dashboard-header .header-stat .number {
        font-size: 28px;
        font-weight: 700;
        color: var(--accent-color);
    }

    .dashboard-header .header-stat .label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.8;
        margin-top: 5px;
    }

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
        box-shadow: 0 20px 40px rgba(26, 125, 107, 0.15);
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

    .stat-card.primary::before {
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    }

    .stat-card.accent::before {
        background: linear-gradient(90deg, var(--accent-color), var(--accent-light));
    }

    .stat-card.success::before {
        background: linear-gradient(90deg, var(--success-color), #34d399);
    }

    .stat-card.info::before {
        background: linear-gradient(90deg, var(--info-color), #60a5fa);
    }

    .stat-card.warning::before {
        background: linear-gradient(90deg, var(--warning-color), #fbbf24);
    }

    .stat-card.danger::before {
        background: linear-gradient(90deg, var(--danger-color), #f87171);
    }

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
        box-shadow: 0 8px 20px rgba(26, 125, 107, 0.3);
        position: relative;
    }

    .stat-card.accent .icon {
        background: linear-gradient(135deg, var(--accent-color), #d4a44e);
        box-shadow: 0 8px 20px rgba(232, 184, 94, 0.3);
    }

    .stat-card.success .icon {
        background: linear-gradient(135deg, var(--success-color), #059669);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .stat-card.info .icon {
        background: linear-gradient(135deg, var(--info-color), #2563eb);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .stat-card.warning .icon {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }

    .stat-card.danger .icon {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

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

    .stat-card .subtitle .status-indicator.published {
        background: var(--success-color);
    }

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
        box-shadow: 0 4px 10px rgba(26, 125, 107, 0.25);
    }

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

    .activity-badge {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 8px;
    }

    .activity-badge.success {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }

    canvas {
        max-height: 350px;
    }

    /* Quick Actions Panel */
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
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 15px;
    }

    .quick-actions .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 15px;
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
        box-shadow: 0 10px 25px rgba(26, 125, 107, 0.25);
    }

    .quick-actions .action-item i {
        font-size: 24px;
        margin-bottom: 10px;
        color: var(--primary-color);
        transition: color 0.3s ease;
    }

    .quick-actions .action-item:hover i {
        color: white;
    }

    .quick-actions .action-item span {
        font-size: 13px;
        font-weight: 600;
        text-align: center;
    }

    /* Stats Summary Row */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .summary-card .summary-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .summary-card .summary-icon.primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    }

    .summary-card .summary-icon.accent {
        background: linear-gradient(135deg, var(--accent-color), #d4a44e);
    }

    .summary-card .summary-icon.success {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }

    .summary-card .summary-icon.info {
        background: linear-gradient(135deg, var(--info-color), #2563eb);
    }

    .summary-card .summary-content .summary-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--secondary-color);
    }

    .summary-card .summary-content .summary-label {
        font-size: 13px;
        color: #9ca3af;
        font-weight: 500;
    }

    @media (max-width: 1200px) {
        .stats-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-summary {
            grid-template-columns: 1fr;
        }

        .stat-card {
            margin-bottom: 15px;
        }
        
        .dashboard-header h2 {
            font-size: 24px;
        }

        .dashboard-header .header-stats {
            flex-wrap: wrap;
            gap: 15px;
        }

        .dashboard-header .header-stat {
            padding: 10px 15px;
        }

        .quick-actions .action-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')
                    <div class="page-content-wrapper">
                        <div class="container-fluid">

        <!-- Dashboard Header -->
        <div class="dashboard-header animate__animated animate__fadeInDown" style="margin-top:70px">
            <h2><i class="fa fa-pie-chart"></i> CMS Dashboard</h2>
            <p>Welcome back! Here's an overview of your content management system.</p>
            <div class="header-stats">
                <div class="header-stat">
                    <div class="number">{{ $stats['services'] + $stats['projects'] + $stats['offers'] + $stats['news'] }}</div>
                    <div class="label">Total Content</div>
                </div>
                <div class="header-stat">
                    <div class="number">{{ $stats['services_published'] + $stats['projects_published'] + $stats['offers_published'] }}</div>
                    <div class="label">Published Items</div>
                </div>
                <div class="header-stat">
                    <div class="number">{{ $recentActivity['services'] + $recentActivity['projects'] + $recentActivity['offers'] + $recentActivity['news'] }}</div>
                    <div class="label">New This Month</div>
                </div>
                <div class="header-stat">
                    <div class="number">{{ $stats['contact_submissions'] ?? 0 }}</div>
                    <div class="label">Contact Forms</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions animate__animated animate__fadeInUp">
            <div class="action-title"><i class="fa fa-bolt"></i> Quick Actions</div>
            <div class="action-grid">
                <a href="{{ route('service.index') }}" class="action-item">
                    <i class="fa fa-cogs"></i>
                    <span>Services</span>
                </a>
                <a href="{{ route('project.index') }}" class="action-item">
                    <i class="fa fa-building"></i>
                    <span>Projects</span>
                </a>
                <a href="{{ route('offer.index') }}" class="action-item">
                    <i class="fa fa-tags"></i>
                    <span>Offers</span>
                </a>
                <a href="{{ route('news-back.index') }}" class="action-item">
                    <i class="fa fa-newspaper-o"></i>
                    <span>News</span>
                </a>
                <a href="{{ route('admin.team.index') }}" class="action-item">
                    <i class="fa fa-users"></i>
                    <span>Team</span>
                </a>
                <a href="{{ route('partner.index') }}" class="action-item">
                    <i class="fa fa-handshake-o"></i>
                    <span>Partners</span>
                </a>
                <a href="{{ route('slider.index') }}" class="action-item">
                    <i class="fa fa-picture-o"></i>
                    <span>Sliders</span>
                </a>
                <a href="{{ route('faq.index') }}" class="action-item">
                    <i class="fa fa-question-circle"></i>
                    <span>FAQs</span>
                </a>
            </div>
        </div>

        <!-- Quick Overview Charts -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Total Content Overview -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Content Overview</div>
                            <div class="chart-subtitle">Total items by content type</div>
                        </div>
                    </div>
                    <canvas id="contentOverviewChart"></canvas>
                </div>
            </div>

            <!-- Recent Activity Chart -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Recent Activity (Last 30 Days)</div>
                            <div class="chart-subtitle">New additions this month</div>
                        </div>
                    </div>
                    <canvas id="recentActivityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Main Statistics Cards -->
        <h3 class="section-title">Main Content Statistics</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Services -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="fa fa-cogs"></i>
                    </div>
                    <div class="title">Services</div>
                    <div class="value">{{ $stats['services'] }}</div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> {{ $stats['services_published'] }} Published
                        <br>
                        <span class="status-indicator published"></span> {{ $stats['services_featured'] }} Featured
                                        </div>
                    @if($recentActivity['services'] > 0)
                    <span class="badge-info">+{{ $recentActivity['services'] }} this month</span>
                    @endif
                                    </div>
                                </div>

            <!-- Projects -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="title">Projects</div>
                    <div class="value">{{ $stats['projects'] }}</div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> {{ $stats['projects_published'] }} Published
                        <br>
                        <span class="status-indicator published"></span> {{ $stats['projects_featured'] }} Featured
                                        </div>
                    @if($recentActivity['projects'] > 0)
                    <span class="badge-info">+{{ $recentActivity['projects'] }} this month</span>
                    @endif
                                    </div>
                                </div>

            <!-- Offers -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon">
                        <i class="fa fa-tags"></i>
                    </div>
                    <div class="title">Offers</div>
                    <div class="value">{{ $stats['offers'] }}</div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> {{ $stats['offers_published'] }} Published
                        <br>
                        <span class="status-indicator published"></span> {{ $stats['offers_featured'] }} Featured
                    </div>
                    @if($recentActivity['offers'] > 0)
                    <span class="badge-info">+{{ $recentActivity['offers'] }} this month</span>
                    @endif
                </div>
            </div>

            <!-- News -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon">
                        <i class="fa fa-newspaper-o"></i>
                    </div>
                    <div class="title">News Articles</div>
                    <div class="value">{{ $stats['news'] }}</div>
                    <div class="subtitle">
                        {{ $stats['news_categories'] }} Categories
                    </div>
                    @if($recentActivity['news'] > 0)
                    <span class="badge-info">+{{ $recentActivity['news'] }} this month</span>
                    @endif
                                        </div>
                                    </div>
                                </div>

        <!-- Contact & Careers -->
        <h3 class="section-title">Contact & Careers</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Contact Submissions -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card warning">
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="title">Contact Submissions</div>
                    <div class="value">{{ $stats['contact_submissions'] ?? 0 }}</div>
                    <div class="subtitle">
                        <span class="status-indicator" style="background: var(--warning-color);"></span> {{ $stats['contact_pending'] ?? 0 }} Pending Review
                    </div>
                </div>
            </div>

            <!-- Job Postings -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="title">Job Postings</div>
                    <div class="value">{{ $stats['jobs_postings'] ?? 0 }}</div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> {{ $stats['jobs_active'] ?? 0 }} Active Jobs
                    </div>
                </div>
            </div>

            <!-- Job Applications -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                    <div class="title">Job Applications</div>
                    <div class="value">{{ $stats['job_applications'] ?? 0 }}</div>
                    <div class="subtitle">
                        <span class="status-indicator" style="background: var(--warning-color);"></span> {{ $stats['job_applications_pending'] ?? 0 }} Pending
                    </div>
                </div>
            </div>

            <!-- System Users -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon">
                        <i class="fa fa-user-secret"></i>
                    </div>
                    <div class="title">System Users</div>
                    <div class="value">{{ $stats['users'] }}</div>
                    <div class="subtitle">Admin users</div>
                                        </div>
                                    </div>
                                </div>

        <!-- Team & Partners -->
        <h3 class="section-title">Team & Partners</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Team Members -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                                        </div>
                    <div class="title">Team Members</div>
                    <div class="value">{{ $stats['team_members'] }}</div>
                    <div class="subtitle">Active team members</div>
                    @if($recentActivity['team_members'] > 0)
                    <span class="badge-info">+{{ $recentActivity['team_members'] }} this month</span>
                    @endif
                                    </div>
                                </div>

            <!-- Partners -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon">
                        <i class="fa fa-handshake-o"></i>
                    </div>
                    <div class="title">Partners</div>
                    <div class="value">{{ $stats['partners'] }}</div>
                    <div class="subtitle">Business partners</div>
                </div>
            </div>

            <!-- Feasibility Studies -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon">
                        <i class="fa fa-line-chart"></i>
                    </div>
                    <div class="title">Feasibility Studies</div>
                    <div class="value">{{ $stats['feasibility_studies'] }}</div>
                    <div class="subtitle">Total studies</div>
                </div>
            </div>

            <!-- FAQs -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon">
                        <i class="fa fa-question-circle"></i>
                            </div>
                    <div class="title">FAQs</div>
                    <div class="value">{{ $stats['faqs'] }}</div>
                    <div class="subtitle">Frequently asked questions</div>
                                        </div>
                                    </div>
                                </div>

        <!-- Website Content -->
        <h3 class="section-title">Website Content</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Sliders -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="fa fa-picture-o"></i>
                    </div>
                    <div class="title">Sliders</div>
                    <div class="value">{{ $stats['sliders'] }}</div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> {{ $stats['sliders_active'] }} Active
                                        </div>
                                    </div>
                                </div>

            <!-- Showcases -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="title">Showcases</div>
                    <div class="value">{{ $stats['showcases'] }}</div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> {{ $stats['showcases_active'] }} Active
                                        </div>
                </div>
            </div>

            <!-- Home Blocks -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon">
                        <i class="fa fa-th-large"></i>
                    </div>
                    <div class="title">Home Blocks</div>
                    <div class="value">{{ $stats['home_blocks'] }}</div>
                    <div class="subtitle">Homepage blocks</div>
                </div>
            </div>

            <!-- Cards -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon">
                        <i class="fa fa-id-card"></i>
                    </div>
                    <div class="title">Cards</div>
                    <div class="value">{{ $stats['cards'] }}</div>
                    <div class="subtitle">Content cards</div>
                </div>
                            </div>

            <!-- Home FAQs -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card warning">
                    <div class="icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="title">Home FAQs</div>
                    <div class="value">{{ $stats['home_faqs'] }}</div>
                    <div class="subtitle">Homepage FAQs</div>
                </div>
                            </div>

            <!-- About Features -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="fa fa-info-circle"></i>
                    </div>
                    <div class="title">About Features</div>
                    <div class="value">{{ $stats['about_features'] }}</div>
                    <div class="subtitle">About page features</div>
                </div>
                         </div>
            
            <!-- About Custom Blocks -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card accent">
                    <div class="icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    <div class="title">About Custom Blocks</div>
                    <div class="value">{{ $stats['about_custom_blocks'] }}</div>
                    <div class="subtitle">Custom about blocks</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <h3 class="section-title">Analytics & Trends</h3>
        
        <!-- Monthly Growth Chart - Full Width -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Monthly Content Growth</div>
                            <div class="chart-subtitle">Last 6 months trend analysis</div>
                        </div>
                    </div>
                    <canvas id="monthlyGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Charts - Two per Row -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Services Status -->
            <div class="col-lg-4">
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

            <!-- Projects Status -->
            <div class="col-lg-4">
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

            <!-- Offers Status -->
            <div class="col-lg-4">
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
            </div>

            <!-- Category Distribution -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Projects by Category</div>
                            <div class="chart-subtitle">Category distribution</div>
                        </div>
                    </div>
                    <canvas id="categoryDistributionChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Check if Chart is available
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded');
            return;
        }

        // Custom color palette matching the new theme
        const colors = {
            primary: '#1a7d6b',
            primaryDark: '#145f52',
            accent: '#e8b85e',
            success: '#10b981',
            info: '#3b82f6',
            warning: '#f59e0b',
            danger: '#ef4444',
            secondary: '#2d3748'
        };

    // Monthly Growth Chart
    var monthlyGrowthCtx = document.getElementById('monthlyGrowthChart');
    if (monthlyGrowthCtx) {
        monthlyGrowthCtx = monthlyGrowthCtx.getContext('2d');
    var monthlyGrowthChart = new Chart(monthlyGrowthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyData['months']) !!},
            datasets: [
                {
                    label: 'Services',
                    data: {!! json_encode($monthlyData['services']) !!},
                            borderColor: colors.primary,
                            backgroundColor: 'rgba(26, 125, 107, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.primary,
                            pointRadius: 5,
                            pointHoverRadius: 7
                },
                {
                    label: 'Projects',
                    data: {!! json_encode($monthlyData['projects']) !!},
                            borderColor: colors.accent,
                            backgroundColor: 'rgba(232, 184, 94, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.accent,
                            pointRadius: 5,
                            pointHoverRadius: 7
                },
                {
                            label: 'Offers',
                            data: {!! json_encode($monthlyData['offers']) !!},
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
                    label: 'News',
                    data: {!! json_encode($monthlyData['news']) !!},
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
                    labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: { size: 12, weight: '600' }
                    }
                },
                tooltip: {
                            backgroundColor: 'rgba(45, 55, 72, 0.95)',
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

    // Services Status Chart
    var servicesStatusCtx = document.getElementById('servicesStatusChart');
    if (servicesStatusCtx) {
        servicesStatusCtx = servicesStatusCtx.getContext('2d');
    var servicesStatusChart = new Chart(servicesStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Unpublished'],
            datasets: [{
                data: [
                    {{ $statusDistribution['services']['published'] }},
                    {{ $statusDistribution['services']['unpublished'] }}
                ],
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
                legend: {
                    position: 'bottom',
                            labels: { padding: 15, usePointStyle: true, font: { size: 12 } }
                }
            }
        }
    });
    }

    // Projects Status Chart
    var projectsStatusCtx = document.getElementById('projectsStatusChart');
    if (projectsStatusCtx) {
        projectsStatusCtx = projectsStatusCtx.getContext('2d');
    var projectsStatusChart = new Chart(projectsStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Unpublished'],
            datasets: [{
                data: [
                    {{ $statusDistribution['projects']['published'] }},
                    {{ $statusDistribution['projects']['unpublished'] }}
                ],
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
                legend: {
                    position: 'bottom',
                            labels: { padding: 15, usePointStyle: true, font: { size: 12 } }
                }
            }
        }
    });
    }

        // Offers Status Chart
        var offersStatusCtx = document.getElementById('offersStatusChart');
        if (offersStatusCtx) {
            offersStatusCtx = offersStatusCtx.getContext('2d');
            var offersStatusChart = new Chart(offersStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Unpublished'],
            datasets: [{
                data: [
                            {{ $statusDistribution['offers']['published'] }},
                            {{ $statusDistribution['offers']['unpublished'] }}
                ],
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
                legend: {
                    position: 'bottom',
                            labels: { padding: 15, usePointStyle: true, font: { size: 12 } }
                }
            }
        }
    });
    }

    // Category Distribution Chart
    var categoryDistributionCtx = document.getElementById('categoryDistributionChart');
    if (categoryDistributionCtx) {
        categoryDistributionCtx = categoryDistributionCtx.getContext('2d');
    var categoryDistributionChart = new Chart(categoryDistributionCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($categoryDistribution['labels']) !!},
            datasets: [{
                data: {!! json_encode($categoryDistribution['data']) !!},
                backgroundColor: [
                            colors.primary,
                            colors.accent,
                            colors.success,
                            colors.info,
                            colors.warning,
                            '#8b5cf6',
                            '#ec4899',
                            colors.secondary
                ],
                        borderWidth: 0,
                        hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                                padding: 12,
                        usePointStyle: true,
                                font: { size: 11 }
                    }
                }
            }
        }
    });
    }

    // Content Overview Chart
    var contentOverviewCtx = document.getElementById('contentOverviewChart');
    if (contentOverviewCtx) {
        contentOverviewCtx = contentOverviewCtx.getContext('2d');
    var contentOverviewChart = new Chart(contentOverviewCtx, {
        type: 'bar',
        data: {
                    labels: ['Services', 'Projects', 'Offers', 'News', 'Team', 'Partners', 'FAQs', 'Sliders'],
            datasets: [{
                label: 'Total Items',
                data: [
                    {{ $stats['services'] }},
                    {{ $stats['projects'] }},
                            {{ $stats['offers'] }},
                    {{ $stats['news'] }},
                    {{ $stats['team_members'] }},
                    {{ $stats['partners'] }},
                    {{ $stats['faqs'] }},
                    {{ $stats['sliders'] }}
                ],
                backgroundColor: [
                            colors.primary,
                            colors.accent,
                            colors.success,
                            colors.info,
                            colors.warning,
                            '#8b5cf6',
                            '#ec4899',
                            colors.secondary
                ],
                borderWidth: 0,
                        borderRadius: 8,
                        barThickness: 35
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                        legend: { display: false },
                tooltip: {
                            backgroundColor: 'rgba(45, 55, 72, 0.95)',
                    padding: 12,
                            titleFont: { size: 14, weight: '700' },
                            bodyFont: { size: 13 },
                            cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.04)' },
                            ticks: { precision: 0, font: { size: 11 } }
                },
                x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                }
            }
        }
    });
    }

    // Recent Activity Chart
    var recentActivityCtx = document.getElementById('recentActivityChart');
    if (recentActivityCtx) {
        recentActivityCtx = recentActivityCtx.getContext('2d');
    var recentActivityChart = new Chart(recentActivityCtx, {
        type: 'doughnut',
        data: {
                    labels: ['Services', 'Projects', 'Offers', 'News', 'Team Members'],
            datasets: [{
                data: [
                    {{ $recentActivity['services'] }},
                    {{ $recentActivity['projects'] }},
                            {{ $recentActivity['offers'] }},
                    {{ $recentActivity['news'] }},
                    {{ $recentActivity['team_members'] }}
                ],
                backgroundColor: [
                            colors.primary,
                            colors.accent,
                            colors.success,
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
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                                font: { size: 12 }
                    }
                },
                tooltip: {
                            backgroundColor: 'rgba(45, 55, 72, 0.95)',
                    padding: 12,
                            cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed + ' new items';
                            return label;
                        }
                    }
                }
            }
        }
    });
    }
    });
</script>
@endsection
