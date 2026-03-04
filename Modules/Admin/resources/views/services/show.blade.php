@extends('admin::layouts.master')
@section('title' , 'Service Information')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
<link rel="stylesheet" href="{{ asset('/css/dropify.min.css') }}">
<link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
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
    
    .service-show-container {
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
    
    .service-main-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .service-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .service-meta-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .service-meta-item:last-child {
        border-bottom: none;
    }
    
    .service-meta-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .service-meta-value {
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
        .service-show-container {
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
            <a href="{{route('service.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Services</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Service Details</a> 
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
                <h4 class="mt-0 mb-0 header-title">Service Details</h4>
                <div class="buttons">
                    <a href="{{ route('service.index') }}" class="mr-2">
                        <button class="btn btn-new"><i class="fa fa-list"></i> Services List</button>
                    </a>
                    <a href="{{ route('service.edit', ['id' => $Service->id]) }}" class="mr-2">
                        <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit Service</button>
                    </a>
                    <button class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fa fa-angle-left"></i> Back
                    </button>
                </div>
            </div>
            
            <!-- Main Content Layout -->
            <div class="service-show-container">
                
                <!-- Left Section -->
                <div class="left-section">
                    @if($Service->main_image)
                        <img src="{{url('/storage' . $Service->main_image)}}" alt="{{ $Service->title_english }}" class="service-main-image">
                    @else
                        <div class="service-main-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fa fa-image" style="font-size: 48px;"></i>
                        </div>
                    @endif
                    
                    <h3 class="service-title">
                        @if(App::getLocale() == 'en')
                            {{ $Service->title_english }}
                        @else
                            {{ $Service->title_arabic }}
                        @endif
                    </h3>
                    
                    <div class="service-meta-item">
                        <div class="service-meta-label">Publish Status</div>
                        <div class="service-meta-value">
                            @if($Service->publish_status == 0)
                                <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                            @else
                                <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Not Published</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="service-meta-item">
                        <div class="service-meta-label">Home Feature Status</div>
                        <div class="service-meta-value">
                            @if($Service->home_feature_status == 0)
                                <span class="badge badge-success"><i class="fa fa-eye"></i> Shown on Home</span>
                            @else
                                <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Not Shown</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Quick Action Buttons -->
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                        <h6 style="font-size: 12px; color: #7f8c8d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 15px; font-weight: 600;">
                            <i class="fa fa-bolt"></i> Quick Actions
                        </h6>
                        
                        <!-- Toggle Publish Status -->
                        <form action="{{ route('service.toggle-publish', ['id' => $Service->id]) }}" method="POST" class="mb-2">
                            @csrf
                            @if($Service->publish_status == 0)
                                <button type="submit" class="btn btn-warning btn-block waves-effect waves-light" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <i class="fa fa-times-circle"></i>
                                    <span>Unpublish Service</span>
                                </button>
                            @else
                                <button type="submit" class="btn btn-success btn-block waves-effect waves-light" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Publish Service</span>
                                </button>
                            @endif
                        </form>
                        
                        <!-- Toggle Home Feature Status -->
                        <form action="{{ route('service.toggle-home-feature', ['id' => $Service->id]) }}" method="POST">
                            @csrf
                            @if($Service->home_feature_status == 0)
                                <button type="submit" class="btn btn-secondary btn-block waves-effect waves-light" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <i class="fa fa-eye-slash"></i>
                                    <span>Hide from Home</span>
                                </button>
                            @else
                                <button type="submit" class="btn btn-info btn-block waves-effect waves-light" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <i class="fa fa-eye"></i>
                                    <span>Show on Home</span>
                                </button>
                            @endif
                        </form>
                    </div>
                    
                    <div class="service-meta-item">
                        <div class="service-meta-label">Service Type</div>
                        <div class="service-meta-value">
                            @if($Service->is_sub_service)
                                <span class="badge badge-info"><i class="fa fa-sitemap"></i> Sub Service</span>
                            @else
                                <span class="badge badge-primary"><i class="fa fa-star"></i> Main Service</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($Service->service_id && isset($Service->parent_title_en))
                    <div class="service-meta-item">
                        <div class="service-meta-label">Parent Service</div>
                        <div class="service-meta-value">
                            @if(App::getLocale() == 'en')
                                {{ $Service->parent_title_en }}
                            @else
                                {{ $Service->parent_title_ar }}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Right Section with Vertical Tabs -->
                <div class="right-section">
                    
                    <!-- Vertical Tabs Navigation -->
                    <div class="vertical-tabs">
                        <div class="vertical-tab-item active" data-tab="service-info">
                            <i class="fa fa-info-circle"></i>
                            <span>Service Information</span>
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
                        <div class="vertical-tab-item" data-tab="features">
                            <i class="fa fa-star"></i>
                            <span>Features</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="values">
                            <i class="fa fa-diamond"></i>
                            <span>Values</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="processes">
                            <i class="fa fa-cogs"></i>
                            <span>Processes</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="blocks">
                            <i class="fa fa-cube"></i>
                            <span>Custom Blocks</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="service-faqs">
                            <i class="fa fa-question-circle"></i>
                            <span>Service FAQs</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="section-ordering">
                            <i class="fa fa-sort"></i>
                            <span>Section Ordering</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="service-titles">
                            <i class="fa fa-text-width"></i>
                            <span>Service Titles</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="timestamps">
                            <i class="fa fa-clock-o"></i>
                            <span>Timestamps</span>
                        </div>
                    </div>
                    
                    <!-- Tab Content Area -->
                    <div class="tab-content-area">
                        
                        <!-- Service Information Tab -->
                        <div class="tab-pane active" id="service-info">
                            <h5 class="tab-content-title">Service Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Service ID:</div>
                                <div class="info-value">{{ $Service->id }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">English Title:</div>
                                <div class="info-value">{{ $Service->title_english }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Arabic Title:</div>
                                <div class="info-value">{{ $Service->title_arabic }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Slug:</div>
                                <div class="info-value"><code>{{ $Service->slug }}</code></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Service Type:</div>
                                <div class="info-value">
                                    @if($Service->is_sub_service)
                                        <span class="badge badge-info">Sub Service</span>
                                    @else
                                        <span class="badge badge-primary">Main Service</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($Service->service_id && isset($Service->parent_title_en))
                            <div class="info-row">
                                <div class="info-label">Parent Service:</div>
                                <div class="info-value">
                                    @if(App::getLocale() == 'en')
                                        {{ $Service->parent_title_en }}
                                    @else
                                        {{ $Service->parent_title_ar }}
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            <div class="info-row">
                                <div class="info-label">Publish Status:</div>
                                <div class="info-value">
                                    @if($Service->publish_status == 0)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-danger">Not Published</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Home Feature Status:</div>
                                <div class="info-value">
                                    @if($Service->home_feature_status == 0)
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
                            
                            <div class="mb-4">
                                <div class="info-label mb-2">Bio English:</div>
                                <div class="description-content">
                                    {{ $Service->bio_english }}
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="info-label mb-2">Bio Arabic:</div>
                                <div class="description-content">
                                    {{ $Service->bio_arabic }}
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="mb-4">
                                <div class="info-label mb-2">Full Description English:</div>
                                <div class="description-content">
                                    {!! $Service->description_english !!}
                                </div>
                            </div>
                            
                            <div>
                                <div class="info-label mb-2">Full Description Arabic:</div>
                                <div class="description-content">
                                    {!! $Service->description_arabic !!}
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
                                        @if($Service->main_image)
                                            <img src="{{url('/storage' . $Service->main_image)}}" 
                                                 class="image-preview lightbox-trigger" 
                                                 data-caption="Main Image - {{ $Service->title_english }}"
                                                 style="max-height: 250px; max-width: 100%;"
                                                 alt="Main Image">
                                        @else
                                            <div style="background: #e9ecef; height: 150px; width: 300px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <span class="text-muted"><i class="fa fa-image"></i> No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                {{-- Service Home Image - Hidden (using main image only)
                                <div class="image-item">
                                    <div class="image-item-label">Service Home Image (870x450):</div>
                                    <div class="image-item-content">
                                        @if($Service->service_home_image)
                                            <img src="{{url('/storage' . $Service->service_home_image)}}" 
                                                 class="image-preview lightbox-trigger" 
                                                 data-caption="Service Home Image - {{ $Service->title_english }}"
                                                 style="max-height: 250px; max-width: 100%;"
                                                 alt="Service Home Image">
                                        @else
                                            <div style="background: #e9ecef; height: 150px; width: 300px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <span class="text-muted"><i class="fa fa-image"></i> No Home Image</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                --}}
                                
                                <div class="image-item">
                                    <div class="image-item-label">Icon:</div>
                                    <div class="image-item-content">
                                        @if($Service->icon)
                                            <img src="{{url('/storage' . $Service->icon)}}" 
                                                 class="image-preview lightbox-trigger" 
                                                 data-caption="Service Icon"
                                                 style="width: 87px; height: 87px;"
                                                 alt="Service Icon">
                                        @else
                                            <div style="background: #e9ecef; height: 87px; width: 87px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <span class="text-muted"><i class="fa fa-image"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="image-item">
                                    <div class="image-item-label">Hero Image:</div>
                                    <div class="image-item-content">
                                        @if($Service->hero_image)
                                            <img src="{{url('/storage' . $Service->hero_image)}}" 
                                                 class="image-preview lightbox-trigger" 
                                                 data-caption="Hero Image - {{ $Service->title_english }}"
                                                 style="max-height: 250px; max-width: 100%;"
                                                 alt="Hero Image">
                                        @else
                                            <div style="background: #e9ecef; height: 150px; width: 400px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <span class="text-muted"><i class="fa fa-image"></i> No Hero Image</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SEO Tab -->
                        <div class="tab-pane" id="seo">
                            <h5 class="tab-content-title">SEO Information</h5>
                            
                            @if($Service->seo_tags || $Service->seo_des_en || $Service->seo_des_ar)
                                @if($Service->seo_tags)
                                <div class="info-row">
                                    <div class="info-label">SEO Tags:</div>
                                    <div class="info-value">{{ $Service->seo_tags }}</div>
                                </div>
                                @endif
                                
                                @if($Service->seo_des_en)
                                <div class="info-row">
                                    <div class="info-label">SEO Description (English):</div>
                                    <div class="info-value">{{ $Service->seo_des_en }}</div>
                                </div>
                                @endif
                                
                                @if($Service->seo_des_ar)
                                <div class="info-row">
                                    <div class="info-label">SEO Description (Arabic):</div>
                                    <div class="info-value">{{ $Service->seo_des_ar }}</div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No SEO information available for this service.
                                </div>
                            @endif
                        </div>
                        
                        @include('admin::services.features._index')
                        
                        @include('admin::services.values._index')
                        
                        @include('admin::services.processes._index')
                        
                        @include('admin::services.blocks._index')
                        
                        @include('admin::services.service_faqs._index')
                        
                        @include('admin::services.section_orders._index')
                        
                        <!-- Service Titles Tab -->
                        <div class="tab-pane" id="service-titles">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="tab-content-title mb-0">Service Titles Management</h5>
                                <a href="{{ route('service-title.index') }}" class="btn btn-primary waves-effect waves-light">
                                    <i class="fa fa-text-width"></i> Manage All Titles
                                </a>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> <strong>Info:</strong> Service titles are used to customize section headings across all services. You can manage them globally from the Service Titles management page.
                            </div>
                            
                            @php
                                $serviceTitles = \App\Models\ServiceTitle::orderBy('target')->get();
                            @endphp
                            
                            @if($serviceTitles->count() > 0)
                                <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Target Section</th>
                                            <th>English Title</th>
                                            <th>Arabic Title</th>
                                            <th>English Subtitle</th>
                                            <th>Arabic Subtitle</th>
                                            <th>#Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($serviceTitles as $title)
                                        <tr>
                                            <td>
                                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $title->target)) }}</span>
                                            </td>
                                            <td>{{ $title->title_english }}</td>
                                            <td>{{ $title->title_arabic }}</td>
                                            <td>{{ $title->subtitle_english ?? '-' }}</td>
                                            <td>{{ $title->subtitle_arabic ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('service-title.edit', ['id' => $title->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i> No service titles configured yet. <a href="{{ route('service-title.create') }}">Create one now</a>.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Timestamps Tab -->
                        <div class="tab-pane" id="timestamps">
                            <h5 class="tab-content-title">Timestamps</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Created At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ $Service->created_at }}
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Updated At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ $Service->updated_at }}
                                </div>
                            </div>
                            
                            @if($Service->deleted_at)
                            <div class="info-row">
                                <div class="info-label">Deleted At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ $Service->deleted_at }}
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

