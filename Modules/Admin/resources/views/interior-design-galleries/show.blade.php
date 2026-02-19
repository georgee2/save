@extends('admin::layouts.master')
@section('title', 'View Interior Design Gallery')

@section('css')
<style>
    /* Timestamp Cards Styles */
    .timestamp-card {
        display: flex;
        gap: 15px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #19868b;
        margin-bottom: 15px;
    }
    
    .timestamp-card.created {
        border-left-color: #28a745;
        background: linear-gradient(135deg, #f8fff9 0%, #f0fdf2 100%);
    }
    
    .timestamp-card.updated {
        border-left-color: #17a2b8;
        background: linear-gradient(135deg, #f8fcff 0%, #f0f9fd 100%);
    }
    
    .timestamp-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
        flex-shrink: 0;
    }
    
    .timestamp-card.created .timestamp-icon {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    
    .timestamp-card.updated .timestamp-icon {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
    }
    
    .timestamp-content {
        flex: 1;
    }
    
    .timestamp-title {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .timestamp-date,
    .timestamp-time,
    .timestamp-user {
        font-size: 13px;
        color: #495057;
        margin-bottom: 5px;
    }
    
    .timestamp-date i,
    .timestamp-time i,
    .timestamp-user i {
        width: 18px;
        color: #6c757d;
    }
    
    .timestamp-user {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #dee2e6;
    }
    
    .last-update-fields {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .last-update-fields .changed-field-badge,
    .changed-field-badge {
        font-size: 11px;
        padding: 4px 10px;
        background: #e9ecef;
        border-radius: 4px;
        color: #495057;
        text-transform: capitalize;
    }
    
    /* Activity Log Styles */
    .activity-log-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .activity-log-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #19868b;
        transition: all 0.2s ease;
    }
    
    .activity-log-item:hover {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .activity-log-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }
    
    .activity-log-icon.create { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
    .activity-log-icon.update { background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); }
    .activity-log-icon.delete { background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); }
    .activity-log-icon.restore { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }
    .activity-log-icon.toggle_status { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); }
    
    .activity-log-content {
        flex: 1;
        min-width: 0;
    }
    
    .activity-log-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    
    .activity-log-time {
        font-size: 12px;
        color: #6c757d;
    }
    
    .activity-log-description {
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
    }
    
    .activity-log-meta {
        display: flex;
        gap: 15px;
        font-size: 12px;
        color: #6c757d;
    }
    
    .activity-log-meta i {
        margin-right: 4px;
    }
    
    .activity-log-changes {
        margin-top: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        align-items: center;
    }
    
    .activity-log-actions {
        flex-shrink: 0;
    }
    
    .activity-log-pagination {
        display: flex;
        justify-content: center;
    }
    
    .activity-log-pagination .pagination {
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('interior-design-gallery.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Interior Design Gallery List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Gallery</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Interior Design Gallery Details</h4>
                        <div class="buttons">
                            <a href="{{ route('interior-design-gallery.edit', ['id' => $gallery->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('interior-design-gallery.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Gallery List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Basic Information</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">English Title:</label>
                                <p>{{ $gallery->title_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Arabic Title:</label>
                                <p>{{ $gallery->title_arabic }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Slug:</label>
                                <p><span class="badge badge-info">{{ $gallery->slug }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Created At:</label>
                                <p>{{ \Carbon\Carbon::parse($gallery->created_at)->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-file-text-o"></i> Bio</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bio English:</label>
                                <p>{{ $gallery->bio_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bio Arabic:</label>
                                <p>{{ $gallery->bio_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-link"></i> Relations</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Category:</label>
                                <p><span class="badge badge-primary">{{ $gallery->category->title_english ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Project Type:</label>
                                <p><span class="badge badge-info">{{ $gallery->projectType->name_english ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Project Style:</label>
                                <p>{{ $gallery->projectStyle->title_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Project:</label>
                                <p>{{ $gallery->project->title_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Emirate:</label>
                                <p>{{ $gallery->emirate->title_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-toggle-on"></i> Status</h5>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Publish Status:</label>
                                <p>
                                    @if($gallery->publish_status == 0)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">Not Published</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Home Status:</label>
                                <p>
                                    @if($gallery->home_status == 0)
                                        <span class="badge badge-success">Shown on Home</span>
                                    @else
                                        <span class="badge badge-secondary">Not Shown on Home</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Display Order:</label>
                                <p><span class="badge badge-dark">{{ $gallery->ordering }}</span></p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-image"></i> Image</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                @if($gallery->image)
                                    <div>
                                        <a data-lightbox="image" href="{{url('/storage'.$gallery->image)}}">
                                            <img style="max-width:765px; max-height: 432px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$gallery->image)}}" alt="Gallery Image">
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted">N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-search"></i> SEO Information</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Tags:</label>
                                <p>{{ $gallery->seo_tags ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description English:</label>
                                <p>{{ $gallery->seo_description_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description Arabic:</label>
                                <p>{{ $gallery->seo_description_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Timestamps & User Activity Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-clock-o"></i> Timestamps & User Activity</h5>
                        </div>
                        
                        @php
                            use App\Models\ActivityLog;
                            
                            // Get creator from activity log
                            $creatorLog = ActivityLog::where('model_type', 'App\Models\InteriorDesignGallery')
                                ->where('model_id', $gallery->id)
                                ->where('action', 'create')
                                ->first();
                            
                            // Get last updater from activity log
                            $lastUpdateLog = ActivityLog::where('model_type', 'App\Models\InteriorDesignGallery')
                                ->where('model_id', $gallery->id)
                                ->where('action', 'update')
                                ->orderBy('created_at', 'desc')
                                ->first();
                        @endphp
                        
                        <div class="col-md-6">
                            <div class="timestamp-card created">
                                <div class="timestamp-icon">
                                    <i class="fa fa-plus-circle"></i>
                                </div>
                                <div class="timestamp-content">
                                    <h6 class="timestamp-title">Created</h6>
                                    <div class="timestamp-date">
                                        <i class="fa fa-calendar"></i> 
                                        {{ \Carbon\Carbon::parse($gallery->created_at)->format('F d, Y') }}
                                    </div>
                                    <div class="timestamp-time">
                                        <i class="fa fa-clock-o"></i> 
                                        {{ \Carbon\Carbon::parse($gallery->created_at)->format('h:i A') }}
                                        <small class="text-muted">({{ \Carbon\Carbon::parse($gallery->created_at)->diffForHumans() }})</small>
                                    </div>
                                    @if($creatorLog && $creatorLog->user_name)
                                    <div class="timestamp-user">
                                        <i class="fa fa-user"></i> 
                                        <strong>{{ $creatorLog->user_name }}</strong>
                                        @if($creatorLog->user_email)
                                        <br><small class="text-muted">{{ $creatorLog->user_email }}</small>
                                        @endif
                                    </div>
                                    @else
                                    <div class="timestamp-user text-muted">
                                        <i class="fa fa-user"></i> 
                                        <em>User info not available</em>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="timestamp-card updated">
                                <div class="timestamp-icon">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <div class="timestamp-content">
                                    <h6 class="timestamp-title">Last Updated</h6>
                                    <div class="timestamp-date">
                                        <i class="fa fa-calendar"></i> 
                                        {{ \Carbon\Carbon::parse($gallery->updated_at)->format('F d, Y') }}
                                    </div>
                                    <div class="timestamp-time">
                                        <i class="fa fa-clock-o"></i> 
                                        {{ \Carbon\Carbon::parse($gallery->updated_at)->format('h:i A') }}
                                        <small class="text-muted">({{ \Carbon\Carbon::parse($gallery->updated_at)->diffForHumans() }})</small>
                                    </div>
                                    @if($lastUpdateLog && $lastUpdateLog->user_name)
                                    <div class="timestamp-user">
                                        <i class="fa fa-user"></i> 
                                        <strong>{{ $lastUpdateLog->user_name }}</strong>
                                        @if($lastUpdateLog->user_email)
                                        <br><small class="text-muted">{{ $lastUpdateLog->user_email }}</small>
                                        @endif
                                    </div>
                                    @else
                                    <div class="timestamp-user text-muted">
                                        <i class="fa fa-user"></i> 
                                        <em>No updates recorded yet</em>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($lastUpdateLog && $lastUpdateLog->changed_fields && count($lastUpdateLog->changed_fields) > 0)
                        <div class="col-md-12 mt-3">
                            <h6 class="text-muted mb-3"><i class="fa fa-list"></i> Last Update Changed Fields</h6>
                            <div class="last-update-fields">
                                @foreach($lastUpdateLog->changed_fields as $field)
                                <span class="changed-field-badge">{{ str_replace('_', ' ', $field) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <!-- Activity Log Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary mb-0"><i class="fa fa-history"></i> Activity Log</h5>
                                <a href="{{ route('admin.activity-logs.index', ['model_name' => 'Interior Gallery', 'search' => $gallery->title_english]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-external-link"></i> View All Logs
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            @php
                                $galleryLogs = ActivityLog::where('model_type', 'App\Models\InteriorDesignGallery')
                                    ->where('model_id', $gallery->id)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5, ['*'], 'activity_page');
                            @endphp
                            
                            @if($galleryLogs->count() > 0)
                                <div class="activity-log-list">
                                    @foreach($galleryLogs as $log)
                                    @php
                                        $actionInfo = $log->getActionLabel();
                                    @endphp
                                    <div class="activity-log-item">
                                        <div class="activity-log-icon {{ $log->action }}">
                                            <i class="fa {{ $actionInfo['icon'] }}"></i>
                                        </div>
                                        <div class="activity-log-content">
                                            <div class="activity-log-header">
                                                <span class="badge badge-{{ $actionInfo['color'] }}">{{ $actionInfo['label'] }}</span>
                                                <span class="activity-log-time">
                                                    <i class="fa fa-clock-o"></i> {{ $log->created_at->format('M d, Y H:i') }}
                                                    <small class="text-muted">({{ $log->created_at->diffForHumans() }})</small>
                                                </span>
                                            </div>
                                            <div class="activity-log-description">
                                                {{ $log->description }}
                                            </div>
                                            <div class="activity-log-meta">
                                                <span><i class="fa fa-user"></i> {{ $log->user_name ?? 'System' }}</span>
                                                @if($log->ip_address)
                                                <span><i class="fa fa-globe"></i> {{ $log->ip_address }}</span>
                                                @endif
                                            </div>
                                            @if($log->changed_fields && count($log->changed_fields) > 0)
                                            <div class="activity-log-changes">
                                                <small class="text-muted">Changed fields:</small>
                                                @foreach($log->changed_fields as $field)
                                                <span class="changed-field-badge">{{ str_replace('_', ' ', $field) }}</span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                        <div class="activity-log-actions">
                                            <a href="{{ route('admin.activity-logs.show', $log->id) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @if($galleryLogs->hasPages())
                                <div class="activity-log-pagination mt-3">
                                    {{ $galleryLogs->links() }}
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No activity logs recorded for this gallery item yet.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
