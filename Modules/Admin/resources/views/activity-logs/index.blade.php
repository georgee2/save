@extends('admin::layouts.master')
@section('title', 'Activity Logs')

@section('css')
<style>
    .activity-card {
        border-radius: 10px;
        border: 1px solid #e9ecef;
        margin-bottom: 15px;
        transition: all 0.2s ease;
    }
    
    .activity-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-color: #19868b;
    }
    
    .activity-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
    }
    
    .activity-icon.create { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
    .activity-icon.update { background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); }
    .activity-icon.delete { background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); }
    .activity-icon.restore { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }
    .activity-icon.toggle_status { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); }
    .activity-icon.reorder { background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); }
    .activity-icon.bulk_create { background: linear-gradient(135deg, #28a745 0%, #007bff 100%); }
    .activity-icon.force_delete { background: linear-gradient(135deg, #343a40 0%, #212529 100%); }
    .activity-icon.default { background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%); }
    
    .activity-info {
        flex: 1;
    }
    
    .activity-title {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .activity-meta {
        display: flex;
        gap: 15px;
        font-size: 12px;
        color: #6c757d;
    }
    
    .activity-meta i {
        margin-right: 4px;
    }
    
    .activity-body {
        padding: 15px;
    }
    
    .activity-description {
        font-size: 14px;
        color: #495057;
        margin-bottom: 10px;
    }
    
    .changed-fields {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .changed-field {
        font-size: 11px;
        padding: 3px 8px;
        background: #e9ecef;
        border-radius: 4px;
        color: #495057;
    }
    
    .filter-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .badge-action {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .badge-model {
        background: #e3f2fd;
        color: #1565c0;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .view-details-btn {
        padding: 5px 12px;
        font-size: 12px;
        border-radius: 6px;
    }
    
    .stats-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        flex: 1;
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        border: 1px solid #e9ecef;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #19868b;
    }
    
    .stat-label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-history"></i> Activity Logs</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-history"></i> Activity Logs</h4>
                            <p class="text-muted mb-0">Track all changes made in the admin panel</p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <span class="text-muted">Total: {{ $logs->total() }} records</span>
                        </div>
                    </div>
                    <hr>
                    
                    {{-- Filters --}}
                    <div class="filter-card">
                        <form method="GET" action="{{ route('admin.activity-logs.index') }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">User</label>
                                        <select name="user_id" class="form-control form-control-sm">
                                            <option value="">All Users</option>
                                            @foreach($users as $user)
                                            <option value="{{ $user->user_id }}" {{ $filters['user_id'] == $user->user_id ? 'selected' : '' }}>
                                                {{ $user->user_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">Action</label>
                                        <select name="action" class="form-control form-control-sm">
                                            <option value="">All Actions</option>
                                            @foreach($actions as $action)
                                            <option value="{{ $action }}" {{ $filters['action'] == $action ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $action)) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">Model</label>
                                        <select name="model_name" class="form-control form-control-sm">
                                            <option value="">All Models</option>
                                            @foreach($modelNames as $modelName)
                                            <option value="{{ $modelName }}" {{ $filters['model_name'] == $modelName ? 'selected' : '' }}>
                                                {{ $modelName }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">From Date</label>
                                        <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $filters['date_from'] }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">To Date</label>
                                        <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $filters['date_to'] }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="small text-muted">Search</label>
                                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ $filters['search'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-filter"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-times"></i> Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    {{-- Activity List --}}
                    @if($logs->count() > 0)
                    <div class="activity-list">
                        @foreach($logs as $log)
                        @php
                            $actionInfo = $log->getActionLabel();
                            $iconClass = str_replace('_', '-', $log->action);
                        @endphp
                        <div class="activity-card">
                            <div class="activity-header">
                                <div class="activity-icon {{ $log->action }}">
                                    <i class="fa {{ $actionInfo['icon'] }}"></i>
                                </div>
                                <div class="activity-info">
                                    <div class="activity-title">
                                        <span class="badge badge-{{ $actionInfo['color'] }} badge-action mr-2">{{ $actionInfo['label'] }}</span>
                                        <span class="badge badge-model">{{ $log->model_name }}</span>
                                        @if($log->record_title)
                                        <span class="text-muted ml-2">- {{ Str::limit($log->record_title, 50) }}</span>
                                        @endif
                                    </div>
                                    <div class="activity-meta">
                                        <span><i class="fa fa-user"></i> {{ $log->user_name ?? 'System' }}</span>
                                        <span><i class="fa fa-clock"></i> {{ $log->created_at->format('M d, Y H:i:s') }}</span>
                                        <span><i class="fa fa-globe"></i> {{ $log->ip_address }}</span>
                                        @if($log->model_id)
                                        <span><i class="fa fa-hashtag"></i> ID: {{ $log->model_id }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('admin.activity-logs.show', $log->id) }}" class="btn btn-outline-primary view-details-btn">
                                        <i class="fa fa-eye"></i> Details
                                    </a>
                                </div>
                            </div>
                            <div class="activity-body">
                                <div class="activity-description">
                                    {{ $log->description }}
                                </div>
                                @if($log->changed_fields && count($log->changed_fields) > 0)
                                <div class="changed-fields">
                                    <span class="text-muted small mr-2">Changed:</span>
                                    @foreach($log->changed_fields as $field)
                                    <span class="changed-field">{{ str_replace('_', ' ', $field) }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $logs->appends($filters)->links() }}
                    </div>
                    @else
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">No activity logs found matching your criteria.</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