<!-- Feature Modals -->
@include('admin::services.features._add_modal')
@include('admin::services.features._show_modal')
@include('admin::services.features._edit_modal')
@include('admin::services.features._delete_modal')

<!-- Value Modals -->
@include('admin::services.values._add_modal')
@include('admin::services.values._show_modal')
@include('admin::services.values._edit_modal')
@include('admin::services.values._delete_modal')

<!-- Process Modals -->
@include('admin::services.processes._add_modal')
@include('admin::services.processes._show_modal')
@include('admin::services.processes._edit_modal')
@include('admin::services.processes._delete_modal')

<!-- Block Modals -->
@include('admin::services.blocks._add_modal')
@include('admin::services.blocks._show_modal')
@include('admin::services.blocks._edit_modal')
@include('admin::services.blocks._delete_modal')

<!-- Service FAQ Modals -->
@include('admin::services.service_faqs._add_modal')
@include('admin::services.service_faqs._show_modal')
@include('admin::services.service_faqs._delete_modal')

@endsection

@section('js')
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script src="{{ asset('/js/select2.min.js') }}"></script>
<script>
    // Vertical Tabs Functionality
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Character Counter for Feature Descriptions (500 chars)
        function updateFeatureCharCount(textarea) {
            const charCount = textarea.value.length;
            const modal = textarea.closest('.modal');
            const isEnglish = textarea.name === 'description_english';
            const counterSpan = modal.querySelector(isEnglish ? '.char-count-en' : '.char-count-ar');
            if (counterSpan) {
                counterSpan.textContent = charCount;
                // Change color if approaching limit (500 chars)
                if (charCount > 450) {
                    counterSpan.style.color = '#d9534f';
                    counterSpan.style.fontWeight = 'bold';
                } else if (charCount > 400) {
                    counterSpan.style.color = '#f0ad4e';
                } else {
                    counterSpan.style.color = '#6c757d';
                    counterSpan.style.fontWeight = 'normal';
                }
            }
        }
        
        // Character Counter for Value Descriptions (1000 chars)
        function updateValueCharCount(textarea) {
            const charCount = textarea.value.length;
            const modal = textarea.closest('.modal');
            const isEnglish = textarea.name === 'description_english';
            const counterSpan = modal.querySelector(isEnglish ? '.char-count-en' : '.char-count-ar');
            if (counterSpan) {
                counterSpan.textContent = charCount;
                // Change color if approaching limit (1000 chars)
                if (charCount > 900) {
                    counterSpan.style.color = '#d9534f';
                    counterSpan.style.fontWeight = 'bold';
                } else if (charCount > 800) {
                    counterSpan.style.color = '#f0ad4e';
                } else {
                    counterSpan.style.color = '#6c757d';
                    counterSpan.style.fontWeight = 'normal';
                }
            }
        }
        
        // Character Counter for Process Descriptions (1000 chars)
        function updateProcessCharCount(textarea) {
            const charCount = textarea.value.length;
            const modal = textarea.closest('.modal');
            const isEnglish = textarea.name === 'description_english';
            const counterSpan = modal.querySelector(isEnglish ? '.char-count-en' : '.char-count-ar');
            if (counterSpan) {
                counterSpan.textContent = charCount;
                // Change color if approaching limit (1000 chars)
                if (charCount > 900) {
                    counterSpan.style.color = '#d9534f';
                    counterSpan.style.fontWeight = 'bold';
                } else if (charCount > 800) {
                    counterSpan.style.color = '#f0ad4e';
                } else {
                    counterSpan.style.color = '#6c757d';
                    counterSpan.style.fontWeight = 'normal';
                }
            }
        }
        
        // Add event listeners to all description textareas
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('feature-desc-counter')) {
                updateFeatureCharCount(e.target);
            } else if (e.target.classList.contains('value-desc-counter')) {
                updateValueCharCount(e.target);
            } else if (e.target.classList.contains('process-desc-counter')) {
                updateProcessCharCount(e.target);
            }
        });
        
        // Initialize character counters when modals are shown
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.feature-desc-counter').each(function() {
                updateFeatureCharCount(this);
            });
            $(this).find('.value-desc-counter').each(function() {
                updateValueCharCount(this);
            });
            $(this).find('.process-desc-counter').each(function() {
                updateProcessCharCount(this);
            });
        });
        
        // Drag and Drop Ordering for Processes
        const sortableProcesses = document.getElementById('sortable-processes');
        if (sortableProcesses) {
            let isDragging = false;
            let draggedRow = null;
            
            // Add dragstart event to all rows
            sortableProcesses.querySelectorAll('tr').forEach(row => {
                row.setAttribute('draggable', 'true');
                
                row.addEventListener('dragstart', function(e) {
                    isDragging = true;
                    draggedRow = this;
                    this.style.opacity = '0.5';
                    e.dataTransfer.effectAllowed = 'move';
                });
                
                row.addEventListener('dragend', function(e) {
                    isDragging = false;
                    this.style.opacity = '1';
                });
                
                row.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    if (isDragging && draggedRow !== this) {
                        const rect = this.getBoundingClientRect();
                        const midpoint = rect.top + rect.height / 2;
                        if (e.clientY < midpoint) {
                            this.parentNode.insertBefore(draggedRow, this);
                        } else {
                            this.parentNode.insertBefore(draggedRow, this.nextSibling);
                        }
                    }
                });
            });
            
            // Save order on drop
            sortableProcesses.addEventListener('dragend', function() {
                const rows = sortableProcesses.querySelectorAll('tr');
                const orderData = [];
                rows.forEach(row => {
                    orderData.push(row.getAttribute('data-id'));
                });
                
                // Send AJAX request to update order
                fetch('{{ route("service-process.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ orders: orderData })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success notification briefly
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success alert-dismissible fade show';
                        alert.style.position = 'fixed';
                        alert.style.top = '20px';
                        alert.style.right = '20px';
                        alert.style.zIndex = '9999';
                        alert.innerHTML = '<i class="fa fa-check-circle"></i> Order updated successfully!';
                        document.body.appendChild(alert);
                        
                        setTimeout(() => {
                            alert.style.transition = 'opacity 0.5s';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }, 2000);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        }
        
        // Character Counter for Block Descriptions (1500 chars)
        function updateBlockCharCount(textarea) {
            const charCount = textarea.value.length;
            const modal = textarea.closest('.modal');
            const isEnglish = textarea.name === 'description_english';
            const counterSpan = modal.querySelector(isEnglish ? '.char-count-en' : '.char-count-ar');
            if (counterSpan) {
                counterSpan.textContent = charCount;
                // Change color if approaching limit (1500 chars)
                if (charCount > 1350) {
                    counterSpan.style.color = '#d9534f';
                    counterSpan.style.fontWeight = 'bold';
                } else if (charCount > 1200) {
                    counterSpan.style.color = '#f0ad4e';
                } else {
                    counterSpan.style.color = '#6c757d';
                    counterSpan.style.fontWeight = 'normal';
                }
            }
        }
        
        // Update character counter event listener
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('block-desc-counter')) {
                updateBlockCharCount(e.target);
            }
        });
        
        // Dynamic Block Type Form Fields - Add Modal
        const addBlockType = document.getElementById('add-block-type');
        if (addBlockType) {
            addBlockType.addEventListener('change', function() {
                const blockType = this.value;
                const modal = this.closest('.modal');
                const descFields = modal.querySelectorAll('.description-field');
                const imageField = modal.querySelector('.image-field');
                const imageInput = modal.querySelector('#add-block-image');
                const requiredIndicators = modal.querySelectorAll('.required-indicator');
                const imageRequiredIndicator = modal.querySelector('.image-required-indicator');
                const imageSizeHint = modal.querySelector('.image-size-hint');
                const descTextareas = modal.querySelectorAll('textarea[name^="description_"]');
                
                if (blockType === 'banner') {
                    // Banner: Hide descriptions, show image (required)
                    descFields.forEach(field => field.style.display = 'none');
                    descTextareas.forEach(textarea => {
                        textarea.removeAttribute('required');
                        textarea.value = '';
                    });
                    requiredIndicators.forEach(ind => ind.style.display = 'none');
                    
                    imageField.style.display = 'block';
                    imageInput.setAttribute('required', 'required');
                    imageRequiredIndicator.innerHTML = '<i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i>';
                    imageSizeHint.textContent = 'Recommended size: 1200x400px (Banner)';
                    
                } else if (blockType === 'image_with_text') {
                    // Image with Text: Show descriptions (required), show image (required)
                    descFields.forEach(field => field.style.display = 'block');
                    descTextareas.forEach(textarea => textarea.setAttribute('required', 'required'));
                    requiredIndicators.forEach(ind => ind.style.display = 'inline');
                    
                    imageField.style.display = 'block';
                    imageInput.setAttribute('required', 'required');
                    imageRequiredIndicator.innerHTML = '<i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i>';
                    imageSizeHint.textContent = 'Recommended size: 600x400px';
                    
                } else {
                    // No type selected: Hide all
                    descFields.forEach(field => field.style.display = 'none');
                    imageField.style.display = 'none';
                    descTextareas.forEach(textarea => textarea.removeAttribute('required'));
                    imageInput.removeAttribute('required');
                }
            });
        }
        
        // Dynamic Block Type Form Fields - Edit Modals
        document.querySelectorAll('.edit-block-type').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const blockType = this.value;
                const modal = this.closest('.modal');
                const descFields = modal.querySelectorAll('.description-field');
                const requiredIndicators = modal.querySelectorAll('.required-indicator');
                const imageSizeHint = modal.querySelector('.image-size-hint');
                const descTextareas = modal.querySelectorAll('textarea[name^="description_"]');
                
                if (blockType === 'banner') {
                    // Banner: Hide descriptions
                    descFields.forEach(field => field.style.display = 'none');
                    descTextareas.forEach(textarea => {
                        textarea.removeAttribute('required');
                    });
                    requiredIndicators.forEach(ind => ind.style.display = 'none');
                    imageSizeHint.textContent = 'Recommended size: 1200x400px (Banner)';
                    
                } else if (blockType === 'image_with_text') {
                    // Image with Text: Show descriptions (required)
                    descFields.forEach(field => field.style.display = 'block');
                    descTextareas.forEach(textarea => textarea.setAttribute('required', 'required'));
                    requiredIndicators.forEach(ind => ind.style.display = 'inline');
                    imageSizeHint.textContent = 'Recommended size: 600x400px';
                }
            });
        });
        
        // Initialize character counters for blocks when modals are shown
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.block-desc-counter').each(function() {
                updateBlockCharCount(this);
            });
        });
        
        // Initialize Select2 for FAQ dropdown
        if ($('#faq-select').length) {
            $('#faq-select').select2({
                placeholder: '-- Select FAQ --',
                allowClear: true,
                width: '100%',
                dropdownParent: $('.bs-add-service-faq-modal')
            });
        }
        
        // FAQ Preview Functionality
        const faqSelect = document.getElementById('faq-select');
        if (faqSelect) {
            // Use jQuery change event for Select2
            $('#faq-select').on('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const preview = document.getElementById('faq-preview');
                
                if (this.value) {
                    // Show preview
                    preview.style.display = 'block';
                    
                    // Update preview content
                    document.getElementById('preview-question-en').textContent = selectedOption.getAttribute('data-question-en');
                    document.getElementById('preview-question-ar').textContent = selectedOption.getAttribute('data-question-ar');
                    document.getElementById('preview-answer-en').textContent = selectedOption.getAttribute('data-answer-en');
                    document.getElementById('preview-answer-ar').textContent = selectedOption.getAttribute('data-answer-ar');
                } else {
                    // Hide preview
                    preview.style.display = 'none';
                }
            });
        }
        
        // Reset FAQ preview when modal is closed
        $('.bs-add-service-faq-modal').on('hidden.bs.modal', function() {
            const preview = document.getElementById('faq-preview');
            // Reset Select2
            $('#faq-select').val(null).trigger('change');
            if (preview) {
                preview.style.display = 'none';
            }
        });
        
        // Drag and Drop for Section Ordering
        const sortableSections = document.getElementById('sortable-sections');
        if (sortableSections) {
            let draggedElement = null;
            
            // Add drag event listeners to all rows
            const rows = sortableSections.querySelectorAll('tr[draggable="true"]');
            rows.forEach(row => {
                row.addEventListener('dragstart', function(e) {
                    draggedElement = this;
                    this.style.opacity = '0.5';
                    e.dataTransfer.effectAllowed = 'move';
                });
                
                row.addEventListener('dragend', function(e) {
                    this.style.opacity = '1';
                    
                    // Update order numbers and save
                    updateSectionOrders();
                });
                
                row.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    
                    if (this !== draggedElement) {
                        const rect = this.getBoundingClientRect();
                        const midpoint = rect.top + rect.height / 2;
                        
                        if (e.clientY < midpoint) {
                            this.parentNode.insertBefore(draggedElement, this);
                        } else {
                            this.parentNode.insertBefore(draggedElement, this.nextSibling);
                        }
                    }
                });
            });
            
            function updateSectionOrders() {
                const rows = sortableSections.querySelectorAll('tr[draggable="true"]');
                const orders = [];
                
                rows.forEach((row, index) => {
                    const id = row.getAttribute('data-id');
                    const orderCell = row.querySelector('td:nth-child(2)');
                    orderCell.textContent = index + 1;
                    
                    orders.push({
                        id: id,
                        order: index + 1
                    });
                });
                
                // Save via AJAX
                fetch('{{ route("service-section-order.update-orders") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ orders: orders })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success notification
                        const notificationArea = document.getElementById('notification-area');
                        if (notificationArea) {
                            notificationArea.innerHTML = `
                                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> ${data.message}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            `;
                            
                            // Auto-scroll to notification
                            setTimeout(function() {
                                notificationArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                const alert = notificationArea.querySelector('.alert');
                                alert.style.animation = 'pulse 0.5s ease-in-out';
                            }, 200);
                            
                            // Auto-dismiss after 5 seconds
                            setTimeout(function() {
                                const alerts = notificationArea.querySelectorAll('.alert');
                                alerts.forEach(function(alert) {
                                    alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                                    alert.style.opacity = '0';
                                    alert.style.transform = 'translateY(-20px)';
                                    setTimeout(function() {
                                        alert.remove();
                                    }, 500);
                                });
                            }, 5000);
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });
</script>
@endsection