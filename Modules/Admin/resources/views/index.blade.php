@extends('admin::layouts.master')
@section('title', 'Admin Dashboard')

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

    .status-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .status-indicator.published {
        background: #28a745;
    }

    .status-indicator.unpublished {
        background: #dc3545;
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
            <h2><i class="fa fa-chart-bar"></i> CMS Dashboard</h2>
            <p>Comprehensive analytics and statistics for all modules</p>
        </div>

        <!-- Quick Overview Charts -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Total Content Overview -->
            <div class="col-lg-6">
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
                <div class="stat-card">
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
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-project-diagram"></i>
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

            <!-- Portfolios -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="title">Portfolios</div>
                    <div class="value">{{ $stats['portfolios'] }}</div>
                    <div class="subtitle">
                        <span class="status-indicator published"></span> {{ $stats['portfolios_published'] }} Published
                        <br>
                        <span class="status-indicator published"></span> {{ $stats['portfolios_featured'] }} Featured
                    </div>
                    @if($recentActivity['portfolios'] > 0)
                    <span class="badge-info">+{{ $recentActivity['portfolios'] }} this month</span>
                    @endif
                </div>
            </div>

            <!-- News -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-newspaper"></i>
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

        <!-- Team & Partners -->
        <h3 class="section-title">Team & Partners</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Team Members -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                                        </div>
                    <div class="title">Team Members</div>
                    <div class="value">{{ $stats['team_members'] }}</div>
                    <div class="subtitle">Active members</div>
                    @if($recentActivity['team_members'] > 0)
                    <span class="badge-info">+{{ $recentActivity['team_members'] }} this month</span>
                    @endif
                                    </div>
                                </div>

            <!-- Partners -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-handshake"></i>
                    </div>
                    <div class="title">Partners</div>
                    <div class="value">{{ $stats['partners'] }}</div>
                    <div class="subtitle">Business partners</div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-user-shield"></i>
                    </div>
                    <div class="title">System Users</div>
                    <div class="value">{{ $stats['users'] }}</div>
                    <div class="subtitle">Admin users</div>
                </div>
            </div>

            <!-- Feasibility Studies -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-chart-line"></i>
                            </div>
                    <div class="title">Feasibility Studies</div>
                    <div class="value">{{ $stats['feasibility_studies'] }}</div>
                    <div class="subtitle">Total studies</div>
                                        </div>
                                    </div>
                                </div>

        <!-- Website Content -->
        <h3 class="section-title">Website Content</h3>
        <div class="row animate__animated animate__fadeInUp">
            <!-- Sliders -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-images"></i>
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
                <div class="stat-card">
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

            <!-- FAQs -->
                                <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-question-circle"></i>
                                        </div>
                    <div class="title">FAQs</div>
                    <div class="value">{{ $stats['faqs'] }}</div>
                    <div class="subtitle">Frequently asked questions</div>
                                    </div>
                                </div>

            <!-- Home FAQs -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="title">Home FAQs</div>
                    <div class="value">{{ $stats['home_faqs'] }}</div>
                    <div class="subtitle">Homepage FAQs</div>
                </div>
            </div>

            <!-- Home Blocks -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
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
                <div class="stat-card">
                    <div class="icon">
                        <i class="fa fa-id-card"></i>
                    </div>
                    <div class="title">Cards</div>
                    <div class="value">{{ $stats['cards'] }}</div>
                    <div class="subtitle">Content cards</div>
                </div>
                            </div>

            <!-- About Features -->
            <div class="col-md-6 col-xl-3">
                <div class="stat-card">
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
                <div class="stat-card">
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
                            <div class="chart-subtitle">Last 6 months trend</div>
                        </div>
                    </div>
                    <canvas id="monthlyGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Charts - Two per Row -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Services Status -->
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

            <!-- Projects Status -->
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

        <!-- More Charts - Two per Row -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Portfolios Status -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Portfolios Status</div>
                            <div class="chart-subtitle">Published vs Unpublished</div>
                        </div>
                    </div>
                    <canvas id="portfoliosStatusChart"></canvas>
                </div>
            </div>

            <!-- Category Distribution -->
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
                    borderColor: '#e64c29',
                    backgroundColor: 'rgba(230, 76, 41, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Projects',
                    data: {!! json_encode($monthlyData['projects']) !!},
                    borderColor: '#4c4c4c',
                    backgroundColor: 'rgba(76, 76, 76, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Portfolios',
                    data: {!! json_encode($monthlyData['portfolios']) !!},
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'News',
                    data: {!! json_encode($monthlyData['news']) !!},
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
                backgroundColor: ['#28a745', '#dc3545'],
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
                backgroundColor: ['#28a745', '#dc3545'],
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

    // Portfolios Status Chart
    var portfoliosStatusCtx = document.getElementById('portfoliosStatusChart');
    if (portfoliosStatusCtx) {
        portfoliosStatusCtx = portfoliosStatusCtx.getContext('2d');
    var portfoliosStatusChart = new Chart(portfoliosStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Unpublished'],
            datasets: [{
                data: [
                    {{ $statusDistribution['portfolios']['published'] }},
                    {{ $statusDistribution['portfolios']['unpublished'] }}
                ],
                backgroundColor: ['#28a745', '#dc3545'],
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

    // Content Overview Chart
    var contentOverviewCtx = document.getElementById('contentOverviewChart');
    if (contentOverviewCtx) {
        contentOverviewCtx = contentOverviewCtx.getContext('2d');
    var contentOverviewChart = new Chart(contentOverviewCtx, {
        type: 'bar',
        data: {
            labels: ['Services', 'Projects', 'Portfolios', 'News', 'Team', 'Partners', 'FAQs', 'Sliders'],
            datasets: [{
                label: 'Total Items',
                data: [
                    {{ $stats['services'] }},
                    {{ $stats['projects'] }},
                    {{ $stats['portfolios'] }},
                    {{ $stats['news'] }},
                    {{ $stats['team_members'] }},
                    {{ $stats['partners'] }},
                    {{ $stats['faqs'] }},
                    {{ $stats['sliders'] }}
                ],
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
            labels: ['Services', 'Projects', 'Portfolios', 'News', 'Team Members'],
            datasets: [{
                data: [
                    {{ $recentActivity['services'] }},
                    {{ $recentActivity['projects'] }},
                    {{ $recentActivity['portfolios'] }},
                    {{ $recentActivity['news'] }},
                    {{ $recentActivity['team_members'] }}
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
    
    }); // End document.ready
</script>
@endsection
