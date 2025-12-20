@extends('admin::layouts.master')
@section('title', 'Offer Details')

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for SweetAlert2 animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!-- Image Uploader CSS -->
<link rel="stylesheet" href="{{ asset('/css/image-uploader.min.css') }}">
<style>
    .image-uploader {
        min-height: 200px;
    }
    #offer-gallery-count {
        font-size: 0.9rem;
        padding: 0.25rem 0.5rem;
    }
    .offer-show-container {
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
    
    .offer-main-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .offer-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .offer-meta-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .offer-meta-item:last-child {
        border-bottom: none;
    }
    
    .offer-meta-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .offer-meta-value {
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
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('offer.index')}}" class="breadcrumbs__item"><i class="fa fa-tag"></i> Offers</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Offer Details</a>
        </nav>

        <div class="col-12">
            <hr>
            
            <!-- Offer Show Container -->
            <div class="offer-show-container">
                
                <!-- Left Section -->
                <div class="left-section">
                    <img src="{{ asset('storage' . $offer->main_image) }}" alt="{{ $offer->title_english }}" class="offer-main-image" onclick="openLightbox('{{ asset('storage' . $offer->main_image) }}')">
                    
                    <h4 class="offer-title">{{ $offer->title_english }}</h4>
                    <p class="text-muted mb-3">{{ $offer->title_arabic }}</p>
                    
                    <div class="offer-meta-item">
                        <div class="offer-meta-label">Category</div>
                        <div class="offer-meta-value">
                            @if($offer->category_name_en)
                                <span class="badge badge-primary">{{ $offer->category_name_en }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="offer-meta-item">
                        <div class="offer-meta-label">Type</div>
                        <div class="offer-meta-value">
                            @if($offer->type_name_en)
                                <span class="badge badge-info">{{ $offer->type_name_en }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="offer-meta-item">
                        <div class="offer-meta-label">Publish Status</div>
                        <div class="offer-meta-value">
                            @if($offer->publish_status == 0)
                                <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                            @else
                                <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Unpublished</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="offer-meta-item">
                        <div class="offer-meta-label">Home Status</div>
                        <div class="offer-meta-value">
                            @if($offer->home_status == 0)
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
                            <form action="{{ route('offer.toggle-publish', ['id' => $offer->id]) }}" method="POST" class="mb-2" id="publishForm">
                                @csrf
                                @if($offer->publish_status == 0)
                                    <button type="button" class="btn btn-danger btn-block" onclick="confirmPublishToggle('unpublish')">
                                        <i class="fa fa-times-circle"></i> Unpublish Offer
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success btn-block" onclick="confirmPublishToggle('publish')">
                                        <i class="fa fa-check-circle"></i> Publish Offer
                                    </button>
                                @endif
                            </form>
                            
                            <!-- Home Status Toggle -->
                            <form action="{{ route('offer.toggle-home-feature', ['id' => $offer->id]) }}" method="POST" class="mb-2" id="homeForm">
                                @csrf
                                @if($offer->home_status == 0)
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
                        <a href="{{ route('offer.index') }}" class="btn btn-primary btn-block mb-2">
                            <i class="fa fa-list"></i> Back to List
                        </a>
                        <a href="{{ route('offer.edit', ['id' => $offer->id]) }}" class="btn btn-warning btn-block">
                            <i class="fa fa-pencil"></i> Edit Offer
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
                        <div class="tab-item" data-tab="prices">
                            <i class="fa fa-money"></i>
                            <span>Prices by Emirate</span>
                        </div>
                        <div class="tab-item" data-tab="measurements">
                            <i class="fa fa-calculator"></i>
                            <span>Measurements</span>
                        </div>
                        <div class="tab-item" data-tab="images">
                            <i class="fa fa-image"></i>
                            <span>Offers Images</span>
                        </div>
                        <div class="tab-item" data-tab="gallery">
                            <i class="fa fa-th"></i>
                            <span>Gallery</span>
                        </div>
                        <div class="tab-item" data-tab="building-components">
                            <i class="fa fa-cube"></i>
                            <span>Building Components</span>
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
                    </div>
                    
                    <div class="tab-content-area">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane active" id="basic-info">
                            <h5 class="mb-4 text-primary">Basic Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">ID</div>
                                <div class="info-value"><strong>#{{ $offer->id }}</strong></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">English Title</div>
                                <div class="info-value">{{ $offer->title_english }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Arabic Title</div>
                                <div class="info-value">{{ $offer->title_arabic }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Slug</div>
                                <div class="info-value"><code>{{ $offer->slug }}</code></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Category (English)</div>
                                <div class="info-value">
                                    @if($offer->category_name_en)
                                        <span class="badge badge-primary">{{ $offer->category_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Category (Arabic)</div>
                                <div class="info-value">
                                    @if($offer->category_name_ar)
                                        <span class="badge badge-primary">{{ $offer->category_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Subcategory (English)</div>
                                <div class="info-value">
                                    @if($offer->subcategory_name_en)
                                        <span class="badge badge-secondary">{{ $offer->subcategory_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Subcategory (Arabic)</div>
                                <div class="info-value">
                                    @if($offer->subcategory_name_ar)
                                        <span class="badge badge-secondary">{{ $offer->subcategory_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Type (English)</div>
                                <div class="info-value">
                                    @if($offer->type_name_en)
                                        <span class="badge badge-info">{{ $offer->type_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Type (Arabic)</div>
                                <div class="info-value">
                                    @if($offer->type_name_ar)
                                        <span class="badge badge-info">{{ $offer->type_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Style (English)</div>
                                <div class="info-value">
                                    @if($offer->style_name_en)
                                        <span class="badge badge-success">{{ $offer->style_name_en }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Style (Arabic)</div>
                                <div class="info-value">
                                    @if($offer->style_name_ar)
                                        <span class="badge badge-success">{{ $offer->style_name_ar }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Currency</div>
                                <div class="info-value">
                                    @if($offer->currency_name_en && $offer->currency_abbr)
                                        <span class="badge badge-warning">{{ $offer->currency_name_en }} ({{ $offer->currency_abbr }})</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Bio English</div>
                                <div class="info-value">{{ $offer->bio_english ?: 'N/A' }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Bio Arabic</div>
                                <div class="info-value">{{ $offer->bio_arabic ?: 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <!-- Prices by Emirate Tab -->
                        <div class="tab-pane" id="prices">
                            @include('admin::offers.prices._index')
                        </div>
                        
                        <!-- Measurements Tab -->
                        <div class="tab-pane" id="measurements">
                            <h5 class="mb-4 text-primary">Area Measurements</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Square Feet (SQFT)</div>
                                <div class="info-value">
                                    @if($offer->sqft)
                                        <strong>{{ number_format($offer->sqft, 2) }}</strong> sqft
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Square Meters (SQM)</div>
                                <div class="info-value">
                                    @if($offer->sqm)
                                        <strong>{{ number_format($offer->sqm, 2) }}</strong> m²
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($offer->sqft && $offer->sqm)
                            <div class="alert alert-info mt-3">
                                <i class="fa fa-info-circle"></i> <strong>Conversion:</strong> 1 SQFT = 0.092903 SQM
                            </div>
                            @endif
                        </div>
                        
                        <!-- Images Tab -->
                        <div class="tab-pane" id="images">
                            <h5 class="mb-4 text-primary">Offer Images</h5>
                            
                            <div class="image-grid">
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $offer->main_image) }}')">
                                    <img src="{{ asset('storage' . $offer->main_image) }}" alt="Main Image">
                                    <div class="image-label">Main Image (1080x1080)</div>
                                </div>
                                
                                @if($offer->cover_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $offer->cover_image) }}')">
                                    <img src="{{ asset('storage' . $offer->cover_image) }}" alt="Cover Image">
                                    <div class="image-label">Cover Image (1890x420)</div>
                                </div>
                                @endif
                                
                                @if($offer->page_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $offer->page_image) }}')">
                                    <img src="{{ asset('storage' . $offer->page_image) }}" alt="Page Image">
                                    <div class="image-label">Page Image (868x450)</div>
                                </div>
                                @endif
                                
                                @if($offer->site_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $offer->site_image) }}')">
                                    <img src="{{ asset('storage' . $offer->site_image) }}" alt="Site Image">
                                    <div class="image-label">Site Image (420x420)</div>
                                </div>
                                @endif
                                
                                @if($offer->plan_2d_image)
                                <div class="image-grid-item" style="cursor: pointer;" onclick="window.open('{{ asset('storage' . $offer->plan_2d_image) }}', '_blank')">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center;">
                                        <i class="fa fa-file-pdf-o" style="font-size: 48px; margin-bottom: 15px;"></i>
                                        <div style="font-weight: 600; font-size: 16px;">Offer File (PDF)</div>
                                        <div style="font-size: 12px; margin-top: 5px; opacity: 0.9;">Click to view/download</div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($offer->plan_3d_image)
                                <div class="image-grid-item" onclick="openLightbox('{{ asset('storage' . $offer->plan_3d_image) }}')">
                                    <img src="{{ asset('storage' . $offer->plan_3d_image) }}" alt="3D Image">
                                    <div class="image-label">3D Image (870x420)</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Media Tab -->
                        <div class="tab-pane" id="media">
                            <h5 class="mb-4 text-primary">Media URLs</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Video URL</div>
                                <div class="info-value">
                                    @if($offer->video_url)
                                        <a href="{{ $offer->video_url }}" target="_blank" class="btn btn-sm btn-outline-danger">
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
                                    @if($offer->tour_url)
                                        <a href="{{ $offer->tour_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-external-link"></i> View Tour
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Gallery Tab -->
                        <div class="tab-pane" id="gallery">
                            @include('admin::offers.gallery._index')
                        </div>
                        
                        <!-- Building Components Tab -->
                        <div class="tab-pane" id="building-components">
                            @include('admin::offers.buildingcomponents._index')
                        </div>
                        
                        <!-- Descriptions Tab -->
                        <div class="tab-pane" id="descriptions">
                            <h5 class="mb-4 text-primary">Descriptions</h5>
                            
                            <h6 class="text-secondary mt-4 mb-3">English Description</h6>
                            <div class="description-content">
                                @if($offer->description_english)
                                    {!! $offer->description_english !!}
                                @else
                                    <p class="text-muted">No English description available.</p>
                                @endif
                            </div>
                            
                            <hr class="my-4">
                            
                            <h6 class="text-secondary mb-3">Arabic Description</h6>
                            <div class="description-content" dir="rtl">
                                @if($offer->description_arabic)
                                    {!! $offer->description_arabic !!}
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
                                    @if($offer->seo_tags)
                                        <div class="seo-tags">
                                            @foreach(explode(',', $offer->seo_tags) as $tag)
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
                                <div class="info-value">{{ $offer->seo_description_english ?: 'N/A' }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Description (Arabic)</div>
                                <div class="info-value" dir="rtl">{{ $offer->seo_description_arabic ?: 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <!-- Timestamps Tab -->
                        <div class="tab-pane" id="timestamps">
                            <h5 class="mb-4 text-primary">Timestamps</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Created At</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($offer->created_at)->format('F d, Y \a\t h:i A') }}
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($offer->created_at)->diffForHumans() }})</small>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Updated At</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($offer->updated_at)->format('F d, Y \a\t h:i A') }}
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($offer->updated_at)->diffForHumans() }})</small>
                                </div>
                            </div>
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
<!-- Image Uploader JS -->
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
            title: isPublishing ? 'Publish Offer?' : 'Unpublish Offer?',
            text: isPublishing 
                ? 'This offer will be visible to the public.' 
                : 'This offer will be hidden from the public.',
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
                ? 'This offer will be displayed on the home page.' 
                : 'This offer will be removed from the home page.',
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
</script>
@endsection

