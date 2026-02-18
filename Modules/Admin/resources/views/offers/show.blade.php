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
    
    /* Custom Lightbox for Offer Images */
    .custom-lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.85);
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    
    .custom-lightbox.active {
        display: flex;
    }
    
    .custom-lightbox img {
        max-width: 500px;
        max-height: 400px;
        border-radius: 8px;
        border: 3px solid #fff;
        box-shadow: 0 0 30px rgba(0,0,0,0.5);
        cursor: default;
    }
    
    .custom-lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 30px;
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transition: background 0.2s ease;
    }
    
    .custom-lightbox-close:hover {
        background: rgba(255,255,255,0.3);
    }
    
    /* Lightbox2 Customization for Offer Gallery */
    .lightboxOverlay {
        cursor: pointer !important;
        background-color: rgba(0, 0, 0, 0.85) !important;
    }
    .lb-outerContainer {
        background-color: transparent !important;
        border-radius: 8px !important;
    }
    .lb-container {
        padding: 0 !important;
    }
    .lb-image {
        max-width: 500px !important;
        max-height: 400px !important;
        border-radius: 8px !important;
        border: 3px solid #fff !important;
    }
    .lb-dataContainer {
        padding: 10px 0 !important;
    }
    .lb-data .lb-details {
        width: 100% !important;
    }
    .lb-data .lb-caption {
        font-size: 14px !important;
        color: #ccc !important;
    }
    .lb-data .lb-number {
        color: #999 !important;
        font-size: 12px !important;
    }
    .lb-closeContainer .lb-close {
        cursor: pointer !important;
        width: 30px !important;
        height: 30px !important;
        opacity: 0.7 !important;
        transition: opacity 0.2s ease !important;
    }
    .lb-closeContainer .lb-close:hover {
        opacity: 1 !important;
    }
    .lb-nav a.lb-prev,
    .lb-nav a.lb-next {
        opacity: 0.6 !important;
    }
    .lb-nav a.lb-prev:hover,
    .lb-nav a.lb-next:hover {
        opacity: 1 !important;
    }
    
    /* Gallery Preview Thumbnails */
    .gallery-thumbs-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .gallery-thumbs-grid .gallery-thumb-item {
        display: block;
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .gallery-thumbs-grid .gallery-thumb-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    .gallery-thumbs-grid .gallery-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .gallery-thumbs-grid .gallery-thumb-item .thumb-order {
        position: absolute;
        top: 3px;
        left: 3px;
        background: rgba(0,0,0,0.7);
        color: #fff;
        font-size: 10px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 3px;
        z-index: 3;
    }
    .gallery-thumbs-grid .gallery-thumb-item .thumb-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        transition: opacity 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gallery-thumbs-grid .gallery-thumb-item:hover .thumb-overlay {
        opacity: 1;
    }
    .gallery-thumbs-grid .gallery-thumb-item .thumb-overlay i {
        color: white;
        font-size: 18px;
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
                    
                    @if($offer->offer_number)
                    <div class="offer-meta-item">
                        <div class="offer-meta-label">Offer Number</div>
                        <div class="offer-meta-value">
                            <span class="badge badge-info">{{ $offer->offer_number }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($offer->offer_code)
                    <div class="offer-meta-item">
                        <div class="offer-meta-label">Offer Code</div>
                        <div class="offer-meta-value">
                            <span class="badge badge-secondary">{{ $offer->offer_code }}</span>
                        </div>
                    </div>
                    @endif
                    
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
                        <a href="{{ route('offer.edit', ['id' => $offer->id]) }}" class="btn btn-warning btn-block mb-2">
                            <i class="fa fa-pencil"></i> Edit Offer
                        </a>
                        <a href="{{ url('en/offers/' . $offer->slug) }}" target="_blank" class="btn btn-success btn-block" style="background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); border: none;">
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
                        <div class="tab-item" data-tab="floors">
                            <i class="fa fa-layer-group"></i>
                            <span>Floors</span>
                        </div>
                        <div class="tab-item" data-tab="length-components">
                            <i class="fa fa-arrows-h"></i>
                            <span>Length Components</span>
                        </div>
                        <div class="tab-item" data-tab="income-components">
                            <i class="fa fa-dollar"></i>
                            <span>Income Components</span>
                        </div>
                        <div class="tab-item" data-tab="construction-costs">
                            <i class="fa fa-wrench"></i>
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
                                <div class="info-value"><strong>#{{ $offer->id }}</strong></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Offer Number</div>
                                <div class="info-value">
                                    @if($offer->offer_number)
                                        <span class="badge badge-info">{{ $offer->offer_number }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Offer Code</div>
                                <div class="info-value">
                                    @if($offer->offer_code)
                                        <span class="badge badge-secondary">{{ $offer->offer_code }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
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
                                    <div class="image-label">Main Image (903x1146)</div>
                                </div>
                                
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
                                    <div class="image-label">3D Image (903x1146)</div>
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
                        
                        <!-- Floors Tab -->
                        <div class="tab-pane" id="floors">
                            @include('admin::offers.floors._list')
                        </div>
                        
                        <!-- Length Components Tab -->
                        <div class="tab-pane" id="length-components">
                            @include('admin::offers.lengthcomponents._index')
                        </div>
                        
                        <!-- Income Components Tab -->
                        <div class="tab-pane" id="income-components">
                            @include('admin::offers.incomecomponents._index')
                        </div>
                        
                        <!-- Construction Costs Tab -->
                        <div class="tab-pane" id="construction-costs">
                            @include('admin::offers.constructioncosts._index')
                        </div>
                        
                        <!-- Specifications Tab -->
                        <div class="tab-pane" id="specifications">
                            @include('admin::offers.specifications._index')
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
                        
                        <!-- Feasibility Studies Tab -->
                        <div class="tab-pane" id="feasibility-studies">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary mb-0">
                                    <i class="fa fa-chart-line"></i> Feasibility Studies
                                </h5>
                                
                                <!-- Website Visibility Toggle -->
                                <div>
                                    <form action="{{ route('offer.toggle-feasibility-studies', ['id' => $offer->id]) }}" method="POST" style="display:inline;" id="toggleFSForm">
                                        @csrf
                                        @if($offer->show_feasibility_studies == 0)
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
                                <a href="{{ route('offer-feasibility-study.create', ['offerId' => $offer->id]) }}" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Create New Feasibility Study
                                </a>
                                <a href="{{ route('offer-feasibility-study.index') }}" class="btn btn-primary">
                                    <i class="fa fa-list"></i> View All Studies
                                </a>
                            </div>
                            
                            @php
                                use App\Models\OfferFeasibilityStudy;
                                $feasibilityStudies = OfferFeasibilityStudy::getByOffer($offer->id);
                            @endphp
                            
                            @if($feasibilityStudies && $feasibilityStudies->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Study Name</th>
                                                <th>Emirate</th>
                                                <th>Price</th>
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
                                                    <span class="badge badge-info">{{ $study->emirate_name_en }}</span>
                                                </td>
                                                <td>
                                                    <strong class="text-success">{{ number_format($study->emirate_price ?? 0, 2) }}</strong>
                                                </td>
                                                <td>
                                                    @if($study->study_type == 'Master')
                                                        <span class="badge badge-warning"><i class="fa fa-star"></i> Master</span>
                                                    @else
                                                        <span class="badge badge-primary"><i class="fa fa-edit"></i> Custom</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($study->status == 'Active')
                                                        <span class="badge badge-success">Active</span>
                                                    @elseif($study->status == 'Archived')
                                                        <span class="badge badge-secondary">Archived</span>
                                                    @else
                                                        <span class="badge badge-info">Draft</span>
                                                    @endif
                                                </td>
                                                <td>{{ $study->creator_name ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($study->created_at)->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('offer-feasibility-study.show', ['id' => $study->id]) }}" 
                                                           class="btn btn-sm btn-info" title="View Study">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('offer-feasibility-study.edit', ['id' => $study->id]) }}" 
                                                           class="btn btn-sm btn-warning" title="Edit Study">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        @if($study->study_type != 'Master')
                                                        <form action="{{ route('offer-feasibility-study.delete', ['id' => $study->id]) }}" method="POST" style="display:inline;" class="delete-fs-form">
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
                                    <i class="fa fa-info-circle"></i> No feasibility studies created for this offer yet.
                                    <a href="{{ route('offer-feasibility-study.create', ['offerId' => $offer->id]) }}">
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

<!-- Custom Lightbox for Offer Images -->
<div class="custom-lightbox" id="custom-lightbox" onclick="closeLightbox()">
    <span class="custom-lightbox-close" onclick="closeLightbox()">&times;</span>
    <img id="lightbox-img" src="" alt="Preview" onclick="event.stopPropagation()">
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

    // Helper function to reload page while preserving current tab
    function reloadWithTab() {
        const activeTab = document.querySelector('.tab-item.active');
        if (activeTab) {
            const tabId = activeTab.getAttribute('data-tab');
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabId);
            window.location.href = url.toString();
        } else {
            reloadWithTab();
        }
    }
    
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
            
            // Update URL without reload
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabId);
            window.history.replaceState({}, '', url.toString());
        });
    });
    
    // On page load, check for tab parameter and activate that tab
    (function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        if (tabParam) {
            const targetTab = document.querySelector(`.tab-item[data-tab="${tabParam}"]`);
            const targetPane = document.getElementById(tabParam);
            if (targetTab && targetPane) {
                // Remove active from all
                document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
                // Activate target
                targetTab.classList.add('active');
                targetPane.classList.add('active');
            }
        }
    })();
    
    // Custom Lightbox functions
    function openLightbox(imgSrc) {
        document.getElementById('lightbox-img').src = imgSrc;
        document.getElementById('custom-lightbox').classList.add('active');
    }
    
    function closeLightbox() {
        document.getElementById('custom-lightbox').classList.remove('active');
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
    
    // ===================================
    // LENGTH COMPONENTS JAVASCRIPT
    // ===================================
    const lengthOfferId = {{ $offer->id }};
    
    // Initialize Select2 for Length Component dropdowns
    function initLengthSelect2() {
        $('.select2-length-building').select2({
            dropdownParent: $('#addLengthComponentModal'),
            placeholder: "Select Building Component",
            allowClear: true
        });
        $('.select2-length').select2({
            dropdownParent: $('#addLengthComponentModal'),
            placeholder: "Select Length Component",
            allowClear: true
        });
    }
    
    // Open Add Length Component Modal
    function openAddLengthComponentModal() {
        $('#addLengthComponentModal').modal('show');
        loadAvailableBuildingComponents();
    }
    
    // Load available building components (is_length = true)
    function loadAvailableBuildingComponents() {
        $.ajax({
            url: `/admin/offer/${lengthOfferId}/lengthcomponents/available-building-components`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Building Component</option>';
                    response.components.forEach(function(comp) {
                        options += `<option value="${comp.id}">${comp.name_english} - ${comp.name_arabic}</option>`;
                    });
                    $('#building_component_id_add').html(options);
                    initLengthSelect2();
                }
            },
            error: function() {
                alert('Failed to load building components');
            }
        });
    }
    
    // Load length components when building component is selected
    $(document).on('change', '#building_component_id_add', function() {
        const buildingComponentId = $(this).val();
        const lengthSelect = $('#length_component_id_add');
        
        if (buildingComponentId) {
            lengthSelect.prop('disabled', false);
            lengthSelect.html('<option value="">Loading...</option>');
            
            $.ajax({
                url: `/admin/offer/${lengthOfferId}/lengthcomponents/available-length-components`,
                method: 'GET',
                data: { building_component_id: buildingComponentId },
                success: function(response) {
                    if (response.success) {
                        let options = '<option value="">Select Length Component</option>';
                        response.components.forEach(function(comp) {
                            options += `<option value="${comp.id}">${comp.name_english} - ${comp.name_arabic}</option>`;
                        });
                        lengthSelect.html(options);
                    }
                },
                error: function() {
                    alert('Failed to load length components');
                }
            });
        } else {
            lengthSelect.prop('disabled', true);
            lengthSelect.html('<option value="">Select Building Component First</option>');
        }
    });
    
    // Add Length Component Form Submit
    $(document).on('submit', '#addLengthComponentForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/offer/${lengthOfferId}/lengthcomponents/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addLengthComponentModal').modal('hide');
                    $('#addLengthComponentForm')[0].reset();
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to add length component');
            }
        });
    });
    
    // Open Edit Length Modal
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
            url: `/admin/offer/${lengthOfferId}/lengthcomponents/update/${componentId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editLengthComponentModal').modal('hide');
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to update length component');
            }
        });
    });
    
    // Open Delete Length Modal
    function openDeleteLengthModal(id, name) {
        $('#delete_length_component_id').val(id);
        $('#delete_length_component_name').text(name);
        $('#deleteLengthComponentModal').modal('show');
    }
    
    // Confirm Delete Length Component
    function confirmDeleteLengthComponent() {
        const componentId = $('#delete_length_component_id').val();
        
        $.ajax({
            url: `/admin/offer/${lengthOfferId}/lengthcomponents/delete/${componentId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#deleteLengthComponentModal').modal('hide');
                if (response.success) {
                    reloadWithTab();
                }
            },
            error: function() {
                alert('Failed to delete length component');
            }
        });
    }
    
    // Restore Length Component
    function restoreLengthComponent(id) {
        if (confirm('Are you sure you want to restore this length component?')) {
            $.ajax({
                url: `/admin/offer/${lengthOfferId}/lengthcomponents/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        reloadWithTab();
                    }
                },
                error: function() {
                    alert('Failed to restore length component');
                }
            });
        }
    }
    
    // ===================================
    // INCOME COMPONENTS JAVASCRIPT
    // ===================================
    const incomeOfferId = {{ $offer->id }};
    
    // Initialize Select2 for Income Component dropdowns
    function initIncomeSelect2() {
        $('.select2-income').select2({
            dropdownParent: $('#addIncomeComponentModal'),
            placeholder: "Select Income Component",
            allowClear: true
        });
    }
    
    // Open Add Income Component Modal
    function openAddIncomeComponentModal() {
        // Load available components
        $.ajax({
            url: `/admin/offer/${incomeOfferId}/incomecomponents/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Component</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(comp) {
                            options += `<option value="${comp.id}">${comp.name_english} - ${comp.name_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No components available</option>';
                    }
                    $('#income_component_id').html(options);
                    initIncomeSelect2();
                    $('#addIncomeComponentModal').modal('show');
                }
            },
            error: function() {
                alert('Failed to load income components');
            }
        });
    }
    
    // Add Income Component Form Submit
    $(document).on('submit', '#addIncomeComponentForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/offer/${incomeOfferId}/incomecomponents/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addIncomeComponentModal').modal('hide');
                    $('#addIncomeComponentForm')[0].reset();
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to add income component');
            }
        });
    });
    
    // Open Edit Income Component Modal
    function openEditIncomeComponentModal(id, name, units, rent) {
        $('#edit_income_component_id').val(id);
        $('#edit_income_component_name').val(name);
        $('#edit_income_number_of_units').val(units);
        $('#edit_income_rent_per_year').val(rent);
        $('#editIncomeComponentModal').modal('show');
    }
    
    // Edit Income Component Form Submit
    $(document).on('submit', '#editIncomeComponentForm', function(e) {
        e.preventDefault();
        const componentId = $('#edit_income_component_id').val();
        
        $.ajax({
            url: `/admin/offer/${incomeOfferId}/incomecomponents/update/${componentId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editIncomeComponentModal').modal('hide');
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to update income component');
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
            url: `/admin/offer/${incomeOfferId}/incomecomponents/delete/${componentId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#deleteIncomeComponentModal').modal('hide');
                if (response.success) {
                    reloadWithTab();
                }
            },
            error: function() {
                alert('Failed to delete income component');
            }
        });
    }
    
    // Restore Income Component
    function restoreIncomeComponent(id) {
        if (confirm('Are you sure you want to restore this income component?')) {
            $.ajax({
                url: `/admin/offer/${incomeOfferId}/incomecomponents/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        reloadWithTab();
                    }
                },
                error: function() {
                    alert('Failed to restore income component');
                }
            });
        }
    }
    
    // ===================================
    // CONSTRUCTION COSTS JAVASCRIPT
    // ===================================
    const constructionOfferId = {{ $offer->id }};
    
    // Initialize Select2 for Construction Cost dropdowns
    function initConstructionSelect2() {
        $('.select2-construction-fsc').select2({
            dropdownParent: $('#addConstructionCostModal'),
            placeholder: "Select Feasibility Study Component",
            allowClear: true
        });
        $('.select2-construction-substation').select2({
            dropdownParent: $('#addConstructionCostModal'),
            placeholder: "Select Substation Room",
            allowClear: true
        });
        $('.select2-construction-pumps').select2({
            dropdownParent: $('#addConstructionCostModal'),
            placeholder: "Select Pumps Room",
            allowClear: true
        });
    }
    
    function initConstructionEditSelect2() {
        $('.select2-construction-substation-edit').select2({
            dropdownParent: $('#editConstructionCostModal'),
            placeholder: "Select Substation Room",
            allowClear: true
        });
        $('.select2-construction-pumps-edit').select2({
            dropdownParent: $('#editConstructionCostModal'),
            placeholder: "Select Pumps Room",
            allowClear: true
        });
    }
    
    // Open Add Construction Cost Modal
    function openAddConstructionCostModal() {
        // Load feasibility study components
        $.ajax({
            url: `/admin/offer/${constructionOfferId}/constructioncosts/available-feasibility-components`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Component</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(comp) {
                            options += `<option value="${comp.id}">${comp.header_english} - ${comp.title_english}</option>`;
                        });
                    } else {
                        options = '<option value="">No components available</option>';
                    }
                    $('#feasibility_study_component_id_add').html(options);
                }
            }
        });
        
        // Load substation rooms
        $.ajax({
            url: `/admin/offer/${constructionOfferId}/constructioncosts/available-substation-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">None</option>';
                    response.rooms.forEach(function(room) {
                        options += `<option value="${room.id}">${room.name_english} - ${number_format(room.price, 2)}</option>`;
                    });
                    $('#substation_room_id_add').html(options);
                }
            }
        });
        
        // Load pumps rooms
        $.ajax({
            url: `/admin/offer/${constructionOfferId}/constructioncosts/available-pumps-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">None</option>';
                    response.rooms.forEach(function(room) {
                        options += `<option value="${room.id}">${room.name_english} - ${number_format(room.price, 2)}</option>`;
                    });
                    $('#pumps_room_id_add').html(options);
                }
            }
        });
        
        initConstructionSelect2();
        $('#addConstructionCostModal').modal('show');
    }
    
    // Helper function for number formatting
    function number_format(number, decimals) {
        return parseFloat(number).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    // Add Construction Cost Form Submit
    $(document).on('submit', '#addConstructionCostForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/offer/${constructionOfferId}/constructioncosts/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addConstructionCostModal').modal('hide');
                    $('#addConstructionCostForm')[0].reset();
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to add construction cost');
            }
        });
    });
    
    // Open Edit Construction Cost Modal
    function openEditConstructionCostModal(id, substationRoomId, pumpsRoomId) {
        $('#edit_construction_cost_id').val(id);
        
        // Load substation rooms for edit
        $.ajax({
            url: `/admin/offer/${constructionOfferId}/constructioncosts/available-substation-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">None</option>';
                    response.rooms.forEach(function(room) {
                        let selected = substationRoomId == room.id ? 'selected' : '';
                        options += `<option value="${room.id}" ${selected}>${room.name_english} - ${number_format(room.price, 2)}</option>`;
                    });
                    $('#substation_room_id_edit').html(options);
                }
            }
        });
        
        // Load pumps rooms for edit
        $.ajax({
            url: `/admin/offer/${constructionOfferId}/constructioncosts/available-pumps-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">None</option>';
                    response.rooms.forEach(function(room) {
                        let selected = pumpsRoomId == room.id ? 'selected' : '';
                        options += `<option value="${room.id}" ${selected}>${room.name_english} - ${number_format(room.price, 2)}</option>`;
                    });
                    $('#pumps_room_id_edit').html(options);
                }
            }
        });
        
        initConstructionEditSelect2();
        $('#editConstructionCostModal').modal('show');
    }
    
    // Edit Construction Cost Form Submit
    $(document).on('submit', '#editConstructionCostForm', function(e) {
        e.preventDefault();
        const costId = $('#edit_construction_cost_id').val();
        
        $.ajax({
            url: `/admin/offer/${constructionOfferId}/constructioncosts/update/${costId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editConstructionCostModal').modal('hide');
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to update construction cost');
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
            url: `/admin/offer/${constructionOfferId}/constructioncosts/delete/${costId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#deleteConstructionCostModal').modal('hide');
                if (response.success) {
                    reloadWithTab();
                }
            },
            error: function() {
                alert('Failed to delete construction cost');
            }
        });
    }
    
    // Restore Construction Cost
    function restoreConstructionCost(id) {
        if (confirm('Are you sure you want to restore this construction cost?')) {
            $.ajax({
                url: `/admin/offer/${constructionOfferId}/constructioncosts/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        reloadWithTab();
                    }
                },
                error: function() {
                    alert('Failed to restore construction cost');
                }
            });
        }
    }
    
    // ===================================
    // SPECIFICATIONS JAVASCRIPT
    // ===================================
    const specOfferId = {{ $offer->id }};
    
    // Initialize Select2 for Specification dropdowns
    function initSpecificationSelect2() {
        $('.select2-specification').select2({
            dropdownParent: $('#addSpecificationModal'),
            placeholder: "Select Specification",
            allowClear: true
        });
    }
    
    // Open Add Specification Modal
    function openAddSpecificationModal() {
        // Load available specifications
        $.ajax({
            url: `/admin/offer/${specOfferId}/specifications/available`,
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
                    initSpecificationSelect2();
                    $('#addSpecificationModal').modal('show');
                }
            },
            error: function() {
                alert('Failed to load specifications');
            }
        });
    }
    
    // Add Specification Form Submit
    $(document).on('submit', '#addSpecificationForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/offer/${specOfferId}/specifications/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addSpecificationModal').modal('hide');
                    $('#addSpecificationForm')[0].reset();
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to add specification');
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
    $(document).on('submit', '#editSpecificationForm', function(e) {
        e.preventDefault();
        const specificationId = $('#edit_specification_id').val();
        
        $.ajax({
            url: `/admin/offer/${specOfferId}/specifications/update/${specificationId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editSpecificationModal').modal('hide');
                    reloadWithTab();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to update specification');
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
        const specificationId = $('#delete_specification_id').val();
        
        $.ajax({
            url: `/admin/offer/${specOfferId}/specifications/delete/${specificationId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#deleteSpecificationModal').modal('hide');
                if (response.success) {
                    reloadWithTab();
                }
            },
            error: function() {
                alert('Failed to delete specification');
            }
        });
    }
    
    // Restore Specification
    function restoreSpecification(id) {
        if (confirm('Are you sure you want to restore this specification?')) {
            $.ajax({
                url: `/admin/offer/${specOfferId}/specifications/restore/${id}`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        reloadWithTab();
                    }
                },
                error: function() {
                    alert('Failed to restore specification');
                }
            });
        }
    }
    
    // Open Force Delete Specification Modal
    function openForceDeleteSpecificationModal(id, name) {
        $('#force_delete_specification_id').val(id);
        $('#force_delete_specification_name').text(name);
        $('#forceDeleteSpecificationModal').modal('show');
    }
    
    // Confirm Force Delete Specification
    function confirmForceDeleteSpecification() {
        const specId = $('#force_delete_specification_id').val();
        
        $.ajax({
            url: `/admin/offer/${specOfferId}/specifications/force-delete/${specId}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    $('#forceDeleteSpecificationModal').modal('hide');
                    showSpecificationAlert('success', response.message);
                    setTimeout(function() {
                        reloadWithTab();
                    }, 1000);
                } else {
                    showSpecificationAlert('error', response.message);
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to permanently delete specification');
            }
        });
    }
    
    // ===================================
    // Bulk Add Specifications JavaScript
    // ===================================
    
    let availableSpecifications = [];
    let bulkRowCounter = 0;
    
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
    
    // Open Bulk Add Specification Modal
    function openBulkAddSpecificationModal() {
        // Reset
        bulkRowCounter = 0;
        $('#bulkSpecificationsContainer').empty();
        
        // Load available specifications first
        $.ajax({
            url: `/admin/offer/${specOfferId}/specifications/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    availableSpecifications = response.components;
                    
                    if (availableSpecifications.length === 0) {
                        showSpecificationAlert('error', 'No specifications available to add. All specifications have already been added to this offer.');
                        return;
                    }
                    
                    // Add initial rows (3 rows or available count, whichever is smaller)
                    const initialRows = Math.min(3, availableSpecifications.length);
                    for (let i = 0; i < initialRows; i++) {
                        addBulkSpecificationRow();
                    }
                    
                    $('#bulkAddSpecificationModal').modal('show');
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to load specifications');
            }
        });
    }
    
    // Add a new row for bulk specification
    function addBulkSpecificationRow() {
        bulkRowCounter++;
        
        // Build options HTML
        let optionsHtml = '<option value="">Select Specification</option>';
        availableSpecifications.forEach(function(spec) {
            optionsHtml += `<option value="${spec.id}" data-icon="${spec.icon || ''}">${spec.title_english} / ${spec.title_arabic}</option>`;
        });
        
        const rowHtml = `
            <div class="bulk-spec-row card mb-2" data-row="${bulkRowCounter}">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Specification <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm bulk-spec-select" name="spec_${bulkRowCounter}" required onchange="updateBulkRowCount()">
                                    ${optionsHtml}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Value (English) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm bulk-value-en" name="value_en_${bulkRowCounter}" placeholder="English value" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Value (Arabic) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm bulk-value-ar" name="value_ar_${bulkRowCounter}" placeholder="القيمة بالعربية" dir="rtl" required>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger btn-sm mb-2 w-100" onclick="removeBulkSpecificationRow(${bulkRowCounter})">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#bulkSpecificationsContainer').append(rowHtml);
        updateBulkRowCount();
    }
    
    // Remove a bulk specification row
    function removeBulkSpecificationRow(rowNum) {
        $(`.bulk-spec-row[data-row="${rowNum}"]`).fadeOut(200, function() {
            $(this).remove();
            updateBulkRowCount();
        });
    }
    
    // Update the row count display
    function updateBulkRowCount() {
        const validRows = $('.bulk-spec-row').filter(function() {
            return $(this).find('.bulk-spec-select').val() !== '';
        }).length;
        const totalRows = $('.bulk-spec-row').length;
        
        $('#bulkRowCount').text(`${validRows} of ${totalRows} specifications ready`);
        $('#bulkAddSubmitBtn').prop('disabled', validRows === 0);
    }
    
    // Bulk Add Specification Form Submit
    $('#bulkAddSpecificationForm').on('submit', function(e) {
        e.preventDefault();
        
        // Collect all specifications data
        const specifications = [];
        let hasError = false;
        
        $('.bulk-spec-row').each(function() {
            const specId = $(this).find('.bulk-spec-select').val();
            const valueEn = $(this).find('.bulk-value-en').val().trim();
            const valueAr = $(this).find('.bulk-value-ar').val().trim();
            
            if (specId) {
                if (!valueEn || !valueAr) {
                    hasError = true;
                    $(this).find('.card-body').addClass('border-danger');
                    return;
                }
                
                specifications.push({
                    specification_id: specId,
                    value_english: valueEn,
                    value_arabic: valueAr
                });
            }
        });
        
        if (hasError) {
            showSpecificationAlert('error', 'Please fill in all required fields for selected specifications');
            return;
        }
        
        if (specifications.length === 0) {
            showSpecificationAlert('error', 'Please add at least one specification');
            return;
        }
        
        // Check for duplicate specifications in the form
        const specIds = specifications.map(s => s.specification_id);
        const uniqueSpecIds = [...new Set(specIds)];
        if (specIds.length !== uniqueSpecIds.length) {
            showSpecificationAlert('error', 'Duplicate specifications detected. Please select unique specifications.');
            return;
        }
        
        // Disable submit button
        $('#bulkAddSubmitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        
        $.ajax({
            url: `/admin/offer/${specOfferId}/specifications/bulk-store`,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                _token: '{{ csrf_token() }}',
                specifications: specifications
            }),
            success: function(response) {
                if (response.success) {
                    $('#bulkAddSpecificationModal').modal('hide');
                    showSpecificationAlert('success', response.message);
                    setTimeout(function() {
                        reloadWithTab();
                    }, 1000);
                } else {
                    showSpecificationAlert('error', response.message);
                    $('#bulkAddSubmitBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Add All Specifications');
                }
            },
            error: function(xhr) {
                showSpecificationAlert('error', xhr.responseJSON?.message || 'Failed to add specifications');
                $('#bulkAddSubmitBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Add All Specifications');
            }
        });
    });

    // ===================================
    // FEASIBILITY STUDIES JAVASCRIPT
    // ===================================
    
    // Toggle Feasibility Studies Visibility on Website
    function confirmToggleFS(action) {
        const isShowing = action === 'show';
        
        Swal.fire({
            title: isShowing ? 'Show Feasibility Studies?' : 'Hide Feasibility Studies?',
            html: isShowing 
                ? 'All feasibility studies for this offer will be <strong>visible on the website</strong>.' 
                : 'All feasibility studies for this offer will be <strong>hidden from the website</strong>.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isShowing ? '#28a745' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isShowing ? '<i class="fa fa-eye"></i> Yes, Show on Website' : '<i class="fa fa-eye-slash"></i> Yes, Hide from Website',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#toggleFSForm').submit();
            }
        });
    }
    
    // Delete Feasibility Study
    $(document).on('click', '.delete-fs-btn', function(e) {
        e.preventDefault();
        const studyId = $(this).data('study-id');
        const studyName = $(this).data('study-name');
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Delete Feasibility Study?',
            html: `Are you sure you want to delete <strong>${studyName}</strong>?<br><br>This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection

