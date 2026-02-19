@extends('admin::layouts.master')
@section('title', 'Interior Design Gallery List')
@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        min-width: 220px;
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
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Interior Design Gallery List</a> 
        </nav>

        <div class="col-12 mx-auto">
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
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between mb-3">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            Interior Design Gallery List
                            <span class="badge badge-secondary ml-2">{{ $galleries->total() }} Total</span>
                        </h4>
                        <div class="buttons">
                            <button type="button" class="btn filter-toggle-btn mr-2" id="filterToggleBtn">
                                <i class="fa fa-filter"></i> Filters
                            </button>
                            <a href="{{ route('interior-design-gallery.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Gallery</button>
                            </a>
                            <a href="{{ route('interior-design-gallery.bulk-add') }}" class="mr-2">
                                <button class="btn btn-info"><i class="fa fa-images"></i> Bulk Add</button>
                            </a>
                            <a href="{{ route('interior-design-gallery.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Galleries</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    
                    <!-- Filter Panel -->
                    <div class="filter-panel" id="filterPanel">
                        <form action="{{ route('interior-design-gallery.index') }}" method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fa fa-font"></i> Title</label>
                                        <input type="text" class="form-control" name="title" value="{{ request('title') }}" placeholder="Search by title...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fa fa-folder"></i> Category</label>
                                        <select class="form-control select2" name="category_id">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fa fa-cube"></i> Project Type</label>
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
                            </div>
                            <div class="row">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-map-marker"></i> Emirate</label>
                                        <select class="form-control select2" name="emirate_id">
                                            <option value="">All Emirates</option>
                                            @foreach($emirates as $emirate)
                                                <option value="{{ $emirate->id }}" {{ request('emirate_id') == $emirate->id ? 'selected' : '' }}>
                                                    {{ $emirate->title_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-check-circle"></i> Publish Status</label>
                                        <select class="form-control" name="publish_status">
                                            <option value="">All Status</option>
                                            <option value="0" {{ request('publish_status') === '0' ? 'selected' : '' }}>Published</option>
                                            <option value="1" {{ request('publish_status') === '1' ? 'selected' : '' }}>Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-eye"></i> Home Status</label>
                                        <select class="form-control" name="home_status">
                                            <option value="">All Status</option>
                                            <option value="0" {{ request('home_status') === '0' ? 'selected' : '' }}>Shown on Home</option>
                                            <option value="1" {{ request('home_status') === '1' ? 'selected' : '' }}>Hidden from Home</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-apply-filters mr-2"><i class="fa fa-filter"></i> Apply Filters</button>
                                <a href="{{ route('interior-design-gallery.index') }}" class="btn btn-reset-filters"><i class="fa fa-times"></i> Reset Filters</a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['title', 'category_id', 'type_id', 'style_id', 'emirate_id', 'publish_status', 'home_status']))
                    <div class="active-filters">
                        <span class="text-muted mr-2"><i class="fa fa-filter"></i> Active Filters:</span>
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
                                <a href="{{ request()->fullUrlWithQuery(['category_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
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
                        @if(request('emirate_id'))
                            @php $filterEmirate = $emirates->firstWhere('id', request('emirate_id')); @endphp
                            @if($filterEmirate)
                            <span class="active-filter-tag">
                                Emirate: {{ $filterEmirate->title_english }}
                                <a href="{{ request()->fullUrlWithQuery(['emirate_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
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
                                    <div class="dropdown-header">Apply to All Galleries</div>
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
                                    <div class="dropdown-header">Apply to All Galleries</div>
                                    <button type="button" class="dropdown-item" onclick="bulkHomeAction('show', 'all')">
                                        <i class="fa fa-eye text-info"></i> Show All on Home
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="bulkHomeAction('hide', 'all')">
                                        <i class="fa fa-eye-slash text-warning"></i> Hide All from Home
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden Forms for Bulk Actions -->
                    <form id="bulkPublishForm" action="{{ route('interior-design-gallery.bulk-publish') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="action" id="bulkPublishAction">
                        <input type="hidden" name="scope" id="bulkPublishScope">
                        <input type="hidden" name="ids" id="bulkPublishIds">
                    </form>
                    
                    <form id="bulkHomeStatusForm" action="{{ route('interior-design-gallery.bulk-home-status') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="action" id="bulkHomeAction">
                        <input type="hidden" name="scope" id="bulkHomeScope">
                        <input type="hidden" name="ids" id="bulkHomeIds">
                    </form>
                    
                    @if($galleries->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">
                                            <input type="checkbox" id="headerCheckbox" class="row-checkbox" title="Select All on Page">
                                        </th>
                                        <th>Order</th>
                                        <th>Image</th>
                                        <th>Title (English)</th>
                                        <th>Category</th>
                                        <th>Project Type</th>
                                        <th>Publish</th>
                                        <th>Home</th>
                                        <th>Created At</th>
                                        <th>#Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($galleries as $gallery)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-checkbox gallery-checkbox" value="{{ $gallery->id }}" data-id="{{ $gallery->id }}">
                                    </td>
                                    <td><span class="badge badge-dark">{{ $gallery->ordering }}</span></td>
                                    <td>
                                        @if($gallery->image)
                                            <a data-lightbox="{{url('/storage'.$gallery->image)}}" href="{{url('/storage'.$gallery->image)}}">
                                                <img style="width:100px; height: 56px; object-fit: cover; border-radius: 4px;" src="{{url('/storage'.$gallery->image)}}" alt="Image">
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $gallery->title_english }}</td>
                                    <td><span class="badge badge-primary">{{ $gallery->category_name ?? 'N/A' }}</span></td>
                                    <td><span class="badge badge-info">{{ $gallery->type_name ?? 'N/A' }}</span></td>
                                    <td>
                                        @if($gallery->publish_status == 0)
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Unpublished</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($gallery->home_status == 0)
                                            <span class="badge badge-success"><i class="fa fa-eye"></i> Shown</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Hidden</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($gallery->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('interior-design-gallery.show', ['id' => $gallery->id]) }}" class="btn btn-primary btn-sm mr-1" title="Show">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('interior-design-gallery.edit', ['id' => $gallery->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $gallery->id }}" title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $gallery->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('interior-design-gallery.delete', ['id' => $gallery->id]) }}" method="POST">
                                                        @csrf
                                                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                            <br>
                                                            <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                            <br><br><p>You Want to Delete This Gallery Item</p>
                                                            <p><strong>{{ $gallery->title_english }}</strong></p>
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
                        @if($galleries->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="pagination-info">
                                Showing {{ $galleries->firstItem() }} to {{ $galleries->lastItem() }} of {{ $galleries->total() }} galleries
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($galleries->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">&laquo; Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $galleries->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($galleries->getUrlRange(1, $galleries->lastPage()) as $page => $url)
                                        @if ($page == $galleries->currentPage())
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
                                    @if ($galleries->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $galleries->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next &raquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        @endif
                    @else
                        <div class="alert alert-info text-center py-5">
                            <i class="fa fa-info-circle fa-3x mb-3"></i>
                            <h4>No Galleries Found</h4>
                            <p class="mb-0">No interior design galleries match your current filter criteria. Try adjusting your filters or <a href="{{ route('interior-design-gallery.index') }}">reset all filters</a>.</p>
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
<script>
    // Toggle Filter Panel
    document.getElementById('filterToggleBtn').addEventListener('click', function() {
        document.getElementById('filterPanel').classList.toggle('active');
    });
    
    // Show filter panel if any filters are active
    @if(request()->hasAny(['title', 'category_id', 'type_id', 'style_id', 'emirate_id', 'publish_status', 'home_status']))
        document.getElementById('filterPanel').classList.add('active');
    @endif
    
    // ===================================
    // Bulk Actions Functionality
    // ===================================
    
    // Dropdown toggles
    document.getElementById('publishDropdownBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('publishDropdownMenu').classList.toggle('show');
        document.getElementById('homeDropdownMenu').classList.remove('show');
    });
    
    document.getElementById('homeDropdownBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('homeDropdownMenu').classList.toggle('show');
        document.getElementById('publishDropdownMenu').classList.remove('show');
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
    const galleryCheckboxes = document.querySelectorAll('.gallery-checkbox');
    const selectedCountEl = document.getElementById('selectedCount');
    const selectedNumberEl = document.getElementById('selectedNumber');
    
    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.gallery-checkbox:checked').length;
        selectedNumberEl.textContent = checkedCount;
        
        if (checkedCount > 0) {
            selectedCountEl.style.display = 'inline-block';
        } else {
            selectedCountEl.style.display = 'none';
        }
        
        // Update header checkbox state
        const totalCheckboxes = galleryCheckboxes.length;
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
        galleryCheckboxes.forEach(cb => {
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
            galleryCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            selectAllCheckbox.checked = this.checked;
            updateSelectedCount();
        });
    }
    
    // Individual checkbox change
    galleryCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });
    
    // Get selected IDs
    function getSelectedIds() {
        const ids = [];
        document.querySelectorAll('.gallery-checkbox:checked').forEach(cb => {
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
                text: 'Please select at least one gallery item.',
                confirmButtonColor: '#19868b'
            });
            return;
        }
        
        const actionText = action === 'publish' ? 'publish' : 'unpublish';
        const actionColor = action === 'publish' ? '#28a745' : '#dc3545';
        const scopeText = scope === 'all' ? 'ALL gallery items' : `${ids.length} selected gallery item(s)`;
        
        Swal.fire({
            title: `${action === 'publish' ? 'Publish' : 'Unpublish'} Galleries?`,
            html: `
                <div style="text-align: center;">
                    <i class="fa fa-${action === 'publish' ? 'check-circle' : 'times-circle'}" style="font-size: 60px; color: ${actionColor}; margin-bottom: 15px;"></i>
                    <p style="font-size: 16px; margin-bottom: 10px;">You are about to <strong>${actionText}</strong></p>
                    <p style="font-size: 18px; font-weight: 600; color: ${actionColor};">${scopeText}</p>
                    ${scope === 'all' ? '<p style="font-size: 13px; color: #6c757d; margin-top: 10px;"><i class="fa fa-exclamation-triangle"></i> This will affect all gallery items in the database</p>' : ''}
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
                    html: `<p>Updating gallery status...</p>`,
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
                text: 'Please select at least one gallery item.',
                confirmButtonColor: '#19868b'
            });
            return;
        }
        
        const actionText = action === 'show' ? 'show on home page' : 'hide from home page';
        const actionIcon = action === 'show' ? 'eye' : 'eye-slash';
        const actionColor = action === 'show' ? '#17a2b8' : '#ffc107';
        const textColor = action === 'show' ? '#17a2b8' : '#856404';
        const scopeText = scope === 'all' ? 'ALL gallery items' : `${ids.length} selected gallery item(s)`;
        
        Swal.fire({
            title: `${action === 'show' ? 'Show' : 'Hide'} on Home Page?`,
            html: `
                <div style="text-align: center;">
                    <i class="fa fa-${actionIcon}" style="font-size: 60px; color: ${textColor}; margin-bottom: 15px;"></i>
                    <p style="font-size: 16px; margin-bottom: 10px;">You are about to <strong>${actionText}</strong></p>
                    <p style="font-size: 18px; font-weight: 600; color: ${textColor};">${scopeText}</p>
                    ${scope === 'all' ? '<p style="font-size: 13px; color: #6c757d; margin-top: 10px;"><i class="fa fa-exclamation-triangle"></i> This will affect all gallery items in the database</p>' : ''}
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
