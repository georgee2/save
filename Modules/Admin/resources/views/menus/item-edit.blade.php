@extends('admin::layouts.master')
@section('title', 'Edit Menu Item')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a href="{{route('admin.menu.items', $menu->id)}}" class="breadcrumbs__item"><i class="fa fa-list"></i> {{ $menu->title_english }}</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit Item</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-edit"></i> Edit Menu Item: {{ $item->title_english }}</h4>
                    <hr>
                    
                    <form action="{{ route('admin.menu.item.update', [$menu->id, $item->id]) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title (English) <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('title_english', $item->title_english) }}" type="text" name="title_english" placeholder="Enter item title in English" required>
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Title (Arabic)</label>
                                <input class="form-control" value="{{ old('title_arabic', $item->title_arabic) }}" type="text" name="title_arabic" placeholder="أدخل عنوان العنصر بالعربية" dir="rtl">
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Parent Item</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="">-- No Parent (Root Level) --</option>
                                    @foreach($parentItems as $parentItem)
                                    <option value="{{ $parentItem->id }}" {{ old('parent_id', $item->parent_id) == $parentItem->id ? 'selected' : '' }}>
                                        {{ $parentItem->title_english }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Item Type <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="item_type" id="item_type" required>
                                    @foreach($itemTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('item_type', $item->item_type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Dynamic items automatically pull content from the database</small>
                                @error('item_type')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row" id="link-section">
                            <div class="form-group col-md-6">
                                <label>Route Name</label>
                                <input class="form-control" value="{{ old('route_name', $item->route_name) }}" type="text" name="route_name" placeholder="e.g., services.index">
                                <small class="text-muted">Laravel route name (preferred)</small>
                                @error('route_name')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>URL (if no route)</label>
                                <input class="form-control" value="{{ old('url', $item->url) }}" type="text" name="url" placeholder="e.g., /page or https://example.com">
                                <small class="text-muted">External URL or custom path</small>
                                @error('url')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Ready Options - Quick Links --}}
                        <div class="row" id="ready-options-section">
                            <div class="form-group col-md-12">
                                <label><i class="fa fa-bolt text-warning"></i> Ready Options (Quick Links)</label>
                                <div class="card bg-light">
                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm btn-block text-left" onclick="setReadyOption('index', 'Home', 'fa fa-home')">
                                                    <i class="fa fa-home mr-2"></i> Home Page
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-info btn-sm btn-block text-left" onclick="setReadyOption('about', 'About Us', 'fa fa-info-circle')">
                                                    <i class="fa fa-info-circle mr-2"></i> About Us
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-success btn-sm btn-block text-left" onclick="setReadyOption('contact', 'Contact Us', 'fa fa-envelope')">
                                                    <i class="fa fa-envelope mr-2"></i> Contact Us
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-secondary btn-sm btn-block text-left" onclick="setReadyOption('services.index', 'Services', 'fa fa-cogs')">
                                                    <i class="fa fa-cogs mr-2"></i> Services
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-warning btn-sm btn-block text-left" onclick="setReadyOption('offers.index', 'Offers', 'fa fa-tags')">
                                                    <i class="fa fa-tags mr-2"></i> Offers
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-dark btn-sm btn-block text-left" onclick="setReadyOption('projects.index', 'Projects', 'fa fa-building')">
                                                    <i class="fa fa-building mr-2"></i> Projects
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-info btn-sm btn-block text-left" onclick="setReadyOption('partners.index', 'Partners', 'fa fa-handshake')">
                                                    <i class="fa fa-handshake mr-2"></i> Partners
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm btn-block text-left" onclick="setReadyOption('branches.index', 'Our Branches', 'fa fa-map-marker-alt')">
                                                    <i class="fa fa-map-marker-alt mr-2"></i> Our Branches
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-success btn-sm btn-block text-left" onclick="setReadyOption('team.index', 'Our Team', 'fa fa-users')">
                                                    <i class="fa fa-users mr-2"></i> Our Team
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-block text-left" onclick="setReadyOption('team.board', 'Board of Directors', 'fa fa-user-tie')">
                                                    <i class="fa fa-user-tie mr-2"></i> Board of Directors
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-warning btn-sm btn-block text-left" onclick="setReadyOption('careers.index', 'Careers', 'fa fa-briefcase')">
                                                    <i class="fa fa-briefcase mr-2"></i> Careers
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-secondary btn-sm btn-block text-left" onclick="setReadyOption('blogs.index', 'News / Blog', 'fa fa-newspaper')">
                                                    <i class="fa fa-newspaper mr-2"></i> News / Blog
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-outline-info btn-sm btn-block text-left" onclick="setReadyOption('interior.index', 'Interior Design', 'fa fa-couch')">
                                                    <i class="fa fa-couch mr-2"></i> Interior Design
                                                </button>
                                            </div>
                                        </div>
                                        <small class="text-muted mt-2 d-block"><i class="fa fa-info-circle"></i> Click any button to auto-fill the route and icon (title will only be filled if empty)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" id="link-section-2">
                            <div class="form-group col-md-6">
                                <label>Route Parameters (JSON)</label>
                                <input class="form-control" value="{{ old('route_params', $item->route_params ? json_encode($item->route_params) : '') }}" type="text" name="route_params" placeholder='e.g., {"id": 1}'>
                                <small class="text-muted">Optional parameters for the route</small>
                                @error('route_params')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Link Target <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="link_target" required>
                                    <option value="_self" {{ old('link_target', $item->link_target) == '_self' ? 'selected' : '' }}>Same Window (_self)</option>
                                    <option value="_blank" {{ old('link_target', $item->link_target) == '_blank' ? 'selected' : '' }}>New Window (_blank)</option>
                                </select>
                                @error('link_target')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Icon (Font Awesome class)</label>
                                <input class="form-control" value="{{ old('icon', $item->icon) }}" type="text" name="icon" placeholder="e.g., fa fa-home or fal fa-cog">
                                @error('icon')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Icon Type <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="icon_type" required>
                                    <option value="fontawesome" {{ old('icon_type', $item->icon_type) == 'fontawesome' ? 'selected' : '' }}>Font Awesome</option>
                                    <option value="image" {{ old('icon_type', $item->icon_type) == 'image' ? 'selected' : '' }}>Image Path</option>
                                    <option value="svg" {{ old('icon_type', $item->icon_type) == 'svg' ? 'selected' : '' }}>SVG Code</option>
                                </select>
                                @error('icon_type')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>CSS Class (optional)</label>
                                <input class="form-control" value="{{ old('css_class', $item->css_class) }}" type="text" name="css_class" placeholder="Additional CSS classes">
                                @error('css_class')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row" id="dynamic-section" style="display: none;">
                            <div class="form-group col-md-6">
                                <label>Show Children <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="show_children" required>
                                    <option value="1" {{ old('show_children', $item->show_children) == '1' ? 'selected' : '' }}>Yes - Show sub-items</option>
                                    <option value="0" {{ old('show_children', $item->show_children) == '0' ? 'selected' : '' }}>No - Hide sub-items</option>
                                </select>
                                <small class="text-muted">For dynamic items, show database children</small>
                                @error('show_children')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Max Children (optional)</label>
                                <input class="form-control" value="{{ old('max_children', $item->max_children) }}" type="number" name="max_children" min="1" placeholder="Leave empty for all">
                                <small class="text-muted">Limit number of dynamic children shown</small>
                                @error('max_children')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Services Selection Section --}}
                        <div id="services-section" style="display: none;">
                            <div class="alert alert-success" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
                                <i class="fa fa-lightbulb"></i> <strong>Recommended:</strong> For a dropdown menu showing all services, leave "Select Service" empty and set "Show Children" to Yes. The menu will automatically show all services with their sub-services.
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Select Service (optional)</label>
                                    <select class="form-control select2" name="service_id" id="service_id">
                                        <option value="">-- All Services (Dropdown) --</option>
                                        @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id', $item->service_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->title_english }} {{ $service->title_arabic ? '(' . $service->title_arabic . ')' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select a specific service for a direct link, or leave empty for all services dropdown</small>
                                    @error('service_id')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Quick Links</label>
                                    <div class="btn-group-vertical w-100">
                                        <button type="button" class="btn btn-outline-primary btn-sm text-left" onclick="setServicesIndex()">
                                            <i class="fa fa-list"></i> Use Services Index Page (All Services)
                                        </button>
                                    </div>
                                    <small class="text-muted mt-1 d-block">Click to set route to services index page</small>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Dynamic Query Section --}}
                        <div id="query-section" style="display: none;">
                            <div class="alert alert-info" style="background: #e8f5e9; border-left: 4px solid #4caf50; color: #2e7d32;">
                                <i class="fa fa-database"></i> <strong>Dynamic Query:</strong> Select a data source and choose specific categories or subcategories to filter the results.
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Data Source <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="query_source" id="query_source">
                                        <option value="">-- Select Data Source --</option>
                                        @foreach($querySources as $value => $label)
                                        <option value="{{ $value }}" {{ old('query_source', $item->query_source) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Choose where to pull data from</small>
                                    @error('query_source')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Query Type</label>
                                    <select class="form-control" name="query_type" id="query_type">
                                        <option value="all" {{ old('query_type', $item->query_type ?? 'all') == 'all' ? 'selected' : '' }}>All Items</option>
                                        <option value="category" {{ old('query_type', $item->query_type) == 'category' ? 'selected' : '' }}>Filter by Categories</option>
                                        <option value="subcategory" {{ old('query_type', $item->query_type) == 'subcategory' ? 'selected' : '' }}>Filter by Subcategories</option>
                                    </select>
                                    <small class="text-muted">How to filter the results</small>
                                    @error('query_type')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row" id="category-selection-row" style="display: none;">
                                <div class="form-group col-md-12">
                                    <label>Select Categories</label>
                                    <select class="form-control select2" name="query_category_ids[]" id="query_category_ids" multiple>
                                        @foreach($selectedCategories as $category)
                                        <option value="{{ $category['id'] }}" selected>{{ $category['title_english'] }} ({{ $category['title_arabic'] ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select one or more categories. Leave empty to include all.</small>
                                    @error('query_category_ids')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row" id="subcategory-selection-row" style="display: none;">
                                <div class="form-group col-md-12">
                                    <label>Select Subcategories</label>
                                    <select class="form-control select2" name="query_subcategory_ids[]" id="query_subcategory_ids" multiple>
                                        @foreach($selectedSubcategories as $subcategory)
                                        <option value="{{ $subcategory['id'] }}" selected>{{ $subcategory['title_english'] }} ({{ $subcategory['title_arabic'] ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select one or more subcategories. Available subcategories depend on selected categories.</small>
                                    @error('query_subcategory_ids')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div id="no-subcategory-notice" class="alert alert-warning" style="display: none;">
                                <i class="fa fa-info-circle"></i> Interior Design only supports category filtering (no subcategories available).
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="is_active" required>
                                    <option value="1" {{ old('is_active', $item->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $item->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Visible on Desktop <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="is_visible_desktop" required>
                                    <option value="1" {{ old('is_visible_desktop', $item->is_visible_desktop) == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('is_visible_desktop', $item->is_visible_desktop) == '0' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('is_visible_desktop')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Visible on Mobile <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="is_visible_mobile" required>
                                    <option value="1" {{ old('is_visible_mobile', $item->is_visible_mobile) == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('is_visible_mobile', $item->is_visible_mobile) == '0' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('is_visible_mobile')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Update Item
                            </button>
                            <a href="{{ route('admin.menu.items', $menu->id) }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Store existing selections
    var existingCategoryIds = @json($item->query_category_ids ?? []);
    var existingSubcategoryIds = @json($item->query_subcategory_ids ?? []);
    
    // Initialize Select2
    $('#query_category_ids').select2({
        placeholder: 'Select categories...',
        allowClear: true
    });
    
    $('#query_subcategory_ids').select2({
        placeholder: 'Select subcategories...',
        allowClear: true
    });
    
    $('#service_id').select2({
        placeholder: 'Select a service...',
        allowClear: true
    });
    
    var hasSubcategories = true;
    
    function toggleSections() {
        var itemType = $('#item_type').val();
        var isDynamicServices = itemType === 'dynamic_services';
        var isDynamic = ['dynamic_offers', 'dynamic_projects', 'dynamic_news'].includes(itemType);
        var isDynamicQuery = itemType === 'dynamic_query';
        var isLinkType = ['static'].includes(itemType);
        var isNonLink = ['divider', 'header'].includes(itemType);
        
        // Hide all first
        $('#dynamic-section').hide();
        $('#query-section').hide();
        $('#services-section').hide();
        $('#ready-options-section').hide();
        $('#link-section').hide();
        $('#link-section-2').hide();
        
        if (isDynamicServices) {
            $('#dynamic-section').show();
            $('#services-section').show();
            $('#link-section').show();
            $('#link-section-2').show();
        } else if (isDynamic) {
            $('#dynamic-section').show();
            $('#link-section').show();
            $('#link-section-2').show();
        } else if (isDynamicQuery) {
            $('#dynamic-section').show();
            $('#query-section').show();
            $('#link-section').show();
            $('#link-section-2').show();
        } else if (isNonLink) {
            // Keep hidden
        } else {
            // Static link - show ready options
            $('#ready-options-section').show();
            $('#link-section').show();
            $('#link-section-2').show();
        }
    }
    
    // Set ready option (quick link)
    window.setReadyOption = function(routeName, title, icon) {
        // Set item type to static
        $('#item_type').val('static').trigger('change');
        
        // Set route name
        $('input[name="route_name"]').val(routeName);
        $('input[name="url"]').val('');
        
        // Set title if empty
        if (!$('input[name="title_english"]').val()) {
            $('input[name="title_english"]').val(title);
        }
        
        // Set icon if empty
        if (!$('input[name="icon"]').val()) {
            $('input[name="icon"]').val(icon);
        }
        
        // Show success feedback
        var btn = event.target.closest('button');
        var originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-check mr-2"></i> Applied!';
        btn.classList.remove('btn-outline-primary', 'btn-outline-info', 'btn-outline-success', 'btn-outline-warning', 'btn-outline-danger', 'btn-outline-secondary', 'btn-outline-dark');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalHtml;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 1500);
    };
    
    // Handle service selection change
    $('#service_id').on('change', function() {
        var serviceId = $(this).val();
        if (serviceId) {
            // Specific service selected - recommend hiding children
            $('select[name="show_children"]').val('0');
        } else {
            // No service selected - recommend showing children
            $('select[name="show_children"]').val('1');
        }
    });
    
    // Set services index as route
    window.setServicesIndex = function() {
        $('input[name="route_name"]').val('services.index');
        $('input[name="url"]').val('');
        $('#service_id').val('').trigger('change');
        $('select[name="show_children"]').val('0');
        alert('Route set to services.index - This will link to the Services listing page.');
    };
    
    function toggleQuerySections() {
        var queryType = $('#query_type').val();
        var source = $('#query_source').val();
        
        if (queryType === 'all') {
            $('#category-selection-row').hide();
            $('#subcategory-selection-row').hide();
        } else if (queryType === 'category') {
            $('#category-selection-row').show();
            $('#subcategory-selection-row').hide();
        } else if (queryType === 'subcategory') {
            $('#category-selection-row').show();
            if (hasSubcategories) {
                $('#subcategory-selection-row').show();
            }
        }
        
        // Show notice for interior
        if (source === 'interior') {
            $('#no-subcategory-notice').show();
            $('#subcategory-selection-row').hide();
            // Force category type for interior
            if (queryType === 'subcategory') {
                $('#query_type').val('category').trigger('change');
            }
        } else {
            $('#no-subcategory-notice').hide();
        }
    }
    
    function loadCategories(source, preselectedIds) {
        if (!source) {
            $('#query_category_ids').empty().trigger('change');
            $('#query_subcategory_ids').empty().trigger('change');
            return;
        }
        
        $.ajax({
            url: '{{ route("admin.menu.ajax.categories") }}',
            type: 'GET',
            data: { source: source },
            success: function(response) {
                if (response.success) {
                    var $select = $('#query_category_ids');
                    $select.empty();
                    
                    $.each(response.categories, function(index, category) {
                        var isSelected = preselectedIds && preselectedIds.includes(category.id);
                        $select.append(new Option(category.title_english + ' (' + (category.title_arabic || '-') + ')', category.id, isSelected, isSelected));
                    });
                    
                    $select.trigger('change');
                    
                    hasSubcategories = response.has_subcategories;
                    
                    // Update query type options
                    if (!hasSubcategories) {
                        $('#query_type option[value="subcategory"]').prop('disabled', true);
                    } else {
                        $('#query_type option[value="subcategory"]').prop('disabled', false);
                    }
                    
                    toggleQuerySections();
                    
                    // Load subcategories if needed
                    if (preselectedIds && preselectedIds.length > 0 && hasSubcategories) {
                        loadSubcategories(source, preselectedIds, existingSubcategoryIds);
                    }
                }
            }
        });
    }
    
    function loadSubcategories(source, categoryIds, preselectedIds) {
        if (!source || !categoryIds || categoryIds.length === 0) {
            $('#query_subcategory_ids').empty().trigger('change');
            return;
        }
        
        $.ajax({
            url: '{{ route("admin.menu.ajax.subcategories") }}',
            type: 'GET',
            data: { 
                source: source,
                category_ids: categoryIds
            },
            success: function(response) {
                if (response.success) {
                    var $select = $('#query_subcategory_ids');
                    $select.empty();
                    
                    $.each(response.subcategories, function(index, subcategory) {
                        var isSelected = preselectedIds && preselectedIds.includes(subcategory.id);
                        $select.append(new Option(subcategory.title_english + ' (' + (subcategory.title_arabic || '-') + ')', subcategory.id, isSelected, isSelected));
                    });
                    
                    $select.trigger('change');
                }
            }
        });
    }
    
    // Event handlers
    $('#item_type').on('change', function() {
        toggleSections();
        if ($(this).val() === 'dynamic_query') {
            var source = $('#query_source').val();
            if (source) {
                loadCategories(source, existingCategoryIds);
            }
        }
    });
    
    $('#query_source').on('change', function() {
        var source = $(this).val();
        loadCategories(source, []);
        $('#query_subcategory_ids').empty().trigger('change');
    });
    
    $('#query_type').on('change', function() {
        toggleQuerySections();
    });
    
    $('#query_category_ids').on('change', function() {
        var source = $('#query_source').val();
        var categoryIds = $(this).val();
        var queryType = $('#query_type').val();
        
        if (queryType === 'subcategory' && hasSubcategories) {
            loadSubcategories(source, categoryIds ? categoryIds.map(Number) : [], []);
        }
    });
    
    // Initialize
    toggleSections();
    
    // If it's a dynamic_query type, load the data
    if ($('#item_type').val() === 'dynamic_query') {
        var source = $('#query_source').val();
        if (source) {
            loadCategories(source, existingCategoryIds);
        }
        toggleQuerySections();
    }
});
</script>
@endsection
