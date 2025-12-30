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
                    
                    <!-- Filter Panel -->
                    <div class="filter-panel" id="filterPanel">
                        <form action="{{ route('offer.index') }}" method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-hashtag"></i> Offer ID</label>
                                        <input type="number" class="form-control" name="offer_id" value="{{ request('offer_id') }}" placeholder="Enter ID">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-barcode"></i> Offer Code</label>
                                        <input type="text" class="form-control" name="offer_code" value="{{ request('offer_code') }}" placeholder="e.g., SKU-VIL-LUX">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-font"></i> Title</label>
                                        <input type="text" class="form-control" name="title" value="{{ request('title') }}" placeholder="Search by title...">
                                    </div>
                                </div>
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
                            </div>
                            <div class="row">
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
                            </div>
                            <div class="row">
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
                    @if(request()->hasAny(['category_id', 'subcategory_id', 'type_id', 'style_id', 'offer_code', 'offer_id', 'title', 'publish_status', 'home_status']))
                    <div class="active-filters">
                        <span class="text-muted mr-2"><i class="fa fa-filter"></i> Active Filters:</span>
                        @if(request('offer_id'))
                            <span class="active-filter-tag">
                                ID: {{ request('offer_id') }}
                                <a href="{{ request()->fullUrlWithQuery(['offer_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
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
    @if(request()->hasAny(['category_id', 'subcategory_id', 'type_id', 'style_id', 'offer_code', 'offer_id', 'title', 'publish_status', 'home_status']))
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
</script>
@endsection
