@extends('admin::layouts.master')
@section('title', 'Portfolio Information')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
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
    /* Fast Modal Animations */
    .modal.fade .modal-dialog {
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
        transform: translate(0, -30px);
        opacity: 0;
    }
    
    .modal.show .modal-dialog {
        transform: translate(0, 0);
        opacity: 1;
    }
    
    .modal-backdrop.fade {
        transition: opacity 0.15s ease-out;
    }
    
    .modal-backdrop.show {
        opacity: 0.5;
    }
    
    /* Notification Animation */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.02);
        }
    }
    
    #notification-area .alert {
        animation: slideInDown 0.3s ease-out;
    }
    
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .portfolio-show-container {
        display: flex;
        gap: 20px;
        min-height: 600px;
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
    
    .portfolio-main-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .portfolio-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .portfolio-meta-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .portfolio-meta-item:last-child {
        border-bottom: none;
    }
    
    .portfolio-meta-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .portfolio-meta-value {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 500;
    }
    
    /* Right Section Styles */
    .right-section {
        flex: 1;
        display: flex;
        gap: 15px;
    }
    
    /* Vertical Tabs Styles */
    .vertical-tabs {
        flex: 0 0 220px;
        background: #fff;
        border-radius: 8px;
        padding: 15px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        height: fit-content;
    }
    
    .vertical-tab-item {
        padding: 15px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        color: #5a6c7d;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .vertical-tab-item:hover {
        background: #f8f9fa;
        color: #2c3e50;
    }
    
    .vertical-tab-item.active {
        background: #e3f2fd;
        border-left-color: #2196F3;
        color: #2196F3;
        font-weight: 600;
    }
    
    .vertical-tab-item i {
        font-size: 16px;
        width: 20px;
    }
    
    /* Tab Content Styles */
    .tab-content-area {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .tab-pane {
        display: none;
        animation: fadeIn 0.3s ease-in;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .tab-content-title {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .info-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: #5a6c7d;
        font-size: 14px;
    }
    
    .info-value {
        flex: 1;
        color: #2c3e50;
        font-size: 14px;
    }
    
    .image-preview {
        max-width: 100%;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .image-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    /* Lightbox Styles */
    .lightbox-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease;
    }
    
    .lightbox-overlay.active {
        display: flex;
    }
    
    .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
        animation: zoomIn 0.3s ease;
    }
    
    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
    }
    
    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        color: white;
        font-size: 36px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    
    .lightbox-close:hover {
        transform: rotate(90deg);
    }
    
    .lightbox-caption {
        position: absolute;
        bottom: -40px;
        left: 0;
        right: 0;
        color: white;
        text-align: center;
        font-size: 16px;
        padding: 10px;
    }
    
    @keyframes zoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    .image-grid {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin-top: 15px;
    }
    
    .image-item {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding: 20px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .image-item:last-child {
        border-bottom: none;
    }
    
    .image-item-label {
        font-weight: 600;
        color: #5a6c7d;
        font-size: 14px;
        min-width: 120px;
        flex-shrink: 0;
    }
    
    .image-item-content {
        flex: 1;
    }
    
    .description-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        margin-top: 10px;
        line-height: 1.6;
    }
    
    @media (max-width: 992px) {
        .portfolio-show-container {
            flex-direction: column;
        }
        
        .left-section {
            flex: 1;
            position: relative;
            top: 0;
        }
        
        .right-section {
            flex-direction: column;
        }
        
        .vertical-tabs {
            flex: 1;
            display: flex;
            overflow-x: auto;
            padding: 0;
        }
        
        .vertical-tab-item {
            border-left: none;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }
        
        .vertical-tab-item.active {
            border-left: none;
            border-bottom-color: #2196F3;
        }
    }
</style>
@endsection
@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('portfolio.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Portfolios</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Portfolio Details</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <!-- Success/Error Messages -->
            <div id="notification-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                        <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                        <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong>
                        <ul class="mb-0" style="margin-top: 10px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            
            <!-- Header with Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mt-0 mb-0 header-title">Portfolio Details</h4>
                <div class="buttons">
                    <a href="{{ route('portfolio.index') }}" class="mr-2">
                        <button class="btn btn-new"><i class="fa fa-list"></i> Portfolios List</button>
                    </a>
                    <a href="{{ route('portfolio.edit', ['id' => $portfolio->id]) }}" class="mr-2">
                        <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit Portfolio</button>
                    </a>
                    <button class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fa fa-angle-left"></i> Back
                    </button>
                </div>
            </div>
            
            <!-- Main Content Layout -->
            <div class="portfolio-show-container">
                
                <!-- Left Section -->
                <div class="left-section">
                    @if($portfolio->main_image)
                        <img src="{{url('/storage' . $portfolio->main_image)}}" alt="{{ $portfolio->title_english }}" class="portfolio-main-image">
                    @else
                        <div class="portfolio-main-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fa fa-image" style="font-size: 48px;"></i>
                        </div>
                    @endif
                    
                    <h3 class="portfolio-title">
                        @if(App::getLocale() == 'en')
                            {{ $portfolio->title_english }}
                        @else
                            {{ $portfolio->title_arabic }}
                        @endif
                    </h3>
                    
                    <div class="portfolio-meta-item">
                        <div class="portfolio-meta-label">Client Name</div>
                        <div class="portfolio-meta-value">
                            <i class="fa fa-user"></i> {{ $portfolio->client_name }}
                        </div>
                    </div>
                    
                    <div class="portfolio-meta-item">
                        <div class="portfolio-meta-label">Portfolio Type</div>
                        <div class="portfolio-meta-value">
                            @if(App::getLocale() == 'en')
                                {{ $portfolio->type_name_english }}
                            @else
                                {{ $portfolio->type_name_arabic }}
                            @endif
                        </div>
                    </div>
                    
                    <div class="portfolio-meta-item">
                        <div class="portfolio-meta-label">Date</div>
                        <div class="portfolio-meta-value">
                            <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($portfolio->date)->format('M d, Y') }}
                        </div>
                    </div>
                    
                    <div class="portfolio-meta-item">
                        <div class="portfolio-meta-label">Publish Status</div>
                        <div class="portfolio-meta-value">
                            @if($portfolio->status == 0)
                                <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                            @else
                                <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Not Published</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="portfolio-meta-item">
                        <div class="portfolio-meta-label">Home Status</div>
                        <div class="portfolio-meta-value">
                            @if($portfolio->home_status == 0)
                                <span class="badge badge-success"><i class="fa fa-eye"></i> Shown on Home</span>
                            @else
                                <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Not Shown</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Right Section with Vertical Tabs -->
                <div class="right-section">
                    
                    <!-- Vertical Tabs Navigation -->
                    <div class="vertical-tabs">
                        <div class="vertical-tab-item active" data-tab="portfolio-info">
                            <i class="fa fa-info-circle"></i>
                            <span>Portfolio Information</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="descriptions">
                            <i class="fa fa-file-text"></i>
                            <span>Descriptions</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="images">
                            <i class="fa fa-image"></i>
                            <span>Images & Media</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="seo">
                            <i class="fa fa-search"></i>
                            <span>SEO Information</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="processes">
                            <i class="fa fa-cogs"></i>
                            <span>Processes</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="gallery">
                            <i class="fa fa-image"></i>
                            <span>Gallery</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="timestamps">
                            <i class="fa fa-clock-o"></i>
                            <span>Timestamps</span>
                        </div>
                    </div>
                    
                    <!-- Tab Content Area -->
                    <div class="tab-content-area">
                        
                        <!-- Portfolio Information Tab -->
                        <div class="tab-pane active" id="portfolio-info">
                            <h5 class="tab-content-title">Portfolio Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Portfolio ID:</div>
                                <div class="info-value">{{ $portfolio->id }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">English Title:</div>
                                <div class="info-value">{{ $portfolio->title_english }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Arabic Title:</div>
                                <div class="info-value">{{ $portfolio->title_arabic }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Client Name:</div>
                                <div class="info-value">{{ $portfolio->client_name }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Portfolio Type:</div>
                                <div class="info-value">
                                    <span class="badge badge-info">
                                        @if(App::getLocale() == 'en')
                                            {{ $portfolio->type_name_english }}
                                        @else
                                            {{ $portfolio->type_name_arabic }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Date:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($portfolio->date)->format('F d, Y') }}
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Publish Status:</div>
                                <div class="info-value">
                                    @if($portfolio->status == 0)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-danger">Not Published</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Home Status:</div>
                                <div class="info-value">
                                    @if($portfolio->home_status == 0)
                                        <span class="badge badge-success">Shown on Home</span>
                                    @else
                                        <span class="badge badge-warning">Not Shown</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Descriptions Tab -->
                        <div class="tab-pane" id="descriptions">
                            <h5 class="tab-content-title">Descriptions & Bio</h5>
                            
                            @if($portfolio->bio_english || $portfolio->bio_arabic)
                            <div class="mb-4">
                                <div class="info-label mb-2">Bio English:</div>
                                <div class="description-content">
                                    {{ $portfolio->bio_english ?? 'N/A' }}
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="info-label mb-2">Bio Arabic:</div>
                                <div class="description-content">
                                    {{ $portfolio->bio_arabic ?? 'N/A' }}
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            @endif
                            
                            <div class="mb-4">
                                <div class="info-label mb-2">Full Description English:</div>
                                <div class="description-content">
                                    {{ $portfolio->description_english }}
                                </div>
                            </div>
                            
                            <div>
                                <div class="info-label mb-2">Full Description Arabic:</div>
                                <div class="description-content">
                                    {{ $portfolio->description_arabic }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Images Tab -->
                        <div class="tab-pane" id="images">
                            <h5 class="tab-content-title">Images & Media</h5>
                            
                            <div class="image-grid">
                                <div class="image-item">
                                    <div class="image-item-label">Main Image:</div>
                                    <div class="image-item-content">
                                        @if($portfolio->main_image)
                                            <img src="{{url('/storage' . $portfolio->main_image)}}" 
                                                 class="image-preview lightbox-trigger" 
                                                 data-caption="Main Image - {{ $portfolio->title_english }}"
                                                 style="max-height: 300px; max-width: 100%;"
                                                 alt="Main Image">
                                        @else
                                            <div style="background: #e9ecef; height: 150px; width: 300px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <span class="text-muted"><i class="fa fa-image"></i> No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="image-item">
                                    <div class="image-item-label">Icon:</div>
                                    <div class="image-item-content">
                                        @if($portfolio->icon)
                                            <img src="{{url('/storage' . $portfolio->icon)}}" 
                                                 class="image-preview lightbox-trigger" 
                                                 data-caption="Portfolio Icon"
                                                 style="width: 100px; height: 100px;"
                                                 alt="Portfolio Icon">
                                        @else
                                            <div style="background: #e9ecef; height: 100px; width: 100px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <span class="text-muted"><i class="fa fa-image"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="image-item">
                                    <div class="image-item-label">Cover Image:</div>
                                    <div class="image-item-content">
                                        @if($portfolio->cover)
                                            <img src="{{url('/storage' . $portfolio->cover)}}" 
                                                 class="image-preview lightbox-trigger" 
                                                 data-caption="Cover Image - {{ $portfolio->title_english }}"
                                                 style="max-height: 250px; max-width: 100%;"
                                                 alt="Cover Image">
                                        @else
                                            <div style="background: #e9ecef; height: 150px; width: 500px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <span class="text-muted"><i class="fa fa-image"></i> No Cover Image</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SEO Tab -->
                        <div class="tab-pane" id="seo">
                            <h5 class="tab-content-title">SEO Information</h5>
                            
                            @if($portfolio->seo_tags || $portfolio->seo_description_english || $portfolio->seo_description_arabic)
                                @if($portfolio->seo_tags)
                                <div class="info-row">
                                    <div class="info-label">SEO Tags:</div>
                                    <div class="info-value">{{ $portfolio->seo_tags }}</div>
                                </div>
                                @endif
                                
                                @if($portfolio->seo_description_english)
                                <div class="info-row">
                                    <div class="info-label">SEO Description (English):</div>
                                    <div class="info-value">{{ $portfolio->seo_description_english }}</div>
                                </div>
                                @endif
                                
                                @if($portfolio->seo_description_arabic)
                                <div class="info-row">
                                    <div class="info-label">SEO Description (Arabic):</div>
                                    <div class="info-value">{{ $portfolio->seo_description_arabic }}</div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No SEO information available for this portfolio.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Processes Tab -->
                        @include('admin::portfolios.processes._index')
                        
                        <!-- Gallery Tab -->
                        <div class="tab-pane" id="gallery">
                            @include('admin::portfolios.images._index')
                        </div>
                        
                        <!-- Timestamps Tab -->
                        <div class="tab-pane" id="timestamps">
                            <h5 class="tab-content-title">Timestamps</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Created At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ $portfolio->created_at }}
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Updated At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ $portfolio->updated_at }}
                                </div>
                            </div>
                            
                            @if($portfolio->deleted_at)
                            <div class="info-row">
                                <div class="info-label">Deleted At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ $portfolio->deleted_at }}
                                </div>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Overlay -->
