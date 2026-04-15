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

    /* Country multi-select dropdown */
    .country-dropdown { position:relative; display:inline-block; }
    .country-dropdown-btn {
        padding:6px 14px; border-radius:20px; border:1px solid #d1d5db; background:#fff; color:#374151;
        font-size:.82rem; cursor:pointer; transition:.2s; display:inline-flex; align-items:center; gap:6px; white-space:nowrap;
    }
    .country-dropdown-btn:hover { border-color:var(--primary); }
    .country-dropdown-btn.has-selection { background:var(--primary); color:#fff; border-color:var(--primary); }
    .country-dropdown-btn .caret { font-size:.6rem; transition:transform .2s; }
    .country-dropdown-btn.open .caret { transform:rotate(180deg); }
    .country-dropdown-menu {
        display:none; position:absolute; top:calc(100% + 6px); left:0; z-index:100;
        background:#fff; border-radius:12px; box-shadow:0 10px 40px rgba(0,0,0,.15); border:1px solid #e2e8f0;
        min-width:260px; max-height:350px; overflow:hidden;
    }
    .country-dropdown-menu.show { display:block; }
    .country-dropdown-search { padding:10px 12px; border-bottom:1px solid #e2e8f0; }
    .country-dropdown-search input { width:100%; padding:6px 10px; border-radius:6px; border:1px solid #d1d5db; font-size:.8rem; outline:none; }
    .country-dropdown-search input:focus { border-color:var(--primary); }
    .country-dropdown-list { max-height:240px; overflow-y:auto; padding:6px 0; }
    .country-dropdown-item { display:flex; align-items:center; gap:8px; padding:6px 14px; font-size:.82rem; cursor:pointer; transition:.1s; }
    .country-dropdown-item:hover { background:#f1f5f9; }
    .country-dropdown-item input[type=checkbox] { width:15px; height:15px; accent-color:var(--primary); cursor:pointer; flex-shrink:0; }
    .country-dropdown-item label { cursor:pointer; flex:1; color:#334155; }
    .country-dropdown-footer { padding:8px 12px; border-top:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; }
    .country-dropdown-footer button { padding:4px 12px; border-radius:6px; font-size:.78rem; cursor:pointer; border:none; }
    .country-dropdown-footer .btn-cd-clear { background:#f1f5f9; color:#64748b; }
    .country-dropdown-footer .btn-cd-clear:hover { background:#e2e8f0; }
    .country-dropdown-footer .btn-cd-apply { background:var(--primary); color:#fff; }
    .country-dropdown-footer .btn-cd-apply:hover { background:var(--primary-dark); }
    .country-active-tags { display:inline-flex; gap:5px; flex-wrap:wrap; align-items:center; }
    .country-tag { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:14px; background:rgba(25,134,139,.1); color:var(--primary); font-size:.75rem; font-weight:600; }
    .country-tag .remove-tag { cursor:pointer; font-size:.85rem; color:var(--accent); line-height:1; }
    .country-tag .remove-tag:hover { color:#b91c1c; }

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

    /* New vs Returning */
    .nvr-summary { display:flex; gap:15px; align-items:center; flex-wrap:wrap; margin-top:12px; }
    .nvr-stat { text-align:center; flex:1; min-width:90px; }
    .nvr-stat .nvr-val { font-size:1.6rem; font-weight:800; }
    .nvr-stat .nvr-lbl { font-size:.78rem; color:#64748b; }
    .nvr-new { color:var(--success); }
    .nvr-ret { color:var(--info); }

    /* Entry/Exit pages */
    .entry-exit-table { width:100%; font-size:.83rem; }
    .entry-exit-table th { background:#f8fafc; color:#64748b; font-weight:600; padding:10px 12px; border-bottom:2px solid #e2e8f0; }
    .entry-exit-table td { padding:10px 12px; border-bottom:1px solid #f1f5f9; color:#334155; }
    .entry-exit-table tr:hover td { background:#f8fafc; }

    /* Peak Hours Heatmap */
    .heatmap-grid { display:grid; grid-template-columns:60px repeat(24, 1fr); gap:2px; font-size:.7rem; }
    .heatmap-cell { aspect-ratio:1; display:flex; align-items:center; justify-content:center; border-radius:4px; color:#fff; font-weight:600; min-width:0; transition:transform .15s; cursor:default; }
    .heatmap-cell:hover { transform:scale(1.2); z-index:2; }
    .heatmap-header { display:flex; align-items:center; justify-content:center; font-weight:700; color:#64748b; font-size:.7rem; }
    .heatmap-row-label { display:flex; align-items:center; font-weight:600; color:#64748b; font-size:.72rem; padding-right:4px; }
    .heatmap-legend { display:flex; align-items:center; gap:6px; margin-top:10px; font-size:.72rem; color:#64748b; }
    .heatmap-legend-bar { display:flex; height:12px; border-radius:3px; overflow:hidden; }
    .heatmap-legend-bar span { width:24px; }

    /* Journey section redesign */
    .journey-stats-row { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:20px; }
    .journey-stat-card { background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius:12px; padding:16px 20px; flex:1; min-width:140px; border:1px solid #e2e8f0; text-align:center; }
    .journey-stat-card .js-val { font-size:1.3rem; font-weight:800; color:var(--secondary); }
    .journey-stat-card .js-lbl { font-size:.75rem; color:#64748b; margin-top:2px; }

    .journey-filters { display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-bottom:20px; padding:14px 18px; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0; }
    .journey-filters select, .journey-filters input[type=text] { padding:6px 12px; border-radius:8px; border:1px solid #d1d5db; font-size:.82rem; min-width:120px; }
    .journey-filters .btn-filter { padding:6px 16px; border-radius:20px; background:var(--primary); color:#fff; border:none; font-size:.82rem; cursor:pointer; }
    .journey-filters .btn-reset { padding:6px 16px; border-radius:20px; background:#6b7280; color:#fff; border:none; font-size:.82rem; cursor:pointer; }

    .journey-timeline { border-left:3px solid var(--primary); margin-left:16px; padding-left:0; }
    .timeline-step { position:relative; padding:10px 0 10px 28px; }
    .timeline-step:last-child { padding-bottom:0; }
    .timeline-dot { position:absolute; left:-12px; top:12px; width:22px; height:22px; border-radius:50%; background:var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-size:.65rem; font-weight:700; }
    .timeline-dot.exit-dot { background:var(--accent); }
    .timeline-content { background:#fff; border-radius:8px; padding:10px 14px; border:1px solid #e2e8f0; }
    .timeline-title { font-weight:600; color:var(--secondary); font-size:.85rem; }
    .timeline-path { font-size:.75rem; color:#94a3b8; font-family:monospace; }
    .timeline-meta { display:flex; gap:12px; margin-top:4px; font-size:.73rem; color:#64748b; }
    .timeline-meta span { display:inline-flex; align-items:center; gap:3px; }

    .journey-pagination { display:flex; align-items:center; justify-content:center; gap:6px; margin-top:18px; }
    .journey-pagination button { padding:5px 12px; border-radius:6px; border:1px solid #d1d5db; background:#fff; font-size:.82rem; cursor:pointer; transition:.2s; }
    .journey-pagination button:hover:not(:disabled) { background:var(--primary); color:#fff; border-color:var(--primary); }
    .journey-pagination button:disabled { opacity:.4; cursor:not-allowed; }
    .journey-pagination .page-info { font-size:.82rem; color:#64748b; }

    .journey-session-card { background:#fff; border-radius:12px; border:1px solid #e2e8f0; margin-bottom:16px; overflow:hidden; transition:.2s; }
    .journey-session-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.08); }
    .journey-session-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; padding:14px 18px; background:#f8fafc; cursor:pointer; border-bottom:1px solid #e2e8f0; }
    .journey-session-header:hover { background:#f1f5f9; }
    .journey-session-info { display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
    .journey-session-meta { display:flex; gap:16px; font-size:.78rem; color:#64748b; flex-wrap:wrap; }
    .journey-session-body { display:none; padding:18px; background:#fafbfc; }
    .journey-loading { text-align:center; padding:30px; color:#64748b; }

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
        <span style="color:#94a3b8;">|</span>
        {{-- Country Multi-Select --}}
        <div class="country-dropdown" id="countryDropdown">
            <button type="button" class="country-dropdown-btn {{ count($selectedCountries) > 0 ? 'has-selection' : '' }}" id="btnCountryDropdown">
                <i class="fa fa-globe"></i>
                <span id="countryBtnLabel">{{ count($selectedCountries) > 0 ? count($selectedCountries) . ' Countries' : 'All Countries' }}</span>
                <i class="fa fa-caret-down caret"></i>
            </button>
            <div class="country-dropdown-menu" id="countryDropdownMenu">
                <div class="country-dropdown-search">
                    <input type="text" id="countrySearchInput" placeholder="Search countries...">
                </div>
                <div class="country-dropdown-list" id="countryDropdownList">
                    @foreach($allCountries as $country)
                    <div class="country-dropdown-item" data-country="{{ $country }}">
                        <input type="checkbox" id="cf_{{ md5($country) }}" value="{{ $country }}" {{ in_array($country, $selectedCountries) ? 'checked' : '' }}>
                        <label for="cf_{{ md5($country) }}">{{ $country }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="country-dropdown-footer">
                    <button type="button" class="btn-cd-clear" id="btnClearCountries">Clear All</button>
                    <button type="button" class="btn-cd-apply" id="btnApplyCountries"><i class="fa fa-check"></i> Apply Filter</button>
                </div>
            </div>
        </div>
        @if(count($selectedCountries) > 0)
        <div class="country-active-tags" id="countryActiveTags">
            @foreach($selectedCountries as $sc)
            <span class="country-tag">{{ $sc }} <span class="remove-tag" data-country="{{ $sc }}">&times;</span></span>
            @endforeach
        </div>
        @endif
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

    {{-- Row: New vs Returning --}}
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="chart-panel">
                <h5><i class="fa fa-user-plus"></i> New vs Returning Visitors</h5>
                @php $nvrTotal = $newVsReturning['new'] + $newVsReturning['returning']; @endphp
                @if($nvrTotal > 0)
                <canvas id="nvrChart" style="max-height:220px;"></canvas>
                <div class="nvr-summary">
                    <div class="nvr-stat"><div class="nvr-val nvr-new">{{ number_format($newVsReturning['new']) }}</div><div class="nvr-lbl">New ({{ round($newVsReturning['new'] / $nvrTotal * 100, 1) }}%)</div></div>
                    <div class="nvr-stat"><div class="nvr-val nvr-ret">{{ number_format($newVsReturning['returning']) }}</div><div class="nvr-lbl">Returning ({{ round($newVsReturning['returning'] / $nvrTotal * 100, 1) }}%)</div></div>
                </div>
                @else
                <p class="text-muted text-center py-4">No visitor data yet</p>
                @endif
            </div>
        </div>
        <div class="col-lg-7 mb-4">
            <div class="chart-panel" style="height:100%;">
                <h5><i class="fa fa-clock-o"></i> Peak Hours Heatmap</h5>
                @php
                    $dayNames = [1 => 'Sun', 2 => 'Mon', 3 => 'Tue', 4 => 'Wed', 5 => 'Thu', 6 => 'Fri', 7 => 'Sat'];
                    $heatGrid = $peakHours['grid'];
                    $heatMax = max($peakHours['max'], 1);
                @endphp
                <div class="heatmap-grid">
                    <div class="heatmap-header"></div>
                    @for($h = 0; $h < 24; $h++)
                    <div class="heatmap-header">{{ sprintf('%02d', $h) }}</div>
                    @endfor

                    @foreach($dayNames as $dow => $dayName)
                    <div class="heatmap-row-label">{{ $dayName }}</div>
                    @for($h = 0; $h < 24; $h++)
                        @php
                            $val = $heatGrid[$dow][$h] ?? 0;
                            $intensity = $heatMax > 0 ? $val / $heatMax : 0;
                            $bg = $val > 0 ? 'rgba(25,134,139,' . (0.15 + $intensity * 0.85) . ')' : '#f1f5f9';
                            $textColor = $intensity > 0.4 ? '#fff' : '#64748b';
                        @endphp
                        <div class="heatmap-cell" style="background:{{ $bg }};color:{{ $textColor }};" title="{{ $dayName }} {{ sprintf('%02d:00', $h) }}: {{ $val }} views">{{ $val > 0 ? $val : '' }}</div>
                    @endfor
                    @endforeach
                </div>
                <div class="heatmap-legend">
                    <span>Less</span>
                    <div class="heatmap-legend-bar">
                        <span style="background:#f1f5f9;"></span>
                        <span style="background:rgba(25,134,139,.2);"></span>
                        <span style="background:rgba(25,134,139,.4);"></span>
                        <span style="background:rgba(25,134,139,.6);"></span>
                        <span style="background:rgba(25,134,139,.8);"></span>
                        <span style="background:rgba(25,134,139,1);"></span>
                    </div>
                    <span>More</span>
                </div>
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

    {{-- Row: Entry/Exit Pages --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="table-panel">
                <h5><i class="fa fa-sign-in"></i> Top Entry Pages</h5>
                <div style="overflow-x:auto;">
                <table class="entry-exit-table">
                    <thead><tr><th>#</th><th>Page</th><th>Sessions</th></tr></thead>
                    <tbody>
                    @forelse($entryExitPages['entry'] as $i => $ep)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="url-cell" title="{{ $ep->entry_page }}">{{ Str::limit(parse_url($ep->entry_page ?? '', PHP_URL_PATH) ?: '/', 50) }}</td>
                        <td><strong>{{ number_format($ep->cnt) }}</strong></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">No data yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="table-panel">
                <h5><i class="fa fa-sign-out"></i> Top Exit Pages</h5>
                <div style="overflow-x:auto;">
                <table class="entry-exit-table">
                    <thead><tr><th>#</th><th>Page</th><th>Sessions</th></tr></thead>
                    <tbody>
                    @forelse($entryExitPages['exit'] as $i => $xp)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="url-cell" title="{{ $xp->exit_page }}">{{ Str::limit(parse_url($xp->exit_page ?? '', PHP_URL_PATH) ?: '/', 50) }}</td>
                        <td><strong>{{ number_format($xp->cnt) }}</strong></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">No data yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
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

    {{-- User Journeys (Redesigned) --}}
    <div class="table-panel">
        <h5><i class="fa fa-road"></i> User Journeys</h5>

        {{-- Journey Stats Cards --}}
        <div class="journey-stats-row">
            <div class="journey-stat-card">
                <div class="js-val">{{ $journeyStats['avg_pages'] }}</div>
                <div class="js-lbl">Avg Pages / Session</div>
            </div>
            <div class="journey-stat-card">
                <div class="js-val">{{ gmdate('i:s', $journeyStats['avg_duration']) }}</div>
                <div class="js-lbl">Avg Session Duration</div>
            </div>
            <div class="journey-stat-card">
                <div class="js-val">{{ $journeyStats['bounce_rate'] }}%</div>
                <div class="js-lbl">Drop-off Rate</div>
            </div>
            <div class="journey-stat-card">
                <div class="js-val" style="font-size:.95rem;">{{ Str::limit($journeyStats['top_entry'], 25) }}</div>
                <div class="js-lbl">Top Entry Page</div>
            </div>
            <div class="journey-stat-card">
                <div class="js-val" style="font-size:.95rem;">{{ Str::limit($journeyStats['top_exit'], 25) }}</div>
                <div class="js-lbl">Top Exit Page</div>
            </div>
        </div>

        {{-- Journey Filters --}}
        <div class="journey-filters">
            <select id="jrnCountry" multiple style="min-width:160px;max-height:34px;" title="Hold Ctrl to select multiple">
                @foreach($allCountries as $c)
                <option value="{{ $c }}" {{ in_array($c, $selectedCountries) ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
            <select id="jrnDevice">
                <option value="">All Devices</option>
                <option value="desktop">Desktop</option>
                <option value="mobile">Mobile</option>
                <option value="tablet">Tablet</option>
            </select>
            <input type="text" id="jrnSearch" placeholder="Search URL path..." style="flex:1;min-width:150px;">
            <button class="btn-filter" id="btnJrnFilter"><i class="fa fa-search"></i> Filter</button>
            <button class="btn-reset" id="btnJrnReset"><i class="fa fa-refresh"></i> Reset</button>
        </div>

        {{-- Journey Sessions (AJAX loaded) --}}
        <div class="journey-loading" id="jrnLoading">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <p style="margin-top:10px;">Loading sessions...</p>
        </div>
        <div id="jrnContainer"></div>
        <div class="journey-pagination" id="jrnPagination"></div>
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

    // New vs Returning doughnut
    @if(($newVsReturning['new'] + $newVsReturning['returning']) > 0)
    var nvrCtx = document.getElementById('nvrChart');
    if (nvrCtx) {
        new Chart(nvrCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['New Visitors', 'Returning Visitors'],
                datasets: [{ data: [{{ $newVsReturning['new'] }}, {{ $newVsReturning['returning'] }}], backgroundColor: [colors.success, colors.info] }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    }
    @endif

    // ─── Global Country Filter ─────────────────────────────────────
    var globalSelectedCountries = @json($selectedCountries);

    function getSelectedCountries() {
        var sel = [];
        $('#countryDropdownList input[type=checkbox]:checked').each(function() {
            sel.push($(this).val());
        });
        return sel;
    }

    // Toggle dropdown
    $('#btnCountryDropdown').on('click', function(e) {
        e.stopPropagation();
        $(this).toggleClass('open');
        $('#countryDropdownMenu').toggleClass('show');
    });

    // Close on outside click
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#countryDropdown').length) {
            $('#btnCountryDropdown').removeClass('open');
            $('#countryDropdownMenu').removeClass('show');
        }
    });

    // Search filter in dropdown
    $('#countrySearchInput').on('input', function() {
        var term = $(this).val().toLowerCase();
        $('#countryDropdownList .country-dropdown-item').each(function() {
            var name = $(this).data('country').toLowerCase();
            $(this).toggle(name.indexOf(term) !== -1);
        });
    });

    // Clear all checkboxes
    $('#btnClearCountries').on('click', function() {
        $('#countryDropdownList input[type=checkbox]').prop('checked', false);
    });

    // Apply country filter (rebuilds URL and reloads)
    $('#btnApplyCountries').on('click', function() {
        globalSelectedCountries = getSelectedCountries();
        applyAllFilters();
    });

    // Remove a single country tag
    $(document).on('click', '.remove-tag', function() {
        var c = $(this).data('country');
        globalSelectedCountries = globalSelectedCountries.filter(function(v) { return v !== c; });
        applyAllFilters();
    });

    function applyAllFilters() {
        var params = new URLSearchParams();
        var f = $('#dateFrom').val(), t = $('#dateTo').val();
        if (f && t) {
            params.set('from', f);
            params.set('to', t);
        } else {
            params.set('range', '{{ $range }}');
        }
        globalSelectedCountries.forEach(function(c) { params.append('countries[]', c); });
        window.location.href = '{{ route("admin.analytics.index") }}?' + params.toString();
    }

    // Date range buttons (include country filter)
    $('.btn-range').on('click', function() {
        var r = $(this).data('range');
        var params = new URLSearchParams();
        params.set('range', r);
        globalSelectedCountries.forEach(function(c) { params.append('countries[]', c); });
        window.location.href = '{{ route("admin.analytics.index") }}?' + params.toString();
    });

    // Apply date + country
    $('#btnApply').on('click', function() {
        globalSelectedCountries = getSelectedCountries();
        applyAllFilters();
    });

    // ─── Journey AJAX System ──────────────────────────────────────
    var jrnPage = 1;

    function formatDuration(sec) {
        if (!sec || sec <= 0) return '0s';
        if (sec < 60) return sec + 's';
        var m = Math.floor(sec / 60), s = sec % 60;
        return m + 'm ' + (s > 0 ? s + 's' : '');
    }

    function loadJourneys(page) {
        page = page || 1;
        jrnPage = page;

        var jrnCountryVal = $('#jrnCountry').val();
        var countriesForJourney = (jrnCountryVal && jrnCountryVal.length > 0) ? jrnCountryVal : globalSelectedCountries;

        var qp = new URLSearchParams();
        qp.set('page', page);
        qp.set('per_page', 15);
        qp.set('from', '{{ $startDate->toDateString() }}');
        qp.set('to', '{{ $endDate->toDateString() }}');
        if (Array.isArray(countriesForJourney)) {
            countriesForJourney.forEach(function(c) { qp.append('countries[]', c); });
        } else if (countriesForJourney) {
            qp.append('countries[]', countriesForJourney);
        }
        if ($('#jrnDevice').val()) qp.set('device', $('#jrnDevice').val());
        if ($('#jrnSearch').val()) qp.set('search', $('#jrnSearch').val());

        $('#jrnLoading').show();
        $('#jrnContainer').hide();
        $('#jrnPagination').hide();

        $.getJSON('{{ route("admin.analytics.journeys") }}?' + qp.toString(), function(res) {
            $('#jrnLoading').hide();
            $('#jrnContainer').show();
            $('#jrnPagination').show();

            var html = '';
            if (!res.data || res.data.length === 0) {
                html = '<div class="text-center text-muted py-4">No sessions found matching filters.</div>';
            } else {
                res.data.forEach(function(sess) {
                    var deviceClass = 'device-' + (sess.device || 'desktop');
                    html += '<div class="journey-session-card">';
                    html += '<div class="journey-session-header" data-sess="' + sess.id + '">';
                    html += '<div class="journey-session-info">';
                    html += '<span class="device-badge ' + deviceClass + '">' + (sess.device ? sess.device.charAt(0).toUpperCase() + sess.device.slice(1) : 'Desktop') + '</span>';
                    html += '<strong>' + (sess.country || 'Unknown') + '</strong>';
                    html += '<span style="color:#94a3b8;font-size:.78rem;">' + sess.visitor_id.substring(0, 10) + '...</span>';
                    html += '</div>';
                    html += '<div class="journey-session-meta">';
                    html += '<span><i class="fa fa-file-o"></i> ' + sess.page_count + ' pages</span>';
                    html += '<span><i class="fa fa-clock-o"></i> ' + formatDuration(sess.duration) + '</span>';
                    html += '<span>' + (sess.is_bounce ? '<span class="text-danger"><i class="fa fa-times-circle"></i> Bounce</span>' : '<span class="text-success"><i class="fa fa-check-circle"></i> Engaged</span>') + '</span>';
                    html += '<span><i class="fa fa-calendar"></i> ' + sess.started_at + '</span>';
                    html += '<i class="fa fa-chevron-down" style="color:#94a3b8;"></i>';
                    html += '</div></div>';

                    // Timeline body
                    html += '<div class="journey-session-body" id="jrnBody-' + sess.id + '">';
                    if (sess.pages && sess.pages.length > 0) {
                        html += '<div class="journey-timeline">';
                        sess.pages.forEach(function(pg, idx) {
                            var isLast = idx === sess.pages.length - 1;
                            var dotClass = isLast ? 'timeline-dot exit-dot' : 'timeline-dot';
                            html += '<div class="timeline-step">';
                            html += '<div class="' + dotClass + '">' + (idx + 1) + '</div>';
                            html += '<div class="timeline-content">';
                            html += '<div class="timeline-title">' + (pg.title || pg.path) + '</div>';
                            html += '<div class="timeline-path">' + pg.path + '</div>';
                            html += '<div class="timeline-meta">';
                            if (pg.time_on_page) html += '<span><i class="fa fa-clock-o"></i> ' + formatDuration(pg.time_on_page) + '</span>';
                            if (pg.viewed_at) html += '<span><i class="fa fa-eye"></i> ' + pg.viewed_at + '</span>';
                            if (idx === 0 && pg.referrer) {
                                var refDomain = pg.referrer;
                                try { refDomain = new URL(pg.referrer).hostname; } catch(e) {}
                                html += '<span><i class="fa fa-external-link"></i> via ' + refDomain + '</span>';
                            }
                            if (isLast) html += '<span style="color:var(--accent);font-weight:600;"><i class="fa fa-sign-out"></i> EXIT</span>';
                            html += '</div></div></div>';
                        });
                        html += '</div>';
                    }
                    html += '</div></div>';
                });
            }
            $('#jrnContainer').html(html);

            // Pagination
            var pHtml = '';
            pHtml += '<button id="jrnPrev" ' + (res.current_page <= 1 ? 'disabled' : '') + '><i class="fa fa-chevron-left"></i> Prev</button>';
            pHtml += '<span class="page-info">Page ' + res.current_page + ' of ' + res.last_page + ' (' + res.total + ' sessions)</span>';
            pHtml += '<button id="jrnNext" ' + (res.current_page >= res.last_page ? 'disabled' : '') + '>Next <i class="fa fa-chevron-right"></i></button>';
            $('#jrnPagination').html(pHtml);
        }).fail(function() {
            $('#jrnLoading').hide();
            $('#jrnContainer').html('<div class="text-center text-danger py-4">Failed to load sessions.</div>').show();
        });
    }

    // Toggle session timeline
    $(document).on('click', '.journey-session-header', function() {
        var id = $(this).data('sess');
        var body = $('#jrnBody-' + id);
        var icon = $(this).find('.fa-chevron-down, .fa-chevron-up');
        body.slideToggle(200);
        icon.toggleClass('fa-chevron-down fa-chevron-up');
    });

    // Journey pagination
    $(document).on('click', '#jrnPrev', function() { if (jrnPage > 1) loadJourneys(jrnPage - 1); });
    $(document).on('click', '#jrnNext', function() { loadJourneys(jrnPage + 1); });

    // Journey filters
    $('#btnJrnFilter').on('click', function() { loadJourneys(1); });
    $('#btnJrnReset').on('click', function() {
        $('#jrnCountry').val('');
        $('#jrnDevice').val('');
        $('#jrnSearch').val('');
        loadJourneys(1);
    });
    $('#jrnSearch').on('keypress', function(e) { if (e.which === 13) loadJourneys(1); });

    // Initial load
    loadJourneys(1);

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
