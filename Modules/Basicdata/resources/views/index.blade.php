@extends('admin::layouts.master')
@section('title', 'Basic Data Dashboard')

@section('css')
<style>
    :root {
        --primary-color: #e64c29;
        --secondary-color: #e8e8e8;
        --dark-color: #4c4c4c;
        --black-color: #000000;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #d43d1f 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(230, 76, 41, 0.3);
    }

    .dashboard-header h2 {
        margin: 0;
        font-weight: 700;
        font-size: 28px;
    }

    .dashboard-header p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(230, 76, 41, 0.2);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: var(--secondary-color);
        border-radius: 50%;
        transform: translate(30%, -30%);
        opacity: 0.3;
    }

    .stat-card .icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), #d43d1f);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(230, 76, 41, 0.3);
    }

    .stat-card .title {
        font-size: 13px;
        color: var(--dark-color);
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
    }

    .stat-card .subtitle {
        font-size: 12px;
        color: #999;
    }

    .stat-card .badge-info {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--primary-color);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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
        color: var(--dark-color);
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--black-color);
        margin: 30px 0 20px 0;
        padding-left: 15px;
        border-left: 4px solid var(--primary-color);
    }

    .activity-badge {
        background: var(--primary-color);
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 8px;
    }

    .activity-badge.success {
        background: #28a745;
    }

    .breadcrumbs {
        background: white;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .page-content-wrapper {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
    }

    canvas {
        max-height: 350px;
    }

    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 15px;
        }
        
        .dashboard-header h2 {
            font-size: 22px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        

        <!-- Dashboard Header -->
        <div class="dashboard-header animate__animated animate__fadeInDown" style="margin-top:70px">
            <h2><i class="fa fa-database"></i> Basic Data Dashboard</h2>
            <p>Comprehensive analytics and statistics for all basic data modules</p>
        </div>

        <!-- Quick Overview Charts -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Total Data Overview -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Data Overview</div>
                            <div class="chart-subtitle">Total items by type</div>
                        </div>
                    </div>
                    <canvas id="dataOverviewChart"></canvas>
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

        <!-- Project Related Data -->
        <h3 class="section-title">Project Related Data</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Project Types -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-folder"></i>
                    </div>
                    <div class="title">Project Types</div>
                    <div class="value">{{ $stats['project_types'] }}</div>
                    <div class="subtitle">Total project types</div>
                    @if($recentActivity['project_types'] > 0)
                    <span class="badge-info">+{{ $recentActivity['project_types'] }} this month</span>
                    @endif
                </div>
            </div>

            <!-- Engineering Categories -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-th-large"></i>
                    </div>
                    <div class="title">Engineering Categories</div>
                    <div class="value">{{ $stats['engineering_categories'] }}</div>
                    <div class="subtitle">Main categories</div>
                    @if($recentActivity['engineering_categories'] > 0)
                    <span class="badge-info">+{{ $recentActivity['engineering_categories'] }} this month</span>
                    @endif
                </div>
            </div>

            <!-- Engineering Subcategories -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <div class="title">Subcategories</div>
                    <div class="value">{{ $stats['engineering_subcategories'] }}</div>
                    <div class="subtitle">Engineering subcategories</div>
                </div>
            </div>

            <!-- Project Styles -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-palette"></i>
                    </div>
                    <div class="title">Project Styles</div>
                    <div class="value">{{ $stats['project_styles'] }}</div>
                    <div class="subtitle">Available styles</div>
                </div>
            </div>
        </div>

        <!-- Components -->
        <h3 class="section-title">Components</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Amenities -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="title">Amenities</div>
                    <div class="value">{{ $stats['amenities'] }}</div>
                    <div class="subtitle">Available amenities</div>
                    @if($recentActivity['amenities'] > 0)
                    <span class="badge-info">+{{ $recentActivity['amenities'] }} this month</span>
                    @endif
                </div>
            </div>

            <!-- Building Components -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <div class="title">Building Components</div>
                    <div class="value">{{ $stats['building_components'] }}</div>
                    <div class="subtitle">Building elements</div>
                    @if($recentActivity['building_components'] > 0)
                    <span class="badge-info">+{{ $recentActivity['building_components'] }} this month</span>
                    @endif
                </div>
            </div>

            <!-- Floor Components -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-layer-group"></i>
                    </div>
                    <div class="title">Floor Components</div>
                    <div class="value">{{ $stats['floor_components'] }}</div>
                    <div class="subtitle">Floor elements</div>
                </div>
            </div>

            <!-- Income Components -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                    <div class="title">Income Components</div>
                    <div class="value">{{ $stats['income_components'] }}</div>
                    <div class="subtitle">Revenue sources</div>
                </div>
            </div>

            <!-- Length Components -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-ruler"></i>
                    </div>
                    <div class="title">Length Components</div>
                    <div class="value">{{ $stats['length_components'] }}</div>
                    <div class="subtitle">Measurement units</div>
                </div>
            </div>

            <!-- Feasibility Components -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-chart-pie"></i>
                    </div>
                    <div class="title">Feasibility Components</div>
                    <div class="value">{{ $stats['feasibility_components'] }}</div>
                    <div class="subtitle">Study elements</div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-list-alt"></i>
                    </div>
                    <div class="title">Specifications</div>
                    <div class="value">{{ $stats['specifications'] }}</div>
                    <div class="subtitle">Technical specs</div>
                    @if($recentActivity['specifications'] > 0)
                    <span class="badge-info">+{{ $recentActivity['specifications'] }} this month</span>
                    @endif
                </div>
            </div>

            <!-- Currencies -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-coins"></i>
                    </div>
                    <div class="title">Currencies</div>
                    <div class="value">{{ $stats['currencies'] }}</div>
                    <div class="subtitle">Available currencies</div>
                </div>
            </div>
        </div>

        <!-- Technical & HR Data -->
        <h3 class="section-title">Technical & HR Data</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Substation Rooms -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-bolt"></i>
                    </div>
                    <div class="title">Substation Rooms</div>
                    <div class="value">{{ $stats['substation_rooms'] }}</div>
                    <div class="subtitle">Electrical rooms</div>
                </div>
            </div>

            <!-- Pumps Rooms -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-tint"></i>
                    </div>
                    <div class="title">Pumps Rooms</div>
                    <div class="value">{{ $stats['pumps_rooms'] }}</div>
                    <div class="subtitle">Water systems</div>
                </div>
            </div>

            <!-- Portfolio Types -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="title">Portfolio Types</div>
                    <div class="value">{{ $stats['portfolio_types'] }}</div>
                    <div class="subtitle">Portfolio categories</div>
                </div>
            </div>

            <!-- Job Titles -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-id-badge"></i>
                    </div>
                    <div class="title">Job Titles</div>
                    <div class="value">{{ $stats['job_titles'] }}</div>
                    <div class="subtitle">Position titles</div>
                </div>
            </div>

            <!-- Job Categories -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-tags"></i>
                    </div>
                    <div class="title">Job Categories</div>
                    <div class="value">{{ $stats['job_categories'] }}</div>
                    <div class="subtitle">Job classifications</div>
                </div>
            </div>

            <!-- Ranks -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-medal"></i>
                    </div>
                    <div class="title">Ranks</div>
                    <div class="value">{{ $stats['ranks'] }}</div>
                    <div class="subtitle">Employee ranks</div>
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
                            <div class="chart-title">Monthly Data Growth</div>
                            <div class="chart-subtitle">Last 6 months trend</div>
                        </div>
                    </div>
                    <canvas id="monthlyGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribution Charts - Two per Row -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Category Distribution -->
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

            <!-- Component Distribution -->
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
        // Check if Chart is available
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded');
            return;
        }

    // Data Overview Chart
    var dataOverviewCtx = document.getElementById('dataOverviewChart');
    if (dataOverviewCtx) {
        dataOverviewCtx = dataOverviewCtx.getContext('2d');
    var dataOverviewChart = new Chart(dataOverviewCtx, {
        type: 'bar',
        data: {
            labels: ['Project Types', 'Categories', 'Components', 'Amenities', 'Specifications', 'Currencies'],
            datasets: [{
                label: 'Total Items',
                data: [
                    {{ $stats['project_types'] }},
                    {{ $stats['engineering_categories'] }},
                    {{ $stats['building_components'] }},
                    {{ $stats['amenities'] }},
                    {{ $stats['specifications'] }},
                    {{ $stats['currencies'] }}
                ],
                backgroundColor: [
                    '#e64c29',
                    '#4c4c4c',
                    '#28a745',
                    '#007bff',
                    '#ffc107',
                    '#17a2b8'
                ],
                borderWidth: 0,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
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
            labels: ['Project Types', 'Categories', 'Components', 'Amenities', 'Specifications'],
            datasets: [{
                data: [
                    {{ $recentActivity['project_types'] }},
                    {{ $recentActivity['engineering_categories'] }},
                    {{ $recentActivity['building_components'] }},
                    {{ $recentActivity['amenities'] }},
                    {{ $recentActivity['specifications'] }}
                ],
                backgroundColor: [
                    '#e64c29',
                    '#4c4c4c',
                    '#28a745',
                    '#007bff',
                    '#ffc107'
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
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
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
                    label: 'Project Types',
                    data: {!! json_encode($monthlyData['project_types']) !!},
                    borderColor: '#e64c29',
                    backgroundColor: 'rgba(230, 76, 41, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Categories',
                    data: {!! json_encode($monthlyData['categories']) !!},
                    borderColor: '#4c4c4c',
                    backgroundColor: 'rgba(76, 76, 76, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Components',
                    data: {!! json_encode($monthlyData['components']) !!},
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Amenities',
                    data: {!! json_encode($monthlyData['amenities']) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
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
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
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
                    '#e64c29',
                    '#4c4c4c',
                    '#28a745',
                    '#007bff',
                    '#ffc107',
                    '#17a2b8',
                    '#6f42c1',
                    '#fd7e14'
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
                    labels: {
                        padding: 10,
                        usePointStyle: true,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
    }

    // Component Distribution Chart
    var componentDistributionCtx = document.getElementById('componentDistributionChart');
    if (componentDistributionCtx) {
        componentDistributionCtx = componentDistributionCtx.getContext('2d');
    var componentDistributionChart = new Chart(componentDistributionCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($componentDistribution['labels']) !!},
            datasets: [{
                data: {!! json_encode($componentDistribution['data']) !!},
                backgroundColor: [
                    '#e64c29',
                    '#4c4c4c',
                    '#28a745',
                    '#007bff',
                    '#ffc107'
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
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });
    }
    
    }); // End document.ready
</script>
@endsection
