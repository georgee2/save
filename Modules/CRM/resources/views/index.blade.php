@extends('admin::layouts.master')
@section('title', 'CRM Dashboard')

@section('css')
<style>
    :root {
        --crm-primary: #19868b;
        --crm-primary-dark: #0d6b6f;
        --crm-secondary: #172e38;
        --crm-accent: #e1273d;
        --crm-success: #10b981;
        --crm-warning: #f6b500;
        --crm-info: #3b82f6;
        --crm-orange: #ff6935;
        --crm-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .crm-header {
        background: linear-gradient(135deg, var(--crm-primary) 0%, var(--crm-primary-dark) 50%, var(--crm-secondary) 100%);
        color: #fff;
        padding: 30px 35px;
        border-radius: 16px;
        margin-bottom: 28px;
        box-shadow: 0 10px 40px rgba(25, 134, 139, 0.3);
    }
    .crm-header h2 { margin: 0; font-weight: 700; font-size: 28px; display: flex; align-items: center; gap: 14px; }
    .crm-header h2 i { background: var(--crm-accent); padding: 12px; border-radius: 12px; font-size: 22px; }
    .crm-header p { margin: 10px 0 0; opacity: 0.9; font-size: 15px; }
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .kpi-card {
        background: #fff;
        border-radius: 14px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--crm-shadow);
        transition: all 0.3s ease;
        border-left: 4px solid var(--crm-primary);
    }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
    .kpi-card.primary { border-left-color: var(--crm-primary); }
    .kpi-card.success { border-left-color: var(--crm-success); }
    .kpi-card.warning { border-left-color: var(--crm-warning); }
    .kpi-card.info { border-left-color: var(--crm-info); }
    .kpi-card.accent { border-left-color: var(--crm-accent); }
    .kpi-card.orange { border-left-color: var(--crm-orange); }
    .kpi-card .kpi-icon {
        width: 52px; height: 52px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; color: #fff; flex-shrink: 0;
    }
    .kpi-card.primary .kpi-icon { background: linear-gradient(135deg, var(--crm-primary), var(--crm-primary-dark)); }
    .kpi-card.success .kpi-icon { background: linear-gradient(135deg, var(--crm-success), #059669); }
    .kpi-card.warning .kpi-icon { background: linear-gradient(135deg, var(--crm-warning), #d97706); }
    .kpi-card.info .kpi-icon { background: linear-gradient(135deg, var(--crm-info), #2563eb); }
    .kpi-card.accent .kpi-icon { background: linear-gradient(135deg, var(--crm-accent), #c41f33); }
    .kpi-card.orange .kpi-icon { background: linear-gradient(135deg, var(--crm-orange), #e55a2b); }
    .kpi-card .kpi-value { font-size: 26px; font-weight: 800; color: var(--crm-secondary); line-height: 1; }
    .kpi-card .kpi-label { font-size: 13px; color: #6b7280; font-weight: 500; margin-top: 5px; }
    .crm-panel {
        background: #fff; border-radius: 16px; padding: 26px;
        margin-bottom: 26px; box-shadow: var(--crm-shadow);
    }
    .crm-panel .panel-title {
        font-size: 18px; font-weight: 700; color: var(--crm-secondary);
        margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f3f4f6;
        display: flex; align-items: center; justify-content: space-between;
    }
    .crm-panel .panel-title span { display: flex; align-items: center; gap: 10px; }
    .crm-panel .panel-title i { color: var(--crm-primary); }
    .crm-table { width: 100%; }
    .crm-table th { font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; padding: 10px; border-bottom: 2px solid #f3f4f6; text-align: left; }
    .crm-table td { padding: 12px 10px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: var(--crm-secondary); }
    .crm-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .crm-badge.activated { background: rgba(16,185,129,0.12); color: var(--crm-success); }
    .crm-badge.pending { background: rgba(246,181,0,0.15); color: #b45309; }
    canvas { max-height: 320px; }
    @media (max-width: 1200px) { .kpi-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .kpi-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="crm-header" style="margin-top:70px">
            <h2><i class="fa fa-exchange"></i> CRM Dashboard</h2>
            <p>Welcome back, {{ auth()->user()->name }}! Overview of registered customers and CRM activity.</p>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card primary">
                <div class="kpi-icon"><i class="fa fa-users"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['total_customers']) }}</div>
                    <div class="kpi-label">Total Customers</div>
                </div>
            </div>
            <div class="kpi-card success">
                <div class="kpi-icon"><i class="fa fa-check-circle"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['activated']) }}</div>
                    <div class="kpi-label">Activated Accounts</div>
                </div>
            </div>
            <div class="kpi-card warning">
                <div class="kpi-icon"><i class="fa fa-hourglass-half"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['pending']) }}</div>
                    <div class="kpi-label">Pending Activation</div>
                </div>
            </div>
            <div class="kpi-card accent">
                <div class="kpi-icon"><i class="fa fa-user-times"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['unassigned']) }}</div>
                    <div class="kpi-label">Unassigned Customers</div>
                </div>
            </div>
            <div class="kpi-card info">
                <div class="kpi-icon"><i class="fa fa-calendar"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['new_this_week']) }}</div>
                    <div class="kpi-label">New This Week</div>
                </div>
            </div>
            <div class="kpi-card info">
                <div class="kpi-icon"><i class="fa fa-calendar-plus-o"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['new_this_month']) }}</div>
                    <div class="kpi-label">New This Month</div>
                </div>
            </div>
            <div class="kpi-card orange">
                <div class="kpi-icon"><i class="fa fa-user-secret"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['active_agents']) }}</div>
                    <div class="kpi-label">Active Agents</div>
                </div>
            </div>
            <div class="kpi-card primary">
                <div class="kpi-icon"><i class="fa fa-heart"></i></div>
                <div>
                    <div class="kpi-value">{{ number_format($kpis['favourites']) }}</div>
                    <div class="kpi-label">Favourite Sessions</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="crm-panel">
                    <div class="panel-title"><span><i class="fa fa-line-chart"></i> Customer Registrations</span><small class="text-muted" style="font-weight:400;">Last 12 months</small></div>
                    <canvas id="registrationsChart"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="crm-panel" style="height: calc(100% - 26px);">
                    <div class="panel-title"><span><i class="fa fa-pie-chart"></i> Activation Status</span></div>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="crm-panel">
            <div class="panel-title">
                <span><i class="fa fa-clock-o"></i> Recent Customers</span>
                <a href="{{ route('crm-customers.index') }}" style="font-size:13px;color:var(--crm-primary);text-decoration:none;font-weight:600;">
                    View All <i class="fa fa-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="crm-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Agent</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCustomers as $customer)
                        <tr>
                            <td>{{ $customer->name ?: '---' }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?: '---' }}</td>
                            <td>{{ $customer->assignedAgent->full_name_en ?? '---' }}</td>
                            <td>
                                @if($customer->password_set_at)
                                    <span class="crm-badge activated">Activated</span>
                                @else
                                    <span class="crm-badge pending">Pending</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('crm-customers.show', ['id' => $customer->id]) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fa fa-users fa-2x mb-2"></i>
                                <p class="mb-0">No customers registered yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        if (typeof Chart === 'undefined') { return; }

        var regCtx = document.getElementById('registrationsChart');
        if (regCtx) {
            new Chart(regCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($chart['months']) !!},
                    datasets: [{
                        label: 'New Customers',
                        data: {!! json_encode($chart['registrations']) !!},
                        borderColor: '#19868b',
                        backgroundColor: 'rgba(25, 134, 139, 0.12)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#19868b',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.04)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        var statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Activated', 'Pending'],
                    datasets: [{
                        data: [{{ $kpis['activated'] }}, {{ $kpis['pending'] }}],
                        backgroundColor: ['#10b981', '#f6b500'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '62%',
                    plugins: { legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true } } }
                }
            });
        }
    });
</script>
@endsection
