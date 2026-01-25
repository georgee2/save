@extends('admin::layouts.master')
@section('title', 'Offers List')
@section('css')
<style>
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
                    
                    @if($offers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Offer #</th>
                                    <th>Offer Code</th>
                                    <th>Title (English)</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Type</th>
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
                                    <td>{{ $offer->id }}</td>
                                    <td>{{ $offer->offer_number ?: 'N/A' }}</td>
                                    <td>
                                        @if($offer->offer_code)
                                            <span class="badge badge-secondary">{{ $offer->offer_code }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($offer->title_english, 30) }}</td>
                                    <td>
                                        @if($offer->category_name)
                                            <span class="badge badge-primary">{{ $offer->category_name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($offer->subcategory_name)
                                            <span class="badge badge-info">{{ $offer->subcategory_name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($offer->type_name)
                                            <span class="badge badge-info">{{ $offer->type_name }}</span>
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
                                    <td>
                                        @if($offer->publish_status == 0)
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Unpublished</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($offer->home_status == 0)
                                            <span class="badge badge-success"><i class="fa fa-eye"></i> Shown</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Hidden</span>
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
</script>
@endsection
