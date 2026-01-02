@extends('admin::layouts.master')
@section('title', 'Basic Data Dashboard')

@section('css')
<style>
    :root {
        --primary-color: #1a7d6b;
        --primary-dark: #145c50;
        --primary-light: #22a08a;
        --accent-color: #e8b85e;
        --secondary-color: #f0f4f3;
        --dark-color: #2c3e50;
        --black-color: #1a1a2e;
        --success-color: #10b981;
        --info-color: #3b82f6;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .page-content-wrapper {
        background: linear-gradient(135deg, #f8faf9 0%, #e8f0ed 100%);
        min-height: 100vh;
        padding: 20px;
    }

    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--primary-light) 100%);
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
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 30%;
        width: 200px;
        height: 200px;
        background: rgba(232, 184, 94, 0.15);
        border-radius: 50%;
    }

    .dashboard-header h2 {
        margin: 0;
        font-weight: 700;
        font-size: 28px;
        position: relative;
        z-index: 1;
    }

    .dashboard-header h2 i {
        margin-right: 12px;
        color: var(--accent-color);
    }

    .dashboard-header p {
        margin: 8px 0 0 0;
        opacity: 0.9;
        font-size: 15px;
        position: relative;
        z-index: 1;
    }

    .header-stats {
        display: flex;
        gap: 30px;
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }

    .header-stat {
        text-align: center;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        backdrop-filter: blur(5px);
    }

    .header-stat .number {
        font-size: 24px;
        font-weight: 700;
        color: var(--accent-color);
    }

    .header-stat .label {
        font-size: 12px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .quick-actions-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-actions-title i {
        color: var(--primary-color);
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
    }

    .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 18px 12px;
        background: var(--secondary-color);
        border-radius: 12px;
        text-decoration: none;
        color: var(--dark-color);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .action-item:hover {
        background: white;
        border-color: var(--primary-color);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(26, 125, 107, 0.15);
        text-decoration: none;
        color: var(--primary-color);
    }

    .action-item i {
        font-size: 24px;
        margin-bottom: 10px;
        color: var(--primary-color);
    }

    .action-item span {
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        line-height: 1.3;
    }

    /* Section Title */
    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--black-color);
        margin: 30px 0 20px 0;
        padding-left: 15px;
        border-left: 4px solid var(--primary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title .badge {
        background: var(--primary-color);
        color: white;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(26, 125, 107, 0.1);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(26, 125, 107, 0.15);
        border-color: var(--primary-color);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        border-radius: 50%;
        transform: translate(30%, -30%);
        opacity: 0.1;
    }

    .stat-card .icon {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 15px;
        box-shadow: 0 6px 20px rgba(26, 125, 107, 0.25);
    }

    .stat-card .icon.orange {
        background: linear-gradient(135deg, var(--accent-color), #d4a04a);
        box-shadow: 0 6px 20px rgba(232, 184, 94, 0.25);
    }

    .stat-card .icon.blue {
        background: linear-gradient(135deg, var(--info-color), #2563eb);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.25);
    }

    .stat-card .icon.green {
        background: linear-gradient(135deg, var(--success-color), #059669);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.25);
    }

    .stat-card .icon.red {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.25);
    }

    .stat-card .title {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-card .value {
        font-size: 32px;
        font-weight: 700;
        color: var(--black-color);
        margin-bottom: 5px;
        line-height: 1;
    }

    .stat-card .subtitle {
        font-size: 12px;
        color: #9ca3af;
    }

    .stat-card .badge-info {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, var(--success-color), #059669);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    /* Chart Cards */
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(26, 125, 107, 0.1);
    }

    .chart-card .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--secondary-color);
    }

    .chart-card .chart-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--black-color);
    }

    .chart-card .chart-subtitle {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    canvas {
        max-height: 320px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .header-stats {
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header-stat {
            flex: 1;
            min-width: 100px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 25px 20px;
        }
        
        .dashboard-header h2 {
            font-size: 22px;
        }
        
        .quick-actions-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .stat-card {
            margin-bottom: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        <!-- Dashboard Header -->
        <div class="dashboard-header" style="margin-top:70px">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2><i class="fa fa-database"></i> Basic Data Dashboard</h2>
                    <p>Manage and configure all foundational data for projects, offers, and system components</p>
                    
                    <div class="header-stats">
                        <div class="header-stat">
                            <div class="number">{{ $totalItems }}</div>
                            <div class="label">Total Items</div>
                        </div>
                        <div class="header-stat">
                            <div class="number">{{ $stats['engineering_categories'] + $stats['engineering_subcategories'] }}</div>
                            <div class="label">Categories</div>
                        </div>
                        <div class="header-stat">
                            <div class="number">{{ $stats['building_components'] + $stats['floor_components'] + $stats['income_components'] }}</div>
                            <div class="label">Components</div>
                        </div>
                        <div class="header-stat">
                            <div class="number">{{ $stats['emirates'] }}</div>
                            <div class="label">Emirates</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="quick-actions-title">
                <i class="fa fa-bolt"></i> Quick Actions
            </div>
            <div class="quick-actions-grid">
                <a href="{{ route('engineeringcategory.index') }}" class="action-item">
                    <i class="fa fa-th-large"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('projecttype.index') }}" class="action-item">
                    <i class="fa fa-folder"></i>
                    <span>Project Types</span>
                </a>
                <a href="{{ route('projectstyle.index') }}" class="action-item">
                    <i class="fa fa-paint-brush"></i>
                    <span>Styles</span>
                </a>
                <a href="{{ route('emirate.index') }}" class="action-item">
                    <i class="fa fa-map-marker"></i>
                    <span>Emirates</span>
                </a>
                <a href="{{ route('offercategory.index') }}" class="action-item">
                    <i class="fa fa-tag"></i>
                    <span>Offer Categories</span>
                </a>
                <a href="{{ route('amenity.index') }}" class="action-item">
                    <i class="fa fa-star"></i>
                    <span>Amenities</span>
                </a>
                <a href="{{ route('buildingcomponent.index') }}" class="action-item">
                    <i class="fa fa-cubes"></i>
                    <span>Building</span>
                </a>
                <a href="{{ route('specification.index') }}" class="action-item">
                    <i class="fa fa-list-alt"></i>
                    <span>Specifications</span>
                </a>
                <a href="{{ route('currency.index') }}" class="action-item">
                    <i class="fa fa-money"></i>
                    <span>Currencies</span>
                </a>
                <a href="{{ route('jobtitle.index') }}" class="action-item">
                    <i class="fa fa-id-card"></i>
                    <span>Job Titles</span>
                </a>
            </div>
        </div>

        <!-- Quick Overview Charts -->
        <div class="row">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Data Overview</div>
                            <div class="chart-subtitle">Total items by category</div>
                        </div>
                    </div>
                    <canvas id="dataOverviewChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Recent Activity</div>
                            <div class="chart-subtitle">New additions (Last 30 Days)</div>
                        </div>
                    </div>
                    <canvas id="recentActivityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Project & Offer Data -->
        <h3 class="section-title">
            <i class="fa fa-building" style="color: var(--primary-color);"></i>
            Project & Offer Data
            <span class="badge">{{ $stats['project_types'] + $stats['engineering_categories'] + $stats['engineering_subcategories'] + $stats['project_styles'] + $stats['offer_categories'] + $stats['offer_subcategories'] }}</span>
        </h3>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-folder"></i></div>
                    <div class="title">Project Types</div>
                    <div class="value">{{ $stats['project_types'] }}</div>
                    <div class="subtitle">Available project types</div>
                    @if($recentActivity['project_types'] > 0)
                    <span class="badge-info">+{{ $recentActivity['project_types'] }} new</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon orange"><i class="fa fa-th-large"></i></div>
                    <div class="title">Engineering Categories</div>
                    <div class="value">{{ $stats['engineering_categories'] }}</div>
                    <div class="subtitle">Main categories</div>
                    @if($recentActivity['engineering_categories'] > 0)
                    <span class="badge-info">+{{ $recentActivity['engineering_categories'] }} new</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon blue"><i class="fa fa-sitemap"></i></div>
                    <div class="title">Subcategories</div>
                    <div class="value">{{ $stats['engineering_subcategories'] }}</div>
                    <div class="subtitle">Engineering subcategories</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon green"><i class="fa fa-paint-brush"></i></div>
                    <div class="title">Project Styles</div>
                    <div class="value">{{ $stats['project_styles'] }}</div>
                    <div class="subtitle">Design styles</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon orange"><i class="fa fa-tag"></i></div>
                    <div class="title">Offer Categories</div>
                    <div class="value">{{ $stats['offer_categories'] }}</div>
                    <div class="subtitle">Main offer categories</div>
                    @if($recentActivity['offer_categories'] > 0)
                    <span class="badge-info">+{{ $recentActivity['offer_categories'] }} new</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon blue"><i class="fa fa-tags"></i></div>
                    <div class="title">Offer Subcategories</div>
                    <div class="value">{{ $stats['offer_subcategories'] }}</div>
                    <div class="subtitle">Offer subcategories</div>
                </div>
            </div>
        </div>

        <!-- Location Data -->
        <h3 class="section-title">
            <i class="fa fa-map-marker" style="color: var(--primary-color);"></i>
            Location Data
            <span class="badge">{{ $stats['emirates'] }}</span>
        </h3>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-map-marker"></i></div>
                    <div class="title">Emirates</div>
                    <div class="value">{{ $stats['emirates'] }}</div>
                    <div class="subtitle">UAE Emirates</div>
                    @if($recentActivity['emirates'] > 0)
                    <span class="badge-info">+{{ $recentActivity['emirates'] }} new</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Components -->
        <h3 class="section-title">
            <i class="fa fa-cubes" style="color: var(--primary-color);"></i>
            Components
            <span class="badge">{{ $stats['amenities'] + $stats['building_components'] + $stats['floor_components'] + $stats['income_components'] + $stats['length_components'] + $stats['feasibility_components'] + $stats['specifications'] }}</span>
        </h3>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-star"></i></div>
                    <div class="title">Amenities</div>
                    <div class="value">{{ $stats['amenities'] }}</div>
                    <div class="subtitle">Available amenities</div>
                    @if($recentActivity['amenities'] > 0)
                    <span class="badge-info">+{{ $recentActivity['amenities'] }} new</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon orange"><i class="fa fa-cubes"></i></div>
                    <div class="title">Building Components</div>
                    <div class="value">{{ $stats['building_components'] }}</div>
                    <div class="subtitle">Building elements</div>
                    @if($recentActivity['building_components'] > 0)
                    <span class="badge-info">+{{ $recentActivity['building_components'] }} new</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon blue"><i class="fa fa-th-list"></i></div>
                    <div class="title">Floor Components</div>
                    <div class="value">{{ $stats['floor_components'] }}</div>
                    <div class="subtitle">Floor elements</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon green"><i class="fa fa-usd"></i></div>
                    <div class="title">Income Components</div>
                    <div class="value">{{ $stats['income_components'] }}</div>
                    <div class="subtitle">Revenue sources</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-arrows-h"></i></div>
                    <div class="title">Length Components</div>
                    <div class="value">{{ $stats['length_components'] }}</div>
                    <div class="subtitle">Measurement units</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon orange"><i class="fa fa-pie-chart"></i></div>
                    <div class="title">Feasibility Components</div>
                    <div class="value">{{ $stats['feasibility_components'] }}</div>
                    <div class="subtitle">Study elements</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon blue"><i class="fa fa-list-alt"></i></div>
                    <div class="title">Specifications</div>
                    <div class="value">{{ $stats['specifications'] }}</div>
                    <div class="subtitle">Technical specs</div>
                    @if($recentActivity['specifications'] > 0)
                    <span class="badge-info">+{{ $recentActivity['specifications'] }} new</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon green"><i class="fa fa-money"></i></div>
                    <div class="title">Currencies</div>
                    <div class="value">{{ $stats['currencies'] }}</div>
                    <div class="subtitle">Available currencies</div>
                </div>
            </div>
        </div>

        <!-- Technical & HR Data -->
        <h3 class="section-title">
            <i class="fa fa-cogs" style="color: var(--primary-color);"></i>
            Technical & HR Data
            <span class="badge">{{ $stats['substation_rooms'] + $stats['pumps_rooms'] + $stats['portfolio_types'] + $stats['job_titles'] + $stats['job_categories'] + $stats['ranks'] }}</span>
        </h3>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-bolt"></i></div>
                    <div class="title">Substation Rooms</div>
                    <div class="value">{{ $stats['substation_rooms'] }}</div>
                    <div class="subtitle">Electrical rooms</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon orange"><i class="fa fa-tint"></i></div>
                    <div class="title">Pumps Rooms</div>
                    <div class="value">{{ $stats['pumps_rooms'] }}</div>
                    <div class="subtitle">Water systems</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon blue"><i class="fa fa-briefcase"></i></div>
                    <div class="title">Portfolio Types</div>
                    <div class="value">{{ $stats['portfolio_types'] }}</div>
                    <div class="subtitle">Portfolio categories</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon green"><i class="fa fa-id-card"></i></div>
                    <div class="title">Job Titles</div>
                    <div class="value">{{ $stats['job_titles'] }}</div>
                    <div class="subtitle">Position titles</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-tags"></i></div>
                    <div class="title">Job Categories</div>
                    <div class="value">{{ $stats['job_categories'] }}</div>
                    <div class="subtitle">Job classifications</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon orange"><i class="fa fa-trophy"></i></div>
                    <div class="title">Ranks</div>
                    <div class="value">{{ $stats['ranks'] }}</div>
                    <div class="subtitle">Employee ranks</div>
                </div>
            </div>
        </div>

        <!-- Analytics Charts -->
        <h3 class="section-title">
            <i class="fa fa-line-chart" style="color: var(--primary-color);"></i>
            Analytics & Trends
        </h3>
        
        <div class="row">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Monthly Data Growth</div>
                            <div class="chart-subtitle">Last 6 months trend</div>
                        </div>
                    </div>
                    <canvas id="monthlyGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Engineering Categories</div>
                            <div class="chart-subtitle">Category distribution</div>
                        </div>
                    </div>
                    <canvas id="categoryDistributionChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Component Types</div>
                            <div class="chart-subtitle">Components by type</div>
                        </div>
                    </div>
                    <canvas id="componentDistributionChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded');
        return;
    }

    // Color palette
    var primaryColor = '#1a7d6b';
    var accentColor = '#e8b85e';
    var successColor = '#10b981';
    var infoColor = '#3b82f6';
    var warningColor = '#f59e0b';
    var dangerColor = '#ef4444';

    // Data Overview Chart
    var dataOverviewCtx = document.getElementById('dataOverviewChart');
    if (dataOverviewCtx) {
        new Chart(dataOverviewCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Project Types', 'Categories', 'Emirates', 'Components', 'Amenities', 'Specifications'],
                datasets: [{
                    label: 'Total Items',
                    data: [
                        {{ $stats['project_types'] }},
                        {{ $stats['engineering_categories'] }},
                        {{ $stats['emirates'] }},
                        {{ $stats['building_components'] }},
                        {{ $stats['amenities'] }},
                        {{ $stats['specifications'] }}
                    ],
                    backgroundColor: [
                        primaryColor,
                        accentColor,
                        successColor,
                        infoColor,
                        warningColor,
                        dangerColor
                    ],
                    borderWidth: 0,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: { precision: 0 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // Recent Activity Chart
    var recentActivityCtx = document.getElementById('recentActivityChart');
    if (recentActivityCtx) {
        new Chart(recentActivityCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Project Types', 'Categories', 'Components', 'Amenities', 'Specifications', 'Emirates', 'Offer Categories'],
                datasets: [{
                    data: [
                        {{ $recentActivity['project_types'] }},
                        {{ $recentActivity['engineering_categories'] }},
                        {{ $recentActivity['building_components'] }},
                        {{ $recentActivity['amenities'] }},
                        {{ $recentActivity['specifications'] }},
                        {{ $recentActivity['emirates'] }},
                        {{ $recentActivity['offer_categories'] }}
                    ],
                    backgroundColor: [
                        primaryColor,
                        accentColor,
                        successColor,
                        infoColor,
                        warningColor,
                        dangerColor,
                        '#8b5cf6'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, font: { size: 11 } }
                    }
                }
            }
        });
    }

    // Monthly Growth Chart
    var monthlyGrowthCtx = document.getElementById('monthlyGrowthChart');
    if (monthlyGrowthCtx) {
        new Chart(monthlyGrowthCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyData['months']) !!},
                datasets: [
                    {
                        label: 'Project Types',
                        data: {!! json_encode($monthlyData['project_types']) !!},
                        borderColor: primaryColor,
                        backgroundColor: 'rgba(26, 125, 107, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Categories',
                        data: {!! json_encode($monthlyData['categories']) !!},
                        borderColor: accentColor,
                        backgroundColor: 'rgba(232, 184, 94, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Components',
                        data: {!! json_encode($monthlyData['components']) !!},
                        borderColor: successColor,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Amenities',
                        data: {!! json_encode($monthlyData['amenities']) !!},
                        borderColor: infoColor,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
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
                        labels: { padding: 15, usePointStyle: true }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // Category Distribution Chart
    var categoryDistributionCtx = document.getElementById('categoryDistributionChart');
    if (categoryDistributionCtx) {
        new Chart(categoryDistributionCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($categoryDistribution['labels']) !!},
                datasets: [{
                    data: {!! json_encode($categoryDistribution['data']) !!},
                    backgroundColor: [
                        primaryColor,
                        accentColor,
                        successColor,
                        infoColor,
                        warningColor,
                        dangerColor,
                        '#8b5cf6',
                        '#ec4899'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 10, usePointStyle: true, font: { size: 11 } }
                    }
                }
            }
        });
    }

    // Component Distribution Chart
    var componentDistributionCtx = document.getElementById('componentDistributionChart');
    if (componentDistributionCtx) {
        new Chart(componentDistributionCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($componentDistribution['labels']) !!},
                datasets: [{
                    data: {!! json_encode($componentDistribution['data']) !!},
                    backgroundColor: [
                        primaryColor,
                        accentColor,
                        successColor,
                        infoColor,
                        warningColor
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15, usePointStyle: true }
                    }
                }
            }
        });
    }

});
</script>
@endsection