<div class="lightbox-overlay" id="lightbox">
    <div class="lightbox-content">
        <button class="lightbox-close" id="lightbox-close">&times;</button>
        <img src="" alt="" class="lightbox-image" id="lightbox-image">
        <div class="lightbox-caption" id="lightbox-caption"></div>
    </div>
</div>

<!-- Portfolio Process Modals -->
@include('admin::portfolios.processes._add_modal')
@include('admin::portfolios.processes._edit_modal')
@include('admin::portfolios.processes._show_modal')
@include('admin::portfolios.processes._delete_modal')

@endsection

@section('js')
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script src="{{ asset('/js/select2.min.js') }}"></script>
<script src="{{ asset('/js/image-uploader.min.js') }}"></script>
<script>
    let images = [];
    
    // Fetch existing gallery images
    fetch('/admin/portfolio-image/galleries/{{ $portfolio->id }}')
        .then(res => res.json())
        .then(data => {
            images = data;
            
            // Initialize image uploader
            $('.images').imageUploader({
                preloaded: images,
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 2 * 1024 * 1024, // 2MB
                maxFiles: 20
            });
            
            // Update gallery count
            updateGalleryCount(images.length);
        })
        .catch(error => {
            console.error('Error loading gallery:', error);
            
            // Initialize empty uploader
            $('.images').imageUploader({
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 20
            });
        });
    
    // Update gallery count badge
    function updateGalleryCount(count) {
        $('#gallery-count').text(count + ' image' + (count !== 1 ? 's' : ''));
    }
    
    // Listen for image changes
    $(document).on('DOMSubtreeModified', '.image-uploader', function() {
        const currentCount = $('.image-uploader .uploaded').length;
        updateGalleryCount(currentCount);
    });
