@extends('admin::layouts.master')
@section('title', 'Website Analytics')

@section('css')
<style>
    :root {
        --primary: #19868b;
        --primary-dark: #146a6e;
        --secondary: #172e38;
        --accent: #e1273d;
        --success: #10b981;
        --warning: #f6b500;
        --danger: #ef4444;
        --info: #3b82f6;
        --light-bg: #f7f9fc;
        --card-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .analytics-wrapper { background: linear-gradient(135deg, #f7f9fc 0%, #eef2f7 100%); min-height: 100vh; padding: 20px; }

    .analytics-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 50%, var(--secondary) 100%);
        color: #fff; padding: 30px 35px; border-radius: 16px; margin-bottom: 25px;
        box-shadow: 0 10px 40px rgba(25,134,139,.3); position: relative; overflow: hidden;
    }
    .analytics-header::before {
        content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px;
        background:radial-gradient(circle,rgba(255,255,255,.1) 0%,transparent 70%); border-radius:50%;
    }
    .analytics-header h2 { font-size:1.8rem; font-weight:700; margin:0; }
    .analytics-header p { opacity:.85; margin:5px 0 0; }

    /* Real-time banner */
    .realtime-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color:#fff; border-radius:14px; padding:20px 28px; margin-bottom:25px;
        box-shadow: var(--card-shadow); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:15px;
    }
    .realtime-left { display:flex; align-items:center; gap:15px; }
    .realtime-dot { width:12px; height:12px; border-radius:50%; background:#10b981; animation: rtPulse 1.5s infinite; }
    @keyframes rtPulse { 0%,100%{ box-shadow:0 0 0 0 rgba(16,185,129,.6); } 50%{ box-shadow:0 0 0 10px rgba(16,185,129,0); } }
    .realtime-count { font-size:2.2rem; font-weight:800; }
    .realtime-label { font-size:.85rem; opacity:.7; }
    .realtime-pages { display:flex; flex-wrap:wrap; gap:8px; }
    .realtime-page-tag { background:rgba(255,255,255,.1); padding:5px 12px; border-radius:20px; font-size:.75rem; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

    /* Date filter */
    .date-filter { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:25px; }
    .date-filter .btn-range { padding:6px 16px; border-radius:20px; border:1px solid #d1d5db; background:#fff; color:#374151; font-size:.82rem; cursor:pointer; transition:.2s; }
    .date-filter .btn-range:hover, .date-filter .btn-range.active { background:var(--primary); color:#fff; border-color:var(--primary); }
    .date-filter input[type=date] { padding:6px 12px; border-radius:8px; border:1px solid #d1d5db; font-size:.82rem; }
    .date-filter .btn-apply { padding:6px 18px; border-radius:20px; background:var(--primary); color:#fff; border:none; font-size:.82rem; cursor:pointer; }
    .date-filter .btn-export { padding:6px 18px; border-radius:20px; background:var(--success); color:#fff; border:none; font-size:.82rem; cursor:pointer; text-decoration:none; }

    /* KPI cards */
    .kpi-card {
        background:#fff; border-radius:14px; padding:22px; box-shadow:var(--card-shadow);
        border-left:4px solid var(--primary); transition:.3s;
    }
    .kpi-card:hover { transform:translateY(-3px); box-shadow:0 8px 30px rgba(0,0,0,.12); }
    .kpi-card .kpi-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.2rem; color:#fff; }
    .kpi-card .kpi-value { font-size:1.8rem; font-weight:800; color:var(--secondary); margin:8px 0 2px; }
    .kpi-card .kpi-label { font-size:.82rem; color:#64748b; }
    .kpi-1 { border-left-color:var(--primary); } .kpi-1 .kpi-icon { background:var(--primary); }
    .kpi-2 { border-left-color:var(--info); } .kpi-2 .kpi-icon { background:var(--info); }
    .kpi-3 { border-left-color:var(--success); } .kpi-3 .kpi-icon { background:var(--success); }
    .kpi-4 { border-left-color:var(--warning); } .kpi-4 .kpi-icon { background:var(--warning); }
    .kpi-5 { border-left-color:var(--accent); } .kpi-5 .kpi-icon { background:var(--accent); }
    .kpi-6 { border-left-color:#8b5cf6; } .kpi-6 .kpi-icon { background:#8b5cf6; }

    /* Chart panel */
    .chart-panel {
        background:#fff; border-radius:14px; padding:22px; box-shadow:var(--card-shadow); margin-bottom:25px;
    }
    .chart-panel h5 { font-size:1rem; font-weight:700; color:var(--secondary); margin-bottom:15px; }
    .chart-panel canvas { max-height:320px; }

    /* Table panel */
    .table-panel { background:#fff; border-radius:14px; padding:22px; box-shadow:var(--card-shadow); margin-bottom:25px; }
    .table-panel h5 { font-size:1rem; font-weight:700; color:var(--secondary); margin-bottom:15px; }
    .table-panel table { width:100%; font-size:.83rem; }
    .table-panel th { background:#f8fafc; color:#64748b; font-weight:600; padding:10px 12px; border-bottom:2px solid #e2e8f0; }
    .table-panel td { padding:10px 12px; border-bottom:1px solid #f1f5f9; color:#334155; vertical-align:middle; }
    .table-panel tr:hover td { background:#f8fafc; }
    .url-cell { max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

    /* Journey expand */
    .journey-toggle { cursor:pointer; color:var(--primary); font-weight:600; }
    .journey-detail { display:none; background:#f8fafc; }
    .journey-detail td { padding:6px 12px 6px 40px; font-size:.78rem; color:#64748b; }
    .journey-step { display:inline-flex; align-items:center; gap:4px; }
    .journey-arrow { color:#cbd5e1; }

    /* Badge */
    .device-badge { padding:3px 10px; border-radius:12px; font-size:.72rem; font-weight:600; }
    .device-desktop { background:#dbeafe; color:#1d4ed8; }
    .device-mobile { background:#d1fae5; color:#065f46; }
    .device-tablet { background:#fef3c7; color:#92400e; }

    /* Cleanup Panel */
    .cleanup-toggle-btn {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color:#fff; border:none; padding:12px 24px; border-radius:12px; font-size:.9rem; font-weight:600;
        cursor:pointer; transition:.3s; display:inline-flex; align-items:center; gap:8px;
    }
    .cleanup-toggle-btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(239,68,68,.4); }
    .cleanup-toggle-btn i { font-size:1rem; }

    .cleanup-panel {
        background:#fff; border-radius:14px; box-shadow:var(--card-shadow); margin-bottom:25px;
        border:2px solid #fecaca; overflow:hidden;
    }
    .cleanup-panel-header {
        background:linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        padding:18px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;
        border-bottom:1px solid #fecaca;
    }
    .cleanup-panel-header h5 { margin:0; color:#991b1b; font-weight:700; font-size:1.05rem; }
    .cleanup-panel-body { padding:20px 24px; }

    .cleanup-section { margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid #f1f5f9; }
    .cleanup-section:last-child { margin-bottom:0; border-bottom:none; padding-bottom:0; }
    .cleanup-section h6 { font-weight:700; color:var(--secondary); margin-bottom:12px; font-size:.95rem; display:flex; align-items:center; gap:8px; }
    .cleanup-section h6 i { color:var(--primary); }

    .cleanup-table { width:100%; font-size:.82rem; border-collapse:collapse; }
    .cleanup-table th { background:#f8fafc; color:#64748b; font-weight:600; padding:8px 12px; border-bottom:2px solid #e2e8f0; text-align:left; }
    .cleanup-table td { padding:8px 12px; border-bottom:1px solid #f1f5f9; color:#334155; vertical-align:middle; }
    .cleanup-table tr:hover td { background:#f8fafc; }
    .cleanup-table .cb-cell { width:36px; text-align:center; }
    .cleanup-table input[type=checkbox] { width:16px; height:16px; cursor:pointer; accent-color:var(--accent); }

    .cleanup-btn { padding:8px 18px; border-radius:8px; border:none; font-size:.82rem; font-weight:600; cursor:pointer; transition:.2s; display:inline-flex; align-items:center; gap:6px; }
    .cleanup-btn:disabled { opacity:.5; cursor:not-allowed; }
    .cleanup-btn-danger { background:#ef4444; color:#fff; }
    .cleanup-btn-danger:hover:not(:disabled) { background:#dc2626; }
    .cleanup-btn-warning { background:#f59e0b; color:#fff; }
    .cleanup-btn-warning:hover:not(:disabled) { background:#d97706; }
    .cleanup-btn-secondary { background:#6b7280; color:#fff; }
    .cleanup-btn-secondary:hover:not(:disabled) { background:#4b5563; }

    .cleanup-actions { display:flex; align-items:center; gap:10px; margin-top:12px; flex-wrap:wrap; }

    .cleanup-stat-card {
        background:#f8fafc; border-radius:10px; padding:14px 18px; text-align:center;
        border:1px solid #e2e8f0; flex:1; min-width:120px;
    }
    .cleanup-stat-card .stat-val { font-size:1.4rem; font-weight:800; color:var(--secondary); }
    .cleanup-stat-card .stat-lbl { font-size:.75rem; color:#64748b; margin-top:2px; }

    .cleanup-alert {
        padding:10px 16px; border-radius:8px; font-size:.82rem; margin-bottom:12px;
        display:none; align-items:center; gap:8px;
    }
    .cleanup-alert-success { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
    .cleanup-alert-error { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }

    .cleanup-loading { display:none; text-align:center; padding:30px; color:#64748b; }
    .cleanup-loaded { display:none; }

    .select-all-wrap { display:flex; align-items:center; gap:6px; font-size:.82rem; color:#64748b; cursor:pointer; }
    .select-all-wrap input { cursor:pointer; }

    @media(max-width:768px) {
        .analytics-header { padding:20px; }
        .analytics-header h2 { font-size:1.3rem; }
        .realtime-count { font-size:1.6rem; }
    }
</style>
@endsection

@section('content')
<div class="analytics-wrapper">

    {{-- Header --}}
    <div class="analytics-header">
        <h2><i class="fa fa-line-chart"></i> Website Analytics</h2>
        <p>Track page views, visitor behavior, and user journeys across your website</p>
    </div>

    {{-- Real-time Banner --}}
    <div class="realtime-banner" id="realtimeBanner">
        <div class="realtime-left">
            <div class="realtime-dot"></div>
            <div>
                <div class="realtime-count" id="rtCount">--</div>
                <div class="realtime-label">Active visitors right now</div>
            </div>
        </div>
        <div class="realtime-pages" id="rtPages">
            <span class="realtime-page-tag"><i class="fa fa-spinner fa-spin"></i> Loading...</span>
        </div>
    </div>

    {{-- Date Filter --}}
    <div class="date-filter">
        <button class="btn-range {{ $range == '1' ? 'active' : '' }}" data-range="1">Today</button>
        <button class="btn-range {{ $range == '7' ? 'active' : '' }}" data-range="7">7 Days</button>
        <button class="btn-range {{ $range == '30' ? 'active' : '' }}" data-range="30">30 Days</button>
        <button class="btn-range {{ $range == '90' ? 'active' : '' }}" data-range="90">90 Days</button>
        <span style="color:#94a3b8;">|</span>
        <input type="date" id="dateFrom" value="{{ $startDate->toDateString() }}">
        <span style="color:#94a3b8;">to</span>
        <input type="date" id="dateTo" value="{{ $endDate->toDateString() }}">
        <button class="btn-apply" id="btnApply"><i class="fa fa-filter"></i> Apply</button>
        <a href="{{ route('admin.analytics.export', ['from' => $startDate->toDateString(), 'to' => $endDate->toDateString()]) }}" class="btn-export"><i class="fa fa-download"></i> Export CSV</a>
    </div>

    {{-- KPI Cards --}}
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="kpi-card kpi-1">
                <div class="kpi-icon"><i class="fa fa-eye"></i></div>
                <div class="kpi-value">{{ number_format($kpis['total_views']) }}</div>
                <div class="kpi-label">Total Page Views</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="kpi-card kpi-2">
                <div class="kpi-icon"><i class="fa fa-users"></i></div>
                <div class="kpi-value">{{ number_format($kpis['unique_visitors']) }}</div>
                <div class="kpi-label">Unique Visitors</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="kpi-card kpi-3">
                <div class="kpi-icon"><i class="fa fa-signal"></i></div>
                <div class="kpi-value">{{ number_format($kpis['total_sessions']) }}</div>
                <div class="kpi-label">Sessions</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="kpi-card kpi-4">
                <div class="kpi-icon"><i class="fa fa-clock-o"></i></div>
                <div class="kpi-value">{{ gmdate('i:s', (int)$kpis['avg_duration']) }}</div>
                <div class="kpi-label">Avg. Duration</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="kpi-card kpi-5">
                <div class="kpi-icon"><i class="fa fa-sign-out"></i></div>
                <div class="kpi-value">{{ $kpis['bounce_rate'] }}%</div>
                <div class="kpi-label">Bounce Rate</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="kpi-card kpi-6">
                <div class="kpi-icon"><i class="fa fa-files-o"></i></div>
                <div class="kpi-value">{{ $kpis['pages_per_session'] }}</div>
                <div class="kpi-label">Pages / Session</div>
            </div>
        </div>
    </div>

    {{-- Row: Daily Chart + Device --}}
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="chart-panel">
                <h5><i class="fa fa-area-chart"></i> Daily Views &amp; Visitors</h5>
                <canvas id="dailyChart"></canvas>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="chart-panel">
                <h5><i class="fa fa-desktop"></i> Device Types</h5>
                <canvas id="deviceChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Row: Countries + Emirates --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="chart-panel">
                <h5><i class="fa fa-globe"></i> Top Countries</h5>
                @if(count($countryData) > 0)
                <canvas id="countryChart"></canvas>
                @else
                <p class="text-muted text-center py-4">No location data yet. Data populates as visitors arrive.</p>
                @endif
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-panel">
                <h5><i class="fa fa-map-marker"></i> UAE Emirates</h5>
                @if(count($emirateData) > 0)
                <canvas id="emirateChart"></canvas>
                @else
                <p class="text-muted text-center py-4">No UAE visitor data yet.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Row: Top Pages + Referrers --}}
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="table-panel">
                <h5><i class="fa fa-file-text-o"></i> Top Pages</h5>
                <div style="overflow-x:auto;">
                <table>
                    <thead><tr><th>#</th><th>Page</th><th>Views</th><th>Unique</th></tr></thead>
                    <tbody>
                    @forelse($topPages as $i => $page)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="url-cell" title="{{ $page->url }}">{{ $page->page_title ?: $page->url }}</td>
                        <td><strong>{{ number_format($page->views) }}</strong></td>
                        <td>{{ number_format($page->unique_views) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No data yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="table-panel">
                <h5><i class="fa fa-external-link"></i> Top Referrers</h5>
                <table>
                    <thead><tr><th>#</th><th>Source</th><th>Visits</th></tr></thead>
                    <tbody>
                    @forelse($topReferrers as $i => $ref)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $ref->domain }}</td>
                        <td><strong>{{ number_format($ref->visits) }}</strong></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">No external referrers yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Row: Browser + OS --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="chart-panel">
                <h5><i class="fa fa-chrome"></i> Browsers</h5>
                @if(count($browserData) > 0)
                <canvas id="browserChart"></canvas>
                @else
                <p class="text-muted text-center py-4">No data yet</p>
                @endif
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-panel">
                <h5><i class="fa fa-windows"></i> Operating Systems</h5>
                @if(count($osData) > 0)
                <canvas id="osChart"></canvas>
                @else
                <p class="text-muted text-center py-4">No data yet</p>
                @endif
            </div>
        </div>
    </div>

    {{-- User Journeys --}}
    <div class="table-panel">
        <h5><i class="fa fa-road"></i> Recent User Journeys</h5>
        <div style="overflow-x:auto;">
        <table>
            <thead><tr><th>Visitor</th><th>Device</th><th>Entry</th><th>Exit</th><th>Pages</th><th>Duration</th><th>Bounce</th><th>Started</th></tr></thead>
            <tbody>
            @forelse($recentSessions as $sess)
            <tr class="journey-toggle" data-id="{{ $sess->id }}">
                <td>
                    <span title="{{ $sess->visitor->ip_address ?? '' }}">
                        {{ Str::limit($sess->visitor_id, 8, '...') }}
                        @if($sess->visitor && $sess->visitor->country)
                        <small class="text-muted">({{ $sess->visitor->country }})</small>
                        @endif
                    </span>
                </td>
                <td>
                    @php $dt = $sess->visitor->device_type ?? 'desktop'; @endphp
                    <span class="device-badge device-{{ $dt }}">{{ ucfirst($dt) }}</span>
                </td>
                <td class="url-cell" title="{{ $sess->entry_page }}">{{ Str::limit(parse_url($sess->entry_page ?? '', PHP_URL_PATH) ?: '/', 40) }}</td>
                <td class="url-cell" title="{{ $sess->exit_page }}">{{ Str::limit(parse_url($sess->exit_page ?? '', PHP_URL_PATH) ?: '/', 40) }}</td>
                <td><strong>{{ $sess->page_count }}</strong></td>
                <td>{{ gmdate('i:s', $sess->duration_seconds) }}</td>
                <td>{!! $sess->is_bounce ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>' !!}</td>
                <td>{{ $sess->started_at ? $sess->started_at->format('M d, H:i') : '-' }}</td>
            </tr>
            <tr class="journey-detail" id="journey-{{ $sess->id }}">
                <td colspan="8">
                    @foreach($sess->pageViews as $k => $pv)
                    <span class="journey-step">
                        @if($k > 0)<span class="journey-arrow"><i class="fa fa-long-arrow-right"></i></span>@endif
                        <span title="{{ $pv->url }}">{{ Str::limit(parse_url($pv->url, PHP_URL_PATH) ?: '/', 30) }}</span>
                        @if($pv->time_on_page)<small class="text-muted">({{ $pv->time_on_page }}s)</small>@endif
                    </span>
                    @endforeach
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted">No sessions recorded yet</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>

    {{-- Data Cleanup --}}
    <div style="text-align:right; margin-bottom:15px;">
        <button class="cleanup-toggle-btn" id="btnToggleCleanup">
            <i class="fa fa-trash-o"></i> Data Cleanup Tools
        </button>
    </div>

    <div class="cleanup-panel" id="cleanupPanel" style="display:none;">
        <div class="cleanup-panel-header">
            <h5><i class="fa fa-trash-o"></i> Analytics Data Cleanup</h5>
            <span style="font-size:.8rem; color:#991b1b;">Deleting data is permanent and cannot be undone</span>
        </div>
        <div class="cleanup-panel-body">

            <div class="cleanup-alert cleanup-alert-success" id="cleanupSuccess"><i class="fa fa-check-circle"></i> <span></span></div>
            <div class="cleanup-alert cleanup-alert-error" id="cleanupError"><i class="fa fa-exclamation-circle"></i> <span></span></div>

            <div class="cleanup-loading" id="cleanupLoading">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
                <p style="margin-top:10px;">Loading analytics data...</p>
            </div>

            <div class="cleanup-loaded" id="cleanupLoaded">

                {{-- Database Totals --}}
                <div class="cleanup-section">
                    <h6><i class="fa fa-database"></i> Database Totals</h6>
                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        <div class="cleanup-stat-card"><div class="stat-val" id="totalVisitors">-</div><div class="stat-lbl">Visitors</div></div>
                        <div class="cleanup-stat-card"><div class="stat-val" id="totalSessions">-</div><div class="stat-lbl">Sessions</div></div>
                        <div class="cleanup-stat-card"><div class="stat-val" id="totalPageViews">-</div><div class="stat-lbl">Page Views</div></div>
                        <div class="cleanup-stat-card"><div class="stat-val" id="totalOrphanedSessions">-</div><div class="stat-lbl">Orphaned Sessions</div></div>
                        <div class="cleanup-stat-card"><div class="stat-val" id="totalOrphanedVisitors">-</div><div class="stat-lbl">Orphaned Visitors</div></div>
                    </div>
                    <div class="cleanup-actions" style="margin-top:14px;">
                        <button class="cleanup-btn cleanup-btn-warning" id="btnCleanOrphaned"><i class="fa fa-unlink"></i> Clean Orphaned Records</button>
                    </div>
                </div>

                {{-- Clean by Country --}}
                <div class="cleanup-section">
                    <h6><i class="fa fa-globe"></i> Clean by Country</h6>
                    <p style="font-size:.8rem; color:#64748b; margin-bottom:10px;">Select countries to remove all their visitors, sessions, and page views from the database.</p>
                    <div style="overflow-x:auto; max-height:350px; overflow-y:auto;">
                        <table class="cleanup-table">
                            <thead>
                                <tr>
                                    <th class="cb-cell"><label class="select-all-wrap"><input type="checkbox" id="selectAllCountries"> All</label></th>
                                    <th>Country</th>
                                    <th>Code</th>
                                    <th>Visitors</th>
                                    <th>Total Hits</th>
                                </tr>
                            </thead>
                            <tbody id="countryTableBody">
                                <tr><td colspan="5" class="text-center text-muted">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cleanup-actions">
                        <button class="cleanup-btn cleanup-btn-danger" id="btnDeleteCountries" disabled><i class="fa fa-trash"></i> Delete Selected Countries</button>
                        <button class="cleanup-btn cleanup-btn-secondary" id="btnDeleteNullCountry" style="display:none;"><i class="fa fa-question-circle"></i> Delete Unknown Location (<span id="nullCountryCount">0</span>)</button>
                        <span style="font-size:.78rem; color:#94a3b8;" id="countrySelectionInfo">0 selected</span>
                    </div>
                </div>

                {{-- Clean Internal URLs --}}
                <div class="cleanup-section">
                    <h6><i class="fa fa-link"></i> Internal / Backend Page Views</h6>
                    <p style="font-size:.8rem; color:#64748b; margin-bottom:10px;">Page views for login, admin, search API, and other internal URLs that should not be tracked.</p>
                    <div style="overflow-x:auto; max-height:300px; overflow-y:auto;">
                        <table class="cleanup-table">
                            <thead>
                                <tr>
                                    <th class="cb-cell"><label class="select-all-wrap"><input type="checkbox" id="selectAllUrls"> All</label></th>
                                    <th>URL</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody id="urlTableBody">
                                <tr><td colspan="3" class="text-center text-muted">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cleanup-actions">
                        <button class="cleanup-btn cleanup-btn-danger" id="btnDeleteUrls" disabled><i class="fa fa-trash"></i> Delete Selected URLs</button>
                        <button class="cleanup-btn cleanup-btn-warning" id="btnDeleteAllInternal"><i class="fa fa-broom"></i> Delete All Internal Page Views</button>
                        <span style="font-size:.78rem; color:#94a3b8;" id="urlSelectionInfo">0 selected</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    if (typeof Chart === 'undefined') return;

    var colors = {
        primary: '#19868b', info: '#3b82f6', success: '#10b981',
        warning: '#f6b500', danger: '#ef4444', purple: '#8b5cf6',
        orange: '#ff6935', pink: '#ec4899', teal: '#14b8a6', indigo: '#6366f1'
    };
    var palette = [colors.primary, colors.info, colors.success, colors.warning, colors.danger, colors.purple, colors.orange, colors.pink, colors.teal, colors.indigo];

    // Daily Views & Visitors
    var dailyCtx = document.getElementById('dailyChart');
    if (dailyCtx) {
        new Chart(dailyCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyChart['labels']) !!},
                datasets: [
                    { label: 'Page Views', data: {!! json_encode($dailyChart['views']) !!}, borderColor: colors.primary, backgroundColor: 'rgba(25,134,139,.1)', fill: true, tension: .4, pointRadius: 2 },
                    { label: 'Unique Visitors', data: {!! json_encode($dailyChart['visitors']) !!}, borderColor: colors.info, backgroundColor: 'rgba(59,130,246,.1)', fill: true, tension: .4, pointRadius: 2 }
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    }

    // Device doughnut
    var deviceCtx = document.getElementById('deviceChart');
    if (deviceCtx) {
        var dd = @json($deviceData);
        new Chart(deviceCtx.getContext('2d'), {
            type: 'doughnut',
            data: { labels: Object.keys(dd).map(function(k){ return k.charAt(0).toUpperCase()+k.slice(1); }), datasets: [{ data: Object.values(dd), backgroundColor: [colors.info, colors.success, colors.warning] }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    }

    // Country doughnut
    @if(count($countryData) > 0)
    var cCtx = document.getElementById('countryChart');
    if (cCtx) {
        var cd = @json($countryData);
        new Chart(cCtx.getContext('2d'), {
            type: 'doughnut',
            data: { labels: Object.keys(cd), datasets: [{ data: Object.values(cd), backgroundColor: palette }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    }
    @endif

    // Emirate bar
    @if(count($emirateData) > 0)
    var eCtx = document.getElementById('emirateChart');
    if (eCtx) {
        var ed = @json($emirateData);
        new Chart(eCtx.getContext('2d'), {
            type: 'bar',
            data: { labels: Object.keys(ed), datasets: [{ label: 'Visitors', data: Object.values(ed), backgroundColor: colors.primary }] },
            options: { responsive: true, indexAxis: 'y', plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    }
    @endif

    // Browser doughnut
    @if(count($browserData) > 0)
    var bCtx = document.getElementById('browserChart');
    if (bCtx) {
        var bd = @json($browserData);
        new Chart(bCtx.getContext('2d'), {
            type: 'doughnut',
            data: { labels: Object.keys(bd), datasets: [{ data: Object.values(bd), backgroundColor: palette }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    }
    @endif

    // OS doughnut
    @if(count($osData) > 0)
    var oCtx = document.getElementById('osChart');
    if (oCtx) {
        var od = @json($osData);
        new Chart(oCtx.getContext('2d'), {
            type: 'doughnut',
            data: { labels: Object.keys(od), datasets: [{ data: Object.values(od), backgroundColor: palette }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    }
    @endif

    // Date range buttons
    $('.btn-range').on('click', function() {
        var r = $(this).data('range');
        window.location.href = '{{ route("admin.analytics.index") }}?range=' + r;
    });

    $('#btnApply').on('click', function() {
        var f = $('#dateFrom').val(), t = $('#dateTo').val();
        if (f && t) window.location.href = '{{ route("admin.analytics.index") }}?from=' + f + '&to=' + t;
    });

    // Journey toggle
    $('.journey-toggle').on('click', function() {
        var id = $(this).data('id');
        $('#journey-' + id).slideToggle(200);
    });

    // Real-time polling
    function fetchRealtime() {
        $.getJSON('{{ route("admin.analytics.realtime") }}', function(data) {
            $('#rtCount').text(data.active_visitors || 0);
            var html = '';
            if (data.active_pages && data.active_pages.length) {
                data.active_pages.slice(0, 5).forEach(function(p) {
                    html += '<span class="realtime-page-tag" title="' + p.url + '">' + (p.title || '/') + ' <small>(' + p.views + ')</small></span>';
                });
            } else {
                html = '<span class="realtime-page-tag">No active pages</span>';
            }
            $('#rtPages').html(html);
        });
    }
    fetchRealtime();
    setInterval(fetchRealtime, 10000);

    // ─── Cleanup Tools ──────────────────────────────────────────────

    var cleanupLoaded = false;

    $('#btnToggleCleanup').on('click', function() {
        var panel = $('#cleanupPanel');
        panel.slideToggle(300);
        if (!cleanupLoaded) {
            loadCleanupData();
            cleanupLoaded = true;
        }
    });

    function showCleanupMsg(type, msg) {
        var el = type === 'success' ? $('#cleanupSuccess') : $('#cleanupError');
        el.find('span').text(msg);
        el.css('display', 'flex').delay(5000).fadeOut(300);
    }

    function fmt(n) { return n.toLocaleString(); }

    function loadCleanupData() {
        $('#cleanupLoading').show();
        $('#cleanupLoaded').hide();

        $.getJSON('{{ route("admin.analytics.cleanup-data") }}', function(data) {
            $('#cleanupLoading').hide();
            $('#cleanupLoaded').show();

            $('#totalVisitors').text(fmt(data.totals.visitors));
            $('#totalSessions').text(fmt(data.totals.sessions));
            $('#totalPageViews').text(fmt(data.totals.page_views));
            $('#totalOrphanedSessions').text(fmt(data.orphaned_sessions));
            $('#totalOrphanedVisitors').text(fmt(data.orphaned_visitors));

            if (data.orphaned_sessions === 0 && data.orphaned_visitors === 0) {
                $('#btnCleanOrphaned').prop('disabled', true).html('<i class="fa fa-check"></i> No orphans');
            }

            // Countries table
            var cHtml = '';
            if (data.countries.length === 0) {
                cHtml = '<tr><td colspan="5" class="text-center text-muted">No country data found</td></tr>';
            } else {
                data.countries.forEach(function(c) {
                    cHtml += '<tr>' +
                        '<td class="cb-cell"><input type="checkbox" class="country-cb" value="' + (c.country || '') + '"></td>' +
                        '<td>' + (c.country || '<em>Unknown</em>') + '</td>' +
                        '<td>' + (c.country_code || '-') + '</td>' +
                        '<td><strong>' + fmt(c.visitors_count) + '</strong></td>' +
                        '<td>' + fmt(c.total_hits) + '</td>' +
                        '</tr>';
                });
            }
            $('#countryTableBody').html(cHtml);

            // Null country
            if (data.null_country_visitors > 0) {
                $('#btnDeleteNullCountry').show();
                $('#nullCountryCount').text(fmt(data.null_country_visitors));
            }

            // URL table
            var uHtml = '';
            if (data.internal_urls.length === 0) {
                uHtml = '<tr><td colspan="3" class="text-center text-muted">No internal URLs found</td></tr>';
                $('#btnDeleteAllInternal').prop('disabled', true);
            } else {
                data.internal_urls.forEach(function(u) {
                    var shortUrl = u.url.length > 80 ? u.url.substring(0, 80) + '...' : u.url;
                    uHtml += '<tr>' +
                        '<td class="cb-cell"><input type="checkbox" class="url-cb" value="' + u.url.replace(/"/g, '&quot;') + '"></td>' +
                        '<td class="url-cell" title="' + u.url.replace(/"/g, '&quot;') + '">' + shortUrl + '</td>' +
                        '<td><strong>' + fmt(u.views_count) + '</strong></td>' +
                        '</tr>';
                });
            }
            $('#urlTableBody').html(uHtml);
            updateSelectionCounts();
        }).fail(function() {
            $('#cleanupLoading').hide();
            showCleanupMsg('error', 'Failed to load cleanup data.');
        });
    }

    function updateSelectionCounts() {
        var cc = $('.country-cb:checked').length;
        $('#countrySelectionInfo').text(cc + ' selected');
        $('#btnDeleteCountries').prop('disabled', cc === 0);

        var uc = $('.url-cb:checked').length;
        $('#urlSelectionInfo').text(uc + ' selected');
        $('#btnDeleteUrls').prop('disabled', uc === 0);
    }

    $(document).on('change', '.country-cb, .url-cb', updateSelectionCounts);

    $('#selectAllCountries').on('change', function() {
        $('.country-cb').prop('checked', this.checked);
        updateSelectionCounts();
    });
    $('#selectAllUrls').on('change', function() {
        $('.url-cb').prop('checked', this.checked);
        updateSelectionCounts();
    });

    function cleanupAjax(url, data, btn) {
        var origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(res) {
                showCleanupMsg('success', res.message);
                cleanupLoaded = false;
                loadCleanupData();
            },
            error: function(xhr) {
                var msg = xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred.';
                showCleanupMsg('error', msg);
                btn.prop('disabled', false).html(origHtml);
            }
        });
    }

    $('#btnDeleteCountries').on('click', function() {
        var selected = [];
        $('.country-cb:checked').each(function() { selected.push($(this).val()); });
        if (selected.length === 0) return;
        if (!confirm('Delete ALL data for ' + selected.length + ' country(ies)?\n\n' + selected.join(', ') + '\n\nThis removes their visitors, sessions, and page views permanently.')) return;
        cleanupAjax('{{ route("admin.analytics.destroy-by-country") }}', { countries: selected }, $(this));
    });

    $('#btnDeleteNullCountry').on('click', function() {
        if (!confirm('Delete ALL visitors with unknown location and their sessions/page views?')) return;
        cleanupAjax('{{ route("admin.analytics.destroy-null-country") }}', {}, $(this));
    });

    $('#btnDeleteUrls').on('click', function() {
        var selected = [];
        $('.url-cb:checked').each(function() { selected.push($(this).val()); });
        if (selected.length === 0) return;
        if (!confirm('Delete ' + selected.length + ' URL(s) page views?')) return;
        cleanupAjax('{{ route("admin.analytics.destroy-by-urls") }}', { urls: selected }, $(this));
    });

    $('#btnDeleteAllInternal').on('click', function() {
        if (!confirm('Delete ALL internal/backend page views at once?\nThis includes login, admin, search API, and other internal URLs.')) return;
        cleanupAjax('{{ route("admin.analytics.destroy-by-urls") }}', { clean_internal: true }, $(this));
    });

    $('#btnCleanOrphaned').on('click', function() {
        if (!confirm('Delete all orphaned sessions and visitors that have no remaining page views?')) return;
        cleanupAjax('{{ route("admin.analytics.destroy-orphaned") }}', {}, $(this));
    });
});
</script>
@endsection
