@extends('admin::layouts.master')
@section('title', 'Offers List')
@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Lightbox2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
<style>
    /* Offer Thumbnail Styles */
    .offer-thumb-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }
    .offer-thumb-img:hover {
        transform: scale(1.1);
        border-color: #19868b;
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
    }
    .no-image-placeholder {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 20px;
    }
    /* Filter Panel Styles */
    .filter-panel {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        display: none;
    }
    .filter-panel.active {
        display: block;
    }
    .filter-toggle-btn {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .filter-toggle-btn:hover {
        opacity: 0.9;
        color: white;
    }
    .filter-panel .form-group {
        margin-bottom: 15px;
    }
    .filter-panel label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
        display: block;
    }
    .filter-panel .form-control, .filter-panel .select2-container .select2-selection--single {
        border-radius: 5px;
        border-color: #ced4da;
    }
    .filter-panel .btn-apply-filters {
        background-color: #19868b;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    .filter-panel .btn-apply-filters:hover {
        background-color: #0d6b6f;
        color: white;
    }
    .filter-panel .btn-reset-filters {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    .filter-panel .btn-reset-filters:hover {
        background-color: #5a6268;
        color: white;
    }
    .active-filters {
        margin-bottom: 20px;
        padding: 10px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }
    .active-filter-tag {
        display: inline-flex;
        align-items: center;
        background-color: #19868b;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        margin-right: 8px;
        margin-bottom: 5px;
        font-size: 13px;
    }
    .active-filter-tag .remove-filter {
        margin-left: 8px;
        cursor: pointer;
        font-weight: bold;
    }
    .offer-code-badge {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: normal;
    }
    /* Category/Subcategory Styles - One word per line */
    .category-cell {
        max-width: 90px;
    }
    .category-text {
        display: inline-block;
        word-spacing: 100vw;
        line-height: 1.5;
        font-weight: 500;
        color: #495057;
        font-size: 13px;
    }
    .pagination-info {
        font-size: 14px;
        color: #6c757d;
        margin-top: 10px;
    }
    /* Custom Pagination Styles */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
        justify-content: center;
    }
    .page-item:first-child .page-link {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #19868b;
        background-color: #fff;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }
    .page-link:hover {
        color: #0d6b6f;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border-color: #19868b;
    }
    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    .page-link i {
        font-size: 1rem;
        vertical-align: middle;
    }
    
    /* Live Search Styles */
    .live-search-container {
        position: relative;
        margin-bottom: 20px;
    }
    .live-search-input-wrapper {
        position: relative;
    }
    .live-search-input-wrapper i.search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #19868b;
        font-size: 18px;
    }
    .live-search-input-wrapper i.clear-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        font-size: 16px;
        cursor: pointer;
        display: none;
    }
    .live-search-input-wrapper i.clear-icon:hover {
        color: #dc3545;
    }
    .live-search-input-wrapper i.clear-icon.show {
        display: block;
    }
    .live-search-input {
        width: 100%;
        padding: 12px 45px;
        font-size: 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .live-search-input:focus {
        border-color: #19868b;
        box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.15);
        outline: none;
    }
    .live-search-input::placeholder {
        color: #adb5bd;
    }
    .live-search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        margin-top: 5px;
    }
    .live-search-results.show {
        display: block;
        animation: fadeInDown 0.2s ease;
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .live-search-item {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
    }
    .live-search-item:last-child {
        border-bottom: none;
    }
    .live-search-item:hover {
        background: #f8f9fa;
        text-decoration: none;
        color: inherit;
    }
    .live-search-item-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 16px;
        flex-shrink: 0;
    }
    .live-search-item-content {
        flex: 1;
        min-width: 0;
    }
    .live-search-item-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .live-search-item-meta {
        font-size: 12px;
        color: #6c757d;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .live-search-item-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .live-search-item-badges {
        display: flex;
        gap: 5px;
        flex-shrink: 0;
    }
    .live-search-no-results {
        padding: 30px 15px;
        text-align: center;
        color: #6c757d;
    }
    .live-search-no-results i {
        font-size: 40px;
        color: #dee2e6;
        margin-bottom: 10px;
        display: block;
    }
    .live-search-loading {
        padding: 20px 15px;
        text-align: center;
        color: #6c757d;
    }
    .live-search-loading i {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .highlight {
        background-color: #fff3cd;
        padding: 1px 2px;
        border-radius: 2px;
    }
    
    /* Bulk Actions Styles */
    .bulk-actions-bar {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }
    .bulk-actions-left {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    .bulk-actions-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .bulk-select-all {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #495057;
    }
    .bulk-select-all input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    .selected-count {
        background: #19868b;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    .bulk-action-dropdown {
        position: relative;
        display: inline-block;
    }
    .bulk-action-dropdown-btn {
        background: #6c757d;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .bulk-action-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        min-width: 200px;
        z-index: 1000;
        display: none;
        margin-top: 5px;
    }
    .bulk-action-dropdown-menu.show {
        display: block;
    }
    .bulk-action-dropdown-menu .dropdown-header {
        padding: 10px 15px;
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        border-bottom: 1px solid #e9ecef;
    }
    .bulk-action-dropdown-menu .dropdown-item {
        padding: 10px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: background 0.2s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-size: 14px;
    }
    .bulk-action-dropdown-menu .dropdown-item:hover {
        background: #f8f9fa;
    }
    .bulk-action-dropdown-menu .dropdown-item i {
        width: 18px;
        text-align: center;
    }
    .bulk-action-dropdown-menu .dropdown-divider {
        height: 1px;
        background: #e9ecef;
        margin: 5px 0;
    }
    .row-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    /* SweetAlert2 Custom Styling */
    .swal2-popup {
        border-radius: 12px;
        padding: 20px;
    }
    .swal2-title {
        color: #2c3e50;
        font-size: 22px;
        font-weight: 600;
    }
    .swal2-html-container {
        color: #495057;
        font-size: 15px;
    }
    .swal2-confirm, .swal2-cancel {
        border-radius: 6px !important;
        padding: 10px 25px !important;
        font-weight: 500 !important;
    }
    .swal2-icon {
        margin: 1em auto 0.5em !important;
    }
</style>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-tag"></i> Offers List</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Success/Error Messages -->
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
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mt-0 header-title align-self-center">
                            Offers List 
                            <span class="badge badge-secondary ml-2">{{ $offers->total() }} Total</span>
                        </h4>
                        <div class="buttons">
                            <button type="button" class="btn filter-toggle-btn mr-2" id="filterToggleBtn">
                                <i class="fa fa-filter"></i> Filters
                            </button>
                            <a href="{{ route('offer.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Offer</button>
                            </a>
                            <a href="{{ route('offer.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Offers</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    
                    <!-- Live Search -->
                    <div class="live-search-container">
                        <div class="live-search-input-wrapper">
                            <i class="fa fa-search search-icon"></i>
                            <input type="text" class="live-search-input" id="liveSearchInput" placeholder="Quick search by Offer Number or Code (e.g., 001, VIL-LUX-001)..." autocomplete="off">
                            <i class="fa fa-times clear-icon" id="clearSearch"></i>
                        </div>
                        <div class="live-search-results" id="liveSearchResults"></div>
                    </div>
                    
                    <!-- Filter Panel -->
                    <div class="filter-panel" id="filterPanel">
                        <form action="{{ route('offer.index') }}" method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-hashtag"></i> Offer ID</label>
                                        <input type="number" class="form-control" name="offer_id" value="{{ request('offer_id') }}" placeholder="Enter ID">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-tag"></i> Offer Number</label>
                                        <input type="text" class="form-control" name="offer_number" value="{{ request('offer_number') }}" placeholder="e.g., 001">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-barcode"></i> Offer Code</label>
                                        <input type="text" class="form-control" name="offer_code" value="{{ request('offer_code') }}" placeholder="e.g., SKU-VIL-LUX">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label><i class="fa fa-font"></i> Title</label>
                                        <input type="text" class="form-control" name="title" value="{{ request('title') }}" placeholder="Search by title...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-folder"></i> Category</label>
                                        <select class="form-control select2" name="category_id" id="filter_category_id">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-folder-open"></i> Subcategory</label>
                                        <select class="form-control select2" name="subcategory_id" id="filter_subcategory_id">
                                            <option value="">All Subcategories</option>
                                            @foreach($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}" {{ request('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                                    {{ $subcategory->title_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-cube"></i> Type</label>
                                        <select class="form-control select2" name="type_id">
                                            <option value="">All Types</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-paint-brush"></i> Style</label>
                                        <select class="form-control select2" name="style_id">
                                            <option value="">All Styles</option>
                                            @foreach($styles as $style)
                                                <option value="{{ $style->id }}" {{ request('style_id') == $style->id ? 'selected' : '' }}>
                                                    {{ $style->title_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-check-circle"></i> Publish Status</label>
                                        <select class="form-control select2" name="publish_status">
                                            <option value="">All Status</option>
                                            <option value="0" {{ request('publish_status') === '0' ? 'selected' : '' }}>Published</option>
                                            <option value="1" {{ request('publish_status') === '1' ? 'selected' : '' }}>Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-eye"></i> Home Status</label>
                                        <select class="form-control select2" name="home_status">
                                            <option value="">All Status</option>
                                            <option value="0" {{ request('home_status') === '0' ? 'selected' : '' }}>Shown on Home</option>
                                            <option value="1" {{ request('home_status') === '1' ? 'selected' : '' }}>Hidden from Home</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-apply-filters mr-2"><i class="fa fa-filter"></i> Apply Filters</button>
                                <a href="{{ route('offer.index') }}" class="btn btn-reset-filters"><i class="fa fa-times"></i> Reset Filters</a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['category_id', 'subcategory_id', 'type_id', 'style_id', 'offer_code', 'offer_number', 'offer_id', 'title', 'publish_status', 'home_status']))
                    <div class="active-filters">
                        <span class="text-muted mr-2"><i class="fa fa-filter"></i> Active Filters:</span>
                        @if(request('offer_id'))
                            <span class="active-filter-tag">
                                ID: {{ request('offer_id') }}
                                <a href="{{ request()->fullUrlWithQuery(['offer_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('offer_number'))
                            <span class="active-filter-tag">
                                Offer #: {{ request('offer_number') }}
                                <a href="{{ request()->fullUrlWithQuery(['offer_number' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('offer_code'))
                            <span class="active-filter-tag">
                                Code: {{ request('offer_code') }}
                                <a href="{{ request()->fullUrlWithQuery(['offer_code' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('title'))
                            <span class="active-filter-tag">
                                Title: {{ request('title') }}
                                <a href="{{ request()->fullUrlWithQuery(['title' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('category_id'))
                            @php $filterCategory = $categories->firstWhere('id', request('category_id')); @endphp
                            @if($filterCategory)
                            <span class="active-filter-tag">
                                Category: {{ $filterCategory->title_english }}
                                <a href="{{ request()->fullUrlWithQuery(['category_id' => null, 'subcategory_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('subcategory_id'))
                            @php $filterSubcategory = $subcategories->firstWhere('id', request('subcategory_id')); @endphp
                            @if($filterSubcategory)
                            <span class="active-filter-tag">
                                Subcategory: {{ $filterSubcategory->title_english }}
                                <a href="{{ request()->fullUrlWithQuery(['subcategory_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('type_id'))
                            @php $filterType = $types->firstWhere('id', request('type_id')); @endphp
                            @if($filterType)
                            <span class="active-filter-tag">
                                Type: {{ $filterType->name_english }}
                                <a href="{{ request()->fullUrlWithQuery(['type_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('style_id'))
                            @php $filterStyle = $styles->firstWhere('id', request('style_id')); @endphp
                            @if($filterStyle)
                            <span class="active-filter-tag">
                                Style: {{ $filterStyle->title_english }}
                                <a href="{{ request()->fullUrlWithQuery(['style_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('publish_status') !== null && request('publish_status') !== '')
                            <span class="active-filter-tag">
                                Publish: {{ request('publish_status') == '0' ? 'Published' : 'Unpublished' }}
                                <a href="{{ request()->fullUrlWithQuery(['publish_status' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('home_status') !== null && request('home_status') !== '')
                            <span class="active-filter-tag">
                                Home: {{ request('home_status') == '0' ? 'Shown' : 'Hidden' }}
                                <a href="{{ request()->fullUrlWithQuery(['home_status' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                    </div>
                    @endif
                    
                    <hr>
                    
                    <!-- Bulk Actions Bar -->
                    <div class="bulk-actions-bar">
                        <div class="bulk-actions-left">
                            <label class="bulk-select-all">
                                <input type="checkbox" id="selectAllCheckbox">
                                <span>Select All</span>
                            </label>
                            <span class="selected-count" id="selectedCount" style="display: none;">
                                <span id="selectedNumber">0</span> selected
                            </span>
                        </div>
                        <div class="bulk-actions-right">
                            <!-- Publish Status Dropdown -->
                            <div class="bulk-action-dropdown">
                                <button type="button" class="bulk-action-dropdown-btn" id="publishDropdownBtn">
                                    <i class="fa fa-globe"></i> Publish Status <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="bulk-action-dropdown-menu" id="publishDropdownMenu">
                                    <div class="dropdown-header">Apply to Selected</div>
                                    <button type="button" class="dropdown-item" onclick="bulkAction('publish', 'selected')">
                                        <i class="fa fa-check-circle text-success"></i> Publish Selected
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="bulkAction('unpublish', 'selected')">
                                        <i class="fa fa-times-circle text-danger"></i> Unpublish Selected
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header">Apply to All Offers</div>
                                    <button type="button" class="dropdown-item" onclick="bulkAction('publish', 'all')">
                                        <i class="fa fa-check-circle text-success"></i> Publish All
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="bulkAction('unpublish', 'all')">
                                        <i class="fa fa-times-circle text-danger"></i> Unpublish All
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Home Status Dropdown -->
                            <div class="bulk-action-dropdown">
                                <button type="button" class="bulk-action-dropdown-btn" id="homeDropdownBtn">
                                    <i class="fa fa-home"></i> Home Status <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="bulk-action-dropdown-menu" id="homeDropdownMenu">
                                    <div class="dropdown-header">Apply to Selected</div>
                                    <button type="button" class="dropdown-item" onclick="bulkHomeAction('show', 'selected')">
                                        <i class="fa fa-eye text-info"></i> Show Selected on Home
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="bulkHomeAction('hide', 'selected')">
                                        <i class="fa fa-eye-slash text-warning"></i> Hide Selected from Home
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header">Apply to All Offers</div>
                                    <button type="button" class="dropdown-item" onclick="bulkHomeAction('show', 'all')">
                                        <i class="fa fa-eye text-info"></i> Show All on Home
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="bulkHomeAction('hide', 'all')">
                                        <i class="fa fa-eye-slash text-warning"></i> Hide All from Home
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Price Status Dropdown -->
                            <div class="bulk-action-dropdown">
                                <button type="button" class="bulk-action-dropdown-btn" id="priceDropdownBtn" style="background: #e83e8c;">
                                    <i class="fa fa-money"></i> Price Status <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="bulk-action-dropdown-menu" id="priceDropdownMenu">
                                    <div class="dropdown-header">Apply to Selected Offers' Prices</div>
                                    <button type="button" class="dropdown-item" onclick="bulkPriceAction('activate', 'selected')">
                                        <i class="fa fa-check-circle text-success"></i> Activate Selected Prices
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="bulkPriceAction('deactivate', 'selected')">
                                        <i class="fa fa-ban text-secondary"></i> Deactivate Selected Prices
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header">Apply to ALL Offers' Prices</div>
                                    <button type="button" class="dropdown-item" onclick="bulkPriceAction('activate', 'all')">
                                        <i class="fa fa-check-circle text-success"></i> Activate All Prices
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="bulkPriceAction('deactivate', 'all')">
                                        <i class="fa fa-ban text-secondary"></i> Deactivate All Prices
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden Forms for Bulk Actions -->
                    <form id="bulkPublishForm" action="{{ route('offer.bulk-publish') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="action" id="bulkPublishAction">
                        <input type="hidden" name="scope" id="bulkPublishScope">
                        <input type="hidden" name="ids" id="bulkPublishIds">
                    </form>
                    
                    <form id="bulkHomeStatusForm" action="{{ route('offer.bulk-home-status') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="action" id="bulkHomeAction">
                        <input type="hidden" name="scope" id="bulkHomeScope">
                        <input type="hidden" name="ids" id="bulkHomeIds">
                    </form>
                    
                    <form id="bulkPriceStatusForm" action="{{ route('offer.bulk-price-status') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="action" id="bulkPriceStatusAction">
                        <input type="hidden" name="scope" id="bulkPriceStatusScope">
                        <input type="hidden" name="ids" id="bulkPriceStatusIds">
                    </form>
                    
                    @if($offers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" id="headerCheckbox" class="row-checkbox" title="Select All on Page">
                                    </th>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th style="min-width: 140px;">Code</th>
                                    <th>Title (English)</th>
                                    <th style="max-width: 90px;">Category</th>
                                    <th style="max-width: 90px;">Sub</th>
                                    <th>Style</th>
                                    <th>Publish Status</th>
                                    <th>Home Status</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offers as $offer)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-checkbox offer-checkbox" value="{{ $offer->id }}" data-id="{{ $offer->id }}">
                                    </td>
                                    <td>{{ $offer->id }}</td>
                                    <td>
                                        @if($offer->main_image)
                                            <a href="{{ url('/storage' . $offer->main_image) }}" data-lightbox="offer-{{ $offer->id }}" data-title="{{ $offer->title_english }}">
                                                <img src="{{ url('/storage' . $offer->main_image) }}" alt="{{ $offer->title_english }}" class="offer-thumb-img">
                                            </a>
                                        @else
                                            <div class="no-image-placeholder">
                                                <i class="fa fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($offer->offer_code)
                                            <span class="badge badge-secondary">{{ $offer->offer_code }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($offer->title_english, 30) }}</td>
                                    <td class="category-cell">
                                        @if($offer->category_name)
                                            <span class="category-text">{{ $offer->category_name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="category-cell">
                                        @if($offer->subcategory_name)
                                            <span class="category-text">{{ $offer->subcategory_name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($offer->style_name)
                                            <span class="badge badge-success">{{ $offer->style_name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($offer->publish_status == 0)
                                            <span class="badge badge-success" title="Published">P</span>
                                        @else
                                            <span class="badge badge-danger" title="Unpublished">U</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($offer->home_status == 0)
                                            <span class="badge badge-success" title="Shown on Home">S</span>
                                        @else
                                            <span class="badge badge-warning" title="Hidden from Home">H</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($offer->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('offer.show', ['id' => $offer->id]) }}" class="btn btn-info btn-sm mr-1" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('offer.edit', ['id' => $offer->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $offer->id }}" title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $offer->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('offer.delete', ['id' => $offer->id]) }}" method="POST">
                                                        @csrf
                                                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                            <br>
                                                            <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                            <br><br><p>You Want to Delete This Offer</p>
                                                            <p><strong>{{ $offer->title_english }}</strong></p>
                                                        </div>
                                                        <br>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="pagination-info">
                            Showing {{ $offers->firstItem() }} to {{ $offers->lastItem() }} of {{ $offers->total() }} offers
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($offers->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo; Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $offers->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($offers->getUrlRange(1, $offers->lastPage()) as $page => $url)
                                    @if ($page == $offers->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($offers->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $offers->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next &raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @else
                    <div class="alert alert-info text-center py-5">
                        <i class="fa fa-info-circle fa-3x mb-3"></i>
                        <h4>No Offers Found</h4>
                        <p class="mb-0">No offers match your current filter criteria. Try adjusting your filters or <a href="{{ route('offer.index') }}">reset all filters</a>.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Lightbox2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    // Configure Lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Image %1 of %2',
        'fadeDuration': 300,
        'imageFadeDuration': 300
    });
</script>
<script>
    // Toggle Filter Panel
    document.getElementById('filterToggleBtn').addEventListener('click', function() {
        document.getElementById('filterPanel').classList.toggle('active');
    });
    
    // Show filter panel if any filters are active
    @if(request()->hasAny(['category_id', 'subcategory_id', 'type_id', 'style_id', 'offer_code', 'offer_number', 'offer_id', 'title', 'publish_status', 'home_status']))
        document.getElementById('filterPanel').classList.add('active');
    @endif
    
    // Dynamic subcategory loading based on category selection
    $('#filter_category_id').on('change', function() {
        const categoryId = $(this).val();
        const subcategorySelect = $('#filter_subcategory_id');
        
        if (!categoryId) {
            subcategorySelect.empty().append('<option value="">All Subcategories</option>').trigger('change');
            return;
        }
        
        subcategorySelect.empty().append('<option value="">Loading...</option>').trigger('change');
        
        fetch(`{{ route('offer.subcategories') }}?category_id=${categoryId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            subcategorySelect.empty().append('<option value="">All Subcategories</option>');
            
            if (data && data.length > 0) {
                data.forEach(subcategory => {
                    const option = new Option(subcategory.title_english, subcategory.id, false, false);
                    subcategorySelect.append(option);
                });
            }
            
            subcategorySelect.trigger('change');
        })
        .catch(error => {
            console.error('Error loading subcategories:', error);
            subcategorySelect.empty().append('<option value="">All Subcategories</option>').trigger('change');
        });
    });
    
    // ===================================
    // Live Search Functionality
    // ===================================
    const liveSearchInput = document.getElementById('liveSearchInput');
    const liveSearchResults = document.getElementById('liveSearchResults');
    const clearSearchBtn = document.getElementById('clearSearch');
    let searchTimeout = null;
    
    // Debounce search input
    liveSearchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Show/hide clear button
        if (query.length > 0) {
            clearSearchBtn.classList.add('show');
        } else {
            clearSearchBtn.classList.remove('show');
            liveSearchResults.classList.remove('show');
            return;
        }
        
        // Clear previous timeout
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        
        // Show loading
        if (query.length >= 1) {
            liveSearchResults.innerHTML = `
                <div class="live-search-loading">
                    <i class="fa fa-spinner"></i> Searching...
                </div>
            `;
            liveSearchResults.classList.add('show');
        }
        
        // Debounce: wait 300ms after user stops typing
        searchTimeout = setTimeout(() => {
            if (query.length >= 1) {
                performLiveSearch(query);
            }
        }, 300);
    });
    
    // Clear search
    clearSearchBtn.addEventListener('click', function() {
        liveSearchInput.value = '';
        liveSearchResults.classList.remove('show');
        this.classList.remove('show');
        liveSearchInput.focus();
    });
    
    // Close results when clicking outside
    document.addEventListener('click', function(e) {
        if (!liveSearchInput.contains(e.target) && !liveSearchResults.contains(e.target)) {
            liveSearchResults.classList.remove('show');
        }
    });
    
    // Show results when focusing on input with existing value
    liveSearchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 1 && liveSearchResults.innerHTML.trim() !== '') {
            liveSearchResults.classList.add('show');
        }
    });
    
    // Perform live search via AJAX
    function performLiveSearch(query) {
        fetch(`{{ route('offer.live-search') }}?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                liveSearchResults.innerHTML = `
                    <div class="live-search-no-results">
                        <i class="fa fa-search"></i>
                        <p class="mb-0">No offers found for "<strong>${escapeHtml(query)}</strong>"</p>
                    </div>
                `;
            } else {
                let html = '';
                data.forEach(offer => {
                    const highlightedCode = highlightMatch(offer.offer_code || '-', query);
                    const highlightedNumber = highlightMatch(offer.offer_number || '-', query);
                    const highlightedTitle = highlightMatch(offer.title_english, query);
                    
                    html += `
                        <a href="{{ url('admin/offer/show') }}/${offer.id}" class="live-search-item">
                            <div class="live-search-item-icon">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="live-search-item-content">
                                <div class="live-search-item-title">${highlightedTitle}</div>
                                <div class="live-search-item-meta">
                                    <span><i class="fa fa-barcode"></i> ${highlightedCode}</span>
                                    <span><i class="fa fa-list-ol"></i> ${highlightedNumber}</span>
                                    ${offer.category_name ? `<span><i class="fa fa-folder"></i> ${escapeHtml(offer.category_name)}</span>` : ''}
                                </div>
                            </div>
                            <div class="live-search-item-badges">
                                ${offer.publish_status == 0 
                                    ? '<span class="badge badge-success" style="font-size: 10px;"><i class="fa fa-check"></i></span>' 
                                    : '<span class="badge badge-danger" style="font-size: 10px;"><i class="fa fa-times"></i></span>'}
                            </div>
                        </a>
                    `;
                });
                liveSearchResults.innerHTML = html;
            }
            liveSearchResults.classList.add('show');
        })
        .catch(error => {
            console.error('Live search error:', error);
            liveSearchResults.innerHTML = `
                <div class="live-search-no-results">
                    <i class="fa fa-exclamation-triangle"></i>
                    <p class="mb-0">Error searching. Please try again.</p>
                </div>
            `;
            liveSearchResults.classList.add('show');
        });
    }
    
    // Highlight matching text
    function highlightMatch(text, query) {
        if (!text || !query) return escapeHtml(text || '');
        const escapedText = escapeHtml(text);
        const escapedQuery = escapeHtml(query);
        const regex = new RegExp(`(${escapedQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        return escapedText.replace(regex, '<span class="highlight">$1</span>');
    }
    
    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Keyboard navigation
    liveSearchInput.addEventListener('keydown', function(e) {
        const items = liveSearchResults.querySelectorAll('.live-search-item');
        const activeItem = liveSearchResults.querySelector('.live-search-item.active');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (!activeItem && items.length > 0) {
                items[0].classList.add('active');
                items[0].style.background = '#e9ecef';
            } else if (activeItem) {
                const nextItem = activeItem.nextElementSibling;
                if (nextItem && nextItem.classList.contains('live-search-item')) {
                    activeItem.classList.remove('active');
                    activeItem.style.background = '';
                    nextItem.classList.add('active');
                    nextItem.style.background = '#e9ecef';
                    nextItem.scrollIntoView({ block: 'nearest' });
                }
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (activeItem) {
                const prevItem = activeItem.previousElementSibling;
                if (prevItem && prevItem.classList.contains('live-search-item')) {
                    activeItem.classList.remove('active');
                    activeItem.style.background = '';
                    prevItem.classList.add('active');
                    prevItem.style.background = '#e9ecef';
                    prevItem.scrollIntoView({ block: 'nearest' });
                }
            }
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (activeItem) {
                window.location.href = activeItem.href;
            }
        } else if (e.key === 'Escape') {
            liveSearchResults.classList.remove('show');
        }
    });
    
    // ===================================
    // Bulk Actions Functionality
    // ===================================
    
    // Dropdown toggles
    document.getElementById('publishDropdownBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('publishDropdownMenu').classList.toggle('show');
        document.getElementById('homeDropdownMenu').classList.remove('show');
        document.getElementById('priceDropdownMenu').classList.remove('show');
    });
    
    document.getElementById('homeDropdownBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('homeDropdownMenu').classList.toggle('show');
        document.getElementById('publishDropdownMenu').classList.remove('show');
        document.getElementById('priceDropdownMenu').classList.remove('show');
    });
    
    document.getElementById('priceDropdownBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('priceDropdownMenu').classList.toggle('show');
        document.getElementById('publishDropdownMenu').classList.remove('show');
        document.getElementById('homeDropdownMenu').classList.remove('show');
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.bulk-action-dropdown')) {
            document.querySelectorAll('.bulk-action-dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
    
    // Select all checkbox (in bulk actions bar)
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const headerCheckbox = document.getElementById('headerCheckbox');
    const offerCheckboxes = document.querySelectorAll('.offer-checkbox');
    const selectedCountEl = document.getElementById('selectedCount');
    const selectedNumberEl = document.getElementById('selectedNumber');
    
    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.offer-checkbox:checked').length;
        selectedNumberEl.textContent = checkedCount;
        
        if (checkedCount > 0) {
            selectedCountEl.style.display = 'inline-block';
        } else {
            selectedCountEl.style.display = 'none';
        }
        
        // Update header checkbox state
        const totalCheckboxes = offerCheckboxes.length;
        if (checkedCount === 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
            if (headerCheckbox) {
                headerCheckbox.checked = false;
                headerCheckbox.indeterminate = false;
            }
        } else if (checkedCount === totalCheckboxes) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
            if (headerCheckbox) {
                headerCheckbox.checked = true;
                headerCheckbox.indeterminate = false;
            }
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
            if (headerCheckbox) {
                headerCheckbox.checked = false;
                headerCheckbox.indeterminate = true;
            }
        }
    }
    
    // Select all in bulk actions bar
    selectAllCheckbox.addEventListener('change', function() {
        offerCheckboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        if (headerCheckbox) {
            headerCheckbox.checked = this.checked;
        }
        updateSelectedCount();
    });
    
    // Select all in table header
    if (headerCheckbox) {
        headerCheckbox.addEventListener('change', function() {
            offerCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            selectAllCheckbox.checked = this.checked;
            updateSelectedCount();
        });
    }
    
    // Individual checkbox change
    offerCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });
    
    // Get selected IDs
    function getSelectedIds() {
        const ids = [];
        document.querySelectorAll('.offer-checkbox:checked').forEach(cb => {
            ids.push(cb.value);
        });
        return ids;
    }
    
    // Bulk publish action with SweetAlert
    function bulkAction(action, scope) {
        const ids = getSelectedIds();
        
        // Close dropdown
        document.querySelectorAll('.bulk-action-dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        
        if (scope === 'selected' && ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one offer.',
                confirmButtonColor: '#19868b'
            });
            return;
        }
        
        const actionText = action === 'publish' ? 'publish' : 'unpublish';
        const actionColor = action === 'publish' ? '#28a745' : '#dc3545';
        const scopeText = scope === 'all' ? 'ALL offers' : `${ids.length} selected offer(s)`;
        
        Swal.fire({
            title: `${action === 'publish' ? 'Publish' : 'Unpublish'} Offers?`,
            html: `
                <div style="text-align: center;">
                    <i class="fa fa-${action === 'publish' ? 'check-circle' : 'times-circle'}" style="font-size: 60px; color: ${actionColor}; margin-bottom: 15px;"></i>
                    <p style="font-size: 16px; margin-bottom: 10px;">You are about to <strong>${actionText}</strong></p>
                    <p style="font-size: 18px; font-weight: 600; color: ${actionColor};">${scopeText}</p>
                    ${scope === 'all' ? '<p style="font-size: 13px; color: #6c757d; margin-top: 10px;"><i class="fa fa-exclamation-triangle"></i> This will affect all offers in the database</p>' : ''}
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: actionColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: `<i class="fa fa-${action === 'publish' ? 'check' : 'times'}"></i> Yes, ${actionText}!`,
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    html: `<p>Updating offer status...</p>`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                document.getElementById('bulkPublishAction').value = action;
                document.getElementById('bulkPublishScope').value = scope;
                document.getElementById('bulkPublishIds').value = JSON.stringify(ids);
                document.getElementById('bulkPublishForm').submit();
            }
        });
    }
    
    // Bulk home status action with SweetAlert
    function bulkHomeAction(action, scope) {
        const ids = getSelectedIds();
        
        // Close dropdown
        document.querySelectorAll('.bulk-action-dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        
        if (scope === 'selected' && ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one offer.',
                confirmButtonColor: '#19868b'
            });
            return;
        }
        
        const actionText = action === 'show' ? 'show on home page' : 'hide from home page';
        const actionIcon = action === 'show' ? 'eye' : 'eye-slash';
        const actionColor = action === 'show' ? '#17a2b8' : '#ffc107';
        const textColor = action === 'show' ? '#17a2b8' : '#856404';
        const scopeText = scope === 'all' ? 'ALL offers' : `${ids.length} selected offer(s)`;
        
        Swal.fire({
            title: `${action === 'show' ? 'Show' : 'Hide'} on Home Page?`,
            html: `
                <div style="text-align: center;">
                    <i class="fa fa-${actionIcon}" style="font-size: 60px; color: ${textColor}; margin-bottom: 15px;"></i>
                    <p style="font-size: 16px; margin-bottom: 10px;">You are about to <strong>${actionText}</strong></p>
                    <p style="font-size: 18px; font-weight: 600; color: ${textColor};">${scopeText}</p>
                    ${scope === 'all' ? '<p style="font-size: 13px; color: #6c757d; margin-top: 10px;"><i class="fa fa-exclamation-triangle"></i> This will affect all offers in the database</p>' : ''}
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: actionColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: `<i class="fa fa-${actionIcon}"></i> Yes, ${action}!`,
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    html: `<p>Updating home status...</p>`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                document.getElementById('bulkHomeAction').value = action;
                document.getElementById('bulkHomeScope').value = scope;
                document.getElementById('bulkHomeIds').value = JSON.stringify(ids);
                document.getElementById('bulkHomeStatusForm').submit();
            }
        });
    }
    
    // Bulk price status action with SweetAlert
    function bulkPriceAction(action, scope) {
        const ids = getSelectedIds();
        
        // Close dropdown
        document.querySelectorAll('.bulk-action-dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        
        if (scope === 'selected' && ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one offer.',
                confirmButtonColor: '#19868b'
            });
            return;
        }
        
        const actionText = action === 'activate' ? 'activate' : 'deactivate';
        const actionIcon = action === 'activate' ? 'check-circle' : 'ban';
        const actionColor = action === 'activate' ? '#28a745' : '#6c757d';
        const scopeText = scope === 'all' ? 'ALL offers' : `${ids.length} selected offer(s)`;
        
        Swal.fire({
            title: `${action === 'activate' ? 'Activate' : 'Deactivate'} Prices?`,
            html: `
                <div style="text-align: center;">
                    <i class="fa fa-${actionIcon}" style="font-size: 60px; color: ${actionColor}; margin-bottom: 15px;"></i>
                    <p style="font-size: 16px; margin-bottom: 10px;">You are about to <strong>${actionText}</strong> all prices for</p>
                    <p style="font-size: 18px; font-weight: 600; color: ${actionColor};">${scopeText}</p>
                    ${scope === 'all' ? '<p style="font-size: 13px; color: #6c757d; margin-top: 10px;"><i class="fa fa-exclamation-triangle"></i> This will affect all offer prices in the database</p>' : ''}
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: actionColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: `<i class="fa fa-${actionIcon}"></i> Yes, ${actionText}!`,
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    html: `<p>Updating price status...</p>`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                document.getElementById('bulkPriceStatusAction').value = action;
                document.getElementById('bulkPriceStatusScope').value = scope;
                document.getElementById('bulkPriceStatusIds').value = JSON.stringify(ids);
                document.getElementById('bulkPriceStatusForm').submit();
            }
        });
    }
    
    // Display success/error messages with SweetAlert2
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#19868b',
            timer: 3000,
            timerProgressBar: true
        });
    @endif
    
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: `<ul style="text-align: left; list-style: none; padding: 0;">
                @foreach($errors->all() as $error)
                    <li style="margin-bottom: 5px;"><i class="fa fa-times-circle text-danger"></i> {{ $error }}</li>
                @endforeach
            </ul>`,
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>
@endsection