</script>
<script>
    // Vertical Tabs Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Dropify
        $('.dropify').dropify();

        // Reinitialize Dropify when modals are shown
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.dropify').dropify();
        });

        // Destroy and reinitialize Dropify when modals are hidden
        $('.modal').on('hidden.bs.modal', function() {
            var drEvent = $(this).find('.dropify').dropify();
            drEvent = drEvent.data('dropify');
            if(drEvent) {
                drEvent.resetPreview();
                drEvent.clearElement();
            }
        });
        // Auto-scroll to notification area if there's a message
        const notificationArea = document.getElementById('notification-area');
        if (notificationArea && notificationArea.querySelector('.alert')) {
            setTimeout(function() {
                notificationArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Add a subtle animation to draw attention
                const alert = notificationArea.querySelector('.alert');
                alert.style.animation = 'pulse 0.5s ease-in-out';
            }, 200);
            
            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                const alerts = notificationArea.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    // Fade out animation
                    alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    
                    // Remove from DOM after animation
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 5000); // 5 seconds
        }
        
        const tabItems = document.querySelectorAll('.vertical-tab-item');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabItems.forEach(item => {
            item.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and panes
                tabItems.forEach(tab => tab.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding pane
                this.classList.add('active');
                document.getElementById(targetTab).classList.add('active');
            });
        });
        
        // Lightbox Functionality
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxCaption = document.getElementById('lightbox-caption');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxTriggers = document.querySelectorAll('.lightbox-trigger');
        
        // Open lightbox when clicking on images
        lightboxTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const imgSrc = this.getAttribute('src');
                const imgCaption = this.getAttribute('data-caption') || '';
                
                lightboxImage.src = imgSrc;
                lightboxCaption.textContent = imgCaption;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });
        });
        
        // Close lightbox when clicking close button
        lightboxClose.addEventListener('click', function() {
            closeLightbox();
        });
        
        // Close lightbox when clicking outside the image
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Close lightbox with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                closeLightbox();
            }
        });
        
        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = ''; // Restore scrolling
        }
        
        // Character counter for portfolio process descriptions
        const processDescCounters = document.querySelectorAll('.portfolio-process-desc-counter');
        processDescCounters.forEach(function(textarea) {
            const parent = textarea.closest('.form-group');
            const counter = parent.querySelector('.char-count-en, .char-count-ar');
            
            if (counter) {
                // Update on page load
                counter.textContent = textarea.value.length;
                
                // Update on input
                textarea.addEventListener('input', function() {
                    counter.textContent = textarea.value.length;
                });
            }
        });
        
        // Word counter for titles (max 6 words)
        // Add modal
        const addTitleEnglish = document.getElementById('add-title-english');
        const addTitleArabic = document.getElementById('add-title-arabic');
        
        if (addTitleEnglish) {
            addTitleEnglish.addEventListener('input', function() {
                const wordCount = this.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                document.getElementById('add-word-count-en').textContent = wordCount;
                
                if (wordCount > 6) {
                    document.getElementById('add-word-count-en').style.color = '#dc3545';
                } else {
                    document.getElementById('add-word-count-en').style.color = '#6c757d';
                }
            });
        }
        
        if (addTitleArabic) {
            addTitleArabic.addEventListener('input', function() {
                const wordCount = this.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                document.getElementById('add-word-count-ar').textContent = wordCount;
                
                if (wordCount > 6) {
                    document.getElementById('add-word-count-ar').style.color = '#dc3545';
                } else {
                    document.getElementById('add-word-count-ar').style.color = '#6c757d';
                }
            });
        }
        
        // Edit modals word counters
        const editTitleEnglish = document.querySelectorAll('.edit-title-english');
        const editTitleArabic = document.querySelectorAll('.edit-title-arabic');
        
        editTitleEnglish.forEach(function(input) {
            const processId = input.getAttribute('data-process-id');
            const counter = document.getElementById('edit-word-count-en-' + processId);
            
            if (counter) {
                // Update on page load
                const wordCount = input.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                counter.textContent = wordCount;
                
                // Update on input
                input.addEventListener('input', function() {
                    const wordCount = this.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                    counter.textContent = wordCount;
                    
                    if (wordCount > 6) {
                        counter.style.color = '#dc3545';
                    } else {
                        counter.style.color = '#6c757d';
                    }
                });
            }
        });
        
        editTitleArabic.forEach(function(input) {
            const processId = input.getAttribute('data-process-id');
            const counter = document.getElementById('edit-word-count-ar-' + processId);
            
            if (counter) {
                // Update on page load
                const wordCount = input.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                counter.textContent = wordCount;
                
                // Update on input
                input.addEventListener('input', function() {
                    const wordCount = this.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                    counter.textContent = wordCount;
                    
                    if (wordCount > 6) {
                        counter.style.color = '#dc3545';
                    } else {
                        counter.style.color = '#6c757d';
                    }
                });
            }
        });
        
        // Drag and Drop for Portfolio Processes Ordering
        const sortableTable = document.getElementById('sortable-portfolio-processes');
        if (sortableTable) {
            let draggedRow = null;
            
            sortableTable.addEventListener('dragstart', function(e) {
                if (e.target.tagName === 'TR') {
                    draggedRow = e.target;
                    e.target.style.opacity = '0.5';
                }
            });
            
            sortableTable.addEventListener('dragend', function(e) {
                if (e.target.tagName === 'TR') {
                    e.target.style.opacity = '';
                }
            });
            
            sortableTable.addEventListener('dragover', function(e) {
                e.preventDefault();
                const afterElement = getDragAfterElement(sortableTable, e.clientY);
                if (afterElement == null) {
                    sortableTable.appendChild(draggedRow);
                } else {
                    sortableTable.insertBefore(draggedRow, afterElement);
                }
            });
            
            sortableTable.addEventListener('drop', function(e) {
                e.preventDefault();
                updateProcessOrder();
            });
            
            function getDragAfterElement(container, y) {
                const draggableElements = [...container.querySelectorAll('tr:not(.dragging)')];
                
                return draggableElements.reduce((closest, child) => {
                    const box = child.getBoundingClientRect();
                    const offset = y - box.top - box.height / 2;
                    
                    if (offset < 0 && offset > closest.offset) {
                        return { offset: offset, element: child };
                    } else {
                        return closest;
                    }
                }, { offset: Number.NEGATIVE_INFINITY }).element;
            }
            
            function updateProcessOrder() {
                const rows = sortableTable.querySelectorAll('tr');
                const orders = [];
                
                rows.forEach(function(row) {
                    const id = row.getAttribute('data-id');
                    if (id) {
                        orders.push(id);
                    }
                });
                
                // Send AJAX request to update order
                fetch('{{ route("portfolio-process.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ orders: orders })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated order
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error updating order:', error);
                });
            }
        }
    });
</script>
@endsection
