@extends('admin::layouts.master')
@section('title', 'Projects List')

@section('css')
<style>
    .filter-toggle-btn {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .filter-toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
        color: white;
    }
    .filter-toggle-btn i {
        transition: transform 0.3s ease;
    }
    .filter-toggle-btn.active i {
        transform: rotate(180deg);
    }
    .filter-panel {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
        display: none;
    }
    .filter-panel.show {
        display: block;
        animation: slideDown 0.3s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .filter-panel .form-group label {
        font-weight: 600;
        color: #495057;
        font-size: 13px;
        margin-bottom: 5px;
    }
    .filter-actions {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }
    .active-filter-tag {
        background: #19868b;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .active-filter-tag .remove-filter {
        cursor: pointer;
        opacity: 0.8;
    }
    .active-filter-tag .remove-filter:hover {
        opacity: 1;
    }
    .project-code-badge {
        font-family: 'Courier New', monospace;
        font-size: 11px;
        padding: 4px 8px;
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border-radius: 4px;
    }
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .pagination-info {
        color: #6c757d;
        font-size: 14px;
    }
    /* Custom Pagination Styling */
    .pagination-wrapper .pagination {
        margin: 0;
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    .pagination-wrapper .pagination .page-item .page-link {
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 14px;
        color: #495057;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover {
        background: #19868b;
        border-color: #19868b;
        color: white;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border-color: #19868b;
        color: white;
        font-weight: 600;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        color: #adb5bd;
        cursor: not-allowed;
    }
    .pagination-wrapper .pagination .page-item .page-link i {
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-building"></i> Projects List</a> 
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
                            Projects List 
                            <span class="badge badge-secondary ml-2">{{ $projects->total() }} Total</span>
                        </h4>
                        <div class="buttons">
                            <button type="button" class="btn filter-toggle-btn mr-2" id="filterToggleBtn">
                                <i class="fa fa-filter"></i> Filters
                            </button>
                            <a href="{{ route('project.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Project</button>
                            </a>
                            <a href="{{ route('project.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Projects</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    
                    <!-- Filter Panel -->
                    <div class="filter-panel" id="filterPanel">
                        <form action="{{ route('project.index') }}" method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-hashtag"></i> Project ID</label>
                                        <input type="number" class="form-control" name="project_id" value="{{ request('project_id') }}" placeholder="Enter ID">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-barcode"></i> Project Code</label>
                                        <input type="text" class="form-control" name="project_code" value="{{ request('project_code') }}" placeholder="e.g., RES-VIL-LUX">
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
                                        <label><i class="fa fa-handshake-o"></i> Partner</label>
                                        <select class="form-control select2" name="partner_id">
                                            <option value="">All Partners</option>
                                            @foreach($partners as $partner)
                                                <option value="{{ $partner->id }}" {{ request('partner_id') == $partner->id ? 'selected' : '' }}>
                                                    {{ $partner->name_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-globe"></i> Publish Status</label>
                                        <select class="form-control" name="publish_status">
                                            <option value="">All Status</option>
                                            <option value="0" {{ request('publish_status') === '0' ? 'selected' : '' }}>Published</option>
                                            <option value="1" {{ request('publish_status') === '1' ? 'selected' : '' }}>Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-home"></i> Home Status</label>
                                        <select class="form-control" name="home_status">
                                            <option value="">All Status</option>
                                            <option value="0" {{ request('home_status') === '0' ? 'selected' : '' }}>Shown on Home</option>
                                            <option value="1" {{ request('home_status') === '1' ? 'selected' : '' }}>Hidden from Home</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="filter-actions">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-search"></i> Apply Filters
                                        </button>
                                        <a href="{{ route('project.index') }}" class="btn btn-secondary">
                                            <i class="fa fa-times"></i> Clear All
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['category_id', 'subcategory_id', 'type_id', 'style_id', 'partner_id', 'project_code', 'project_id', 'title', 'publish_status', 'home_status']))
                    <div class="active-filters">
                        <span class="text-muted mr-2"><i class="fa fa-filter"></i> Active Filters:</span>
                        @if(request('project_id'))
                            <span class="active-filter-tag">
                                ID: {{ request('project_id') }}
                                <a href="{{ request()->fullUrlWithQuery(['project_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('project_code'))
                            <span class="active-filter-tag">
                                Code: {{ request('project_code') }}
                                <a href="{{ request()->fullUrlWithQuery(['project_code' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('title'))
                            <span class="active-filter-tag">
                                Title: {{ request('title') }}
                                <a href="{{ request()->fullUrlWithQuery(['title' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                        @endif
                        @if(request('category_id'))
                            @php $cat = $categories->find(request('category_id')); @endphp
                            @if($cat)
                            <span class="active-filter-tag">
                                Category: {{ $cat->title_english }}
                                <a href="{{ request()->fullUrlWithQuery(['category_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('subcategory_id'))
                            @php $subcat = $subcategories->find(request('subcategory_id')); @endphp
                            @if($subcat)
                            <span class="active-filter-tag">
                                Subcategory: {{ $subcat->title_english }}
                                <a href="{{ request()->fullUrlWithQuery(['subcategory_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('type_id'))
                            @php $type = $types->find(request('type_id')); @endphp
                            @if($type)
                            <span class="active-filter-tag">
                                Type: {{ $type->name_english }}
                                <a href="{{ request()->fullUrlWithQuery(['type_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('style_id'))
                            @php $style = $styles->find(request('style_id')); @endphp
                            @if($style)
                            <span class="active-filter-tag">
                                Style: {{ $style->title_english }}
                                <a href="{{ request()->fullUrlWithQuery(['style_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
                            </span>
                            @endif
                        @endif
                        @if(request('partner_id'))
                            @php $partner = $partners->find(request('partner_id')); @endphp
                            @if($partner)
                            <span class="active-filter-tag">
                                Partner: {{ $partner->name_english }}
                                <a href="{{ request()->fullUrlWithQuery(['partner_id' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a>
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
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Title (English)</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Publish Status</th>
                                    <th>Home Status</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>
                                        @if($project->project_code)
                                            <span class="project-code-badge">{{ $project->project_code }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $project->title_english }}</td>
                                    <td>
                                        @if($project->category_name)
                                            <span class="badge badge-primary">{{ $project->category_name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->type_name)
                                            <span class="badge badge-info">{{ $project->type_name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->publish_status == 0)
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Unpublished</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->home_status == 0)
                                            <span class="badge badge-success"><i class="fa fa-eye"></i> Shown</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Hidden</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($project->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('project.show', ['id' => $project->id]) }}" class="btn btn-info btn-sm" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('project.edit', ['id' => $project->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $project->id }}" title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('project.delete', ['id' => $project->id]) }}" method="POST">
                                                        @csrf
                                                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                            <br>
                                                            <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                            <br><br><p>You Want to Delete This Project</p>
                                                            <p><strong>{{ $project->title_english }}</strong></p>
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
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fa fa-folder-open-o fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No projects found matching your criteria.</p>
                                        <a href="{{ route('project.index') }}" class="btn btn-sm btn-primary">Clear Filters</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($projects->hasPages())
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }} projects
                        </div>
                        <div>
                            {{ $projects->links('admin::pagination.admin') }}
                        </div>
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
    // Filter toggle
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterPanel = document.getElementById('filterPanel');
    
    // Check if there are active filters and show panel
    @if(request()->hasAny(['category_id', 'subcategory_id', 'type_id', 'style_id', 'partner_id', 'project_code', 'project_id', 'title', 'publish_status', 'home_status']))
        filterPanel.classList.add('show');
        filterToggleBtn.classList.add('active');
    @endif
    
    filterToggleBtn.addEventListener('click', function() {
        filterPanel.classList.toggle('show');
        this.classList.toggle('active');
    });
    
    // Dynamic subcategory loading based on category
    $('#filter_category_id').on('change', function() {
        const categoryId = $(this).val();
        const subcategorySelect = $('#filter_subcategory_id');
        
        if (!categoryId) {
            // Reset to show all subcategories
            subcategorySelect.val('').trigger('change');
            return;
        }
        
        // Filter subcategories based on category
        fetch(`{{ route('project.subcategories') }}?category_id=${categoryId}`, {
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
                    subcategorySelect.append(new Option(subcategory.title_english, subcategory.id, false, false));
                });
            }
            
            subcategorySelect.trigger('change');
        })
        .catch(error => {
            console.error('Error loading subcategories:', error);
        });
    });
</script>
@endsection

