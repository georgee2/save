@extends('admin::layouts.master')
@section('title', 'Activity Log Details')

@section('css')
<style>
    .detail-card {
        border-radius: 10px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }
    
    .detail-card-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        border-radius: 10px 10px 0 0;
    }
    
    .detail-card-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }
    
    .detail-card-body {
        padding: 20px;
    }
    
    .info-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        width: 150px;
        font-weight: 600;
        color: #495057;
    }
    
    .info-value {
        flex: 1;
        color: #333;
    }
    
    .json-viewer {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        max-height: 400px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-break: break-all;
    }
    
    .diff-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .diff-column {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }
    
    .diff-column.old {
        border-left: 4px solid #dc3545;
    }
    
    .diff-column.new {
        border-left: 4px solid #28a745;
    }
    
    .diff-title {
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .diff-title.old { color: #dc3545; }
    .diff-title.new { color: #28a745; }
    
    .field-change {
        padding: 8px 12px;
        margin-bottom: 8px;
        border-radius: 6px;
        background: #fff;
        border: 1px solid #e9ecef;
    }
    
    .field-name {
        font-weight: 600;
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    
    .field-value {
        font-size: 14px;
        word-break: break-all;
    }
    
    .field-value.old { color: #dc3545; }
    .field-value.new { color: #28a745; }
    
    .action-badge {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 20px;
    }
    
    .model-badge {
        background: #e3f2fd;
        color: #1565c0;
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 20px;
    }
    
    @media (max-width: 768px) {
        .diff-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.activity-logs.index')}}" class="breadcrumbs__item"><i class="fa fa-history"></i> Activity Logs</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Log Details</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @php
                $actionInfo = $log->getActionLabel();
            @endphp
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mt-0 header-title mb-2">
                                <i class="fa fa-eye"></i> Activity Log Details
                            </h4>
                            <span class="badge badge-{{ $actionInfo['color'] }} action-badge mr-2">
                                <i class="fa {{ $actionInfo['icon'] }} mr-1"></i> {{ $actionInfo['label'] }}
                            </span>
                            <span class="model-badge">{{ $log->model_name }}</span>
                        </div>
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Logs
                        </a>
                    </div>
                    <hr>
                    
                    <div class="row">
                        {{-- Basic Information --}}
                        <div class="col-lg-6">
                            <div class="detail-card">
                                <div class="detail-card-header">
                                    <h5><i class="fa fa-info-circle mr-2"></i> Basic Information</h5>
                                </div>
                                <div class="detail-card-body">
                                    <div class="info-row">
                                        <div class="info-label">Log ID</div>
                                        <div class="info-value">#{{ $log->id }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Action</div>
                                        <div class="info-value">
                                            <span class="badge badge-{{ $actionInfo['color'] }}">{{ $actionInfo['label'] }}</span>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Model</div>
                                        <div class="info-value">{{ $log->model_name }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Record ID</div>
                                        <div class="info-value">{{ $log->model_id ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Record Title</div>
                                        <div class="info-value">{{ $log->record_title ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Description</div>
                                        <div class="info-value">{{ $log->description }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- User & System Information --}}
                        <div class="col-lg-6">
                            <div class="detail-card">
                                <div class="detail-card-header">
                                    <h5><i class="fa fa-user mr-2"></i> User & System Information</h5>
                                </div>
                                <div class="detail-card-body">
                                    <div class="info-row">
                                        <div class="info-label">User</div>
                                        <div class="info-value">{{ $log->user_name ?? 'System' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">{{ $log->user_email ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">IP Address</div>
                                        <div class="info-value">{{ $log->ip_address ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Date & Time</div>
                                        <div class="info-value">{{ $log->created_at->format('F d, Y H:i:s') }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Time Ago</div>
                                        <div class="info-value">{{ $log->created_at->diffForHumans() }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">User Agent</div>
                                        <div class="info-value" style="font-size: 12px;">{{ Str::limit($log->user_agent, 100) ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Changed Fields --}}
                    @if($log->changed_fields && count($log->changed_fields) > 0)
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <h5><i class="fa fa-exchange-alt mr-2"></i> Changed Fields ({{ count($log->changed_fields) }})</h5>
                        </div>
                        <div class="detail-card-body">
                            <div class="diff-container">
                                {{-- Old Values --}}
                                <div class="diff-column old">
                                    <div class="diff-title old"><i class="fa fa-minus-circle mr-1"></i> Previous Values</div>
                                    @foreach($log->changed_fields as $field)
                                    <div class="field-change">
                                        <div class="field-name">{{ str_replace('_', ' ', $field) }}</div>
                                        <div class="field-value old">
                                            @php
                                                $oldValue = $log->old_values[$field] ?? null;
                                                if (is_array($oldValue)) {
                                                    $oldValue = json_encode($oldValue, JSON_PRETTY_PRINT);
                                                } elseif (is_bool($oldValue)) {
                                                    $oldValue = $oldValue ? 'true' : 'false';
                                                } elseif (is_null($oldValue)) {
                                                    $oldValue = '(empty)';
                                                }
                                            @endphp
                                            {{ Str::limit($oldValue, 200) }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                {{-- New Values --}}
                                <div class="diff-column new">
                                    <div class="diff-title new"><i class="fa fa-plus-circle mr-1"></i> New Values</div>
                                    @foreach($log->changed_fields as $field)
                                    <div class="field-change">
                                        <div class="field-name">{{ str_replace('_', ' ', $field) }}</div>
                                        <div class="field-value new">
                                            @php
                                                $newValue = $log->new_values[$field] ?? null;
                                                if (is_array($newValue)) {
                                                    $newValue = json_encode($newValue, JSON_PRETTY_PRINT);
                                                } elseif (is_bool($newValue)) {
                                                    $newValue = $newValue ? 'true' : 'false';
                                                } elseif (is_null($newValue)) {
                                                    $newValue = '(empty)';
                                                }
                                            @endphp
                                            {{ Str::limit($newValue, 200) }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Full Data (Collapsible) --}}
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <h5>
                                <a data-toggle="collapse" href="#fullDataCollapse" role="button" aria-expanded="false">
                                    <i class="fa fa-code mr-2"></i> Full Data (JSON) <i class="fa fa-chevron-down ml-2"></i>
                                </a>
                            </h5>
                        </div>
                        <div class="collapse" id="fullDataCollapse">
                            <div class="detail-card-body">
                                <div class="row">
                                    @if($log->old_values)
                                    <div class="col-md-6">
                                        <h6 class="text-danger mb-2"><i class="fa fa-minus-circle mr-1"></i> Old Values</h6>
                                        <div class="json-viewer">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</div>
                                    </div>
                                    @endif
                                    @if($log->new_values)
                                    <div class="col-md-6">
                                        <h6 class="text-success mb-2"><i class="fa fa-plus-circle mr-1"></i> New Values</h6>
                                        <div class="json-viewer">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
