@extends('admin::layouts.master')
@section('title', 'Project Details')

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for SweetAlert2 animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!-- Image Uploader CSS -->
<link rel="stylesheet" href="{{ asset('/css/dropify.min.css') }}">
<link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/js/image-uploader.min.js') }}"></script>
<style>
    .image-uploader {
        min-height: 200px;
    }
    #gallery-count {
        font-size: 0.9rem;
        padding: 0.25rem 0.5rem;
    }
    .project-show-container {
        display: flex;
        gap: 20px;
        min-height: 600px;
        width: 100%;
        max-width: 100%;
    }
    
    /* Left Section Styles */
    .left-section {
        flex: 0 0 350px;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    
    .project-main-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .project-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .project-meta-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .project-meta-item:last-child {
        border-bottom: none;
    }
    
    .project-meta-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .project-meta-value {
        font-size: 15px;
        color: #2c3e50;
        font-weight: 500;
    }
    
    /* Action Buttons Styles */
    .btn-block {
        transition: all 0.3s ease;
        font-weight: 500;
        border-radius: 6px;
        padding: 10px 15px;
    }
    
    .btn-block:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-block i {
        margin-right: 5px;
    }
    
    /* SweetAlert2 Custom Styling */
    .swal2-popup {
        border-radius: 12px;
        font-family: inherit;
    }
    
    .swal2-title {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .swal2-html-container {
        font-size: 16px;
        color: #6c757d;
    }
    
    .swal2-confirm, .swal2-cancel {
        border-radius: 6px;
        font-weight: 500;
        padding: 10px 24px;
        font-size: 15px;
    }
    
    .swal2-icon {
        border-width: 3px;
    }
    
    /* Toast Notification Custom Styling */
    .swal2-toast {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Right Section - Tabs */
    .right-section {
        flex: 1;
        min-width: 0;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
    }
    
    .vertical-tabs {
        flex: 0 0 200px;
        background: #f8f9fa;
        border-radius: 8px 0 0 8px;
        padding: 20px 0;
    }
    
    .tab-item {
        padding: 15px 25px;
        cursor: pointer;
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
        font-size: 14px;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .tab-item i {
        font-size: 16px;
    }
    
    .tab-item:hover {
        background: #e9ecef;
    }
    
    .tab-item.active {
        background: #fff;
        border-left-color: #007bff;
        color: #007bff;
        font-weight: 600;
    }
    
    .tab-content-area {
        flex: 1;
        min-width: 0;
        padding: 30px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .info-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: #495057;
        font-size: 14px;
    }
    
    .info-value {
        flex: 1;
        color: #6c757d;
        font-size: 14px;
    }
    
    .description-content {
        line-height: 1.8;
        color: #495057;
        font-size: 14px;
    }
    
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .image-grid-item {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .image-grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .image-grid-item:hover img {
        transform: scale(1.1);
    }
    
    .image-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: #fff;
        padding: 8px;
        font-size: 12px;
        text-align: center;
    }
    
    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        justify-content: center;
        align-items: center;
    }
    
    .lightbox.active {
        display: flex;
    }
    
    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 0 30px rgba(255,255,255,0.3);
    }
    
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 40px;
        cursor: pointer;
    }
    
    .seo-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .seo-tag {
        background: #e7f3ff;
        color: #0066cc;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        border: 1px solid #b3d9ff;
    }
    
    /* Responsive Tables Fix */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1rem;
    }
    
    .table-responsive table {
        width: 100%;
    }
    
    /* Ensure tables don't break layout */
    .tab-content-area .table-responsive {
        max-width: 100%;
    }
    
    .table-responsive th,
    .table-responsive td {
        white-space: nowrap;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('project.index')}}" class="breadcrumbs__item"><i class="fa fa-building"></i> Projects</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Project Details</a>
        </nav>

        <div class="col-12">
            <hr>
            
            
            <!-- Project Show Container -->
            <div class="project-show-container">
                
                <!-- Left Section -->
                <div class="left-section">
                    <img src="{{ asset('storage' . $project->main_image) }}" alt="{{ $project->title_english }}" class="project-main-image" onclick="openLightbox('{{ asset('storage' . $project->main_image) }}')">
                    
                    <h4 class="project-title">{{ $project->title_english }}</h4>
                    <p class="text-muted mb-3">{{ $project->title_arabic }}</p>
                    
                    @if($project->project_code)
                    <div class="project-meta-item">
                        <div class="project-meta-label">Project Code</div>
                        <div class="project-meta-value">
                            <span class="badge" style="font-size: 13px; padding: 6px 12px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); color: white;">
                                <i class="fa fa-barcode"></i> {{ $project->project_code }}
                            </span>
                        </div>
                    </div>
                    @endif
                    
                    @if($project->project_number)
                    <div class="project-meta-item">
                        <div class="project-meta-label">Project Number</div>
                        <div class="project-meta-value">
                            <span class="badge badge-secondary" style="font-size: 13px; padding: 6px 12px;">
                                <i class="fa fa-list-ol"></i> {{ $project->project_number }}
                            </span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Category</div>
                        <div class="project-meta-value">
                            @if($project->category_name_en)
                                <span class="badge badge-primary">{{ $project->category_name_en }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Type</div>
                        <div class="project-meta-value">
                            @if($project->type_name_en)
                                <span class="badge badge-info">{{ $project->type_name_en }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Publish Status</div>
                        <div class="project-meta-value">
                            @if($project->publish_status == 0)
                                <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                            @else
                                <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Unpublished</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Home Status</div>
                        <div class="project-meta-value">
                            @if($project->home_status == 0)
                                <span class="badge badge-success"><i class="fa fa-eye"></i> Shown</span>
                            @else
                                <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Hidden</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <!-- Action Buttons -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-2" style="font-size: 13px; text-transform: uppercase;">Quick Actions</h6>
                            
                            <!-- Publish Status Toggle -->
                            <form action="{{ route('project.toggle-publish', ['id' => $project->id]) }}" method="POST" class="mb-2" id="publishForm">
                                @csrf
                                @if($project->publish_status == 0)
                                    <button type="button" class="btn btn-danger btn-block" onclick="confirmPublishToggle('unpublish')">
                                        <i class="fa fa-times-circle"></i> Unpublish Project
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success btn-block" onclick="confirmPublishToggle('publish')">
                                        <i class="fa fa-check-circle"></i> Publish Project
                                    </button>
                                @endif
                            </form>
                            
                            <!-- Home Status Toggle -->
                            <form action="{{ route('project.toggle-home-feature', ['id' => $project->id]) }}" method="POST" class="mb-2" id="homeForm">
                                @csrf
                                @if($project->home_status == 0)
                                    <button type="button" class="btn btn-warning btn-block" onclick="confirmHomeToggle('hide')">
                                        <i class="fa fa-eye-slash"></i> Hide from Home
                                    </button>
                                @else
                                    <button type="button" class="btn btn-info btn-block" onclick="confirmHomeToggle('show')">
                                        <i class="fa fa-eye"></i> Show on Home
                                    </button>
                                @endif
                            </form>
                        </div>
                        
                        <hr style="border-top: 1px solid #e0e0e0; margin: 20px 0;">
                        
                        <!-- Navigation Buttons -->
                        <a href="{{ route('project.index') }}" class="btn btn-primary btn-block mb-2">
                            <i class="fa fa-list"></i> Back to List
                        </a>
                        <a href="{{ route('project.edit', ['id' => $project->id]) }}" class="btn btn-warning btn-block mb-2">
                            <i class="fa fa-pencil"></i> Edit Project
                        </a>
                        <a href="{{ url('en/projects/' . $project->slug) }}" target="_blank" class="btn btn-success btn-block" style="background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); border: none;">
                            <i class="fa fa-external-link"></i> View on Website
                        </a>
                    </div>
                </div>
                
                <!-- Right Section - Tabs -->
                <div class="right-section">
                    <div class="vertical-tabs">
                        <div class="tab-item active" data-tab="basic-info">
                            <i class="fa fa-info-circle"></i>
                            <span>Basic Info</span>
                        </div>
                        <div class="tab-item" data-tab="classifications">
                            <i class="fa fa-tags"></i>
                            <span>Classifications</span>
                        </div>
                        <div class="tab-item" data-tab="measurements">
                            <i class="fa fa-calculator"></i>
                            <span>Measurements</span>
                        </div>
                        <div class="tab-item" data-tab="images">
                            <i class="fa fa-image"></i>
                            <span>Images</span>
                        </div>
                        <div class="tab-item" data-tab="gallery">
                            <i class="fa fa-image"></i>
                            <span>Gallery</span>
                        </div>
                        <div class="tab-item" data-tab="building-components">
                            <i class="fa fa-cube"></i>
                            <span>Building Components</span>
                        </div>
                        <div class="tab-item" data-tab="floors">
                            <i class="fa fa-building"></i>
                            <span>Floors</span>
                        </div>
                        <div class="tab-item" data-tab="length-components">
                            <i class="mdi mdi-ruler"></i>
                            <span>Length Components</span>
                        </div>
                        <div class="tab-item" data-tab="income-components">
                            <i class="fa fa-dollar"></i>
                            <span>Income Components</span>
                        </div>
                        <div class="tab-item" data-tab="construction-costs">
                            <i class="fa fa-calculator"></i>
                            <span>Construction Costs</span>
                        </div>
                        <div class="tab-item" data-tab="specifications">
                            <i class="fa fa-list-alt"></i>
                            <span>Specifications</span>
                        </div>
                        <div class="tab-item" data-tab="media">
                            <i class="fa fa-film"></i>
                            <span>Media</span>
                        </div>
                        <div class="tab-item" data-tab="descriptions">
                            <i class="fa fa-align-left"></i>
                            <span>Descriptions</span>
                        </div>
                        <div class="tab-item" data-tab="seo">
                            <i class="fa fa-search"></i>
                            <span>SEO</span>
                        </div>
                        <div class="tab-item" data-tab="timestamps">
                            <i class="fa fa-clock-o"></i>
                            <span>Timestamps</span>
                        </div>
                        <div class="tab-item" data-tab="feasibility-studies">
                            <i class="fa fa-money"></i>
                            <span>Feasibility Studies</span>
                        </div>
                    </div>
                    
                    <div class="tab-content-area">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane active" id="basic-info">
                            <h5 class="mb-4 text-primary">Basic Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">ID</div>
                                <div class="info-value"><strong>#{{ $project->id }}</strong></div>
                            </div>
                            
                            @if($project->project_code)
                            <div class="info-row">
                                <div class="info-label">Project Code</div>
                                <div class="info-value">
                                    <span class="badge badge-success" style="font-size: 14px; padding: 8px 15px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                                        <i class="fa fa-barcode"></i> {{ $project->project_code }}
                                    </span>
                                </div>
                            </div>
                            @endif
                            
                            <div class="info-row">
                                <div class="info-label">Project Number</div>
                                <div class="info-value">
                                    @if($project->project_number)
                                        <span class="badge badge-secondary" style="font-size: 14px; padding: 8px 15px;">
                                            <i class="fa fa-list-ol"></i> {{ $project->project_number }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">English Title</div>
                                <div class="info-value">{{ $project->title_english }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Arabic Title</div>
                                <div class="info-value">{{ $project->title_arabic }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Slug</div>
                                <div class="info-value"><code>{{ $project->slug }}</code></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Location (English)</div>
                                <div class="info-value">
                                    @if($project->location_english)
                                        <i class="fa fa-map-marker text-danger"></i> {{ $project->location_english }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Location (Arabic)</div>
                                <div class="info-value">
                                    @if($project->location_arabic)
                                        <i class="fa fa-map-marker text-danger"></i> {{ $project->location_arabic }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Project Cost</div>
                                <div class="info-value">
                                    @if($project->project_cost)
                                        <strong class="text-success" style="font-size: 16px;">
                                            @if($project->currency_abbr)
                                                {{ $project->currency_abbr }} {{ number_format($project->project_cost, 2) }}
                                            @else
                                                {{ number_format($project->project_cost, 2) }}
                                            @endif
                                        </strong>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Emirate</div>
                                <div class="info-value">
                                    @if($project->emirate_name_en)
                                        <span class="badge badge-secondary">{{ $project->emirate_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Bio English</div>
                                <div class="info-value">{{ $project->bio_english ?: 'N/A' }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Bio Arabic</div>
                                <div class="info-value">{{ $project->bio_arabic ?: 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <!-- Classifications Tab -->
                        <div class="tab-pane" id="classifications">
                            <h5 class="mb-4 text-primary">Project Classifications</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Category (English)</div>
                                <div class="info-value">
                                    @if($project->category_name_en)
                                        <span class="badge badge-primary">{{ $project->category_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Category (Arabic)</div>
                                <div class="info-value">
                                    @if($project->category_name_ar)
                                        <span class="badge badge-primary">{{ $project->category_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Subcategory (English)</div>
                                <div class="info-value">
                                    @if($project->subcategory_name_en)
                                        <span class="badge badge-secondary">{{ $project->subcategory_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Subcategory (Arabic)</div>
                                <div class="info-value">
                                    @if($project->subcategory_name_ar)
                                        <span class="badge badge-secondary">{{ $project->subcategory_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Type (English)</div>
                                <div class="info-value">
                                    @if($project->type_name_en)
                                        <span class="badge badge-info">{{ $project->type_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Type (Arabic)</div>
                                <div class="info-value">
                                    @if($project->type_name_ar)
                                        <span class="badge badge-info">{{ $project->type_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Style (English)</div>
                                <div class="info-value">
                                    @if($project->style_name_en)
                                        <span class="badge badge-success">{{ $project->style_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Style (Arabic)</div>
                                <div class="info-value">
                                    @if($project->style_name_ar)
                                        <span class="badge badge-success">{{ $project->style_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Currency</div>
                                <div class="info-value">
                                    @if($project->currency_name_en && $project->currency_abbr)
                                        <span class="badge badge-warning">{{ $project->currency_name_en }} ({{ $project->currency_abbr }})</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Partner (English)</div>
                                <div class="info-value">
                                    @if($project->partner_name_en)
                                        <span class="badge badge-dark">{{ $project->partner_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Partner (Arabic)</div>
                                <div class="info-value">
                                    @if($project->partner_name_ar)
                                        <span class="badge badge-dark">{{ $project->partner_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Measurements Tab -->
                        <div class="tab-pane" id="measurements">
                            <h5 class="mb-4 text-primary">Area Measurements</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Square Feet (SQFT)</div>
                                <div class="info-value">
                                    @if($project->sqft)
                                        <strong>{{ number_format($project->sqft, 2) }}</strong> sqft
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Square Meters (SQM)</div>
                                <div class="info-value">
                                    @if($project->sqm)
                                        <strong>{{ number_format($project->sqm, 2) }}</strong> m²
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($project->sqft && $project->sqm)
                            <div class="alert alert-info mt-3">
                                <i class="fa fa-info-circle"></i> <strong>Conversion:</strong> 1 SQFT = 0.092903 SQM
                            </div>
                            @endif
                        </div>
                        
                        <!-- Media Tab -->
                        <div class="tab-pane" id="media">
                            <h5 class="mb-4 text-primary">Media URLs</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Video URL</div>
                                <div class="info-value">
                                    @if($project->video_url)
                                        <a href="{{ $project->video_url }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-youtube-play"></i> Watch Video
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Virtual Tour URL</div>
                                <div class="info-value">
                                    @if($project->tour_url)
                                        <a href="{{ $project->tour_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-external-link"></i> View Tour
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Images Tab -->
                        <div class="tab-pane" id="images">
                            <h5 class="mb-4 text-primary">Project Images</h5>
                            
                            <div class="image-grid">
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $project->main_image) }}')">
                                    <img src="{{ asset('storage' . $project->main_image) }}" alt="Main Image">
                                    <div class="image-label">Main Image (1080x1080)</div>
                                </div>
                                
                                {{-- Cover Image and Page Image are hidden for now but fields remain in database --}}
                                {{--
                                @if($project->cover_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $project->cover_image) }}')">
                                    <img src="{{ asset('storage' . $project->cover_image) }}" alt="Cover Image">
                                    <div class="image-label">Cover Image (1890x420)</div>
                                </div>
                                @endif
                                
                                @if($project->page_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $project->page_image) }}')">
                                    <img src="{{ asset('storage' . $project->page_image) }}" alt="Page Image">
                                    <div class="image-label">Page Image (868x450)</div>
                                </div>
                                @endif
                                --}}
                                
                                @if($project->site_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $project->site_image) }}')">
                                    <img src="{{ asset('storage' . $project->site_image) }}" alt="Site Image">
                                    <div class="image-label">Site Image (1080x1080)</div>
                                </div>
                                @endif
                                
                                @if($project->plan_2d_image)
                                <div class="image-grid-item" style="cursor: pointer;" onclick="window.open('{{ asset('storage' . $project->plan_2d_image) }}', '_blank')">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center;">
                                        <i class="fa fa-file-pdf-o" style="font-size: 48px; margin-bottom: 15px;"></i>
                                        <div style="font-weight: 600; font-size: 16px;">Project File (PDF)</div>
                                        <div style="font-size: 12px; margin-top: 5px; opacity: 0.9;">Click to view/download</div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($project->plan_3d_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $project->plan_3d_image) }}')">
                                    <img src="{{ asset('storage' . $project->plan_3d_image) }}" alt="3D Image">
                                    <div class="image-label">3D Image (1080x1080)</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Gallery Tab -->
                        <div class="tab-pane" id="gallery">
                            @include('admin::projects.images._index')
                        </div>
                        
                        <!-- Descriptions Tab -->
                        <div class="tab-pane" id="descriptions">
                            <h5 class="mb-4 text-primary">Descriptions</h5>
                            
                            <h6 class="text-secondary mt-4 mb-3">English Description</h6>
                            <div class="description-content">
                                @if($project->description_english)
                                    {!! $project->description_english !!}
                                @else
                                    <p class="text-muted">No English description available.</p>
                                @endif
                            </div>
                            
                            <hr class="my-4">
                            
                            <h6 class="text-secondary mb-3">Arabic Description</h6>
                            <div class="description-content" dir="rtl">
                                @if($project->description_arabic)
                                    {!! $project->description_arabic !!}
                                @else
                                    <p class="text-muted">لا يوجد وصف بالعربية</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- SEO Tab -->
                        <div class="tab-pane" id="seo">
                            <h5 class="mb-4 text-primary">SEO Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Tags</div>
                                <div class="info-value">
                                    @if($project->seo_tags)
                                        <div class="seo-tags">
                                            @foreach(explode(',', $project->seo_tags) as $tag)
                                                <span class="seo-tag">{{ trim($tag) }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No tags</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Description (English)</div>
                                <div class="info-value">{{ $project->seo_description_english ?: 'N/A' }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Description (Arabic)</div>
                                <div class="info-value" dir="rtl">{{ $project->seo_description_arabic ?: 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <!-- Building Components Tab -->
                        <div class="tab-pane" id="building-components">
                            @include('admin::projects.buildingcomponents._index')
                        </div>
                        
                        <!-- Floors Tab -->
                        <div class="tab-pane" id="floors">
                            @include('admin::projects.floors._list')
                        </div>
                        
                        <!-- Income Components Tab -->
                        <div class="tab-pane" id="income-components">
                            @include('admin::projects.incomecomponents._index')
                        </div>
                        
                        <!-- Length Components Tab -->
                        <div class="tab-pane" id="length-components">
                            @include('admin::projects.lengthcomponents._index')
                        </div>
                        
                        <!-- Construction Costs Tab -->
                        <div class="tab-pane" id="construction-costs">
                            @include('admin::projects.constructioncosts._index')
                        </div>
                        
                        <!-- Specifications Tab -->
                        <div class="tab-pane" id="specifications">
                            @include('admin::projects.specifications._index')
                        </div>
                        
                        <!-- Timestamps Tab -->
                        <div class="tab-pane" id="timestamps">
                            <h5 class="mb-4 text-primary">Timestamps</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Created At</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($project->created_at)->format('F d, Y \a\t h:i A') }}
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }})</small>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Updated At</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($project->updated_at)->format('F d, Y \a\t h:i A') }}
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($project->updated_at)->diffForHumans() }})</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Feasibility Studies Tab -->
                        <div class="tab-pane" id="feasibility-studies">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary mb-0">
                                    <i class="fa fa-chart-line"></i> Feasibility Studies
                                </h5>
                                
                                <!-- Website Visibility Toggle -->
                                <div>
                                    <form action="{{ route('project.toggle-feasibility-studies', ['id' => $project->id]) }}" method="POST" style="display:inline;" id="toggleFSForm">
                                        @csrf
                                        @if($project->show_feasibility_studies == 0)
                                            <button type="button" class="btn btn-sm btn-success" onclick="confirmToggleFS('hide')" title="Feasibility Studies are currently visible on website">
                                                <i class="fa fa-eye"></i> Visible on Website
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-warning" onclick="confirmToggleFS('show')" title="Feasibility Studies are currently hidden from website">
                                                <i class="fa fa-eye-slash"></i> Hidden from Website
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <a href="{{ route('feasibility-study.create', ['projectId' => $project->id]) }}" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Create New Feasibility Study
                                </a>
                                <a href="{{ route('feasibility-study.index') }}" class="btn btn-primary">
                                    <i class="fa fa-list"></i> View All Studies
                                </a>
                            </div>
                            
                            @php
                                use App\Models\FeasibilityStudy;
                                $feasibilityStudies = FeasibilityStudy::getByProject($project->id);
                            @endphp
                            
                            @if($feasibilityStudies && $feasibilityStudies->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Study Name</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Created Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($feasibilityStudies as $study)
                                            <tr>
                                                <td>{{ $study->id }}</td>
                                                <td><strong>{{ $study->study_name }}</strong></td>
                                                <td>
                                                    @if($study->study_type == 'Master')
                                                        <span class="badge badge-warning"><i class="fa fa-star"></i> Master</span>
                                                    @else
                                                        <span class="badge badge-primary"><i class="fa fa-edit"></i> Custom</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($study->status == 'Active')
                                                        <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                                    @elseif($study->status == 'Draft')
                                                        <span class="badge badge-warning"><i class="fa fa-file"></i> Draft</span>
                                                    @else
                                                        <span class="badge badge-secondary"><i class="fa fa-archive"></i> Archived</span>
                                                    @endif
                                                </td>
                                                <td>{{ $study->creator_name ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($study->created_at)->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('feasibility-study.show', ['id' => $study->id]) }}" 
                                                           class="btn btn-sm btn-info" title="View Study">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('feasibility-study.edit', ['id' => $study->id]) }}" 
                                                           class="btn btn-sm btn-warning" title="Edit Study">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        @if($study->study_type != 'Master')
                                                        <form action="{{ route('feasibility-study.delete', ['id' => $study->id]) }}" method="POST" style="display:inline;" class="delete-fs-form">
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger delete-fs-btn" title="Delete Study" 
                                                                    data-study-id="{{ $study->id }}" data-study-name="{{ $study->study_name }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No feasibility studies created for this project yet.
                                    <a href="{{ route('feasibility-study.create', ['projectId' => $project->id]) }}">
                                        Create your first study
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <img id="lightbox-img" src="" alt="Preview">
</div>
@endsection

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/js/image-uploader.min.js') }}"></script>

<script>
    // Display success/error messages with SweetAlert2
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    @endif

    // Tab switching
    document.querySelectorAll('.tab-item').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs and panes
            document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show corresponding pane
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Lightbox functions
    function openLightbox(imgSrc) {
        document.getElementById('lightbox-img').src = imgSrc;
        document.getElementById('lightbox').classList.add('active');
    }
    
    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
    }
    
    // ===================================
    // Action Button Confirmations with SweetAlert2
    // ===================================
    
    // Confirm Publish Toggle
    function confirmPublishToggle(action) {
        const isPublishing = action === 'publish';
        
        Swal.fire({
            title: isPublishing ? 'Publish Project?' : 'Unpublish Project?',
            text: isPublishing 
                ? 'This project will be visible to the public.' 
                : 'This project will be hidden from the public.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isPublishing ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isPublishing ? '<i class="fa fa-check-circle"></i> Yes, Publish' : '<i class="fa fa-times-circle"></i> Yes, Unpublish',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Updating publish status',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('publishForm').submit();
            }
        });
    }
    
    // Confirm Home Toggle
    function confirmHomeToggle(action) {
        const isShowing = action === 'show';
        
        Swal.fire({
            title: isShowing ? 'Show on Home?' : 'Hide from Home?',
            text: isShowing 
                ? 'This project will be displayed on the home page.' 
                : 'This project will be removed from the home page.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isShowing ? '#17a2b8' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isShowing ? '<i class="fa fa-eye"></i> Yes, Show' : '<i class="fa fa-eye-slash"></i> Yes, Hide',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Updating home visibility status',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('homeForm').submit();
            }
        });
    }
    
    // Building Components JavaScript
    const projectId = {{ $project->id }};

    // Open Add Component Modal
    function openAddComponentModal() {
        // Load available components
        $.ajax({
            url: `/admin/project/${projectId}/buildingcomponents/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Building Component</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(component) {
                            options += `<option value="${component.id}">${component.name_english} - ${component.name_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No components available</option>';
                    }
                    $('#building_component_id').html(options);
                    $('#addComponentModal').modal('show');
                }
            },
            error: function() {
                showComponentAlert('error', 'Failed to load components');
            }
        });
    }

    // Add Component Form Submit
    $(document).ready(function() {
        $('#addComponentForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: `/admin/project/${projectId}/buildingcomponents/store`,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#addComponentModal').modal('hide');
                        $('#addComponentForm')[0].reset();
                        refreshComponentsList();
                        showComponentAlert('success', response.message);
                    } else {
                        showComponentAlert('error', response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to add component';
                    showComponentAlert('error', message);
                }
            });
        });

        // Edit Component Form Submit
        $('#editComponentForm').on('submit', function(e) {
            e.preventDefault();
            
            const componentId = $('#edit_component_id').val();
            
            $.ajax({
                url: `/admin/project/${projectId}/buildingcomponents/update/${componentId}`,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#editComponentModal').modal('hide');
                        refreshComponentsList();
                        showComponentAlert('success', response.message);
                    } else {
                        showComponentAlert('error', response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to update component';
                    showComponentAlert('error', message);
                }
            });
        });
    });

    // Open Edit Modal
    function openEditModal(id, name, cost) {
        $('#edit_component_id').val(id);
        $('#edit_component_name').val(name);
        $('#edit_construction_cost').val(cost);
        $('#editComponentModal').modal('show');
    }

    // Open Delete Modal
    function openDeleteModal(id, name) {
        $('#delete_component_id').val(id);
        $('#delete_component_name').text(name);
        $('#deleteComponentModal').modal('show');
    }

    // Confirm Delete
    function confirmDelete() {
        const componentId = $('#delete_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/buildingcomponents/delete/${componentId}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#deleteComponentModal').modal('hide');
                    refreshComponentsList();
                    showComponentAlert('success', response.message);
                } else {
                    showComponentAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to delete component';
                showComponentAlert('error', message);
            }
        });
    }

    // Restore Component
    function restoreComponent(id) {
        if (confirm('Are you sure you want to restore this component?')) {
            $.ajax({
                url: `/admin/project/${projectId}/buildingcomponents/restore/${id}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        refreshComponentsList();
                        showComponentAlert('success', response.message);
                    } else {
                        showComponentAlert('error', response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to restore component';
                    showComponentAlert('error', message);
                }
            });
        }
    }

    // Refresh Components List
    function refreshComponentsList() {
        $('#componentsListContainer').load(location.href + ' #componentsListContainer > *');
    }

    // Show Alert for Building Components
    function showComponentAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.building-components-section').prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.building-components-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Income Components JavaScript
    // Open Add Income Component Modal
    function openAddIncomeComponentModal() {
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Income Component</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(component) {
                            options += `<option value="${component.id}">${component.name_english} - ${component.name_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No components available</option>';
                    }
                    $('#income_component_id').html(options);
                    $('#addIncomeComponentModal').modal('show');
                }
            },
            error: function() {
                showIncomeComponentAlert('error', 'Failed to load components');
            }
        });
    }

    // Add Income Component Form Submit
    $('#addIncomeComponentForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addIncomeComponentModal').modal('hide');
                    $('#addIncomeComponentForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showIncomeComponentAlert('error', xhr.responseJSON?.message || 'Failed to add component');
            }
        });
    });

    // Open Edit Income Component Modal
    function openEditIncomeComponentModal(id, name, units, rent) {
        $('#edit_component_id').val(id);
        $('#edit_component_name').val(name);
        $('#edit_number_of_units').val(units);
        $('#edit_rent_per_year').val(rent);
        $('#editIncomeComponentModal').modal('show');
    }

    // Edit Income Component Form Submit
    $('#editIncomeComponentForm').on('submit', function(e) {
        e.preventDefault();
        const componentId = $('#edit_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/update/${componentId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editIncomeComponentModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showIncomeComponentAlert('error', xhr.responseJSON?.message || 'Failed to update component');
            }
        });
    });

    // Open Delete Income Component Modal
    function openDeleteIncomeComponentModal(id, name) {
        $('#delete_income_component_id').val(id);
        $('#delete_income_component_name').text(name);
        $('#deleteIncomeComponentModal').modal('show');
    }

    // Confirm Delete Income Component
    function confirmDeleteIncomeComponent() {
        const componentId = $('#delete_income_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/delete/${componentId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    $('#deleteIncomeComponentModal').modal('hide');
                    location.reload();
                }
            },
            error: function() {
                showIncomeComponentAlert('error', 'Failed to delete component');
            }
        });
    }

    // Restore Income Component
    function restoreIncomeComponent(id) {
        if (confirm('Are you sure you want to restore this income component?')) {
            $.ajax({
                url: `/admin/project/${projectId}/incomecomponents/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showIncomeComponentAlert('error', 'Failed to restore component');
                }
            });
        }
    }

    // Show Income Component Alert
    function showIncomeComponentAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.income-components-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.income-components-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }

    // ===================================
    // Feasibility Studies Actions
    // ===================================
    
    // Toggle Feasibility Studies Visibility on Website
    function confirmToggleFS(action) {
        const isShowing = action === 'show';
        
        Swal.fire({
            title: isShowing ? 'Show Feasibility Studies?' : 'Hide Feasibility Studies?',
            html: isShowing 
                ? 'All feasibility studies for this project will be <strong>visible on the website</strong>.' 
                : 'All feasibility studies for this project will be <strong>hidden from the website</strong>.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isShowing ? '#28a745' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isShowing ? '<i class="fa fa-eye"></i> Yes, Show on Website' : '<i class="fa fa-eye-slash"></i> Yes, Hide from Website',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Updating feasibility studies visibility',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('toggleFSForm').submit();
            }
        });
    }
    
    // Handle Delete Feasibility Study Button Click
    $(document).on('click', '.delete-fs-btn', function(e) {
        e.preventDefault();
        const studyName = $(this).data('study-name');
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Delete Feasibility Study?',
            html: `Are you sure you want to delete <strong>"${studyName}"</strong>?<br><span style="color: #dc3545; font-size: 14px;">This action will delete all associated data and cannot be undone!</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the study and all its data',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                form.submit();
            }
        });
    });
    
    // ===================================
    // Specifications JavaScript
    // ===================================
    
    // Open Add Specification Modal
    function openAddSpecificationModal() {
        $.ajax({
            url: `/admin/project/${projectId}/specifications/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Specification</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(spec) {
                            options += `<option value="${spec.id}">${spec.title_english} - ${spec.title_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No specifications available</option>';
                    }
                    $('#specification_id').html(options);
                    $('#addSpecificationModal').modal('show');
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to load specifications');
            }
        });
    }

    // Add Specification Form Submit
    $('#addSpecificationForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addSpecificationModal').modal('hide');
                    $('#addSpecificationForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showSpecificationAlert('error', xhr.responseJSON?.message || 'Failed to add specification');
            }
        });
    });

    // Open Edit Specification Modal
    function openEditSpecificationModal(id, name, valueEn, valueAr) {
        $('#edit_specification_id').val(id);
        $('#edit_specification_name').val(name);
        $('#edit_value_english').val(valueEn);
        $('#edit_value_arabic').val(valueAr);
        $('#editSpecificationModal').modal('show');
    }

    // Edit Specification Form Submit
    $('#editSpecificationForm').on('submit', function(e) {
        e.preventDefault();
        const specId = $('#edit_specification_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/update/${specId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editSpecificationModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showSpecificationAlert('error', xhr.responseJSON?.message || 'Failed to update specification');
            }
        });
    });

    // Open Delete Specification Modal
    function openDeleteSpecificationModal(id, name) {
        $('#delete_specification_id').val(id);
        $('#delete_specification_name').text(name);
        $('#deleteSpecificationModal').modal('show');
    }

    // Confirm Delete Specification
    function confirmDeleteSpecification() {
        const specId = $('#delete_specification_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/delete/${specId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    $('#deleteSpecificationModal').modal('hide');
                    location.reload();
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to delete specification');
            }
        });
    }

    // Restore Specification
    function restoreSpecification(id) {
        if (confirm('Are you sure you want to restore this specification?')) {
            $.ajax({
                url: `/admin/project/${projectId}/specifications/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showSpecificationAlert('error', 'Failed to restore specification');
                }
            });
        }
    }

    // Show Specification Alert
    function showSpecificationAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('.specifications-section').prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.specifications-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }

    // ===================================
    // Length Components JavaScript
    // ===================================
    
    // Open Add Length Component Modal
    function openAddLengthComponentModal() {
        $('#addLengthComponentModal').modal('show');
        loadAvailableBuildingComponents();
    }
    
    // Load Available Building Components (only is_length = true)
    function loadAvailableBuildingComponents() {
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/available-building-components`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = $('#building_component_id_add');
                    select.empty();
                    
                    if (response.components.length > 0) {
                        select.append('<option value="">Select Building Component</option>');
                        response.components.forEach(function(component) {
                            select.append(`<option value="${component.id}">${component.name_english}</option>`);
                        });
                    } else {
                        select.append('<option value="">No Length Building Components Available</option>');
                    }
                }
            },
            error: function() {
                showLengthComponentAlert('error', 'Failed to load building components');
            }
        });
    }
    
    // When building component changes, load length components
    $(document).on('change', '#building_component_id_add', function() {
        const buildingComponentId = $(this).val();
        const lengthSelect = $('#length_component_id_add');
        
        if (buildingComponentId) {
            $.ajax({
                url: `/admin/project/${projectId}/lengthcomponents/available-length-components`,
                method: 'GET',
                data: { building_component_id: buildingComponentId },
                success: function(response) {
                    if (response.success) {
                        lengthSelect.empty();
                        
                        if (response.components.length > 0) {
                            lengthSelect.append('<option value="">Select Length Component</option>');
                            response.components.forEach(function(component) {
                                lengthSelect.append(`<option value="${component.id}">${component.name_english}</option>`);
                            });
                            lengthSelect.prop('disabled', false);
                        } else {
                            lengthSelect.append('<option value="">No Length Components Available</option>');
                            lengthSelect.prop('disabled', true);
                        }
                    }
                },
                error: function() {
                    showLengthComponentAlert('error', 'Failed to load length components');
                }
            });
        } else {
            lengthSelect.empty();
            lengthSelect.append('<option value="">Select Building Component First</option>');
            lengthSelect.prop('disabled', true);
        }
    });
    
    // Add Length Component Form Submit
    $(document).on('submit', '#addLengthComponentForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addLengthComponentModal').modal('hide');
                    $('#addLengthComponentForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showLengthComponentAlert('error', xhr.responseJSON?.message || 'Failed to add length component');
            }
        });
    });
    
    // Open Edit Length Component Modal
    function openEditLengthModal(id, name, unitCost) {
        $('#edit_length_component_id').val(id);
        $('#edit_length_component_name').val(name);
        $('#edit_length_unit_cost').val(unitCost);
        $('#editLengthComponentModal').modal('show');
    }
    
    // Edit Length Component Form Submit
    $(document).on('submit', '#editLengthComponentForm', function(e) {
        e.preventDefault();
        const componentId = $('#edit_length_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/update/${componentId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editLengthComponentModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showLengthComponentAlert('error', xhr.responseJSON?.message || 'Failed to update length component');
            }
        });
    });
    
    // Open Delete Length Component Modal
    function openDeleteLengthModal(id, name) {
        $('#delete_length_component_id').val(id);
        $('#delete_length_component_name').text(name);
        $('#deleteLengthComponentModal').modal('show');
    }
    
    // Confirm Delete Length Component
    function confirmDeleteLengthComponent() {
        const componentId = $('#delete_length_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/delete/${componentId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#deleteLengthComponentModal').modal('hide');
                if (response.success) {
                    location.reload();
                }
            },
            error: function() {
                showLengthComponentAlert('error', 'Failed to delete length component');
            }
        });
    }
    
    // Restore Length Component
    function restoreLengthComponent(id) {
        if (confirm('Are you sure you want to restore this length component?')) {
            $.ajax({
                url: `/admin/project/${projectId}/lengthcomponents/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showLengthComponentAlert('error', 'Failed to restore length component');
                }
            });
        }
    }
    
    // Show Length Component Alert
    function showLengthComponentAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.length-components-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.length-components-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }

    // ===================================
    // Construction Costs JavaScript
    // ===================================
    
    // Open Add Construction Cost Modal
    function openAddConstructionCostModal() {
        $('#addConstructionCostModal').modal('show');
        loadAvailableFeasibilityComponents();
        loadAvailableSubstationRooms('add');
        loadAvailablePumpsRooms('add');
    }
    
    // Load Available Feasibility Study Components
    function loadAvailableFeasibilityComponents() {
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/available-feasibility-components`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = $('#feasibility_study_component_id_add');
                    select.empty();
                    
                    if (response.components.length > 0) {
                        select.append('<option value="">Select Feasibility Study Component</option>');
                        response.components.forEach(function(component) {
                            select.append(`<option value="${component.id}">${component.header_english} - ${component.title_english} (${component.target})</option>`);
                        });
                    } else {
                        select.append('<option value="">No Components Available</option>');
                    }
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to load feasibility components');
            }
        });
    }
    
    // Load Available Substation Rooms
    function loadAvailableSubstationRooms(mode) {
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/available-substation-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = mode === 'add' ? $('#substation_room_id_add') : $('#substation_room_id_edit');
                    select.empty();
                    select.append('<option value="">None</option>');
                    
                    response.rooms.forEach(function(room) {
                        select.append(`<option value="${room.id}">${room.name_english} - ${room.price}</option>`);
                    });
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to load substation rooms');
            }
        });
    }
    
    // Load Available Pumps Rooms
    function loadAvailablePumpsRooms(mode) {
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/available-pumps-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = mode === 'add' ? $('#pumps_room_id_add') : $('#pumps_room_id_edit');
                    select.empty();
                    select.append('<option value="">None</option>');
                    
                    response.rooms.forEach(function(room) {
                        select.append(`<option value="${room.id}">${room.name_english} - ${room.price}</option>`);
                    });
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to load pumps rooms');
            }
        });
    }
    
    // Add Construction Cost Form Submit
    $(document).on('submit', '#addConstructionCostForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addConstructionCostModal').modal('hide');
                    $('#addConstructionCostForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showConstructionCostAlert('error', xhr.responseJSON?.message || 'Failed to add construction cost');
            }
        });
    });
    
    // Open Edit Construction Cost Modal
    function openEditConstructionCostModal(id, substationRoomId, pumpsRoomId) {
        $('#edit_construction_cost_id').val(id);
        loadAvailableSubstationRooms('edit');
        loadAvailablePumpsRooms('edit');
        
        // Set selected values after a short delay to allow options to load
        setTimeout(function() {
            if (substationRoomId) {
                $('#substation_room_id_edit').val(substationRoomId);
            }
            if (pumpsRoomId) {
                $('#pumps_room_id_edit').val(pumpsRoomId);
            }
        }, 500);
        
        $('#editConstructionCostModal').modal('show');
    }
    
    // Edit Construction Cost Form Submit
    $(document).on('submit', '#editConstructionCostForm', function(e) {
        e.preventDefault();
        const costId = $('#edit_construction_cost_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/update/${costId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editConstructionCostModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showConstructionCostAlert('error', xhr.responseJSON?.message || 'Failed to update construction cost');
            }
        });
    });
    
    // Open Delete Construction Cost Modal
    function openDeleteConstructionCostModal(id, name) {
        $('#delete_construction_cost_id').val(id);
        $('#delete_construction_cost_name').text(name);
        $('#deleteConstructionCostModal').modal('show');
    }
    
    // Confirm Delete Construction Cost
    function confirmDeleteConstructionCost() {
        const costId = $('#delete_construction_cost_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/delete/${costId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#deleteConstructionCostModal').modal('hide');
                if (response.success) {
                    location.reload();
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to delete construction cost');
            }
        });
    }
    
    // Restore Construction Cost
    function restoreConstructionCost(id) {
        if (confirm('Are you sure you want to restore this construction cost?')) {
            $.ajax({
                url: `/admin/project/${projectId}/constructioncosts/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showConstructionCostAlert('error', 'Failed to restore construction cost');
                }
            });
        }
    }
    
    // Show Construction Cost Alert
    function showConstructionCostAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.construction-costs-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.construction-costs-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Project Gallery JavaScript
    let projectImages = [];
    
    // Fetch existing gallery images
    fetch('/admin/project-image/galleries/{{ $project->id }}')
        .then(res => res.json())
        .then(data => {
            projectImages = data;
            
            // Initialize image uploader
            $('.images').imageUploader({
                preloaded: projectImages,
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 5 * 1024 * 1024, // 5MB
                maxFiles: 30,
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.webp'],
                mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']
            });
            
            // Update gallery count
            updateProjectGalleryCount(projectImages.length);
        })
        .catch(error => {
            console.error('Error loading gallery:', error);
            
            // Initialize empty uploader
            $('.images').imageUploader({
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 5 * 1024 * 1024,
                maxFiles: 30,
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.webp'],
                mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']
            });
        });
    
    // Update gallery count badge
    function updateProjectGalleryCount(count) {
        $('#gallery-count').text(count + ' image' + (count !== 1 ? 's' : ''));
    }
    
    // Update count when images are added/removed
    $(document).on('DOMSubtreeModified', '.images', function() {
        const currentCount = $('.image-uploader-images .uploaded').length;
        updateProjectGalleryCount(currentCount);
    });
</script>
@endsection

