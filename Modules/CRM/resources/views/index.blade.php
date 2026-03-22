@extends('admin::layouts.master')
@section('title', 'CRM Dashboard')

@section('css')
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
    .dashboard-header .header-stat.highlight .number { color: var(--warning-color); }
    .dashboard-header .header-stat.danger .number { color: var(--accent-color); }

    .summary-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
        cursor: pointer;
        text-decoration: none;
    }
    .summary-mini-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        text-decoration: none;
    }
    .summary-mini-card.primary { border-left-color: var(--primary-color); }
    .summary-mini-card.accent { border-left-color: var(--accent-color); }
    .summary-mini-card.success { border-left-color: var(--success-color); }
    .summary-mini-card.warning { border-left-color: var(--warning-color); }
    .summary-mini-card.info { border-left-color: var(--info-color); }
    .summary-mini-card.orange { border-left-color: var(--orange-color); }
    .summary-mini-card.danger { border-left-color: var(--danger-color); }

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
    .summary-mini-card.danger .mini-icon { background: linear-gradient(135deg, var(--danger-color), #dc2626); }

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
    .summary-mini-card .mini-badge.up { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }
    .summary-mini-card .mini-badge.pending { background: rgba(246, 181, 0, 0.1); color: var(--warning-color); }

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
        margin-bottom: 25px;
        padding-left: 18px;
        border-left: 5px solid var(--primary-color);
        position: relative;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 18px;
        width: 60px;
        height: 3px;
        background: var(--accent-color);
        border-radius: 2px;
    }

    .top-list-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        margin-bottom: 25px;
    }
    .top-list-header {
        padding: 18px 24px;
        font-weight: 700;
        font-size: 16px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .top-list-header.projects { background: linear-gradient(135deg, var(--accent-color), #c41f33); }
    .top-list-header.offers { background: linear-gradient(135deg, var(--success-color), #059669); }
    .top-list-header.interiors { background: linear-gradient(135deg, var(--info-color), #2563eb); }

    .top-list-body { padding: 0; }
    .top-list-item {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s;
    }
    .top-list-item:hover { background: #f8fafc; }
    .top-list-item:last-child { border-bottom: none; }
    .top-list-rank {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        margin-right: 14px;
    }
    .top-list-rank.r1 { background: linear-gradient(135deg, #f6b500, #d97706); }
    .top-list-rank.r2 { background: linear-gradient(135deg, #9ca3af, #6b7280); }
    .top-list-rank.r3 { background: linear-gradient(135deg, #d97706, #b45309); }
    .top-list-rank.r-default { background: #e5e7eb; color: #6b7280; }
    .top-list-info { flex: 1; min-width: 0; }
    .top-list-title {
        font-weight: 600;
        font-size: 14px;
        color: var(--secondary-color);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .top-list-code {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 2px;
    }
    .top-list-count {
        background: #f3f4f6;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        color: var(--secondary-color);
        flex-shrink: 0;
        margin-left: 10px;
    }
    .top-list-empty {
        padding: 30px;
        text-align: center;
        color: #ccc;
        font-size: 14px;
    }

    .activity-panel {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        margin-bottom: 25px;
    }
    .activity-panel .panel-header {
        padding: 18px 24px;
        font-weight: 700;
        font-size: 16px;
        color: var(--secondary-color);
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .activity-panel .panel-header i { color: var(--primary-color); }
    .activity-item {
        display: flex;
        align-items: center;
        padding: 14px 24px;
        border-bottom: 1px solid #f8f9fc;
        transition: background 0.2s;
    }
    .activity-item:hover { background: #f8fafc; }
    .activity-item:last-child { border-bottom: none; }
    .activity-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        margin-right: 14px;
    }
    .activity-info { flex: 1; min-width: 0; }
    .activity-name {
        font-weight: 600;
        font-size: 14px;
        color: var(--secondary-color);
    }
    .activity-detail {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 2px;
    }
    .activity-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
        margin-left: 10px;
    }
    .badge-pending { background: rgba(246, 181, 0, 0.1); color: var(--warning-color); }
    .badge-inprogress { background: rgba(59, 130, 246, 0.1); color: var(--info-color); }
    .badge-done { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }

    .agent-bar {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        border-bottom: 1px solid #f3f4f6;
    }
    .agent-bar:last-child { border-bottom: none; }
    .agent-bar-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
        margin-right: 12px;
    }
    .agent-bar-name {
        flex: 1;
        font-weight: 600;
        font-size: 14px;
        color: var(--secondary-color);
    }
    .agent-bar-stats {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }
    .agent-bar-stat {
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--card-shadow);
    }
    .quick-actions .action-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 18px;
    }
    .quick-actions .action-title i { color: var(--warning-color); margin-right: 8px; }
    .quick-actions .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 12px;
    }
    .quick-actions .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 18px 10px;
        background: var(--light-bg);
        border-radius: 12px;
        color: var(--secondary-color);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    .quick-actions .action-item:hover {
        background: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.15);
        color: var(--primary-color);
        text-decoration: none;
    }
    .quick-actions .action-item i { font-size: 24px; color: var(--primary-color); }

    @media (max-width: 1200px) { .summary-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .summary-row { grid-template-columns: 1fr; }
        .dashboard-header { padding: 25px; }
        .dashboard-header h2 { font-size: 24px; }
        .dashboard-header .header-stats { gap: 10px; }
        .dashboard-header .header-stat { min-width: 90px; padding: 10px 15px; }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        {{-- Dashboard Header --}}
        <div class="dashboard-header" style="margin-top:70px;">
            <h2><i class="fa fa-dashboard"></i> CRM Dashboard</h2>
            <p>Welcome back, {{ auth()->user()->name }}! Here's your customer relationship overview.</p>
            <div class="header-stats">
                <div class="header-stat">
                    <div class="number">{{ number_format($contactStats->total) }}</div>
                    <div class="label">Contact Messages</div>
                </div>
                <div class="header-stat">
                    <div class="number">{{ number_format($favStats->total_sessions) }}</div>
                    <div class="label">Favourite Sessions</div>
                </div>
                <div class="header-stat highlight">
                    <div class="number">{{ number_format($contactStats->this_week) }}</div>
                    <div class="label">New This Week</div>
                </div>
                <div class="header-stat danger">
                    <div class="number">{{ number_format($contactStats->pending) }}</div>
                    <div class="label">Pending</div>
                </div>
                <div class="header-stat">
                    <div class="number">{{ number_format($agentsCount) }}</div>
                    <div class="label">Active Agents</div>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="summary-row">
            <a href="{{ route('crm-contact-us.index') }}" class="summary-mini-card primary">
                <div class="mini-icon"><i class="fa fa-envelope"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $contactStats->total }}</div>
                    <div class="mini-label">Total Contacts</div>
                </div>
                @if($contactStats->today > 0)
                <span class="mini-badge up">+{{ $contactStats->today }} today</span>
                @endif
            </a>
            <a href="{{ route('crm-contact-us.index', ['status' => 'Pending']) }}" class="summary-mini-card warning">
                <div class="mini-icon"><i class="fa fa-clock-o"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $contactStats->pending }}</div>
                    <div class="mini-label">Pending Contacts</div>
                </div>
                @if($contactStats->pending > 0)
                <span class="mini-badge pending">Needs Review</span>
                @endif
            </a>
            <a href="{{ route('crm-contact-us.index', ['status' => 'InProgress']) }}" class="summary-mini-card info">
                <div class="mini-icon"><i class="fa fa-spinner"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $contactStats->in_progress }}</div>
                    <div class="mini-label">In Progress</div>
                </div>
            </a>
            <a href="{{ route('crm-contact-us.index', ['status' => 'Done']) }}" class="summary-mini-card success">
                <div class="mini-icon"><i class="fa fa-check-circle"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $contactStats->done }}</div>
                    <div class="mini-label">Completed</div>
                </div>
            </a>
        </div>

        <div class="summary-row">
            <a href="{{ route('crm-favourites.index') }}" class="summary-mini-card accent">
                <div class="mini-icon"><i class="fa fa-heart"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $favStats->total_sessions }}</div>
                    <div class="mini-label">Fav Sessions</div>
                </div>
            </a>
            <div class="summary-mini-card orange">
                <div class="mini-icon"><i class="fa fa-star"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $favStats->total_items }}</div>
                    <div class="mini-label">Total Fav Items</div>
                </div>
            </div>
            <div class="summary-mini-card primary">
                <div class="mini-icon"><i class="fa fa-paper-plane"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $emailsSent }}</div>
                    <div class="mini-label">Emails Sent</div>
                </div>
            </div>
            <a href="{{ route('crm-agents.index') }}" class="summary-mini-card danger">
                <div class="mini-icon"><i class="fa fa-user-secret"></i></div>
                <div class="mini-content">
                    <div class="mini-value">{{ $agentsCount }}</div>
                    <div class="mini-label">Active Agents</div>
                </div>
            </a>
        </div>

        {{-- Quick Actions --}}
        <div class="quick-actions">
            <div class="action-title"><i class="fa fa-bolt"></i> Quick Actions</div>
            <div class="action-grid">
                <a href="{{ route('crm-contact-us.index') }}" class="action-item">
                    <i class="fa fa-envelope"></i>
                    <span>Contact Us</span>
                </a>
                <a href="{{ route('crm-favourites.index') }}" class="action-item">
                    <i class="fa fa-heart"></i>
                    <span>Favourites</span>
                </a>
                <a href="{{ route('crm-agents.index') }}" class="action-item">
                    <i class="fa fa-user-secret"></i>
                    <span>Agents</span>
                </a>
                <a href="{{ route('crm-agents.create') }}" class="action-item">
                    <i class="fa fa-user-plus"></i>
                    <span>Add Agent</span>
                </a>
                <a href="{{ route('crm-contact-us.index', ['status' => 'Pending']) }}" class="action-item">
                    <i class="fa fa-clock-o"></i>
                    <span>Pending</span>
                </a>
                <a href="{{ route('crm-contact-us.index', ['agent' => 'unassigned']) }}" class="action-item">
                    <i class="fa fa-user-times"></i>
                    <span>Unassigned</span>
                </a>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Activity Trend</div>
                            <div class="chart-subtitle">Contact messages & favourite sessions over the last 6 months</div>
                        </div>
                    </div>
                    <canvas id="trendChart" height="100"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Contact Status</div>
                            <div class="chart-subtitle">Distribution by status</div>
                        </div>
                    </div>
                    <canvas id="contactStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Favourites Breakdown</div>
                            <div class="chart-subtitle">Items by type</div>
                        </div>
                    </div>
                    <canvas id="favTypeChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Contacts by Service</div>
                            <div class="chart-subtitle">Most requested services</div>
                        </div>
                    </div>
                    <canvas id="serviceChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Top Favourited Items --}}
        <div class="section-title" style="margin-top:10px;">Top Favourited Items</div>
        <div class="row">
            <div class="col-lg-4">
                <div class="top-list-card">
                    <div class="top-list-header projects"><span><i class="fa fa-building"></i> Top Projects</span><span>{{ $topProjects->count() }}</span></div>
                    <div class="top-list-body">
                        @forelse($topProjects as $index => $item)
                        <div class="top-list-item">
                            <div class="top-list-rank {{ $index === 0 ? 'r1' : ($index === 1 ? 'r2' : ($index === 2 ? 'r3' : 'r-default')) }}">{{ $index + 1 }}</div>
                            <div class="top-list-info">
                                <div class="top-list-title">{{ $item->title ?? 'N/A' }}</div>
                                @if($item->code)<div class="top-list-code">{{ $item->code }}</div>@endif
                            </div>
                            <div class="top-list-count">{{ $item->fav_count }}</div>
                        </div>
                        @empty
                        <div class="top-list-empty"><i class="fa fa-building" style="font-size:24px;display:block;margin-bottom:8px;"></i> No project favourites yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="top-list-card">
                    <div class="top-list-header offers"><span><i class="fa fa-tags"></i> Top Offers</span><span>{{ $topOffers->count() }}</span></div>
                    <div class="top-list-body">
                        @forelse($topOffers as $index => $item)
                        <div class="top-list-item">
                            <div class="top-list-rank {{ $index === 0 ? 'r1' : ($index === 1 ? 'r2' : ($index === 2 ? 'r3' : 'r-default')) }}">{{ $index + 1 }}</div>
                            <div class="top-list-info">
                                <div class="top-list-title">{{ $item->title ?? 'N/A' }}</div>
                                @if($item->code)<div class="top-list-code">{{ $item->code }}</div>@endif
                            </div>
                            <div class="top-list-count">{{ $item->fav_count }}</div>
                        </div>
                        @empty
                        <div class="top-list-empty"><i class="fa fa-tags" style="font-size:24px;display:block;margin-bottom:8px;"></i> No offer favourites yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="top-list-card">
                    <div class="top-list-header interiors"><span><i class="fa fa-paint-brush"></i> Top Interior Designs</span><span>{{ $topInteriors->count() }}</span></div>
                    <div class="top-list-body">
                        @forelse($topInteriors as $index => $item)
                        <div class="top-list-item">
                            <div class="top-list-rank {{ $index === 0 ? 'r1' : ($index === 1 ? 'r2' : ($index === 2 ? 'r3' : 'r-default')) }}">{{ $index + 1 }}</div>
                            <div class="top-list-info">
                                <div class="top-list-title">{{ $item->title ?? 'N/A' }}</div>
                                <div class="top-list-code">ID: {{ $item->item_id }}</div>
                            </div>
                            <div class="top-list-count">{{ $item->fav_count }}</div>
                        </div>
                        @empty
                        <div class="top-list-empty"><i class="fa fa-paint-brush" style="font-size:24px;display:block;margin-bottom:8px;"></i> No interior favourites yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Agent Performance & Recent Contacts --}}
        <div class="row">
            <div class="col-lg-5">
                <div class="activity-panel">
                    <div class="panel-header"><i class="fa fa-user-secret"></i> Agent Workload</div>
                    @forelse($agentPerformance as $agent)
                    <div class="agent-bar">
                        <div class="agent-bar-avatar">{{ strtoupper(substr($agent->full_name_en, 0, 1)) }}</div>
                        <div class="agent-bar-name">{{ $agent->full_name_en }}</div>
                        <div class="agent-bar-stats">
                            <span class="agent-bar-stat" style="background:rgba(25,134,139,0.1);color:var(--primary-color);">
                                <i class="fa fa-envelope"></i> {{ $agent->contacts_assigned }}
                            </span>
                            <span class="agent-bar-stat" style="background:rgba(225,39,61,0.1);color:var(--accent-color);">
                                <i class="fa fa-heart"></i> {{ $agent->favs_assigned }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div style="padding:30px;text-align:center;color:#ccc;">No agents found</div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-7">
                <div class="activity-panel">
                    <div class="panel-header"><i class="fa fa-clock-o"></i> Recent Contact Messages</div>
                    @forelse($recentContacts as $rc)
                    <a href="{{ route('crm-contact-us.show', $rc->id) }}" class="activity-item" style="text-decoration:none;color:inherit;">
                        <div class="activity-avatar" style="background:linear-gradient(135deg, {{ $rc->status === 'Pending' ? '#f6b500,#d97706' : ($rc->status === 'InProgress' ? '#3b82f6,#2563eb' : '#10b981,#059669') }});">
                            {{ strtoupper(substr($rc->name, 0, 1)) }}
                        </div>
                        <div class="activity-info">
                            <div class="activity-name">{{ $rc->name }}</div>
                            <div class="activity-detail">{{ Str::limit($rc->subject, 40) }} &middot; {{ \Carbon\Carbon::parse($rc->created_at)->diffForHumans() }}</div>
                        </div>
                        @if($rc->agent_name)
                        <span class="agent-bar-stat" style="background:rgba(25,134,139,0.1);color:var(--primary-color);margin-right:6px;font-size:10px;">
                            <i class="fa fa-user-secret"></i> {{ Str::limit($rc->agent_name, 12) }}
                        </span>
                        @endif
                        <span class="activity-badge {{ $rc->status === 'Pending' ? 'badge-pending' : ($rc->status === 'InProgress' ? 'badge-inprogress' : 'badge-done') }}">
                            {{ $rc->status === 'InProgress' ? 'In Progress' : $rc->status }}
                        </span>
                    </a>
                    @empty
                    <div style="padding:30px;text-align:center;color:#ccc;">No contact messages yet</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var chartColors = {
        primary: '#19868b',
        primaryLight: 'rgba(25, 134, 139, 0.1)',
        accent: '#e1273d',
        accentLight: 'rgba(225, 39, 61, 0.1)',
        success: '#10b981',
        warning: '#f6b500',
        info: '#3b82f6',
        orange: '#ff6935',
        danger: '#ef4444'
    };

    // Activity Trend Chart
    new Chart(document.getElementById('trendChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthLabels) !!},
            datasets: [{
                label: 'Contact Messages',
                data: {!! json_encode($contactTrend) !!},
                borderColor: chartColors.primary,
                backgroundColor: chartColors.primaryLight,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: chartColors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }, {
                label: 'Favourite Sessions',
                data: {!! json_encode($favTrend) !!},
                borderColor: chartColors.accent,
                backgroundColor: chartColors.accentLight,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: chartColors.accent,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Contact Status Doughnut
    new Chart(document.getElementById('contactStatusChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Done'],
            datasets: [{
                data: [{{ $contactStats->pending }}, {{ $contactStats->in_progress }}, {{ $contactStats->done }}],
                backgroundColor: [chartColors.warning, chartColors.info, chartColors.success],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Favourites Type Doughnut
    new Chart(document.getElementById('favTypeChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Projects', 'Offers', 'Interior Designs'],
            datasets: [{
                data: [{{ $favStats->projects }}, {{ $favStats->offers }}, {{ $favStats->interiors }}],
                backgroundColor: [chartColors.accent, chartColors.success, chartColors.info],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Contacts by Service Bar Chart
    new Chart(document.getElementById('serviceChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($contactByService->pluck('service')->toArray()) !!},
            datasets: [{
                label: 'Messages',
                data: {!! json_encode($contactByService->pluck('count')->toArray()) !!},
                backgroundColor: [
                    chartColors.primary, chartColors.accent, chartColors.success,
                    chartColors.info, chartColors.warning, chartColors.orange,
                    chartColors.danger, '#8b5cf6'
                ],
                borderWidth: 0,
                borderRadius: 8,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0,
                        font: { size: 11 },
                        callback: function(value) {
                            var label = this.getLabelForValue(value);
                            return label.length > 15 ? label.substr(0, 15) + '...' : label;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
